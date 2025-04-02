// Função para exibir modal de redirecionamento
function showRedirectAlert(pageName) {
  const modal = new bootstrap.Modal(document.getElementById("redirectModal"));
  const modalBody = document.getElementById("redirectModalBody");

  if (pageName) {
    modalBody.innerHTML = `Você será redirecionado para a página: <strong>${pageName}</strong>. Deseja continuar?`;

    // Configurar botões do modal
    const modalFooter = document.querySelector("#redirectModal .modal-footer");
    modalFooter.innerHTML = `
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
      <button type="button" class="btn btn-primary" id="confirmRedirect">Continuar</button>
    `;

    // Adicionar evento ao botão de confirmação
    document
      .getElementById("confirmRedirect")
      .addEventListener("click", function () {
        modal.hide();
        if (pageName === "Tabela de Solicitações") {
          window.location.href = "./tabela_solicitacoes.php";
        } else if (pageName === "Inserir Pedido") {
          window.location.href = "./inserir_pedido.php";
        } else if (pageName === "Contato") {
          window.location.href = "./contato.html";
        }
      });
  } else {
    modalBody.innerHTML = "Você será redirecionado para a página de login.";
    modalFooter.innerHTML = `
      <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
    `;
  }

  modal.show();
}

// Função para encerrar a sessão com modal
function logout() {
  const modal = new bootstrap.Modal(document.getElementById("confirmModal"));
  const modalBody = document.getElementById("confirmModalBody");

  modalBody.innerHTML = "Tem certeza que deseja sair?";

  const modalFooter = document.querySelector("#confirmModal .modal-footer");
  modalFooter.innerHTML = `
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
    <button type="button" class="btn btn-danger" id="confirmLogout">Sair</button>
  `;

  document
    .getElementById("confirmLogout")
    .addEventListener("click", function () {
      modal.hide();
      window.location.href = "../login.php";
    });

  modal.show();
}

// Função para confirmar redirecionamento com modal
function confirmRedirect(destination) {
  const modal = new bootstrap.Modal(document.getElementById("confirmModal"));
  const modalBody = document.getElementById("confirmModalBody");

  modalBody.innerHTML = `Tem certeza que deseja ir para a página <strong>${destination}</strong>?`;

  const modalFooter = document.querySelector("#confirmModal .modal-footer");
  modalFooter.innerHTML = `
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
    <button type="button" class="btn btn-primary" id="confirmAction">Continuar</button>
  `;

  document
    .getElementById("confirmAction")
    .addEventListener("click", function () {
      modal.hide();
      if (destination === "principal") {
        window.location.href = "../paginas/principal.html";
      } else if (destination === "login") {
        window.location.href = "../login.php";
      }
    });

  modal.show();
}

// Função para confirmar envio do formulário com modal
function confirmSubmission() {
  const modal = new bootstrap.Modal(document.getElementById("confirmModal"));
  const modalBody = document.getElementById("confirmModalBody");
  let confirmed = false;

  modalBody.innerHTML = "Tem certeza que deseja enviar o formulário?";

  const modalFooter = document.querySelector("#confirmModal .modal-footer");
  modalFooter.innerHTML = `
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
    <button type="button" class="btn btn-success" id="confirmSubmit">Enviar</button>
  `;

  document
    .getElementById("confirmSubmit")
    .addEventListener("click", function () {
      confirmed = true;
      modal.hide();
    });

  modal.show();

  // Retorna o valor apenas após o usuário interagir com o modal
  return new Promise((resolve) => {
    modal._element.addEventListener("hidden.bs.modal", function () {
      resolve(confirmed);
    });
  });
}

// Modificar os event listeners para usar async/await
document.addEventListener("DOMContentLoaded", function () {
  // Evento para formulários
  const forms = document.querySelectorAll(
    'form[onsubmit="return confirmSubmission()"]'
  );
  forms.forEach((form) => {
    form.addEventListener("submit", async function (e) {
      e.preventDefault();
      const confirmed = await confirmSubmission();
      if (confirmed) {
        this.submit();
      }
    });
  });

  // Efeito hover na logo
  document.getElementById("logo")?.addEventListener("mouseover", function () {
    this.style.transform = "rotate(5deg)";
    this.style.transition = "transform 0.3s ease";
  });

  document.getElementById("logo")?.addEventListener("mouseout", function () {
    this.style.transform = "rotate(0deg)";
  });

  // Função para definir a data atual no campo de data
  function setTodayDate() {
    const today = new Date();
    const year = today.getFullYear();
    const month = (today.getMonth() + 1).toString().padStart(2, "0");
    const day = today.getDate().toString().padStart(2, "0");
    const currentDate = `${year}-${month}-${day}`;
    const dateField = document.getElementById("data_solicitacao");
    if (dateField) dateField.value = currentDate;
  }

  setTodayDate();
});

// Adicionar os modais ao final do body (deve ser adicionado em cada página)
function addModalElements() {
  const modalHTML = `
    <!-- Modal de confirmação genérico -->
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Confirmação</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body" id="confirmModalBody"></div>
          <div class="modal-footer">
            <!-- Buttons serão inseridos dinamicamente -->
          </div>
        </div>
      </div>
    </div>

    <!-- Modal de redirecionamento -->
    <div class="modal fade" id="redirectModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Redirecionamento</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body" id="redirectModalBody"></div>
          <div class="modal-footer">
            <!-- Buttons serão inseridos dinamicamente -->
          </div>
        </div>
      </div>
    </div>
  `;

  const modalContainer = document.createElement("div");
  modalContainer.innerHTML = modalHTML;
  document.body.appendChild(modalContainer);
}

// Chamar a função para adicionar os modais quando o DOM estiver pronto
document.addEventListener("DOMContentLoaded", addModalElements);
