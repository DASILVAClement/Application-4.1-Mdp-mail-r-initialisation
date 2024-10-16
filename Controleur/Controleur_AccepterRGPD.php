<?php

use App\Modele\Modele_Utilisateur;
use App\Vue\Vue_ConsentementRGPD;
use App\Vue\Vue_Structure_BasDePage;
use App\Vue\Vue_Structure_Entete;

$Vue->setEntete(new Vue_Structure_Entete());

switch ($action) {
    case "AccepterRGPD":
        if (isset($_POST['consentement']) && $_POST['consentement'] == 'on') {
            $ip = $_SERVER['REMOTE_ADDR'];
            $date = date('Y-m-d H:i:s');
            Modele_Utilisateur::updateConsentement($_SESSION["idUtilisateur"], 1, $date, $ip);
            header("Location: index.php");
        } else {
            $Vue->addToCorps(new Vue_ConsentementRGPD("Vous devez accepter les termes pour continuer."));
        }
        break;
    case "RefuserRGPD":
        session_destroy();
        header("Location: index.php");
        break;
    default:
        $Vue->addToCorps(new Vue_ConsentementRGPD());
        break;
}

$Vue->setBasDePage(new Vue_Structure_BasDePage());