// Cache de elementos DOM
const domElements = {
  teamsList: document.getElementById("teamsList"),
  penaltyHistory: document.getElementById("penaltyHistory"),
  activeRequests: document.getElementById("activeRequests"),
  penaltyDisplay: document.getElementById("penaltyDisplay"),
  connectionStatus: document.getElementById("connectionStatus"),
  lastUpdate: document.getElementById("lastUpdate"),
};

// Estado anterior para comparação
let previousState = {
  teams: null,
  recentPenalties: null,
  urgentRequests: null,
  activePenalty: null,
  isSimulationRunning: null,
  lastUpdate: null,
};

// Formatação de tempo (segundos para HH:MM)
function formatTime(totalSeconds) {
  totalSeconds = Math.round(totalSeconds);
  const hours = Math.floor(totalSeconds / 3600);
  const minutes = Math.floor((totalSeconds % 3600) / 60);
  return `${hours.toString().padStart(2, "0")}:${minutes
    .toString()
    .padStart(2, "0")}`;
}

// Atualiza apenas os timers das equipes (otimizado)
function updateTeamTimers(teams) {
  if (!teams) return;

  teams.forEach((team) => {
    const timerElement = document.querySelector(`#timer-${team.name}`);
    if (timerElement) {
      timerElement.textContent = formatTime(team.time);

      // Atualiza a cor apenas se necessário
      const isCritical = team.time < 3600;
      const isCurrentlyCritical =
        timerElement.classList.contains("text-danger");

      if (isCritical && !isCurrentlyCritical) {
        timerElement.classList.remove("text-dark");
        timerElement.classList.add("text-danger");
      } else if (!isCritical && isCurrentlyCritical) {
        timerElement.classList.remove("text-danger");
        timerElement.classList.add("text-dark");
      }
    }
  });
}

// Atualiza a lista de equipes (com preservação de estado dos inputs)
function updateTeamsList(teams, isSimulationRunning) {
  if (!teams) return;

  // Preserva os valores dos inputs antes de atualizar
  const inputsState = {};
  teams.forEach((team) => {
    const timeInput = document.querySelector(`#timeIncrement-${team.name}`);
    const moneyInput = document.querySelector(`#moneyIncrement-${team.name}`);
    if (timeInput) inputsState[`time-${team.name}`] = timeInput.value;
    if (moneyInput) inputsState[`money-${team.name}`] = moneyInput.value;
  });

  domElements.teamsList.innerHTML = teams
    .map(
      (team) => `
        <div class="col-md-6">
            <div class="team-card">
                <div class="d-flex justify-content-between align-items-start">
                    <h3>${team.name}</h3>
                    <span class="badge bg-${
                      isSimulationRunning ? "success" : "secondary"
                    }">
                        ${isSimulationRunning ? "Ativa" : "Inativa"}
                    </span>
                </div>
                
                <p><i class="fas fa-user-tie me-2 text-primary"></i><strong>Scrum Master:</strong> ${
                  team.scrumMaster
                }</p>
                <p><i class="fas fa-user-check me-2 text-primary"></i><strong>Product Owner:</strong> ${
                  team.productOwner
                }</p>
                <p><i class="fas fa-laptop-code me-2 text-primary"></i><strong>Frontend:</strong> ${
                  team.frontendDev
                }</p>
                <p><i class="fas fa-server me-2 text-primary"></i><strong>Backend:</strong> ${
                  team.backendDev
                }</p>
                <p><i class="fas fa-paint-brush me-2 text-primary"></i><strong>Designer:</strong> ${
                  team.designer
                }</p>
                
                <div class="team-meta mt-3">
                    <div>
                        <span id="timer-${team.name}" class="display-6 ${
        team.time < 3600 ? "text-danger" : "text-dark"
      }">${formatTime(team.time)}</span>
                        <small>Tempo Restante</small>
                    </div>
                    <div>
                        <span id="money-${
                          team.name
                        }" class="display-6">R$ ${team.money.toLocaleString(
        "pt-BR"
      )}</span>
                        <small>Orçamento</small>
                    </div>
                </div>
                
                <div class="mt-3">
                    <h5><i class="fas fa-tasks me-2"></i>Demandas Ativas</h5>
                    <div id="requests-${team.name}" class="mt-2">
                        ${
                          team.activeRequests?.length > 0
                            ? team.activeRequests
                                .map(
                                  (req) => `
                                    <div class="alert alert-warning py-2 px-3 mb-2">
                                        <div class="d-flex justify-content-between">
                                            <span>${req.description}</span>
                                            <strong>${req.time} min</strong>
                                        </div>
                                    </div>
                                `
                                )
                                .join("")
                            : '<p class="text-muted small">Nenhuma demanda ativa</p>'
                        }
                    </div>
                </div>
                
                <div class="mt-3 row g-2">
                    <div class="col-md-6">
                        <div class="input-group">
                            <input type="number" id="timeIncrement-${
                              team.name
                            }" class="form-control form-control-sm" placeholder="Minutos">
                            <button class="btn btn-sm btn-outline-primary" onclick="changeTime('${
                              team.name
                            }')">
                                <i class="fas fa-clock"></i> Ajustar
                            </button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <input type="number" id="moneyIncrement-${
                              team.name
                            }" class="form-control form-control-sm" placeholder="Valor">
                            <button class="btn btn-sm btn-outline-primary" onclick="changeMoney('${
                              team.name
                            }')">
                                <i class="fas fa-money-bill-wave"></i> Ajustar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `
    )
    .join("");

  // Restaura os valores dos inputs após a atualização
  teams.forEach((team) => {
    const timeInput = document.querySelector(`#timeIncrement-${team.name}`);
    const moneyInput = document.querySelector(`#moneyIncrement-${team.name}`);
    if (timeInput) timeInput.value = inputsState[`time-${team.name}`] || "";
    if (moneyInput) moneyInput.value = inputsState[`money-${team.name}`] || "";
  });
}

