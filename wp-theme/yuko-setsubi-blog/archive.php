<?php
/**
 * ブログ一覧（投稿アーカイブ・カテゴリー・タグ・年月アーカイブ）
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$is_news_archive = is_post_type_archive( 'news' ) || is_tax( 'news_category' );

get_header(); ?>

<section class="page-hero">
  <div class="page-hero__bg" style="background-image:url('<?php echo esc_url( get_template_directory_uri() ); ?>/assets/<?php echo $is_news_archive ? 'hero-sign.jpg' : 'staff-meeting.jpg'; ?>')"></div>
  <div class="page-hero__glow"></div>
  <div class="page-hero__inner">
    <p class="page-hero__en" data-text="<?php echo $is_news_archive ? 'News' : 'Blog'; ?>"><?php echo $is_news_archive ? 'News' : 'Blog'; ?></p>
    <h1 class="page-hero__jp"><?php echo $is_news_archive ? 'お知らせ' : '社員ブログ'; ?></h1>
    <nav class="breadcrumb">
      <a href="<?php echo yuko_main_url(); ?>">HOME</a><span>/</span>
      <span><?php echo $is_news_archive ? 'News' : 'Blog'; ?></span>
    </nav>
  </div>
</section>

<section class="page-section page-section--white">
  <div class="container">

    <?php if ( $is_news_archive ) : ?>
      <p class="page-lead">会社からの公式なお知らせを掲載しています。</p>
    <?php else : ?>
      <p class="page-lead">現場や社内のリアルを、社員みんなで発信中。<br>友好設備の「日常」をのぞいてみてください。</p>
    <?php endif; ?>

    <?php
    /* カテゴリーフィルタ（投稿のみ） */
    if ( ! $is_news_archive ) :
      $cats = get_terms( array( 'taxonomy' => 'category', 'hide_empty' => true ) );
      if ( ! empty( $cats ) && ! is_wp_error( $cats ) ) : ?>
        <div class="blog-filter">
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>"<?php if ( is_home() && ! is_category() ) echo ' class="is-active"'; ?>>すべて</a>
          <?php foreach ( $cats as $c ) : ?>
            <a href="<?php echo esc_url( get_term_link( $c ) ); ?>"<?php if ( is_category( $c->term_id ) ) echo ' class="is-active"'; ?>><?php echo esc_html( $c->name ); ?></a>
          <?php endforeach; ?>
        </div>
      <?php endif;
    endif; ?>

    <?php if ( have_posts() ) : ?>
      <?php if ( $is_news_archive ) : ?>
        <ul class="news-list" style="list-style:none;padding:0;margin:48px 0 0">
          <?php while ( have_posts() ) : the_post(); ?>
            <li style="display:flex;align-items:center;gap:24px;padding:24px 0;border-bottom:1px solid var(--border)">
              <time style="font-family:var(--ff-en);font-weight:900;color:var(--sky-deep,#2E8FBE);min-width:110px"><?php yuko_post_date(); ?></time>
              <?php $cat = yuko_post_first_category( null, 'news_category' ); ?>
              <?php if ( $cat ) : ?><span class="tag" style="padding:4px 12px;border-radius:999px;background:var(--sky-pale);color:var(--navy);font-size:12px;font-weight:900"><?php echo $cat; ?></span><?php endif; ?>
              <a href="<?php the_permalink(); ?>" style="flex:1;color:var(--ink);font-weight:700;text-decoration:none"><?php the_title(); ?></a>
            </li>
          <?php endwhile; ?>
        </ul>
      <?php else : ?>
        <div class="blog-list">
          <?php while ( have_posts() ) : the_post(); ?>
            <a href="<?php the_permalink(); ?>" class="blog-card">
              <div class="blog-card__thumb">
                <?php if ( has_post_thumbnail() ) : ?>
                  <?php the_post_thumbnail( 'yuko-card', array( 'class' => 'thumb-img', 'alt' => esc_attr( get_the_title() ) ) ); ?>
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
      <?php endif; ?>

      <div class="pagination">
        <?php
        echo paginate_links( array(
          'prev_text' => '«',
          'next_text' => '»',
          'mid_size'  => 1,
          'end_size'  => 1,
        ) );
        ?>
      </div>

    <?php else : ?>
      <p style="text-align:center;padding:80px 0;color:var(--gray)">記事はまだありません。</p>
    <?php endif; ?>

  </div>
</section>

<?php get_footer();
