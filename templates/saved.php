<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" href="styles/main.css">

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1"> 

        <meta name="author" content="Jun Song Park, Yancheng Pan">
        <meta name="description" content="A website containing all the dieting hacks you will ever need">
        <meta name="keywords" content="Diet, Weight loss, health">
        
        <title>Easy Peasy</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" 
        integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous"> 
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    </head>
    <body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>



    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"
        integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script> -->

    <!-- check for login status -->
    <?php 
    
    if (!isset($_SESSION["email"])){
      header("Location: ?command=login");
    }
     ?>
        <nav class="navbar navbar-expand-lg">
            <div class="container-xl">
                <a class="navlogo" href="?command=mainPage">EasyPeasy</a>
                <button class=" navbutton navbar-toggler" type="button" data-bs-toggle="collapse" 
                data-bs-target="#navbarsTop" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon">...</span>
                </button>
    
                <div class="collapse navbar-collapse" id="navbarsTop">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="navbutton" aria-current="page" href="?command=mainPage">Home</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="navbutton dropdown-toggle" href="#" id="dropdown1" data-bs-toggle="dropdown" 
                            aria-expanded="false">Dashboard</a>
                            <ul class="dropdown-menu" aria-labelledby="dropdown1">
                                <li><a class="dropdown-item" href="?command=saved">Saved Recipe</a></li>
                                <li><a class="dropdown-item" href=".?command=add">Add Recipe</a></li>
                            </ul>
                        </li>
                    </ul>
                    <!-- check for login status -->
                    <?php
                    if(isset($_SESSION["name"])){
                        echo "<h4 style='color: white;'> Hi, ".$_SESSION["name"]."! </h4>";
                        echo "<a style='color: white; border-color: white; margin-left: 5px' 
                        class='btn button-border my-2 my-sm-0' aria-current='page' href='?command=logout'>Log out</a>";
                    }
                    else{
                        echo "<a style='color: white; border-color: white;' 
                        class='btn button-border my-2 my-sm-0' aria-current='page' href='?command=login'>Log in</a>";
                    }
                    ?>
                    
                </div>
            </div>
        </nav>
        <!-- SearchBar -->
        <div class="p-5 mb-4 text-white" id="home-1">
            <div id="totalCal">Total Daily Calories: </div>
            <div id="total">0
            </div>
            <button style="	text-align: center" id="clearCal" class="btn btn-outline-success" onclick="clearCalorie()">Clear Calories</button>
        </div>

        <h1 style="margin-left: 5rem">Saved Recipes</h1>

        <?php
            if(!empty($final)){
                $i = 0;
                foreach($final as $key => $value){
                    echo "<div class='container py-1'>";
                    echo "<div class='card shadow mb-4'>";
                    echo "<div class='card-body p-5'>";
                    echo "<h4 class='mb-4'>" .$key."</h4>";
                    
                    foreach($result as $res){
                        if($res["recipeId"] == $key){
                            $calories = $res["calorie"];
                            break;
                        }
                    }
                    echo "<h6>Calories: "; 
                    echo "</h6>";
                    echo "<p>" .$calories. "</p>";
                    echo "<h6>Ingredients: "; 
                    echo "</h6>";
                    echo " <ul class='list-inline'>";
                    foreach($value as $detail){
                        echo "<li class='list-inline-item'>". $detail. "</li>";
                    }
                    echo "</ul>";
                    echo "<p>";
                    foreach($result as $res){
                        if($res["recipeId"] == $key){
                            $instruction = $res["description"];
                            break;
                        }
                    }
                    echo "<h6>Instructions: "; 
                    echo "</h6>";
                    echo $instruction;
                    echo "</p>";
                    echo " <ul class='list-inline'>";
                    echo "<li class='list-inline-item'>";
                    echo "<form action='?command=saved' method='post'>";
                    echo "<input type='hidden' name='deleteId' value='". $key. "'>";
                    echo "<button type='submit' name='deleteItem' class='btn btn-outline-danger' >";
                    echo "Delete";
                    echo "</button>";
                    echo "</form>";
                    echo "</li>";

                    echo "<li class='list-inline-item'>";
                    echo "<form action='?command=saved' method='post'>";
                    // echo "<input type='hidden' value='".$calories."' class='calorieInput'>";
                    echo "<button type='button' name='calorieItem' value='".$calories."' class='btn btn-outline-success calorieInput'>";
                    echo "Add to Daily Intake";
                    echo "</button>";
                    echo "</form>";
                    echo "</li>";

                    echo "</ul>";

                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                }
                $i += 1;
                
            }
               

        ?>


        <!-- <div class="container py-1">        
            <div class="card shadow mb-4">
                <div class="card-body p-5">
                    <h4 class="mb-4">Some Recipe</h4>
                    <h6>Ingredients</h6>

                    <ul class="list-inline">
                        <li class="list-inline-item">First item</li>
                        <li class="list-inline-item">Second item</li>
                        <li class="list-inline-item">Third item</li>
                        <li class="list-inline-item">Fourth item </li>
                        <li class="list-inline-item">Fifth item</li>
                    </ul>
                    <ol class="custom-numbers">
                        <li class="mb-2">Cook something</li>
                        <li class="mb-2">Season something</li>
                        <li class="mb-2">Blah Blah Blah</li>
                        <li class="mb-2">...</li>
                        <li class="mb-2">...</li>
                    </ol>
                </div>
            </div>                
        </div>

        <div class="container py-1">        
            <div class="card shadow mb-4">
                <div class="card-body p-5">
                    <h4 class="mb-4">Some Recipe</h4>
                    <h6>
                    Ingredients
                    </h6>
                    <ul class="list-inline">
                        <li class="list-inline-item">First item</li>
                        <li class="list-inline-item">Second item</li>
                        <li class="list-inline-item">Third item</li>
                        <li class="list-inline-item">Fourth item </li>
                        <li class="list-inline-item">Fifth item</li>
                    </ul>
                    <ol class="custom-numbers">
                        <li class="mb-2">Cook something</li>
                        <li class="mb-2">Season something</li>
                        <li class="mb-2">Blah Blah Blah</li>
                        <li class="mb-2">...</li>
                        <li class="mb-2">...</li>
                    </ol>
                </div>
            </div>                
        </div> -->
        
        <div class="fadeshow container">
            <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
                <p class="col-md-4 mb-0 text-muted">&copy; 2021 EasyPeasy, Inc</p>
    
                <ul class="nav col-md-4 justify-content-end">
                    <li class="nav-item"><a href="./index.html" class="nav-link px-2 text-muted">Home</a></li>
                    <li class="nav-item"><a href="./templates/saved.html" class="nav-link px-2 text-muted">Saved Recipe</a></li>
                    <li class="nav-item"><a href="./templates/addPage.html" class="nav-link px-2 text-muted">Add Recipe</a></li>
                    <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Daily Nutrient Intake</a></li>
                </ul>
            </footer>
        </div>






        <script>
            $(document).on("click", "button.calorieInput" , function() {
                var cal = +$(this).val() + +document.getElementById("total").innerHTML
                document.getElementById("total").innerHTML = cal;
            });
            
            function addCalorie(){
                console.log(document.getElementById("calorieInput0").value);
                var cal = +document.getElementById("calorieInput0").value + +document.getElementById("total").innerHTML
                document.getElementById("total").innerHTML = cal;
            }

            function clearCalorie(){
                document.getElementById("total").innerHTML = 0;

            }
            const myInterval = setInterval(myTimer);

            function myTimer() {
                const date = new Date();
                // document.getElementById("time").innerHTML = date.toLocaleTimeString();
            }
            function scheduleReset() {
                // get current time
                let reset = new Date();

                // update the Hours, mins, secs to the 24th hour (which is when the next day starts)
                reset.setHours(24, 0, 0, 0);
                // calc amount of time until restart
                let t = reset.getTime() - Date.now();
                setTimeout(function() {
                    // reset variable
                    document.getElementById("total").innerHTML = 0;
                    // schedule the next variable reset
                    scheduleReset();
                }, t);
            }

            scheduleReset();
        </script>
    </body>

</html>