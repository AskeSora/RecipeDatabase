<?php
require '../classes/Connection.php';
require '../classes/Recipes.php';

$conobject = new Connection();
$connection = $conobject->getConnection();

if ($connection === null) {
    die("Database connection is null.");
}

$recipesobject = new Recipes($connection);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (int)$_POST['id'];
    $name = htmlspecialchars(trim($_POST['name']));
    $link = htmlspecialchars(trim($_POST['link']));
    $ingredients = htmlspecialchars(trim($_POST['ingredients']));
    $category = htmlspecialchars(trim($_POST['category']));
    $cuisine = htmlspecialchars(trim($_POST['cuisine']));
    $picid = htmlspecialchars(trim($_POST['picid']));
    
    if ($recipesobject->editRecipe($id, $name, $link, $ingredients, $category, $cuisine, $picid)) {
        header("Location:../index.php?message=Recipe updated successfully");
        exit();
    } else {
        echo "Error updating recipe.";
    }
} else {
    header("Location: ../index.php?error=Invalid request");
    exit();
}
