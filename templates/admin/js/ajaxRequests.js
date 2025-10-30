document.getElementById("logoutButton").addEventListener("click", function () {
    // Faz uma requisição AJAX para o script PHP
    fetch("/tsony/logout/", {
        method: "POST",
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Redireciona o usuário após destruir a sessão
            window.location.href = "/tsony";
        } else {
            console.error("Falha ao encerrar a sessão.");
        }
    })
    .catch(error => console.error("Erro:", error));
});
