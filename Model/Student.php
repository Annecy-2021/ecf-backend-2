<?php
require_once 'Connect.php';

class Student extends Connect
{
    public function countAll(string $nom, string $prenom)
    {
        $req = $this->pdo->prepare('SELECT COUNT(id_etudiant) `count` FROM etudiants WHERE nom LIKE :nom AND prenom LIKE :prenom');
        $req->bindValue('nom', $nom . '%');
        $req->bindValue('prenom', $prenom . '%');
        $req->execute();
        return $req->fetch();
    }

    public function getAll(string $nom, string $prenom, int $page)
    {
        $offset = ($page - 1) * 6;
        $req = $this->pdo->prepare('
            SELECT e.id_etudiant, prenom, nom, AVG(note) moyenne
            FROM etudiants e 
            INNER JOIN examens x
            ON x.id_etudiant = e.id_etudiant
            WHERE nom LIKE :nom AND prenom LIKE :prenom
            GROUP BY x.id_etudiant
            LIMIT 6
            OFFSET :offset
        ');
        $req->bindValue('nom', $nom . '%');
        $req->bindValue('prenom', $prenom . '%');
        $req->bindParam('offset', $offset, PDO::PARAM_INT);
        $req->execute();
        return $req->fetchAll();
    }

    public function getOne(int $id)
    {
        $req = $this->pdo->prepare('SELECT e.id_etudiant, prenom, nom, AVG(note) moyenne FROM etudiants e INNER JOIN examens x ON x.id_etudiant = e.id_etudiant WHERE e.id_etudiant = :id GROUP BY x.id_etudiant');
        $req->bindParam('id', $id, PDO::PARAM_INT);
        $req->execute();
        return $req->fetch();
    }

    public function getNotes(int $id)
    {
        $req = $this->pdo->prepare('SELECT x.id, id_examen, matiere, note FROM etudiants e INNER JOIN examens x ON x.id_etudiant = e.id_etudiant WHERE e.id_etudiant = :id');
        $req->bindParam('id', $id, PDO::PARAM_INT);
        $req->execute();
        return $req->fetchAll();
    }

    public function getMoyennes(int $id)
    {
        $req = $this->pdo->prepare('
            SELECT matiere, AVG(note) moyenne, (SELECT AVG(note) FROM examens e WHERE e.matiere = x.matiere) moyenne_g
            FROM examens x
            WHERE x.id_etudiant = :id
            GROUP BY matiere
        ');
        $req->bindParam('id', $id, PDO::PARAM_INT);
        $req->execute();
        return $req->fetchAll();
    }

    public function update(int $id, string $nom, string $prenom): bool
    {
        $req = $this->pdo->prepare('UPDATE etudiants SET prenom = :prenom, nom = :nom WHERE id_etudiant = :id');
        $req->bindParam('prenom', $prenom);
        $req->bindParam('nom', $nom);
        $req->bindParam('id', $id, PDO::PARAM_INT);
        return $req->execute();
    }

    public function delete(int $id)
    {
        $req = $this->pdo->prepare('DELETE e, x FROM etudiants e INNER JOIN examens x ON x.id_etudiant = e.id_etudiant WHERE e.id_etudiant = :id');
        $req->bindParam('id', $id, PDO::PARAM_INT);
        return $req->execute();
    }
}
