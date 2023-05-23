<?php require './functions.php';?>
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
   <div class="container mx-auto p-10">
   <h1 class="text-4xl font-bold text-center mb-8 text-gray-800">DEMANDE D'ARTICLES</h1>
        <div class="flex justify-center">
            <div class="flex items-center mr-4">
                <?php generateSelectFilter();// Génére la liste des catégories dans le select pour le filtre?>
                <button id="button-filtre" name="filtrer" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Filtrer</button>
            </div>
        </div>
        <form method="post" action="Confirmation_Demande.php" id="form-confirmation">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class= "text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">CODE SAP</th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">CODE POLE</th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">Description</th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">Unitédemesure</th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">Categorie</th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">Sélectionner</th>
                    </tr>
                </thead>
                <tbody id="table-body">
                    <!-- Table qui se génère en JS into mama.js-->
                </tbody>
            </table>
            </div>
            <input type="hidden" name="articles" value="">
            <div class="flex justify-center mt-8">
                <button type="submit" name="valider" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Valider</button>
            </div>
        </form>
    </div>
    <script src="mama.js"></script>
</body>
</html>