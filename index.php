<?php
require_once '../Model/pdo.php';

$etudiants = $dbPDO->query("SELECT id, prenom, nom FROM etudiants")->fetchAll(PDO::FETCH_ASSOC);
$classes = $dbPDO->query("SELECT id, libelle FROM classes")->fetchAll(PDO::FETCH_ASSOC);
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
        <?php foreach ($etudiants as $etudiant) {
            echo "<li>" . htmlspecialchars($etudiant['prenom']) . " " . htmlspecialchars($etudiant['nom']) . " ";
            echo "<a href='Views/modif_etudiant.php?id=" . $etudiant['id'] . "'>Modifier</a>";
            echo " | <a href='Views/suppression_etudiant.php?id=" . $etudiant['id'] . "'>Supprimer</a></li>";
        } ?>
    </ul>

    <h1>Liste des Classes</h1>
    <ul>
        <?php foreach ($classes as $classe) {
            echo "<li>" . htmlspecialchars($classe['libelle']) . "</li>";
        } ?>
    </ul>

    <h1>Liste des Professeurs</h1>
    <ul>
        <?php foreach ($professeurs as $prof) {
            echo "<li>" . htmlspecialchars($prof['prenom']) . " " . htmlspecialchars($prof['nom']) . "</li>";
        } ?>
    </ul>

    <h1>Professeurs avec Matière et Classe</h1>
    <ul>
        <?php foreach ($professeurs_detail as $prof) {
            echo "<li>" . htmlspecialchars($prof['prenom']) . " " . htmlspecialchars($prof['nom']) . " - " . htmlspecialchars($prof['matiere']) . " (" . htmlspecialchars($prof['classe']) . ")</li>";
        } ?>
    </ul>

    <h1>Ajouter une Matière</h1>
    <form action="Views/nouvelle_matiere.php" method="POST">
        <input type="text" name="libelle" required>
        <button type="submit">Valider</button>
    </form>

    <h1>Ajouter un Étudiant</h1>
    <form action="Views/nouvel_etudiant.php" method="POST">
        <input type="text" name="prenom" placeholder="Prénom" required>
        <input type="text" name="nom" placeholder="Nom" required>
        <select name="classe_id" required>
            <?php foreach ($classes as $classe) {
                echo "<option value='" . $classe['id'] . "'>" . htmlspecialchars($classe['libelle']) . "</option>";
            } ?>
        </select>
        <button type="submit">Valider</button>
    </form>
</body>
</html>
