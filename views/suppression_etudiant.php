<?php
require_once '../pdo.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $dbPDO->prepare("SELECT COUNT(*) FROM etudiants WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $etudiantExiste = $stmt->fetchColumn();

    if ($etudiantExiste) {
        $stmt = $dbPDO->prepare("DELETE FROM etudiants WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        header("Location: ../index.php?message=Suppression réussie");
        exit();
    } else {
        echo "Étudiant introuvable.";
    }
} else {
    echo "ID invalide.";
}
?>
