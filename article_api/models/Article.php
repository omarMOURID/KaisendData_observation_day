<?php
namespace App\Models;

class Article
{
    // Connexion
    private $connexion;
    private $table = "article";

    // Object properties
    public $id;
    public $title;
    public $description;
    public $published;

    /**
     * Constructeur avec $db pour la connexion à la base de données
     *
     * @param $db
     */
    public function __construct($db)
    {
        $this->connexion = $db;
    }

    /**
     * Lecture des Articles
     *
     * @return mixed
     */
    public function get_articles()
    {
        $sql = "SELECT * FROM ".$this->table;
        $query = $this->connexion->prepare($sql);
        $query->execute();

        return $query;
    }

    public function get_article_by_id()
    {
        $sql = "SELECT * FROM ".$this->table." WHERE id = :id";
        $query = $this->connexion->prepare($sql);
        $query->execute([
            'id' => $this->id,
        ]);

        return $query;
    }

    public function create_article()
    {
        $sql = "INSERT INTO ".$this->table." (title, description, published) VALUES (:tl, :des, :pb)";

        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->description = htmlspecialchars((strip_tags($this->description)));
        $this->published = htmlspecialchars((strip_tags($this->published)));

        $query = $this->connexion->prepare($sql);
        $executed = $query->execute([
            'tl' => $this->title,
            'des' => $this->description,
            'pb' => $this->published,
        ]);

        if ($executed) {
            return true;
        } else {
            return false;
        }
    }

    public function edit_article()
    {
        $sql = "UPDATE ".$this->table." SET title = :tl, description = :des, published = :pb WHERE id = :id";

        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->description = htmlspecialchars((strip_tags($this->description)));
        $this->published = htmlspecialchars((strip_tags($this->published)));

        $query = $this->connexion->prepare($sql);
        $executed = $query->execute([
            'tl' => $this->title,
            'des' => $this->description,
            'pb' => $this->published,
            'id' => $this->id,
        ]);

        if ($executed) {
            return true;
        } else {
            return false;
        }
    }

    public function delete_article()
    {
        $sql = "DELETE FROM ".$this->table." WHERE id = :id";
        $query = $this->connexion->prepare($sql);
        $executed = $query->execute([
            'id' => $this->id,
        ]);

        if ($executed) {
            return true;
        }
        return false;
    }
}
