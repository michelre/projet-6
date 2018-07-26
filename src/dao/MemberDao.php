<?php

namespace Projet6\Dao;
require_once 'BaseDao';

class MemberDao extends BaseDao
{
    /** Permet de creer un nouveau membre*/
    public function createMember($pseudo, $pass, $email)
    {
        $db = $this->dbConnect();
        $member = $db->prepare('INSERT INTO member(pseudo, pass, email, date_inscription ) VALUES(?, ?, ?, NOW())');
        $affectedLines = $member->execute(array($pseudo, $pass, $email));
        return $affectedLines;
    }

    /** Permet de recuperer un utilisateur pour la connexion*/
    public function getUser($mailconnect, $mdpconnect)
    {
        $db = $this->dbConnect();
        $requser = $db->prepare('SELECT * FROM member WHERE email = ' . $this->Q($mailconnect) . ' AND pass = ' . $this->Q($mdpconnect));
        $requser->execute();
        return $requser->fetch();
    }
}
