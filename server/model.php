<?php

define("HOST", "localhost"); 
define("DBNAME", "mamedov1");
define("DBLOGIN", "mamedov1");
define("DBPWD", "mamedov1"); 

function getMovieById($id){
    $cnx = new PDO("mysql:host=".HOST.";dbname=".DBNAME.";charset=utf8", DBLOGIN, DBPWD);
    

    $sql = "SELECT Movie.*, Category.name AS category_name 
            FROM Movie 
            LEFT JOIN Category ON Movie.id_category = Category.id 
            WHERE Movie.id = :id";
            
    $stmt = $cnx->prepare($sql);
    $stmt->execute([':id' => $id]);
    
    return $stmt->fetch(PDO::FETCH_OBJ); 
}

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

function addMovie($name, $director, $year, $length, $description, $image, $trailer, $min_age, $id_category){
    $cnx = new PDO("mysql:host=".HOST.";dbname=".DBNAME.";charset=utf8", DBLOGIN, DBPWD);
    
    $sql = "INSERT INTO Movie (name, director, year, length, description, image, trailer, min_age, id_category) 
            VALUES (:name, :director, :year, :length, :description, :image, :trailer, :min_age, :id_category)";
    
    $stmt = $cnx->prepare($sql);
    
    $res = $stmt->execute([
        ':name' => $name,
        ':director' => $director,
        ':year' => $year,
        ':length' => $length,
        ':description' => $description,
        ':image' => $image,
        ':trailer' => $trailer,
        ':min_age' => $min_age,
        ':id_category' => $id_category
    ]);
    
    return $res; 
}

function addProfile($name, $avatar, $age_restriction){
    try {
        $cnx = new PDO("mysql:host=".HOST.";dbname=".DBNAME.";charset=utf8", DBLOGIN, DBPWD);
        
        $sql = "INSERT INTO Profile (name, avatar, age_restriction) VALUES (:name, :avatar, :age)";
        
        $stmt = $cnx->prepare($sql);
        $res = $stmt->execute([
            ':name' => $name,
            ':avatar' => $avatar,
            ':age' => (int)$age_restriction 
        ]);
        
        return $res;
    } catch (PDOException $e) {
        return false;
    }
}

function getProfiles() {
    try {
        $cnx = new PDO("mysql:host=".HOST.";dbname=".DBNAME.";charset=utf8", DBLOGIN, DBPWD);
        $sql = "SELECT * FROM Profile"; // Проверь название таблицы!
        $stmt = $cnx->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
       
        error_log($e->getMessage());
        return false;
    }
}

function getAllCategories() {
    try {
        $cnx = new PDO("mysql:host=".HOST.";dbname=".DBNAME.";charset=utf8", DBLOGIN, DBPWD);
        $sql = "SELECT * FROM Category ORDER BY name ASC";
        $stmt = $cnx->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log($e->getMessage());
        return false;
    }
}

function getAllMoviesWithCategory(){
    $cnx = new PDO("mysql:host=".HOST.";dbname=".DBNAME.";charset=utf8", DBLOGIN, DBPWD);
    $sql = "SELECT m.*, c.name AS category_name 
            FROM Movie m 
            LEFT JOIN Category c ON m.id_category = c.id 
            ORDER BY c.name, m.name";
    $stmt = $cnx->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}

function getAllMoviesWithCategoryFiltered($ageLimit) {
    try {
        $cnx = new PDO("mysql:host=".HOST.";dbname=".DBNAME.";charset=utf8", DBLOGIN, DBPWD);
       
        $sql = "SELECT m.*, c.name AS category_name 
                FROM Movie m 
                LEFT JOIN Category c ON m.id_category = c.id 
                WHERE m.min_age <= :age
                ORDER BY c.name, m.name";
                
        $stmt = $cnx->prepare($sql);
        $stmt->execute([':age' => (int)$ageLimit]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    } catch (PDOException $e) {
        return false;
    }
}

?>