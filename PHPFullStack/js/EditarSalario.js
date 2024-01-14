document.addEventListener("DOMContentLoaded", function () {
  var formInicio = document.getElementById("formFuncionarioInicio");
  formInicio.addEventListener("submit", function (event) {
    var id = document.getElementById("id");

    // Validar se o ID é um número positivo
    if (id.value <= 0 || isNaN(id.value)) {
      alert("ID deve ser um número positivo.");
      id.value = "";
      event.preventDefault();
    }
  });

  var formFim = document.getElementById("formFuncionarioFim");
  formFim.addEventListener("submit", function (event) {
    var novoSalario = document.getElementById("novo_salario");
    var novoTipoReajuste = document.getElementById("novo_tipo_reajuste");

    // Validar se o salário é um número positivo e maior ou igual a 600
    if (
      novoSalario.value <= 0 ||
      isNaN(novoSalario.value) ||
      novoSalario.value < 600
    ) {
      alert("Novo salário deve ser um número positivo e maior ou igual a 600.");
      novoSalario.value = "";
      event.preventDefault();
    }

    // Validar se o tipo de reajuste é 'redução' ou 'aumento'
    if (
      !["redução", "aumento"].includes(novoTipoReajuste.value.toLowerCase())
    ) {
      alert("Tipo de reajuste inválido. Escolha 'redução' ou 'aumento'.");
      novoTipoReajuste.value = "";
      event.preventDefault();
    }
  });

  // Preencher automaticamente a data atual no campo de data
  var dataReajuste = document.getElementById("nova_data_reajuste");
  var hoje = new Date();
  var dia = hoje.getDate();
  var mes = hoje.getMonth() + 1; // Meses começam do zero
  var ano = hoje.getFullYear();
  var dataFormatada = `${ano}-${mes < 10 ? "0" + mes : mes}-${
    dia < 10 ? "0" + dia : dia
  }`;
  dataReajuste.value = dataFormatada;
});
