#!/usr/bin/env bash
# ==============================================================================
# rubberband Theme Generator
# by Creative Band (https://creative-band.com)
#
# 사용법:
#   git clone https://github.com/creativeband/rubberband.git
#   cd rubberband
#   bash generator/generate.sh
# ==============================================================================

set -e

GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
RESET='\033[0m'

info()    { echo -e "${GREEN}[rubberband]${RESET} $1"; }
warning() { echo -e "${YELLOW}[경고]${RESET} $1"; }
error()   { echo -e "${RED}[오류]${RESET} $1"; exit 1; }

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
TEMPLATE_DIR="$SCRIPT_DIR/../template"
DEFAULT_WP_PATH="/Applications/MAMP/htdocs"

echo ""
echo "========================================"
echo "  rubberband Theme Generator"
echo "  by Creative Band"
echo "========================================"
echo ""

# ── 입력 ──────────────────────────────────────────────────────────────────────

read -p "프로젝트 이름 (예: 헤어온의원): " PROJECT_NAME
[ -z "$PROJECT_NAME" ] && error "프로젝트 이름을 입력해주세요."

read -p "테마 슬러그 (영문 소문자·하이픈만, 예: hairon): " THEME_SLUG
[ -z "$THEME_SLUG" ] && error "테마 슬러그를 입력해주세요."
[[ ! "$THEME_SLUG" =~ ^[a-z0-9\-]+$ ]] && error "슬러그는 영문 소문자, 숫자, 하이픈(-)만 사용할 수 있습니다."

read -p "제작자 이름 [크리에이티브밴드]: " AUTHOR_NAME
AUTHOR_NAME="${AUTHOR_NAME:-크리에이티브밴드}"

read -p "제작자 URL [https://creative-band.com]: " AUTHOR_URL
AUTHOR_URL="${AUTHOR_URL:-https://creative-band.com}"

read -p "워드프레스 설치 경로 [$DEFAULT_WP_PATH]: " WP_PATH
WP_PATH="${WP_PATH:-$DEFAULT_WP_PATH}"

# ── 치환 변수 ─────────────────────────────────────────────────────────────────
# _s 공식 컨벤션 5종
FUNC_PREFIX="${THEME_SLUG//-/_}"                          # rubberband_ → slug_
CONST_PREFIX="${FUNC_PREFIX^^}"                           # RUBBERBAND_ → SLUG_
DISPLAY_NAME=$(echo "$THEME_SLUG" | sed 's/-/ /g' \
  | awk '{for(i=1;i<=NF;i++) $i=toupper(substr($i,1,1)) tolower(substr($i,2)); print}')

OUTPUT_DIR="$WP_PATH/$THEME_SLUG/wp-content/themes/$THEME_SLUG"

echo ""
info "생성 정보 확인"
echo "  프로젝트명  : $PROJECT_NAME"
echo "  테마 슬러그 : $THEME_SLUG"
echo "  함수 접두사 : ${FUNC_PREFIX}_"
echo "  상수 접두사 : ${CONST_PREFIX}_"
echo "  제작자      : $AUTHOR_NAME ($AUTHOR_URL)"
echo "  출력 경로   : $OUTPUT_DIR"
echo ""

read -p "계속 진행할까요? (y/N): " CONFIRM
[[ "$CONFIRM" =~ ^[Yy]$ ]] || { echo "취소되었습니다."; exit 0; }

# ── 출력 폴더 ─────────────────────────────────────────────────────────────────

if [ -d "$OUTPUT_DIR" ]; then
  warning "이미 존재하는 경로: $OUTPUT_DIR"
  read -p "덮어쓸까요? (y/N): " OVERWRITE
  [[ "$OVERWRITE" =~ ^[Yy]$ ]] || { echo "취소되었습니다."; exit 0; }
  rm -rf "$OUTPUT_DIR"
fi

mkdir -p "$OUTPUT_DIR"

# ── 파일 복사 ─────────────────────────────────────────────────────────────────

