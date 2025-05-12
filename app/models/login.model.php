<?php
function findUserConnect($email, $mot_de_passe) {
    $sql = "
        SELECT *
        FROM utilisateur u
        WHERE u.email = :email AND u.mot_de_passe = :mot_de_passe
    ";
    
    $params = [
        'email' => $email,
        'mot_de_passe' => $mot_de_passe
    ];
    
    try {
        return executeSelect($sql, false, $params);
    } catch (PDOException $e) {
        echo "Erreur lors de la connexion : " . $e->getMessage();
        return null;
    }
}

