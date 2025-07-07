document.addEventListener("DOMContentLoaded", () => {
  const tarjetas = document.querySelectorAll('.animar');

  const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
      }
    });
  }, {
    threshold: 0.1
  });

  tarjetas.forEach(t => observer.observe(t));
});
