<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<section class="related-links">
  <div class="container">
    <h2 class="related-links__title">他のページを見る</h2>
    <div class="related-links__grid">
      <?php if ( ! is_post_type_archive( 'news' ) && ! is_singular( 'news' ) ) : ?>
        <a href="<?php echo esc_url( get_post_type_archive_link( 'news' ) ); ?>" class="related-link"><span class="kbd">News</span><h3>お知らせ</h3><p>会社からの公式なお知らせ。</p><i>VIEW MORE →</i></a>
      <?php else : ?>
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="related-link"><span class="kbd">Blog</span><h3>社員ブログ</h3><p>現場のリアルを社員が発信。</p><i>VIEW MORE →</i></a>
      <?php endif; ?>
      <a href="<?php echo yuko_main_url( 'recruit/' ); ?>" class="related-link"><span class="kbd">Recruit</span><h3>採用情報</h3><p>仲間を募集中。</p><i>VIEW MORE →</i></a>
      <a href="<?php echo yuko_main_url( 'contact/' ); ?>" class="related-link"><span class="kbd">Contact</span><h3>お問い合わせ</h3><p>ご質問はこちら。</p><i>VIEW MORE →</i></a>
    </div>
  </div>
</section>

<footer class="site-footer">
  <div class="container">
    <div class="site-footer__grid">
      <div class="site-footer__brand">
        <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/logo-white.svg" alt="有限会社友好設備" class="brand-logo brand-logo--footer">
        <small class="brand-tagline">Yuko Setsubi Co.,Ltd. / since 1980</small>
        <address class="footer-address">〒334-0058<br>埼玉県川口市大字安行領根岸1167<br>TEL: <a href="tel:048-287-0666">048-287-0666</a> / FAX: 048-287-0665</address>
      </div>
      <div class="site-footer__cols">
        <div><h4>About</h4><ul>
          <li><a href="<?php echo yuko_main_url( 'about/' ); ?>">会社案内</a></li>
          <li><a href="<?php echo yuko_main_url( 'about/#message' ); ?>">代表メッセージ</a></li>
          <li><a href="<?php echo yuko_main_url( 'about/#history' ); ?>">沿革</a></li>
          <li><a href="<?php echo yuko_main_url( 'about/#company' ); ?>">会社概要</a></li>
        </ul></div>
        <div><h4>Service</h4><ul>
          <li><a href="<?php echo yuko_main_url( 'service/' ); ?>">事業内容</a></li>
          <li><a href="<?php echo yuko_main_url( 'service/#mainline' ); ?>">上下水道工事</a></li>
          <li><a href="<?php echo yuko_main_url( 'service/#leak' ); ?>">漏水修理・緊急対応</a></li>
          <li><a href="<?php echo yuko_main_url( 'service/#service' ); ?>">水道引込工事</a></li>
          <li><a href="<?php echo yuko_main_url( 'service/#public' ); ?>">道路埋設管工事</a></li>
          <li><a href="<?php echo yuko_main_url( 'service/#school' ); ?>">学校・公共施設</a></li>
        </ul></div>
        <div><h4>Recruit</h4><ul>
          <li><a href="<?php echo yuko_main_url( 'recruit/' ); ?>">採用情報</a></li>
          <li><a href="<?php echo yuko_main_url( 'recruit/#people' ); ?>">先輩社員</a></li>
          <li><a href="<?php echo yuko_main_url( 'recruit/#welfare' ); ?>">福利厚生</a></li>
          <li><a href="<?php echo yuko_main_url( 'recruit/#flow' ); ?>">1日の流れ</a></li>
        </ul></div>
        <div><h4>Other</h4><ul>
          <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">ブログ</a></li>
          <li><a href="<?php echo esc_url( get_post_type_archive_link( 'news' ) ); ?>">お知らせ</a></li>
          <li><a href="<?php echo yuko_main_url( 'contact/' ); ?>">お問い合わせ</a></li>
        </ul></div>
      </div>
    </div>
    <p class="copy">&copy; 1980 YUKO SETSUBI Co.,Ltd. All Rights Reserved.</p>
  </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
