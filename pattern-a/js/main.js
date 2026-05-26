// Yuko Setsubi — Pattern A

// ===== Hero: split-text kinetic typography =====
document.querySelectorAll('.split-char').forEach(el=>{
  const text = el.textContent;
  el.textContent = '';
  Array.from(text).forEach((c,i)=>{
    const s = document.createElement('span');
    s.className = 'char';
    s.style.setProperty('--i', i);
    s.textContent = c === ' ' ? ' ' : c;
    s.style.display = 'inline-block';
    el.appendChild(s);
  });
});

// ===== Hero: mouse-follow parallax =====
const hero = document.querySelector('.hero');
if(hero){
  const bg = hero.querySelector('[data-parallax="bg"]');
  const fg = hero.querySelector('[data-parallax="fg"]');
  const glow1 = hero.querySelector('.hero__glow--1');
  const glow2 = hero.querySelector('.hero__glow--2');
  let raf = null;
  hero.addEventListener('mousemove',(e)=>{
    const r = hero.getBoundingClientRect();
    const x = (e.clientX - r.left)/r.width - .5;
    const y = (e.clientY - r.top)/r.height - .5;
    if(raf) cancelAnimationFrame(raf);
    raf = requestAnimationFrame(()=>{
      if(bg)  bg.style.transform  = `translate3d(${x*-22}px, ${y*-22}px, 0) scale(1.02)`;
      if(fg)  fg.style.transform  = `translate3d(${x*16}px, ${y*16}px, 0)`;
      if(glow1) glow1.style.transform = `translate3d(${x*40}px, ${y*40}px, 0)`;
      if(glow2) glow2.style.transform = `translate3d(${x*-50}px, ${y*-50}px, 0)`;
    });
  });
  hero.addEventListener('mouseleave',()=>{
    [bg,fg,glow1,glow2].forEach(el=>{ if(el) el.style.transform = ''; });
  });
}

// ===== Magnetic CTA =====
document.querySelectorAll('[data-magnet]').forEach(btn=>{
  const strength = 22;
  btn.addEventListener('mousemove',(e)=>{
    const r = btn.getBoundingClientRect();
    const x = (e.clientX - r.left)/r.width - .5;
    const y = (e.clientY - r.top)/r.height - .5;
    btn.style.transform = `translate(${x*strength}px, ${y*strength}px) translateY(-3px)`;
  });
  btn.addEventListener('mouseleave',()=>{
    btn.style.transform = '';
  });
});

// ===== Scroll-driven hero darken (sticky impact) =====
const heroOverlay = document.querySelector('.hero__overlay');
window.addEventListener('scroll',()=>{
  if(!heroOverlay) return;
  const y = window.scrollY;
  const vh = window.innerHeight;
  if(y < vh){
    const p = y/vh;
    heroOverlay.style.opacity = String(.5 + p*.5);
  }
},{passive:true});

// Scroll reveal
const io = new IntersectionObserver((entries)=>{
  entries.forEach(e=>{
    if(e.isIntersecting){ e.target.classList.add('in'); io.unobserve(e.target); }
  });
},{threshold:.15});
document.querySelectorAll('.section-title, .about__photo, .about__text, .karuta__card, .voice-row, .blog-card, .message__body, .company__table, .partners__box').forEach(el=>{
  el.classList.add('reveal'); io.observe(el);
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

// Header shadow on scroll
const header = document.querySelector('.site-header');
window.addEventListener('scroll',()=>{
  if(window.scrollY > 8){ header.classList.add('scrolled'); }
  else { header.classList.remove('scrolled'); }
},{passive:true});

// Karuta hover slight rotate
document.querySelectorAll('.karuta__card').forEach((c, i)=>{
  c.style.transitionDelay = (i*40)+'ms';
});

// ===== Karuta card: click to flip (PC + mobile) =====
document.querySelectorAll('.karuta-card').forEach(card=>{
  card.addEventListener('click',(e)=>{
    // Don't trigger when clicking the back-side "View More" link
    if(e.target.closest('.karuta-card__link')) return;
    // Close other cards first (single-open)
    document.querySelectorAll('.karuta-card').forEach(c=>{
      if(c !== card) c.classList.remove('is-flipped');
    });
    card.classList.toggle('is-flipped');
  });
});

// ===== Karuta scroll-triggered entrance =====
const karutaObserver = new IntersectionObserver((entries)=>{
  entries.forEach(e=>{
    if(e.isIntersecting){
      e.target.style.animationPlayState = 'running';
      karutaObserver.unobserve(e.target);
    }
  });
},{threshold:.2});
document.querySelectorAll('.karuta-card').forEach(c=>{
  c.style.animationPlayState = 'paused';
  karutaObserver.observe(c);
});

// ===== Recruit banner: spotlight follow =====
const recruitBanner = document.querySelector('.recruit-banner[data-spotlight]');
if(recruitBanner){
  recruitBanner.addEventListener('mousemove',(e)=>{
    const r = recruitBanner.getBoundingClientRect();
    const x = ((e.clientX - r.left) / r.width) * 100;
    const y = ((e.clientY - r.top) / r.height) * 100;
    recruitBanner.style.setProperty('--mx', x + '%');
    recruitBanner.style.setProperty('--my', y + '%');
  });
}

// (stat count-up removed - now using word statements)
