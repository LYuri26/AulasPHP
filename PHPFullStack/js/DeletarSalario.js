document.addEventListener("DOMContentLoaded", function () {
  var formInicio = document.getElementById("formFuncionario");
  formInicio.addEventListener("submit", function (event) {
    var id = document.getElementById("id");

    // Validar se o ID é um número positivo
    if (id.value <= 0 || isNaN(id.value)) {
      alert("ID deve ser um número positivo.");
      id.value = "";
      event.preventDefault();
    }
  });
});
