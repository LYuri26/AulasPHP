/**
 * SISTEMA DE VALIDAÇÃO DE FORMULÁRIO - ECOPLAST
 *
 * Este arquivo é responsável por:
 * - Aplicar máscaras aos campos de telefone e CEP
 * - Validar todos os campos do formulário antes do envio
 * - Gerenciar o envio dos dados para criação/atualização de clientes
 * - Exibir feedback visual para o usuário
 */

// Aguarda o carregamento completo do DOM antes de executar o código
document.addEventListener("DOMContentLoaded", function () {
  // =============================================
  // CONFIGURAÇÃO DE MÁSCARAS PARA OS CAMPOS
  // =============================================

  /**
   * Máscara para campo de telefone: formata como (99) 9999-9999
   */
  document.getElementById("telefone").addEventListener("input", function (e) {
    this.value = this.value
      .replace(/\D/g, "") // Remove tudo que não é dígito
      .replace(/(\d{2})(\d)/, "($1) $2") // Captura 2 grupos: o primeiro com 2 dígitos e o segundo com o restante
      .replace(/(\d{4})(\d)/, "$1-$2") // Formata os 4 dígitos seguintes com um hífen
      .replace(/(-\d{4})\d+?$/, "$1"); // Impede que digite mais que 9 números
  });

  /**
   * Máscara para campo de CEP: formata como 99999-999
   */
  document.getElementById("cep").addEventListener("input", function (e) {
    this.value = this.value
      .replace(/\D/g, "") // Remove tudo que não é dígito
      .replace(/(\d{5})(\d)/, "$1-$2") // Insere hífen após 5 dígitos
      .replace(/(-\d{3})\d+?$/, "$1"); // Impede que digite mais que 8 números
  });

  // =============================================
  // VALIDAÇÃO DO FORMULÁRIO
  // =============================================

  /**
   * Event listener para o submit do formulário
   */
  document
    .getElementById("clienteForm")
    .addEventListener("submit", function (e) {
      e.preventDefault(); // Impede o comportamento padrão de submit

      // Executa a validação e só continua se retornar true
      if (!validarFormulario()) return;

      // Obtém o ID do cliente (se existir, indica edição)
      const clienteId = document.getElementById("clienteId").value;

      // Cria um objeto FormData com os dados do formulário
      const formData = new FormData(this);

      // Decide qual endpoint chamar baseado no modo (criação ou edição)
      if (clienteId) {
        enviarDados("update_client.php", formData);
      } else {
        enviarDados("create_client.php", formData);
      }
    });
});

// =============================================
// FUNÇÕES DE VALIDAÇÃO
// =============================================

/**
 * Valida todos os campos do formulário
 * @returns {boolean} Retorna true se todos os campos são válidos
 */
function validarFormulario() {
  let valido = true; // Flag que indica se o formulário é válido

  // Obtém e trimma os valores dos campos
  const nome = document.getElementById("nome").value.trim();
  const email = document.getElementById("email").value.trim();
  const telefone = document.getElementById("telefone").value.trim();
  const endereco = document.getElementById("endereco").value.trim();
  const cidade = document.getElementById("cidade").value.trim();
  const estado = document.getElementById("estado").value;

  // Limpa erros de validação anteriores
  document.querySelectorAll(".is-invalid").forEach((el) => {
    el.classList.remove("is-invalid");
  });

  // Validação do nome (mínimo 3 caracteres)
  if (!nome || nome.length < 3) {
    mostrarErroCampo(
      "nome",
      "Por favor, insira um nome válido (mínimo 3 caracteres)"
    );
    valido = false;
  }

  // Validação do e-mail (formato válido)
  if (!validateEmail(email)) {
    mostrarErroCampo("email", "Por favor, insira um e-mail válido");
    valido = false;
  }

  // Validação do telefone (pelo menos 10 dígitos numéricos)
  if (!telefone || telefone.replace(/\D/g, "").length < 10) {
    mostrarErroCampo(
      "telefone",
      "Por favor, insira um telefone válido com DDD"
    );
    valido = false;
  }

  // Validação do endereço (não vazio)
  if (!endereco) {
    mostrarErroCampo("endereco", "Por favor, insira um endereço");
    valido = false;
  }

  // Validação da cidade (não vazia)
  if (!cidade) {
    mostrarErroCampo("cidade", "Por favor, insira uma cidade");
    valido = false;
  }

  // Validação do estado (deve ser selecionado)
  if (!estado) {
    mostrarErroCampo("estado", "Por favor, selecione um estado");
    valido = false;
  }

  return valido;
}

