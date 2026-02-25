const baseUrl = window.location.origin + '/ws/';

document.addEventListener("DOMContentLoaded", function () {
let comentarioIdSelecionado = null;


function validaNome(n){
    let erroNome = document.getElementById("nameError");
    if(n.trim() === ""){
       erroNome.textContent = "É necessário escrever o nome";
       return false;
   }

   erroNome.textContent = "";
   return true;
}

function validaComentario(c){
    let erroComentario = document.getElementById("comentarioError");
    if(c.trim() === ""){
       erroComentario.textContent = "É necessário escrever o comentário";
       return false;
   }

   erroComentario.textContent = "";
   return true;
}

document.querySelectorAll(".btnExcluir, .btnExcluir3").forEach(btn => {
    btn.addEventListener("click", function (e) {
        e.preventDefault();

        comentarioIdSelecionado = this.getAttribute("data-id");
        document.getElementById("modalD").style.display = "block";
    });
});


document.getElementById("remover").addEventListener("click", function () {
    document.getElementById("modalD").style.display = "none";

    if (!comentarioIdSelecionado) return;

    const formData = new FormData();
    formData.append("id", comentarioIdSelecionado);

    fetch(baseUrl + "wsRemoverComentario.php", {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById("modalE").style.display = "block";
            setTimeout(() => {
                document.getElementById("modalE").style.display = "none";
                location.reload();
            }, 1000);
        } else {
            alert("Erro ao remover a nota.");
        }
    })
    .catch(error => {
        console.error(error);
    });
});

document.getElementById("manter").addEventListener("click", function () {
    document.getElementById("modalD").style.display = "none";
    notaIdSelecionada = null;
});


document.querySelectorAll('.btnResponder').forEach(botao => {
    botao.addEventListener('click', function (e) {
        e.preventDefault();
        document.getElementById("modalDetalhes2").style.display = "block";
        const idComentario = this.getAttribute('data-id'); 
        document.getElementById('id_pai').value = idComentario;
    });
});

const fechar = document.querySelector(".close5");
fechar.addEventListener("click", function () {
    document.getElementById("modalDetalhes2").style.display = "none";
});

const modal = document.getElementById("modalDetalhes2");
modal.addEventListener("click", function (event) {
    if (event.target === modal) {
        modal.style.display = "none";
    }
});

document.getElementById("btnEnviarResposta").addEventListener("click", function(e){
    e.preventDefault();

    const nome = document.getElementById("name_resposta").value;
    const comentario = document.getElementById("comentario_resposta").value;
    const inputData = document.getElementById('data_publicada_resposta');
    const idPai = document.getElementById('id_pai').value; 

    const agora = new Date();
    const ano = agora.getFullYear();
    const mes = String(agora.getMonth() + 1).padStart(2, '0');
    const dia = String(agora.getDate()).padStart(2, '0');
    const hora = String(agora.getHours()).padStart(2, '0');
    const minuto = String(agora.getMinutes()).padStart(2, '0');

    inputData.value = `${ano}/${mes}/${dia} ${hora}:${minuto}`;

    const NomeValido = validaNome(nome);
    const comentarioValido = validaComentario(comentario);

    if (!(NomeValido && comentarioValido)) return;

    let form = document.getElementById("formResposta");
    let formData = new FormData(form);

    formData.append('id_pai', idPai);

    fetch(baseUrl + "wsAdicionarSugestoes.php", {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {

        document.getElementById("modalDetalhes2").style.display = "none";
        let modalSucesso = document.getElementById("modalDetalhes");

        if (data.success) {
            modalSucesso.style.display = "block";

            setTimeout(() => {
                modalSucesso.style.display = "none";
                location.reload()
            }, 1000);
        } 
    })
    .catch(error => console.error(error));
});




document.getElementById("btnEnviar").addEventListener("click", function(e){
    e.preventDefault()

    const nome = document.getElementById("name").value;
    const comentario = document.getElementById("comentario").value;
    const inputData = document.getElementById('data_publicada');
    const agora = new Date();

    const ano = agora.getFullYear();
    const mes = String(agora.getMonth() + 1).padStart(2, '0');
    const dia = String(agora.getDate()).padStart(2, '0');
    const hora = String(agora.getHours()).padStart(2, '0');
    const minuto = String(agora.getMinutes()).padStart(2, '0');

    inputData.value = `${ano}/${mes}/${dia} ${hora}:${minuto}`;

    const NomeValido = validaNome(nome);
    const comentarioValido = validaComentario(comentario);

    if (!(NomeValido && comentarioValido)) {
        return; 
    }

    let form = document.getElementById("registrationForm")

    let formData = new FormData(form)

    fetch(baseUrl + "wsAdicionarSugestoes.php", {
        'method' : 'POST',
        'body' : formData
    })
    .then(response => response.json())
    .then(data => {

        document.getElementById("modalDetalhes2").style.display = "none";
        let modalSucesso = document.getElementById("modalDetalhes");

        if (data.success) {
            modalSucesso.style.display = "block";

            setTimeout(() => {
                modalSucesso.style.display = "none";
                location.reload()
            }, 1000);
        } 

    })
    .catch(error => {
        return console.log(error)
    })
})


});