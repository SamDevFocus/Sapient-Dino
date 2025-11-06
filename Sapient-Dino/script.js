document.addEventListener("DOMContentLoaded", () => {
  const menuItems = document.querySelectorAll(".menu li");

  // Função para atualizar qual link está ativo conforme a página atual
  const currentPath = window.location.pathname.split("/").pop();
  menuItems.forEach((item) => {
    const link = item.querySelector("a");
    if (link.getAttribute("href") === currentPath) {
      item.classList.add("active");
    } else {
      item.classList.remove("active");
    }
  });

  // Clique no menu
  menuItems.forEach((item) => {
    item.addEventListener("click", (e) => {
      e.preventDefault(); // impede mudança imediata

      // Remove "active" de todos e adiciona no clicado
      menuItems.forEach((i) => i.classList.remove("active"));
      item.classList.add("active");

      // Animação do ícone
      const icon = item.querySelector("i");
      icon.style.transition = "transform 0.2s ease";
      icon.style.transform = "scale(1.2)";
      setTimeout(() => {
        icon.style.transform = "scale(1)";
      }, 200);

      // Depois de 250ms, vai pra página
      const link = item.querySelector("a");
      setTimeout(() => {
        window.location.href = link.getAttribute("href");
      }, 250);
    });
  });

  // Efeito de highlight (brilho no hover)
  menuItems.forEach((item) => {
    item.addEventListener("mouseenter", (e) => {
      const existing = item.querySelector(".highlight");
      if (existing) existing.remove();

      const highlight = document.createElement("div");
      highlight.classList.add("highlight");
      highlight.style.position = "absolute";
      highlight.style.inset = "0";
      highlight.style.borderRadius = "16px";
      highlight.style.background =
        `radial-gradient(circle at ${e.offsetX}px ${e.offsetY}px, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0) 70%)`;
      highlight.style.pointerEvents = "none";
      highlight.style.transition = "opacity 0.3s ease";

      item.style.position = "relative";
      item.appendChild(highlight);

      setTimeout(() => {
        highlight.style.opacity = "0";
        setTimeout(() => highlight.remove(), 300);
      }, 400);
    });
  });
});
