<?php
/**
 * カスタム投稿タイプ News（お知らせ）
 */
if ( ! defined( 'ABSPATH' ) ) exit;

function yuko_register_news_cpt() {
	register_post_type( 'news', array(
		'label'         => 'お知らせ',
		'labels'        => array(
			'name'               => 'お知らせ',
			'singular_name'      => 'お知らせ',
			'menu_name'          => 'お知らせ',
			'all_items'          => 'お知らせ一覧',
			'add_new'            => '新規追加',
			'add_new_item'       => '新しいお知らせを追加',
			'edit_item'          => 'お知らせを編集',
			'new_item'           => '新しいお知らせ',
			'view_item'          => 'お知らせを表示',
			'search_items'       => 'お知らせを検索',
			'not_found'          => 'お知らせはありません',
			'not_found_in_trash' => 'ゴミ箱にお知らせはありません',
		),
		'public'        => true,
		'has_archive'   => true,
		'rewrite'       => array( 'slug' => 'news', 'with_front' => false ),
		'show_in_rest'  => true, // ブロックエディタ
		'menu_icon'     => 'dashicons-megaphone',
		'menu_position' => 6,
		'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'revisions' ),
		'taxonomies'    => array( 'news_category' ),
	) );

	register_taxonomy( 'news_category', 'news', array(
		'label'             => 'お知らせカテゴリー',
		'public'            => true,
		'hierarchical'      => true,
		'show_in_rest'      => true,
		'rewrite'           => array( 'slug' => 'news-category' ),
	) );
}
add_action( 'init', 'yuko_register_news_cpt' );

/* Blogのカテゴリーをよりわかりやすい用語に */
function yuko_blog_labels( $labels ) {
	$labels->name          = 'ブログ';
	$labels->singular_name = 'ブログ記事';
	$labels->menu_name     = 'ブログ';
	$labels->add_new_item  = '新しいブログ記事';
	return $labels;
}
add_filter( 'post_type_labels_post', 'yuko_blog_labels' );

/* Blogのスラッグを /blog/ に変更 */
function yuko_blog_rewrite() {
	global $wp_post_types, $wp_rewrite;
	if ( isset( $wp_post_types['post'] ) ) {
		$wp_post_types['post']->rewrite['slug']       = 'blog';
		$wp_post_types['post']->rewrite['with_front'] = false;
		$wp_post_types['post']->has_archive           = 'blog';
	}
}
add_action( 'init', 'yuko_blog_rewrite', 11 );
