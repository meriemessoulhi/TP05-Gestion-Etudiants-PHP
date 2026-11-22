
<?php
/**
 * BONUS 5.2 : suppression d'un étudiant.
 * Reçoit l'id en POST, exécute un DELETE préparé, puis redirige vers la liste.
 */

require_once __DIR__ . '/config/connexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: liste.php');
    exit;
}

// Récupération et validation de l'id
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

if ($id) {
    $pdo = getConnexion();

    // 5.2.a : préparer la requête DELETE
    $sql = "DELETE FROM etudiants WHERE id = :id";
    $stmt = $pdo->prepare($sql);

    // 5.2.b : lier l'id et exécuter
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    // 5.2.c : vérifier si un étudiant a été supprimé
    if ($stmt->rowCount() === 1) {
        header('Location: liste.php?supprime=1');
        exit;
    }
}

header('Location: liste.php');
exit;
