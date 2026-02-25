const baseUrl = window.location.origin + '/ws/';

const quill = new Quill('#editor', {
    modules: {
        syntax: true,
        toolbar: '#toolbar-container',
    },
    placeholder: 'Escreva...',
    theme: 'snow',
});

const conteudo = document.getElementById('conteudo').value;
quill.root.innerHTML = conteudo;

document.getElementById("btnEnviar").addEventListener("click", function (e) {
    e.preventDefault();

    const form = document.getElementById("formCaderno");
    document.getElementById("conteudo").value = quill.root.innerHTML;
    document.getElementById("modalSalvo").style.display = "flex";

    const formData = new FormData(form);

    fetch(baseUrl + "wsAdicionarConteudo.php", {
        method: "POST",
        body: formData,
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById("modalSalvo").style.display = "block";
        setTimeout(() => {
            document.getElementById("modalSalvo").style.display = "none";
        }, 2000);
    })
    .catch(error => {
        console.error("Erro:", error);
    });
});

inputBusca.addEventListener("keydown", function(e) {
    if (e.key === "Enter") {
        e.preventDefault();
    }
});


document.getElementById("inputBusca").addEventListener("keyup", function() {

    const termo = this.value.trim().toLowerCase();
    const texto = quill.getText();
    const textoLower = texto.toLowerCase();

    quill.formatText(0, texto.length, { background: false });

    if (!termo) return;

    let palavra = textoLower.indexOf(termo);
    while (palavra !== -1) {
        quill.formatText(palavra, termo.length, { background: "yellow" });
        palavra = textoLower.indexOf(termo, palavra + termo.length);
    }
});