// Verifica demandas expiradas
function checkExpiredRequests(urgentRequests) {
  const now = new Date();
  return urgentRequests.filter((request) => {
    const requestEndTime = new Date(request.addedAt);
    requestEndTime.setMinutes(requestEndTime.getMinutes() + request.time);
    return now < requestEndTime;
  });
}

// Atualiza o histórico de penalidades
function updatePenaltyHistory(recentPenalties) {
  if (!recentPenalties) return;

  domElements.penaltyHistory.innerHTML = `
    <h3><i class="fas fa-history me-2"></i>Histórico de Eventos</h3>
    <ul class="mt-3">
        ${
          recentPenalties.length > 0
            ? recentPenalties
                .map(
                  (penalty) => `
                  <li class="fade-in">
                      <div class="d-flex justify-content-between">
                          <div>
                              <strong class="text-primary">${
                                penalty.teamName
                              }</strong> |
                              <span class="text-muted">${penalty.memberName} (${
                    penalty.memberRole
                  })</span>
                          </div>
                          <small class="text-muted">${new Date(
                            penalty.timestamp
                          ).toLocaleTimeString()}</small>
                      </div>
                      <div class="mt-1">${penalty.penalty}</div>
                  </li>
              `
                )
                .join("")
            : '<p class="text-muted">Nenhum evento registrado ainda</p>'
        }
    </ul>
  `;
}

// Atualiza demandas ativas
function updateActiveRequests(urgentRequests) {
  if (!urgentRequests) return;

  domElements.activeRequests.innerHTML =
    urgentRequests.length > 0
      ? urgentRequests
          .map(
            (request) => `
            <div class="request-item fade-in">
                <div class="request-info">
                    <strong>${request.description}</strong>
                    <small class="text-muted d-block">Adicionado em ${new Date(
                      request.addedAt
                    ).toLocaleTimeString()}</small>
                </div>
                <div class="request-time">${request.time} min</div>
            </div>
        `
          )
          .join("")
      : '<p class="text-muted">Nenhuma demanda ativa no momento</p>';
}

// Atualiza a penalidade ativa
function showPenalty(activePenalty) {
  if (!activePenalty) {
    domElements.penaltyDisplay.innerHTML = `
      <div class="text-center py-4 text-muted">
          <i class="fas fa-check-circle fa-3x mb-3"></i>
          <h4>Nenhuma penalidade ativa no momento</h4>
          <p>A próxima penalidade será aplicada automaticamente</p>
      </div>
    `;
    return;
  }

  const isBonus = activePenalty.penalty.includes("BÔNUS:");
  domElements.penaltyDisplay.innerHTML = `
    <div class="${isBonus ? "bonus-card" : "penalty-card"} fade-in">
        <h3><i class="fas ${
          isBonus ? "fa-gift" : "fa-exclamation-triangle"
        } me-2"></i>${isBonus ? "Bônus Concedido!" : "Penalidade Aplicada"}</h3>
        <div class="mt-3">
            <p><strong><i class="fas fa-users me-2"></i>Equipe:</strong> ${
              activePenalty.teamName
            }</p>
            <p><strong><i class="fas fa-user me-2"></i>Membro:</strong> ${
              activePenalty.memberName
            } (${activePenalty.memberRole})</p>
            <p class="mt-3 alert alert-${isBonus ? "success" : "danger"}">
                <strong><i class="fas ${
                  isBonus ? "fa-star" : "fa-bolt"
                } me-2"></i>${
    isBonus ? "Bônus" : "Penalidade"
  }:</strong> ${activePenalty.penalty.replace("BÔNUS: ", "")}
            </p>
        </div>
    </div>
  `;

  // Efeito visual
  domElements.penaltyDisplay.classList.add("pulse");
  setTimeout(() => {
    domElements.penaltyDisplay.classList.remove("pulse");
  }, 500);
}

