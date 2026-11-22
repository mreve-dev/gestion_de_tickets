# Gestion de tickets — Projet PHP Base

Prototype d'application de gestion de tickets en **PHP natif** (sans framework) avec une base **MySQL**.
Les usagers signalent des problèmes, la personne de l'équipe de développement y répond.

---

## Installation

1. **Base de données** : exécuter `base.sql` dans MySQL (crée la base `lc_tickets`, les tables et les 3 comptes).
2. **Connexion à la base** : dans `bdd/bdd.php`, remplacer l'identifiant et le mot de passe MySQL dans la ligne `new PDO(...)`.
3. **PHP** : l'extension `pdo_mysql` doit être activée dans `php.ini`.
4. **Lancer le serveur** depuis la racine du projet :
   ```
   php -S localhost:8000
   ```
5. Ouvrir `http://localhost:8000/index.php`.

## Comptes de test

| Identifiant | Mot de passe | Rôle |
|---|---|---|
| alice | alice | dev |
| bob | bob | usager |
| charles | charles | usager |

## Structure

```
Projet/
├── index.php              → page de connexion
├── base.sql               → création de la base
├── bdd/
│   └── bdd.php            → fonction executerRequete (fournie par le sujet)
├── js/
│   └── main.js            → changement d'onglet sur les dashboards
└── src/
    ├── head.php           → <head> commun (Tailwind + couleurs)
    ├── header.php         → en-tête commun (titre, déconnexion, onglets)
    ├── statut.php         → libellés et couleurs des statuts
    ├── deconnexion.php
    ├── dashboard_dev.php
    ├── dashboard_usager.php
    ├── createTicket.php
    ├── voir_ticket_dev.php
    └── voir_ticket_usager.php
```

---

## Ce qui est fait

### Connexion / déconnexion
- [x] Formulaire de connexion avec vérification des champs
- [x] Vérification du mot de passe avec `password_verify`
- [x] Message d'erreur unique « Identifiant ou mot de passe incorrect »
- [x] Session : id, rôle et identifiant de l'utilisateur
- [x] Redirection selon le rôle (dev → `dashboard_dev.php`, usager → `dashboard_usager.php`)
- [x] Utilisateur déjà connecté redirigé directement vers son dashboard
- [x] Déconnexion (`session_destroy`) depuis chaque page

### Sécurité
- [x] Chaque page vérifie le rôle et redirige vers la connexion si l'accès est refusé
- [x] `htmlspecialchars` sur les textes saisis par les utilisateurs

### Dashboard dev
- [x] Liste des tickets en cours (tous les usagers, hors tickets clos)
- [x] Titre, date de création, statut et lien « Voir » pour chaque ticket
- [x] Filtre par statut avec des onglets (Tout, Nouveau, Non résolu, Résolu)

### Dashboard usager
- [x] Liste de ses propres tickets uniquement
- [x] Filtre par statut avec des onglets (Tout, Nouveau, Non résolu, Résolu, Clos)

### Créer un ticket (usager)
- [x] Formulaire titre + description
- [x] Statut forcé à « NOUVEAU » et date du jour ajoutés côté PHP
- [x] Enregistrement en base puis redirection vers le dashboard

### Visuel
- [x] Tailwind (CDN) avec une palette de couleurs personnalisée
- [x] Responsive (mobile et ordinateur)

---

## Ce qui reste à faire

### Voir un ticket — dev (`voir_ticket_dev.php`)
- [ ] Récupérer l'id dans l'URL (`$_GET`) et le ticket avec `voir-ticket-par-id`
- [ ] Afficher titre, description, date de création et statut
- [ ] Afficher l'historique des messages (`voir-responses-par-ticket`)
- [ ] Formulaire « Répondre » si le statut est NOUVEAU ou NONRESOLU
  - [ ] Enregistrer le message (`creer-reponse`)
  - [ ] Passer le ticket en RESOLU (`modifier-statut-ticket`)
- [ ] Aucune action possible pour les autres statuts

### Voir un ticket — usager (`voir_ticket_usager.php`)
- [ ] Mêmes affichages que la page dev, avec l'auteur du ticket (`compte_id`)
- [ ] Vérifier que le ticket appartient bien à l'usager connecté
- [ ] Bouton « Clore le ticket » (tous statuts sauf CLOS) → statut CLOS
- [ ] Formulaire « Répondre » seulement si le statut est RESOLU → statut NONRESOLU

### Finitions
- [ ] Supprimer les anciens commentaires de l'exercice formulaire
- [ ] Vérifier que le HTML est valide
- [ ] Préparer le ZIP de rendu (sans `node_modules`)

### Bonus
- [ ] Compteurs de tickets dans les onglets
- [ ] Cacher l'onglet « Clos » côté dev
- [ ] `session_regenerate_id(true)` après la connexion

---

## Sources et aides

- Requêtes SQL et fonction `executerRequete` : fournies par le sujet.
- Assistance d'une IA (Claude, Anthropic) pour des explications, le débogage, la palette de couleurs et des maquettes visuelles.