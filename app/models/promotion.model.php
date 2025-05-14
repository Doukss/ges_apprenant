<?php
function findAllPromotion($search = '') {
    $searchParam = '%' . $search . '%';

    $sql = "
        SELECT 
            p.nom AS promotion,
            p.date_debut,
            p.date_fin,
            p.statut,
            r.libelle AS referentiel,
            COUNT(a.id) AS nombre_apprenants
        FROM 
            promotion p
        LEFT JOIN 
            referentiel_promotion pr ON p.id = pr.id_promotion
        LEFT JOIN 
            referentiel r ON pr.id_referentiel = r.id
        LEFT JOIN 
            apprenant a ON p.id = a.id
    ";

    if (!empty($search)) {
        $sql .= " WHERE p.nom LIKE :search OR r.libelle LIKE :search ";
    }

    $sql .= "
        GROUP BY 
            p.id, p.nom, p.date_debut, p.date_fin, p.statut, r.libelle
        ORDER BY 
            p.date_debut DESC
    ";

    try {
        $params = [];
        if (!empty($search)) {
            $params[':search'] = $searchParam;
        }

        return executeSelect($sql, true, $params);
    } catch (PDOException $e) {
        echo "Erreur lors de la connexion : " . $e->getMessage();
        return null;
    }
}
