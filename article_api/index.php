<?php

include("./config/Database.php");
include("./models/Article.php");

include_once './view/getArticles.php';
include_once './view/getArticleById.php';
include_once './view/deleteArticle.php';
include_once './view/createArticle.php';
include_once './view/editArticle.php';

header("Access-Control-Allow-Origin: *"); // Tous le monde a l'autorisation
header("Content-type: application/json;"); // On renvoie une réponse en JSON
header("Access-Control-Allow-Methods: DELETE, GET, PUT, POST, OPTIONS"); // Les méthodes accepter pour la requete en question (on est obliger d'utiliser une methode GET)

$part = explode("/", $_SERVER["REQUEST_URI"]);

if ($part[1] != "article_api") {
    http_response_code(404);
    exit;
} else {
    $data = json_decode(file_get_contents("php://input"));
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        if ($part[2] == '') {
            get_articles($_SERVER['REQUEST_METHOD']);
        } else {
            get_article_by_id($_SERVER['REQUEST_METHOD'], $part[2]);
        }
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        create_article($_SERVER['REQUEST_METHOD'], $data);
    }
    if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
        edit_article($_SERVER['REQUEST_METHOD'], $part[2], $data);
    }
    if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
        delete_articel($_SERVER['REQUEST_METHOD'], $part[2]);
    }
}
