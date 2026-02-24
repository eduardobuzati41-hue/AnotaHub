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

document.getElementById("nome").addEventListener("input", function(c) {
    let desc = this.value; 
  
    if (desc.length > 20) {
      desc = desc.substring(0, 20); 
    }
  
    this.value = desc; 
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


document.getElementById("btnCadernos").addEventListener("click", function (e) {
    e.preventDefault();

    const desc = document.getElementById("nome").value;
    const cor = document.getElementById("cor").value;

    const descValido = validaDesc(desc);

    if (!(descValido && cor)) return;

    let form = document.getElementById("formCadernos");
    let formData = new FormData(form);

    fetch(baseUrl + "wsAdicionarCaderno.php", {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);

        if (data.success) {
            document.getElementById("modalC").style.display = "block";

            document.getElementById("nome").value = "";

            setTimeout(() => {
                document.getElementById("modalC").style.display = "none";
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


 
