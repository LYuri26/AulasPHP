// Importando as penalidades específicas
import { scrumMasterPenalties } from "./scrummaster.js";
import { productOwnerPenalties } from "./productowner.js";
import { frontendDevPenalties } from "./desenvolvedorfrontend.js";
import { backendDevPenalties } from "./desenvolvedorbackend.js";
import { designerPenalties } from "./designer.js";
import { generalPenalties } from "./gerais.js";
import { bonuses } from "./bonus.js";

document.addEventListener("DOMContentLoaded", function () {
  const teamForm = document.getElementById("teamForm");
  const teamsList = document.getElementById("teamsList");
  const startButton = document.getElementById("startButton");
  const penaltyDisplay = document.getElementById("penaltyDisplay");
  const penaltyHistory = document.getElementById("penaltyHistory");
  const loansContainer = document.createElement("div");

  // Configuração do container de empréstimos
  loansContainer.className = "card mb-4";
  loansContainer.innerHTML = `
    <div class="card-body">
      <h2 class="card-title">Empréstimos</h2>
      <div id="loansForm"></div>
      <div id="activeLoans"></div>
    </div>
  `;
  teamForm.parentNode.insertBefore(loansContainer, teamForm.nextSibling);

  let teams = [];
  let recentPenalties = [];
  let activeLoans = [];
  let penaltyTimer = null;
  let penaltyCycleInterval = null;

  // Adicionar equipe
  teamForm.addEventListener("submit", function (e) {
    e.preventDefault();

    const team = {
      name: document.getElementById("teamName").value,
      scrumMaster: document.getElementById("scrumMaster").value,
      productOwner: document.getElementById("productOwner").value,
      frontendDev: document.getElementById("frontendDev").value,
      backendDev: document.getElementById("backendDev").value,
      designer: document.getElementById("designer").value,
      time: 480 * 60, // Agora em segundos (8 horas = 480 minutos = 28800 segundos)
      money: 200000,
      penalties: [],
      timerInterval: null,
      lastUpdate: Date.now(), // Adicionado para controle preciso do tempo
    };

    teams.push(team);
    updateTeamsList();
    teamForm.reset();
    updateLoansForm();
  });

  // Função para atualizar o formulário de empréstimos
  function updateLoansForm() {
    const loansForm = document.getElementById("loansForm");
    loansForm.innerHTML = "";

    for (let i = 1; i <= 6; i++) {
      loansForm.innerHTML += `
        <div class="loan-form mb-3">
          <h5>Empréstimo ${i}</h5>
          <input type="text" id="loanName${i}" class="form-control mb-2" placeholder="Nome do recurso">
          <input type="number" id="loanTime${i}" class="form-control mb-2" placeholder="Tempo (minutos)">
          <button class="btn btn-primary mb-3" onclick="startLoan(${i})">Iniciar Empréstimo</button>
        </div>
      `;
    }
  }

  // Função para iniciar um empréstimo
  window.startLoan = function (loanNumber) {
    const name = document.getElementById(`loanName${loanNumber}`).value;
    const time = parseInt(
      document.getElementById(`loanTime${loanNumber}`).value
    );

    if (!name || isNaN(time)) return;

    const endTime = new Date();
    endTime.setMinutes(endTime.getMinutes() + time);

    const loan = {
      id: Date.now(),
      name,
      endTime,
      timer: setInterval(() => {
        updateLoanTimer(loan.id);
      }, 1000),
    };

    activeLoans.push(loan);
    updateActiveLoans();
  };

  // Função para atualizar os empréstimos ativos
  function updateActiveLoans() {
    const activeLoansDiv = document.getElementById("activeLoans");
    activeLoansDiv.innerHTML = "<h4>Empréstimos Ativos</h4>";

    activeLoans.forEach((loan) => {
      const remaining = Math.max(
        0,
        Math.round((loan.endTime - new Date()) / 1000)
      );
      if (remaining <= 0) {
        clearInterval(loan.timer);
        activeLoans = activeLoans.filter((l) => l.id !== loan.id);
        updateActiveLoans();
        return;
      }

      const loanDiv = document.createElement("div");
      loanDiv.className = "loan-item mb-2";
      loanDiv.innerHTML = `
        <p><strong>${loan.name}</strong> - Tempo restante: ${formatTime(
        remaining
      )}</p>
      `;
      activeLoansDiv.appendChild(loanDiv);
    });
  }

  // Função para atualizar o timer de um empréstimo
  function updateLoanTimer(loanId) {
    const loan = activeLoans.find((l) => l.id === loanId);
    if (!loan) return;

    updateActiveLoans();
  }

  // Iniciar o gerenciamento de equipes
  startButton.addEventListener("click", function () {
    if (!startButton.classList.contains("started")) {
      startButton.classList.add("started");
      teams.forEach((team) => {
        if (!team.timerInterval) {
          startTimer(team);
        }
      });
      startPenaltyCycle();
    }
  });

  // Função para aplicar penalidade específica por cargo
  function applyRandomPenalty() {
    if (teams.length === 0) return;

    const randomTeamIndex = Math.floor(Math.random() * teams.length);
    const team = teams[randomTeamIndex];

    // 20% de chance de penalidade geral
    if (Math.random() < 0.2) {
      const randomPenaltyIndex = Math.floor(
        Math.random() * generalPenalties.length
      );
      const penalty = generalPenalties[randomPenaltyIndex];
      addToPenaltyHistory(team.name, "Equipe", "Todos", penalty);
      showPenalty(team.name, "Equipe", "Todos", penalty);
    }
    // 10% de chance de bônus
    else if (Math.random() < 0.1) {
      const randomBonusIndex = Math.floor(Math.random() * bonuses.length);
      const bonus = bonuses[randomBonusIndex];
      addToPenaltyHistory(team.name, "Equipe", "Todos", "BÔNUS: " + bonus);
      showPenalty(team.name, "Equipe", "Todos", "BÔNUS: " + bonus);
    }
    // 70% de chance de penalidade específica
    else {
      const roles = [
        {
          role: "Scrum Master",
          name: team.scrumMaster,
          penalties: scrumMasterPenalties,
        },
        {
          role: "Product Owner",
          name: team.productOwner,
          penalties: productOwnerPenalties,
        },
        {
          role: "Desenvolvedor Frontend",
          name: team.frontendDev,
          penalties: frontendDevPenalties,
        },
        {
          role: "Desenvolvedor Backend",
          name: team.backendDev,
          penalties: backendDevPenalties,
        },
        {
          role: "Designer UX/UI",
          name: team.designer,
          penalties: designerPenalties,
        },
      ];

      const randomRoleIndex = Math.floor(Math.random() * roles.length);
      const selectedRole = roles[randomRoleIndex];
      const randomPenaltyIndex = Math.floor(
        Math.random() * selectedRole.penalties.length
      );
      const penalty = selectedRole.penalties[randomPenaltyIndex];

      addToPenaltyHistory(
        team.name,
        selectedRole.role,
        selectedRole.name,
        penalty
      );
      showPenalty(team.name, selectedRole.role, selectedRole.name, penalty);
    }

    // Timer para limpar a penalidade após 10 minutos
    if (penaltyTimer) {
      clearTimeout(penaltyTimer);
    }
    penaltyTimer = setTimeout(() => {
      clearPenalty();
    }, 600000); // 10 minutos em milissegundos
  }

  // Função para iniciar o ciclo de penalidades (a cada 20 minutos)
  function startPenaltyCycle() {
    // Limpar qualquer intervalo existente
    if (penaltyCycleInterval) {
      clearInterval(penaltyCycleInterval);
    }

    // Aplicar a primeira penalidade imediatamente
    applyRandomPenalty();

    // Configurar o intervalo para 20 minutos (1200000 ms)
    penaltyCycleInterval = setInterval(() => {
      applyRandomPenalty();
    }, 1200000); // Aplicar penalidade a cada 20 minutos
  }

  // Função para adicionar uma penalidade ao histórico
  function addToPenaltyHistory(teamName, memberRole, memberName, penalty) {
    recentPenalties.unshift({
      teamName,
      memberRole,
      memberName,
      penalty,
    });

    if (recentPenalties.length > 5) {
      recentPenalties.pop();
    }

    updatePenaltyHistory();
  }

  // Função para atualizar o histórico de penalidades
  function updatePenaltyHistory() {
    penaltyHistory.innerHTML = `
      <h3>Histórico de Penalidades</h3>
      <ul>
        ${recentPenalties
          .map(
            (penalty) => `
          <li>
            <strong>Equipe:</strong> ${penalty.teamName} |
            <strong>Membro:</strong> ${penalty.memberName} (${penalty.memberRole}) |
            <strong>Penalidade:</strong> ${penalty.penalty}
          </li>
        `
          )
          .join("")}
      </ul>
    `;
  }

  // Função para exibir a penalidade
  function showPenalty(teamName, memberRole, memberName, penalty) {
    penaltyDisplay.innerHTML = `
      <div class="penalty-card">
        <h3>Penalidade Aplicada</h3>
        <p><strong>Equipe:</strong> ${teamName}</p>
        <p><strong>Membro:</strong> ${memberName} (${memberRole})</p>
        <p><strong>Penalidade:</strong> ${penalty}</p>
      </div>
    `;
  }

  // Função para remover a penalidade
  function clearPenalty() {
    penaltyDisplay.innerHTML = "";
  }

  // Função para atualizar a lista de equipes
  function updateTeamsList() {
    teamsList.innerHTML = "";
    teams.forEach((team) => {
      const teamCard = document.createElement("div");
      teamCard.className = "team-card";
      teamCard.innerHTML = `
        <h3>${team.name}</h3>
        <p><strong>Scrum Master:</strong> ${team.scrumMaster}</p>
        <p><strong>Product Owner:</strong> ${team.productOwner}</p>
        <p><strong>Desenvolvedor Frontend:</strong> ${team.frontendDev}</p>
        <p><strong>Desenvolvedor Backend:</strong> ${team.backendDev}</p>
        <p><strong>Designer UX/UI:</strong> ${team.designer}</p>
        <h4>Timer: <span id="timer-${team.name}">${formatTime(
        team.time
      )}</span></h4>
        <h4>Dinheiro: <span id="money-${team.name}">${team.money}</span></h4>
        <input type="number" id="timeIncrement-${
          team.name
        }" placeholder="Ajustar tempo (min)" />
        <input type="number" id="moneyIncrement-${
          team.name
        }" placeholder="Ajustar dinheiro" />
        <button onclick="changeTime('${team.name}')">Alterar Tempo</button>
        <button onclick="changeMoney('${team.name}')">Alterar Dinheiro</button>
        <ul id="penalties-${team.name}">
          ${team.penalties.map((penalty) => `<li>${penalty}</li>`).join("")}
        </ul>
      `;
      teamsList.appendChild(teamCard);
    });
  }

  // Função para formatar o tempo (agora recebe segundos)
  function formatTime(totalSeconds) {
    totalSeconds = Math.round(totalSeconds); // Garantir que estamos trabalhando com números inteiros
    const hours = Math.floor(totalSeconds / 3600);
    const minutes = Math.floor((totalSeconds % 3600) / 60);
    const seconds = totalSeconds % 60;

    // Formatar para sempre mostrar 2 dígitos nos segundos
    const formattedSeconds = seconds.toString().padStart(2, "0");
    return `${hours}h ${minutes}m ${formattedSeconds}s`;
  }

  // Função para iniciar o timer da equipe (agora em segundos)
  function startTimer(team) {
    if (!team.timerInterval) {
      team.lastUpdate = Date.now(); // Registrar o momento de início

      team.timerInterval = setInterval(() => {
        const now = Date.now();
        const elapsedSeconds = (now - team.lastUpdate) / 1000;
        team.lastUpdate = now;

        if (team.time > 0) {
          team.time -= elapsedSeconds; // Diminuir o tempo decorrido
          if (team.time < 0) team.time = 0; // Garantir que não fique negativo
          updateTimer(team);
        } else {
          clearInterval(team.timerInterval);
          team.timerInterval = null;
        }
      }, 1000); // Atualiza a cada segundo
    }
  }

  // Função para atualizar apenas o timer de uma equipe
  function updateTimer(team) {
    const timerElement = document.getElementById(`timer-${team.name}`);
    if (timerElement) {
      timerElement.textContent = formatTime(team.time);
    }
  }

  // Função para alterar o tempo da equipe (agora em segundos)
  window.changeTime = function (teamName) {
    const team = teams.find((t) => t.name === teamName);
    const incrementValue = parseFloat(
      document.getElementById(`timeIncrement-${teamName}`).value
    );

    if (team && !isNaN(incrementValue)) {
      team.time += incrementValue * 60; // Converter minutos para segundos
      updateTimer(team);
    }
  };

  // Função para alterar o dinheiro da equipe
  window.changeMoney = function (teamName) {
    const team = teams.find((t) => t.name === teamName);
    const incrementValue = parseInt(
      document.getElementById(`moneyIncrement-${teamName}`).value
    );
    if (team && !isNaN(incrementValue)) {
      team.money += incrementValue;
      const moneyElement = document.getElementById(`money-${teamName}`);
      if (moneyElement) {
        moneyElement.textContent = team.money;
      }
    }
  };
});
