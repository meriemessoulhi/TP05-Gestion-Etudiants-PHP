<?php
$titre = 'Accueil';
require_once __DIR__ . '/config/connexion.php';

$pdo = getConnexion();
// query() suffit ici : la requête ne contient aucune donnée venant de l'utilisateur
$total = $pdo->query('SELECT COUNT(*) FROM etudiants')->fetchColumn();

require __DIR__ . '/includes/header.php';
?>
<h1>Bienvenue</h1>
<div class="carte">
    <p>Cette petite application permet de gérer la liste des étudiants à l'aide de <strong>PHP / PDO</strong> et <strong>MySQL</strong>.</p>
    <p>Nombre d'étudiants inscrits : <span class="badge"><?= (int) $total ?></span></p>
    <div class="actions">
        <a class="btn" href="ajouter.php"> Ajouter un étudiant</a>
        <a class="btn btn-secondaire" href="liste.php">📋 Voir la liste</a>
    </div>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
