
<!-- CS Server: https://cs4640.cs.virginia.edu/jp6ax/EasyPeasy/index.html -->
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

    </head>  
    <body>
        
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
                                <li><a class="dropdown-item" href="#">Daily Nutrient Intake</a></li>
                            </ul>
                        </li>
                    </ul>
                    <!-- check for login status -->
                    <?php
                    session_start();
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
    
        <div class="p-5 mb-4 text-white" id="home-1">
            <div class="container py-5">
                <h1 class="display-5 fw-bold">Find Your Recipes</h1>
                <p >Search and Filter through all our recipes</p>
                <form method="post" action="?command=mainPage" id="searchForm">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="search" id ="search" placeholder="Any food item that you want to search about" aria-label="Search" aria-describedby="button-addon2">
                        <button class="btn btn-outline-success" type="submit" id="button-addon2">Search</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- loop through databse to check for saved recipes -->
        <div class="searchResult">
           
        </div>


        <section id ="explore" class="fadeshow" style="padding-left: 7rem; padding-bottom: 5rem;" >
            <div class="col-4">
                <h3>Explore</h3>
            </div>
            <a href="./index.html" aria-label="Explore Page Carousel of Food Pictures">
                <div class="col-8" id="carousel">
                    <div class="item"></div>
                    <div class="item"></div>
                    <div class="item"></div>
                    <div class="item"></div>
                </div>
            </a>
        </section>
    
        <div class="fadeshow container">
            <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
                <p class="col-md-4 mb-0 text-muted">&copy; 2021 EasyPeasy, Inc</p>
    
                <ul class="nav col-md-4 justify-content-end">
                    <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Home</a></li>
                    <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Saved Recipe</a></li>
                    <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Add Recipe</a></li>
                    <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Daily Nutrient Intake</a></li>
                </ul>
            </footer>
        </div>
    
    
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.js"
	integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
	crossorigin="anonymous"></script>
        <script>
            const element = document.getElementById("searchForm");
            console.log(1);
            var searchRes = null;
            element.addEventListener("submit", function(e) {
                e.preventDefault();
                $("#explore").css("display","none");
                const input = document.getElementById("search").value;
                url = "https://trackapi.nutritionix.com/v2/search/instant?query=" + encodeURIComponent(input);
                $.ajax({
                    type: 'GET',
                    url: url,
                    headers: {
                        "x-app-id":"dda5d795",
                        "x-app-key":"66c24162955e8993f799a2385a0052b7"
                    },
                    success: function (data) {
                        searchRes = data['branded'];
                        console.log(searchRes);  
                        $.each(searchRes, function(index, value) {
                            var myString = `
                            <div class='container py-1'>
                                <div class='card shadow mb-4'>
                                    <div class='card-body p-5'>
                                        <h4 class='mb-4'> ${searchRes[index]['food_name']}</h4>
                                        <ul class='list-inline'>"
                                            <li class='list-inline-item'> Brand Name: ${searchRes[index]['brand_name_item_name']} </li>
                                            <li class='list-inline-item'> Calories: ${searchRes[index]['nf_calories']}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            `
                            $('.searchResult').append(myString);
                        });
                        
                    }
    
                });
            
        
            });
       
            

        </script>
    
    </body>

</html>