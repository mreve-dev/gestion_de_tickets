<?php
session_start();
require_once('../bdd/bdd.php');
require_once __DIR__ . '/statut.php';

// Protection du dashboard :

if (empty($_SESSION['role']) || $_SESSION['role'] !== "dev") {
    header("Location: ../index.php");
    exit;
}

// récuperer les tickets dans la bdd
$tickets = executerRequete('voir-tickets-en-cours');

?>


<!doctype html>
<html lang="fr">

<?php require './head.php' ?>

<body class="h-screen p-6 bg-cream text-ink flex flex-col items-center gap-5">

    <?php $page = 'ticket'; ?>
    <?php require './header.php' ?>



    <main class="bg-surface w-full max-w-200 rounded-2xl border-2 border-muted/30 grid grid-cols-1 overflow-y-auto flex-1 min-h-0 [scrollbar-width:none] [&::-webkit-scrollbar]:hidden md:[scrollbar-width:thin] md:[scrollbar-color:var(--color-line)_transparent]">

       

        
    </main>

    <script type="module" src="../js/main.js"></script>
</body>

</html>