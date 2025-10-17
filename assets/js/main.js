// assets/js/main.js - minimal JS for interactions: slider, mobile menu, product gallery, cart qty, checkout steps
document.addEventListener('DOMContentLoaded', function(){

  // Mobile menu toggle
  const btn = document.getElementById('mobile-menu-btn');
  const nav = document.getElementById('mobile-nav');
  if(btn && nav){
    btn.addEventListener('click', ()=> nav.classList.toggle('hidden'));
  }

  // Simple hero slider (auto + arrows)
  let slideIndex = 0;
  const slides = document.querySelectorAll('.hero-slide');
  const dots = document.querySelectorAll('.hero-dot');
  function showSlide(n){
    slides.forEach((s,i)=> s.classList.add('hidden'));
    dots.forEach(d=> d.classList.remove('opacity-100'));
    slides[n].classList.remove('hidden');
    dots[n].classList.add('opacity-100');
  }
  function nextSlide(){
    slideIndex = (slideIndex + 1) % slides.length;
    showSlide(slideIndex);
  }
  if(slides.length > 0){
    showSlide(0);
    setInterval(nextSlide, 5000);
    // dots click
    dots.forEach((d,i)=> d.addEventListener('click', ()=> { slideIndex = i; showSlide(i); }));
  }

  // Testimonials carousel (simple)
  let tIndex = 0;
  const tCards = document.querySelectorAll('.testi-card');
  function showTesti(n){
    tCards.forEach((c,i)=> c.classList.add('hidden'));
    tCards[n].classList.remove('hidden');
  }
  if(tCards.length > 0){
    showTesti(0);
    setInterval(()=>{ tIndex = (tIndex+1) % tCards.length; showTesti(tIndex); }, 4500);
  }

  // Product gallery thumbnails
  document.querySelectorAll('.thumb').forEach(thumb=>{
    thumb.addEventListener('click', e=>{
      const main = thumb.closest('.gallery').querySelector('.main-img');
      main.src = thumb.dataset.src;
    });
  });

  // Quantity buttons
  document.querySelectorAll('.qty-decrease').forEach(btn=>{
    btn.addEventListener('click', e=>{
      const input = btn.nextElementSibling;
      input.value = Math.max(1, parseInt(input.value||1)-1);
      updateSubtotal(btn);
    });
  });
  document.querySelectorAll('.qty-increase').forEach(btn=>{
    btn.addEventListener('click', e=>{
      const input = btn.previousElementSibling;
      input.value = parseInt(input.value||1)+1;
      updateSubtotal(btn);
    });
  });
  function updateSubtotal(el){
    const row = el.closest('tr');
    if(!row) return;
    const price = parseFloat(row.querySelector('.item-price').dataset.value);
    const qty = parseInt(row.querySelector('input[type=number]').value);
    row.querySelector('.item-subtotal').textContent = '$' + (price*qty).toFixed(2);
    // update totals
    updateCartTotals();
  }
  function updateCartTotals(){
    let total = 0;
    document.querySelectorAll('tr.cart-row').forEach(r=>{
      const s = parseFloat(r.querySelector('.item-subtotal').textContent.replace('$','')) || 0;
      total += s;
    });
    document.querySelectorAll('.cart-total-amount').forEach(el=> el.textContent = '$' + total.toFixed(2));
  }
  updateCartTotals();

  // Simple checkout multi-step
  const steps = Array.from(document.querySelectorAll('.checkout-step'));
  const nextBtns = document.querySelectorAll('.checkout-next');
  const prevBtns = document.querySelectorAll('.checkout-prev');
  let currentStep = 0;
  function showStep(i){
    steps.forEach((s,idx)=> s.classList.add('hidden'));
    steps[i].classList.remove('hidden');
  }
  nextBtns.forEach(b=> b.addEventListener('click', e=>{
    if(currentStep < steps.length-1) { currentStep++; showStep(currentStep); }
  }));
  prevBtns.forEach(b=> b.addEventListener('click', e=>{
    if(currentStep > 0) { currentStep--; showStep(currentStep); }
  }));
  if(steps.length) showStep(0);

  // Simple search form (client-side)
  const searchForm = document.getElementById('search-form');
  if(searchForm){
    searchForm.addEventListener('submit', (e)=>{
      e.preventDefault();
      const q = document.getElementById('search-input').value.trim();
      if(q) {
        // navigate to category page and include query param (UI only)
        window.location.href = 'category.html?search=' + encodeURIComponent(q);
      }
    });
  }

  // Simple profile edit toggle
  document.querySelectorAll('.toggle-edit').forEach(btn=>{
    btn.addEventListener('click', ()=> {
      const form = document.getElementById('edit-profile-form');
      if(form) form.classList.toggle('hidden');
    });
  });

});