<?php

namespace App\src\Entity;

use App\src\Entity\Database;
use PDO;

class User extends Database
{
    //Attribut
    public $id;
    public $email;
    public $createdAt;
    public $role;
    public $pass;
    public $token;

    /**
     * Method construct qui ce connecte a ma base de données
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Method qui retourne un TOKEN 
     * @return HASH
     */
    public function generateCSRFToken()
    {
        $length = 10;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ%=';
        $character = strlen($characters);
        $token = '';
        for ($i = 0; $i < $length; $i++) {
            $token .= $characters[mt_rand(0, $character - 1)];
        }
        return $token;
    }

    /**
     * Method qui sert a inserer un nouveau user
     * @return requete INSERT
     */
    public function addUser()
    {
        $insert = 'INSERT INTO `ajax_user` (`email`, `pass`, `token`) VALUES (:email, :pass, :token);';
        $insertDb = $this->db->prepare($insert);
        $insertDb->bindValue(':email', $this->email, PDO::PARAM_STR);
        $insertDb->bindValue(':pass', $this->pass, PDO::PARAM_STR);
        $insertDb->bindValue(':token', $this->token, PDO::PARAM_STR);
        return $insertDb->execute();
    }

    public function getUserList()
    {
        $query = 'SELECT * FROM `ajax_user`';
        $requete = $this->db->query($query);
        return $requete->fetchAll();
    }

    /**
     * Method qui permet de recuperer les infos d'un user via son mail
     */
    public function getUserMail()
    {
        $query = 'SELECT * FROM `ajax_user` WHERE `email`=:email;';
        $fetchProfil = $this->db->prepare($query);
        $fetchProfil->bindValue(':email', $this->email, PDO::PARAM_STR);
        $fetchProfil->execute();
        return $fetchProfil->fetch(PDO::FETCH_OBJ);
    }

    /**
     * method qui permet de modifier un token(jeton) de connexion
     */
    public function setTokenUser()
    {
        $query = 'UPDATE `ajax_user` SET `token`=:token WHERE `id`=:id;';
        $findProfil = $this->db->prepare($query);
        $findProfil->bindValue(':id', $this->id, PDO::PARAM_INT);
        $findProfil->bindValue(':token', $this->token, PDO::PARAM_STR);
        return $findProfil->execute();
    }

    /**
     * method qui permet de recuperer un token(jeton) de connexion
     */
    public function getTokenUser()
    {
        $req = 'SELECT `token` FROM `ajax_user` WHERE id=:id ';
        $prep = $this->db->prepare($req);
        $prep->bindValue(':id', $this->id, PDO::PARAM_INT);
        $prep->execute();
        $tokenId = $prep->fetch(PDO::FETCH_OBJ);
        return $tokenId->tokenUser;
    }

    /**
     * Method qui renvoi true si il y a des occurences d'email dans la table users
     */
    public function checkFreeMail()
    {
        $email = 'SELECT `email` FROM `ajax_user` WHERE `email`= :email;';
        $reqmail = $this->db->prepare($email);
        $reqmail->bindValue(':email', $this->email, PDO::PARAM_STR);
        $reqmail->execute();
        return $reqmail->rowCount();
    }
}
