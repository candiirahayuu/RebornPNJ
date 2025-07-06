// Contoh JS jika ingin menambahkan class aktif ke menu saat diklik
document.querySelectorAll('nav a').forEach(link => {
  link.addEventListener('click', function () {
    document.querySelectorAll('nav a').forEach(el => el.classList.remove('active'));
    this.classList.add('active');
  });
});
