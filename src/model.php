<?php
function getArticles() {
    $bdd = new PDO('mysql:host=localhost;dbname=livre;charset=utf8', 'livre_user', 'secret');
    $articles = $bdd->query('select * from t_article order by art_id desc');
    return $articles;
}