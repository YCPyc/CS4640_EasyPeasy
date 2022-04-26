<!DOCTYPE html>
<html lang="en">
    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1"> 

        <meta name="author" content="Jun Song Park, Yancheng Pan">
        <meta name="description" content="A website containing all the dieting hacks you will ever need">
        <meta name="keywords" content="Diet, Weight loss, health">
        
        <title>Easy Peasy</title>
        <script src="jquery-3.5.1.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <link rel="stylesheet" href="styles/main.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" 
        integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous"> 
    </head>
    <body>
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
                                <li><a class="dropdown-item" href="?command=add">Add Recipe</a></li>
                            </ul>
                        </li>
                    </ul>
                    <!-- check for login status -->
                    <?php
                    foreach( $errorMsg as $error){
                        echo $error;
                     }
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

        <h1 style="padding: 2.5rem 5rem 5rem; background-image: linear-gradient(#2BC8A2, white); width:100%">
            New Recipes Information</h1>

        <div class="add container"> 
            <form action="?command=add" method="post" >
                <div class="add name--section">
                    <label class="label--name" for="recipe--name">Recipe Name:</label> 
                    <input type="text" id="recipe--name"   name="recipeName">
                </div>

                <div class="add ingredient--section">
                    <label class="label--name" id="recipe--ingredients">Ingredients List: </label>

                    <button type="button" class="btn btn-success btn-sm" id="insert-more">Add New Ingredient</button>
                     <br>
                     <div class="table-responsive">
                        <table class="table" id="mytable">
                            <thead>
                                <tr>
                                    <th>Amount</th>
                                    <th>Measurement</th>
                                    <th>Ingredient</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <input aria-labelledby='recipe--ingredients' type="number" name="measurement[]">
                                    </td>
                                    <td>
                                        <select name="unit[]" aria-labelledby='recipe--ingredients'>
                                            <option value="tbsp">tbsp</option>
                                            <option value="Cup">Cup</option>
                                            <option value="Serving">Serving</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input list="ingredients" aria-labelledby='recipe--ingredients' name="item[]">
                                        
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm">Remove</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                     </div>    
                </div>

                <div class="add instuctions--section">
                    <label class="label--name" for="recipe--instructions">Instructions:</label> 
                    <textarea id="recipe--instructions" class="form-control" aria-label="With textarea" rows="6" name="description">  </textarea>

                </div>
                <div class="add name--section">
                    <label class="label--name" for="recipe--calories">Total Calories:</label> 
                    <input type="text" id="recipe--calories" name="calories">
                </div>


                <button type="submit" class="btn btn-outline-success" style="margin-left: 15px;">Save</button>
            </form>      
                       
        </div>
        
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

        <!-- JavaScript for adding new ingredients to recipe -->
        <script>
            $("#insert-more").click(function () {
                $("#mytable").each(function () {
                    var tds = '<tr>';
                    jQuery.each($('tr:last td', this), function () {
                        tds += '<td>' + $(this).html() + '</td>';
                    });
                    tds += '</tr>';
                    if ($('tbody', this).length > 0) {
                        $('tbody', this).append(tds);
                    } else {
                        $(this).append(tds);
                    }
                });
            });
        </script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>

    </body>

</html>