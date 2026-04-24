<?php

define("HOST", "localhost"); 
define("DBNAME", "mamedov1");
define("DBLOGIN", "mamedov1");
define("DBPWD", "mamedov1"); 

function getAllMovies(){
    try {

        $cnx = new PDO("mysql:host=".HOST.";dbname=".DBNAME.";charset=utf8", DBLOGIN, DBPWD);
        
        $sql = "SELECT * FROM Movie";
        
        $stmt = $cnx->prepare($sql);
        $stmt->execute();
        
        $res = $stmt->fetchAll(PDO::FETCH_OBJ);
        
        return $res; 

    } catch (PDOException $e) {

        return false;
    }
}

function addMovie($p){
    $cnx = new PDO("mysql:host=".HOST.";dbname=".DBNAME.";charset=utf8", DBLOGIN, DBPWD);
    
    // Просто перечисляем поля и значения через двоеточие
    $sql = "INSERT INTO Movie (name, director, year, description, image, trailer, min_age, id_category) 
            VALUES (:name, :director, :year, :description, :image, :trailer, :min_age, :id_category)";
    
    $stmt = $cnx->prepare($sql);
    $res = $stmt->execute([
        ':name' => $p['name'],
        ':director' => $p['director'],
        ':year' => $p['year'],
        ':length'      => $p['length'],
        ':description' => $p['description'],
        ':image' => $p['image'],
        ':trailer' => $p['trailer'],
        ':min_age' => $p['min_age'],
        ':id_category' => $p['id_category']
    ]);
    
    return $res; // вернет true или false
}

?>