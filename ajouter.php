```php
<?php
$titre = 'Ajouter un étudiant';
require_once __DIR__ . '/config/connexion.php';

// Valeurs du formulaire
$donnees = [
    'cne' => '',
    'nom' => '',
    'prenom' => '',
    'email' => '',
    'filiere' => '',
    'date_naissance' => ''
];

$erreurs = [];

// Étape 3 : traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 1) Récupération et nettoyage des données
    foreach ($donnees as $champ => $v) {
        $donnees[$champ] = trim($_POST[$champ] ?? '');
    }

    $donnees['cne'] = strtoupper($donnees['cne']);

    // 2) Validation côté serveur
    if (!preg_match('/^[A-Z0-9]{6,20}$/', $donnees['cne'])) {
        $erreurs['cne'] = 'Le CNE doit contenir 6 à 20 lettres majuscules ou chiffres.';
    }

    if ($donnees['nom'] === '' || mb_strlen($donnees['nom']) > 50) {
        $erreurs['nom'] = 'Le nom est obligatoire (50 caractères max).';
    }

    if ($donnees['prenom'] === '' || mb_strlen($donnees['prenom']) > 50) {
        $erreurs['prenom'] = 'Le prénom est obligatoire (50 caractères max).';
    }

    if (!filter_var($donnees['email'], FILTER_VALIDATE_EMAIL)) {
        $erreurs['email'] = "L'adresse e-mail n'est pas valide.";
    }

    if (!in_array($donnees['filiere'], FILIERES, true)) {
        $erreurs['filiere'] = 'Veuillez choisir une filière dans la liste.';
    }

    // Date facultative
    if ($donnees['date_naissance'] !== '') {
        $d = DateTime::createFromFormat('Y-m-d', $donnees['date_naissance']);

        if (!$d || $d->format('Y-m-d') !== $donnees['date_naissance']) {
            $erreurs['date_naissance'] = 'Date de naissance invalide.';
        }
    }

    // 3) Insertion dans la base de données
    if (empty($erreurs)) {
        $pdo = getConnexion();

        $sql = "INSERT INTO etudiants
                (cne, nom, prenom, email, filiere, date_naissance)
                VALUES
                (:cne, :nom, :prenom, :email, :filiere, :date_naissance)";

        try {
            // Préparation de la requête
            $stmt = $pdo->prepare($sql);

            // Liaison des valeurs
            $stmt->bindValue(':cne', $donnees['cne']);
            $stmt->bindValue(':nom', $donnees['nom']);
            $stmt->bindValue(':prenom', $donnees['prenom']);
            $stmt->bindValue(':email', $donnees['email']);
            $stmt->bindValue(':filiere', $donnees['filiere']);

            // Date de naissance
            if (empty($donnees['date_naissance'])) {
                $stmt->bindValue(':date_naissance', null, PDO::PARAM_NULL);
            } else {
                $stmt->bindValue(':date_naissance', $donnees['date_naissance']);
            }

            // Exécution de la requête
            $stmt->execute();

            // Récupération de l'id inséré
            $id = $pdo->lastInsertId();

            // Redirection vers la liste
            header('Location: liste.php?ajout=' . $id);
            exit;

        } catch (PDOException $e) {

            // Gestion des doublons
            if ($e->errorInfo[1] == 1062) {
                $erreurs['global'] = 'Un étudiant avec ce CNE ou cet e-mail existe déjà.';
            } else {
                $erreurs['global'] = 'Erreur SQL (' . $e->getCode() . ') : ' . $e->getMessage();
            }
        }
    }
}

require __DIR__ . '/includes/header.php';
?>

<h1>Ajouter un étudiant</h1>

<?php if (!empty($erreurs)): ?>
    <div class="alerte alerte-erreur">
        <strong>Le formulaire contient des erreurs :</strong>
        <ul>
            <?php foreach ($erreurs as $msg): ?>
                <li><?= e($msg) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<div class="carte">
    <form method="post" action="ajouter.php" novalidate>
        <div class="grille">

            <div class="champ">
                <label for="cne">CNE <span class="obligatoire">*</span></label>
                <input type="text" id="cne" name="cne"
                       maxlength="20"
                       value="<?= e($donnees['cne']) ?>"
                       placeholder="ex : R130456789">

                <?php if (isset($erreurs['cne'])): ?>
                    <div class="erreur-champ"><?= e($erreurs['cne']) ?></div>
                <?php endif; ?>
            </div>

            <div class="champ">
                <label for="email">E-mail <span class="obligatoire">*</span></label>
                <input type="email" id="email" name="email"
                       maxlength="100"
                       value="<?= e($donnees['email']) ?>"
                       placeholder="prenom.nom@etu.uca.ma">

                <?php if (isset($erreurs['email'])): ?>
                    <div class="erreur-champ"><?= e($erreurs['email']) ?></div>
                <?php endif; ?>
            </div>

            <div class="champ">
                <label for="nom">Nom <span class="obligatoire">*</span></label>
                <input type="text" id="nom" name="nom"
                       maxlength="50"
                       value="<?= e($donnees['nom']) ?>">

                <?php if (isset($erreurs['nom'])): ?>
                    <div class="erreur-champ"><?= e($erreurs['nom']) ?></div>
                <?php endif; ?>
            </div>

            <div class="champ">
                <label for="prenom">Prénom <span class="obligatoire">*</span></label>
                <input type="text" id="prenom" name="prenom"
                       maxlength="50"
                       value="<?= e($donnees['prenom']) ?>">

                <?php if (isset($erreurs['prenom'])): ?>
                    <div class="erreur-champ"><?= e($erreurs['prenom']) ?></div>
                <?php endif; ?>
            </div>

            <div class="champ">
                <label for="filiere">Filière <span class="obligatoire">*</span></label>
                <select id="filiere" name="filiere">
                    <option value="">— Choisir —</option>

                    <?php foreach (FILIERES as $f): ?>
                        <option value="<?= e($f) ?>"
                            <?= $donnees['filiere'] === $f ? 'selected' : '' ?>>
                            <?= e($f) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <?php if (isset($erreurs['filiere'])): ?>
                    <div class="erreur-champ"><?= e($erreurs['filiere']) ?></div>
                <?php endif; ?>
            </div>

            <div class="champ">
                <label for="date_naissance">Date de naissance</label>
                <input type="date" id="date_naissance" name="date_naissance"
                       value="<?= e($donnees['date_naissance']) ?>">

                <?php if (isset($erreurs['date_naissance'])): ?>
                    <div class="erreur-champ"><?= e($erreurs['date_naissance']) ?></div>
                <?php endif; ?>
            </div>

        </div>

        <div class="actions">
            <button type="submit" class="btn">Enregistrer</button>
            <a href="liste.php" class="btn btn-secondaire">Annuler</a>
        </div>
    </form>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
```