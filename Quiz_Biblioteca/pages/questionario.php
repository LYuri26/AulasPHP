<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz</title>
</head>

<body>
    <div class="menu-container">
        <header>
            <a href="/">
                <img src="../images/Senai.png" alt="Logo SENAI" class="logo-senai" />
            </a>
        </header>
        <h1>Quiz Semana da Biblioteca</h1>

        <label>
            Nome:
            <input type="text" id="nome" maxlength="40">
        </label>

        <button id="iniciarBtn" disabled>Iniciar</button>
    </div>

    <div id="perguntaContainer" style="display:none;">
        <!-- As perguntas e opções serão carregadas aqui -->
    </div>

    <div id="fimJogoContainer" style="display:none;">
        <h2>Fim de Jogo</h2>
        <p>Nome: <span id="nomeJogadorFim"></span></p>
        <p>Pontuação: <span id="pontuacaoJogadorFim"></span></p>
        <button id="reiniciarJogo">Reiniciar Jogo</button>
    </div>

    <footer>
        Jogo desenvolvido pela turma de Desenvolvimento de Sistemas Trilhas de Futuro 02/2022.
    </footer>

    <script src="../components/perguntas.js"></script>
    <script>
        let perguntaAtual = 0;
        let respostas = Array(perguntas.length).fill(null);
        let pontuacao = 0;
        let jogoFinalizado = false;

        document.getElementById('nome').addEventListener('input', function() {
            const iniciarBtn = document.getElementById('iniciarBtn');
            iniciarBtn.disabled = this.value.trim() === '';
        });

        document.getElementById('iniciarBtn').addEventListener('click', function() {
            const nome = document.getElementById('nome').value;
            const menuContainer = document.querySelector('.menu-container');
            const perguntaContainer = document.getElementById('perguntaContainer');

            menuContainer.style.display = 'none';
            perguntaContainer.style.display = 'block';
            criarPergunta();
        });

        const criarPergunta = () => {
            const perguntaContainer = document.getElementById('perguntaContainer');
            perguntaContainer.innerHTML = `
        <h3>${perguntas[perguntaAtual].pergunta}</h3>
        <div>
            ${perguntas[perguntaAtual].opcoes
                .map(
                    (opcao, index) => `
                        <button type="button" data-index="${index}" data-valor="${opcao.valor}" onclick="handleClickOpcao(event)">
                            ${opcao.texto}
                        </button>
                    `
                )
                .join('')}
        </div>
        <button id="finalizarJogo">Finalizar Jogo</button>
    `;

            const finalizarBtn = document.getElementById('finalizarJogo');
            finalizarBtn.addEventListener('click', finalizarJogo);
        };

        const handleClickOpcao = (event) => {
            const index = event.target.dataset.index;
            const valor = event.target.dataset.valor;

            if (!jogoFinalizado) {
                const novaResposta = [...respostas];
                novaResposta[perguntaAtual] = parseInt(valor);

                pontuacao += parseInt(valor);

                respostas = novaResposta;
                if (perguntaAtual + 1 < perguntas.length) {
                    perguntaAtual++;
                    criarPergunta();
                } else {
                    finalizarJogo();
                }
            }
        };

        const finalizarJogo = () => {
            const nome = document.getElementById('nome').value;
            const pontuacaoFinal = pontuacao;

            const nomeJogadorFim = document.getElementById('nomeJogadorFim');
            const pontuacaoJogadorFim = document.getElementById('pontuacaoJogadorFim');

            nomeJogadorFim.textContent = nome;
            pontuacaoJogadorFim.textContent = pontuacaoFinal;

            const perguntaContainer = document.getElementById('perguntaContainer');
            const fimJogoContainer = document.getElementById('fimJogoContainer');

            perguntaContainer.style.display = 'none';
            fimJogoContainer.style.display = 'block';

            // Enviar pontuação para o banco de dados aqui (usando uma requisição AJAX)
            const xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState === 4 && this.status === 200) {
                    console.log(this.responseText);
                }
            };

            xhttp.open('POST', '../backend/inserir_dados.php', true);
            xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhttp.send(`nome=${nome}&pontuacao=${pontuacaoFinal}`);
        };

        document.getElementById('reiniciarJogo').addEventListener('click', function() {
            location.reload();
        });
    </script>
</body>

</html>