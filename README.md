# Unis pour aider : version locale

Projet scolaire HTML/CSS/PHP adapté à SQLite. Le design et les contenus de l’export fourni sont conservés. Les adresses de connexion sont remplacées par des adresses de démonstration.

## Lancer sur Windows

1. Installer PHP 8.1 ou plus récent, ou XAMPP.
2. Dans le `php.ini` utilisé par PHP, activer `extension=pdo_sqlite` et `extension=sqlite3` (retirer le point-virgule devant ces lignes). `php --ini` indique le fichier utilisé.
3. Extraire le ZIP, puis double-cliquer sur `lancer-windows.bat`. Il utilise en priorité XAMPP dans `C:\xampp`, puis PHP dans le PATH.
4. Ouvrir http://localhost:8000/index.php et garder la fenêtre du serveur ouverte.

Alternative dans un terminal, depuis ce dossier :

```sh
php -S localhost:8000 router.php
```

Avec XAMPP, si PHP n’est pas dans le PATH :

```bat
C:\xampp\php\php.exe -S localhost:8000 router.php
```

Aucun serveur MySQL, aucun import manuel et aucune ancienne connexion distante nécessaires. Le dossier doit être accessible en écriture. La base `data/asbl.sqlite` est créée au premier accès aux données à partir de `bd.sql`. Les modifications persistent après redémarrage.

## Compte de démonstration

- Identifiant : `demo@example.test`
- Mot de passe : `Portfolio2026!`

Les mots de passe sont hachés au premier lancement. Les autres comptes sont désactivés pour la connexion.

## Fonctionnalités

Accueil, actualités, recherche, tri, équipe, connexion, consultation du profil, modification et suppression des départements, ajout d’actualités. Supprimer un département conserve son personnel, qui devient sans département. Le formulaire de contact enregistre les messages dans la table `Messages`, sans envoyer d’e-mail.

Pour remettre les données à zéro, arrêter le serveur puis supprimer `data/asbl.sqlite` : la base est recréée au prochain lancement.

## Corrections

Connexion PDO SQLite automatique ; chemins d’images Windows convertis ; inclusions uniques ; exceptions correctement résolues ; colonnes PDO déclarées pour PHP récent ; identifiants d’actualités auto-incrémentés ; rafraîchissement après suppression ; profil accessible après connexion ; déconnexion avant l’envoi du HTML ; erreur de connexion affichée.

## Limites héritées et suite pour le portfolio

Cette version est destinée à une démonstration locale. Les écrans d’administration restent accessibles sans contrôle de rôle et les formulaires n’ont pas de jeton CSRF. Avant une mise en ligne, compléter les autorisations, la validation serveur et l’échappement systématique des sorties.

Le profil affiche le nom, prénom et téléphone en lecture seule et permet de changer la photo. La réinitialisation par e-mail n’est pas disponible ; l’écran indique cette limite et rappelle le compte de démonstration. Ces fonctions n’étaient pas réalisées dans le projet d’origine.

L’interface utilise les polices système et des symboles intégrés : le projet fonctionne sans ressources externes.

`bd.sql` utilise désormais la syntaxe SQLite et ne doit pas être importé dans phpMyAdmin. Garder votre ZIP original si vous souhaitez retrouver l’export MySQL historique.

## Vérification réalisée

Syntaxe contrôlée sous PHP 8.3 ; tests HTTP de consultation des pages, recherche et tri, connexion valide/invalide, profil, ajout d’actualité, édition/suppression de département, contact local et déconnexion. Base et export SQLite vérifiés, ainsi que les chemins des 81 photos.

## Présentation sobre

Identité anthracite et turquoise conservée. CSS lisible et commenté, avec des règles classiques : couleurs, marges, bordures, Flexbox et deux media queries. Accueil simple, cartes blanches et formulaires harmonisés. Aucune animation, illustration décorative ou dépendance externe.

Pour remplacer votre ancienne version : sauvegardez votre dossier, puis copiez les fichiers de cette archive dans le projet. Si vous avez déjà une base `data/asbl.sqlite`, gardez-la pour conserver vos modifications.
