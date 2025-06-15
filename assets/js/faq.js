document.addEventListener('click', function (e) {
	if (!e.target.closest('.faq__question')) return;

	const btn     = e.target.closest('.faq__question');
	const answer  = btn.nextElementSibling;
	const expanded = btn.getAttribute('aria-expanded') === 'true';

	btn.setAttribute('aria-expanded', !expanded);
	answer.hidden = expanded;
});