info "파일 복사 중..."
rsync -a \
  --exclude='.DS_Store' \
  --exclude='.git/' \
  --exclude='generator/' \
  --exclude='README.md' \
  --exclude='CHANGELOG.md' \
  --exclude='.gitignore' \
  "$TEMPLATE_DIR/" "$OUTPUT_DIR/"

# ── 슬러그 치환 ───────────────────────────────────────────────────────────────

info "슬러그 치환 중..."

replace_in_file() {
  local FILE="$1"
  if [[ "$OSTYPE" == "darwin"* ]]; then
    # macOS BSD sed
    sed -i '' "s/rubberband_/${FUNC_PREFIX}_/g"      "$FILE"
    sed -i '' "s/'rubberband'/'${THEME_SLUG}'/g"     "$FILE"
    sed -i '' "s/rubberband-/${THEME_SLUG}-/g"       "$FILE"
    sed -i '' "s/RUBBERBAND_/${CONST_PREFIX}_/g"     "$FILE"
    sed -i '' "s/Rubberband/${DISPLAY_NAME}/g"       "$FILE"
    sed -i '' "s/rubberband/${THEME_SLUG}/g"         "$FILE"
  else
    # Linux GNU sed
    sed -i "s/rubberband_/${FUNC_PREFIX}_/g"         "$FILE"
    sed -i "s/'rubberband'/'${THEME_SLUG}'/g"        "$FILE"
    sed -i "s/rubberband-/${THEME_SLUG}-/g"          "$FILE"
    sed -i "s/RUBBERBAND_/${CONST_PREFIX}_/g"        "$FILE"
    sed -i "s/Rubberband/${DISPLAY_NAME}/g"          "$FILE"
    sed -i "s/rubberband/${THEME_SLUG}/g"            "$FILE"
  fi
}

find "$OUTPUT_DIR" -type f \( \
  -name "*.php" -o \
  -name "*.css" -o \
  -name "*.js"  -o \
  -name "*.pot" -o \
  -name "*.json" \
\) | while read -r FILE; do
  replace_in_file "$FILE"
done

# ── style.css 헤더 ────────────────────────────────────────────────────────────

info "style.css 헤더 작성 중..."
CURRENT_YEAR=$(date +%Y)

# 기존 CSS 본문 보존 (헤더 주석 이후부터)
CSS_BODY=$(awk '/^\*\//{found=1; next} found{print}' "$OUTPUT_DIR/style.css")

cat > "$OUTPUT_DIR/style.css" << STYLECSS
/*!
Theme Name:  ${PROJECT_NAME}
Theme URI:   ${AUTHOR_URL}
Author:      ${AUTHOR_NAME}
Author URI:  ${AUTHOR_URL}
Description: ${PROJECT_NAME} WordPress Theme
Version:     1.0.0
Requires at least: 6.0
Tested up to: 6.7
Requires PHP: 8.0
License:     GNU General Public License v2 or later
License URI: LICENSE
Text Domain: ${THEME_SLUG}
Tags:        custom-background, custom-logo, custom-menu, featured-images, threaded-comments, translation-ready

This theme, like WordPress, is licensed under the GPL.
rubberband is based on Underscores https://underscores.me/, (C) 2012-${CURRENT_YEAR} Automattic, Inc.
Generated by rubberband / Creative Band (${AUTHOR_URL})
*/

STYLECSS

echo "$CSS_BODY" >> "$OUTPUT_DIR/style.css"

# ── CLAUDE.md ─────────────────────────────────────────────────────────────────

info "CLAUDE.md 생성 중..."

cat > "$OUTPUT_DIR/CLAUDE.md" << CLAUDEMD
# ${PROJECT_NAME}

## 프로젝트 개요
- **테마 슬러그**: ${THEME_SLUG}
- **제작사**: ${AUTHOR_NAME} (${AUTHOR_URL})
- **기반**: rubberband starter (Underscores / _s)
- **생성일**: $(date +%Y-%m-%d)

## 개발 환경
- **로컬 URL**: http://localhost:8888/${THEME_SLUG}/
- **테마 경로**: ${WP_PATH}/${THEME_SLUG}/wp-content/themes/${THEME_SLUG}/
- **PHP**: 8.2 / **WordPress**: 6.x

