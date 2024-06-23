<?php
// Array com os títulos das músicas do álbum "Meteora" do Linkin Park
$faixas_meteora = [
    "Foreword",
    "Don't Stay",
    "Somewhere I Belong",
    "Lying from You",
    "Hit the Floor",
    "Easier to Run",
    "Faint",
    "Figure.09",
    "Breaking the Habit",
    "From the Inside",
    "Nobody's Listening",
    "Session",
    "Numb"
];

// Contar e exibir o número de caracteres em cada título de música
$total_faixas = count($faixas_meteora); // Obter o número total de faixas
for ($i = 0; $i < $total_faixas; $i++) {
    $faixa = $faixas_meteora[$i]; // Obter cada título de música
    $quantidade_caracteres = strlen($faixa); // Contar os caracteres do título de música
    echo "$faixa - $quantidade_caracteres caracteres<br>"; // Exibir o título e a contagem de caracteres
}
?>
