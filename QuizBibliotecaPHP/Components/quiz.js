document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("quizForm");
  const nomeInput = document.getElementById("nome");
  const perguntaContainer = document.getElementById("perguntaContainer");
  const finalizarQuizButton = document.getElementById("finalizarQuiz");
  const resultadoFinal = document.getElementById("resultadoFinal");
  const resultadoNome = document.getElementById("resultadoNome");
  const resultadoPontuacao = document.getElementById("resultadoPontuacao");
  const reiniciarJogoButton = document.getElementById("reiniciarJogo");

  let currentPergunta = 0;
  let pontuacao = 0;
  let perguntas = [
    {
      pergunta: "Qual autor escreveu o livro 'Dom Casmurro'?",
      opcoes: [
        { texto: "Machado de Assis", valor: 10 },
        { texto: "José de Alencar", valor: 0 },
        { texto: "Érico Veríssimo", valor: 0 },
        { texto: "Monteiro Lobato", valor: 0 },
      ],
    },
    // Adicione outras perguntas aqui ...
    {
      pergunta:
        "Qual é o título do livro que conta a história de um grupo de animais que vivem em uma fazenda e se rebelam contra os humanos?",
      opcoes: [
        { texto: "A Revolução dos Bichos", valor: 10 },
        { texto: "A Ilha dos Cachorros", valor: 0 },
        { texto: "O Poderoso Chefão", valor: 0 },
        { texto: "A Máquina do Tempo", valor: 0 },
      ],
    },
  ];

  function mostrarPergunta() {
    const perguntaAtual = perguntas[currentPergunta];
    const opcoesHTML = perguntaAtual.opcoes
      .map(
        (opcao) =>
          `<div class="opcao"><button type="button" class="opcaoButton" data-valor="${opcao.valor}">${opcao.texto}</button></div>`
      )
      .join("");

    perguntaContainer.innerHTML = `
    <div class="pergunta">${perguntaAtual.pergunta}</div>
    ${opcoesHTML}
  `;

    nomeInput.addEventListener("input", function () {
      finalizarQuizButton.disabled = nomeInput.value.trim() === "";
    });

    const opcaoButtons = document.querySelectorAll(".opcaoButton");
    opcaoButtons.forEach((button) => {
      button.addEventListener("click", function () {
        if (
          nomeInput.value.trim() !== "" &&
          currentPergunta < perguntas.length
        ) {
          pontuacao += parseInt(this.dataset.valor);
          currentPergunta++;
          mostrarPergunta();
        }
      });
    });

    form.addEventListener("submit", function (event) {
      event.preventDefault();
    });
  }

  function mostrarResultadoFinal() {
    form.style.display = "none";
    resultadoFinal.style.display = "block";
    resultadoNome.textContent = nomeInput.value;
    resultadoPontuacao.textContent = pontuacao;
    finalizarQuizButton.disabled = true;

    const formData = new FormData();
    formData.append("nome", nomeInput.value);
    formData.append("pontuacao", pontuacao);

    fetch("../DataBase/inserir_dados.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.text())
      .then((data) => console.log(data))
      .catch((error) => console.error(error));

    document
      .getElementById("reiniciarJogo")
      .addEventListener("click", reiniciarJogo);
  }

  nomeInput.addEventListener("input", function () {
    finalizarQuizButton.disabled = nomeInput.value.trim() === "";
  });

  const reiniciarPagina = () => {
    setTimeout(() => {
      window.location.reload();
    }, 5000);
  };

  const reiniciarJogo = () => {
    nomeInput.value = "";
    currentPergunta = 0;
    pontuacao = 0;
    form.style.display = "block";
    resultadoFinal.style.display = "none";
    mostrarPergunta();
    reiniciarPagina();
  };

  mostrarPergunta();
});
