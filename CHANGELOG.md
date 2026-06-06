# Changelog

## [1.0.0] - 2026-06-06

### 개편
- 기존 rubberband (2022) 기반으로 패키지 구조 전면 재구성
- `functions.php` 내 인라인 코드를 `cb-` 파일로 분리
- `generator/generate.sh` 테마 자동 생성 스크립트 추가

### cb- 파일 구성
- `cb-setup.php` : 테마 설정 + CB-00 헤드링크 제거 + CB-01 Page Excerpt
  + CB-03 Custom 404 + CB-05 REST API FI + CB-06 로그인 자동완성 + CB-07 조회수
- `cb-enqueue.php` : 스크립트·스타일 등록 (creativeband.js 포함)
- `cb-menus.php` : 네비게이션 4종 (primary / utility / footer / category-nav)
- `cb-archive.php` : 아카이브 타이틀 접두어 제거 (CB-02)
- `cb-pagination.php` : 페이지네이션 (CB-04) + 포스트 이전/다음
- `cb-dashboard.php` : 관리자 대시보드 위젯 2종 신규 추가

### template-parts 구조 변경
- `template-parts/page/content.php` 신규 추가
- 기존 `content.php`, `content-none.php`, `content-page.php`, `content-search.php` 유지 (_s 호환)
- 기존 `common/`, `archive/`, `single/` 구조 유지

### 생성기
- `generator/generate.sh` : 프로젝트명/슬러그 입력 → 테마 폴더 자동 생성
- 생성 시 `CLAUDE.md` 자동 포함
