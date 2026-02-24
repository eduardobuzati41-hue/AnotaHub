document.addEventListener("DOMContentLoaded", function () {
  (function () {
    const itens = document.querySelectorAll("#tabela-vencidas .comentario"); 
    const btnAnterior = document.getElementById("anterior");
    const btnProximo = document.getElementById("proximo");

    let percorrer = 1;
    const itensPorPagina = 2;
    const totalPaginas = Math.ceil(itens.length / itensPorPagina);

    function mostrarPagina(page) {
      itens.forEach((item, index) => {
        item.style.display =
          index >= (page - 1) * itensPorPagina && index < page * itensPorPagina ? "" : "none";
      });

      btnAnterior.disabled = page === 1;
      btnProximo.disabled = page === totalPaginas;

      if (itens.length === 0) {
        btnAnterior.style.display = "none";
        btnProximo.style.display = "none";
      } else {
        btnAnterior.style.display = "inline-block";
        btnProximo.style.display = "inline-block";
      }
    }

    btnAnterior.addEventListener("click", function () {
      if (percorrer > 1) {
        percorrer--;
        mostrarPagina(percorrer);
      }
    });

    btnProximo.addEventListener("click", function () {
      if (percorrer < totalPaginas) {
        percorrer++;
        mostrarPagina(percorrer);
      }
    });

    mostrarPagina(percorrer);
  })();
});
