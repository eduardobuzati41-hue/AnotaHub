const baseUrl = "http://localhost/tcc_smart/ws/";

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

    if(desc.trim()==""){
        erroDesc.textContent = "A descrição deve ser preenchido";
        return false;
    }

    erroDesc.textContent = "";
    return true;
}

document.getElementById("descricao").addEventListener("input", function(c) {
    let desc = this.value; 
  
    if (desc.length > 20) {
      desc = desc.substring(0, 20); 
    }
  
    this.value = desc; 
  });

function validaData(data) {
    let erroData = document.getElementById("dataError");

    if (data.trim() === "") {
        erroData.textContent = "A data deve ser preenchido";
        return false;
    }

    erroData.textContent = "";
    return true;
}

function validaHora(hora) {
    let erroHora = document.getElementById("timeError");
    const dataInput = document.getElementById("data_publicada").value;

    if (hora.trim() === "") {
        erroHora.textContent = "A hora deve ser preenchida";
        return false;
    }

    if (dataInput.trim() === "") {
        erroHora.textContent = "Preencha a data antes da hora";
        return false;
    }

    const dataSelecionada = new Date(`${dataInput}T${hora}`);
    const agora = new Date();

    if (dataSelecionada < agora) {
        erroHora.textContent = "Adicione uma hora valida!";
        return false;
    }

    erroHora.textContent = "";
    return true;
}

document.getElementById("btnNotas").addEventListener("click", function (e) {
    e.preventDefault();

    const desc = document.getElementById("descricao").value;
    const data = document.getElementById("data_publicada").value;
    const hora = document.getElementById("hora_publicada").value;

    const descValido = validaDesc(desc);
    const dataValida = validaData(data);
    const horaValida = validaHora(hora);

    if (!(descValido && dataValida && horaValida)) return;

    let form = document.getElementById("formNotas");
    let formData = new FormData(form);

    fetch(baseUrl + "wsAdicionarNota.php", {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);

        if (data.success) {
            document.getElementById("modalR").style.display = "block";

            document.getElementById("descricao").value = "";
            document.getElementById("data_publicada").value = "";
            document.getElementById("hora_publicada").value = "";

            setTimeout(() => {
                document.getElementById("modalR").style.display = "none";
                location.reload();
            }, 1000);

            document.getElementById("modalDetalhes").style.display = "none";
        } else {
            console.error("Erro do servidor:", data.message);
            alert("Erro ao cadastrar a nota.");
        }
    })
    .catch(error => {
        console.error("Erro de conexão:", error);
        alert("Erro ao tentar enviar a nota.");
    });
});

document.querySelectorAll(".btnExcluir").forEach(btn => {
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

            fetch(baseUrl + "wsRemoverNota.php", {
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
    btn.addEventListener("click", function () {
        const row = this.closest("tr");
        const id = this.dataset.id;
        const titulo = row.cells[1].innerText.trim();
        const dataTexto = row.cells[2].innerText.trim();
        const hora = row.cells[3].innerText.trim();

        const partes = dataTexto.split("/");
        const dataFormatada = `${partes[2]}-${partes[1]}-${partes[0]}`;

        document.getElementById("notaId").value = id;
        document.getElementById("descricaoAtualizar").value = titulo;
        document.getElementById("dataAtualizar").value = dataFormatada;
        document.getElementById("horaAtualizar").value = hora;

        document.getElementById("modalAtualizar").style.display = "block";
    });
});

function validaDescAtualizar(desc) {
    let erroDesc = document.getElementById("descErrorAtualizar");
    if(desc.trim() === ""){
        erroDesc.textContent = "A descrição deve ser preenchida";
        return false;
    }
    erroDesc.textContent = "";
    return true;
}

function validaDataAtualizar(data) {
    let erroData = document.getElementById("dataErrorAtualizar");
    if(data.trim() === ""){
        erroData.textContent = "A data deve ser preenchida";
        return false;
    }
    erroData.textContent = "";
    return true;
}

function validaHoraAtualizar(hora) {
    let erroHora = document.getElementById("timeErrorAtualizar");
    const dataInput = document.getElementById("dataAtualizar").value;

    if (hora.trim() === "") {
        erroHora.textContent = "A hora deve ser preenchida";
        return false;
    }

    if (dataInput.trim() === "") {
        erroHora.textContent = "Preencha a data antes da hora";
        return false;
    }

    const dataSelecionada = new Date(`${dataInput}T${hora}`);
    const agora = new Date();

    if (dataSelecionada < agora) {
        erroHora.textContent = "Adicione uma hora valida!";
        return false;
    }

    erroHora.textContent = "";
    return true;
}

document.getElementById("formAtualizar").addEventListener("submit", function(e){
    e.preventDefault();

    const id = document.getElementById("notaId").value;
    const descricao = document.getElementById("descricaoAtualizar").value;
    const data = document.getElementById("dataAtualizar").value;
    const hora = document.getElementById("horaAtualizar").value;

    if (!(validaDescAtualizar(descricao) && validaDataAtualizar(data) && validaHoraAtualizar(hora))) return;

    let formData = new FormData();
    formData.append("id", id);
    formData.append("descricao", descricao);
    formData.append("data_publicada", data);
    formData.append("hora_publicada", hora);

    fetch(baseUrl + "wsAtualizarAgenda.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if(data.success){
            document.getElementById("modalC").style.display = "block";
            setTimeout(() => {
                document.getElementById("modalC").style.display = "none";
                location.reload();
            }, 1000);
            document.getElementById("modalAtualizar").style.display = "none";
        } else {
            alert("Erro ao atualizar: " + data.message);
        }
    })
    .catch(erro => {
        console.error("Erro ao atualizar:", erro);
    });
});

document.querySelector(".close2").addEventListener("click", function () {
    document.getElementById("modalAtualizar").style.display = "none";
});

document.getElementById("modalAtualizar").addEventListener("click", function(event){
    if(event.target === this){
        this.style.display = "none";
    }
});