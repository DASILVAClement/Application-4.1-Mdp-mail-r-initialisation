<?php
namespace App\Vue;
use App\Utilitaire\Vue_Composant;

class Vue_Connexion_Formulaire_client extends Vue_Composant
{
    private string $msgErreur;

    public function __construct(string $msgErreur = "")
    {
        $this->msgErreur = $msgErreur;
    }

    function donneTexte(): string
    {
        $str = "
        <h1>Café : Connexion</h1>
        <div style='width: 50%; display: block; margin: auto;'>  
            <form action='index.php' method='post'>
                <h2>Connexion</h2>
                
                <label for='compte'><b>Compte</b></label>
                <input type='text' id='compte' placeholder='Identifiant du compte' name='compte' required>

                <label for='password'><b>Mot de passe</b></label>
                <input type='password' id='password' placeholder='Mot de passe' name='password' required>
                
                <button type='submit' id='submit' name='action' value='Se connecter'>
                    Se connecter
                </button>";

        if ($this->msgErreur != "") {
            $str .= "<p style='color: red;'><b>Erreur : {$this->msgErreur}</b></p>";
        }

        $str .= "
            </form>
            <form action='index.php' method='post'>
                <h2>Mot de passe perdu ?</h2>

                <button type='submit' id='submit' name='action' value='reinitmdp'>
                    Réinitialiser le mot de passe
                </button>
            </form>
        </div>";

        return $str;
    }
}