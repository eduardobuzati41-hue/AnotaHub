document.querySelectorAll("input[id^='btn-ocult-']").forEach(btn => {
    btn.addEventListener("change", function () {
        const cadernoId = this.id.replace("btn-ocult-", "");
        const ocultar = this.checked ? 1 : 0;

        const formData = new FormData();
        formData.append("caderno_id", cadernoId);
        formData.append("ocultar", ocultar);
        formData.append("usuario_id", usuarioId);

        fetch(baseUrl + "wsOcultar.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            location.reload();
            if (!data.success) {
                alert("Erro ao ocultar!");
                this.checked = !this.checked;
            }
        })
        .catch(err => {
            console.error(err);
            this.checked = !this.checked;
        });
    });
});
