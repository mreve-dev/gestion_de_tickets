<header class="flex flex-col justify-between gap-4
 max-w-200 w-full">

    <article class="bg-surface p-5 rounded-2xl  border-2 border-line w-full flex items-center justify-between">

        <section class="">
            <?php if ($_SESSION['role'] === "dev"):  ?>
                <h1 class="text-2xl font-semibold">Dashboard dev</h1>
            <?php else: ?>
                <h1>Dashboard utilisateur</h1>
            <?php endif; ?>



            <h2 class="text-muted">
                Bonjour, <?= htmlspecialchars($_SESSION['identifiant']) ?>
            </h2>
        </section>

        <section class="flex items-center gap-3">


            <?php if ($_SESSION['role'] === "usager" && $page !== 'create'):  ?>
                <form action="./createTicket.php" method="GET">
                    <button
                        type="submit"
                        class="cursor-pointer rounded-2xl bg-primary-soft px-5 py-2 text-primary font-semibold hover:bg-primary hover:text-white">
                        + Créer un ticket
                    </button>
                </form>

            <?php endif; ?>





            <form action="./deconnexion.php" method="POST" class="text-accent font-semibold">
                <button
                    type="submit"
                    class="cursor-pointer px-5 py-2 rounded-2xl flex items-center gap-3 bg-neutral-btn text-ink hover:bg-neutral-btn-hover">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span class="hidden md:block">Se déconnecter</span>
                </button>
            </form>

        </section>



    </article>

    <?php if ($page === 'dashboard'): ?>
        <nav class="grid gap-6 md:flex md:w-full">
            <button
                type="button"
                class="group flex-1 flex items-center justify-center gap-2 bg-surface rounded-4xl px-5 py-2 border-2 font-semibold whitespace-nowrap border-line text-muted aria-pressed:border-primary aria-pressed:text-primary"
                aria-pressed="true"
                data-status="all">
                Tout
                <span class="px-3 rounded-full bg-line group-aria-pressed:bg-primary/20">0</span>
            </button>

            <button
                type="button"
                class="group flex-1 flex items-center justify-center gap-2 bg-surface rounded-4xl px-5 py-2 border-2 font-semibold whitespace-nowrap border-line text-muted aria-pressed:border-new aria-pressed:text-new"
                aria-pressed="false"
                data-status="new">
                Nouveau
                <span class="px-3 rounded-full bg-line group-aria-pressed:bg-new/20">0</span>
            </button>

            <button
                type="button"
                class="group flex-1 flex items-center justify-center gap-2 bg-surface rounded-4xl px-5 py-2 border-2 font-semibold whitespace-nowrap border-line text-muted aria-pressed:border-unresolved aria-pressed:text-unresolved"
                aria-pressed="false"
                data-status="unresolved">
                Non résolu
                <span class="px-3 rounded-full bg-line group-aria-pressed:bg-unresolved/20">0</span>
            </button>
            <button
                type="button"
                class="group flex-1 flex items-center justify-center gap-2 bg-surface rounded-4xl px-5 py-2 border-2 font-semibold whitespace-nowrap border-line text-muted aria-pressed:border-resolved aria-pressed:text-resolved"
                aria-pressed="false"
                data-status="resolved">
                Résolu
                <span class="px-3 py-1 rounded-full bg-line group-aria-pressed:bg-resolved/20">0</span>
            </button>

            <?php if ($_SESSION['role'] === "usager"): ?>
                <button
                    type="button"
                    class="group flex-1 flex items-center justify-center gap-2 bg-surface rounded-4xl px-5 py-2 border-2 font-semibold whitespace-nowrap border-line text-muted aria-pressed:border-closed aria-pressed:text-closed"
                    aria-pressed="false"
                    data-status="resolved">
                    Clos
                    <span class="px-3 py-1 rounded-full bg-line group-aria-pressed:bg-closed/20">0</span>
                </button>
            <?php endif; ?>

        </nav>

    <?php endif; ?>




</header>