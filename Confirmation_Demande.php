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
            <div class="flex items-center ml-auto">
                <div class="text-white font-bold mr-4">Hayottej</div>
                <button class="p-1 text-gray-400 hover:text-gray-200" onclick="location.href='http://localhost/deconnexion.php'">
                    <svg class="h-8 w-8 text-red-500"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z"/>
                        <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" />
                        <path d="M7 12h14l-3 -3m0 6l3 -3" />
                    </svg>
                </button>
            </div>
        </div>
    </nav>
    <div class="container  mx-auto p-10">
        <h1 class="text-4xl font-bold text-center mb-8 text-gray-800">Confirmation Demande</h1>
        <form method="post" action="enregistrer_demande.php" class="flex flex-col">
            <table class="w-full text-sm text-center text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">CODESAP</th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">DESCRIPTION</th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">Quantité</th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">Unitédemesure</th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">Date du besoin</th>
                    </tr>
                </thead>
                    <tbody>
                    <?php
                    try {
                        $db = new PDO('sqlite:C:\Users\Etudiant\Documents\MAGASIN.db');
                    } catch (PDOException $e) {
                        die("Erreur de connexion : " . $e->getMessage());
                    }

                    $articles = $_POST['articles'];
                    $sql = $db->prepare("SELECT DISTINCT * FROM ARTICLE WHERE CODESAP IN (".implode(',', array_fill(0, count(explode(",",$articles)), '?')).")");

                    $sql->execute(explode(",",$articles));
                    $results = $sql->fetchAll(PDO::FETCH_ASSOC);

                    if(!empty($results)) {
                        $cpt = 0;
                        foreach($results as $row) {
                            echo '<tr>'.
                            "<td class='border px-4 py-2'><input type='text' name='date'".$cpt."'>".$row["CODESAP"]."</td>".
                            "<td class='border px-4 py-2'>".$row["Description"]."</td>".
                            '<td class="border px-4 py-2"><input type="number" min="0" name="quantite'.$cpt.'"></td>'.
                            "<td class='border px-4 py-2'>".$row["Unitédemesure"]."</td>".
                            '<td class="border px-4 py-2"><input type="date" name="date'.$cpt.'"></td>'.
                            '</tr>';
                            $cpt++;
                        }
                    } else {
                        echo "<tr><td colspan='7' class='border px-4 py-2'>Aucun article sélectionné.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
            <input type="hidden" name="compteur" value="<?php echo $cpt;?>">
            <input type="submit" value="Envoyer la demande" class="block mx-auto bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-4 ">
        </form>
    </div>
</body>
</html>