## 코딩 규칙 (WordPress Coding Standards)
- 들여쓰기: **탭** (스페이스 금지)
- 함수·변수 접두사: \`${FUNC_PREFIX}_\`
- 텍스트 도메인: \`${THEME_SLUG}\`
- 상수 접두사: \`${CONST_PREFIX}_\`
- 하드코딩 URL 금지 → \`home_url()\`, \`get_template_directory_uri()\` 사용
- 직접 DB 쿼리 금지 → \`WP_Query\`, \`get_posts()\` 사용
- 이미지 출력 → \`wp_get_attachment_image()\` 사용

## 파일 구조
\`\`\`
${THEME_SLUG}/
├── functions.php                ← require 진입점만
├── inc/
│   ├── template-tags.php        ← _s 원본 (수정 금지)
│   ├── template-functions.php   ← _s 원본 (수정 금지)
│   ├── customizer.php           ← _s 원본 (수정 금지)
│   ├── custom-header.php        ← _s 원본 (수정 금지)
│   ├── cb-setup.php             ← 테마 설정 / CB-00~01,03,05~07
│   ├── cb-enqueue.php           ← 스크립트·스타일 등록
│   ├── cb-menus.php             ← 네비게이션 4종
│   ├── cb-archive.php           ← 아카이브 타이틀 접두어 제거 (CB-02)
│   ├── cb-pagination.php        ← 페이지네이션 (CB-04)
│   ├── cb-dashboard.php         ← 관리자 대시보드 위젯 2종
│   ├── cb-cpt.php               ← (추가) CPT 등록
│   ├── cb-taxonomy.php          ← (추가) 택소노미 등록
│   └── cb-metabox.php           ← (추가) MetaBox 설정
├── template-parts/
│   ├── archive/content.php      ← 아카이브 루프
│   ├── single/content.php       ← 단일 포스트
│   ├── page/content.php         ← 고정 페이지
│   ├── content.php              ← 기본 fallback (_s 호환)
│   ├── content-none.php         ← 결과 없음 (_s 호환)
│   ├── content-page.php         ← 페이지 (_s 호환)
│   ├── content-search.php       ← 검색 (_s 호환)
│   └── common/
│       ├── menu.php             ← 오프캔버스/모바일 메뉴 영역
│       ├── search.php           ← 검색 영역
│       ├── share.php            ← 공유 버튼
│       └── related.php          ← 관련 글
├── js/
│   ├── navigation.js            ← _s 원본
│   └── creativeband.js          ← 커스텀 JS
└── CLAUDE.md                    ← 이 파일
\`\`\`

## 네비게이션 위치
| location | 설명 |
|---|---|
| \`primary\` | 주 네비게이션 (헤더) |
| \`utility\` | 유틸리티 라인 (헤더 상단) |
| \`footer\` | 푸터 네비게이션 |
| \`category-nav\` | 카테고리 네비게이션 |

## 조회수 함수
\`\`\`php
rubberband_set_post_views( get_the_ID() );  // 카운트 증가 (single.php 상단)
rubberband_get_post_views( get_the_ID() );  // 조회수 출력
\`\`\`

## 플러그인
- CPT/필드: MetaBox Pro
- SEO: Rank Math
- 폼: Contact Form 7
- 보안: Wordfence

## 주의사항
- CPT·택소노미 추가 전 IA Excel 먼저 확인
- 한국어 타이포그래피: \`word-break: keep-all\`, line-height 1.7 이상 권장
- 페이지 빌더: 기본 미사용 (프로젝트별 결정)
CLAUDEMD

# ── 완료 ──────────────────────────────────────────────────────────────────────

echo ""
info "테마 생성 완료!"
echo ""
echo "  출력 위치 : $OUTPUT_DIR"
echo ""
echo "  다음 단계:"
echo "  1. MAMP에서 새 사이트 추가 후 워드프레스 설치"
echo "  2. 관리자 > 외모 > 테마에서 '${PROJECT_NAME}' 활성화"
echo "  3. Claude Code 시작:"
echo ""
echo "     cd $OUTPUT_DIR"
echo "     claude"
echo ""
