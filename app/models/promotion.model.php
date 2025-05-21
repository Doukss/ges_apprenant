<?php
function findAllPromotion($search = '', $page = 1, $itemsPerPage = 6) {
    try {
        $db = connectToDatabase();
        
        // Validation des paramètres
        $page = max(1, (int)$page);
        $itemsPerPage = max(1, (int)$itemsPerPage);
        $offset = ($page - 1) * $itemsPerPage;
        $searchParam = '%' . $search . '%';

        // Requête pour obtenir le nombre total d'éléments
        $countSql = "
            SELECT COUNT(DISTINCT p.id) as total
            FROM promotion p
            LEFT JOIN referentiel_promotion pr ON p.id = pr.id_promotion
            LEFT JOIN referentiel r ON pr.id_referentiel = r.id
            LEFT JOIN apprenant a ON p.id = a.id
        ";

        if (!empty($search)) {
            $countSql .= " WHERE p.nom LIKE :search OR r.libelle LIKE :search ";
        }

        // Requête principale avec pagination
        $sql = "
            SELECT 
                p.id,
                p.nom AS promotion,
                p.date_debut,
                p.date_fin,
                p.statut,
                p.photo,
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
                p.id, p.nom, p.date_debut, p.date_fin, p.statut, p.photo, r.libelle
            ORDER BY 
                p.date_debut DESC
            LIMIT :limit OFFSET :offset
        ";

        // Exécuter la requête de comptage
        $stmt = $db->prepare($countSql);
        if (!empty($search)) {
            $stmt->bindParam(':search', $searchParam);
        }
        $stmt->execute();
        $total = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        // Si aucun résultat, retourner un tableau vide avec les métadonnées
        if ($total === 0) {
            return [
                'data' => [],
                'total' => 0,
                'current_page' => $page,
                'items_per_page' => $itemsPerPage,
                'total_pages' => 1
            ];
        }

        // Exécuter la requête principale
        $stmt = $db->prepare($sql);
        if (!empty($search)) {
            $stmt->bindParam(':search', $searchParam);
        }
        $stmt->bindParam(':limit', $itemsPerPage, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return [
            'data' => $results,
            'total' => $total,
            'current_page' => $page,
            'items_per_page' => $itemsPerPage,
            'total_pages' => ceil($total / $itemsPerPage)
        ];
    } catch (PDOException $e) {
        error_log("Erreur lors de la récupération des promotions : " . $e->getMessage());
        return null;
    }
}
