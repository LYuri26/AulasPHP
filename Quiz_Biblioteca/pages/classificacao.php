<!DOCTYPE html>
<html lang="pt-BR">
<meta name="viewport" content="width=device-width, initial-scale=1">


<body>
    <header>
        <a href="/">
            <img src="../images/Senai.png" alt="Logo SENAI" class="logo-senai">
        </a>
        <title>Classificação</title>
        <link rel="stylesheet" href="../styles/classificacao.css">
    </header>
    <h1>Pódio</h1>
    <div class="menu-container">
        <div class="scrollable-table">
            <table>
                <thead>
                    <tr>
                        <th>Colocação</th>
                        <th>Nome</th>
                        <th>Pontuação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include_once '../backend/consulta_dados.php';
                    if (is_array($data)) {
                        foreach ($data as $item) {
                            echo "<tr>";
                            echo "<td>{$item['classificacao']}</td>";
                            echo "<td>{$item['nome']}</td>";
                            echo "<td>{$item['pontuacao']}</td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <footer>

        Jogo desenvolvido pela turma de Desenvolvimento de Sistemas Trilhas de Futuro 02/2022.
    </footer>
</body>

</html>