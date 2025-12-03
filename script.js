document.addEventListener("DOMContentLoaded", function () {
    const promo = new bootstrap.Modal(document.getElementById('promoModal'));
    promo.show();
});

// Load Footer
fetch("footer.html")
  .then(res => res.text())
  .then(html => {
    document.getElementById("footer-placeholder").innerHTML = html;

    // Jalankan loader info kalau ada
    if (typeof loadInformasi === "function") {
      loadInformasi();
    }
  });

