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
$search = "";
?>
<!DOCTYPE html>
<style>
    <?php include 'recipemain.css'; ?>
</style>
<?php
    include 'recipeheader.html';
?>
<main>
    <div class="indexintro">
        <h2>Welcome to Find Recipe!</h2>
        <p>
            This is a database of links to recipes, to help you find what you a craving. <br>
            Browse the categories, search through the recipes, or try searching for the ingredient you have!
        </p>
    </div>
    <div class="searchbar">
        <form method="post">
            <input type="text" name="search" placeholder="Search recipes">
            <button>
                Search!
            </button>
        </form>
    </div>
    <section>
        <?php 
        if (isset($_POST['search'])) :
            $search = $_POST['search'];
            $searchresults = $recipesobject->searchRecipes($search);
            if (empty($searchresults)) {
                ?>
                <div class="noSearchResult">
                    <p>No recipes found matching your search for "<strong><?php echo $search; ?></strong>". <br>
                       You could try another search or try browsing the categories.</p>
                </div>
            <?php
            } else {?>
                <h3>Search Results:</h3>
                <?php
                foreach ($searchresults as $result):
                ?>
                    <div class="searchresult">
                        <div class="recipe">
                            <div class="container">
                                <div class="grid-item">
                                    <img src="<?php echo $result['picid'] ?>" alt="<?php echo $result['name'] ?>">
                                </div>
                                <div class="grid-item">
                                    <div class="recipeName">
                                        <h4><a href="<?php echo $result['link'] ?>"><?php echo $result['name'] ?></a></h4>
                                    </div>
                                    <p>
                                    <i><?php echo $result['category'] ?>, <?php echo $result['cuisine'] ?></i>
                                    </p>
                                    <p>
                                    Main ingredients: <?php echo $result['ingredients'] ?>
                                    </p>
                                    <br>
                                    <br>
                                    <form action="editingRecipe.php" method="POST" style="display:inline;">
                                        <input type="hidden" name="id" value="<?php echo $result['id']; ?>">
                                        <button type="submit" onclick="return confirm('Edit this recipe?')">Edit</button>
                                    </form>
                                    <form action="code/deleteRecipe.php" method="POST" style="display:inline;">
                                        <input type="hidden" name="id" value="<?php echo $result['id']; ?>">
                                        <button type="submit" onclick="return confirm('Are you sure you wish to delete this recipe?')">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; 
            }
        endif;?>
    </section>
    <section>
        <?php
        if (isset($_POST['search']) == null) :
            try {
                $randomRecipe = $recipesobject->getRandomRecipe();

                if ($randomRecipe) {
                    $id = $randomRecipe['id'];
                    $name = $randomRecipe['name'];
                    $link = $randomRecipe['link'];
                    $ingredients = $randomRecipe['ingredients'];
                    $category = $randomRecipe['category'];
                    $cuisine = $randomRecipe['cuisine'];
                    $picid = $randomRecipe['picid'];
                } else {
                    echo "No recipes found.";
                }
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
            ?>
            <h3>Have you tried:</h3>
            <div class="recipe">
                <div class="container">
                    <div class="grid-item">
                        <img src="<?php echo $picid ?>" alt="<?php echo $name ?>">
                    </div>
                    <div class="grid-item">
                        <div class="recipeName">
                            <h4><a href="<?php echo $link ?>"><?php echo $name ?></a></h4>
                        </div>
                        <p>
                        <i><?php echo $category ?>, <?php echo $cuisine ?></i>
                        </p>
                        <p>
                        Main ingredients: <?php echo $ingredients ?>
                        </p>
                        <br>
                        <br>
                        <form action="editingRecipe.php" method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <button type="submit" onclick="return confirm('Edit this recipe?')">Edit</button>
                        </form>
                        <form action="code/deleteRecipe.php" method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <button type="submit" onclick="return confirm('Are you sure you wish to delete this recipe?')">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </section>
</main>
<?php
    include 'recipefooter.html';
?>