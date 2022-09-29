<?php

class Model
{


    /**
     * Attribut contenant l'instance PDO
     */
    private $bd;


    /**
     * Attribut statique qui contiendra l'unique instance de Model
     */
    private static $instance = null;


    /**
     * Constructeur : effectue la connexion à la base de données.
     */
    private function __construct()
    {

        try {
            include 'Utils/credentials.php';
            $this->bd = new PDO($dsn, $login, $mdp);
            $this->bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->bd->query("SET nameS 'utf8'");
        } catch (PDOException $e) {
            die('Echec connexion, erreur n°' . $e->getCode() . ':' . $e->getMessage());
        }
    }


    public static function getModel()
    {

        if (is_null(self::$instance)) {
            self::$instance = new Model();
        }
        return self::$instance;
    }

    public function IDlastinsert($infos)
    {
        try {
            $requete = $this->bd->prepare('SELECT FileID FROM fichiers_upload WHERE Name=:name AND Size=:size AND Filename=:filename');
            $marqueurs = ['name','size', 'filename'];
            foreach ($marqueurs as $value) {
                $requete->bindValue(':' . $value, $infos[$value]);
            }
            $requete->execute();
            return $requete->fetchall(PDO::FETCH_COLUMN);
        } catch (PDOException $e) {
            die('Echec IDlastinsert, erreur n°' . $e->getCode() . ':' . $e->getMessage());
        }
    }

    public function addDoc($infos)
    {

        try {
            $requete = $this->bd->prepare('INSERT INTO fichiers_upload (Name,Description,Filename,Type,Size) VALUES (:name,:description,:filename,:type,:size);  SELECT LAST_INSERT_ID();');
            $marqueurs = ['name', 'description', 'filename','type', 'size'];
            foreach ($marqueurs as $value) {
                $requete->bindValue(':' . $value, $infos[$value]);
            }
            $requete->execute();
            $requete->closeCursor();
            return $this->IDlastinsert(["name"=>$infos["name"],"size"=>$infos["size"],"filename"=>$infos["filename"]])[0];
        } catch (PDOException $e) {
            die('Echec addDoc, erreur n°' . $e->getCode() . ':' . $e->getMessage());
        }
    }

    public function addMot($infos)
    {
        try {
            $requete = $this->bd->prepare('INSERT INTO indexation (Word, Occurence, FileID) VALUES (:word, :occurence, :fileID);');
            $marqueurs = ['word', 'occurence', 'fileID'];
            foreach ($marqueurs as $value) {
                $requete->bindValue(':' . $value, $infos[$value]);
            }
            return $requete->execute();
        } catch (PDOException $e) {
            die('Echec addMot, erreur n°' . $e->getCode() . ':' . $e->getMessage());
        }
    }




}
