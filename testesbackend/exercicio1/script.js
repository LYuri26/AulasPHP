document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("formulario");

  form.addEventListener("submit", function (evento) {
    let nome = document.querySelector('input[name="nome"]').value;
    let email = document.querySelector('input[name="email"]').value;
    let idade = document.getElementById("idade").value;
    let senha = document.getElementById("senha").value;
    let termos = document.querySelector('input[type="checkbox"]').checked;

    if (nome.length < 3) {
      alert("O nome deve conter pelo menos 3 caracteres!");
      evento.preventDefault();
    }

    if (email == "") {
      alert("Preencha o email!");
      evento.preventDefault();
    }

    if (idade < 18) {
      alert("Você precisa ter pelo menos 18 anos para se cadastrar.");
      evento.preventDefault();
    }

    if (senha.length < 6) {
      alert("A senha precisa ter no mínimo 6 caracteres.");
      evento.preventDefault();
    }

    if (termos === false) {
      alert("Você precisa aceitar os termos de uso!");
      evento.preventDefault();
    }

    alert("Cadastro enviado com sucesso!");
  });

  $("#meuModal").modal("show");
});
