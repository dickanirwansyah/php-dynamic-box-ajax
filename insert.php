<?php

    /*
     * @Author dickanirwansyah
     * @IDE NetBeans Development Version
     * @Title Dynamic Box - Jquery AJAX
     */


    if(isset($_POST["item_name"])){
        
        $connect = new PDO("mysql:host=localhost;dbname=db_php_development", "root", "root");
        
        $order_id = uniqid();
        
        for($count = 0; $count < count($_POST["item_name"]); $count++){
            
            $query = "insert into orders(order_id, item_name, item_quantity, item_unit) "
                    . "values(:order_id, :item_name, :item_quantity, :item_unit)";
            
            $statement = $connect->prepare($query);
            $statement->execute(
                   array(
                       ':order_id' => $order_id,
                       ':item_name' => $_POST["item_name"][$count],
                       ':item_quantity' => $_POST["item_quantity"][$count],
                       ':item_unit' => $_POST["item_unit"][$count]
                   )
                );
        }
        
        $result = $statement->fetchAll();
        if(isset($result)){
            echo 'ok';
        }
    }

?>
