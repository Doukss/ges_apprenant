<?php
function findAllReferentiels() {
    $sql = "
        SELECT 
            id,
            libelle
        FROM 
            referentiel
        ORDER BY 
            libelle ASC
    ";

    try {
        return executeSelect($sql, true);
    } catch (PDOException $e) {
        return ['error' => $e->getMessage()];
    }
}

function findReferentielById($id) {
    $sql = "
        SELECT 
            id,
            libelle
        FROM 
            referentiel
        WHERE 
            id = :id
        LIMIT 1
    ";

    try {
        $result = executeSelect($sql, false, [':id' => $id]);
        return $result ?: null;
    } catch (PDOException $e) {
        return null;
    }
}

function getReferentielStats() {
    $sql = "
        SELECT 
            COUNT(*) as total_referentiels
        FROM 
            referentiel
    ";

    try {
        $result = executeSelect($sql, false);
        return [
            'total_referentiels' => $result['total_referentiels'] ?? 0
        ];
    } catch (PDOException $e) {
        return [
            'total_referentiels' => 0
        ];
    }
} 