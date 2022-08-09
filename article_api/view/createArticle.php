<?php

use App\Config\Database;
use App\Models\Article;


function create_article($method, $data)
{
    // on verifie que la methode utilisée est GET
    if ($method == 'POST') {
        // On instancie la base de données
        $database = new Database();
        $db = $database->getConnexion();

        //On instancie les articles
        $article = new Article($db);

        //On récupère les données envoyées

        // on va verifier si on a tous les champs
        if (!empty($data->title)  && !empty($data->description) && isset($data->published)) {
            $article->title = $data->title;
            $article->description = $data->description;
            $article->published = $data->published;

            if ($article->create_article()) {
                // ici la creation a fonctionné
                http_response_code(201);
                echo json_encode(["message" => "L'ajout a été effectué"]);
            } else {
                // ici la creation n'a pas fonctionné
                http_response_code(503);
                echo json_encode(["message" => "L'ajout n'a pas été effectué"]);
            }
        }
    } else {
        http_response_code(405); // le code correspond à (la methode n'est pas autorisée)
        echo json_encode(["message" => "La methode n'est pas autorisée"]);
    }
}
