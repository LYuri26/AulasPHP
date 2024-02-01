// Função para formatar número para duas casas decimais
function formatarDuasCasasDecimais(numero) {
  return parseFloat(numero).toFixed(2); // Converte o número para ponto flutuante e formata para duas casas decimais
}

// Função para incrementar o contador de um item no carrinho
function incrementarContador(item) {
  var contador = item.querySelector(".contador span"); // Seleciona o elemento do contador dentro do item
  if (contador) {
    var valorAtual = parseInt(contador.textContent); // Obtém o valor atual do contador convertendo para número inteiro
    contador.textContent = valorAtual + 1; // Incrementa o contador em 1
    atualizarTotalPedido(); // Atualiza o total do pedido após incrementar o contador
  }
}

// Função para decrementar o contador de um item no carrinho
function decrementarContador(item) {
  var contador = item.querySelector(".contador span"); // Seleciona o elemento do contador dentro do item
  if (contador) {
    var valorAtual = parseInt(contador.textContent); // Obtém o valor atual do contador convertendo para número inteiro
    if (valorAtual > 0) {
      contador.textContent = valorAtual - 1; // Decrementa o contador em 1 se o valor atual for maior que zero
      atualizarTotalPedido(); // Atualiza o total do pedido após decrementar o contador
    }
  }
}

// Função para limpar e bloquear checkboxes
function checarCheckboxes() {
  var checkboxes = document.querySelectorAll('input[name="pedido"]'); // Seleciona todos os checkboxes com o nome "pedido"
  checkboxes.forEach(function (checkbox) {
    checkbox.checked = false; // Desmarca todos os checkboxes
    var item = checkbox.closest(".item-cardapio"); // Encontra o item do cardápio mais próximo do checkbox
    item.querySelector(".contador span").textContent = "0"; // Define o contador do item como zero
    item.querySelector(".subtrair").disabled = true; // Desativa o botão de subtrair do item
    item.querySelector(".somar").disabled = true; // Desativa o botão de somar do item
  });

  atualizarTotalPedido(); // Atualiza o total do pedido após limpar os checkboxes
}

// Função para atualizar o total do pedido com base nos itens selecionados
function atualizarTotalPedido() {
  var total = 0; // Inicializa o total como zero
  var checkboxes = document.querySelectorAll(".checar"); // Seleciona todos os checkboxes marcados

  checkboxes.forEach(function (checkbox) {
    var preco = parseFloat(checkbox.value); // Obtém o preço do item convertendo para ponto flutuante
    var item = checkbox.closest(".item-cardapio"); // Encontra o item do cardápio mais próximo do checkbox
    var quantidadeElement = item.querySelector(".contador span"); // Seleciona o elemento do contador dentro do item
    var quantidade = parseInt(quantidadeElement.textContent); // Obtém a quantidade do item convertendo para número inteiro

    if (checkbox.checked) {
      // Se o checkbox estiver marcado
      total += preco * quantidade; // Incrementa o total com o preço multiplicado pela quantidade
      item.querySelector(".subtrair").disabled = false; // Ativa o botão de subtrair do item
      item.querySelector(".somar").disabled = false; // Ativa o botão de somar do item
    } else {
      item.querySelector(".subtrair").disabled = true; // Desativa o botão de subtrair do item
      item.querySelector(".somar").disabled = true; // Desativa o botão de somar do item

      // Limpar o contador quando o checkbox é desmarcado
      quantidadeElement.textContent = "0"; // Define o contador do item como zero
    }
  });

  // Limitar a quantidade de dígitos após a vírgula para duas casas decimais e exibe o total no elemento "total"
  document.getElementById("total").textContent =
    "Total: R$ " + total.toFixed(2);
}

// Adicionar eventos de clique aos botões para incrementar/decrementar o contador
const botoesIncrementar = document.querySelectorAll(".item-cardapio .subtrair");
const botoesDecrementar = document.querySelectorAll(".item-cardapio .somar");

botoesIncrementar.forEach((botao) => {
  if (!botao.hasEventListener) {
    botao.hasEventListener = true;
    botao.addEventListener("click", function () {
      incrementarContador(this.closest(".item-cardapio")); // Chama a função de incrementar contador passando o item do cardápio relacionado
    });
  }
});

botoesDecrementar.forEach((botao) => {
  if (!botao.hasEventListener) {
    botao.hasEventListener = true;
    botao.addEventListener("click", function () {
      decrementarContador(this.closest(".item-cardapio")); // Chama a função de decrementar contador passando o item do cardápio relacionado
    });
  }
});

