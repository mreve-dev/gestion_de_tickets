<?php

session_start();

// Redirige vers le dashboard adapté au bon rôle si la personne s'est déjà connecté et que son rôle est gardé en SESSION

if (!empty($_SESSION['role'])) {
    if ($_SESSION['role'] === "dev") {
        header("Location: ./src/dashboard_dev.php");
    } else {
        header("Location: ./src/dashboard_usager.php");
    }

    exit;
}

require_once('./bdd/bdd.php');


// Un tableau d'erreurs pour afficher les erreurs
$erreurs = [];

// On vérifie si c'est du GET ou si c'est du POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Ce que veut dire ce code, c'est :
    // - Je crée une variable $identifier (c'est plus pratique à s'en rappeler)
    // - Je vais chercher (filter_input) dans les données POST (INPUT_POST),
    //   la clé "identifier" envoyée par la requête
    $identifier = filter_input(INPUT_POST, 'identifier');
    $password = filter_input(INPUT_POST, 'password');

    // Si y'a pas d'identifiant (id="" ou identifier=NULL)
    if (!$identifier) {
        // Pour ajouter une nouvelle case dans le tableau erreurs,
        // on fait comme ça : 
        $erreurs[] = "L'identifiant est manquant";
    }
    // Pareil pour le mot de passe
    if (!$password) {
        $erreurs[] = 'Le mot de passe est manquant';
    }

    // On considère à partir d'ici que les tests sont terminés, et donc
    // on va pouvoir faire le test le plus important pour le processus :
    // est-ce que c'est bon ou pas ?
    // Est-ce qu'il y a eu des erreurs ?
    if (empty($erreurs)) {
        // Il n'y a pas d'erreurs (la fonction s'appelle "empty", donc
        // si c'est vrai, c'est que le tableau d'erreurs est vide)

        // Dans un processus classique, vu que le principe ici est de
        // laisser un message, on devrait stocker ça quelque part.
        // Par exemple dans une base de données.

        // A la place, une fonction pour afficher le contenu de la variable

        // $_SESSION s’utilise comme un tableau associatif, avec une clé entre crochets. On peux appeler la clé "message".

        // header(...) → dit au navigateur : « recharge la page, mais en GET »
        // exit; → arrête le PHP ici (inutile d’aller plus loin, on change de page)

        $account = executerRequete('recuperer-compte-par-identifiant', ['identifiant' => $identifier]);
        if (empty($account) || !password_verify($password, $account['mot_de_passe'])) {
            $erreurs[] = 'Identifiant ou mot de passe incorrect';
        } else {

            // stocker les informations de l'utilisateur pour la session
            $_SESSION['id'] = $account['id'];
            $_SESSION['role'] = $account['role'];
            $_SESSION['identifiant'] = $account['identifiant'];

            if ($_SESSION['role'] === "dev") {
                header("Location: ./src/dashboard_dev.php");
            } else {
                header("Location: ./src/dashboard_usager.php");
            }

            exit();
        }
    } else {
        // Là y'a eu des erreurs. Mais ce qu'on veut c'est les afficher.
        // Et si on les affiche ici maintenant, on est au dessus du
        // doctype. Donc en termes de sémantique HTML c'est pas terrible.


    }
} else {
    // echo "On est en GET";
}
?>






<!DOCTYPE html>
<html lang="fr">

<?php require './src/head.php' ?>


<body class="h-screen flex justify-center items-center flex-col bg-cream gap-6">

    <h2 class="text-5xl text-ink">
        Se connecter
    </h2>


    <!-- On affiche les erreurs présentes dans le tableaue erreur s'il y en a -->

    <?php if (!empty($erreurs)): ?>
        <output class="erreurs">
            <ul>
                <?php foreach ($erreurs as $erreur): ?>
                    <li><?= $erreur ?></li>
                <?php endforeach; ?>
            </ul>
        </output>
    <?php endif; ?>


    <form method="POST" class="flex flex-col gap-5 min-w-80 p-4 bg-surface rounded-2xl text-ink shadow-lg shadow-muted border border-line">
        <div class="flex flex-col gap-2">
            <label for="identifier" class="font-semibold">Identifiant</label>
            <input type="text" id="identifier" name="identifier" class="rounded-lg bg-cream border-2 py-1 px-2 border-muted focus:border-primary focus:outline-none" required>
        </div>

        <div class="flex flex-col gap-2">
            <label for="password" class="font-semibold">Mot de passe</label>
            <input type="password" id="password" name="password" class="rounded-lg bg-cream py-1 px-2 border-2 border-muted focus:border-primary focus:outline-none" required>
        </div>

        <input type="submit" value="Envoyer" class="bg-primary hover:bg-primary-hover text-white px-4 py-2 rounded-lg font-semibold shadow-md shadow-primary/25 hover:shadow-lg hover:-translate-y-0.5 transition-all cursor-pointer self-center w-fit">
    </form>

</body>

</html>