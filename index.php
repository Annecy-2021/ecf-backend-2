<?php

require_once 'Model/Student.php';

$student_model = new Student();

if (isset($_GET['error'])) $error = htmlspecialchars($_GET['error']);

if (isset($_GET['nom']) || isset($_GET['prenom'])) {
    $students = $student_model->getAllByName($_GET['nom'] ?? '', $_GET['prenom'] ?? '');
    $alert = count($students) . ' résultat(s) trouvé(s)';
} else {
    $students = $student_model->getAll();
}
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <title>ECF Backend 2</title>
    </head>
    <body>
        <main class="container">

            <section class="p-5 mb-4 mt-4 bg-light rounded-3">
                <h1>Interface de gestion des élèves et des examens</h1>
                <h2>Liste des élèves</h2>
            </section>

            <header class="py-3 mb-3 border-bottom">
                <div class="container-fluid d-grid gap-3 align-items-center" style="grid-template-columns: 1fr 2fr;">
                    <h1>ECF Backend</h1>

                    <form class="w-100 me-3 row g-3" action="index.php" method="GET">
                        <div class="col">
                            <input type="search" class="form-control" placeholder="Nom" name="nom">
                        </div>
                        <div class="col">
                            <input type="search" class="form-control" placeholder="Prénom" name="prenom">
                        </div>
                        <button class="btn btn-primary col" type="submit">Rechercher un élève</button>
                    </form>
                </div>
            </header>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger" role="alert">
                    <?= $error ?>
                </div>
            <?php endif; ?>

            <?php if (isset($alert)): ?>
                <div class="alert alert-primary" role="alert">
                    <?= $alert ?>
                </div>
            <?php endif; ?>

            <section>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Prénom</th>
                            <th scope="col">Nom</th>
                            <th scope="col">Moyenne générale</th>
                            <th scope="col">Détails</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($students as $student): ?>
                            <tr>
                                <th scope="row"><?= $student->id_etudiant ?></th>
                                <td><?= $student->prenom ?></td>
                                <td><?= $student->nom ?></td>
                                <td><?= $student->moyenne ?></td>
                                <td><a href="show.php?s=<?= $student->id_etudiant ?>">Voir</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </section>

        </main>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
</html>
