document.addEventListener("DOMContentLoaded", function () {
  var form = document.getElementById("formFuncionario");
  var dataReajuste = document.getElementById("data_reajuste");

  // Preencher automaticamente a data atual no formulário (horário local do navegador)
  var hoje = new Date();
  var dataFormatada =
    hoje.getFullYear() +
    "-" +
    ("0" + (hoje.getMonth() + 1)).slice(-2) +
    "-" +
    ("0" + hoje.getDate()).slice(-2);
  dataReajuste.value = dataFormatada;

  form.addEventListener("submit", function (event) {
    if (!validacaoFormulario()) {
      event.preventDefault();
    }
  });

  function validacaoFormulario() {
    var id = document.getElementById("id");
    var salario = document.getElementById("salario");
    var tipoReajuste = document.getElementById("tipo_reajuste");

    if (
      [id, salario, tipoReajuste].some((campo) => campo.value.trim() === "")
    ) {
      alert("Por favor, preencha todos os campos.");
      return false;
    }

    if (id.value < 0 || isNaN(id.value)) {
      alert("ID deve ser um número positivo.");
      id.value = "";
      return false;
    }

    if (salario.value < 0 || isNaN(salario.value) || salario.value < 600) {
      alert("Salário deve ser um número positivo e maior ou igual a 600.");
      salario.value = "";
      return false;
    }

    var regexPermitidos = /^[a-zA-Z0-9\s´^`~,]+$/;

    if (
      ![id, tipoReajuste].every((campo) => regexPermitidos.test(campo.value))
    ) {
      alert("Por favor, remova caracteres inválidos.");
      tipoReajuste.value = "";
      return false;
    }

    return true;
  }
});
