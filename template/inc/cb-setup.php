<?php
/**
 * rubberband Theme Setup
 *
 * 기존 rubberband의 rubberband_setup() +
 * CB-00 헤드 링크 제거 / CB-01 Page Excerpt / CB-03 Custom 404 /
 * CB-05 REST API Featured Image / CB-06 로그인 자동완성 비활성화 /
 * CB-07 포스트 조회수 카운트를 통합.
 *
 * @package rubberband
 */

/**
 * 테마 기본 설정
 */
if ( ! function_exists( 'rubberband_setup' ) ) :
	function rubberband_setup() {

		load_theme_textdomain( 'rubberband', get_template_directory() . '/languages' );

		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );

		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		add_theme_support(
			'custom-background',
			apply_filters(
				'rubberband_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		add_theme_support( 'customize-selective-refresh-widgets' );
		add_theme_support( 'align-wide' );
		add_theme_support( 'editor-styles' );

		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'rubberband_setup' );


/**
 * content_width 전역 설정
 */
function rubberband_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'rubberband_content_width', 1200 );
}
add_action( 'after_setup_theme', 'rubberband_content_width', 0 );


/**
 * 위젯 영역 등록
 */
function rubberband_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'rubberband' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'rubberband' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'rubberband_widgets_init' );


/**
 * ── CB-00. 불필요한 헤드 링크 제거 ──────────────────────────────────────────
 * RSD, WLW Manifest 링크는 보안상 노출 불필요.
 */
function rubberband_remove_head_links() {
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
}
add_action( 'init', 'rubberband_remove_head_links' );


/**
 * ── CB-01. Page Excerpt 지원 ─────────────────────────────────────────────────
 * WP 기본은 post 타입에만 excerpt 제공. page 타입에도 활성화.
 */
function rubberband_add_excerpt_support_for_pages() {
	add_post_type_support( 'page', 'excerpt' );
}
add_action( 'init', 'rubberband_add_excerpt_support_for_pages' );

function rubberband_excerpt_length( $length ) {
	if ( is_admin() ) {
		return $length;
	}
	return 30;
}
add_filter( 'excerpt_length', 'rubberband_excerpt_length' );

function rubberband_excerpt_more( $more ) {
	if ( is_admin() ) {
		return $more;
	}
	return '&hellip;';
}
add_filter( 'excerpt_more', 'rubberband_excerpt_more' );


/**
 * ── CB-03. Custom 404 Error Handler ─────────────────────────────────────────
 */
add_filter( 'wp_die_handler', 'rubberband_get_custom_die_handler' );

function rubberband_get_custom_die_handler() {
	return 'rubberband_custom_die_handler';
}

function rubberband_custom_die_handler( $message, $title = '', $args = array() ) {
	require_once get_stylesheet_directory() . '/404.php';
}


/**
 * ── CB-05. REST API에 Featured Image URL 추가 ────────────────────────────────
 */
function rubberband_post_featured_image_json( $data, $post, $context ) {
	$featured_image_id  = $data->data['featured_media'];
	$featured_image_url = wp_get_attachment_image_src( $featured_image_id, 'medium' );

	if ( $featured_image_url ) {
		$data->data['featured_image_url'] = $featured_image_url[0];
	}

	return $data;
}
add_filter( 'rest_prepare_post', 'rubberband_post_featured_image_json', 10, 3 );


/**
 * ── CB-06. 로그인 비밀번호 자동완성 비활성화 ────────────────────────────────
 */
function rubberband_login_form_autocomplete() {
	echo '<script>document.getElementById("user_pass").autocomplete="off";</script>';
}
add_action( 'login_form', 'rubberband_login_form_autocomplete' );


/**
 * ── CB-07. 포스트 조회수 카운트 ──────────────────────────────────────────────
 *
 * 사용 예시:
 *   echo getPostViews( get_the_ID() );  // 조회수 출력
 *   setPostViews( get_the_ID() );       // 조회수 증가 (single.php 등에서 호출)
 */
function rubberband_get_post_views( $post_id ) {
	$count = get_post_meta( $post_id, 'post_views_count', true );
	if ( '' === $count ) {
		delete_post_meta( $post_id, 'post_views_count' );
		add_post_meta( $post_id, 'post_views_count', '0' );
		return '0';
	}
	return $count;
}

function rubberband_set_post_views( $post_id ) {
	$count = get_post_meta( $post_id, 'post_views_count', true );
	if ( '' === $count ) {
		delete_post_meta( $post_id, 'post_views_count' );
		add_post_meta( $post_id, 'post_views_count', '0' );
	} else {
		update_post_meta( $post_id, 'post_views_count', (int) $count + 1 );
	}
}
