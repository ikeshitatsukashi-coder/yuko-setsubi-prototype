<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" type="image/svg+xml" href="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/favicon.svg">
<link rel="icon" type="image/png" sizes="32x32" href="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/favicon-32.png">
<link rel="apple-touch-icon" sizes="180x180" href="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/favicon-180.png">
<?php wp_head(); ?>
</head>
<body <?php body_class( 'page-sub' ); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
  <div class="site-header__inner">
    <a href="<?php echo yuko_main_url(); ?>" class="site-header__logo" aria-label="有限会社友好設備">
      <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/logo.svg" alt="有限会社友好設備" class="brand-logo">
    </a>
    <nav class="gnav" aria-label="グローバル">
      <ul>
        <li><a href="<?php echo yuko_main_url( 'about/' ); ?>">About</a></li>
        <li><a href="<?php echo yuko_main_url( 'service/' ); ?>">Service</a></li>
        <li><a href="<?php echo yuko_main_url( 'recruit/' ); ?>">Recruit</a></li>
        <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"<?php if ( is_home() || is_singular( 'post' ) || is_category() || is_archive() && ! is_post_type_archive( 'news' ) ) echo ' class="is-current"'; ?>>Blog</a></li>
        <li><a href="<?php echo esc_url( get_post_type_archive_link( 'news' ) ); ?>"<?php if ( is_singular( 'news' ) || is_post_type_archive( 'news' ) || is_tax( 'news_category' ) ) echo ' class="is-current"'; ?>>News</a></li>
        <li><a href="<?php echo yuko_main_url( 'contact/' ); ?>">Contact</a></li>
      </ul>
    </nav>
    <a href="<?php echo yuko_main_url( 'recruit/' ); ?>" class="entry-btn">採用エントリー<span aria-hidden="true">→</span></a>
    <button class="hamburger" aria-label="メニュー" aria-expanded="false"><span></span><span></span><span></span></button>
  </div>
</header>
