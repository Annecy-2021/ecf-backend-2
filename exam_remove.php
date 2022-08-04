<?php

if (!isset($_GET['e'])) {
    header('location: index.php?error=Erreur: action impossible');
    die();
}

require_once 'Model/Examen.php';
$exam_model = new Examen();

$exam = $exam_model->getOne($_GET['e']);
if (!$exam) {
    header('location: index.php?error=Erreur : Aucun examen trouvé.');
    die();
}

$exam_model->delete($_GET['e']);
header('location: show.php?s=' . $exam->id_etudiant);
die();
