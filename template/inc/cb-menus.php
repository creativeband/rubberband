<?php
/**
 * rubberband Navigation Menus
 *
 * primary      : 주 네비게이션 (헤더)
 * utility      : 유틸리티 라인 (헤더 상단 - SNS, 언어, 연락처 등)
 * footer       : 푸터 네비게이션
 * category-nav : 카테고리/섹션 탭 네비게이션
 *
 * @package rubberband
 */

function rubberband_register_menus() {
	register_nav_menus(
		array(
			'primary'      => esc_html__( '주 네비게이션', 'rubberband' ),
			'utility'      => esc_html__( '유틸리티 라인', 'rubberband' ),
			'footer'       => esc_html__( '푸터 네비게이션', 'rubberband' ),
			'category-nav' => esc_html__( '카테고리 네비게이션', 'rubberband' ),
		)
	);
}
add_action( 'init', 'rubberband_register_menus' );
