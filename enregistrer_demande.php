<?php

if (!isset($_POST['compteur']) || empty($_POST['compteur'])) {
    header('location: ../confirmation_demande.php');
    exit();
}

$cpt = $_POST['compteur'];


for ($i=0; $i < $cpt; $i++) { 
    if (!isset($_POST['codeSAP' + $i]) || empty($_POST['codeSAP' + $i])) {
        header('location: ../confirmation_demande.php');
        exit();
    }

    if (!isset($_POST['date' + $i]) || empty($_POST['date' + $i])) {
        header('location: ../confirmation_demande.php');
        exit();
    }

    if (!isset($_POST['quantite' + $i]) || empty($_POST['quantite' + $i])) {
        header('location: ../confirmation_demande.php');
        exit();
    }

    $code = $_POST['codeSAP' + $i];
    $date = $_POST['date' + $i];
    $quantite = $_POST['quantite' + $i];

    try {
        $pdo = new PDO($connect);
        $req = $pdo->prepare("INSERT INTO Demande (codeSAP, login, password, observation, type) VALUES (?, ?, ?, ?, ?);");
        $req->execute([$name, $login, $password, $observation, $type]);
        $req->closeCursor();
        $pdo = null;
    } catch (PDOException $e) {
        die("Error : " . $e);
    }
}

header('location: ../dashboard.php');
exit();
?>