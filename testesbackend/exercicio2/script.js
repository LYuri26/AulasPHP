document.getElementById("formulario").addEventListener("submit", function (e) {
  e.preventDefault();
  const id = document.getElementById("produtoId").value;

  if (id <= 0) {
    document.getElementById("resultado").innerHTML = "ID inválido.";
    return;
  }

  fetch("produto.php?id=" + encodeURIComponent(id))
    .then((res) => {
      if (!res.ok) throw new Error("Erro ao consultar produto.");
      return res.text();
    })
    .then((data) => {
      document.getElementById("resultado").innerHTML = data;
    })
    .catch((err) => {
      document.getElementById("resultado").innerHTML = "Erro: " + err.message;
    });
});
