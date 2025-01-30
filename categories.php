<?php
require 'classes/Connection.php';
require 'classes/Recipes.php';

$conobject = new Connection();
$connection = $conobject->getConnection();

if ($connection === null) {
    die("Database connection is null.");
} else {
    //echo "Connection obtained successfully.<br>";
}
// Create a new instance of the Recipes class with the connection
$recipesobject = new Recipes($connection);

//////
// Optionally, call a method to verify it works
try {
    $categories = $recipesobject->getCategories();
    
    if ($categories->num_rows > 0) {
        while ($row = $categories->fetch_assoc()) {
            $categoriesArray[] = $row['category'];
        }
        
    } else {
        echo "No categories found.";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
//////
try {
    $cuisines = $recipesobject->getCuisines();
    
    if ($cuisines->num_rows > 0) {
        $cuisinesArray = [];
        
        while ($row = $cuisines->fetch_assoc()) {
            $cuisinesArray[] = $row['cuisine'];
        }
        
    } else {
        echo "No cuisines found.";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
//////

?>
<!DOCTYPE html>
<style>
    <?php include 'recipemain.css'; ?>
</style>
<?php
include 'recipeheader.html';
?>

<main>
    <h3>Recipes by Categories:</h3>
    <div class="recipe-categories">
        <a href="allRecipes.php"><p>All Recipes</p></a>
        <?php
            foreach ($categoriesArray as $category):
                ?>
            <a href="category.php?name=<?php echo urlencode($category); ?>"><p><?php echo $category ?></p></a>
        <?php endforeach; ?>
        <br>
        <h4>Cuisines:</h4>
        <?php
        foreach ($cuisinesArray as $cuisine):
            ?>
            <a href="cuisine.php?name=<?php echo urlencode($cuisine); ?>"><p><?php echo $cuisine ?></p></a>
        <?php endforeach; ?>
    </div>
</main>
<?php
    include 'recipefooter.html';
?>
