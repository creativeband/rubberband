# rubberband

> WordPress Starter Theme by [Creative Band](https://creative-band.com)  
> Based on [Underscores (_s)](https://github.com/Automattic/_s) by Automattic

---

## 사용법

```bash
git clone https://github.com/creativeband/rubberband.git
cd rubberband
bash generator/generate.sh
```

입력 예시:

```
프로젝트 이름 : Rubber Band
테마 슬러그   : rubberband
제작자 이름   : Creative Band
제작자 URL    : https://creative-band.com
WP 경로       : /Sites/
```

결과:

```
/Applications/MAMP/htdocs/hairon/wp-content/themes/hairon/
```

---

## 패키지 구조

```
rubberband/
├── generator/
│   └── generate.sh          ← 실행 진입점
├── template/                ← 테마 소스 (여기서 직접 수정)
│   ├── functions.php        ← require 진입점만
│   ├── inc/
│   │   ├── template-tags.php        (_s 원본)
│   │   ├── template-functions.php   (_s 원본)
│   │   ├── customizer.php           (_s 원본)
│   │   ├── custom-header.php        (_s 원본)
│   │   ├── cb-setup.php             (rubberband)
│   │   ├── cb-enqueue.php           (rubberband)
│   │   ├── cb-menus.php             (rubberband)
│   │   ├── cb-archive.php           (rubberband)
│   │   ├── cb-pagination.php        (rubberband)
│   │   └── cb-dashboard.php         (rubberband)
│   ├── template-parts/
│   │   ├── archive/content.php
│   │   ├── single/content.php
│   │   ├── page/content.php
│   │   ├── content.php              (_s 호환)
│   │   ├── content-none.php         (_s 호환)
│   │   ├── content-page.php         (_s 호환)
│   │   ├── content-search.php       (_s 호환)
│   │   └── common/
│   │       ├── menu.php
│   │       ├── search.php
│   │       ├── share.php
│   │       └── related.php
│   └── js/
│       ├── navigation.js            (_s 원본)
│       └── creativeband.js          (커스텀)
├── .gitignore
├── CHANGELOG.md
└── README.md
```

---

## 슬러그 치환 규칙 (_s 컨벤션)

| 패턴 | 용도 | 예시 (slug: hairon) |
|---|---|---|
| `rubberband_` | 함수명 | `hairon_` |
| `'rubberband'` | 텍스트 도메인 | `'hairon'` |
| `rubberband-` | 핸들 | `hairon-` |
| `RUBBERBAND_` | 상수 | `HAIRON_` |
| `Rubberband` | DocBlock | `Hairon` |

---

## 기본 포함 기능 (CB- 번호)

| 번호 | 기능 | 파일 |
|---|---|---|
| CB-00 | 헤드 불필요 링크 제거 (RSD, WLW) | cb-setup.php |
| CB-01 | Page Excerpt 지원 | cb-setup.php |
| CB-02 | 아카이브 타이틀 접두어 제거 | cb-archive.php |
| CB-03 | Custom 404 Error Handler | cb-setup.php |
| CB-04 | 페이지네이션 | cb-pagination.php |
| CB-05 | REST API Featured Image URL | cb-setup.php |
| CB-06 | 로그인 자동완성 비활성화 | cb-setup.php |
| CB-07 | 포스트 조회수 카운트 | cb-setup.php |
| — | 네비게이션 4종 | cb-menus.php |
| — | 관리자 대시보드 위젯 2종 | cb-dashboard.php |

---

## 라이선스

GNU General Public License v2 or later  
Based on Underscores (_s) © Automattic, Inc.
