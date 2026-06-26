<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" style="display:flex;gap:8px;max-width:520px;margin:0 auto 32px">
  <label for="s" class="screen-reader-text" style="position:absolute;left:-9999px">検索</label>
  <input id="s" name="s" type="search" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="キーワードで検索" style="flex:1;padding:14px 18px;border:1px solid var(--border);border-radius:8px;font-size:15px">
  <button type="submit" style="padding:0 28px;background:var(--navy);color:#fff;border:none;border-radius:8px;font-weight:900;cursor:pointer">検索</button>
</form>
