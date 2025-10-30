
// Função que envia o formulário da seccao contacte-nos via AJAX
$("#form-contacto").on("submit", function() {
    var nome = $("#nome").val();
    var email = $("#email").val();
    var mensagem = $("#mensagem").val();

    // Envia a requisição AJAX para o PHP
    $.ajax({
        url: "/tsony/contacte/", // Caminho para o arquivo PHP
        type: "POST",
        data: {
            nome: nome,
            email: email,
            mensagem: mensagem
        },
        dataType: "json",
        success: function(response) {
            // Quando a resposta for recebida, mostramos o alert
            alert(response.message);
        },
        error: function() {
            alert("Ocorreu um erro ao enviar o e-mail.");
        }
    });
});


// Função que envia o formulário de login via AJAX
$("#form-login").on("submit", function() {
    var email = $("#useremail").val();
    var password = $("#userpassword").val();

    // Envia requisicao AJAX para o PHP
    $.ajax({
        url: "/tsony/auth/",
        type: "POST",
        data: {
            email: email,
            password: password
        },
        dataType: "json",
        success: function(response) {
            alert(response.message);
            window.location.href = "admin/";
        }, 
        error: function() {
            alert("ERRO: Falha ao conectar!!! Tente novamente mais tarde");
        }
    })
});