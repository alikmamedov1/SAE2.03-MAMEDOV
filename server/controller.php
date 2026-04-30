<?php

/** ARCHITECTURE PHP SERVEUR  : Rôle du fichier controller.php
 * 
 *  Dans ce fichier, on va définir les fonctions de contrôle qui vont traiter les requêtes HTTP.
 *  Les requêtes HTTP sont interprétées selon la valeur du paramètre 'todo' de la requête (voir script.php)
 *  Pour chaque valeur différente, on déclarera une fonction de contrôle différente.
 * 
 *  Les fonctions de contrôle vont éventuellement lire les paramètres additionnels de la requête, 
 *  les vérifier, puis appeler les fonctions du modèle (model.php) pour effectuer les opérations
 *  nécessaires sur la base de données.
 *  
 *  Si la fonction échoue à traiter la requête, elle retourne false (mauvais paramètres, erreur de connexion à la BDD, etc.)
 *  Sinon elle retourne le résultat de l'opération (des données ou un message) à includre dans la réponse HTTP.
 */

/** Inclusion du fichier model.php
 *  Pour pouvoir utiliser les fonctions qui y sont déclarées et qui permettent
 *  de faire des opérations sur les données stockées en base de données.
 */
require("model.php");

function readCategoriesController() {
    $res = getAllCategories();
    return $res;
}

function readMovieDetailController($id){
    $movie = getMovieById($id);
    return $movie;
}

function readMoviesController(){
    $movies = getAllMovies();
    return $movies;
}

function readMoviesGroupedController(){
    $movies = getAllMoviesWithCategory();
    $grouped = [];

    if ($movies) {
        foreach ($movies as $m) {
            $catName = $m->category_name ?: "Autre"; 
            
            if (!isset($grouped[$catName])) {
                $grouped[$catName] = [];
            }
            $grouped[$catName][] = $m;
        }
        return $grouped;
    }
    return false;
}

function addMovieController(){
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    if ($data) {
        $name = $data['name'];
        $director = $data['director'];
        $year = $data['year'];
        $length = $data['length'];
        $description = $data['description'];
        $image = $data['image'];
        $trailer = $data['trailer'];
        $min_age = $data['min_age'];
        $id_category = $data['id_category'];
        
        $res = addMovie($name, $director, $year, $length, $description, $image, $trailer, $min_age, $id_category);
        return $res ? ["message" => "Succès"] : ["message" => "Erreur SQL"];
    }
    
    return ["message" => "Données JSON invalides"];
}

function addProfileController(){
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    if ($data) {
        $name = $data['name'];
        $avatar = $data['avatar'];
        $age = $data['age_restriction']; 

        $res = addProfile($name, $avatar, $age);
        
        if ($res) {
            return ["message" => "Le profil a été ajouté avec succès."];
        } else {
            return ["message" => "Erreur SQL lors de l'ajout du profil"];
        }
    }
    return ["message" => "Données JSON invalides"];
} 

function getProfilesController() {
    $res = getProfiles(); 
    return $res; 
}
