<?php
/** En-tête commun à toutes les pages. Définir $titre avant l'include. */
$titre = $titre ?? 'Gestion des étudiants';
$page  = basename($_SERVER['SCRIPT_NAME']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($titre) ?> — TP PDO</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<header class="topbar">
    <div class="brand">🎓 Gestion des étudiants <span>TP PDO</span></div>
    <nav>
        <a href="index.php"   class="<?= $page === 'index.php'   ? 'actif' : '' ?>">Accueil</a>
        <a href="ajouter.php" class="<?= $page === 'ajouter.php' ? 'actif' : '' ?>">Ajouter</a>
        <a href="liste.php"   class="<?= $page === 'liste.php'   ? 'actif' : '' ?>">Liste</a>
    </nav>
</header>
<main class="conteneur">
