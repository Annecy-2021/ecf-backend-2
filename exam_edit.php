<?php
require_once 'Model/Examen.php';
if (isset($_POST['note'], $_POST['id'])) {
    $exam_model = new Examen();
    $exam = $exam_model->getOne($_POST['id']);
    if (!$exam) {
        $error = 'Erreur : Aucun examen trouvé.';
    } else {
        $note = min(20, max(0, (float)$_POST['note'])); // Note compris entre 0 et 20
        $success = $exam_model->update($_POST['id'], $note);
        if ($success) {
            header('location: show.php?s=' . $exam->id_etudiant);
            die();
        } else {
            $error = 'Erreur : Une erreur est survenue.';
        }
    }
} else if (!isset($_GET['e'])) {
    header('location: index.php');
    die();
}

$exam_model = new Examen();
$exam = $exam_model->getOne((int)$_GET['e']);
if (!$exam) {
    $error = 'Erreur : Aucun examen trouvé.';
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
                <?php if (!isset($error)): ?>
                    <h2>Modifier la note de <?= $exam->prenom . ' ' . $exam->nom ?> à l'examen n°<?= $exam->id_examen ?></h2>
                <?php else: ?>
                    <p><?= $error ?></p>
                <?php endif; ?>
                <a href="show.php?s=<?= $exam->id_etudiant ?>">Retour</a>
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
            <?php die(); endif; ?>

            <section>
                <article class="card">
                    <h5 class="card-header">#<?= $exam->id ?></h5>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5>Elève</h5>
                                <div class="mb-3 input-group">
                                    <label class="input-group-text">Prénom :</label>
                                    <input type="text" class="form-control bg-light" value="<?= $exam->prenom ?>" disabled>
                                </div>
                                <div class="mb-3 input-group">
                                    <label class="input-group-text">Nom :</label>
                                    <input type="text" class="form-control bg-light" value="<?= $exam->nom ?>" disabled>
                                </div>
                            </div>
                            <div class="col">
                                <h5>Examen #<?= $exam->id_examen ?></h5>
                                <div class="mb-3 input-group">
                                    <label class="input-group-text">Matière :</label>
                                    <input type="text" class="form-control bg-light" value="<?= $exam->matiere ?>" disabled>
                                </div>
                                <form method="POST">
                                    <div class="mb-3 input-group">
                                        <label class="input-group-text">Note :</label>
                                        <input type="text" class="form-control bg-light" value="<?= $exam->note ?>" name="note">
                                    </div>
                                    <input type="hidden" value="<?= $exam->id ?>" name="id">
                                    <button type="submit" class="btn btn-primary">Modifier la note</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </article>
            </section>
        </main>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
</html>

