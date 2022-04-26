<?php

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

    $result = "";
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $result = $this->loadFood($_POST["search"]);
    
    if(!empty($result)){
        
        foreach($result as $item){
            echo "<div class='container py-1'>";
            echo "<div class='card shadow mb-4'>";
            echo "<div class='card-body p-5'>";
            echo "<h4 class='mb-4'>" .$item['food_name']."</h4>";
            echo " <ul class='list-inline'>";
            echo "<li class='list-inline-item'> Brand Name: ". $item['brand_name_item_name']. "</li>";
            echo "<li class='list-inline-item'> Calories: ". $item['nf_calories']. "</li>";
            echo "</ul>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
        }
    }
    else{
        echo "";
    }