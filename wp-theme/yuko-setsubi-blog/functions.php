<?php
/**
 * 友好設備 ブログテーマ functions
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/* メインサイト(コーポレート)URL。本番は yukohsetsubi.com、開発時は適宜上書き */
if ( ! defined( 'YUKO_MAIN_SITE_URL' ) ) {
	define( 'YUKO_MAIN_SITE_URL', 'https://yukohsetsubi.com' );
}

/* ===========================================
 * 秘密ログインURL（社員のみアクセス可能）
 * ↓本番リリース前に必ず変更してください
 * 例: 'yuko-staff-2026' → https://blog.yukohsetsubi.com/yuko-staff-2026
 * =========================================== */
if ( ! defined( 'YUKO_LOGIN_SLUG' ) ) {
	define( 'YUKO_LOGIN_SLUG', 'yuko-staff-2026' );
}

/**
 * /wp-login.php と /wp-admin/ を一般ユーザーから隠す
 * - 秘密スラッグ経由のアクセスのみ許可
 * - 秘密スラッグなしの直接アクセスは 404
 * - ログアウト・パスワードリセットは引き続き機能
 */
function yuko_hide_login_init() {
	if ( ! defined( 'YUKO_LOGIN_SLUG' ) || ! YUKO_LOGIN_SLUG ) return;

	$slug = YUKO_LOGIN_SLUG;
	$req  = isset( $_SERVER['REQUEST_URI'] ) ? $_SERVER['REQUEST_URI'] : '';
	$path = wp_parse_url( $req, PHP_URL_PATH );
	$path = $path ? trim( $path, '/' ) : '';

	// ① 秘密スラッグでのアクセス → /wp-login.php に内部的に渡す
	if ( $path === $slug ) {
		// クッキー埋め込み（後続の認証フローを通すため）
		setcookie( 'yuko_login_ok', '1', time() + 600, COOKIEPATH, COOKIE_DOMAIN, is_ssl(), true );
		$_COOKIE['yuko_login_ok'] = '1';
		require_once ABSPATH . 'wp-login.php';
		exit;
	}

	// ② /wp-login.php 直アクセス → 404
	if ( strpos( $req, 'wp-login.php' ) !== false ) {
		// ログアウト・パスワードリセット等は許可
		$allowed_actions = array( 'logout', 'postpass', 'rp', 'resetpass', 'lostpassword', 'register' );
		$action = isset( $_REQUEST['action'] ) ? $_REQUEST['action'] : '';
		// 秘密フローを通ってきている場合は許可
		$has_cookie = isset( $_COOKIE['yuko_login_ok'] );
		if ( ! in_array( $action, $allowed_actions, true ) && ! $has_cookie ) {
			yuko_force_404();
		}
	}

	// ③ /wp-admin/ 直アクセス（未ログイン） → 404
	if ( strpos( $req, 'wp-admin' ) !== false && ! is_user_logged_in() ) {
		// admin-ajax と admin-post は通す（フロント側で使うため）
		if ( strpos( $req, 'admin-ajax.php' ) === false && strpos( $req, 'admin-post.php' ) === false ) {
			yuko_force_404();
		}
	}
}
add_action( 'init', 'yuko_hide_login_init', 1 );

function yuko_force_404() {
	status_header( 404 );
	nocache_headers();
	global $wp_query;
	$wp_query->set_404();
	$tpl = get_query_template( '404' );
	if ( $tpl ) include $tpl;
	exit;
}

/* ログイン後のリダイレクト先：管理画面ダッシュボード */
function yuko_login_redirect( $redirect_to, $request, $user ) {
	if ( isset( $user->ID ) ) return admin_url();
	return $redirect_to;
}
add_filter( 'login_redirect', 'yuko_login_redirect', 10, 3 );

/* テーマサポート */
function yuko_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'navigation-widgets' ) );
	add_theme_support( 'automatic-feed-links' );

	add_image_size( 'yuko-card',  720, 480, true );
	add_image_size( 'yuko-hero', 1600, 900, true );

	register_nav_menus( array(
		'primary' => 'グローバルナビ（本番URL固定でOK）',
		'footer'  => 'フッターメニュー',
	) );
}
add_action( 'after_setup_theme', 'yuko_setup' );

/* CSS/JS 読み込み */
function yuko_enqueue() {
	$theme_uri = get_template_directory_uri();
	$ver       = wp_get_theme()->get( 'Version' );

	// Google Fonts
	wp_enqueue_style( 'yuko-fonts',
		'https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;700;900&family=Caveat:wght@500;700&family=Outfit:wght@400;700;900&family=Anton&display=swap',
		array(), null );

	// メインCSS（pattern-cと共通スタイル）
	wp_enqueue_style( 'yuko-main', $theme_uri . '/assets/css/style.css', array(), $ver );

	// ブログ・WP特有スタイル
	wp_enqueue_style( 'yuko-wp', $theme_uri . '/assets/css/wp.css', array( 'yuko-main' ), $ver );

	// JS
	wp_enqueue_script( 'yuko-main', $theme_uri . '/assets/js/main.js', array(), $ver, true );
}
add_action( 'wp_enqueue_scripts', 'yuko_enqueue' );

/* News カスタム投稿タイプ */
require_once get_template_directory() . '/inc/post-types.php';

/* Blog カテゴリースラッグの日本語→ローマ字マップ（クライアントが日本語で作成→URLは英数字） */
function yuko_sanitize_category_slug( $title, $raw_title, $context ) {
	if ( 'save' === $context && preg_match( '/[^\x00-\x7F]/', $title ) ) {
		// 日本語が含まれている場合、英字でない部分を 'category' + ID 形式に
		return 'cat-' . wp_generate_password( 6, false );
	}
	return $title;
}
add_filter( 'sanitize_title', 'yuko_sanitize_category_slug', 10, 3 );

/* 抜粋を120文字に */
function yuko_excerpt_length( $length ) { return 60; }
add_filter( 'excerpt_length', 'yuko_excerpt_length' );

function yuko_excerpt_more( $more ) { return '…'; }
add_filter( 'excerpt_more', 'yuko_excerpt_more' );

/* 管理画面：投稿エディタを「投稿/News」共通でクラシック寄りに */
function yuko_admin_scripts() {
	echo '<style>
		.acf-postbox .hndle { font-weight:bold; }
		.post-type-news .editor-styles-wrapper { background:#f6fbff; }
	</style>';
}
add_action( 'admin_head', 'yuko_admin_scripts' );

/* メインサイトURL用ヘルパー */
function yuko_main_url( $path = '' ) {
	return esc_url( trailingslashit( YUKO_MAIN_SITE_URL ) . ltrim( $path, '/' ) );
}

/* 投稿日付フォーマット */
function yuko_post_date() {
	echo esc_html( get_the_date( 'Y.m.d' ) );
}

/* カテゴリーラベル取得（先頭1件） */
function yuko_post_first_category( $post_id = null, $taxonomy = 'category' ) {
	$terms = get_the_terms( $post_id ?: get_the_ID(), $taxonomy );
	if ( $terms && ! is_wp_error( $terms ) ) {
		return esc_html( $terms[0]->name );
	}
	return '';
}

/* 検索を無効化したい場合のショートカット（コメントアウト） */
// add_filter( 'pre_get_posts', function( $q ) {
// 	if ( ! is_admin() && $q->is_main_query() && $q->is_search() ) {
// 		$q->is_search = false; $q->is_404 = true;
// 	}
// });
