<?php

require_once 'pdo.php';



$etudiants = $dbPDO->query("SELECT prenom, nom FROM etudiants")->fetchAll(PDO::FETCH_ASSOC);


$classes = $dbPDO->query("SELECT libelle FROM classes")->fetchAll(PDO::FETCH_ASSOC);


$professeurs = $dbPDO->query("SELECT prenom, nom FROM professeurs")->fetchAll(PDO::FETCH_ASSOC);


$query = "SELECT professeurs.prenom, professeurs.nom, matiere.lib AS matiere, classes.libelle AS classe 
          FROM professeurs 
          JOIN matiere ON professeurs.id_matiere = matiere.id 
          JOIN classes ON professeurs.id_classe = classes.id";
$professeurs_detail = $dbPDO->query($query)->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Étudiants, Classes et Professeurs</title>
</head>
<body>
    <h1>Liste des Étudiants</h1>
    <ul>
        <?php foreach ($etudiants as $etudiant): ?>
            <li><?= htmlspecialchars($etudiant['prenom']) . " " . htmlspecialchars($etudiant['nom']) ?></li>
        <?php endforeach; ?>
    </ul>

    <h1>Liste des Classes</h1>
    <ul>
        <?php foreach ($classes as $classe): ?>
            <li><?= htmlspecialchars($classe['libelle']) ?></li>
        <?php endforeach; ?>
    </ul>

    <h1>Liste des Professeurs</h1>
    <ul>
        <?php foreach ($professeurs as $prof): ?>
            <li><?= htmlspecialchars($prof['prenom']) . " " . htmlspecialchars($prof['nom']) ?></li>
        <?php endforeach; ?>
    </ul>

    <h1>Professeurs avec Matière et Classe</h1>
    <ul>
        <?php foreach ($professeurs_detail as $prof): ?>
            <li><?= htmlspecialchars($prof['prenom']) . " " . htmlspecialchars($prof['nom']) . " - " . htmlspecialchars($prof['matiere']) . " (" . htmlspecialchars($prof['classe']) . ")" ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
