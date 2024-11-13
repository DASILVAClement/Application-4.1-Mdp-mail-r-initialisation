<?php

function CalculComplexiteMdp(string $motDePasse): int {
$longueur = strlen($motDePasse);
$tailleJeuCaracteres = 0;

if (preg_match('/[a-z]/', $motDePasse)) {
$tailleJeuCaracteres += 26;
}
if (preg_match('/[A-Z]/', $motDePasse)) {
$tailleJeuCaracteres += 26;
}
if (preg_match('/[0-9]/', $motDePasse)) {
$tailleJeuCaracteres += 10;
}
if (preg_match('/[^a-zA-Z0-9]/', $motDePasse)) {
$tailleJeuCaracteres += 32;
}

$entropie = $longueur * log($tailleJeuCaracteres, 2);

return (int) round($entropie);
}
