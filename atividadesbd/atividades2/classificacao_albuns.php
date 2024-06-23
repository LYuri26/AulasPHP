<?php
// Arrays separados para os álbuns e anos de lançamento do Linkin Park
$albuns = [
    "Hybrid Theory",
    "Meteora",
    "Minutes to Midnight",
    "A Thousand Suns",
    "Living Things"
];

$anos = [
    2000,
    2003,
    2007,
    2010,
    2012
];

// Ordenar os álbuns por ordem crescente de lançamento
array_multisort($anos, $albuns);

// Exibir os álbuns ordenados
for ($i = 0; $i < count($albuns); $i++) {
    echo $albuns[$i] . " - " . $anos[$i] . "<br>";
}
?>
