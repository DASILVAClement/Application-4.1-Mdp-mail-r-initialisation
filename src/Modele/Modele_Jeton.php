<?php
//test



//dvnizeovn


namespace App\Modele;

class Modele_Jeton {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function genererJeton($idUtilisateur) {
        $octetsAleatoires = openssl_random_pseudo_bytes(256);
        $jeton = sodium_bin2base64($octetsAleatoires, SODIUM_BASE64_VARIANT_ORIGINAL);
        $dateFin = date('Y-m-d H:i:s', strtotime('+1 hour'));
        $this->stockerJeton($jeton, $idUtilisateur, $dateFin);
        return $jeton;
    }

    private function stockerJeton($jeton, $idUtilisateur, $dateFin) {
        $stmt = $this->db->prepare("INSERT INTO token (valeur, codeAction, idUtilisateur, dateFin) VALUES (?, ?, ?, ?)");
        $codeAction = 1; // Code action pour la réinitialisation du mot de passe
        $stmt->bind_param("sdis", $jeton, $codeAction, $idUtilisateur, $dateFin);
        $stmt->execute();
        $stmt->close();
    }

    public function recupererJeton($jeton) {
        $stmt = $this->db->prepare("SELECT * FROM token WHERE valeur = ?");
        $stmt->bind_param("s", $jeton);
        $stmt->execute();
        $result = $stmt->get_result();
        $tokenData = $result->fetch_assoc();
        $stmt->close();
        return $tokenData;
    }

    public function invaliderJeton($jeton) {
        // Suppression du jeton après utilisation
        $stmt = $this->db->prepare("DELETE FROM token WHERE valeur = ?");
        $stmt->bind_param("s", $jeton);
        $stmt->execute();
        $stmt->close();
    }
}

?>