<?php
require '../classes/Connection.php';
require '../classes/Recipes.php';

$conobject = new Connection();
$connection = $conobject->getConnection();

if ($connection === null) {
    die("Database connection is null.");
} else {
    echo "Connection obtained successfully.<br>";
}

// Create a new instance of the Recipes class with the connection
$recipes = new Recipes($connection);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input data
    $name = htmlspecialchars(trim($_POST['name']));
    $link = htmlspecialchars(trim($_POST['link']));
    $ingredients = htmlspecialchars(trim($_POST['ingredients']));
    $category = htmlspecialchars(trim($_POST['category']));
    $cuisine = htmlspecialchars(trim($_POST['cuisine']));
    $picid = htmlspecialchars(trim($_POST['picid']));

    // Debugging output
    echo "<pre>";
    echo "Name: $name\n";
    echo "Link: $link\n";
    echo "Ingredients: $ingredients\n";
    echo "Category: $category\n";
    echo "Cuisine: $cuisine\n";
    echo "Pic ID: $picid\n";
    echo "</pre>";

    $newid = $recipes->addRecipe($name, $link, $ingredients, $category, $cuisine, $picid);

    // Check if the recipe was added successfully
    if ($newid) {
        header("Location: ../index.php?newid=$newid");
        exit;
    } else {
        echo "Error adding recipe.";
    }
}