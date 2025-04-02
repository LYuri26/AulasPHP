// Funções de Controle do Carrinho
function incrementarContador(botao) {
  const item = botao.closest(".item-cardapio");
  if (!item) return;

  const contador = item.querySelector(".contador span");
  if (contador) {
    const valorAtual = parseInt(contador.textContent) || 0;
    contador.textContent = valorAtual + 1;
    atualizarTotalPedido();
  }
}

function decrementarContador(botao) {
  const item = botao.closest(".item-cardapio");
  if (!item) return;

  const contador = item.querySelector(".contador span");
  if (contador) {
    const valorAtual = parseInt(contador.textContent) || 0;
    if (valorAtual > 0) {
      contador.textContent = valorAtual - 1;
      atualizarTotalPedido();
    }
  }
}

function atualizarTotalPedido() {
  let total = 0;
  const checkboxes = document.querySelectorAll('input[name="pedido"]');

  checkboxes.forEach((checkbox) => {
    const item = checkbox.closest(".item-cardapio");
    if (!item) return;

    const preco = parseFloat(checkbox.value) || 0;
    const contador = item.querySelector(".contador span");
    const quantidade = contador ? parseInt(contador.textContent) || 0 : 0;

    if (checkbox.checked) {
      total += preco * quantidade;
      item.querySelector(".subtrair").disabled = false;
      item.querySelector(".somar").disabled = false;
    } else {
      item.querySelector(".subtrair").disabled = true;
      item.querySelector(".somar").disabled = true;
      if (contador) contador.textContent = "0";
    }
  });

  const totalElement = document.getElementById("total");
  if (totalElement) {
    totalElement.textContent = `Total: R$ ${total.toFixed(2)}`;
  }
}

function limparCarrinho() {
  const checkboxes = document.querySelectorAll('input[name="pedido"]');
  checkboxes.forEach((checkbox) => {
    checkbox.checked = false;
    const item = checkbox.closest(".item-cardapio");
    if (item) {
      item.querySelector(".contador span").textContent = "0";
      item.querySelector(".subtrair").disabled = true;
      item.querySelector(".somar").disabled = true;
    }
  });
  atualizarTotalPedido();
}

// Funções de Efeitos Visuais
function iniciarEfeitoPulsante() {
  const imagens = document.querySelectorAll(".item-cardapio img");

  function pulsar() {
    imagens.forEach((img) => {
      img.style.transition = "transform 0.5s";
      img.style.transform = "scale(1.03)";
      setTimeout(() => (img.style.transform = "scale(1.0)"), 500);
    });
  }

  setInterval(pulsar, 3000);
}

// Função de Envio do Pedido com prevenção de duplo clique
async function enviarPedido() {
  const botaoEnviar = document.getElementById("enviar");
  if (!botaoEnviar) return;

  // Desabilita o botão para evitar múltiplos cliques
  botaoEnviar.disabled = true;

  try {
    const totalElement = document.getElementById("total");
    if (!totalElement) return;

    const total =
      parseFloat(
        totalElement.textContent.replace("Total: R$ ", "").replace(",", ".")
      ) || 0;

    // Validação do total
    if (total <= 0) {
      alert("Selecione pelo menos um item antes de enviar o pedido.");
      return;
    }

    // Coleta e validação dos itens
    const itens = Array.from(
      document.querySelectorAll('input[name="pedido"]:checked')
    ).map((checkbox) => {
      const item = checkbox.closest(".item-cardapio");
      const quantidade =
        parseInt(item.querySelector(".contador span")?.textContent) || 0;

      return {
        nome: item.querySelector("h2")?.textContent || "",
        quantidade: quantidade,
        preco: parseFloat(checkbox.value) || 0,
      };
    });

    // Verifica se há pelo menos um item com quantidade > 0
    const itensValidos = itens.filter((item) => item.quantidade > 0);
    if (itensValidos.length === 0) {
      alert("Pelo menos um item deve ter quantidade maior que zero.");
      return;
    }

    // Confirmação para pedidos grandes
    if (
      total > 600 &&
      !confirm("Tem certeza disso? Vai alimentar um batalhão?")
    ) {
      limparCarrinho();
      return;
    }

    // Envia apenas os itens com quantidade > 0
    const response = await fetch("/db/Registrar_Pedido.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({
        total: total.toFixed(2),
        itens: itensValidos,
      }),
    });

    if (response.ok) {
      alert(`Pedido de R$ ${total.toFixed(2)} enviado com sucesso!`);
      limparCarrinho();
    } else {
      throw new Error(await response.text());
    }
  } catch (error) {
    console.error("Erro:", error);
    alert("Erro ao enviar pedido. Tente novamente.");
  } finally {
    // Reabilita o botão após o processamento
    botaoEnviar.disabled = false;
  }
}

// Inicialização
document.addEventListener("DOMContentLoaded", () => {
  // Remove os event listeners inline do HTML para evitar duplicação
  document
    .querySelectorAll(".subtrair[onclick], .somar[onclick]")
    .forEach((botao) => {
      botao.removeAttribute("onclick");
    });

  // Configura eventos dos botões de quantidade
  document.querySelectorAll(".subtrair").forEach((botao) => {
    botao.addEventListener("click", function () {
      decrementarContador(this);
    });
  });

  document.querySelectorAll(".somar").forEach((botao) => {
    botao.addEventListener("click", function () {
      incrementarContador(this);
    });
  });

  // Configura eventos dos checkboxes
  document.querySelectorAll('input[name="pedido"]').forEach((checkbox) => {
    checkbox.addEventListener("change", atualizarTotalPedido);
  });

  // Configura botão de enviar (apenas um listener)
  const botaoEnviar = document.getElementById("enviar");
  if (botaoEnviar) {
    // Remove o onclick do HTML para evitar duplicação
    botaoEnviar.removeAttribute("onclick");
    botaoEnviar.addEventListener("click", enviarPedido);
  }

  // Inicia efeitos visuais
  iniciarEfeitoPulsante();
});
