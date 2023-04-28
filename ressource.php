
<html>
    <head>
        <link rel="stylesheet" href="ressource.css">
    </head>
    <body>
        <center>
            <h1>Gestion des Ressources</h1>
            <div>
                <button type="button" onclick="location.href='http://localhost/emprunteurs.php'">Emprunteurs</button>
                <button type="button" onclick="location.href='http://localhost/emprunts.php'">Emprunts</button>
            </div>
        </center>
        <br>
        <br>
        <br>
        <br>
        <br>
        Ajouter une ressources:
        <br>
        <br>
        <form action="db.php" method="post">
            <div>
                Désignation: <input type="text" name="name">
                Date d'achat: <input type="text" name="dateAchat">
                Observation: <input type="text" name="observation">
                <input type="hidden" name="form" value="nvlressource">
                <input type="submit">
            </div>
        </form>
        <center>
            <table border="3">
                <tr>
                    <td>id</td>
                    <td>name</td>
                    <td>date</td>
                    <td>observation</td>
                    <td>Delete</td>
                    <td>Incident</td>
                </tr>
               <?php
                    $pdo = new PDO('sqlite:database.sqlite');
                    $sql = $pdo->prepare("SELECT * FROM ressource");
                    $sql->setFetchMode(PDO::FETCH_ASSOC);
                    $sql->execute();
                    while($row=$sql->fetch()) {
                        echo "<tr>".
                            "<td>".$row["ressourceID"]."</td>".
                            "<td>".$row["nom"]."</td>".
                            "<td>".$row["dateAchat"]."</td>".
                            "<td>".$row["observation"]."</td>".
                            "<td><form action='db.php' method='post'><input type='hidden' name='form' value='deleteRes'><input type='hidden' name='id' value=".$row["ressourceID"]."><input type='submit' value='Del'></form>". 
                            "<td><button type='button' onclick=\"location.href='http://localhost/incident.php?ressource=".$row['ressourceID']."'\">Incident</button></td>".
                            "</tr>";
                    }
                ?> 
            </table>
        </center>
    </body>
</html>