<?php
if (!isset($_POST['articles']) || empty($_POST['articles'])) {
    header('location: ../demande_article.php');
    exit();
}

$section = $_POST['selectedSection'];
$articles = explode(",", $_POST['articles']);
$cpt = $_POST['compteur'];
$quantité = [];
$dates = [];
$etat = 0;

for ($i = 0; $i <= $cpt; $i++) {
    if (isset($_POST['quantité'.$i]) && !empty($_POST['quantité'.$i])) {
        $quantité[$i] = $_POST['quantité'.$i];
    }
    if (isset($_POST['date'.$i]) && !empty($_POST['date'.$i])) {
        $dates[$i] = $_POST['date'.$i];
    }
}

try {
    $db = new PDO('sqlite:C:\Users\Etudiant\Documents\MAGASIN.db');
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

for ($i = 0; $i <= $cpt; $i++) {
    if (isset($articles[$i], $dates[$i], $quantité[$i], $section)) {
        $req = $db->prepare("INSERT INTO Demande (CODESAP, Date_Demande, Date_Besoin, Etat, quantité, section) VALUES (?, ?, ?, ?, ?, ?);");
        $req->execute([str_replace(' ', '', $articles[$i]), date('Y-m-d'), $dates[$i], $etat, $quantité[$i], $section]);
        $req->closeCursor();
        header('location: ../demande_article.php?success=true');
        exit();
    }
}

?>

