
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Search</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Additional Custom Styles */
        #recipeDetailsContainer {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mt-4">Recipe Search</h1>
        <div class="row">
            <!-- Search Input and Button -->
            <div class="col-md-6">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" id="searchInput" placeholder="Search for recipes">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button" onclick="searchRecipes()">Search</button>
                    </div>
                </div>
            </div>
        </div>
        
        <hr>

        <!-- Filter Section -->
        <h2>Filter Recipes</h2>
        <div class="row">
            <div class="col-md-3">
                <label for="cuisineType">Cuisine Type:</label>
                <select class="form-control" id="cuisineType">
                    <option value="italian">Italian</option>
                    <option value="mexican">Mexican</option>
                    <option value="indian">Indian</option>
                    <!-- Add more cuisine types as needed -->
                </select>
            </div>
            <div class="col-md-3">
                <label for="mealType">Meal Type:</label>
                <select class="form-control" id="mealType">
                    <option value="breakfast">Breakfast</option>
                    <option value="lunch">Lunch</option>
                    <option value="dinner">Dinner</option>
                    <!-- Add more meal types as needed -->
                </select>
            </div>
            <div class="col-md-3">
                <label for="cookingTime">Max Cooking Time (minutes):</label>
                <input type="number" class="form-control" id="cookingTime" min="0">
            </div>
            <div class="col-md-3">
                <label>Dietary Requirements:</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="vegetarian">
                    <label class="form-check-label" for="vegetarian">Vegetarian</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="glutenFree">
                    <label class="form-check-label" for="glutenFree">Gluten-Free</label>
                </div>
                <!-- Add more dietary requirements checkboxes as needed -->
            </div>
            <button onclick="searchRecipess()">Search</button>
        </div>

        <hr>

        <!-- Recipe List -->
        <h2>Recipes</h2>
        <ul class="list-group" id="recipeList"></ul>
    </div>

    <!-- Bootstrap JS and your custom JavaScript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>


    function searchRecipess() {
            const cuisineType = document.getElementById("cuisineType").value;
            const mealType = document.getElementById("mealType").value;
            const cookingTime = document.getElementById("cookingTime").value;
            const vegetarian = document.getElementById("vegetarian").checked;
            const glutenFree = document.getElementById("glutenFree").checked;

            // Make AJAX request to your backend or Spoonacular API with the specified parameters
            // Process the response and display the filtered recipes on the webpage
            // Example:
            fetch(`https://api.spoonacular.com/recipes/search?cuisine=${cuisineType}&type=${mealType}&maxReadyTime=${cookingTime}&vegetarian=${vegetarian}&glutenFree=${glutenFree}&apiKey=8988d84101104230997657bc497153e7`)
                .then(response => response.json())
                .then(data => {
                    displayRecipess(data.results);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function displayRecipess(recipes) {
            const recipeList = document.getElementById("recipeList");
            recipeList.innerHTML = "";

            recipes.forEach(recipe => {
                const listItem = document.createElement("li");
                listItem.textContent = recipe.title;
                recipeList.appendChild(listItem);
            });
        }


        function searchRecipes() {
            const searchInput = document.getElementById("searchInput").value;
            const apiKey = "8988d84101104230997657bc497153e7";
            const url = `https://api.spoonacular.com/recipes/search?query=${encodeURIComponent(searchInput)}&apiKey=${apiKey}&number=10`;

            fetch(url)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    displayRecipes(data.results);
                })
                .catch(error => {
                    console.error('There was a problem with the fetch operation:', error);
                });
        }

        function displayRecipes(recipes) {
            const recipeList = document.getElementById("recipeList");
            recipeList.innerHTML = "";

            recipes.forEach(recipe => {
                const listItem = document.createElement("li");

                // Recipe Title and Image
                const recipeTitle = document.createElement("h3");
                recipeTitle.textContent = recipe.title;
                listItem.appendChild(recipeTitle);

                const recipeImage = document.createElement("img");
                recipeImage.src = recipe.image; // URL of the recipe image
                recipeImage.alt = recipe.title; // Alt text for the image
                listItem.appendChild(recipeImage);

                // Button to view recipe details
                const viewDetailsButton = document.createElement("button");
                viewDetailsButton.textContent = "View Details";
                viewDetailsButton.onclick = function() {
                    fetchRecipeDetails(recipe.id);
                };
                listItem.appendChild(viewDetailsButton);

                recipeList.appendChild(listItem);
            });
        }

        function fetchRecipeDetails(recipeId) {
            const apiKey = "8988d84101104230997657bc497153e7";
            const url = `https://api.spoonacular.com/recipes/${recipeId}/information?apiKey=${apiKey}`;

            fetch(url)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(recipe => {
                    // Display detailed information about the recipe
                    renderRecipeDetails(recipe);
                })
                .catch(error => {
                    console.error('There was a problem with the fetch operation:', error);
                });
        }

        function renderRecipeDetails(recipe) {
            const recipeDetailsContainer = document.getElementById("recipeDetailsContainer");
            recipeDetailsContainer.innerHTML = "";

            // Title
            const titleElement = document.createElement("h2");
            titleElement.textContent = recipe.title;
            recipeDetailsContainer.appendChild(titleElement);

            // Ingredients
            const ingredientsHeader = document.createElement("h3");
            ingredientsHeader.textContent = "Ingredients";
            recipeDetailsContainer.appendChild(ingredientsHeader);

            const ingredientsList = document.createElement("ul");
            recipe.extendedIngredients.forEach(ingredient => {
                const ingredientItem = document.createElement("li");
                ingredientItem.textContent = ingredient.original;
                ingredientsList.appendChild(ingredientItem);
            });
            recipeDetailsContainer.appendChild(ingredientsList);

            // Instructions
            const instructionsHeader = document.createElement("h3");
            instructionsHeader.textContent = "Instructions";
            recipeDetailsContainer.appendChild(instructionsHeader);

            const instructionsList = document.createElement("ol");
            recipe.analyzedInstructions[0].steps.forEach(step => {
                const instructionItem = document.createElement("li");
                instructionItem.textContent = step.step;
                instructionsList.appendChild(instructionItem);
            });
            recipeDetailsContainer.appendChild(instructionsList);

            // Nutritional Information
            const nutritionHeader = document.createElement("h3");
            nutritionHeader.textContent = "Nutritional Information";
            recipeDetailsContainer.appendChild(nutritionHeader);

            const nutritionList = document.createElement("ul");
            for (const [key, value] of Object.entries(recipe.nutrition)) {
                const nutritionItem = document.createElement("li");
                nutritionItem.textContent = `${key}: ${value}`;
                nutritionList.appendChild(nutritionItem);
            }
            recipeDetailsContainer.appendChild(nutritionList);
        }
    </script>
</body>
</html>
