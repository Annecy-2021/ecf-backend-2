<?php
require_once 'Connect.php';

class Examen extends Connect
{
    public function getOne(int $id)
    {
        $req = $this->pdo->prepare('SELECT x.id, x.id_examen, x.matiere, x.note, e.prenom, e.nom, e.id_etudiant
            FROM examens x
            INNER JOIN etudiants e ON x.id_etudiant = e.id_etudiant
            WHERE x.id = :id
        ');
        $req->bindParam('id', $id);
        $req->execute();
        return $req->fetch();
    }

    public function update(int $id, float $note)
    {
        $note = (string)$note; // transformation en string pour le bindParam
        $req = $this->pdo->prepare('UPDATE examens SET note = :note WHERE id = :id');
        $req->bindParam('note', $note);
        $req->bindParam('id', $id, PDO::PARAM_INT);
        return $req->execute();
    }

    public function create(int $id_etudiant, int $id_examen, string $matiere, float $note)
    {
        $note = (string)$note;
        $req = $this->pdo->prepare(
            'INSERT INTO examens (id_examen, id_etudiant, matiere, note)
            VALUES (:id_exa, :id_etu, :matiere, :note)'
        );
        $req->bindParam('id_exa', $id_examen, PDO::PARAM_INT);
        $req->bindParam('id_etu', $id_etudiant, PDO::PARAM_INT);
        $req->bindParam('matiere', $matiere);
        $req->bindParam('note', $note);
        return $req->execute();
    }

    public function delete(int $id)
    {
        $req = $this->pdo->prepare('DELETE FROM examens WHERE id = :id');
        $req->bindParam('id', $id, PDO::PARAM_INT);
        return $req->execute();
    }
}