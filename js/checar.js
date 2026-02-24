const usuarioId = document.body.dataset.usuario;

document.querySelectorAll(".chkConcluido").forEach(chk => {
    chk.addEventListener("change", function() {
        const notaId = this.dataset.id;
        const concluido = this.checked ? 1 : 0;

        let formData = new FormData();
        formData.append("id", notaId);
        formData.append("concluido", concluido);
        formData.append("usuario_id", usuarioId);

        fetch(baseUrl + "wsConcluirNota.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {

             if (!data.success) {
                alert("Erro ao checar!");
                this.checked = !this.checked;
            } else {
                location.href = location.href;
            }
        })
        .catch(err => {
            console.error(err);
            this.checked = !this.checked;
        });
    });
});
