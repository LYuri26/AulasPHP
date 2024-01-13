document.addEventListener("DOMContentLoaded", function () {
  var form = document.getElementById("formFuncionario");

  form.addEventListener("submit", function (event) {
    if (!validacaoFormulario()) {
      event.preventDefault();
    }
  });

  function validacaoFormulario() {
    var nome = document.getElementById("nome");
    var cargo = document.getElementById("cargo");
    var departamento = document.getElementById("departamento");

    // Verifica se os campos contêm apenas letras, números, espaço, ´, ^, `, ~
    var regexPermitidos = /^[a-zA-Z0-9\s´^`~]+$/;

    if (
      !regexPermitidos.test(nome.value) ||
      !regexPermitidos.test(cargo.value) ||
      !regexPermitidos.test(departamento.value)
    ) {
      alert("Por favor, remova caracteres inválidos.");

      // Limpa os campos inválidos
      nome.value = "";
      cargo.value = "";
      departamento.value = "";

      return false;
    }

    return true;
  }
});
