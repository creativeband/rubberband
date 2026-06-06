<?php
/**
 * rubberband Dashboard Widgets
 *
 * 관리자 대시보드에 두 개의 위젯 추가.
 *
 * 1. cb_theme_info_widget   : 크리에이티브밴드 제작 정보 + 유지관리 안내 링크
 * 2. cb_recent_posts_widget : 최신 아티클 5개
 *
 * 유지관리 URL은 외모 > 커스터마이저 > 'cb_support_url' 항목에서 변경 가능.
 *
 * @package rubberband
 */

function rubberband_add_dashboard_widgets() {
	wp_add_dashboard_widget(
		'cb_theme_info_widget',
		__( '이 사이트 제작 및 유지관리', 'rubberband' ),
		'rubberband_theme_info_widget_content'
	);

	wp_add_dashboard_widget(
		'cb_recent_posts_widget',
		__( '최신 아티클', 'rubberband' ),
		'rubberband_recent_posts_widget_content'
	);
}
add_action( 'wp_dashboard_setup', 'rubberband_add_dashboard_widgets' );


/**
 * 위젯 1: 크리에이티브밴드 제작 정보 + 유지관리 링크
 */
function rubberband_theme_info_widget_content() {

	$support_url = get_theme_mod( 'cb_support_url', 'https://creative-band.com/support/' );
	$theme       = wp_get_theme();
	?>
	<div style="line-height:1.8;">
		<p>
			<strong><?php echo esc_html( $theme->get( 'Name' ) ); ?></strong>
			<?php if ( $theme->get( 'Version' ) ) : ?>
				<span style="color:#999; font-size:12px;">v<?php echo esc_html( $theme->get( 'Version' ) ); ?></span>
			<?php endif; ?>
		</p>
		<p style="color:#555; font-size:13px;">
			<?php esc_html_e( '이 웹사이트는 워드프레스 전문 에이전시 크리에이티브밴드가 기획·제작·운영하고 있습니다.', 'rubberband' ); ?>
		</p>
		<hr style="border:none; border-top:1px solid #eee; margin:10px 0;">
		<p>
			<a href="<?php echo esc_url( $support_url ); ?>" target="_blank" rel="noopener noreferrer"
				style="display:inline-block; padding:6px 14px; background:#1e1e2e; color:#fff; border-radius:4px; text-decoration:none; font-size:13px;">
				<?php esc_html_e( '유지관리 및 운영 안내', 'rubberband' ); ?>
			</a>
			<a href="https://creative-band.com" target="_blank" rel="noopener noreferrer"
				style="margin-left:10px; font-size:13px; color:#555; text-decoration:none;">
				creative-band.com
			</a>
		</p>
		<p style="font-size:12px; color:#aaa; margin-top:6px;">
			<?php
			printf(
				/* translators: %s: 이메일 주소 */
				esc_html__( '문의: %s', 'rubberband' ),
				'<a href="mailto:hello@creative-band.com" style="color:#aaa;">hello@creative-band.com</a>'
			);
			?>
		</p>
	</div>
	<?php
}


/**
 * 위젯 2: 최신 아티클 5개
 */
function rubberband_recent_posts_widget_content() {

	$recent_posts = new WP_Query(
		array(
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'posts_per_page' => 5,
			'no_found_rows'  => true,
		)
	);

	if ( $recent_posts->have_posts() ) :
		echo '<ul style="margin:0; padding:0; list-style:none;">';

		while ( $recent_posts->have_posts() ) :
			$recent_posts->the_post();
			?>
			<li style="padding:7px 0; border-bottom:1px solid #f0f0f0;">
				<a href="<?php the_permalink(); ?>" style="font-size:13px; text-decoration:none; color:#1d2327; display:block;">
					<?php the_title(); ?>
				</a>
				<span style="font-size:11px; color:#aaa;">
					<?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?>
					<?php
					$cats = get_the_category();
					if ( $cats ) {
						echo ' &middot; ' . esc_html( $cats[0]->name );
					}
					?>
				</span>
			</li>
			<?php
		endwhile;

		echo '</ul>';
		wp_reset_postdata();

		echo '<p style="margin-top:10px; text-align:right;">';
		printf(
			'<a href="%s" style="font-size:12px; color:#555; text-decoration:none;">%s &rarr;</a>',
			esc_url( admin_url( 'edit.php' ) ),
			esc_html__( '전체 글 보기', 'rubberband' )
		);
		echo '</p>';

	else :
		echo '<p style="color:#aaa; font-size:13px;">' . esc_html__( '아직 발행된 글이 없습니다.', 'rubberband' ) . '</p>';
	endif;
}
