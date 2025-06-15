document.addEventListener('DOMContentLoaded', () => {
  const burger = document.querySelector('.nav-toggle');
  const nav    = document.querySelector('.site-nav');
  if (!burger || !nav) return;
  burger.addEventListener('click', () => {
    burger.classList.toggle('open');
    nav.classList.toggle('open');
  });
});
