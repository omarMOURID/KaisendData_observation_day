<?php
use App\Config\Database;
use App\Models\Article;


function get_articles($method) {
    header("Access-Control-Allow-Origin: *"); // Tous le monde a l'autorisation
    header("Content-type: application/json; charset=UTF-8"); // On renvoie une réponse en JSON
    header("Access-Control-Allow-Methods: GET"); // Les méthodes accepter pour la requete en question (on est obliger d'utiliser une methode GET)

// on verifie que la methode utilisée est GET
    if($method == 'GET') {
        // On instancie la base de données
        $database = new Database();
        $db = $database->getConnexion();

        //On instancie les articles
        $article = new Article($db);

        //On récupère les données
        $statement = $article->get_articles();

        //On verifie si on a au moins 1 article sinon on renvoie rien
        if($statement->rowCount() > 0) {
            // On initialise un tableau associatif
            $tableauArticles = [];
            $tableauArticles['articles'] = [];
            // fetch est plus rapide que fetchAll!!!
            while($row = $statement->fetch(PDO::FETCH_ASSOC)) { // FETCH_ASSOC pour avoir un tableau associatif
                extract($row);
                // avec la fonction extract on a l'access direct vers les colonnes de la table article
                $artc = [
                    'id' => $id,
                    'title' => $title,
                    'description' => $description,
                    'published' => $published,
                ];

                $tableauArticles['articles'][] = $artc;
            }
            // On envoie le code 200 ok
            http_response_code(200);

            // on encode en json et on envoie
            echo json_encode($tableauArticles, JSON_UNESCAPED_UNICODE); // pour ne pas trouver des problèmes avec les caractères accentués
        }
    } else {
        http_response_code(405);// le code correspond à (la methode n'est pas autorisée)
        echo json_encode(["message" => "La methode n'est pas autorisée"]);
    }
}

