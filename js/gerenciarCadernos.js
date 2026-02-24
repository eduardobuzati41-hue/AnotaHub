document.getElementById("gerenciar").addEventListener("click", function (e) {
    e.preventDefault();

    const modal = document.getElementById("modalG"); 
    modal.style.display = "block";

    document.querySelectorAll(".btnExcluir").forEach(btn => {
        btn.addEventListener("click", function (e) {
            e.preventDefault();
        
            document.getElementById("modalG").style.display = "none";

            document.getElementById("modalD").style.display = "block";

            const materiaId = this.getAttribute("data-id");

            const remover = document.getElementById("remover");
            const manter = document.getElementById("manter");

            remover.addEventListener("click", function () {
                document.getElementById("modalD").style.display = "none";

                let formData = new FormData();
                formData.append("id", materiaId);

                fetch(baseUrl + "wsRemoverMateria.php", {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    if (data.success) {

                        document.getElementById("modalE").style.display = "block";
                        setTimeout(() => {
                            document.getElementById("modalE").style.display = "none";
                            location.reload();
                        }, 1000);
                        
                    } else {
                        console.error("Erro do servidor:", data.message);
                        alert("Erro ao remover a nota.");
                    }
                })
                .catch(error => {
                    console.log(error);
                });
            });

            manter.addEventListener("click", function () {
                document.getElementById("modalD").style.display = "none";
            });
        });
    });

    document.querySelectorAll(".btnAtualizar").forEach(btn => {
        btn.addEventListener("click", function (e) {
            e.preventDefault();

            const materiaId = this.getAttribute("data-id");
            const nomeMateria = this.closest("tr").querySelector("td").innerText;

            document.getElementById("idMateria").value = materiaId;
            document.getElementById("nomeEditar").value = nomeMateria;

            document.getElementById("modalG").style.display = "none";
            document.getElementById("modalDetalhes2").style.display = "block";
        });
    });


    document.getElementById("formEditarCaderno").addEventListener("submit", function (e) {
        e.preventDefault();

        const materiaId = document.getElementById("idMateria").value;
        const novoNome = document.getElementById("nomeEditar").value;
        const novaCor = document.getElementById("corEditar").value;

        let formData = new FormData();
        formData.append("id", materiaId);
        formData.append("nome", novoNome);
        formData.append("cor", novaCor);

            fetch(baseUrl + "wsAtualizarMateria.php", {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
            if (data.success) {
                document.getElementById("modalDetalhes2").style.display = "none";
                document.getElementById("modalH").style.display = "block";

                setTimeout(() => {
                document.getElementById("modalH").style.display = "none";
                location.reload();
                }, 1000);
            } else {
                alert("Erro: " + data.Mensagem);
            }
            })
            .catch(error => {
            console.error("Erro ao atualizar:", error);
        });
    });


    const fechar1 = document.querySelector(".close3");

    fechar1.addEventListener("click", function () {
        document.getElementById("modalG").style.display = "none";
    });

    const modal3 = document.getElementById("modalG");
    modal3.addEventListener("click", function (event) {
        if (event.target === modal3) {
            modal3.style.display = "none";
        }
    });

    const fechar = document.querySelector(".close2");

    fechar.addEventListener("click", function () {
        document.getElementById("modalDetalhes2").style.display = "none";
    });

    const modal2 = document.getElementById("modalDetalhes2");
    modal2.addEventListener("click", function (event) {
        if (event.target === modal2) {
            modal2.style.display = "none";
        }
    });
});


