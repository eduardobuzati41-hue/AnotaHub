const baseUrl = window.location.origin + '/ws/';

document.getElementById("btnEnviar").addEventListener("click", function (e) {
    e.preventDefault();
    document.getElementById("modalDetalhes").style.display = "block";
});

const fechar = document.querySelector(".close");
fechar.addEventListener("click", function () {
    document.getElementById("modalDetalhes").style.display = "none";
});

const modal = document.getElementById("modalDetalhes");
modal.addEventListener("click", function (event) {
    if (event.target === modal) {
        modal.style.display = "none";
    }
});

function validaDesc(desc) {
    let erroDesc = document.getElementById("descError");

    if (desc.trim() == "") {
        erroDesc.textContent = "A descrição deve ser preenchido";
        return false;
    }

    erroDesc.textContent = "";
    return true;
}

document.getElementById("descricao").addEventListener("input", function (c) {
    let desc = this.value;

    if (desc.length > 20) {
        desc = desc.substring(0, 20);
    }

    this.value = desc;
});

function validalink(link) {
    let erroLink = document.getElementById("linkError");

    if (link.trim() == "") {
        erroLink.textContent = "o link deve ser preenchido";
        return false;
    }

    erroLink.textContent = "";
    return true;
}

document.getElementById("link").addEventListener("input", function (c) {
    let link = this.value;

    if (link.length > 100) {
        link = link.substring(0, 100);
    }

    this.value = link;
});

function validaMateria(materia) {
    let erroMateria = document.getElementById("materiaError");

    if (materia.trim() == "") {
        erroMateria.textContent = "A matéria deve ser preenchida";
        return false;
    }

    erroMateria.textContent = "";
    return true;
}


document.getElementById("btnVideos").addEventListener("click", function (e) {
    e.preventDefault();

    const desc = document.getElementById("descricao").value;
    const link = document.getElementById("link").value;
    const materia = document.getElementById("materia").value;

    const descValido = validaDesc(desc);
    const linkValido = validalink(link);
    const materiaValida = validaMateria(materia);

    if (!(descValido && linkValido && materiaValida)) return;

    let form = document.getElementById("formVideos");
    let formData = new FormData(form);

    fetch(baseUrl + "wsAdicionarVideo.php", {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            console.log(data);

            if (data.success) {
                document.getElementById("modalR").style.display = "block";

                document.getElementById("descricao").value = "";
                document.getElementById("link").value = "";
                document.getElementById("materia").value = "";

                setTimeout(() => {
                    document.getElementById("modalR").style.display = "none";
                    location.reload();
                }, 1000);

                document.getElementById("modalDetalhes").style.display = "none";
            } else {
                console.error("Erro do servidor:", data.message);
                alert("Erro ao cadastrar o video.");
            }
        })
        .catch(error => {
            console.error("Erro de conexão:", error);
            alert("Erro ao tentar enviar o video.");
        });
});

document.querySelectorAll(".btnExcluir2").forEach(btn => {
    btn.addEventListener("click", function (e) {
        e.preventDefault();
    
        document.getElementById("modalD").style.display = "block";

        const notaId = this.getAttribute("data-id");

        const remover = document.getElementById("remover");
        const manter = document.getElementById("manter");

        remover.addEventListener("click", function () {
            document.getElementById("modalD").style.display = "none";

            let formData = new FormData();
            formData.append("id", notaId);

            fetch(baseUrl + "wsRemoverVideo.php", {
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
                        location.href = location.href;
                    }, 1000);
                } else {
                    console.error("Erro do servidor:", data.message);
                    alert("Erro ao remover o video.");
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
