<?php

class Recipes {
    private $connection;
    
    public function __construct($connection) {
        $this->connection = $connection;
        //echo "database connection assigned.<br>";
    }
    public function getAllRecipes() {
        $sql = "SELECT * FROM recipes ORDER BY name";
        $result = $this->connection->query($sql);
        
        if (!$result) {
            // Handle query error
            throw new Exception("Database query failed: " . $this->connection->error);
        }
        
        $allrecipes = [];
        
        while ($row = $result->fetch_assoc()) {
            $allrecipes[$row['id']] = $row;
        }
        return $allrecipes;
    }
    
    public function getRecipesByCategory($category) {
        $sql = "SELECT * FROM recipes WHERE category = ? ORDER BY name";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("s", $category);
        $stmt->execute();
    
        $result = $stmt->get_result();
        $recipes = [];
    
        while ($row = $result->fetch_assoc()) {
            $recipes[] = $row;
        }
    
        return $recipes;
    }
    
    public function getRecipesByCuisine($cuisine) {
        $sql = "SELECT * FROM recipes WHERE cuisine = ? ORDER BY name";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("s", $cuisine);
        $stmt->execute();
    
        $result = $stmt->get_result();
        $recipes = [];
    
        while ($row = $result->fetch_assoc()) {
            $recipes[] = $row;
        }
    
        return $recipes;
    }
    
    public function getCategories() {
        if ($this->connection === null) {
            throw new Exception("Database connection is not set.");
        }

        $query = "SELECT DISTINCT category FROM recipes ORDER BY category";
        return $this->connection->query($query);
    }
    public function getCuisines() {
        if ($this->connection === null) {
            throw new Exception("Database connection is not set.");
        }

        $query = "SELECT DISTINCT cuisine FROM recipes ORDER BY cuisine";
        return $this->connection->query($query);
    }
    function getRandomRecipe() {
        $sql = "SELECT * FROM recipes ORDER BY RAND() LIMIT 1";
        $result = $this->connection->query($sql);
        
        if($result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }
    public function addRecipe($name, $link, $ingredients, $category, $cuisine, $picid) {
        $sql = "INSERT INTO recipes (name, link, ingredients, category, cuisine, picid) VALUES (?, ?, ?, ?, ?, ?)";
    
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("ssssss", $name, $link, $ingredients, $category, $cuisine, $picid);

        // Check if the insert was successful
        if ($stmt->execute()) {
            return $stmt->insert_id; // Return the new ID
        } else {
            echo "Error: " . $stmt->error; // Debugging output
            return false;
        }
    }
    
    public function editRecipe($id, $name, $link, $ingredients, $category, $cuisine, $picid) {
    $sql = "UPDATE recipes SET name=?, link=?, ingredients=?, category=?, cuisine=?, picid=? WHERE id=?";
    $stmt = $this->connection->prepare($sql);
    
    // Check if prepare was successful
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($this->connection->error));
    }

    // Bind the parameters: 6 strings and 1 integer
    $stmt->bind_param("ssssssi", $name, $link, $ingredients, $category, $cuisine, $picid, $id);

    // Execute the statement
    if ($stmt->execute()) {
        return true; // Successful execution
    } else {
        return false; // Failed execution
    }
}

    
    public function deleteRecipe($id) {
        $sql = "DELETE FROM recipes WHERE id = ?";
        $stmt = $this->connection->prepare($sql);
        
        if ($stmt->execute([$id])) {
            echo "Recipe with ID $id deleted successfully.";
            return true;
        } else {
            echo "Failed to delete recipe with ID $id.";
            return false;
        }
        //return $stmt->execute(['id']);
    }
    public function getRecipeById($id) {
        $sql = "SELECT * FROM recipes WHERE id = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_assoc();
    }
    function searchRecipes($search) {
        $sql = "SELECT * FROM recipes WHERE name LIKE '%".$search."%' OR ingredients LIKE '%".$search."%' ORDER BY name";
        $result = $this->connection->query($sql);
        if (!$result) {
            throw new Exception("Database query failed: " . $this->connection->error);
        }
        $recipes = [];
        while ($row = $result->fetch_assoc()) {
            $recipes[] = $row;
        }
        return $recipes;
    }
}
