<?php
// Array com as faixas do álbum "Hybrid Theory"
$hybrid_theory = [
    "Papercut",
    "One Step Closer",
    "With You",
    "Points of Authority",
    "Crawling",
    "Runaway",
    "By Myself",
    "In the End",
    "A Place for My Head",
    "Forgotten",
    "Cure for the Itch",
    "Pushing Me Away"
];

// Contar o número de faixas
$total_faixas = count($hybrid_theory);

// Loop para exibir cada faixa
for ($i = 0; $i < $total_faixas; $i++) {
    echo $hybrid_theory[$i] . "<br>";
}
?>
