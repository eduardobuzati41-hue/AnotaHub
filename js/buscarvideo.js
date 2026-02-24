document.querySelectorAll(".caderno-option").forEach(video => {
   
    video.addEventListener("click", function (e) {

        e.preventDefault();

        const cadernoId = this.dataset.id;

        console.log("ID do caderno clicado:", cadernoId);

        fetch(baseUrl + "wsBuscarVideo.php?id=" + cadernoId)

            .then(response => response.json())
            .then(data => {
                location.reload();
                console.log("Vídeos recebidos:", data);
            })

            .catch(err => console.error("Erro:", err));
    });
});
