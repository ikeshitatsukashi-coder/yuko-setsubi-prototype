<?php
/**
 * 404
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header(); ?>

<section class="page-section page-section--white" style="padding:120px 0;text-align:center">
  <div class="container">
    <p style="font-family:var(--ff-en);font-size:120px;font-weight:900;color:var(--sky);margin:0;line-height:1">404</p>
    <h1 style="font-size:28px;color:var(--navy);margin:16px 0 8px">ページが見つかりません</h1>
    <p style="color:var(--gray);margin-bottom:32px">お探しのページは削除されたか、URLが変更された可能性があります。</p>
    <p>
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="cta cta--outline" style="display:inline-block;padding:14px 28px;border:2px solid var(--navy);color:var(--navy);text-decoration:none;font-weight:900;border-radius:8px;margin:6px">ブログ一覧へ</a>
      <a href="<?php echo yuko_main_url(); ?>" class="cta cta--outline" style="display:inline-block;padding:14px 28px;border:2px solid var(--navy);color:var(--navy);text-decoration:none;font-weight:900;border-radius:8px;margin:6px">トップへ戻る</a>
    </p>
  </div>
</section>

<?php get_footer();
