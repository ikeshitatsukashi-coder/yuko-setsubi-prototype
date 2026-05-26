// Yuko Setsubi — Pattern B

const io = new IntersectionObserver((entries)=>{
  entries.forEach(e=>{
    if(e.isIntersecting){ e.target.classList.add('in'); io.unobserve(e.target); }
  });
},{threshold:.12});

document.querySelectorAll('.block__text, .block__visual, .layer, .brand-message__quote, .brand-message__body, .message__body, .recruit__title, .partner__title, .blog__list li, .company__list > div').forEach(el=>{
  el.classList.add('reveal'); io.observe(el);
});

// Subtle parallax on hero video on scroll
const vid = document.querySelector('.hero__video');
if(vid){
  window.addEventListener('scroll', ()=>{
    const y = window.scrollY;
    if(y < window.innerHeight){
      vid.style.transform = `translateY(${y*0.18}px) scale(1.05)`;
    }
  },{passive:true});
}

// Layers — slight parallax in block visuals
const visuals = document.querySelectorAll('.block__visual');
visuals.forEach(v=>{
  v.addEventListener('mousemove',(e)=>{
    const r = v.getBoundingClientRect();
    const x = (e.clientX - r.left)/r.width - .5;
    const y = (e.clientY - r.top)/r.height - .5;
    v.querySelector('.layer--bg')?.style.setProperty('transform', `translate(${x*-10}px, ${y*-10}px)`);
    v.querySelector('.layer--main')?.style.setProperty('transform', `translate(${x*10}px, ${y*10}px)`);
    v.querySelector('.layer--accent')?.style.setProperty('transform', `translate(${x*-18}px, ${y*-18}px)`);
  });
  v.addEventListener('mouseleave',()=>{
    v.querySelectorAll('.layer').forEach(l=>l.style.transform='');
  });
});
