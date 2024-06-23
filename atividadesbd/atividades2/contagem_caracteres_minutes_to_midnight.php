<?php
// Array com os títulos das músicas do álbum "Minutes to Midnight" do Linkin Park
$musicas_minutes_to_midnight = [
    "Wake",
    "Given Up",
    "Leave Out All the Rest",
    "Bleed It Out",
    "Shadow of the Day",
    "What I've Done",
    "Hands Held High",
    "No More Sorrow",
    "Valentine's Day",
    "In Between",
    "In Pieces",
    "The Little Things Give You Away"
];

// Contar e exibir o número de caracteres em cada título de música
$num_musicas = count($musicas_minutes_to_midnight); // Obter o número total de músicas
for ($i = 0; $i < $num_musicas; $i++) {
    $musica = $musicas_minutes_to_midnight[$i]; // Obter cada título de música
    $quantidade_caracteres = strlen($musica); // Contar os caracteres do título de música
    echo "$musica - $quantidade_caracteres caracteres<br>"; // Exibir o título e a contagem de caracteres
}
?>
