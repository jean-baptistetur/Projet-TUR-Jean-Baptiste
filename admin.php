<?php
require_once '../pdo.php';

$etudiants = $dbPDO->query("SELECT id, prenom, nom FROM etudiants")->fetchAll(PDO::FETCH_ASSOC);
$classes = $dbPDO->query("SELECT id, libelle FROM classes")->fetchAll(PDO::FETCH_ASSOC);
$professeurs = $dbPDO->query("SELECT id, prenom, nom FROM professeurs")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_student'])) {
        $prenom = $_POST['prenom'];
        $nom = $_POST['nom'];
        $classe_id = $_POST['classe_id'];
        $stmt = $dbPDO->prepare("INSERT INTO etudiants (prenom, nom, classe_id) VALUES (?, ?, ?)");
        $stmt->execute([$prenom, $nom, $classe_id]);
    }

    if (isset($_POST['delete_student'])) {
        $id = $_POST['student_id'];
        $stmt = $dbPDO->prepare("DELETE FROM etudiants WHERE id = ?");
        $stmt->execute([$id]);
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
    <div class="container mx-auto">
        <h1 class="text-3xl font-bold mb-6">Admin Panel</h1>

        <!-- Ajout d'un étudiant -->
        <h2 class="text-xl font-semibold mb-3">Ajouter un Étudiant</h2>
        <form action="" method="POST" class="bg-white p-4 shadow-md rounded-lg">
            <label class="block mb-2">Prénom :</label>
            <input type="text" name="prenom" required class="w-full p-2 border rounded">
            
            <label class="block mt-2 mb-2">Nom :</label>
            <input type="text" name="nom" required class="w-full p-2 border rounded">
            
            <label class="block mt-2 mb-2">Classe :</label>
            <select name="classe_id" required class="w-full p-2 border rounded">
                <?php foreach ($classes as $classe) { ?>
                    <option value="<?= $classe['id']; ?>"><?= htmlspecialchars($classe['libelle']); ?></option>
                <?php } ?>
            </select>
            
            <button type="submit" name="add_student" class="bg-blue-500 text-white px-4 py-2 mt-4 rounded">Ajouter</button>
        </form>

        <!-- Liste des étudiants avec suppression -->
        <h2 class="text-xl font-semibold mt-6 mb-3">Liste des Étudiants</h2>
        <div class="overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-gray-500 border border-gray-200">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th class="px-6 py-3">Prénom</th>
                        <th class="px-6 py-3">Nom</th>
                        <th class="px-6 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($etudiants as $etudiant) { ?>
                        <tr class="border-b bg-white">
                            <td class="px-6 py-4"><?= htmlspecialchars($etudiant['prenom']); ?></td>
                            <td class="px-6 py-4"><?= htmlspecialchars($etudiant['nom']); ?></td>
                            <td class="px-6 py-4">
                                <a href='modif_etudiant.php?id=<?= $etudiant['id']; ?>' class="text-blue-500">Modifier</a>
                                <form action="" method="POST" class="inline">
                                    <input type="hidden" name="student_id" value="<?= $etudiant['id']; ?>">
                                    <button type="submit" name="delete_student" class="text-red-500 ml-2">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <h2 class="text-xl font-semibold mt-6 mb-3">Ajouter une Classe</h2>
        <form action="ajout_classe.php" method="POST" class="bg-white p-4 shadow-md rounded-lg">
            <label class="block mb-2">Libellé :</label>
            <input type="text" name="libelle" required class="w-full p-2 border rounded">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 mt-4 rounded">Ajouter</button>
        </form>

        <h2 class="text-xl font-semibold mt-6 mb-3">Ajouter un Professeur</h2>
        <form action="ajout_professeur.php" method="POST" class="bg-white p-4 shadow-md rounded-lg">
            <label class="block mb-2">Prénom :</label>
            <input type="text" name="prenom" required class="w-full p-2 border rounded">
            
            <label class="block mt-2 mb-2">Nom :</label>
            <input type="text" name="nom" required class="w-full p-2 border rounded">
            
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 mt-4 rounded">Ajouter</button>
        </form>
        
        <a href="logout.php" class="mt-6 inline-block text-red-500">Se déconnecter</a>
    </div>
</body>
</html>
