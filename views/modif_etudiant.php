<?php
require_once '../pdo.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID étudiant manquant");
}

$id = (int)$_GET['id'];
$req = $dbPDO->prepare("SELECT * FROM etudiants WHERE id = ?");
$req->execute([$id]);
$etudiant = $req->fetch(PDO::FETCH_ASSOC);

if (!$etudiant) {
    die("Étudiant introuvable");
}

$classes = $dbPDO->query("SELECT id, libelle FROM classes")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $classe_id = $_POST['classe_id'];

    $update = $dbPDO->prepare("UPDATE etudiants SET prenom = ?, nom = ?, id_classe = ? WHERE id = ?");
    $update->execute([$prenom, $nom, $classe_id, $id]);
    
    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Étudiant</title>
</head>
<body>
    <h1>Modifier Étudiant</h1>
    <form method="POST">
        <input type="text" name="prenom" value="<?= htmlspecialchars($etudiant['prenom']) ?>" required>
        <input type="text" name="nom" value="<?= htmlspecialchars($etudiant['nom']) ?>" required>
        <select name="classe_id" required>
            <?php foreach ($classes as $classe) {
                $selected = $classe['id'] == $etudiant['id_classe'] ? 'selected' : '';
                echo "<option value='" . $classe['id'] . "' $selected>" . htmlspecialchars($classe['libelle']) . "</option>";
            } ?>
        </select>
        <button type="submit">Modifier</button>
    </form>
    <a href="../index.php">Retour</a>
</body>
</html>
