<?php
// Verificar se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obter a música escolhida
    $musica = $_POST['musica'];
    
    // Exibir uma mensagem personalizada
    if ($musica == "Numb") {
        echo "Você escolheu 'Numb'. Uma ótima escolha para momentos introspectivos!";
    } elseif ($musica == "In the End") {
        echo "Você escolheu 'In the End'. Uma música perfeita para reflexões profundas!";
    } else {
        echo "Por favor, escolha uma música.";
    }
}
?>
