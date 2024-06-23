<?php
// Função para contar quantas vezes o refrão aparece na letra de forma simples
function contaRefrao($letra, $refrao) {
    // Inicializa a contagem do refrão como zero
    $quantidade = 0;
    
    // Pega o comprimento da letra e do refrão
    $tamanhoLetra = strlen($letra);
    $tamanhoRefrao = strlen($refrao);

    // Percorre a letra procurando o refrão
    for ($i = 0; $i <= $tamanhoLetra - $tamanhoRefrao; $i++) {
        // Verifica se o trecho da letra a partir da posição atual é igual ao refrão
        if (substr($letra, $i, $tamanhoRefrao) === $refrao) {
            // Se for igual, aumenta a contagem
            $quantidade++;
        }
    }

    // Retorna a quantidade de vezes que o refrão apareceu
    return $quantidade;
}


// Trecho da letra de "Numb"
$letra = "I'm tired of being what you want me to be
Feeling so faithless, lost under the surface
I don't know what you're expecting of me
Put under the pressure of walking in your shoes

(Caught in the undertow, just caught in the undertow)
Every step that I take is another mistake to you
(Caught in the undertow, just caught in the undertow)

I've become so numb, I can't feel you there
Become so tired, so much more aware
I'm becoming this, all I want to do
Is be more like me and be less like you

Can't you see that you're smothering me?
Holding too tightly, afraid to lose control
'Cause everything that you thought I would be
Has fallen apart right in front of you

(Caught in the undertow, just caught in the undertow)
Every step that I take is another mistake to you
(Caught in the undertow, just caught in the undertow)
And every second I waste is more than I can take

I've become so numb, I can't feel you there
Become so tired, so much more aware
I'm becoming this, all I want to do
Is be more like me and be less like you

And I know I may end up failing too
But I know you were just like me
With someone disappointed in you

I've become so numb, I can't feel you there
Become so tired, so much more aware
I'm becoming this, all I want to do
Is be more like me and be less like you

I've become so numb, I can't feel you there
(I'm tired of being what you want me to be)
I've become so numb, I can't feel you there
(I'm tired of being what you want me to be)";

// Refrão de "Numb"
$refrao = "I've become so numb";

// Chamar a função e exibir o resultado
$vezes = contaRefrao($letra, $refrao);
echo "O refrão 'I've become so numb' aparece $vezes vezes na letra.";
?>
