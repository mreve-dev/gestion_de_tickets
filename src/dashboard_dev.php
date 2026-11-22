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

    <?php $page = 'dashboard'; ?>
    <?php require './header.php' ?>



    <main class="bg-surface w-full max-w-200 rounded-2xl border-2 border-muted/30 grid grid-cols-1 overflow-y-auto flex-1 min-h-0 [scrollbar-width:none] [&::-webkit-scrollbar]:hidden md:[scrollbar-width:thin] md:[scrollbar-color:var(--color-line)_transparent]">

        <article
            class="column column--all is-active hidden [&.is-active]:block"
            data-status="all">


            <!-- En-tête : caché sur mobile -->
            <div class="hidden md:grid grid-cols-[1fr_130px_130px_70px]  px-5 py-3 text-sm text-muted border-b-2 border-line sticky top-0 z-10">
                <span>Titre</span>
                <span>Créé le</span>
                <span>Statut</span>
                <span></span>
            </div>

            <!-- Affichage des tickets présents dans la base de donnée (titre, date de création et statut) -->


            <?php foreach ($tickets as $ticket): ?>
                <div class="flex flex-col md:grid md:grid-cols-[1fr_130px_130px_70px] md:items-center p-5 border-t border-line">
                    <p class="font-semibold"><?= htmlspecialchars($ticket['titre']) ?></p>
                    <!-- date au format français -->
                    <p class="text-sm text-muted"><?= date('d/m/y', strtotime($ticket['date_creation'])) ?></p>
                    <p><span class="<?= $couleurs[$ticket['statut']] ?> text-xs font-bold px-3 py-1 rounded-full"><?= $libelles[$ticket['statut']] ?></span></p>
                    <a 
                    href="voir_ticket_dev.php?id=<?= $ticket['id'] ?>" class="text-primary font-semibold cursor-pointer">Voir →</a>
                </div>
            <?php endforeach; ?>



        </article>


        <article
            class="column column--new hidden [&.is-active]:block"
            data-status="new">

            <!-- En-tête : caché sur mobile -->
            <div class="hidden md:grid grid-cols-[1fr_130px_130px_70px]  px-5 py-3 text-sm text-muted border-b-2 border-line sticky top-0 z-10">
                <span>Titre</span>
                <span>Créé le</span>
                <span>Statut</span>
                <span></span>
            </div>

            <!-- Affichage des nouveaux tickets présents dans la base de donnée (titre, date de création et statut) -->


            <?php foreach ($tickets as $ticket): ?>

                <?php if ($ticket['statut'] === "NOUVEAU"): ?>

                    <div class="flex flex-col md:grid md:grid-cols-[1fr_130px_130px_70px] md:items-center p-5 border-t border-line">
                        <p class="font-semibold"><?= htmlspecialchars($ticket['titre']) ?></p>
                        <!-- date au format français -->
                        <p class="text-sm text-muted"><?= date('d/m/y', strtotime($ticket['date_creation'])) ?></p>
                        <p><span class="<?= $couleurs[$ticket['statut']] ?> text-xs font-bold px-3 py-1 rounded-full"><?= $libelles[$ticket['statut']] ?></span></p>
                        <a href="voir_ticket_dev.php?id=<?= $ticket['id'] ?>" class="text-primary font-semibold cursor-pointer">Voir →</a>
                    </div>

                <?php endif; ?>


            <?php endforeach; ?>

        </article>

        <article
            class="column column--unresolved hidden [&.is-active]:block"
            data-status="unresolved">

            <!-- En-tête : caché sur mobile -->
            <div class="hidden md:grid grid-cols-[1fr_130px_130px_70px]  px-5 py-3 text-sm text-muted border-b-2 border-line sticky top-0 z-10">
                <span>Titre</span>
                <span>Créé le</span>
                <span>Statut</span>
                <span></span>
            </div>

            <!-- Affichage des tickets non résolus présents dans la base de donnée (titre, date de création et statut) -->


            <?php foreach ($tickets as $ticket): ?>

                <?php if ($ticket['statut'] === "NONRESOLU"): ?>

                    <div class="flex flex-col md:grid md:grid-cols-[1fr_130px_130px_70px] md:items-center p-5 border-t border-line">
                        <p class="font-semibold"><?= htmlspecialchars($ticket['titre']) ?></p>
                        <!-- date au format français -->
                        <p class="text-sm text-muted"><?= date('d/m/y', strtotime($ticket['date_creation'])) ?></p>
                        <p><span class="<?= $couleurs[$ticket['statut']] ?> text-xs font-bold px-3 py-1 rounded-full"><?= $libelles[$ticket['statut']] ?></span></p>
                        <a href="voir_ticket_dev.php?id=<?= $ticket['id'] ?>" class="text-primary font-semibold cursor-pointer">Voir →</a>
                    </div>

                <?php endif; ?>


            <?php endforeach; ?>

        </article>

        <article
            class="column column--resolved hidden [&.is-active]:block"
            data-status="resolved">

            <!-- En-tête : caché sur mobile -->
            <div class="hidden md:grid grid-cols-[1fr_130px_130px_70px]  px-5 py-3 text-sm text-muted border-b-2 border-line sticky top-0 z-10">
                <span>Titre</span>
                <span>Créé le</span>
                <span>Statut</span>
                <span></span>
            </div>

            <!-- Affichage des tickets résolus présents dans la base de donnée (titre, date de création et statut) -->


            <?php foreach ($tickets as $ticket): ?>

                <?php if ($ticket['statut'] === "RESOLU"): ?>

                    <div class="flex flex-col md:grid md:grid-cols-[1fr_130px_130px_70px] md:items-center p-5 border-t border-line">
                        <p class="font-semibold"><?= htmlspecialchars($ticket['titre']) ?></p>
                        <!-- date au format français -->
                        <p class="text-sm text-muted"><?= date('d/m/y', strtotime($ticket['date_creation'])) ?></p>
                        <p><span class="<?= $couleurs[$ticket['statut']] ?> text-xs font-bold px-3 py-1 rounded-full"><?= $libelles[$ticket['statut']] ?></span></p>
                        <a href="voir_ticket_dev.php?id=<?= $ticket['id'] ?>" class="text-primary font-semibold cursor-pointer">Voir →</a>
                    </div>

                <?php endif; ?>


            <?php endforeach; ?>

        </article>

        
    </main>

    <script type="module" src="../js/main.js"></script>
</body>

</html>