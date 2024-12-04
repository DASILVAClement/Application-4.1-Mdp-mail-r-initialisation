<?php

namespace App\Modele;

class Modele_Jeton {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    // Méthode pour insérer un jeton
    // Méthode pour insérer un jeton
    public function insert($idUtilisateur, $jeton, $dateExpiration) {
        $stmt = $this->mysqli->prepare("INSERT INTO token (valeur, codeAction, idUtilisateur, dateFin) VALUES (?, ?, ?, ?)");
        $codeAction = 1; // Exemple de code d'action, à ajuster selon vos besoins
        $stmt->bind_param("siss", $jeton, $codeAction, $idUtilisateur, $dateExpiration);
        $stmt->execute();
        $stmt->close();
    }

    // Méthode pour mettre à jour un jeton pour le déclarer utilisé
    public function update($jeton) {
        $stmt = $this->mysqli->prepare("UPDATE token SET codeAction = 0 WHERE valeur = ?");
        $stmt->bind_param("s", $jeton);
        $stmt->execute();
        $stmt->close();
    }

    // Méthode pour rechercher un jeton par sa valeur
    public function recherche($jeton) {
        $stmt = $this->mysqli->prepare("SELECT * FROM token WHERE valeur = ?");
        $stmt->bind_param("s", $jeton);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        $stmt->close();
        return $data;
    }

    // Exemple de génération de jeton avec insertion
    public function genererJeton($idUtilisateur) {
        $jeton = bin2hex(random_bytes(16)); // Génération d'un jeton aléatoire
        $dateExpiration = (new \DateTime())->modify('+1 day')->format('Y-m-d H:i:s'); // Définir la date d'expiration
        $this->insert($idUtilisateur, $jeton, $dateExpiration);
        return $jeton;
    }

    // Exemple de récupération de jeton
    public function recupererJeton($jeton) {
        return $this->recherche($jeton);
    }

    // Exemple d'invalidation de jeton
    public function invaliderJeton($jeton) {
        $this->update($jeton);
    }
}
