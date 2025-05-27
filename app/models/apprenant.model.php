<?php
// models/apprenant.model.php

function findAllApprenants($filters = [], $page = 1, $perPage = 10) {
    $db = connectToDatabase();
    $offset = ($page - 1) * $perPage;
    $where = [];
    $params = [];

    if (!empty($filters['matricule'])) {
        $where[] = "matricule LIKE ?";
        $params[] = "%" . $filters['matricule'] . "%";
    }
    if (!empty($filters['classe'])) {
        $where[] = "classe = ?";
        $params[] = $filters['classe'];
    }
    if (!empty($filters['statut'])) {
        $where[] = "statut = ?";
        $params[] = $filters['statut'];
    }

    $sql = "SELECT * FROM apprenant";
    if ($where) {
        $sql .= " WHERE " . implode(" AND ", $where);
    }
    $sql .= " ORDER BY nom, prenom LIMIT ? OFFSET ?";
    $params[] = $perPage;
    $params[] = $offset;

    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function countApprenants($filters = []) {
    $db = connectToDatabase();
    $where = [];
    $params = [];

    if (!empty($filters['matricule'])) {
        $where[] = "matricule LIKE ?";
        $params[] = "%" . $filters['matricule'] . "%";
    }
    if (!empty($filters['classe'])) {
        $where[] = "classe = ?";
        $params[] = $filters['classe'];
    }
    if (!empty($filters['statut'])) {
        $where[] = "statut = ?";
        $params[] = $filters['statut'];
    }

    $sql = "SELECT COUNT(*) as total FROM apprenant";
    if ($where) {
        $sql .= " WHERE " . implode(" AND ", $where);
    }

    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
}

function getApprenantById($id) {
    $db = connectToDatabase();
    $sql = "SELECT * FROM apprenant WHERE id = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function addApprenant($matricule, $nom, $prenom, $email, $telephone, $classe, $statut, $photo) {
    $db = connectToDatabase();
    try {
        $sql = "INSERT INTO apprenant (matricule, nom, prenom, email, telephone, classe, statut, photo) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $db->prepare($sql);
        return $stmt->execute([$matricule, $nom, $prenom, $email, $telephone, $classe, $statut, $photo]);
    } catch (PDOException $e) {
        return false;
    }
}

function updateApprenant($id, $matricule, $nom, $prenom, $email, $telephone, $classe, $statut, $photo = null) {
    $db = connectToDatabase();
    try {
        if ($photo) {
            $sql = "UPDATE apprenant SET matricule = ?, nom = ?, prenom = ?, email = ?, 
                    telephone = ?, classe = ?, statut = ?, photo = ? WHERE id = ?";
            $params = [$matricule, $nom, $prenom, $email, $telephone, $classe, $statut, $photo, $id];
        } else {
            $sql = "UPDATE apprenant SET matricule = ?, nom = ?, prenom = ?, email = ?, 
                    telephone = ?, classe = ?, statut = ? WHERE id = ?";
            $params = [$matricule, $nom, $prenom, $email, $telephone, $classe, $statut, $id];
        }
        $stmt = $db->prepare($sql);
        return $stmt->execute($params);
    } catch (PDOException $e) {
        return false;
    }
}

function updateApprenantStatut($id, $statut) {
    $db = connectToDatabase();
    try {
        $sql = "UPDATE apprenant SET statut = ? WHERE id = ?";
        $stmt = $db->prepare($sql);
        return $stmt->execute([$statut, $id]);
    } catch (PDOException $e) {
        return false;
    }
}

function deleteApprenant($id) {
    $db = connectToDatabase();
    try {
        $sql = "DELETE FROM apprenant WHERE id = ?";
        $stmt = $db->prepare($sql);
        return $stmt->execute([$id]);
    } catch (PDOException $e) {
        return false;
    }
}

function getClasses() {
    $db = connectToDatabase();
    $sql = "SELECT DISTINCT classe FROM apprenant ORDER BY classe";
    $stmt = $db->query($sql);
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

function getStatuts() {
    return ['Actif', 'Inactif', 'En pause'];
}