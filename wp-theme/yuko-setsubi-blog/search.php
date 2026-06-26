<?php
/**
 * 検索結果
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header(); ?>

<section class="page-hero">
  <div class="page-hero__bg" style="background-image:url('<?php echo esc_url( get_template_directory_uri() ); ?>/assets/staff-meeting.jpg')"></div>
  <div class="page-hero__glow"></div>
  <div class="page-hero__inner">
    <p class="page-hero__en" data-text="Search">Search</p>
    <h1 class="page-hero__jp">検索結果</h1>
    <nav class="breadcrumb">
      <a href="<?php echo yuko_main_url(); ?>">HOME</a><span>/</span>
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Blog</a><span>/</span>
      <span>「<?php echo esc_html( get_search_query() ); ?>」</span>
    </nav>
  </div>
</section>

<section class="page-section page-section--white">
  <div class="container">
    <p class="page-lead">「<?php echo esc_html( get_search_query() ); ?>」の検索結果</p>

    <?php if ( have_posts() ) : ?>
      <div class="blog-list">
        <?php while ( have_posts() ) : the_post(); ?>
          <a href="<?php the_permalink(); ?>" class="blog-card">
            <div class="blog-card__thumb">
              <?php if ( has_post_thumbnail() ) : ?>
                <?php the_post_thumbnail( 'yuko-card', array( 'class' => 'thumb-img' ) ); ?>
              <?php else : ?>
                <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/staff-meeting.jpg" alt="" class="thumb-img">
              <?php endif; ?>
            </div>
            <span class="blog-card__date"><?php yuko_post_date(); ?></span>
            <h3><?php the_title(); ?></h3>
            <p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 40, '…' ) ); ?></p>
          </a>
        <?php endwhile; ?>
      </div>
      <div class="pagination">
        <?php echo paginate_links( array( 'prev_text' => '«', 'next_text' => '»' ) ); ?>
      </div>
    <?php else : ?>
      <p style="text-align:center;padding:80px 0;color:var(--gray)">該当する記事が見つかりませんでした。</p>
    <?php endif; ?>
  </div>
</section>

<?php get_footer();
