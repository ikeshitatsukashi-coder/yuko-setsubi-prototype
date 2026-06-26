<?php
/**
 * ブログ記事 個別ページ
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();

while ( have_posts() ) : the_post();
  $thumb_url = has_post_thumbnail() ? get_the_post_thumbnail_url( null, 'yuko-hero' ) : get_template_directory_uri() . '/assets/staff-meeting.jpg';
?>

<section class="page-hero">
  <div class="page-hero__bg" style="background-image:url('<?php echo esc_url( $thumb_url ); ?>')"></div>
  <div class="page-hero__glow"></div>
  <div class="page-hero__inner">
    <p class="page-hero__en" data-text="Blog">Blog</p>
    <h1 class="page-hero__jp" style="font-size:clamp(28px,4vw,40px);line-height:1.5"><?php the_title(); ?></h1>
    <nav class="breadcrumb">
      <a href="<?php echo yuko_main_url(); ?>">HOME</a><span>/</span>
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Blog</a><span>/</span>
      <span><?php echo esc_html( wp_trim_words( get_the_title(), 8, '…' ) ); ?></span>
    </nav>
  </div>
</section>

<section class="page-section page-section--white">
  <div class="container" style="max-width:880px">
    <p style="text-align:center;color:var(--gray);font-family:var(--ff-en);font-weight:700;letter-spacing:.06em;margin-bottom:8px">
      <?php yuko_post_date(); ?>
      <?php $cat = yuko_post_first_category(); if ( $cat ) : ?>
        <span style="margin-left:12px;padding:4px 12px;border-radius:999px;background:var(--sky-pale);color:var(--navy);font-size:11px"><?php echo $cat; ?></span>
      <?php endif; ?>
    </p>
    <article class="entry-content" style="line-height:2;font-size:16px;color:var(--ink)">
      <?php the_content(); ?>
    </article>

    <nav class="post-nav" style="display:flex;justify-content:space-between;gap:16px;margin-top:64px;padding-top:32px;border-top:1px solid var(--border);font-family:var(--ff-en);font-weight:900;font-size:13px;letter-spacing:.08em">
      <?php
      $prev = get_previous_post();
      $next = get_next_post();
      ?>
      <div><?php if ( $prev ) : ?><a href="<?php echo esc_url( get_permalink( $prev ) ); ?>" style="color:var(--navy);text-decoration:none">← <?php echo esc_html( get_the_title( $prev ) ); ?></a><?php endif; ?></div>
      <div style="text-align:right"><?php if ( $next ) : ?><a href="<?php echo esc_url( get_permalink( $next ) ); ?>" style="color:var(--navy);text-decoration:none"><?php echo esc_html( get_the_title( $next ) ); ?> →</a><?php endif; ?></div>
    </nav>

    <p style="text-align:center;margin-top:48px">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="cta cta--outline" style="display:inline-block;padding:14px 28px;border:2px solid var(--navy);color:var(--navy);text-decoration:none;font-weight:900;border-radius:8px">ブログ一覧へ戻る</a>
    </p>
  </div>
</section>

<?php endwhile; get_footer();
