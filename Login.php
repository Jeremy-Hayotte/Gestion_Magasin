<?php
session_start();

// Vérification de la soumission du formulaire
if (isset($_POST['submit'])) {
    // Récupération des données du formulaire
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Connexion à la base de données
    $pdo = new PDO('sqlite:C:\Users\Etudiant\Documents\MAGASIN.db');

    // Requête pour récupérer l'utilisateur correspondant au nom d'utilisateur
    $stmt = $pdo->prepare("SELECT * FROM user WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérification du mot de passe
    if ($user && password_verify($password, $user['password'])) {
        // Authentification réussie, stockage des informations de l'utilisateur en session
        $_SESSION['user'] = [
            'id' => $user['id'],
            'username' => $user['username'],
            'role' => $user['role']
        ];

        // Redirection vers la page appropriée en fonction du rôle de l'utilisateur
        if ($user['role'] == 'admin') {
            header('Location: liste_demande.php');
        } else {
            header('Location: demande_article.php');
        }
        exit();
    } else {
        // Authentification échouée, affichage d'un message d'erreur
        $error = "Nom d'utilisateur ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss/dist/tailwind.min.css">
    <style>
        html, body {
            height: 100%;
        }
    </style>
</head>
<body class="bg-blue-200">
    <div class="h-full flex items-center justify-center">
        <div class="w-1/2 bg-white p-8 rounded shadow-lg">
            <h1 class="text-2xl font-bold mb-4">Connexion</h1>

            <?php if (isset($error)) : ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif ?>

            <form action="login.php" method="post">
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2" for="username">Email:</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" name="username" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2" for="password">Mot de passe :</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="password" name="password" required>
                </div>
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit" name="submit">Se connecter</button>
            </form>
        </div>
    </div>
</body>
</html>



