<?php
function findAllPromotion() {
    $sql = "
        SELECT 
    p.nom AS promotion,
    p.date_debut,
    p.date_fin,
    p.statut,
    r.libelle AS referentiel,
    COUNT(a.id_apprenant) AS nombre_apprenants
FROM 
    promotion p
LEFT JOIN 
    promoref pr ON p.id_promotion = pr.id_promotion
LEFT JOIN 
    referentiel r ON pr.id_referentiel = r.id_referentiel
LEFT JOIN 
    apprenant a ON p.id_promotion = a.id_promotion
GROUP BY 
    p.id_promotion, p.nom, p.date_debut, p.date_fin, p.statut, r.libelle
ORDER BY 
    p.date_debut DESC;
    ";

    
    try {
        return executeSelect($sql, True);
    } catch (PDOException $e) {
        echo "Erreur lors de la connexion : " . $e->getMessage();
        return null;
    }
}