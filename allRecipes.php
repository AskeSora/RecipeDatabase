<?php
require 'classes/Connection.php';
require 'classes/Recipes.php';

$conobject = new Connection();
$connection = $conobject->getConnection();

if ($connection === null) {
    die("Database connection is null.");
}
$recipes = new Recipes($connection);
$recipeList = $recipes->getAllRecipes();

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
    <h3>All Recipes:</h3>
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