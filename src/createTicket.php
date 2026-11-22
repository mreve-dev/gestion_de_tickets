<?php
session_start();
require_once('../bdd/bdd.php');
require_once __DIR__ . '/statut.php';

// Protection du dashboard :
// S'il n'y a pas de rôle en session ou si le rôle n'est pas usager, on renvoie vers la page de connexion et on arrête tout

if (empty($_SESSION['role']) || $_SESSION['role'] !== "usager") {
    header("Location: ../index.php");
    exit;
}

$erreurs = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $titre = filter_input(INPUT_POST, 'titre');
    $description = filter_input(INPUT_POST, 'description');

    // Si y'a pas de titre ou de description (titre="" ou titre=NULL)
    if (!$titre) {
        $erreurs[] = "Le titre est manquant";
    }
    if (!$description) {
        $erreurs[] = "La description est manquante";
    }

    // Si pas d"erreurs, création du ticket
    if (empty($erreurs)) {
        executerRequete('creer-ticket', [
            'compte' => $_SESSION['id'],
            'titre' => $titre,
            'description' => $description,
            'statut' => "NOUVEAU",
            'date_creation' => date('Y-m-d H:i:s'),
        ]);

        header("Location: ./dashboard_usager.php");
        exit;
    }
}



?>

<!-- Gérer la gestion du chargement -->
<script>
  const form = document.querySelector("#create-form");
  const btn = document.querySelector("#create-btn");

  form.addEventListener("submit", () => {
    btn.disabled = true;
    btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Création…';
  });
</script>




<!doctype html>
<html lang="fr">

<?php require './head.php' ?>

<body class="min-h-screen p-4 md:p-6 bg-cream text-ink flex flex-col items-center gap-3">

    <?php $page = 'create'; ?>
    <?php require './header.php' ?>

    <main class="w-full max-w-200 rounded-2xl grid grid-cols-1 gap-3">

        <a
            href="./dashboard_usager.php"
            class="bg-transparent flex items-center gap-3">
            <i class="fa-solid fa-angle-left"></i> Retour
        </a>

        <form 
        method="POST" 
        class="flex flex-col gap-6 p-7 bg-surface rounded-2xl text-ink shadow-lg shadow-muted border border-line"
        id="create-form">


            <!-- On affiche les erreurs présentes dans le tableaue erreur s'il y en a -->

            <?php if (!empty($erreurs)): ?>
                <output class="bg-danger-soft text-danger rounded-lg px-4 py-2">
                    <ul>
                        <?php foreach ($erreurs as $erreur): ?>
                            <li><?= $erreur ?></li>
                        <?php endforeach; ?>
                    </ul>
                </output>
            <?php endif; ?>

            <div class="flex flex-col gap-2">
                <label for="title" class="font-semibold">Titre</label>
                <input type="text" id="title" name="titre" class="rounded-lg bg-cream border-2 border-muted/30 py-1 px-2 focus:border-primary focus:outline-none" required>
            </div>

            <div class="flex flex-col gap-2">
                <label for="description" class="font-semibold">Description</label>
                <textarea
                    id="description"
                    name="description"
                    placeholder="Décris ce que tu faisais, ce qui s'est passé, et ce que tu attendais."
                    class="rounded-lg bg-cream py-1 px-2 border-2 h-40 border-muted/30 focus:border-primary focus:outline-none" required></textarea>
            </div>


            <p class="bg-new/20 rounded-2xl px-4 py-2 text-new">
                <i class="fa-solid fa-circle-info"></i>
                <span class="md:hidden">Statut : « Nouveau »</span>
                <span class="hidden md:inline">Ton ticket sera créé avec le statut « Nouveau ».</span>
            </p>

            <section class="flex items-center gap-3 self-end">
                <a href="./dashboard_usager.php" class="bg-line hover:bg-neutral-btn-hover text-ink px-4 py-2 rounded-lg font-semibold shadow-md shadow-primary/25 hover:shadow-lg hover:-translate-y-0.5 transition-all cursor-pointer self-center w-fit">
                    Annuler
                </a>



                <button 
                type="submit" 
                value="Envoyer" 
                class="bg-primary hover:bg-primary-hover text-white px-4 py-2 rounded-lg font-semibold shadow-md shadow-primary/25 hover:shadow-lg hover:-translate-y-0.5 transition-all cursor-pointer self-center w-fit disabled:opacity-60 disabled:cursor-wait"
                id="create-btn">
                    Créer le ticket
                </button>

            </section>


        </form>




    </main>


    <script type="module" src="../js/main.js"></script>
</body>

</html>