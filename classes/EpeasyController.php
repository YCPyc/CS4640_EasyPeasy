<?php
// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

class EpeasyController{
    private $command;
    private $db;

    public function __construct($command){
        $this->command = $command;
        $this->db = new Database();
    }

    public function run(){
        switch($this->command){
            case "login":
                $this->login();
                break;
            case "mainPage":
                $this->mainPage();
                break;
            case "add":
                $this->add();
                break;
            case "saved":
                $this->saved();
                break;
            case "logout":
                $this->logout();
                break;
            case "search":
                $this->searchAPI();
                break;
            default:
                $this->mainPage();
                break;
        }

    }

    public function logout(){
        session_start();
        if(count($_SESSION) > 0){
            foreach ($_SESSION as $k => $v){
            unset($_SESSION[$k]);
            }
            session_destroy();    
        }
        header("Location: ?command=mainPage");
    }

    public function login(){
        $errorMsg = array();
        if($_SERVER["REQUEST_METHOD"] == "POST"){
                session_start();
                //check name value
                if (empty($_POST["name"])) {
                    // array_push($errorMsg, "<div class='alert alert-danger'> Name is required</div>");
                } else {
                    // check if name only contains letters and whitespace
                    if (!preg_match("/^[a-zA-Z-' ]*$/",$_POST["name"])) {
                        array_push($errorMsg, "<div class='alert alert-danger'> Name: Only letters and white space allowed</div>");
                    }
                }
                //check email value
                if (empty($_POST["email"])) {
                    // array_push($errorMsg, "<div class='alert alert-danger'> Email is required</div>");
                } else {
                    if (!filter_var($_POST["email"],FILTER_VALIDATE_EMAIL)) {
                        array_push($errorMsg, "<div class='alert alert-danger'> Email: Invalid email format</div>");
                    }
                }
                //check passwrod value
                if (empty($_POST["password"])) {
                    // array_push($errorMsg, "<div class='alert alert-danger'> Password is required</div>");   
                } else {
                    if (!preg_match("/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/",$_POST["password"])) {
                        array_push($errorMsg, "<div class='alert alert-danger'> Password: Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters</div>");
                    }
                }
                //if passed value validation
                if(empty($errorMsg)){
                    $data = $this->db->query("select * from user where userId = ?;","s",$_POST["email"]);
                    if($data === false){
                        array_push($errorMsg, "<div class='alert alert-danger'>Error checking the email</div>");
                    }
                    //if it is a new user, check password
                    else if (!empty($data)) {
                        if(password_verify($_POST["password"],$data[0]["password"])){
                            $_SESSION["email"] = $_POST["email"];
                            $_SESSION["name"] = $_POST["name"];
                            header("Location: ?command=mainPage");
                        }
                        else{
                            array_push($errorMsg, "<div class='alert alert-danger'>Wrong Password</div>");
                        }
                    }
                    //if its is new user, input data
                    else {
                        //insert into the database
                        $insert = $this->db->query("insert into user (userId,name,password) values (?,?,?);","sss",$_POST["email"],$_POST["name"],password_hash($_POST["password"],PASSWORD_DEFAULT));
                        if($insert == false){
                            array_push($errorMsg, "<div class='alert alert-danger'>Error checking the email</div>");
                        }
                        else{
                            $_SESSION["email"] = $_POST["email"];
                            $_SESSION["name"] = $_POST["name"];
                            header("Location: ?command=mainPage");
                        }
                    }
                    
                }

        }
        include("templates/login.php");
       
    }

