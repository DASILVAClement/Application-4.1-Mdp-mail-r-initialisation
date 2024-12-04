<?php
//error_log("page debut");
session_start();
include_once "vendor/autoload.php";

use App\Modele\Modele_Jeton;
use App\Modele\Modele_Utilisateur;
use App\Utilitaire\Vue;
use App\Vue\Vue_AfficherMessage;
use App\Vue\Vue_Connexion_Formulaire_client;
use App\Vue\Vue_Mail_ChoisirNouveauMdp;
use App\Vue\Vue_Menu_Administration;
use App\Vue\Vue_Structure_Entete;


//Page appelée pour les utilisateurs publics


$Vue = new Vue();

//Charge le gestionnaire de vue


if (isset($_SESSION["typeConnexionBack"])) {
    $typeConnexion = $_SESSION["typeConnexionBack"];
} else {
    $typeConnexion = "visiteur";
}
//error_log("typeConnexion : " . $typeConnexion)  ;
//utiliser en débuggage pour avoir le type de connexion
//$Vue->addToCorps(new Vue_AfficherMessage("<br>typeConnexion $typeConnexion<br>"));

//Identification du cas demandé (situation)
if (isset($_REQUEST["case"]))
    $case = $_REQUEST["case"];
else
    $case = "Cas_Par_Defaut";
//error_log("case : " . $case);
//utiliser en débuggage pour avoir le type de connexion
//$Vue->addToCorps(new Vue_AfficherMessage("<br>Case $case<br>"));

//Identification de l'action demandée
if (isset($_REQUEST["action"]))
    $action = $_REQUEST["action"];
else
    $action = "Action_Par_Defaut";
//error_log("action : " . $action);
//utiliser en débuggage pour avoir le type de connexion
//$Vue->addToCorps(new Vue_AfficherMessage("<br>Action $action<br>"));


function handlePasswordChoice($Vue)
{
    $token = $_POST['token'] ?? '';
    error_log("Jeton soumis : $token");

    $mdp1 = $_POST['mdp1'] ?? '';
    $mdp2 = $_POST['mdp2'] ?? '';

    if ($token && $mdp1 && $mdp2) {
        if ($mdp1 === $mdp2) {
            $jetonData = Modele_Jeton::search($token);
            error_log("Jeton data : " . print_r($jetonData, true));

            if ($jetonData && strtotime($jetonData['dateFin']) > time()) {
                $hashedPassword = password_hash($mdp1, PASSWORD_BCRYPT);
                Modele_Utilisateur::Utilisateur_Modifier_motDePasse($jetonData['idUtilisateur'], $hashedPassword);
                Modele_Jeton::update($jetonData['id']);

                $Vue->addToCorps(new Vue_Connexion_Formulaire_client("Mot de passe réinitialisé avec succès."));
            } else {
                $Vue->addToCorps(new Vue_Connexion_Formulaire_client("Jeton invalide ou expiré après soumission."));
                error_log("Jeton invalide ou expiré.");
            }
        } else {
            $Vue->addToCorps(new Vue_Mail_ChoisirNouveauMdp("Les mots de passe ne correspondent pas. Veuillez réessayer."));
            error_log("Les mots de passe ne correspondent pas.");
        }
    } else {
        $Vue->addToCorps(new Vue_Mail_ChoisirNouveauMdp("Veuillez remplir tous les champs pour réinitialiser votre mot de passe."));
        error_log("Champs manquants lors de la soumission du mot de passe.");
    }
}


switch ($typeConnexion) {
    case "visiteur" :
        switch ($case) {
            case "RGPD":
                include "Controleur/Controleur_AccepterRGPD.php";
                break;
            default:
                include "Controleur/Controleur_visiteur.php";
        }
        break;
    case "gestionnaireCatalogue":
    case "commercialCafe":
    case "administrateurLogiciel":
        switch ($case) {
            case "Gerer_CommandeClient":
            case "Gerer_Commande":
                include "Controleur/Controleur_Gerer_Commande.php";
                break;
            case "Gerer_entreprisesPartenaires":
                include "Controleur/Controleur_Gerer_entreprisesPartenaires.php";
                break;
            case "Gerer_utilisateur":
                include "Controleur/Controleur_Gerer_utilisateur.php";
                break;
            case "Gerer_catalogue":
                include "Controleur/Controleur_Gerer_catalogue.php";
                break;
            case "Gerer_monCompte":
                include "Controleur/Controleur_Gerer_monCompte.php";
                break;
            default:
                $Vue->setMenu(new Vue_Menu_Administration($typeConnexion));
                break;
        }
        break;
    case "entrepriseCliente" :
    case "salarieEntrepriseCliente" :
        switch ($case) {

            case "Gerer_CommandeClient":
                include "Controleur/Controleur_Gerer_CommandeClient.php";
                break;
            case "Gerer_Panier":
                include "Controleur/Controleur_Gerer_Panier.php";
                break;
            case "Gerer_MonCompte_Salarie":
                include "Controleur/Controleur_Gerer_MonCompte_Salarie.php";
                break;
            case "Gerer_monCompte" :
            case "Gerer_Entreprise" :
                include "Controleur/Controleur_Gerer_Entreprise.php";
                break;
            case "Cas_Par_Defaut":
            case "Gerer_catalogue":
            case "Catalogue_client":
            default:
                include "Controleur/Controleur_Catalogue_client.php";
                break;
        }

    switch ($action) {
        case "token":
            if (isset($_GET['token'])) {
                $tokenValue = $_GET['token'];
                $jetonData = Modele_Jeton::search($tokenValue);

                if ($jetonData && strtotime($jetonData['dateFin']) > time()) {
                    $Vue->addToCorps(new Vue_Mail_ChoisirNouveauMdp($tokenValue));
                } else {
                    $Vue->addToCorps(new Vue_Connexion_Formulaire_client("Jeton invalide ou expiré."));
                }
            } else {
                $Vue->addToCorps(new Vue_Connexion_Formulaire_client("Jeton manquant ou URL incorrecte."));
            }
            break;

        case "choixmdp":
            handlePasswordChoice($Vue);
            break;

        default:
            $Vue->addToCorps(new Vue_Connexion_Formulaire_client());
            break;
    }

    case "token":
        $token = $_GET['token'] ?? '';
        if ($token) {
            $Vue->addToCorps(new Vue_Mail_ChoisirNouveauMdp($tokenValue));

        }


        break;

    default:
        $Vue->addToCorps(new Vue_AfficherMessage("Type de connexion non reconnu"));
}


$Vue->afficher();
