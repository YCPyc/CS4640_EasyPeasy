<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">  
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="CS4640">
        <meta name="description" content="CS4640 Trivia Login Page">  
        <title>Easy Peasy Login</title>
        <link rel="stylesheet" href="styles/main.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous"> 
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
                                <li><a class="dropdown-item" href="?command=add">Add Recipe</a></li>
                            </ul>
                        </li>
                    </ul>
                    
                </div>
            </div>
        </nav>
        
        <div class="container" style="margin-top: 15px;">
            <div class="row col-xs-8">
                <h1>Customzied Recipe is just one click away - Get Started or Log Back In</h1>
                <p> Welcome to Easy Peasy!  To get started, enter a username and password.</p>
            </div>
            <div class="row justify-content-center">
                <div class="col-4">
               <?php
                    foreach( $errorMsg as $error){
                       echo $error;
                    }
               ?>
                <form action="?command=login" method="post">

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email"/>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name"/>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password"/>
                    </div>
                    <div class="text-center">                
                    <button type="submit" class="btn btn-primary">Enter</button>
                    </div>
                </form>
                
                </div>
            </div>
        </div>
        <script>
            
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    </body>
</html>