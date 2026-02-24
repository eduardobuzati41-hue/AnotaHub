document.addEventListener("DOMContentLoaded", function () {
  (function () {
    const itens = document.querySelectorAll("#tabela-vencidas tbody tr");
    const btnAnterior = document.getElementById("anterior");
    const btnProximo = document.getElementById("proximo");

    let percorrer = 1;
    const itensporpagina = 3;
    const totalPaginas = Math.ceil(itens.length / itensporpagina);

    function mostrarPagina(page) {
      itens.forEach((item, index) => {
        item.style.display =
          index >= (page - 1) * itensporpagina && index < page * itensporpagina ? "" : "none";
      });

      const linhasVisiveis = Array.from(itens).filter(item => item.style.display !== "none");

      if (linhasVisiveis.length === 0) {
        btnAnterior.style.display = "none";
        btnProximo.style.display = "none";

      } else {
        btnAnterior.style.display = "inline-block";
        btnProximo.style.display = "inline-block";
      }

      btnAnterior.disabled = page === 1;
      btnProximo.disabled = page === totalPaginas;
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

  (function () {
    const itens = document.querySelectorAll("#tabela-hoje tbody tr");
    const btnAnterior = document.getElementById("anterior2");
    const btnProximo = document.getElementById("proximo2");

    let percorrer = 1;
    const itensporpagina = 4;
    const totalPaginas = Math.ceil(itens.length / itensporpagina);

    function mostrarPagina(page) {
      itens.forEach((item, index) => {
        item.style.display =
          index >= (page - 1) * itensporpagina && index < page * itensporpagina
            ? ""
            : "none";
      });

      const linhasVisiveis = Array.from(itens).filter(item => item.style.display !== "none");

      if (linhasVisiveis.length === 0) {
        btnAnterior.style.display = "none";
        btnProximo.style.display = "none";
      } else {
        btnAnterior.style.display = "inline-block";
        btnProximo.style.display = "inline-block";
      }

      btnAnterior.disabled = page === 1;
      btnProximo.disabled = page === totalPaginas;
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
