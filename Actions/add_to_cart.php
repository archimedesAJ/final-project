<?php
session_start();
require('../Controllers/cart_controller.php');

//getting the ip address
$ip_add = getenv("REMOTE_ADDR");

if(isset($_GET["product_id"])){
    $p_id = $_GET["product_id"];
    $qty  = 1;
  //Checks if the user has logged In
    if(isset($_SESSION['user_id'])){
        $c_id = $_SESSION['user_id'];
        
        $all_cart = getValidated_Controller($c_id, $p_id);

        //checks if product already exist in the cart
        if(!empty($all_cart)){
            $_SESSION['status'] = "Product already in the cart";
			$_SESSION['status_code'] = "warning";
            header('Location: ' . $_SERVER['HTTP_REFERER']);

        //If the product is not already in the cart, add to cart 
        }else{
            $result = add_to_cart_controller($p_id,$ip_add,$c_id, $qty);
            if($result){
                $_SESSION['status'] = "Product Successfully added to Cart!";
                $_SESSION['status_code'] = "success";
                header('Location: ' . $_SERVER['HTTP_REFERER']);
               
            }else{
                $_SESSION['status'] = "Product Not added to cart!";
                $_SESSION['status_code'] = "success";
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                
            }
        }
        
    // If the user is not logged In
    }else{
        $all_cart = select_one_cart_controller($p_id, $ip_add);
        
        //checks if product already exist in the cart
        if(!empty($all_cart)){
            $_SESSION['status'] = "Product already in the cart";
            $_SESSION['status_code'] = "warning";
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            //header("Location: ../View/product-detail.php");
           
        //If product is not already in the cart, then add to cart
        }else{
            $result = add_to_cart_notLogin_controller($p_id,$ip_add, $qty);
            if($result){
                $_SESSION['status'] = "Product Successfully added!";
                $_SESSION['status_code'] = "success";
                header('Location: ' . $_SERVER['HTTP_REFERER']);
     
            }else{
                $_SESSION['status'] = "Product Not added to cart";
                $_SESSION['status_code'] = "error";
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            
            }
        }
    } 

}


?>