/**
 * Mostra mensagem de erro em um campo específico
 * @param {string} campoId - ID do campo que contém erro
 * @param {string} mensagem - Mensagem de erro a ser exibida
 */
function mostrarErroCampo(campoId, mensagem) {
  const campo = document.getElementById(campoId);
  campo.classList.add("is-invalid"); // Adiciona classe de erro do Bootstrap

  // Atualiza a mensagem de feedback do campo
  const feedback = campo.nextElementSibling;
  if (feedback && feedback.classList.contains("invalid-feedback")) {
    feedback.textContent = mensagem;
  }
}

/**
 * Valida o formato de um e-mail
 * @param {string} email - E-mail a ser validado
 * @returns {boolean} Retorna true se o e-mail é válido
 */
function validateEmail(email) {
  const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Regex para validar e-mail
  return re.test(email);
}

// =============================================
// FUNÇÕES DE ENVIO DE DADOS
// =============================================

/**
 * Envia dados do formulário para o servidor
 * @param {string} endpoint - Endpoint para onde enviar os dados
 * @param {FormData} formData - Dados do formulário
 */
function enviarDados(endpoint, formData) {
  showLoading(true); // Ativa estado de carregamento

  // Converte FormData para objeto para validação adicional
  const dados = Object.fromEntries(formData.entries());

  // Lista de campos obrigatórios (exceto CEP que é opcional)
  const camposObrigatorios = [
    "nome",
    "email",
    "telefone",
    "endereco",
    "cidade",
    "estado",
  ];

  // Verifica campos vazios
  const camposVazios = camposObrigatorios.filter((campo) => !dados[campo]);

  if (camposVazios.length > 0) {
    showAlert("Por favor, preencha todos os campos obrigatórios", "danger");
    showLoading(false);
    return;
  }

  // Envia os dados para o servidor
  fetch(`src/controllers/${endpoint}`, {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded", // Tipo de conteúdo
    },
    body: new URLSearchParams(dados), // Converte para formato URL-encoded
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error("Erro na requisição"); // Lança erro se a resposta não for OK
      }
      return response.json(); // Converte resposta para JSON
    })
    .then((data) => {
      if (data.success) {
        // Feedback de sucesso
        showAlert(data.message, "success");

        // Recarrega a lista de clientes se a função existir
        if (typeof window.carregarClientes === "function") {
          window.carregarClientes();
        }

        // Esconde o formulário após sucesso
        document.getElementById("formContainer").style.display = "none";
      } else {
        throw new Error(data.message || "Erro ao processar requisição");
      }
    })
    .catch((error) => {
      // Feedback de erro
      showAlert(error.message, "danger");
    })
    .finally(() => {
      showLoading(false); // Desativa estado de carregamento
    });
}

// =============================================
// FUNÇÕES AUXILIARES
// =============================================

/**
 * Exibe uma mensagem de alerta para o usuário
 * @param {string} message - Mensagem a ser exibida
 * @param {string} type - Tipo de alerta (success, danger, warning, etc.)
 */
function showAlert(message, type) {
  const alertContainer = document.getElementById("alertContainer");
  alertContainer.innerHTML = `
    <div class="alert alert-${type} alert-dismissible fade show" role="alert">
      ${message}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  `;
}

/**
 * Controla o estado de carregamento da aplicação
 * @param {boolean} show - True para mostrar estado de carregamento
 */
function showLoading(show) {
  const buttons = document.querySelectorAll("button");
  buttons.forEach((btn) => {
    btn.disabled = show; // Desabilita todos os botões durante o carregamento
  });
}
