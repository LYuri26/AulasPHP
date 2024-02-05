// Função para exibir alerta de redirecionamento
function showRedirectAlert() {
  alert("Você será redirecionado para a página de login.");
}
// Função para exibir alerta de redirecionamento
function showRedirectAlert(pageName) {
  alert("Você será redirecionado para a página: " + pageName);
}

// Função para encerrar a sessão
function logout() {
  if (confirm("Tem certeza que deseja sair?")) {
    window.location.href = "../login.php";
  }
}

// Função para confirmar redirecionamento
function confirmRedirect(destination) {
  if (confirm("Tem certeza que deseja ir para a página " + destination + "?")) {
    if (destination === "principal") {
      window.location.href = "../paginas/principal.html";
    } else if (destination === "login") {
      window.location.href = "../login.php";
    }
  }
}

// Função para confirmar envio do formulário
function confirmSubmission() {
  return confirm("Tem certeza que deseja enviar o formulário?");
}

// Função para definir a data atual no campo de data
function setTodayDate() {
  var today = new Date();
  var year = today.getFullYear();
  var month = (today.getMonth() + 1).toString().padStart(2, "0");
  var day = today.getDate().toString().padStart(2, "0");
  var currentDate = year + "-" + month + "-" + day;
  document.getElementById("data_solicitacao").value = currentDate;
}

// Chamar a função para definir a data atual ao carregar a página
window.onload = function () {
  setTodayDate();
};

// Função para exibir alerta de redirecionamento e redirecionar
function showRedirectAlert(pageName) {
  if (pageName) {
    if (
      confirm(
        "Você será redirecionado para a página: " +
          pageName +
          ". Deseja continuar?"
      )
    ) {
      if (pageName === "Tabela de Solicitações") {
        window.location.href = "./tabela_solicitacoes.php";
      } else if (pageName === "Inserir Pedido") {
        window.location.href = "./inserir_pedido.php";
      } else if (pageName === "Contato") {
        window.location.href = "./contato.html";
      }
    }
  } else {
    alert("Você será redirecionado para a página de login.");
    // Adicione aqui o código para redirecionar para a página de login, caso necessário
  }
}

// Função para exibir alerta ao clicar no botão de login
function showAlertOnLoginButtonClick() {
  showRedirectAlert();
}

document.addEventListener("DOMContentLoaded", function () {
  document.getElementById("logo").addEventListener("mouseover", function () {
    this.style.transform = "rotate(5deg)"; // Rotação para a direita
  });

  document.getElementById("logo").addEventListener("mouseout", function () {
    this.style.transform = "rotate(0deg)"; // Rotação de volta à posição original
  });
});
