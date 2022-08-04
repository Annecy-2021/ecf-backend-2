<?php

if (!isset($_GET['s'])) {
    header('location: index.php?error=Erreur: Action impossible');
    die();
}

require_once 'Model/Student.php';
$student_model = new Student();

$student = $student_model->getOne((int)$_GET['s']);
if (!$student) {
    header('location: index.php?error=Erreur: Aucun étudiant trouvé.');
    die();
}

$student_model->delete((int)$_GET['s']);
header('location: index.php');
die();
