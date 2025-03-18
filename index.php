<?php
require_once '../Model/pdo.php';

$etudiants = $dbPDO->query("SELECT id, prenom, nom FROM etudiants")->fetchAll(PDO::FETCH_ASSOC);
$classes = $dbPDO->query("SELECT id, libelle FROM classes")->fetchAll(PDO::FETCH_ASSOC);
$professeurs = $dbPDO->query("SELECT prenom, nom FROM professeurs")->fetchAll(PDO::FETCH_ASSOC);
$users = $dbPDO->query("SELECT id, prenom, nom, email, role FROM users")->fetchAll(PDO::FETCH_ASSOC);

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
    <title>Gestion des Étudiants et Utilisateurs</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
    <div class="container mx-auto">

        <h1 class="text-2xl font-bold mb-4">Liste des Étudiants</h1>
        <div class="overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 border border-gray-200">
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
                            <td class="px-6 py-4"><?php echo htmlspecialchars($etudiant['prenom']); ?></td>
                            <td class="px-6 py-4"><?php echo htmlspecialchars($etudiant['nom']); ?></td>
                            <td class="px-6 py-4">
                                <a href='Views/modif_etudiant.php?id=<?php echo $etudiant['id']; ?>' class="text-blue-500">Modifier</a> | 
                                <a href='Views/suppression_etudiant.php?id=<?php echo $etudiant['id']; ?>' class="text-red-500">Supprimer</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <h1 class="text-2xl font-bold mt-6 mb-4">Liste des Classes</h1>
        <div class="overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 border border-gray-200">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th class="px-6 py-3">Libellé</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($classes as $classe) { ?>
                        <tr class="border-b bg-white">
                            <td class="px-6 py-4"><?php echo htmlspecialchars($classe['libelle']); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <h1 class="text-2xl font-bold mt-6 mb-4">Liste des Professeurs</h1>
        <div class="overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 border border-gray-200">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th class="px-6 py-3">Prénom</th>
                        <th class="px-6 py-3">Nom</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($professeurs as $prof) { ?>
                        <tr class="border-b bg-white">
                            <td class="px-6 py-4"><?php echo htmlspecialchars($prof['prenom']); ?></td>
                            <td class="px-6 py-4"><?php echo htmlspecialchars($prof['nom']); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <h1 class="text-2xl font-bold mt-6 mb-4">Professeurs avec Matière et Classe</h1>
        <div class="overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 border border-gray-200">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th class="px-6 py-3">Prénom</th>
                        <th class="px-6 py-3">Nom</th>
                        <th class="px-6 py-3">Matière</th>
                        <th class="px-6 py-3">Classe</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($professeurs_detail as $prof) { ?>
                        <tr class="border-b bg-white">
                            <td class="px-6 py-4"><?php echo htmlspecialchars($prof['prenom']); ?></td>
                            <td class="px-6 py-4"><?php echo htmlspecialchars($prof['nom']); ?></td>
                            <td class="px-6 py-4"><?php echo htmlspecialchars($prof['matiere']); ?></td>
                            <td class="px-6 py-4"><?php echo htmlspecialchars($prof['classe']); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <h1 class="text-2xl font-bold mt-6 mb-4">Liste des Utilisateurs</h1>
        <div class="overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 border border-gray-200">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th class="px-6 py-3">Prénom</th>
                        <th class="px-6 py-3">Nom</th>
                        <th class="px-6 py-3">Email</th>
                        <th class="px-6 py-3">Rôle</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user) { ?>
                        <tr class="border-b bg-white">
                            <td class="px-6 py-4"><?php echo htmlspecialchars($user['prenom']); ?></td>
                            <td class="px-6 py-4"><?php echo htmlspecialchars($user['nom']); ?></td>
                            <td class="px-6 py-4"><?php echo htmlspecialchars($user['email']); ?></td>
                            <td class="px-6 py-4"><?php echo htmlspecialchars($user['role']); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

    </div>
</body>
</html>
