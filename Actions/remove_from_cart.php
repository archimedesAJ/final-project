<?php
session_start();
require('../Controllers/cart_controller.php');

//getting the ip address
$ip_add = getenv("REMOTE_ADDR");

if (isset($_GET['removeProd_ID'])){
    $p_id = $_GET['removeProd_ID'];
    
    //check if the user is logged in
    if (isset($_SESSION["user_id"])){
        $session = $_SESSION["user_id"];
        $result = remove_carts_controller($p_id,$session);

        //if true
        if($result){
            $_SESSION['status'] = "Product Successfully removed from cart!";
			$_SESSION['status_code'] = "success";
            header('Location: ../View/shoping-cart.php');
            
         }else{
            $_SESSION['status'] = "Product Not removed from cart!";
			$_SESSION['status_code'] = "error";
            header('LLocation: ../View/shoping-cart.php');
            
         }
    //if the user is not logged in
    }else{
        $result = remove_cart_controller($p_id,$ip_add);

        if($result){
            $_SESSION['status'] = "Product Successfully removed from cart!";
			$_SESSION['status_code'] = "success";
            header('Location: ../View/shoping-cart.php');
            
        }else{
            $_SESSION['status'] = "Product Not removed from cart!";
			$_SESSION['status_code'] = "error";
            header('Location: ../View/shoping-cart.php');
        }

    }
}


?>