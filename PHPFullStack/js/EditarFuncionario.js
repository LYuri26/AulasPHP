document.addEventListener("DOMContentLoaded", function () {
  var form = document.getElementById("formFuncionario");

  form.addEventListener("submit", function (event) {
    if (!validacaoFormulario()) {
      event.preventDefault();
    }
  });

  function validacaoFormulario() {
    var nome = form.elements["nome"];
    var cargo = form.elements["cargo"];
    var departamento = form.elements["departamento"];

    // Verifica se os campos não estão vazios
    if (
      nome.value.trim() === "" ||
      cargo.value.trim() === "" ||
      departamento.value.trim() === ""
    ) {
      alert("Por favor, preencha todos os campos.");
      return false;
    }

    // Verifica se os campos contêm apenas letras, números, espaço, ´, ^, `, ~
    var regexPermitidos = /^[a-zA-Z0-9\s´^`~]+$/;

    if (
      !regexPermitidos.test(nome.value) ||
      !regexPermitidos.test(cargo.value) ||
      !regexPermitidos.test(departamento.value)
    ) {
      alert("Por favor, remova caracteres inválidos.");
      return false;
    }

    return true;
  }
});
