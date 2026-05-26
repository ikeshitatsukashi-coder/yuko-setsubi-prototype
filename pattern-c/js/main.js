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
    name:'T.S', role:'施工管理 / 入社5年目',
    qa:[
      ['Q1. 友好設備に入った理由は？','前職は飲食店で、ずっと「形に残るしごと」をやりたかったんです。地元・川口の会社で、社長との面接で「うちは家族だよ」と言ってくれた言葉が決め手でした。'],
      ['Q2. 仕事の魅力は？','現場が完成して、車が走り出した瞬間。あの達成感はちょっと他の仕事にはないですね。'],
      ['Q3. これから入る人へ','体力勝負と思われがちですが、いまは機械化が進んでます。意外と頭を使う仕事です。']
    ]
  },
  '2': {
    name:'K.M', role:'管工事 / 入社2年目',
    qa:[
      ['Q1. 友好設備に入った理由は？','飲食店を辞めて、手に職を付けたかったから。「未経験OK」と書かれた求人をたくさん見て、社長の面接が一番フランクだった友好設備に決めました。'],
      ['Q2. 仕事の魅力は？','資格取得を全部会社が支援してくれます。すでに5つ取りました。'],
      ['Q3. これから入る人へ','工具の名前も知らないところから始めましたが、先輩が毎日教えてくれます。']
    ]
  },
  '3': {
    name:'H.A', role:'土木 / 入社14年目',
    qa:[
      ['Q1. 友好設備に入った理由は？','地元の友人の紹介でした。最初は3年くらいでと思っていたら、いつのまにか14年。'],
      ['Q2. 仕事の魅力は？','「家族のような会社」と言うとベタですが、本当にそうなんです。社長は名前で呼んでくれるし、誕生日にはみんなで肉を焼きます。'],
      ['Q3. これから入る人へ','人間関係で悩んだことがありません。それが一番のおすすめポイントです。']
    ]
  },
  '4': {
    name:'Y.N', role:'舗装 / 入社1年目',
    qa:[
      ['Q1. 友好設備に入った理由は？','高校で進学か就職か迷ったとき、「手に職をつけてほしい」と父に勧められて。'],
      ['Q2. 仕事の魅力は？','まだ覚えることだらけですが、毎日見える景色が変わっていくのは楽しいです。'],
      ['Q3. これから入る人へ','若い人がもっと増えてほしいです。先輩がやさしいので安心して飛び込んできて。']
    ]
  }
};

const modal = document.getElementById('personModal');
const modalBody = modal.querySelector('.person-modal__body');
const closeBtn = modal.querySelector('.person-modal__close');

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