// Atualiza o status da conexão
function updateConnectionStatus(lastUpdate) {
  const now = new Date();
  const updateTime = new Date(lastUpdate);
  const secondsDiff = Math.floor((now - updateTime) / 1000);

  domElements.lastUpdate.textContent = updateTime.toLocaleTimeString();

  if (secondsDiff > 10) {
    domElements.connectionStatus.className = "badge bg-danger";
    domElements.connectionStatus.innerHTML =
      '<i class="fas fa-unlink me-1"></i> Desconectado';
  } else if (secondsDiff > 5) {
    domElements.connectionStatus.className = "badge bg-warning";
    domElements.connectionStatus.innerHTML =
      '<i class="fas fa-exclamation-triangle me-1"></i> Conexão instável';
  } else {
    domElements.connectionStatus.className = "badge bg-success";
    domElements.connectionStatus.innerHTML =
      '<i class="fas fa-check-circle me-1"></i> Conectado';
  }
}

// Carrega e atualiza os dados de forma otimizada
function loadAndUpdateData() {
  try {
    const appState =
      JSON.parse(localStorage.getItem("scrumSimulatorData")) || {};
    let {
      teams = [],
      recentPenalties = [],
      urgentRequests = [],
      activePenalty = null,
      isSimulationRunning = false,
      lastUpdate = new Date().toISOString(),
    } = appState;

    // Filtrar demandas expiradas
    urgentRequests = checkExpiredRequests(urgentRequests);
    teams.forEach((team) => {
      if (team.activeRequests) {
        team.activeRequests = checkExpiredRequests(team.activeRequests);
      }
    });

    // Atualizações otimizadas
    updateTeamsList(teams, isSimulationRunning);
    updateTeamTimers(teams);
    updatePenaltyHistory(recentPenalties);
    updateActiveRequests(urgentRequests);
    showPenalty(activePenalty);
    updateConnectionStatus(lastUpdate);

    // Atualiza o estado anterior
    previousState = {
      teams: [...teams],
      recentPenalties: [...recentPenalties],
      urgentRequests: [...urgentRequests],
      activePenalty: activePenalty ? { ...activePenalty } : null,
      isSimulationRunning,
      lastUpdate,
    };
  } catch (error) {
    console.error("Erro ao carregar dados:", error);
  }
}

// Monitora mudanças no localStorage
window.addEventListener("storage", function (event) {
  if (event.key === "scrumSimulatorData") {
    loadAndUpdateData();
  }
});

// Configura o IntersectionObserver para otimizar quando a janela não está visível
let isWindowVisible = true;
const visibilityObserver = new IntersectionObserver(
  (entries) => {
    isWindowVisible = entries[0].isIntersecting;
  },
  { threshold: 0.1 }
);

visibilityObserver.observe(document);

// Atualiza os dados periodicamente (com otimização quando a janela não está visível)
function optimizedUpdate() {
  if (isWindowVisible) {
    loadAndUpdateData();
    setTimeout(optimizedUpdate, 1000); // Atualiza a cada 1s quando visível
  } else {
    setTimeout(optimizedUpdate, 5000); // Atualiza a cada 5s quando oculto
  }
}

// Funções globais para os botões
window.changeTime = function (teamName) {
  const team = previousState.teams.find((t) => t.name === teamName);
  const incrementValue = parseFloat(
    document.querySelector(`#timeIncrement-${teamName}`).value
  );

  if (team && !isNaN(incrementValue)) {
    // Atualiza o estado local
    team.time += incrementValue * 60;

    // Atualiza o display imediatamente
    const timerElement = document.querySelector(`#timer-${teamName}`);
    if (timerElement) {
      timerElement.textContent = formatTime(team.time);
    }

    document.querySelector(`#timeIncrement-${teamName}`).value = "";

    // Dispara notificação (você precisará implementar showNotification)
    // showNotification("Tempo Ajustado", `O tempo da equipe ${teamName} foi ajustado`, "info");
  }
};

window.changeMoney = function (teamName) {
  const team = previousState.teams.find((t) => t.name === teamName);
  const incrementValue = parseInt(
    document.querySelector(`#moneyIncrement-${teamName}`).value
  );

  if (team && !isNaN(incrementValue)) {
    // Atualiza o estado local
    team.money += incrementValue;

    // Atualiza o display imediatamente
    const moneyElement = document.querySelector(`#money-${teamName}`);
    if (moneyElement) {
      moneyElement.textContent = `R$ ${team.money.toLocaleString("pt-BR")}`;
    }

    document.querySelector(`#moneyIncrement-${teamName}`).value = "";

    // Dispara notificação (você precisará implementar showNotification)
    // showNotification("Orçamento Ajustado", `O orçamento da equipe ${teamName} foi ajustado`, "info");
  }
};

// Inicia o ciclo de atualização
document.addEventListener("DOMContentLoaded", function () {
  loadAndUpdateData();
  optimizedUpdate();
});
