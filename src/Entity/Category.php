<?php

namespace App\src\Entity;

use App\src\Entity\Database;
use PDO;

class Category extends Database
{
    public $id;
    public $title;
    public $description;

    public function __construct()
    {
        parent::__construct();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setTitle($title)
    {
        $this->title = $title;
        return $this->title;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setDescription($description)
    {
        $this->description = $description;
        return $this->description;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function createCategory()
    {
        $insert = 'INSERT INTO `sjt_category` (`title`, `description`) VALUES (:title, :description);';
        $insertDb = $this->db->prepare($insert);
        $insertDb->bindValue(':title', $this->title, PDO::PARAM_STR);
        $insertDb->bindValue(':description', $this->description, PDO::PARAM_STR);
        return $insertDb->execute();
    }

    /**
     * methode permettant de recuperer la liste des articles
     */
    public function findAll()
    {
        $query = 'SELECT * FROM `sjt_category`';
        $queryResult = $this->db->query($query);
        return $queryResult->fetchAll(PDO::FETCH_OBJ);
    }

    public function find(int $id)
    {
        $requete = 'SELECT * FROM `sjt_category` WHERE `id`=:id ;';
        $find = $this->db->prepare($requete);
        $find->bindValue(':id', $id, PDO::PARAM_INT);
        if ($find->execute()) {
            return $find->fetch(PDO::FETCH_OBJ);
        }
    }

    public function setCategory(int $id)
    {
        $query = 'UPDATE `sjt_category` SET  `title`=:title, `description`=:description  WHERE `id`=:id;';
        $findProfil = $this->db->prepare($query);
        $findProfil->bindValue(':title', $this->title, PDO::PARAM_STR);
        $findProfil->bindValue(':description', $this->description, PDO::PARAM_STR);
        $findProfil->bindValue(':id', $id, PDO::PARAM_INT);
        return $findProfil->execute();
    }

    /**
     * Methode qui permet d'effacer une category
     */
    public function removeCategory(int $id)
    {
        $query = 'DELETE FROM `sjt_category` WHERE `id`=:id;';
        $article = $this->db->prepare($query);
        $article->bindValue(':id', $id, PDO::PARAM_INT);
        return $article->execute();
    }
}
