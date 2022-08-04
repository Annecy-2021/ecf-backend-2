<?php

if (!isset($_POST['id_etudiant'], $_POST['note'], $_POST['examen'])) {
    header('location: index.php?error=Erreur: action impossible');
    die();
}

require_once 'Model/Examen.php';
$exam_model = new Examen();

[$matiere, $id_examen] = explode('#', $_POST['examen']);
$note = min(20, max(0, (float)$_POST['note'])); // Note compris entre 0 et 20

$error = !$exam_model->create($_POST['id_etudiant'], $id_examen, $matiere, $note);
header('location: show.php?s=' . $_POST['id_etudiant'] . ($error ? '&error=Erreur: action impossible' : ''));
die();
