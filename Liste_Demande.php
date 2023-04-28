<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Lien vers Tailwind CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.1.4/tailwind.min.css">
</head>
<body class="bg-gray-200">
    <nav class="bg-blue-500 py-4">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <div>
                <button class="px-4 py-2 rounded-md bg-gray-700 text-white mr-2 hover:bg-gray-600" onclick="location.href='http://localhost/DEMANDE_ARTICLE.php'">Demande</button>
                <button class="px-4 py-2 rounded-md bg-gray-700 text-white hover:bg-gray-600" onclick="location.href='http://localhost/Liste_Demande.php'">Liste</button>
            </div>
        </div>
    </nav>
  <div class="container mx-auto p-10">
  <h1 class="text-4xl font-bold text-center mb-8 text-gray-800">LISTE DEMANDES</h1>
        <form method="post" action="confirmation_demande.php" id="form-confirmation">
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">Code</th>
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">Description</th>
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">Catégorie</th>
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">Magasin</th>
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">Emplacement</th>
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">Unité</th>
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">Quantité/u</th>
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">Sélectionner</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $pdo = new PDO('sqlite:C:\Users\Etudiant\Documents\MAGASIN.db');
                $sql = $pdo->prepare("SELECT * FROM Demande");
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $sql->execute();
                $count = 0;
                while($row=$sql->fetch()) {
                    $count++;
                    echo "<tr class='" . ($count%2==0 ? "bg-gray-100" : "") . "'>" .
                        "<td class='border px-4 py-2'>".$row["CODESAP"]."</td>".
                        "<td class='border px-4 py-2'>".$row["Description"]."</td>".
                        "<td class='border px-4 py-2'>".$row["Categorie"]."</td>".
                        "<td class='border px-4 py-2'>".$row["Magasin"]."</td>".
                        "<td class='border px-4 py-2'>".$row["Emplacementmagasin"]."</td>".
                        "<td class='border px-4 py-2'>".$row["unitédecommande"]."</td>".
                        "<td class='border px-4 py-2'>".$row["qtt/sortie"]."</td>".
                        "<td class='border px-4 py-2'><form action='db.php' method='post'><input type='hidden' name='form' value='deleteRes'><input type='hidden' name='id' value=".$row["CODESAP"]."><input type='submit' value='Del'></form>". 
                        "</tr>";
                }
            ?> 
            </tbody>
        </table>
        </div>
            <input type="hidden" name="articles" value="">
            <div class="flex justify-center space-x-4 mt-8">
                <button onclick="window.print()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Imprimer</button>
            </div>
        </form>
    </div>
</body>
</html>
