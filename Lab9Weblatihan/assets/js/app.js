// assets/js/app.js — interaksi: menu mobile, konfirmasi hapus, flash, pratinjau gambar.
(function () {
  var side = document.getElementById('side'), burger = document.getElementById('burger');
  if (burger && side) {
    burger.addEventListener('click', function () { side.classList.toggle('open'); });
    document.addEventListener('click', function (e) {
      if (side.classList.contains('open') && !side.contains(e.target) && !burger.contains(e.target)) side.classList.remove('open');
    });
  }
  // Konfirmasi sebelum form hapus dikirim
  document.querySelectorAll('form[data-confirm]').forEach(function (f) {
    f.addEventListener('submit', function (e) { if (!window.confirm(f.getAttribute('data-confirm'))) e.preventDefault(); });
  });
  // Tutup flash; flash sukses hilang otomatis
  document.querySelectorAll('.flash').forEach(function (el) {
    var x = el.querySelector('.x');
    if (x) x.addEventListener('click', function () { el.remove(); });
    if (el.classList.contains('success')) setTimeout(function () { el.style.transition = 'opacity .4s'; el.style.opacity = '0'; setTimeout(function () { el.remove(); }, 400); }, 4500);
  });
  // Pratinjau gambar sebelum diunggah
  var file = document.getElementById('file_gambar'), prev = document.getElementById('preview');
  if (file && prev) file.addEventListener('change', function () {
    var f = file.files[0];
    if (!f || !/^image\//.test(f.type)) return;
    var img = document.createElement('img'); img.className = 'thumb'; img.alt = 'Pratinjau';
    img.src = URL.createObjectURL(f); prev.innerHTML = ''; prev.appendChild(img);
  });
})();
