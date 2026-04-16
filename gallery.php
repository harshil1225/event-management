
<!DOCTYPE html>
<html>
<head>
    <style>
        .gallery-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            grid-gap: 20px;
            justify-content: center;
        }

        .gallery-item {
            border: 1px solid #ccc;
            overflow: hidden;
        }

        .gallery-item img {
            width: 100%;
            height: 100%;
            display: block;
        }

        .logout-button {
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 20px;
        }

        .logout-button:hover {
            background-color: #555;
        }
    </style>
</head>
<body>

<center>
    <fieldset>
        <h1>Gallery</h1>
        <div class="gallery-container">
            <div class="gallery-item">
                <a target="_blank" href="img_5terre.jpg">
                    <img src="m11.jpeg" alt="Cinque Terre">
                </a>
            </div>

            <div class="gallery-item">
                <a target="_blank" href="img_forest.jpg">
                    <img src="m14.jpg" alt="Forest">
                </a>
            </div>

            <div class="gallery-item">
                <a target="_blank" href="img_lights.jpg">
                    <img src="m13.jpg" alt="Northern Lights">
                </a>
            </div>

            <div class="gallery-item">
                <a target="_blank" href="img_mountains.jpg">
                    <img src="b12.jpeg" alt="Mountains">
                </a>
            </div>

            <div class="gallery-item">
                <a target="_blank" href="img_mountains.jpg">
                    <img src="b1.jpeg" alt="Mountains">
                </a>
            </div>

            <div class="gallery-item">
                <a target="_blank" href="img_mountains.jpg">
                    <img src="b2.jpg" alt="Mountains">
                </a>
            </div>

            <div class="gallery-item">
                <a target="_blank" href="img_mountains.jpg">
                    <img src="b3.jpeg" alt="Mountains">
                </a>
            </div>
            
            <div class="gallery-item">
                <a target="_blank" href="img_mountains.jpg">
                    <img src="n1.jpeg" alt="Mountains">
                </a>
            </div>
            
            <div class="gallery-item">
                <a target="_blank" href="img_mountains.jpg">
                    <img src="n2.jpeg" alt="Mountains">
                </a>
            </div>
            
            <div class="gallery-item">
                <a target="_blank" href="img_mountains.jpg">
                    <img src="n3.jpeg" alt="Mountains">
                </a>
            </div>
            
            <div class="gallery-item">
                <a target="_blank" href="img_mountains.jpg">
                    <img src="n4.jpeg" alt="Mountains">
                </a>
            </div>

            <div class="gallery-item">
                <a target="_blank" href="img_mountains.jpg">
                    <img src="b4.jpg" alt="Mountains">
                </a>
            </div>
        </div>
    </fieldset>
</center>

<center>
    <a href="home.php">
        <button class="logout-button" type="button">Go Back</button>
    </a>
</center>

</body>
</html>
