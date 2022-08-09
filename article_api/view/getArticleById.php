<?php
use App\Config\Database;
use App\Models\Article;


function get_article_by_id($method, $id){

// on verifie que la methode utilisée est GET
    if($method == 'GET') {
        // On instancie la base de données
        $database = new Database();
        $db = $database->getConnexion();

        //On instancie les articles
        $article = new Article($db);
        $article->id = $id;

        if ($statement = $article->get_article_by_id()->fetch(PDO::FETCH_ASSOC)) {
            extract($statement);
            $artc = [
                'id' => $id,
                'title' => $title,
                'description' => $description,
                'published' => $published,
            ];
            // ici la creation a fonctionné
            http_response_code(200);
            echo json_encode($artc, JSON_UNESCAPED_UNICODE);
        } else {
            // ici la creation n'a pas fonctionné
            http_response_code(404);
            echo json_encode(["message" => "L'article introuvable"]);
        }
    } else {
        http_response_code(405);// le code correspond à (la methode n'est pas autorisée)
        echo json_encode(["message" => "La methode n'est pas autorisée"]);
    }
}

