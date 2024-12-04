<?php

require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/../src/Modele/Modele_Jeton.php";
require_once __DIR__ . "/../src/Utilitaire/Singleton_ConnexionPDO.php";

use App\Modele\Modele_Jeton;

// Connexion à la base de données (modifiez les paramètres si nécessaire)
$mysqli = new mysqli("localhost", "root", "", "bddcafe2024");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$modeleJeton = new Modele_Jeton($mysqli);

// Test de génération de jeton pour un utilisateur fictif
$idUtilisateur = 1; // Remplacez par un ID utilisateur existant
$jeton = $modeleJeton->genererJeton($idUtilisateur);
echo "Jeton généré : " . $jeton . "\n";

// Test de récupération du jeton
$tokenData = $modeleJeton->recupererJeton($jeton);
echo "Données du jeton récupérées : \n";
print_r($tokenData);

// Test d'invalidation du jeton
$modeleJeton->invaliderJeton($jeton);
echo "Jeton invalidé.";

?>