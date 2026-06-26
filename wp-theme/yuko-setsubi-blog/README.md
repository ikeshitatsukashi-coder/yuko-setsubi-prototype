# 有限会社友好設備 ブログテーマ

`yuko-setsubi-blog` ── 友好設備様のコーポレートサイト（pattern-c）と統一感のあるWordPressテーマ。
ブログとお知らせ（カスタム投稿タイプ）を運用するための専用テーマです。

---

## 同梱物

```
yuko-setsubi-blog/
├── style.css              テーマ情報
├── functions.php          初期設定・CSS/JS読み込み
├── header.php / footer.php  共通レイアウト（メインサイトと統一）
├── index.php / archive.php  ブログ一覧
├── single.php             ブログ個別ページ
├── archive-news.php       お知らせ一覧
├── single-news.php        お知らせ個別ページ
├── 404.php                404ページ
├── search.php / searchform.php  検索ページ
├── inc/post-types.php     お知らせカスタム投稿タイプ登録
├── assets/                CSS・JS・ロゴ・ヒーロー画像
└── README.md              （このファイル）
```

---

## インストール手順

### 1. WordPressをインストール
- お名前.com（または他レンタルサーバー）の管理画面で **WordPress簡単インストール**
- インストール先：`blog.yukousetsubi.com`（サブドメイン本番想定）または `〜.sakura.ne.jp` 等の開発用URL

### 2. テーマをアップロード
1. WordPress管理画面 → 外観 → テーマ → 新しいテーマを追加 → **テーマのアップロード**
2. `yuko-setsubi-blog.zip` を選択してアップロード
3. **有効化**

### 3. パーマリンク設定
1. 設定 → パーマリンク
2. **「投稿名」** を選択 → 保存
   - URL構造：`/blog/記事スラッグ/`（ブログ）／`/news/記事スラッグ/`（お知らせ）

### 4. メインサイトURL設定
`functions.php` の冒頭にある定数 `YUKO_MAIN_SITE_URL` を本番URLに合わせて編集：
```php
define( 'YUKO_MAIN_SITE_URL', 'https://yukousetsubi.com' );
```
※ デフォルトでは `https://yukousetsubi.com` を指しています。開発時は GitHub Pages URL等に書き換え可。

### 5. 推奨プラグイン（任意）
- **WP Multibyte Patch**（日本語環境最適化／公式推奨）
- **Yoast SEO** または **All in One SEO**（SEO対策）
- **EWWW Image Optimizer**（画像自動圧縮）
- **BackWPup**（自動バックアップ）

---

## クライアント様向け：投稿マニュアル

### ブログ記事を書く
1. WordPress管理画面にログイン
2. 左メニュー「**投稿**」→「**新規追加**」
3. タイトル・本文・カテゴリー・アイキャッチ画像を設定
4. 「**公開**」ボタン

### お知らせを書く
1. 左メニュー「**お知らせ**」→「**新規追加**」
2. タイトル・本文・お知らせカテゴリーを設定
3. 「**公開**」ボタン

### アイキャッチ画像（ブログ用）
- 推奨サイズ：横1600px × 縦1200px 程度
- 一覧では自動で 720×480 にトリミングされます

---

## 開発者向けメモ

### CSS編集
- 基本スタイル：`assets/css/style.css` ← `pattern-c/css/style.css` と同一
- WP特有スタイル：`assets/css/wp.css`

### カスタム投稿タイプ追加
`inc/post-types.php` に `register_post_type()` を追記。

### 本番デプロイ前チェックリスト
- [ ] `YUKO_MAIN_SITE_URL` を本番URLに設定
- [ ] パーマリンク「投稿名」設定
- [ ] サンプル記事を1本投稿して動作確認
- [ ] アイキャッチ画像が一覧で適切に表示されるか
- [ ] お知らせ投稿タイプが管理メニューに出ているか
- [ ] メインサイトのナビからブログへのリンクが正しい
- [ ] SSL（https）が有効
- [ ] サーチコンソール登録（必要なら）

---

## バージョン

- 1.0.0 ── 初版（pattern-cデザイン準拠）
