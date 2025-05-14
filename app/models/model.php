<?php
function connectToDatabase(){
    $servername = "localhost";
    $username = "postgres";
    $password = "passer0412";
    $port = 5432;
    $dbname = "ges_apprenant";

    try {
        $conn = new PDO("pgsql:host=$servername;port=$port;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch(PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
}




function isEmpty($name,&$errors){
    if (empty($_POST[$name])) {
       $errors[$name] =ucfirst($name). " est obligatoire.";
   }
}
 
function dd(){
    echo "<pre>";
    print_r(func_get_args());
    echo "</pre>";
    exit;
}

function executeselect($sql, $isALL = false, $params = []) {
    $pdo = connectToDatabase();
    $stmt = $pdo->prepare($sql);
    
    if (!empty($params)) {
        foreach ($params as $key => $value) {
            $stmt->bindValue(is_int($key) ? $key + 1 : $key, $value);
        }
    }
    
    $stmt->execute();
    return $isALL ? $stmt->fetchAll() : $stmt->fetch();
}

function getDashboardStat() {
    $db = connectToDatabase();

    $stats = [];

    $query = $db->query("SELECT COUNT(*) as total FROM apprenant");
    $stats["total_apprenant"] = $query->fetch()["total"];

    $query = $db->query("SELECT COUNT(*) as total FROM referentiel");
    $stats["total_referentiel"] = $query->fetch()["total"];

    $query = $db->query("SELECT COUNT(*) as total FROM promotion WHERE statut='Actif'");
    $stats["total_promotionActive"] = $query->fetch()["total"];

    $query = $db->query("SELECT COUNT(*) as total FROM promotion ");
    $stats["total_promotion"] = $query->fetch()["total"];

    return $stats;
}


    