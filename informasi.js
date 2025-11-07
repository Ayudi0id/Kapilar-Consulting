document.addEventListener("DOMContentLoaded", () => {
  fetch("data/informasi.json")
    .then(res => res.json())
    .then(data => {
      const list = document.getElementById("informasi-list");
      list.innerHTML = ""; // Clear existing content
      data.articles.forEach(article => {
        const li = document.createElement("li");
        li.innerHTML = `<a href="${article.link}" class="text-light text-decoration-none">${article.title}</a>`;
        list.appendChild(li);
      });
    })
    .catch(err => console.error("Gagal memuat informasi:", err));
});
