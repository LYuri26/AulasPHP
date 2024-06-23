<?php
// Arrays com os primeiros nomes e sobrenomes dos membros originais do Linkin Park
$primeiros_nomes = ["Chester", "Mike", "Joe", "Brad", "Rob"];
$sobrenomes = ["Bennington", "Shinoda", "Hahn", "Delson", "Bourdon"];

// Exibir o nome completo de cada membro
for ($i = 0; $i < count($primeiros_nomes); $i++) {
    $nome_completo = $primeiros_nomes[$i] . " " . $sobrenomes[$i];
    echo "Membro " . ($i + 1) . ": $nome_completo<br>";
}
?>
