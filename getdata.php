<?php
    header('Content-Type: application/json');
    $pdo = new PDO('sqlite:C:\Users\Etudiant\Documents\MAGASIN.db');
    $sql = $pdo->prepare("SELECT * FROM ARTICLE");                            
    if(isset($_GET['categorie']) && !empty($_GET['categorie'])) {
        $categorie = $_GET['categorie'];
        $sql = $pdo->prepare("SELECT * FROM ARTICLE WHERE Categorie = :categorie");
        $sql->bindParam(':categorie', $categorie);
    }                        
    $sql->execute();
    $results = $sql->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($results);
?>
