<?php
session_start();

// Vérifiez si l'utilisateur est connecté
if (isset($_SESSION['user'])) {
    $username = $_SESSION['user']['username'];

} else {
    header('Location: login.php');
    exit();
}
if (!isset($_POST['articles']) || empty($_POST['articles'])) {
    header('location: ../demande_article.php');
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
</head>
<body class="bg-gray-200">
    <nav class="bg-blue-500 py-4">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <div class="flex items-center ml-auto">
                <div class="text-white font-bold mr-4"><?php echo $_SESSION['user']['username']; ?></div>
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
        <h1 class="text-4xl font-bold text-center mb-8 text-gray-800">Confirmation Demande</h1>
        <form method="post" action="enregistrer_demande.php" onsubmit="return validateForm()">
            <?php
                try {
                    $db = new PDO('sqlite:C:\Users\Etudiant\Documents\MAGASIN.db');
                } catch (PDOException $e) {
                    die("Erreur de connexion : " . $e->getMessage());
                }
                $sql = $db->prepare("SELECT DISTINCT Section FROM `Centre_De_Cout`");
                $sql->execute();
                $results = $sql->fetchAll(PDO::FETCH_ASSOC);
                if(!empty($results)) {
                    echo '<div class="flex flex-row-reverse items-center p-10">';
                    echo '<div class="relative">';
                    echo '<div class="inline-flex">';
                    echo '<select name="section" id="section" class="block appearance-none w-full bg-yellow-200 text-center border-gray-300 hover:border-gray-400 px-4 py-2 pr-8 rounded-md shadow leading-tight focus:outline-none focus:shadow-outline-blue focus:border-blue-300 ml-2">';
                    echo '<option value="" selected disabled>Choisir votre Section</option>';
                    // Add options dynamically using PHP code
                    foreach ($results as $row) {
                        echo '<option value="' . $row["Section"] . '">' . $row["Section"] . '</option>';
                    }
                    echo '</select>';
                    echo '<input type="hidden" name="selectedSection" value="'.$row["Section"].'">';
                    echo '<div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">';
                    // Add icon from Font Awesome
                    echo '<svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M7 10l5 5 5-5z" /></svg>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            ?>
            <div class="relative flex content-center">
                <table class="mx-auto w-4/5 relative overflow-x-auto shadow-md sm:rounded-lg text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr class="bg-blue-500 border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="text-center px-6 py-4 font-medium text-white whitespace-nowrap dark:text-white font-bold">CODESAP</th>
                        <th scope="row" class="text-center px-6 py-4 font-medium text-white whitespace-nowrap dark:text-white font-bold">DESCRIPTION</th>
                        <th scope="row" class="text-center px-6 py-4 font-medium text-white whitespace-nowrap dark:text-white font-bold">Quantité</th>
                        <th scope="row" class="text-center px-6 py-4 font-medium text-white whitespace-nowrap dark:text-white font-bold">Unité</th>
                        <th scope="row" class="text-center px-6 py-4 font-medium text-white whitespace-nowrap dark:text-white font-bold">Date du besoin</th>
                    </tr>
                </thead>
                    <tbody class="bg-white">
                    <?php
                    try {
                        $db = new PDO('sqlite:C:\Users\Etudiant\Documents\MAGASIN.db');
                    } catch (PDOException $e) {
                        die("Erreur de connexion : " . $e->getMessage());
                    }

                    $articles = $_POST['articles'];
                    $sql = $db->prepare("SELECT DISTINCT CODESAP, Description, Unitédemesure  FROM ARTICLE WHERE CODESAP IN (".implode(',', array_fill(0, count(explode(",",$articles)), '?')).")");
                    $sql->execute(explode("," , $articles));
                    $results = $sql->fetchAll(PDO::FETCH_ASSOC);
                    if(!empty($results)) {
                        $cpt = 0;
                        foreach($results as $row) {

                            echo '<tr>'.
                            "<td class='text-center px-4 py-2 '>".$row["CODESAP"]."</td>".
                            "<td class='text-center px-4 py-2'>".$row["Description"]."</td>".
                            '<td class="text-center px-4 py-2"><input class="text-center rounded bg-yellow-200" value="0" type="number" name="quantité'.$cpt.'"></td>'.
                            "<td class='text-center px-4 py-2'>".$row["Unitédemesure"]."</td>".
                            '<td class="text-center px-4 py-2"><input class="text-center p-2 rounded bg-yellow-200" type="date" name="date'.$cpt.'"></td>'.
                            '</tr>';
                            $cpt++;
                        }
                    } else {
                        echo '<tr>';
                        echo '<td class="text-center px-4 py-2">1205869X</td>';
                        echo '<td class="text-center px-4 py-2">Rouleau</td>';
                        echo '<td class="text-center px-4 py-2">Divers</td>';
                        echo '<td class="text-center px-4 py-2"><input type="text" class="text-center text-center-gray-300 rounded-md p-2"></td>';
                        echo '<td class="text-center px-4 py-2">PAK</td>';
                        echo '<td class="text-center px-4 py-2"><input type="date"  class="text-center text-center-gray-300 rounded-md p-2"></td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
            </div>
            <input type="hidden" value="<?php echo $cpt?> " name="compteur">
            <input type="hidden" value="<?php echo $articles?> " name="articles">
            <div class="flex justify-center mt-8">
                <button type="submit" name="valider" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" onclick="return validateForm()">Envoyer la demande</button>
            </div>
        </form>
<script>
function validateForm() {
  var section = document.forms[0].section.value;         
  var inputs = document.getElementsByTagName("input");
  
  if (section === "") {
    showAlert("Veuillez choisir une section");
    return false;
  }

  for (var i = 0; i < inputs.length; i++) {
    var input = inputs[i];
    if (input.type === "number" && (input.value === "" || input.value === "0")) {
      showAlert("Veuillez remplir tous les champs de quantité.", "bg-red-500");
      return false;
    }
    if (input.type === "date" && input.value === "") {
      showAlert("Veuillez remplir tous les champs de date.", "bg-red-500");
      return false;
    }
  }

  return true;
}


function showAlert(message, colorClass) {
  var alertContainer = document.createElement("div");
  alertContainer.classList.add("fixed", "top-0", "left-0", "right-0", "bottom-0", "flex", "justify-center", "items-center", "bg-opacity-50");
  
  var alertBox = document.createElement("div");
  alertBox.classList.add("bg-white", "shadow-lg", "rounded", "p-4", "mx-auto");
  
  var alertText = document.createElement("p");
  alertText.textContent = message;
  
  var alertButton = document.createElement("button");
  alertButton.textContent = "OK";
  alertButton.classList.add("bg-blue-500", "hover:bg-blue-700", "text-white", "font-bold", "py-2", "px-4", "rounded", "mt-4");
  
  alertButton.addEventListener("click", function() {
    alertContainer.remove();
  });
  
  alertBox.appendChild(alertText);
  alertBox.appendChild(alertButton);
  alertContainer.appendChild(alertBox);
  document.body.appendChild(alertContainer);
}
</script>   
</body>
</html>
