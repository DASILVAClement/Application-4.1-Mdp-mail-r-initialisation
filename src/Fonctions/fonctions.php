<?php
namespace App\Fonctions;
use PHPMailer\PHPMailer\PHPMailer;

function Redirect_Self_URL():void{
    unset($_REQUEST);
    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
}

function GenereMDP($nbChar) :string{

    return "secret";
}

function passgen1($nbChar)
{
//    $chaine = "ABCDEFGHIJKLMONOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789&é\"'(-è_çà)=$^*ù!:;,~#{[|`\^@]}¤€";
    $chaine = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^*";
    $pass = '';
    $longueurChaine = strlen($chaine);
    for ($i = 0; $i < $nbChar; $i++) {
        $indexAleatoire = random_int(0, $longueurChaine - 1);
        $pass .= $chaine[$indexAleatoire];
    }
    return $pass;
}

function envoyerMail($nouveauMDP) {
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->Host = '127.0.0.1';
    $mail->Port = 1025; //Port non crypté
    $mail->SMTPAuth = false; //Pas d’authentification
    $mail->SMTPAutoTLS = false; //Pas de certificat TLS
    $mail->setFrom('test@labruleriecomtoise.fr', 'admin');
    $mail->addAddress($_REQUEST["email"], 'Mon client');
    if ($mail->addReplyTo('test@labruleriecomtoise.fr', 'admin')) {
        $mail->Subject = 'Objet : Bonjour !';
        $mail->isHTML(false);
        $mail->Body = "Voici votre nouveau mot de passe : $nouveauMDP";

        if (!$mail->send()) {
            $msg = 'Désolé, quelque chose a mal tourné. Veuillez réessayer plus tard.';
        } else {
            $msg = 'Message envoyé ! Merci de nous avoir contactés.';
        }
    } else {
        $msg = 'Il doit manquer qqc !';
    }
    echo $msg;
}
function CalculComplexiteMdp($mdp): float {
    $longueur = strlen($mdp);
    $ensemble = 0;

    // Vérifie les différents types de caractères et ajuste la taille de l'ensemble
    if (preg_match('/[a-z]/', $mdp)) {
        $ensemble += 26; // Lettres minuscules
    }
    if (preg_match('/[A-Z]/', $mdp)) {
        $ensemble += 26; // Lettres majuscules
    }
    if (preg_match('/[0-9]/', $mdp)) {
        $ensemble += 10; // Chiffres
    }
    if (preg_match('/[\W_]/', $mdp)) {
        $ensemble += 32; // Caractères spéciaux (approximatif)
    }

    // Calcul de l'entropie
    $entropie = $longueur * log($ensemble, 2);

    return $entropie;
}