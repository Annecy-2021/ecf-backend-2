<?php

if (!isset($_POST['id_etudiant'], $_POST['nom'], $_POST['prenom'])) {
    header('location: index.php?error=Erreur: action impossible');
    die();
}

require_once 'Model/Student.php';
$student_model = new Student();
$error = !$student_model->update($_POST['id_etudiant'], $_POST['nom'], $_POST['prenom']);
header('location: show.php?s=' . $_POST['id_etudiant'] . ($error ? '&error=Erreur: action impossible' : ''));
die();
