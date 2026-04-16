<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Food Menu</title>
        <style>
            /* CSS Styles */
            body {
                font-family: Arial, sans-serif;
                background-color: #f2f2f2;
                margin: 0;
                padding: 0;
            }

            .menu-container {
                max-width: 600px;
                margin: 20px auto;
                background-color: #fff;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }

            h2 {
                text-align: center;
                margin-bottom: 20px;
            }

            .menu-category {
                margin-bottom: 20px;
            }

            .menu-category h3 {
                color: #333;
                margin-bottom: 10px;
            }

            .menu-category ul {
                list-style-type: none;
                padding: 0;
                margin: 0;
            }

            .menu-category ul li {
                margin-bottom: 5px;
            }

            /* Improved select dropdown styles */
            .food-select {
                width: 100%;
                padding: 10px;
                border: 1px solid #ccc;
                border-radius: 5px;
                margin-bottom: 10px;
            }

            /* Styles for selected items display */
            #selected-items {
                margin-top: 20px;
                padding: 10px;
                border: 1px solid #ccc;
                border-radius: 5px;
            }

            #selected-items h3 {
                margin-bottom: 10px;
            }

            #selected-items p {
                margin: 5px 0;
            }
        </style>
    </head>
    <body>
        <div class="menu-container">
            <h2>Food Menu</h2>

            <!-- Select dropdowns for food items -->
            <div class="food-select-container">
                <select class="food-select" id="appetizers">
                    <option value="">Select an appetizer</option>
                    <option value="Samosas">Samosas</option>
                    <option value="Pakoras">Pakoras</option>
                    <option value="Kebabs">Kebabs</option>
                    <option value="Chaat">Chaat</option>
                    <option value="Assorted Tikkas">Assorted Tikkas</option>
                </select>
                <select class="food-select" id="main-courses">
                    <option value="">Select a main course</option>
                    <option value="Butter Chicken">Butter Chicken</option>
                    <option value="Paneer Tikka Masala">Paneer Tikka Masala</option>
                    <option value="Dal Makhani">Dal Makhani</option>
                    <option value="Mixed Vegetable Curry">Mixed Vegetable Curry</option>
                    <option value="Biryanis">Biryanis</option>
                    <option value="Naan">Naan</option>
                    <option value="Roti">Roti</option>
                    <option value="Paratha">Paratha</option>
                </select>
                <select class="food-select" id="rice-dishes">
                    <option value="">Select a rice dish</option>
                    <option value="Plain Rice">Plain Rice</option>
                    <option value="Vegetable Pulao">Vegetable Pulao</option>
                    <option value="Biryanis">Biryanis</option>
                    <option value="Flavored Rice Dishes">Flavored Rice Dishes</option>
                </select>
                <select class="food-select" id="desserts">
                    <option value="">Select a dessert</option>
                    <option value="Gulab Jamun">Gulab Jamun</option>
                    <option value="Rasgulla">Rasgulla</option>
                    <option value="Kheer">Kheer</option>
                    <option value="Jalebi">Jalebi</option>
                    <option value="Assorted Sweets">Assorted Sweets</option>
                </select>
                <select class="food-select" id="beverages">
                    <option value="">Select a beverage</option>
                    <option value="Lassi">Lassi</option>
                    <option value="Masala Chai">Masala Chai</option>
                    <option value="Soft Drinks">Soft Drinks</option>
                    <option value="Alcoholic Beverages">Alcoholic Beverages (depending on event and location)</option>
                </select>
                <button onclick="submitSelection()">Submit Selection</button>
                <button onclick="displaySelection()">Show Selection</button>
            </div>

            <!-- Display selected items -->
            <div id="selected-items"></div>
        </div>

        <script>
            function submitSelection() {
                var appetizers = document.getElementById("appetizers").value;
                var mainCourses = document.getElementById("main-courses").value;
                var riceDishes = document.getElementById("rice-dishes").value;
                var desserts = document.getElementById("desserts").value;
                var beverages = document.getElementById("beverages").value;

                // AJAX request to submit selected items to server
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function () {
                    if (xhr.readyState == XMLHttpRequest.DONE) {
                        if (xhr.status == 200) {
                            // Response received, display confirmation message or handle further actions
                            var response = xhr.responseText;
                            alert(response); // For demonstration, you can remove this alert
                        } else {
                            // Error occurred during request
                            alert('Error submitting selection. Please try again.');
                        }
                    }
                };
                xhr.open("POST", "store_selection.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.send("appetizer=" + appetizers + "&main_course=" + mainCourses + "&rice_dish=" + riceDishes + "&dessert=" + desserts + "&beverage=" + beverages);
            }

            function displaySelection() {
                var appetizers = document.getElementById("appetizers").value;
                var mainCourses = document.getElementById("main-courses").value;
                var riceDishes = document.getElementById("rice-dishes").value;
                var desserts = document.getElementById("desserts").value;
                var beverages = document.getElementById("beverages").value;

                var selectedItems = document.getElementById("selected-items");
                selectedItems.innerHTML = "<h3>Selected Items</h3>";
                selectedItems.innerHTML += "<p><strong>Appetizer:</strong> " + appetizers + "</p>";
                selectedItems.innerHTML += "<p><strong>Main Course:</strong> " + mainCourses + "</p>";
                selectedItems.innerHTML += "<p><strong>Rice Dish:</strong> " + riceDishes + "</p>";
                selectedItems.innerHTML += "<p><strong>Dessert:</strong> " + desserts + "</p>";
                selectedItems.innerHTML += "<p><strong>Beverage:</strong> " + beverages + "</p>";
            }
        </script>
    </body>
</html>
