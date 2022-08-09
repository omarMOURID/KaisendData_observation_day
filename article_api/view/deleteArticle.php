<?php

use App\Config\Database;
use App\Models\Article;

function delete_articel($method, $id)
{

    // on verifie que la methode utilisée est GET
    if ($method == 'DELETE') {
        // On instancie la base de données
        $database = new Database();
        $db = $database->getConnexion();

        //On instancie les articles
        $article = new Article($db);

        //On récupère les données envoyées

        $article->id = $id;

        if ($article->delete_article()) {
            // ici la creation a fonctionné
            http_response_code(200);
            echo json_encode(["message" => "La suppression a été effectué"]);
        } else {
            // ici la creation n'a pas fonctionné
            http_response_code(503);
            echo json_encode(["message" => "La suppression n'a pas été effectué"]);
        }
    } else {
        http_response_code(405); // le code correspond à (la methode n'est pas autorisée)
        echo json_encode(["message" => "La methode n'est pas autorisée"]);
    }
}
