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

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    
    $recipe = $recipesobject->getRecipeById($id);
    if ($recipe) {
        $name = $recipe['name'];
        $link = $recipe['link'];
        $ingredients = $recipe['ingredients'];
        $category = $recipe['category'];
        $cuisine = $recipe['cuisine'];
        $picid = $recipe['picid'];
    } else {
        die("Recipe not found.");
    }
} else {
    die("No recipe ID provided.");
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
    <h3>Edit recipe:</h3>
    <form class="new-recipe" action="code/editRecipe.php" method="post">
        <input type="hidden" name="id" value="<?php echo $id ?>">
        <p>Recipe Name:</p>
        <input type="text" name="name" placeholder="Recipe name" autocomplete="off" value="<?php echo $name ?>">
        <p>Link to Recipe:</p>
        <textarea name="link" cols="30" rows="1" placeholder="Recipe Link"><?php echo $link ?></textarea><br>
        <p>Main Ingredients:</p>
        <span>Separate ingredients with ",".</span><br>
        <textarea name="ingredients" cols="30" rows="3" placeholder="Ingredients"><?php echo $ingredients ?></textarea><br>
        <p>Food Category:</p>
        <select id="category" name="category">
            <option value="Breakfast" <?php if ($category == "Breakfast") {echo 'selected';} ?>>Breakfast</option>
            <option value="Dessert" <?php if ($category == "Dessert") {echo 'selected';} ?>>Dessert</option>
            <option value="Dinner" <?php if ($category == "Dinner") {echo 'selected';} ?>>Dinner</option>
            <option value="Lunch" <?php if ($category == "Lunch") {echo 'selected';} ?>>Lunch</option>
            <option value="Snack" <?php if ($category == "Snack") {echo 'selected';} ?>>Snack</option>
        </select><br>
        <?php //$category = $_POST['category'] ?>
        <p>Cuisine/Origin:</p>
        <span>French, American, Asian, etc.</span><br>
        <textarea name="cuisine" cols="30" rows="1" placeholder="Cuisine"><?php echo $cuisine ?></textarea><br>
        <p>Link to Picture:</p>
        <span>(optional)</span><br>
        <textarea name="picid" cols="30" rows="1" placeholder="Picture Link"><?php echo $picid ?></textarea><br>
        <button>Update Recipe!</button>
    </form>
</main>
<?php
    include 'recipefooter.html';
?>
