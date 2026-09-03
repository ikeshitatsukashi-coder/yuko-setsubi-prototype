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
