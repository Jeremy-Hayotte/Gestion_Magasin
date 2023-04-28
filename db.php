<?php
    try {
        $pdo = new PDO('sqlite:MAGASIN.db');
    } catch (PDOExeption $e) {
        die("Il y a une couille avec la db");
    }


    $reqAddRes = $pdo->prepare("INSERT INTO RESSOURCE(nom, dateAchat, observation) VALUES(:name, :date, :observations)");
    $reqAddUser = $pdo->prepare("INSERT INTO EMPRUNTEUR(nom, prenom, observations) VALUES(:name, :surname, :observations)");
    $reqDelRes = $pdo->prepare("DELETE FROM RESSOURCE WHERE ressourceID = :id");
    $reqDelUser = $pdo->prepare("DELETE FROM emprunteur WHERE emprunteurID = :id");
    $reqaddEmprnt = $pdo->prepare("INSERT INTO EMPRUNT(dateHeureDebut, dateHeureFin, observations, ressourceID, emprunteurID) VALUES(:dateDebut, :dateFin, :observations, :ressourceID, :emprunteurID)");
    $reqBack = $pdo->prepare("UPDATE EMPRUNT SET dateHeureRetour = :date WHERE emprunt.empruntID = :id");
    $reqaddIncident = $pdo->prepare("INSERT INTO INCIDENT(commentaire,date,emprunteurID,ressourceID) VALUES(:com, :date, :emprunteurID, :ressourceID)");

    if ($_POST["form"] == "nvlressource") {
        $reqAddRes->bindValue(":name", $_POST["name"]);
        $reqAddRes->bindValue(":date", $_POST["dateAchat"]);
        $reqAddRes->bindValue(":observations", $_POST["observation"]);
        $reqAddRes->execute();
        header("Location: http://localhost/ressource.php");
    }

    if ($_POST["form"] == "deleteRes") {
        echo $_POST["id"];
        $reqDelRes->bindValue(":id", $_POST["id"]);
        $reqDelRes->execute();
        header("Location: http://localhost/ressource.php");
    }

    if ($_POST["form"] == "nvlUser") {
        $reqAddUser->bindValue(":name", $_POST["name"]);
        $reqAddUser->bindValue(":surname", $_POST["surname"]);
        $reqAddUser->bindValue(":observations", $_POST["observations"]);
        $reqAddUser->execute();
        header("Location: http://localhost/emprunteurs.php");
    }

    if ($_POST["form"] == "deleteUser") {
        echo $_POST["id"];
        $reqDelUser->bindValue(":id", $_POST["id"]);
        $reqDelUser->execute();
        echo "<meta http-equiv='refresh' content='0; http://localhost/emprunteurs.php'>";
        header("Location: http://localhost/emprunteurs.php");
    }

    if ($_POST["form"] == "addEmprunt") {
        echo $_POST["dateFin"]." ".$_POST["observation"]." ".$_POST["ressourceID"]." ".$_POST["emprunteurID"];
        $reqaddEmprnt->bindValue(":dateDebut", date("y-m-d"));
        $reqaddEmprnt->bindValue(":dateFin", $_POST["dateFin"]);
        $reqaddEmprnt->bindValue(":observations", $_POST["observation"]);
        $reqaddEmprnt->bindValue(":ressourceID", $_POST["ressourceID"]);
        $reqaddEmprnt->bindValue(":emprunteurID", $_POST["emprunteurID"]);
        $reqaddEmprnt->bindValue(":dateDebut", "2022-10-10");
        $reqaddEmprnt->execute();
        header("Location: http://localhost/emprunts.php");
    }

    if ($_POST["form"] == "back") {
        $reqBack->bindValue(":date", date("y-m-d"));
        $reqBack->bindValue(":id", $_POST["id"]);
        $reqBack->execute();
        header("Location: http://localhost/emprunts.php");
    }

    if ($_POST["form"] == "addIncident") {
        $reqaddIncident->bindValue(":com", $_POST["commentaire"]);
        $reqaddIncident->bindValue(":date", $_POST["date"]);
        $reqaddIncident->bindValue(":ressourceID", $_POST["ressourceID"]);
        $reqaddIncident->bindValue(":emprunteurID", $_POST["emprunteurID"]);
        $reqaddIncident->execute();
        header("Location: http://localhost/incident.php?ressource=".$_POST["ressourceID"]);
    }
?>