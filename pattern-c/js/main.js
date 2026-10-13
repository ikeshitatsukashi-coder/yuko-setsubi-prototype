// Yuko Setsubi — Pattern C

// Scroll reveal
const io = new IntersectionObserver((entries)=>{
  entries.forEach(e=>{
    if(e.isIntersecting){ e.target.classList.add('in'); io.unobserve(e.target); }
  });
},{threshold:.12});
document.querySelectorAll('.section-title, .topics__list li, .stat, .person, .job-card, .flow__list li, .welfare__item, .blog-card, .ceo-message__body, .entry__title, .company__list > div').forEach(el=>{
  el.classList.add('reveal'); io.observe(el);
});

// People modal
const persons = {
  '1': {
    name:'西岡さん', role:'27歳 / 一度離れて戻ってきた「出戻り」',
    qa:[
      ['出戻りで、また友好設備へ','実は僕は出戻りで、一度外構の会社に移ったことがありました。そこが基本的に1人作業、土日すら休めなくて…。現場で友好設備の先輩にばったり会ったりするたびに「戻りたいな…」って思ってたんです。でもなかなか言い出せなくて…そしたら村井さんが「さっさと戻ってこいよ！」ってしつこく誘ってくれたんです（笑）'],
      ['戻ってきて思うのは、とにかく「居心地が良い！」','戻ってきて思うのは、とにかく「居心地が良い！」こと。8時15分スタートで17時15分には終わるし、有給も取りやすい。GW・お盆・年末年始は長いと10連休くらいになるので、小さい子どもがいる身としては本当にありがたいです。'],
      ['社長の畑の、おすそ分け','あと、置き場にいると社長の畑の野菜や果物が山盛りで置いてあるので、家で野菜を買わなくて大丈夫ですよ！（笑）']
    ]
  },
  '2': {
    name:'村井さん', role:'46歳 / 勤続20年',
    qa:[
      ['入社のキッカケは「家から近かった」だけ！','ここに決めた一番の理由は、正直に言うと「家から近かった」から（笑）前の型枠の現場は遠くて、17時に終わっても家に着くのは18時過ぎ。近所を散歩していて、たまたま見つけたのが友好設備だったんです。'],
      ['続いてる理由は、やっぱり「人」','入ってみて続いてる理由は、やっぱり「人」ですね！最初は水道の締め方ひとつとっても不安で。でも「大丈夫だよ！一応見とくから！」って先輩が一言かけてくれるだけでフッと安心できる。他の現場だと言葉が強めな世界もあるけど、うちはみんな丁寧で穏やか。広島から出てきた自分にもすごく馴染みやすかったですね。'],
      ['気がついたら、もう入社20年','水道ってライフライン、人の生活に直結する仕事です。現場でお客さんからお菓子やジュースをいただいたり、「ありがとう」って直接言ってもらえる。いい仕事だなぁって、20年やっても思います！興味を持って頂けたら、ちょっと遊びに来て下さい！']
    ]
  }
};

const modal = document.getElementById('personModal');
const modalBody = modal ? modal.querySelector('.person-modal__body') : null;
const closeBtn = modal ? modal.querySelector('.person-modal__close') : null;

if(modal && modalBody && closeBtn){

document.querySelectorAll('.person').forEach(card=>{
  card.addEventListener('click',()=>{
    const id = card.dataset.id;
    const p = persons[id];
    if(!p) return;
    modalBody.innerHTML = `
      <span class="role">${p.role}</span>
      <h3>${p.name}</h3>
      ${p.qa.map(([q,a])=>`<div class="qa"><b>${q}</b><p>${a}</p></div>`).join('')}
    `;
    modal.classList.add('open');
    document.body.style.overflow = 'hidden';
  });
});
closeBtn.addEventListener('click',()=>{
  modal.classList.remove('open');
  document.body.style.overflow='';
});
modal.addEventListener('click',(e)=>{
  if(e.target===modal){
    modal.classList.remove('open');
    document.body.style.overflow='';
  }
});

} // end if(modal)

// Hamburger toggle
const hb = document.querySelector('.hamburger');
const nav = document.querySelector('.gnav');
if(hb && nav){
  hb.addEventListener('click',()=>{
    const open = hb.getAttribute('aria-expanded') === 'true';
    hb.setAttribute('aria-expanded', String(!open));
    nav.classList.toggle('open');
  });
}

// Sticky entry shows only after hero
const stickyEntry = document.querySelector('.sticky-entry');
if(stickyEntry){
  window.addEventListener('scroll', ()=>{
    if(window.scrollY > window.innerHeight * .6){
      stickyEntry.style.opacity = '1';
      stickyEntry.style.pointerEvents = 'auto';
    } else {
      stickyEntry.style.opacity = '0';
      stickyEntry.style.pointerEvents = 'none';
    }
  },{passive:true});
  stickyEntry.style.transition = 'opacity .3s, transform .25s, background .25s';
  stickyEntry.style.opacity = '0';
  stickyEntry.style.pointerEvents = 'none';
}


