<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require '../classes/Connection.php';
require '../classes/Recipes.php';
$conobject = new Connection();

$connection = $conobject->getConnection();
$recipesobject = new Recipes($connection);

// Debugging output
echo '<pre>';
var_dump($_POST);
echo '</pre>';

if (isset($_POST["id"])) {
    $id = trim($_POST["id"]);
    echo "Attempting to delete recipe with ID: $id<br>";
    
    if ($recipesobject->deleteRecipe($id)) {
        echo "Recipe with ID $id has been deleted.";
    } else {
        echo "Failed to delete recipe.";
    }
} else {
    echo "No ID received.";
}

header("location:../index.php");
exit();