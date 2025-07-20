/**
 * SISTEMA DE GERENCIAMENTO DE CLIENTES - ECOPLAST
 * Arquivo principal JavaScript com todas as funcionalidades CRUD
 *
 * Melhorias implementadas:
 * - Validação reforçada de formulário
 * - Tratamento de erros mais robusto
 * - Feedback visual aprimorado
 * - Estrutura de código mais organizada
 */

document.addEventListener("DOMContentLoaded", function () {
  // =============================================
  // SELEÇÃO DE ELEMENTOS DO DOM (OTIMIZADA)
  // =============================================
  const elementos = {
    btnNovoCliente: document.getElementById("btnNovoCliente"),
    formContainer: document.getElementById("formContainer"),
    clienteForm: document.getElementById("clienteForm"),
    btnCancelar: document.getElementById("btnCancelar"),
    clientesTableBody: document.getElementById("clientesTableBody"),
    alertContainer: document.getElementById("alertContainer"),
    // Elementos do formulário para fácil acesso
    formFields: {
      id: document.getElementById("clienteId"),
      nome: document.getElementById("nome"),
      email: document.getElementById("email"),
      telefone: document.getElementById("telefone"),
      endereco: document.getElementById("endereco"),
      cidade: document.getElementById("cidade"),
      estado: document.getElementById("estado"),
      cep: document.getElementById("cep"),
      status: document.getElementById("status"),
    },
  };

  // Modal de confirmação do Bootstrap
  const confirmModal = new bootstrap.Modal(
    document.getElementById("confirmModal")
  );

  // =============================================
  // VARIÁVEIS DE ESTADO (REORGANIZADAS)
  // =============================================
  const estadoApp = {
    clienteIdParaExcluir: null,
    modoEdicao: false,
    carregando: false,
  };

  // =============================================
  // INICIALIZAÇÃO (COM TRATAMENTO DE ERRO)
  // =============================================
  try {
    carregarClientes();
    configurarMascaras();
    configurarEventos();
  } catch (error) {
    console.error("Erro na inicialização:", error);
    mostrarAlerta(
      "Erro ao iniciar a aplicação. Recarregue a página.",
      "danger"
    );
  }

  // =============================================
  // FUNÇÕES PRINCIPAIS (COM MELHOR DOCUMENTAÇÃO)
  // =============================================

  /**
   * Configura todos os event listeners da aplicação
   * - Controles de formulário
   * - Eventos de botões
   * - Submissão de dados
   */
  function configurarEventos() {
    // Evento para novo cliente
    elementos.btnNovoCliente.addEventListener(
      "click",
      mostrarFormularioNovoCliente
    );

    // Evento para cancelar edição/criação
    elementos.btnCancelar.addEventListener("click", esconderFormulario);

    // Evento de submit do formulário
    elementos.clienteForm.addEventListener("submit", handleFormSubmit);

    // Evento de confirmação de exclusão
    document
      .getElementById("btnConfirmarExclusao")
      .addEventListener("click", confirmarExclusaoHandler);
  }

  /**
   * Mostra formulário para novo cliente
   * - Reseta campos
   * - Configura estado de edição
   * - Exibe formulário
   */
  function mostrarFormularioNovoCliente() {
    estadoApp.modoEdicao = false;
    elementos.clienteForm.reset();
    elementos.formFields.id.value = "";
    elementos.formFields.status.value = "ativo";
    elementos.formContainer.style.display = "block";
    window.scrollTo({ top: 0, behavior: "smooth" });
  }

  /**
   * Esconde o formulário e limpa validações
   */
  function esconderFormulario() {
    elementos.formContainer.style.display = "none";
    elementos.clienteForm.classList.remove("was-validated");
  }

  /**
   * Handler para submit do formulário
   * - Valida dados
   * - Prepara payload
   * - Decide ação (criação/edição)
   */
  function handleFormSubmit(e) {
    e.preventDefault();
    e.stopPropagation();

    if (!validarFormulario()) return;

    const formData = {
      nome: elementos.formFields.nome.value,
      email: elementos.formFields.email.value,
      telefone: elementos.formFields.telefone.value,
      endereco: elementos.formFields.endereco.value,
      cidade: elementos.formFields.cidade.value,
      estado: elementos.formFields.estado.value,
      cep: elementos.formFields.cep.value,
      status: elementos.formFields.status.value,
    };

    if (estadoApp.modoEdicao) {
      formData.id = elementos.formFields.id.value;
    }

    const endpoint = estadoApp.modoEdicao
      ? "src/controllers/update_client.php"
      : "src/controllers/create_client.php";

    enviarDadosCliente(endpoint, formData);
  }

  /**
   * Handler para confirmação de exclusão
   */
  function confirmarExclusaoHandler() {
    if (estadoApp.clienteIdParaExcluir) {
      excluirCliente(estadoApp.clienteIdParaExcluir);
    }
  }

  // =============================================
  // FUNÇÕES DE VALIDAÇÃO (APRIMORADAS)
  // =============================================

  /**
   * Validação completa do formulário
   * - Verifica campos obrigatórios
   * - Valida formatos específicos
   * - Mostra feedback visual
   */
  function validarFormulario() {
    const campos = {
      nome: elementos.formFields.nome.value.trim(),
      email: elementos.formFields.email.value.trim(),
      telefone: elementos.formFields.telefone.value.trim(),
      endereco: elementos.formFields.endereco.value.trim(),
      cidade: elementos.formFields.cidade.value.trim(),
      estado: elementos.formFields.estado.value,
      cep: elementos.formFields.cep.value.trim(),
    };

    let valido = true;

    // Validações individuais com mensagens específicas
    const validacoes = [
      {
        condicao: !campos.nome || campos.nome.length < 3,
        campo: "nome",
        mensagem: "Nome deve ter pelo menos 3 caracteres",
      },
      {
        condicao: !validarEmail(campos.email),
        campo: "email",
        mensagem: "E-mail inválido",
      },
      {
        condicao:
          !campos.telefone || campos.telefone.replace(/\D/g, "").length < 10,
        campo: "telefone",
        mensagem: "Telefone incompleto (com DDD)",
      },
      {
        condicao: !campos.endereco,
        campo: "endereco",
        mensagem: "Endereço obrigatório",
      },
      {
        condicao: !campos.cidade,
        campo: "cidade",
        mensagem: "Cidade obrigatória",
      },
      {
        condicao: !campos.estado,
        campo: "estado",
        mensagem: "Estado obrigatório",
      },
      {
        condicao: campos.cep && !/^\d{5}-?\d{3}$/.test(campos.cep),
        campo: "cep",
        mensagem: "CEP inválido (formato: XXXXX-XXX)",
      },
    ];

    validacoes.forEach((validacao) => {
      if (validacao.condicao) {
        mostrarErroCampo(validacao.campo, validacao.mensagem);
        valido = false;
      }
    });

    elementos.clienteForm.classList.add("was-validated");
    return valido;
  }

  /**
   * Validação de e-mail com regex aprimorado
   */
  function validarEmail(email) {
    const re = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    return re.test(email);
  }

  /**
   * Exibe mensagem de erro em campo específico
   */
  function mostrarErroCampo(campoId, mensagem) {
    const campo = elementos.formFields[campoId];
    if (!campo) return;

    campo.classList.add("is-invalid");
    const feedback = campo.nextElementSibling;

    if (feedback && feedback.classList.contains("invalid-feedback")) {
      feedback.textContent = mensagem;
    }
  }

  // =============================================
  // FUNÇÕES CRUD (COM MELHOR TRATAMENTO DE ERROS)
  // =============================================

  /**
   * Carrega lista de clientes com tratamento de erro
   */
  async function carregarClientes() {
    try {
      showLoading(true);

      const response = await fetch("src/controllers/fetch_clients.php");
      if (!response.ok) throw new Error(`Erro HTTP: ${response.status}`);

      const resultado = await response.json();
      if (!resultado.success)
        throw new Error(resultado.error || "Erro ao carregar clientes");

      renderizarClientes(resultado.data);
    } catch (error) {
      console.error("Erro ao carregar clientes:", error);
      mostrarAlerta(error.message || "Erro ao carregar clientes", "danger");
    } finally {
      showLoading(false);
    }
  }

  /**
   * Renderiza lista de clientes na tabela
   */
  function renderizarClientes(clientes) {
    elementos.clientesTableBody.innerHTML = "";

    if (clientes.length === 0) {
      elementos.clientesTableBody.innerHTML = `
        <tr>
          <td colspan="7" class="text-center">Nenhum cliente cadastrado</td>
        </tr>
      `;
      return;
    }

    clientes.forEach((cliente) => {
      const tr = document.createElement("tr");
      tr.innerHTML = `
        <td>${cliente.id}</td>
        <td>${cliente.nome}</td>
        <td>${cliente.email}</td>
        <td>${formatarTelefone(cliente.telefone)}</td>
        <td>${cliente.cidade}/${cliente.estado}</td>
        <td>
          <span class="badge ${
            cliente.status === "ativo" ? "bg-success" : "bg-secondary"
          }">
            ${cliente.status}
          </span>
        </td>
        <td>
          <button class="btn btn-sm btn-primary btn-editar" data-id="${
            cliente.id
          }" title="Editar">
            <i class="bi bi-pencil"></i> Editar
          </button>
          <button class="btn btn-sm btn-danger btn-excluir" data-id="${
            cliente.id
          }" title="Excluir">
            <i class="bi bi-trash"></i> Excluir
          </button>
        </td>
      `;
      elementos.clientesTableBody.appendChild(tr);
    });

    configurarBotoesAcao();
  }

  /**
   * Formata número de telefone para exibição
   */
  function formatarTelefone(telefone) {
    if (!telefone) return "";
    const nums = telefone.replace(/\D/g, "");
    return `(${nums.substring(
      0,
      2
    )}) ${nums.substring(2, 6)}-${nums.substring(6)}`;
  }

  /**
   * Carrega dados de cliente para edição
   */
  async function editarCliente(id) {
    try {
      showLoading(true);

      const response = await fetch(
        `src/controllers/fetch_clients.php?id=${id}`
      );
      if (!response.ok) throw new Error(`Erro HTTP: ${response.status}`);

      const resultado = await response.json();
      if (!resultado.success)
        throw new Error(resultado.error || "Erro ao carregar cliente");
      if (!resultado.data?.length) throw new Error("Cliente não encontrado");

      preencherFormularioEdicao(resultado.data[0]);
    } catch (error) {
      console.error("Erro ao editar cliente:", error);
      mostrarAlerta(error.message, "danger");
    } finally {
      showLoading(false);
    }
  }

  /**
   * Preenche formulário com dados do cliente
   */
  function preencherFormularioEdicao(cliente) {
    estadoApp.modoEdicao = true;
    elementos.formContainer.style.display = "block";

    elementos.formFields.id.value = cliente.id;
    elementos.formFields.nome.value = cliente.nome;
    elementos.formFields.email.value = cliente.email;
    elementos.formFields.telefone.value = cliente.telefone;
    elementos.formFields.endereco.value = cliente.endereco;
    elementos.formFields.cidade.value = cliente.cidade;
    elementos.formFields.estado.value = cliente.estado;
    elementos.formFields.cep.value = cliente.cep || "";
    elementos.formFields.status.value = cliente.status;

    window.scrollTo({ top: 0, behavior: "smooth" });
  }

  /**
   * Envia dados do cliente para o servidor
   */
  async function enviarDadosCliente(endpoint, data) {
    try {
      showLoading(true);

      const response = await fetch(endpoint, {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: new URLSearchParams(data),
      });

      if (!response.ok) {
        const errorData = await response.json();
        throw new Error(errorData.message || "Erro na requisição");
      }

      const resultado = await response.json();
      if (!resultado.success)
        throw new Error(resultado.message || "Operação falhou");

      mostrarAlerta(resultado.message, "success");
      elementos.formContainer.style.display = "none";
      await carregarClientes();
    } catch (error) {
      console.error("Erro ao enviar dados:", error);
      mostrarAlerta(error.message, "danger");
    } finally {
      showLoading(false);
    }
  }

  /**
   * Exclui cliente após confirmação
   */
  async function excluirCliente(id) {
    try {
      showLoading(true);

      const response = await fetch("src/controllers/delete_client.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `id=${id}`,
      });

      if (!response.ok) {
        const errorData = await response.json();
        throw new Error(errorData.message || "Erro na requisição");
      }

      const resultado = await response.json();
      if (!resultado.success)
        throw new Error(resultado.message || "Exclusão falhou");

      mostrarAlerta(resultado.message, "success");
      await carregarClientes();
    } catch (error) {
      console.error("Erro ao excluir cliente:", error);
      mostrarAlerta(error.message, "danger");
    } finally {
      showLoading(false);
      confirmModal.hide();
    }
  }

  // =============================================
  // FUNÇÕES AUXILIARES (MELHOR ORGANIZADAS)
  // =============================================

  /**
   * Configura eventos dos botões na tabela
   */
  function configurarBotoesAcao() {
    // Botões de edição
    document.querySelectorAll(".btn-editar").forEach((btn) => {
      btn.addEventListener("click", () => editarCliente(btn.dataset.id));
    });

    // Botões de exclusão
    document.querySelectorAll(".btn-excluir").forEach((btn) => {
      btn.addEventListener("click", () => {
        estadoApp.clienteIdParaExcluir = btn.dataset.id;
        confirmModal.show();
      });
    });
  }

  /**
   * Exibe mensagem de alerta estilizada
   */
  function mostrarAlerta(mensagem, tipo) {
    const alert = document.createElement("div");
    alert.className = `alert alert-${tipo} alert-dismissible fade show`;
    alert.role = "alert";
    alert.innerHTML = `
      <div class="d-flex align-items-center">
        <i class="bi ${
          tipo === "success"
            ? "bi-check-circle-fill"
            : "bi-exclamation-triangle-fill"
        } me-2"></i>
        <div>${mensagem}</div>
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    `;

    elementos.alertContainer.innerHTML = "";
    elementos.alertContainer.appendChild(alert);

    setTimeout(() => {
      new bootstrap.Alert(alert).close();
    }, 5000);
  }

  /**
   * Controla estado de carregamento
   */
  function showLoading(show) {
    estadoApp.carregando = show;

    document.querySelectorAll("button").forEach((btn) => {
      btn.disabled = show;
    });

    document.body.style.cursor = show ? "wait" : "default";
  }

  /**
   * Configura máscaras para campos de telefone e CEP
   */
  function configurarMascaras() {
    // Máscara para telefone
    elementos.formFields.telefone.addEventListener("input", function (e) {
      this.value = this.value
        .replace(/\D/g, "")
        .replace(/(\d{2})(\d)/, "($1) $2")
        .replace(/(\d{4})(\d)/, "$1-$2")
        .replace(/(-\d{4})\d+?$/, "$1");
    });

    // Máscara para CEP
    elementos.formFields.cep.addEventListener("input", function (e) {
      this.value = this.value
        .replace(/\D/g, "")
        .replace(/(\d{5})(\d)/, "$1-$2")
        .replace(/(-\d{3})\d+?$/, "$1");
    });
  }
});