/* ========= フォーム → メール送信（send.php 経由） ========= */
function yukoSend(form, e){
  e.preventDefault();
  var btn = form.querySelector('button[type="submit"]');
  var orig = btn ? btn.innerHTML : '';
  if(btn){ btn.disabled = true; btn.innerHTML = '送信中…'; }
  var fd = new FormData(form);
  fd.append('ajax','1');
  fetch('/send.php', { method:'POST', body: fd })
    .then(function(r){ return r.json().catch(function(){ return { ok: r.ok }; }); })
    .then(function(j){
      if(j && j.ok){
        form.innerHTML = '<div style="text-align:center;padding:48px 16px;color:#0E2A47">'
          + '<p style="font-size:20px;font-weight:900;margin:0 0 10px">送信しました</p>'
          + '<p style="color:#3f5568;line-height:1.9;margin:0">お問い合わせありがとうございます。<br>担当者より追ってご連絡いたします。</p></div>';
      } else {
        alert('送信に失敗しました。お手数ですが、お電話（048-287-0666）でお問い合わせください。');
        if(btn){ btn.disabled = false; btn.innerHTML = orig; }
      }
    })
    .catch(function(){
      alert('送信に失敗しました。お手数ですが、お電話（048-287-0666）でお問い合わせください。');
      if(btn){ btn.disabled = false; btn.innerHTML = orig; }
    });
  return false;
}

/* ========= WordPress連動：最新情報（お知らせ）＋ 社員ブログ（投稿） ========= */
(function(){
  var WP = 'https://blog.yukoh-setsubi.jp/wp-json/wp/v2/';
  function fmtDate(s){
    var d = new Date(s); if(isNaN(d)) return '';
    var p = function(n){ return (n<10?'0':'')+n; };
    return d.getFullYear()+'.'+p(d.getMonth()+1)+'.'+p(d.getDate());
  }
  function esc(s){ return String(s==null?'':s).replace(/[&<>"]/g,function(c){return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;'}[c];}); }
  function cat(it, fb){
    try{ var t = it._embedded['wp:term'][0]; if(t && t.length){ var n=t[0].name; if(n && n!=='未分類' && n.toLowerCase()!=='uncategorized') return n; } }catch(e){}
    return fb;
  }

  // 最新情報（news CPT）→ 固定の3件を置き換え（失敗時は固定表示を維持）
  var topics = document.querySelector('.topics__list');
  if(topics){
    fetch(WP+'news?per_page=3&_embed=1')
      .then(function(r){ return r.ok ? r.json() : Promise.reject(); })
      .then(function(items){
        if(!items || !items.length) return;
        topics.innerHTML = items.map(function(it){
          var title = (it.title && it.title.rendered) || '';
          var link = it.link || 'https://blog.yukoh-setsubi.jp/news/';
          return '<li><time>'+fmtDate(it.date)+'</time>'
            + '<span class="tag tag--recruit">'+esc(cat(it,'お知らせ'))+'</span>'
            + '<p><a href="'+link+'" target="_blank" rel="noopener" style="color:inherit">'+title+'</a></p></li>';
        }).join('');
      })
      .catch(function(){});
  }

  // 社員ブログ（投稿）→ 固定の3枚を置き換え
  var blog = document.querySelector('.blog__grid');
  if(blog){
    var DEF = '/shared/images/works-grid.jpg';
    fetch(WP+'posts?per_page=3&_embed=1')
      .then(function(r){ return r.ok ? r.json() : Promise.reject(); })
      .then(function(items){
        if(!items || !items.length) return;
        blog.innerHTML = items.map(function(it){
          var title = (it.title && it.title.rendered) || '';
          var link = it.link || 'https://blog.yukoh-setsubi.jp/';
          var img = DEF;
          try{ var m = it._embedded['wp:featuredmedia'][0]; if(m && m.source_url) img = m.source_url; }catch(e){}
          return '<article class="blog-card" onclick="window.open(\'' + link + '\',\'_blank\')" style="cursor:pointer">'
            + '<div class="blog-card__thumb"><img src="'+img+'" alt="" class="thumb-img"></div>'
            + '<span class="blog-card__cat">'+esc(cat(it,'ブログ'))+'</span>'
            + '<h3>'+title+'</h3><time>'+fmtDate(it.date)+'</time></article>';
        }).join('');
      })
      .catch(function(){});
  }
})();
