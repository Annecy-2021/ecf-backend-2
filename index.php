<?php

require_once 'Model/Student.php';

$student_model = new Student();

if (isset($_GET['error'])) $error = htmlspecialchars($_GET['error']);
$page = (int)($_GET['p'] ?? 1);
$nom = $_GET['nom'] ?? '';
$prenom = $_GET['prenom'] ?? '';

$result_count = $student_model->countAll($nom, $prenom)->count;
$total_pages = max(ceil($result_count / 6), 1);

// redirection si page inexistante
if ($page > $total_pages) {
    $_GET['p'] = $total_pages;
    header('location: index.php?' . http_build_query($_GET));
    die();
} else if ($page < 1) {
    unset($_GET['p']);
    header('location: index.php?' . http_build_query($_GET));
    die();
}

$alert = $result_count . ' résultat(s) trouvé(s)';
$students = $student_model->getAll($nom, $prenom, $page);

$next = $page + 1;
$prev = $page - 1;
unset($_GET['p']);
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
        <main class="container mb-5">

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
                            <th scope="col">Moyenne générale (sur 20)</th>
                            <th scope="col">Détails</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($students as $student): ?>
                            <tr>
                                <th scope="row"><?= $student->id_etudiant ?></th>
                                <td><?= $student->prenom ?></td>
                                <td><?= $student->nom ?></td>
                                <td><?= number_format($student->moyenne, 2) ?></td>
                                <td><a href="show.php?s=<?= $student->id_etudiant ?>">Voir</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </section>

            <nav>
                <ul class="pagination justify-content-between">
                    <li class="page-item <?= $prev > 0 ?: 'disabled' ?>">
                        <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['p' => $prev])) ?>">Précédent</a>
                    </li>
                    <li class="page-item <?= $next <= $total_pages ? '' : 'disabled' ?>">
                        <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['p' => $next])) ?>">Suivant</a>
                    </li>
                </ul>
            </nav>

        </main>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
</html>
