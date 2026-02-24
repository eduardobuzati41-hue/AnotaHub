const usuarioId = document.body.dataset.usuario;

document.querySelectorAll(".btn-check").forEach(btn => {
    btn.addEventListener("change", function () {
        const cadernoId = this.id.replace("btn-fav-", "");
        const favoritar = this.checked ? 1 : 0;

        const formData = new FormData();
        formData.append("caderno_id", cadernoId);
        formData.append("favoritar", favoritar);
        formData.append("usuario_id", usuarioId);

        fetch(baseUrl + "wsFavoritar.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            location.reload();
            if (!data.success) {
                alert("Erro ao atualizar favorito!");
                this.checked = !this.checked; 
            }
        })
        .catch(err => {
            console.error(err);
            this.checked = !this.checked; 
        });
    });
});
