<?php
require 'classes/Connection.php';
require 'classes/Recipes.php';

$conobject = new Connection();
$connection = $conobject->getConnection();

if ($connection === null) {
    die("Database connection is null.");
}

// Get the category name from the URL
$categoryName = filter_input(INPUT_GET, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

$recipes = new Recipes($connection);

if ($categoryName) {
    $recipeList = $recipes->getRecipesByCategory($categoryName); // Assuming this method fetches recipes by category

    //echo "<h3>Recipes in the '$categoryName' Category</h3>";
    if ($recipeList) {
        foreach ($recipeList as $recipe) {
            //echo "<h4>" . htmlspecialchars($recipe['name']) . "</h4>";
            //echo "<p>" . htmlspecialchars($recipe['ingredients']) . "</p>";
            // Add more recipe details as needed
        }
    } else {
        echo "<p>No recipes found in this category.</p>";
    }
} else {
    echo "<p>No category specified.</p>";
}
?>
<!DOCTYPE html>
<style>
    <?php include 'recipemain.css'; ?>
</style>
<?php
include 'recipeheader.html';
?>

<main>
    <section>
    <h3>Recipes in the <?php echo $categoryName ?> Category</h3>
    <?php foreach ($recipeList as $recipe):?>
    <div class="recipe">
        <div class="container">
            <div class="grid-item">
                <img src="<?php echo $recipe['picid'] ?>" alt="<?php echo $recipe['name'] ?>">
            </div>
            <div class="grid-item">
                <div class="recipeName">
                    <h4><a href="<?php echo $recipe['link'] ?>"><?php echo $recipe['name'] ?></a></h4>
                </div>
                <p>
                <i><?php echo $recipe['category'] ?>, <?php echo $recipe['cuisine'] ?></i>
                </p>
                <p>
                Main ingredients: <?php echo $recipe['ingredients'] ?>
                </p>
                <br>
                <br>
                <form action="editingRecipe.php" method="POST" style="display:inline;">
                    <input type="hidden" name="id" value="<?php echo $recipe['id']; ?>">
                    <button type="submit" onclick="return confirm('Edit this recipe?')">Edit</button>
                </form>
                <form action="code/deleteRecipe.php" method="POST" style="display:inline;">
                    <input type="hidden" name="id" value="<?php echo $recipe['id']; ?>">
                    <button type="submit" onclick="return confirm('Are you sure you wish to delete this recipe?')">Delete</button>
                </form>
            </div>
        </div>
    </div>
    <?php
    endforeach;
    ?>
    </section>
</main>
<?php
    include 'recipefooter.html';
?>