    public function mainPage(){
        $result = "";
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $result = $this->loadFood($_POST["search"]);
   
        }
        include("templates/main.php");
    }


    private function loadFood($item){
        $url = "https://trackapi.nutritionix.com/v2/search/instant?query=".rawurlencode($item);

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            "x-app-id: dda5d795",
            "x-app-key: 66c24162955e8993f799a2385a0052b7",
            "Content-Type: application/json",
        ]);
        $response = curl_exec($curl);
        curl_close($curl);
        $data = json_decode($response,true);
        return $data['branded'];
    }

    public function add(){
        session_start();
        $errorMsg = array();
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            if (empty($_POST["recipeName"])) {
                array_push($errorMsg, "<div class='alert alert-danger'> Recipe Name is required</div>");
            } 
            else {
                // check if name only contains letters and whitespace
                if (!preg_match("/^[a-zA-Z-' ]*$/",$_POST["recipeName"])) {
                    array_push($errorMsg, "<div class='alert alert-danger'> Recipe Name: Only letters and white space allowed</div>");
                }
            }
            //check email value
            if (empty($_POST["measurement"]) || empty($_POST["unit"]) || empty($_POST["item"])) {
                array_push($errorMsg, "<div class='alert alert-danger'> Ingredient is required</div>");
            } 
            //check passwrod value
            if (empty($_POST["description"])) {
                array_push($errorMsg, "<div class='alert alert-danger'> Password is required</div>");   
            } 
            if(empty($errorMsg)){
                $data = $this->db->query("select * from recipe where recipeId = ?;","s",$_POST["recipeName"]);
                if($data === false){
                    array_push($errorMsg, "<div class='alert alert-danger'>Error checking the recipe</div>");
                }
                //if it is a old recipe, check password
                else if (!empty($data)) {
                    
                    array_push($errorMsg, "<div class='alert alert-danger'>Please enter a new recipe or put your name in the recipe name</div>");
    
                }
                //if its is new user, input data
                else {
                    //insert into the database
                    for($x = 0; $x<count($_POST["measurement"]);$x++){
                        $ingredientInsert = $this->db->query("insert into ingredient (recipeId,measurement,unit,item) values (?,?,?,?);","siss",$_POST["recipeName"],$_POST["measurement"][$x],$_POST["unit"][$x],$_POST["item"][$x]);
                        if($ingredientInsert == false){
                            array_push($errorMsg, "<div class='alert alert-danger'>Error inputing the ingredients</div>");
                            break;
                        }
                    }
                    $recipeInsert = $this->db->query("insert into recipe (recipeId,userId,description) values (?,?,?);","sss",$_POST["recipeName"],$_SESSION["email"],$_POST["description"]);
                    if($recipeInsert == false){
                        array_push($errorMsg, "<div class='alert alert-danger'>Error inputing the recipe</div>");
                    }
                    else{
                        header("Location: ?command=saved");
                    }
                }
            }
        }
        include("templates/addPage.php");
    }

    public function saved(){
        session_start();
        //deletion handlement
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $deleteRecipe = $this->db->query("delete from recipe where recipeId = ?","s",$_POST["deleteId"]);
            $deleteIngredient = $this->db->query("delete from ingredient where recipeId = ?","s",$_POST["deleteId"]);
            if($deleteRecipe== false || $deleteIngredient== false){
                echo "deletion failed";
            }
            header("?command=saved");
        }

        if(isset($_SESSION["email"])){
            $result = $this->db->query("select * from user natural join recipe natural join ingredient where userId = ?","s",$_SESSION["email"]);
            if(!empty($result)){
                $recipes = array();
                foreach($result as $dish){
                    if(!in_array($dish["recipeId"],$recipes)){
                        array_push($recipes,$dish["recipeId"]);
                    }
                }   
                $final = array();
                foreach($recipes as $base){
                    //get ingredient for each recipe
                    $ingreList = array();
                    foreach($result as $res){
                        if($res["recipeId"] == $base){
                            $part1 = strval($res["measurement"]);
                            $part2 = " ";
                            $part3 = $res["unit"];
                            $part4 = " of ";
                            $part5 = $res["item"];
                            $ans = $part1.$part2.$part3.$part4.$part5;
                            array_push($ingreList,$ans);
                        }
                    }
                    //associative array that correspond ingredient to recipe
                    $final[$base] = $ingreList;
                }    
            }
        }
        else{
            header("?command=mainPage");
        }


        include("templates/saved.php");
    }
}