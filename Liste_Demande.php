<?php
session_start();

// Vérifiez si l'utilisateur est connecté
if (isset($_SESSION['user'])) {
    $username = $_SESSION['user']['username'];

} else {
    header('Location: Login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Lien vers Tailwind CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.1.4/tailwind.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-200">
    <nav class="bg-blue-500 py-4">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <div class="flex items-center">
                <button class="px-4 py-2 rounded-md bg-gray-700 text-white mr-2 hover:bg-gray-600" onclick="location.href='http://localhost/DEMANDE_ARTICLE.php'">Demande</button>
                <button class="px-4 py-2 rounded-md bg-gray-700 text-white hover:bg-gray-600" onclick="location.href='http://localhost/Liste_Demande.php'">Liste</button>
            </div>
            <div class="flex items-center">
                <h1 class="text-white font-bold mr-4"><?php echo $_SESSION['user']['username']; ?></h1>
                <button class="p-1 text-gray-400 hover:text-gray-200" onclick="location.href='http://localhost/deconnexion.php'">
                    <svg class="h-8 w-8 text-red-500" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z"/>
                        <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" />
                        <path d="M7 12h14l-3 -3m0 6l3 -3" />
                    </svg>
                </button>
            </div>
        </div>
    </nav>
   <div class="container mx-auto p-10">
   <h1 class="text-4xl font-bold text-center mb-8 text-gray-800">LISTE DEMANDES</h1>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-center text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">Code</th>
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">Description</th>
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">Catégorie</th>
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">Emplacement</th>
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">Quantité</th>
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">Unité</th>
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">Date demande</th>
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">Date besoin</th>
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">Section</th>
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">Supprimer</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $pdo = new PDO('sqlite:C:\Users\Etudiant\Documents\MAGASIN.db');
                $sql = $pdo->prepare("SELECT * FROM Demande INNER JOIN Article ON Demande.CODESAP = Article.CODESAP WHERE etat == 0" );
                $sql->execute();
                $results = $sql->fetchAll(PDO::FETCH_ASSOC);
                $count = 0;
                foreach ($results as $row) {
                    $count++;
                    echo "<tr class='" . ($count%2==0 ? "bg-gray-100" : "") . "'>" .
                        "<td class='border px-4 py-2'>".$row["CODESAP"]."</td>".
                        "<td class='border px-4 py-2'>".$row["Description"]."</td>".
                        "<td class='border px-4 py-2'>".$row["Categorie"]."</td>".
                        "<td class='border px-4 py-2'>".$row["Emplacementmagasin"]."</td>".
                        "<td class='border px-4 py-2'>".$row["quantité"]."</td>".
                        "<td class='border px-4 py-2'>".$row["unitédecommande"]."</td>".
                        "<td class='border px-4 py-2'>".$row["Date_Demande"]."</td>".
                        "<td class='border px-4 py-2'>".$row["Date_Besoin"]."</td>".
                        "<td class='border px-4 py-2'>".$row["Section"]."</td>".
                        "<td class='border px-4 py-2'>
                        <form action='functions.php' method='post'>
                            <input type='hidden' name='form' value='delete'>
                            <input type='hidden' name='demandeId' value='".$row["id"]."'>
                            <button type='submit'><i class='far fa-trash-alt'></i></button>
                        </form>
                        </td>".
                        "</tr>";
                }
            ?> 
            </tbody>
        </table>
        </div>
            <div class="flex justify-center space-x-4 mt-8">
                <button onclick="window.print()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Imprimer</button>
            </div>
    </div>
</body>
</html>
