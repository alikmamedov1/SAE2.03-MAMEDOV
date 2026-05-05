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

function saveProfile($id, $name, $avatar, $age_restriction) {
    try {
        $cnx = new PDO("mysql:host=".HOST.";dbname=".DBNAME.";charset=utf8", DBLOGIN, DBPWD);
        $cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if ($id > 0) {
            $sql = "UPDATE Profile SET name = :name, avatar = :avatar, age_restriction = :age WHERE id = :id";
            $stmt = $cnx->prepare($sql);
            $res = $stmt->execute([
                ':id' => $id,
                ':name' => $name,
                ':avatar' => $avatar,
                ':age' => (int)$age_restriction
            ]);
        } else {
            $sql = "INSERT INTO Profile (name, avatar, age_restriction) VALUES (:name, :avatar, :age)";
            $stmt = $cnx->prepare($sql);
            $res = $stmt->execute([
                ':name' => $name,
                ':avatar' => $avatar,
                ':age' => (int)$age_restriction
            ]);
        }
        return $res;
    } catch (PDOException $e) {
        error_log("DB Error: " . $e->getMessage());
        return false;
    }
}

function getProfiles() {
    try {
        $cnx = new PDO("mysql:host=".HOST.";dbname=".DBNAME.";charset=utf8", DBLOGIN, DBPWD);
        $sql = "SELECT * FROM Profile"; 
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

function addFavorite($id_profile, $id_movie) {
    try {
        $cnx = new PDO("mysql:host=".HOST.";dbname=".DBNAME.";charset=utf8", DBLOGIN, DBPWD);
        $sql = "INSERT IGNORE INTO Favorite (id_profile, id_movie) VALUES (:id_p, :id_m)";
        $stmt = $cnx->prepare($sql);
        return $stmt->execute([':id_p' => $id_profile, ':id_m' => $id_movie]);
    } catch (PDOException $e) {
        return false;
    }
}

function getFavorites($id_profile) {
    try {
        $cnx = new PDO("mysql:host=".HOST.";dbname=".DBNAME.";charset=utf8", DBLOGIN, DBPWD);
        $sql = "SELECT m.* FROM Movie m 
                INNER JOIN Favorite f ON m.id = f.id_movie 
                WHERE f.id_profile = :id_p";
        $stmt = $cnx->prepare($sql);
        $stmt->execute([':id_p' => $id_profile]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return [];
    }
}

function removeFavorite($id_profile, $id_movie) {
    try {
        $cnx = new PDO("mysql:host=".HOST.";dbname=".DBNAME.";charset=utf8", DBLOGIN, DBPWD);
        
  
        $sql = "DELETE FROM Favorite WHERE id_profile = :id_p AND id_movie = :id_m";
        
        $stmt = $cnx->prepare($sql);
        $res = $stmt->execute([
            ':id_p' => $id_profile, 
            ':id_m' => $id_movie
        ]);
        
        return $res;
    } catch (PDOException $e) {
        error_log("Erreur lors de la suppression des favoris: " . $e->getMessage());
        return false;
    }
}

function getFeaturedMovies() {
    try {
        $cnx = new PDO("mysql:host=".HOST.";dbname=".DBNAME.";charset=utf8", DBLOGIN, DBPWD);
        
        $sql = "SELECT m.*, c.name AS category_name 
                FROM Movie m 
                LEFT JOIN Category c ON m.id_category = c.id 
                WHERE m.featured = 1";
        
        $stmt = $cnx->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    } catch (PDOException $e) {
        error_log("Aucun film mis en avant pour le moment." . $e->getMessage());
        return [];
    }
}

function searchMovies($query) {
    try {
        $pdo = new PDO("mysql:host=".HOST.";dbname=".DBNAME.";charset=utf8", DBLOGIN, DBPWD);
        
        $sql = "SELECT m.*, c.name AS category_name 
                FROM Movie m 
                LEFT JOIN Category c ON m.id_category = c.id 
                WHERE m.name LIKE :q";
        
        $stmt = $pdo->prepare($sql);
        $search = "%" . $query . "%";
        $stmt->execute([':q' => $search]);
        
        return $stmt->fetchAll(PDO::FETCH_OBJ); 
    } catch (PDOException $e) {
        error_log("Search Error: " . $e->getMessage());
        return [];
    }
}

?>