// Adicionar eventos de mudança aos checkboxes
const checkboxes = document.querySelectorAll('input[name="pedido"]');
checkboxes.forEach((checkbox) => {
  checkbox.addEventListener("change", function () {
    atualizarTotalPedido(); // Chama a função de atualizar o total do pedido quando houver mudança nos checkboxes
  });
});

// Adicionar efeito de imagem pulsante automático
const imagens = document.querySelectorAll(".item-cardapio img");

function pulsarImagens() {
  imagens.forEach((imagem) => {
    imagem.style.transition = "transform 0.5s"; // Define a transição de 0.5 segundos para a transformação da imagem
    imagem.style.transform = "scale(1.03)"; // Aplica a transformação de escala na imagem

    setTimeout(() => {
      imagem.style.transform = "scale(1.0)"; // Restaura a escala original da imagem após 0.5 segundos
    }, 500);
  });
}

// Iniciar a pulsação automática a cada 3 segundos (ajuste conforme necessário)
setInterval(pulsarImagens, 3000);

// Função para enviar pedido
function enviarPedido() {
  var totalText = document.getElementById("total").textContent;
  var total = parseFloat(totalText.replace("Total: R$ ", "").replace(",", "."));

  if (total <= 0) {
    alert("Selecione pelo menos um item antes de enviar o pedido."); // Exibe um alerta se o total for menor ou igual a zero
    return;
  }

  if (total > 600) {
    // Se o total ultrapassar 600 reais, exibir um alerta com confirmação
    var confirmacao = confirm(
      "Tem certeza disso? Por acaso está brincando com a gente? Vai alimentar um batalhão?"
    );

    if (!confirmacao) {
      // Se o usuário clicar em "Não, errei!", cancelar o envio e limpar a página
      checarCheckboxes(); // Limpar checkboxes e resetar total
      return;
    }
  }

  var checkboxes = document.querySelectorAll('input[name="pedido"]:checked');
  var itensPedido = [];

  checkboxes.forEach(function (checkbox) {
    var item = checkbox.closest(".item-cardapio");
    var quantidade = parseInt(item.querySelector(".contador span").textContent);
    var preco = parseFloat(checkbox.value).toFixed(2); // Limitar a dois dígitos após a vírgula
    var nomeItem = item.querySelector("h2").textContent;

    itensPedido.push({
      nome: nomeItem,
      quantidade: quantidade,
      preco: preco,
    });
  });

  // Enviar dados para o PHP usando AJAX
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "/db/Registrar_Pedido.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  // Converter o objeto para uma string codificada
  var parametros =
    "total=" +
    total.toFixed(2) + // Limitar a dois dígitos após a vírgula
    "&itens=" +
    encodeURIComponent(JSON.stringify(itensPedido));

  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4) {
      if (xhr.status == 200) {
        // Pedido enviado com sucesso
        console.log(xhr.responseText);
        alert("Pedido de R$ " + total.toFixed(2) + " enviado com sucesso!");
      } else {
        // Erro no envio do pedido
        alert("Erro ao enviar o pedido. Por favor, tente novamente.");
      }
    }
  };

  xhr.send(parametros);
}

// Função para registrar o pedido no banco de dados
function registrarPedido() {
  var totalText = document.getElementById("total").textContent;
  var total = parseFloat(totalText.replace("Total: R$ ", "").replace(",", "."));

  if (isNaN(total) || total <= 0) {
    alert("Selecione pelo menos um item antes de enviar o pedido."); // Exibe um alerta se o total for inválido ou menor ou igual a zero
    return;
  }

  var checkboxes = document.querySelectorAll('input[name="pedido"]:checked');
  var itensPedido = [];

  checkboxes.forEach(function (checkbox) {
    var item = checkbox.closest(".item-cardapio");
    var nomeItem = item.querySelector("h2").textContent;
    var quantidade = parseInt(item.querySelector(".contador span").textContent);
    var preco = parseFloat(checkbox.value);

    itensPedido.push({
      nome: nomeItem,
      quantidade: quantidade,
      preco: preco,
    });
  });

  // Criar um objeto com os dados do pedido
  var pedido = {
    total: total.toFixed(2), // Limitar a quantidade de dígitos após a vírgula para duas casas decimais
    itens: itensPedido,
  };

  // Enviar dados para o PHP usando AJAX
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "/db/Registrar_Pedido.php", true);
  xhr.setRequestHeader("Content-Type", "application/json");
  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4 && xhr.status == 200) {
      // Resposta do servidor (pode implementar algum tratamento aqui se necessário)
      console.log(xhr.responseText);
    }
  };
  xhr.send(JSON.stringify(pedido));
}
