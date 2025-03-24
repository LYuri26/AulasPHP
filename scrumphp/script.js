document.addEventListener("DOMContentLoaded", function () {
  const teamForm = document.getElementById("teamForm");
  const teamsList = document.getElementById("teamsList");
  const startButton = document.getElementById("startButton");
  const penaltyDisplay = document.getElementById("penaltyDisplay"); // Novo elemento para exibir penalidades
  const penaltyHistory = document.getElementById("penaltyHistory"); // Novo elemento para exibir o histórico

  let teams = [];
  let recentPenalties = []; // Array para armazenar as últimas 5 penalidades
  let penalties = [
    "Front-end impedido de trabalhar por 15 minutos: Devido a uma falha crítica no código, o desenvolvedor Front-End está impossibilitado de trabalhar por 15 minutos, impactando a entrega do sprint.",
    "Equipes podem apagar 5 quadros do Trello: Uma equipe escolhe uma equipe concorrente e apaga 5 quadros do Trello, afetando o planejamento e as tarefas da outra equipe.",
    "Mudança de Product Owners entre equipes: Os Product Owners (PO) trocam de equipes, causando uma mudança de prioridades e estratégias no desenvolvimento do projeto, interrompendo o fluxo de trabalho por 30 minutos.",
    "Designer UX/UI perde 10 minutos por erro na interface: O Designer UX/UI comete um erro no design que precisa ser corrigido imediatamente, perdendo 10 minutos da sua tarefa.",
    "Desenvolvedor Back-End sem acesso ao banco de dados por 20 minutos: O desenvolvedor Backend tem o acesso temporariamente revogado ao banco de dados por 20 minutos devido a problemas no servidor, impactando as funções de integração.",
    "Equipe de Desenvolvimento Front-End perde 15 minutos por conflito de código: O código desenvolvido por dois membros do time de Front-End entra em conflito, e 15 minutos são necessários para ser resolvido.",
    "Desenvolvedor Back-End perde 15 minutos por erro de lógica no banco de dados: Erro na estrutura da lógica do banco de dados faz com que o desenvolvedor perca 15 minutos para corrigir.",
    "PO altera backlog de funcionalidades de forma errada: O Product Owner altera erroneamente o backlog de funcionalidades, causando confusão no planejamento, o que resulta em 10 minutos perdidos para corrigir.",
    "Desenvolvedor Front-End com bug no código e perda de 20 minutos: Um bug crítico na interface do Front-End impede o progresso, fazendo com que o desenvolvedor perca 20 minutos tentando corrigir.",
    "Equipe perde 10 minutos devido a falha de comunicação interna: Falha na comunicação dentro de uma equipe causa 10 minutos de atraso enquanto um membro esclarece informações essenciais.",
    "Front-End tem código apagado por erro de versão: Um erro de versionamento apaga o código no repositório da equipe Front-End, e ela perde 15 minutos para recuperar.",
    "Designer UX/UI tem trabalho rejeitado: O trabalho do designer é rejeitado por falta de consistência, sendo necessário refazer as mudanças, o que resulta em 20 minutos de perda de tempo.",
    "Mudança de prioridades do PO durante Sprint: O PO muda as prioridades de uma equipe no meio da Sprint, afetando diretamente o progresso da equipe e resultando em 15 minutos de reorganização.",
    "Backend perde 15 minutos devido à falha de integração de API: Falha na integração de API com o sistema externo causa 15 minutos de atraso enquanto o Backend resolve o problema.",
    "Back-End perde 10 minutos devido a falha de segurança: O desenvolvedor Backend precisa corrigir uma falha de segurança crítica no sistema, resultando em 10 minutos de atraso.",
    "Equipes de desenvolvimento perdem 20 minutos devido a falha no Trello: Problemas técnicos no Trello fazem com que toda a equipe perca 20 minutos para reorganizar o planejamento e as tarefas.",
    "Desenvolvedor Front-End perde 10 minutos por erro de CSS: Um erro de formatação CSS faz com que o Front-End precise de 10 minutos para corrigir a aparência da página.",
    "Equipe de Front-End perde 15 minutos devido a falha de responsividade: A interface não está funcionando corretamente em dispositivos móveis, o que exige 15 minutos extras para ajustes.",
    "Diminuição da capacidade de trabalho de Front-End por falha de servidor: O servidor de desenvolvimento Front-End está inoperante por 15 minutos, impossibilitando o trabalho da equipe.",
    "PO exclui tarefas do Trello por erro de planejamento: O Product Owner apaga tarefas que estavam em progresso no Trello, causando uma perda de 15 minutos enquanto as tarefas precisam ser recriadas.",
    "Equipe de Front-End perde 10 minutos com conflito de design: O Front-End precisa discutir e resolver um conflito com a equipe de design sobre elementos visuais, causando uma perda de 10 minutos.",
    "Desenvolvedor Backend perde 15 minutos com erro de sintaxe SQL: O desenvolvedor Backend comete um erro de sintaxe SQL que resulta em uma perda de 15 minutos corrigindo a consulta.",
    "Mudança de um desenvolvedor para outra equipe: Um membro da equipe de Backend é transferido para a equipe de Front-End por 20 minutos, interrompendo o fluxo de trabalho original.",
    "Equipes alteram a ordem das sprints no Trello sem permissão: A equipe altera a ordem das sprints no Trello sem consultar o PO, causando 10 minutos de confusão.",
    "PO cria duplicação de tarefas no Trello: O Product Owner cria tarefas duplicadas sem querer, e a equipe perde 10 minutos para reorganizar.",
    "Front-End perde 20 minutos com problemas de compatibilidade de navegador: O código não está funcionando corretamente em todos os navegadores, resultando em 20 minutos de correção.",
    "Equipe de Desenvolvimento Backend perde 10 minutos com falha no Git: A equipe de Backend perde 10 minutos devido a conflitos de versão no Git, impactando a entrega da Sprint.",
    "Designer UX/UI com problema de usabilidade no protótipo: O protótipo da interface tem um problema de usabilidade crítico, fazendo com que o Designer perca 10 minutos para corrigir.",
    "Front-End perde 15 minutos para corrigir imagem quebrada: Um erro na inserção de imagens faz com que o Front-End perca 15 minutos ajustando os links e formatos.",
    "PO muda critérios de aceitação de funcionalidades durante a Sprint: O PO altera os critérios de aceitação das funcionalidades sem aviso prévio, resultando em 15 minutos de atraso enquanto a equipe se ajusta.",
    "Equipe de Front-End perde 10 minutos com erro em layout: O layout da página não é exibido corretamente, exigindo 10 minutos de trabalho extra.",
    "Backend perde 15 minutos devido a falha de autenticação: O sistema de autenticação falha, e o Backend perde 15 minutos corrigindo o problema.",
    "Product Owner adiciona novas funcionalidades sem considerar o impacto: O PO decide adicionar novas funcionalidades sem avaliar o impacto no cronograma, causando 10 minutos de atraso na equipe.",
    "Equipes podem bloquear 10 minutos do tempo da outra equipe: Uma equipe pode bloquear o tempo de outra equipe por 10 minutos, impactando diretamente o andamento da tarefa concorrente.",
    "Diminuição no número de membros da equipe por 20 minutos: Um membro chave da equipe é temporariamente removido da equipe, perdendo 20 minutos de trabalho enquanto a equipe se adapta à sua ausência.",
    "Erro crítico de código no Front-End atrasa a equipe por 10 minutos: O Front-End encontra um erro crítico de código que necessita de 10 minutos para ser corrigido.",
    "Mudança inesperada no design UX/UI: O designer muda drasticamente o design da interface sem aviso prévio, resultando em uma perda de 15 minutos.",
    "Erro grave na configuração do banco de dados no Backend: O desenvolvedor Backend comete um erro de configuração crítica no banco de dados, fazendo com que perca 20 minutos para corrigir.",
    "Desenvolvedor Front-End perde 10 minutos com erro de carregamento: A página não carrega corretamente devido a erros no JavaScript, resultando em 10 minutos de atraso para correção.",
    "Equipes de Front-End e Backend têm que refazer tarefas por erro de alinhamento: Ambos os times perdem 15 minutos para corrigir a falta de alinhamento nas tarefas, comprometendo o progresso.",
    "Frontend bloqueado: O desenvolvedor Frontend fica impossibilitado de trabalhar por 15 minutos devido a um bug crítico.",
    "Backend bloqueado: O desenvolvedor Backend fica impossibilitado de trabalhar por 20 minutos devido a falha na integração com o banco de dados.",
    "Scrum Master bloqueado: O Scrum Master fica impossibilitado de gerenciar a equipe por 15 minutos.",
    "Product Owner bloqueado: O Product Owner fica impossibilitado de priorizar tarefas por 20 minutos.",
    "Designer bloqueado: O Designer UX/UI fica impossibilitado de trabalhar por 15 minutos devido a problemas com o protótipo.",
    "Frontend e Backend bloqueados: Ambos os desenvolvedores ficam impossibilitados de trabalhar por 10 minutos.",
    "Scrum Master e PO bloqueados: Scrum Master e Product Owner ficam impossibilitados de trabalhar por 15 minutos.",
    "Equipe inteira bloqueada: Todos os membros da equipe ficam impossibilitados de trabalhar por 5 minutos.",
    "Frontend demitido temporariamente: O desenvolvedor Frontend é 'demitido' por 30 minutos.",
    "Backend demitido temporariamente: O desenvolvedor Backend é 'demitido' por 30 minutos.",
    "Apagar 5 quadros: A equipe perde 5 quadros do Trello.",
    "Apagar 10 quadros: A equipe perde 10 quadros do Trello.",
    "Quadros congelados: Nenhum quadro pode ser movido ou editado por 15 minutos.",
    "Erros no código Front-End: Causa 10 minutos de atraso para corrigir.",
    "Erros de sintaxe no código Backend: 10 minutos de atraso para corrigir.",
    "PO alterando as funcionalidades no meio da Sprint: 10 minutos perdidos.",
    "Mudança de prioridade no backlog pelo PO sem aviso prévio: 15 minutos de atraso enquanto a equipe reorganiza as tarefas e ajusta o planejamento.",
    "Erro de versionamento no Git: Conflito nas versões do repositório provoca 20 minutos de atraso enquanto o time resolve o problema.",
    "Falta de integração entre Front-End e Back-End: A equipe perde 30 minutos para alinhar as funcionalidades que dependem da integração, afetando o andamento do projeto.",
    "Equipe perde 10 minutos devido a falha na comunicação com o PO: A falta de clareza nos requisitos fornecidos pelo PO causa 10 minutos de atraso até que as instruções sejam compreendidas corretamente.",
    "Erro de lógica no código Front-End: A lógica do código Front-End falha em um cenário específico, fazendo a equipe perder 15 minutos até que o problema seja resolvido.",
    "Backend perde 10 minutos devido a falta de documentação: A equipe de Backend precisa gastar 10 minutos a mais para entender uma API que não está bem documentada.",
    "Scrum Master perdido em reunião e atrasando o progresso da equipe: O Scrum Master demora 20 minutos para retornar de uma reunião importante, atrasando o andamento do projeto.",
    "Design alterado sem feedback da equipe: O Designer muda elementos importantes de design sem consultar a equipe, resultando em 15 minutos para ajustar o novo layout.",
    "API externa fora do ar, impactando o Backend: O Backend fica 30 minutos sem poder prosseguir devido a uma falha externa na API que depende para uma funcionalidade crítica.",
    "Erros de CSS impedindo a renderização correta das páginas: A equipe Front-End perde 15 minutos corrigindo um erro de CSS que afeta a renderização da página em múltiplos dispositivos.",
    "Desorganização no Trello causa atrasos: A equipe perde 20 minutos reorganizando o Trello após um erro de categorização das tarefas, o que cria confusão no processo de desenvolvimento.",
    "Desenvolvedor Front-End fica sem acesso a recursos essenciais por 10 minutos: O Front-End perde 10 minutos de produtividade enquanto espera por acesso a bibliotecas e ferramentas necessárias.",
    "Problema de escalabilidade no Back-End: A equipe de Back-End detecta um problema de escalabilidade no sistema, que exige 20 minutos de análise para refatoração do código.",
    "Scrum Master confunde prioridades de sprints: O Scrum Master organiza as prioridades de sprints de forma equivocada, o que resulta em 10 minutos para corrigir a organização do planejamento.",
    "Erro de configuração no servidor de produção: A equipe perde 30 minutos identificando e corrigindo um erro de configuração no servidor que afeta a performance do sistema.",
    "Mudança de escopo durante a Sprint: O escopo do projeto é alterado durante a Sprint sem comunicação adequada com a equipe, causando 15 minutos de atraso para ajustar os fluxos de trabalho.",
    "Falha no sistema de controle de versão GitHub: O repositório tem uma falha e as equipes perdem 20 minutos resolvendo conflitos de versões e ajustando commits errados.",
    "Problema no controle de acesso ao sistema: A equipe perde 15 minutos para resolver um erro no sistema de controle de acesso, que impede que alguns membros da equipe acessem recursos necessários.",
    "Falta de testes automatizados no Front-End: A equipe Front-End precisa gastar 20 minutos criando testes automatizados para funcionalidades essenciais, que não foram considerados inicialmente.",
    "Erro de configuração no ambiente de desenvolvimento: A equipe perde 15 minutos tentando resolver um erro de configuração no ambiente de desenvolvimento que impede a execução dos testes.",
    "Erro de dependência no Node.js: A equipe Front-End perde 10 minutos para corrigir um erro de dependência no Node.js que afeta a execução do projeto.",
    "Falha na comunicação entre a equipe de design e a de desenvolvimento: A equipe perde 20 minutos resolvendo divergências de entendimento sobre a interface do usuário, resultando em alterações inesperadas.",
    "Erro na criação de banco de dados no Back-End: O desenvolvedor Backend cria um banco de dados com a estrutura errada, causando 15 minutos de atraso enquanto ajusta a modelagem de dados.",
    "Integração com serviço de terceiros falha: O sistema de integração com um serviço de pagamento de terceiros falha por 25 minutos, impactando a equipe Back-End que precisa refazer a configuração.",
    "Desenvolvedor Front-End se distrai com tarefa não prioritária: O desenvolvedor Front-End perde 10 minutos trabalhando em uma tarefa que não é prioritária, deixando uma funcionalidade crítica pendente.",
    "Problema com a autenticação de usuários no sistema: A equipe de Back-End perde 15 minutos corrigindo um erro de autenticação de usuários, impedindo o login no sistema.",
    "Mudança nos requisitos de segurança de dados durante a Sprint: Os requisitos de segurança do projeto são alterados no meio da Sprint, o que gera 20 minutos de ajustes na arquitetura de segurança da aplicação.",
    "Demora na definição do design final: A equipe de design leva 25 minutos para definir o layout final da página, o que atrasa o desenvolvimento Front-End.",
    "Erro de sincronização entre Front-End e Back-End: O Front-End e o Back-End estão usando versões incompatíveis de API, causando 30 minutos de atraso enquanto ajustam as configurações.",
    "Desenvolvedor Back-End enfrenta erro crítico em microserviço: O erro crítico em um microserviço impacta 30 minutos do time, já que a equipe precisa identificar e corrigir a falha.",
    "Equipe de Front-End perde 10 minutos com erro de JavaScript: Um erro de JavaScript em uma página web impede o progresso da equipe, que precisa de 10 minutos para corrigi-lo.",
    "Confusão sobre as responsabilidades das equipes: A falta de clareza sobre o que cada equipe deve fazer causa 15 minutos de atraso até que os papéis sejam definidos corretamente.",
    "Erro de versionamento no Back-End: Um erro na atualização das dependências do sistema de Back-End faz com que a equipe perca 20 minutos resolvendo o conflito de versões.",
    "Problema de carregamento lento no Front-End: O desempenho do Front-End é comprometido devido a carregamento lento, fazendo com que a equipe perca 10 minutos identificando o problema e aplicando a solução.",
    "Desenvolvedor Front-End perde 10 minutos devido à falha em testes unitários: Um erro nos testes unitários impede o desenvolvimento de novas funcionalidades por 10 minutos.",
    "Troca inesperada de membros na equipe de Back-End: Um membro da equipe de Back-End é trocado sem aviso prévio, causando 20 minutos de atraso na adaptação.",
    "Divergência de visão entre PO e Designer: O Product Owner e o Designer não alinham a visão do produto corretamente, resultando em 15 minutos para ajustar a direção do design.",
    "Erro de comunicação entre Scrum Master e equipe de desenvolvimento: A comunicação ineficaz entre o Scrum Master e a equipe de desenvolvimento causa 20 minutos de atraso para alinhar as prioridades.",
    "Falha no deploy do Front-End: Um erro no deploy do Front-End faz com que o time perca 15 minutos para corrigir o ambiente de produção.",
    "Problema com a integração de APIs externas no Back-End: A integração com uma API externa falha por 30 minutos, causando atraso no desenvolvimento das funcionalidades dependentes dessa API.",
    "Problemas de compatibilidade de versão no Front-End: O Front-End encontra problemas de compatibilidade entre versões de bibliotecas JavaScript, resultando em 20 minutos de atraso.",
    "Mudança de critérios de aprovação pelo PO: O PO altera os critérios de aceitação no meio da Sprint, forçando a equipe a gastar 10 minutos ajustando o desenvolvimento.",
    "Falta de teste de integração no sistema de Back-End: A falta de testes de integração no sistema de Back-End causa 25 minutos de atraso enquanto a equipe implementa a verificação de integração.",
    "Front-End perde 10 minutos devido à falta de documentação técnica: A falta de documentação técnica adequada no Front-End faz com que o desenvolvedor perca 10 minutos buscando informações.",
    "Bônus de Aumento de Orçamento por Feedback Positivo: A equipe recebe um aumento de 10% no orçamento devido a um feedback positivo do cliente. Recursos: Aumento de 10% no orçamento do projeto.",
    "Bônus de Alocação Extra de Tempo por Atraso de Fornecedores: Se houver um atraso nos fornecedores, a equipe recebe 15 minutos adicionais para concluir a tarefa. Recursos: 15 minutos adicionais no prazo de entrega.",
    "Bônus de Ampliação de Orçamento por Expansão do Escopo: O cliente aprova a expansão do escopo, concedendo um aumento no orçamento. Recursos: Aumento de 20% no orçamento do projeto.",
    "Bônus de Tempo Adicional por Complexidade Imprevista: Em casos de aumento inesperado da complexidade, a equipe recebe 30 minutos extras para concluir a tarefa. Recursos: 30 minutos adicionais de tempo.",
    "Bônus de Recursos Temporários por Falha em Integração: Caso haja falha crítica na integração, a equipe pode alocar 1 desenvolvedor temporário de outra equipe por 30 minutos. Recursos: 1 Desenvolvedor Backend por 30 minutos.",
    "Bônus de Aumento de Orçamento por Adição de Funcionalidade Extra: A equipe recebe 15% a mais no orçamento após a inclusão de funcionalidades extras solicitadas pelo cliente. Recursos: Aumento de 15% no orçamento.",
    "Bônus de Contratação Temporária para Ajustes de Urgência: A equipe pode contratar 1 Analista de Suporte Técnico e 1 Desenvolvedor Front-End para realizar ajustes urgentes por 30 minutos. Recursos: 1 Analista de Suporte Técnico e 1 Desenvolvedor Front-End por 30 minutos.",
    "Bônus de Aumento de Orçamento por Ajustes de Design de Última Hora: O time recebe um bônus de 10% no orçamento para implementar ajustes de design solicitados pelo cliente. Recursos: Aumento de 10% no orçamento.",
    "Bônus de Recursos Adicionais por Alteração de Prioridade: Caso o PO altere a prioridade da tarefa, a equipe pode obter 20% a mais no orçamento. Recursos: Aumento de 20% no orçamento.",
    "Bônus de Tempo Adicional por Atraso na Validação de Funcionalidade: Se houver atraso na validação de uma funcionalidade, a equipe recebe 25 minutos adicionais para finalização. Recursos: 25 minutos adicionais no prazo de entrega.",
    "Bônus de Alocação Extra por Problemas de Performance: Caso um problema crítico de performance seja identificado, a equipe recebe um bônus de 15% no orçamento e 20 minutos extras. Recursos: Aumento de 15% no orçamento e 20 minutos adicionais de tempo.",
    "Bônus de Reforço Temporário por Falta de Membros da Equipe: Caso membros da equipe estejam ausentes, 2 desenvolvedores temporários podem ser alocados por até 30 minutos. Recursos: 2 Desenvolvedores Backend por 30 minutos.",
    "Bônus de Aumento de Orçamento por Revisão de Código: Após revisão de código, é aprovada a alocação de 10% a mais no orçamento para melhorias sugeridas. Recursos: Aumento de 10% no orçamento.",
    "Bônus de Contratação Temporária por Atraso de Entregas: A equipe pode contratar 1 desenvolvedor Backend e 1 QA de outra equipe para cobrir os atrasos de entrega. Recursos: 1 Desenvolvedor Backend e 1 QA por 30 minutos.",
    "Bônus de Recursos Adicionais por Reunião Extra com Cliente: Uma reunião adicional com o cliente resulta em 30 minutos extras para ajustes conforme as novas orientações. Recursos: 30 minutos adicionais de tempo.",
    "Bônus de Aumento de Orçamento por Ajustes Necessários de Usabilidade: Após análise de usabilidade, é aprovado um aumento de 15% no orçamento para implementar melhorias. Recursos: Aumento de 15% no orçamento.",
    "Bônus de Contratação Temporária por Crise no Desenvolvimento: A equipe pode contratar 1 desenvolvedor Full-Stack e 1 Analista de Sistemas para mitigar uma crise urgente de desenvolvimento. Recursos: 1 Desenvolvedor Full-Stack e 1 Analista de Sistemas por 30 minutos.",
    "Bônus de Tempo Adicional por Erros em Produção: Se ocorrerem erros graves em produção, a equipe recebe 30 minutos extras para resolução do problema. Recursos: 30 minutos adicionais no prazo de entrega.",
    "Bônus de Aumento de Orçamento por Incremento de Funcionalidade: Um aumento de 20% no orçamento é concedido para incluir uma nova funcionalidade que não estava no escopo original. Recursos: Aumento de 20% no orçamento.",
    "Bônus de Recursos Temporários por Atraso no Desenvolvimento: Se houver atraso devido a complexidade técnica, a equipe pode contratar até 2 desenvolvedores temporários de outras equipes por 30 minutos. Recursos: 2 Desenvolvedores Backend por 30 minutos.",
  ];

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
      time: 28800, // Timer inicial de 480 minutos (28800 segundos)
      money: 200000, // Valor inicial de 200 mil
      penalties: [],
      timerInterval: null,
    };

    teams.push(team);
    updateTeamsList();
    teamForm.reset();
  });

  // Iniciar o gerenciamento de equipes ao clicar no botão "Iniciar"
  startButton.addEventListener("click", function () {
    // Só iniciar se ainda não tiver começado
    if (!startButton.classList.contains("started")) {
      startButton.classList.add("started"); // Adiciona uma classe para impedir múltiplos inícios
      teams.forEach((team) => {
        if (!team.timerInterval) {
          startTimer(team);
        }
      });
      startPenaltyCycle(); // Iniciar o ciclo de penalidades
    }
  });

  // Função para iniciar o ciclo de penalidades
  function startPenaltyCycle() {
    setInterval(() => {
      applyRandomPenalty();
    }, 120000); // Aplicar uma nova penalidade a cada 20 minutos (120000 ms)
  }

  // Função para aplicar uma penalidade aleatória
  function applyRandomPenalty() {
    if (teams.length === 0) return; // Verifica se há equipes cadastradas

    // Seleciona uma equipe aleatória
    const randomTeamIndex = Math.floor(Math.random() * teams.length);
    const team = teams[randomTeamIndex];

    // Seleciona um membro aleatório da equipe
    const members = [
      { role: "Scrum Master", name: team.scrumMaster },
      { role: "Product Owner", name: team.productOwner },
      { role: "Desenvolvedor Frontend", name: team.frontendDev },
      { role: "Desenvolvedor Backend", name: team.backendDev },
      { role: "Designer UX/UI", name: team.designer },
    ];
    const randomMemberIndex = Math.floor(Math.random() * members.length);
    const member = members[randomMemberIndex];

    // Seleciona uma penalidade aleatória
    const randomPenaltyIndex = Math.floor(Math.random() * penalties.length);
    const penalty = penalties[randomPenaltyIndex];

    // Adiciona a penalidade ao histórico
    addToPenaltyHistory(team.name, member.role, member.name, penalty);

    // Exibe a penalidade
    showPenalty(team.name, member.role, member.name, penalty);

    // Remove a penalidade após 10 segundos
    setTimeout(() => {
      clearPenalty();
    }, 600000); // 10 MINUTOS (600000 ms)
  }

  // Função para adicionar uma penalidade ao histórico
  function addToPenaltyHistory(teamName, memberRole, memberName, penalty) {
    // Adiciona a nova penalidade ao início do array
    recentPenalties.unshift({
      teamName,
      memberRole,
      memberName,
      penalty,
    });

    // Mantém apenas as últimas 5 penalidades
    if (recentPenalties.length > 5) {
      recentPenalties.pop();
    }

    // Atualiza o histórico na interface
    updatePenaltyHistory();
  }

  // Função para atualizar o histórico de penalidades na interface
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

      const teamInfo = `
                      <h3>${team.name}</h3>
                      <p><strong>Scrum Master:</strong> ${team.scrumMaster}</p>
                      <p><strong>Product Owner:</strong> ${
                        team.productOwner
                      }</p>
                      <p><strong>Desenvolvedor Frontend:</strong> ${
                        team.frontendDev
                      }</p>
                      <p><strong>Desenvolvedor Backend:</strong> ${
                        team.backendDev
                      }</p>
                      <p><strong>Designer UX/UI:</strong> ${team.designer}</p>
                      <h4>Timer: <span id="timer-${team.name}">${formatTime(
        team.time
      )}</span></h4>
                      <h4>Dinheiro: <span id="money-${team.name}">${
        team.money
      }</span></h4>
                      <input type="number" id="timeIncrement-${
                        team.name
                      }" placeholder="Ajustar tempo" />
                      <input type="number" id="moneyIncrement-${
                        team.name
                      }" placeholder="Ajustar dinheiro" />
                      <button onclick="changeTime('${
                        team.name
                      }')">Alterar Tempo</button>
                      <button onclick="changeMoney('${
                        team.name
                      }')">Alterar Dinheiro</button>
                      <ul id="penalties-${team.name}">
                        ${team.penalties
                          .map((penalty) => `<li>${penalty}</li>`)
                          .join("")}
                      </ul>
                    `;

      teamCard.innerHTML = teamInfo;
      teamsList.appendChild(teamCard);
    });
  }

  // Função para formatar o tempo
  function formatTime(seconds) {
    const hours = Math.floor(seconds / 3600);
    const minutes = Math.floor((seconds % 3600) / 60);
    const secs = seconds % 60;
    return `${hours}h ${minutes}m ${secs}s`;
  }

  // Função para iniciar o timer da equipe
  function startTimer(team) {
    // Se o timer ainda não foi iniciado, inicie
    if (!team.timerInterval) {
      team.timerInterval = setInterval(() => {
        if (team.time > 0) {
          team.time--;
          updateTimer(team); // Atualiza apenas o timer
        } else {
          clearInterval(team.timerInterval);
          team.timerInterval = null; // Permite reiniciar o timer se necessário
        }
      }, 1000); // Decrementa a cada segundo
    }
  }

  // Função para atualizar apenas o timer de uma equipe
  function updateTimer(team) {
    const timerElement = document.getElementById(`timer-${team.name}`);
    if (timerElement) {
      timerElement.textContent = formatTime(team.time);
    }
  }

  // Função para alterar o tempo da equipe
  window.changeTime = function (teamName) {
    const team = teams.find((t) => t.name === teamName);
    const incrementValue = document.getElementById(
      `timeIncrement-${teamName}`
    ).value;

    if (team && incrementValue) {
      // Adiciona o valor ao tempo sem limpar o intervalo
      team.time += parseInt(incrementValue);
      updateTimer(team); // Atualiza apenas o timer
    }
  };

  // Função para alterar o dinheiro da equipe
  window.changeMoney = function (teamName) {
    const team = teams.find((t) => t.name === teamName);
    const incrementValue = document.getElementById(
      `moneyIncrement-${teamName}`
    ).value;
    if (team && incrementValue) {
      team.money += parseInt(incrementValue);
      const moneyElement = document.getElementById(`money-${teamName}`);
      if (moneyElement) {
        moneyElement.textContent = team.money;
      }
    }
  };
});
