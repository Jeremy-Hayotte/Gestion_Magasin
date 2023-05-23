<?php

if (isset($_POST['form']) && $_POST['form'] === 'delete') {
    $demandeId = $_POST['demandeId'];
    try {
        $db = new PDO('sqlite:C:\Users\Etudiant\Documents\MAGASIN.db');
    } catch (PDOException $e) {
        die("Erreur de connexion : " . $e->getMessage());
    }
    $sql = $db->prepare("UPDATE Demande SET Etat = 1 WHERE id = :demandeId");
    $sql->bindParam(':demandeId', $demandeId);
    $sql->execute();
    header('Location: Liste_Demande.php');
    exit();
}

function generateSelectFilter() {
    try {
        $db = new PDO('sqlite:C:\Users\Etudiant\Documents\MAGASIN.db');
    } catch (PDOException $e) {
        die("Erreur de connexion : " . $e->getMessage());
    }
    $sql = $db->prepare("SELECT DISTINCT Categorie FROM ARTICLE");
    $sql->execute();
    $results = $sql->fetchAll(PDO::FETCH_ASSOC);
    if(!empty($results)) {
        echo '<label for="categorie" class="mr-2 font-bold">Filtrer par catégorie :</label>';
        echo '<div class="relative">';
        echo '<select name="Categorie" id="Categorie" class="px-4 py-2 rounded-md bg-gray-100 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent">';
        foreach($results as $row) {
            echo '<option value="'.$row["Categorie"].'">'.$row["Categorie"].'</option>';
        }
        echo '</select>';
        echo '</div>';
        echo '</div>';
    }

    if(isset($_POST['selectedItems']) && !empty($_POST['selectedItems'])){
        $Items = ($_POST['selectedItems']);
        echo "<input type='hidden' name='selectedItems' value=".$Items.">";
    }else{
        echo "<input type='hidden' name='selectedItems' value=''>";
    }
}



?>