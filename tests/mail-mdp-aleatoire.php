<?php
// function passgen1($nbChar) {
//    $chaine ="mnoTUzS5678kVvwxy9WXYZRNCDEFrslq41GtuaHIJKpOPQA23LcdefghiBMbj0";
//    srand((double)microtime()*1000000);
//    $pass = '';
//    for($i=0; $i<$nbChar; $i++){
//        $pass .= $chaine[rand()%strlen($chaine)];
//        }
//    return $pass;
//    }
//
//    function passgen2($nbChar){
//    return substr(str_shuffle(
//'abcdefghijklmnopqrstuvwxyzABCEFGHIJKLMNOPQRSTUVWXYZ0123456789'),1, $nbChar); }
//
//echo passgen1(10);
//echo"\n";
//echo passgen2(10);


//function passgen1($nbChar) {
//    $chaine = "mnoTUzS5678kVvwxy9WXYZRNCDEFrslq41GtuaHIJKpOPQA23LcdefghiBMbj0";
//    srand((double)microtime() * 1000000);
//    $pass = '';
//    for ($i = 0; $i < $nbChar; $i++) {
//        $pass .= $chaine[rand() % strlen($chaine)];
//    }
//    return $pass;
//}
//
//for ($i = 0; $i < 1000000; $i++) {
//    $password = passgen1(10);
//    echo $password . "\n";
//}



////Création de la séquence aléatoire à la base du mot de passe
//$octetsAleatoires = openssl_random_pseudo_bytes (12) ;
////Transformation de la séquence binaire en caractères alpha
//$motDePasse = sodium_bin2base64($octetsAleatoires, SODIUM_BASE64_VARIANT_ORIGINAL);
//echo $motDePasse;

function passgen1($nbChar)
{
    $chaine = "ABCDEFGHIJKLMONOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789&é\"'(-è_çà)=$^*ù!:;,~#{[|`\^@]}¤€";
    $pass = '';
    $longueurChaine = strlen($chaine);
    for ($i = 0; $i < $nbChar; $i++) {
        $indexAleatoire = random_int(0, $longueurChaine - 1);
        $pass .= $chaine[$indexAleatoire];
    }
    return $pass;
}

echo passgen1(10);