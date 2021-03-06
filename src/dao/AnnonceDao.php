<?php

namespace Projet6\Dao;

use Projet6\Model\Annonce;

class AnnonceDao extends BaseDao
{
    /**Creer une nouvelle annonce*/
    public function createAnnonce($title, $content, $typeof, $tel, $email, $city, $author)
    {
        $db = $this->dbConnect();
        $annonces = $db->prepare('INSERT INTO annonces (title, content,typeof , tel ,email,city, author, creation_date) VALUES(?, ?,?,?,?,?,?, NOW())');
        $affectedLines = $annonces->execute(array($title, $content, $typeof, $tel, $email, $city, $author));
        return $affectedLines;
    }

    /**Retourne une annonce suivant son id*/
    public function getAnnonceById($id)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT id,title, content,typeof , tel ,email,city, author , creation_date FROM annonces WHERE id = ' . $id);
        $req->execute();
        $annonceData = $req->fetch();
        return new Annonce($annonceData);
    }

    /**retourne un épisode*/
    public function getannonce($annonceId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT id,title, content,typeof , tel ,email,city,  creation_date FROM annonces WHERE id =' . $annonceId);
        $req->execute();
        $annonceData = $req->fetch();
        return new Annonce($annonceData);
    }

    /**Retourne toutes les annonces*/
    public function getAllAnnonces()
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM annonces ORDER BY creation_date');
        $req->execute();
        $annoncesDB = $req->fetchAll();
        $annonces = [];
        foreach ($annoncesDB as $annonceDB) {
            array_push($annonces, new Annonce($annonceDB));
        }
        return $annonces;
    }

    /**Retourne les annonces type recherche*/
    public function getTypeOfAnnoncesSearch()
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM annonces WHERE typeof = "recherche"');
        $req->execute();
        $annoncesDB = $req->fetchAll();
        $annonces = [];
        foreach ($annoncesDB as $annonceDB) {
            array_push($annonces, new Annonce($annonceDB));
        }
        return $annonces;
    }

    /**Retourne les annonces type */
    public function getTypeOfAnnoncesGive()
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM annonces WHERE typeof = "propose"');
        $req->execute();
        $annoncesDB = $req->fetchAll();
        $annonces = [];
        foreach ($annoncesDB as $annonceDB) {
            array_push($annonces, new Annonce($annonceDB));
        }
        return $annonces;
    }
    /****************************************/
    /**Retourne les annonces signalées */
    public function getSpamAnnonces()
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM annonces WHERE spam  IS NOT NULL');
        $req->execute();
        $annoncesDB = $req->fetchAll();
        $annonces = [];
        foreach ($annoncesDB as $annonceDB) {
            array_push($annonces, new Annonce($annonceDB));
        }
        return $annonces;
    }
    /*************************************************/













    /****************************************/
    /**Retourne les annonces liées à l'email */
    public function getAnnoncesMember()
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT annonces.id,annonces.title,annonces.content,annonces.typeof,annonces.tel,annonces.email,annonces.city,annonces.author,annonces.creation_date,annonces.spam
FROM `annonces`,`member`
WHERE annonces.email = member.email');
        $req->execute();
        $annoncesDB = $req->fetchAll();
        $annonces = [];
        foreach ($annoncesDB as $annonceDB) {
            array_push($annonces, new Annonce($annonceDB));
        }
        return $annonces;
    }
    /*************************************************/





























    /** renvoie la liste des annonces liées a un utilisateur */
    /**A définir*/
    public function getMyAnnonces()
    {
        $db = $this->dbConnect();

    }

    /** permet de mettre à jour une annonce */
    public function updateAnnonce($id, $title, $content, $typeof, $tel, $email, $city)
    {
        $db = $this->dbConnect();
        $annonce = $db->prepare('UPDATE annonces SET title = ?, content = ?,typeof =?, tel = ?, email = ?, city = ? WHERE id = ?');
        $affectedLine = $annonce->execute(array($title, $content, $typeof, $tel, $email, $city));
        return $affectedLine;
    }

    /** Retourne les ville et le nombre d'annonces correspondantes */
    public function getCity()
    {

        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM annonces ORDER BY city ASC ');
        $req->execute();
        $annoncesDB = $req->fetchAll();
        $annonces = [];
        foreach ($annoncesDB as $annonceDB) {
            array_push($annonces, new Annonce($annonceDB));
        }
        return $annonces;


    }
    /** permet de signaler une annonce */
    public function signalAnnonce($id, $spam)
    {
        $db = $this->dbConnect();
        $annonce = $db->prepare('UPDATE annonces SET spam = ? WHERE id = ?');
        $affectedLine = $annonce->execute(array($spam, $id));
        return $affectedLine;
    }


    /** permet de supprimer une annonce */
    public function deleteAnnonce($annonceId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('DELETE FROM annonces WHERE id = ?');
        $req->execute(array($annonceId));
    }


}
