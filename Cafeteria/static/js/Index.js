document.addEventListener("DOMContentLoaded", function () {
  // Controle de quantidade
  document.addEventListener("click", function (e) {
    if (e.target.classList.contains("increment")) {
      const input = e.target.previousElementSibling;
      input.value = parseInt(input.value) + 1;
      atualizarResumo();
    } else if (e.target.classList.contains("decrement")) {
      const input = e.target.nextElementSibling;
      if (parseInt(input.value) > 0) {
        input.value = parseInt(input.value) - 1;
        atualizarResumo();
      }
    }
  });

  // Atualizar resumo quando quantidade muda
  document.addEventListener("change", function (e) {
    if (e.target.classList.contains("quantidade")) {
      atualizarResumo();
    }
  });

  // Enviar pedido
  document
    .getElementById("pedidoForm")
    .addEventListener("submit", function (e) {
      e.preventDefault();
      enviarPedido();
    });

  function atualizarResumo() {
    const resumo = [];
    let total = 0;

    document.querySelectorAll(".quantidade").forEach((input) => {
      const quantidade = parseInt(input.value);
      if (quantidade > 0) {
        const card = input.closest(".card-body");
        const nome = card.querySelector(".card-title").textContent;
        const precoUnitario = parseFloat(input.dataset.preco);
        const subtotal = quantidade * precoUnitario;

        resumo.push(`${quantidade}x ${nome} - R$ ${subtotal.toFixed(2)}`);
        total += subtotal;
      }
    });

    document.getElementById("resumoPedido").innerHTML =
      resumo.join("<br>") || "Nenhum item selecionado";
    document.getElementById("totalPedido").textContent = total
      .toFixed(2)
      .replace(".", ",");
  }

  function enviarPedido() {
    const nomeCliente = document.getElementById("nomeCliente").value;
    const itens = [];
    let total = 0;

    document.querySelectorAll(".quantidade").forEach((input) => {
      const quantidade = parseInt(input.value);
      if (quantidade > 0) {
        itens.push({
          id: input.dataset.id,
          quantidade: quantidade,
          preco: parseFloat(input.dataset.preco),
        });
        total += quantidade * parseFloat(input.dataset.preco);
      }
    });

    if (itens.length === 0) {
      alert("Selecione pelo menos um item!");
      return;
    }

    if (!nomeCliente) {
      alert("Digite seu nome!");
      return;
    }

    fetch("db/RegistrarPedido.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        nome_cliente: nomeCliente,
        itens: itens,
        total: total,
      }),
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
      })
      .then((data) => {
        if (data.status === "success") {
          alert(`Pedido registrado com sucesso! ID: ${data.pedido_id}`);
          window.location.href = "VisualizarPedidos.php";
        } else {
          throw new Error(data.message || "Erro desconhecido");
        }
      })
      .catch((error) => {
        console.error("Error:", error);
        alert(`Erro ao enviar pedido: ${error.message}`);
      });
  }
});
