<?php
session_start();
require('../Controllers/cart_controller.php');

//get the ip address
$ip_add = getenv("REMOTE_ADDR");

if (isset($_POST['update_cart'])){
    $prod_id = $_POST['p_id'];
    $qty = $_POST['qty'];
    echo $prod_id ;
    
    //check if the user is logged in
    if (isset($_SESSION['user_id'])){
        $session = $_SESSION['user_id'];
        $result = updateCartQty_Logged($qty, $prod_id, $session);


        //if true, update cart
        if($result){
            $_SESSION['status'] = "Cart Successfully updated!";
			$_SESSION['status_code'] = "success";
            header('Location: ../View/shoping-cart.php');

        }else{
            $_SESSION['status'] = "Cart Not updated!";
			$_SESSION['status_code'] = "error";
            header('Location: ../View/edit_shoping-cart.php');
            
        }
    //if the user is not logged in
    }else{
        $result = updateCartQty($qty, $prod_id, $ip_add);
        
        //if true, update cart
        if($result){
            $_SESSION['status'] = "Cart Successfully updated!";
			$_SESSION['status_code'] = "success";
            header('Location: ../View/shoping-cart.php');

        }else{
            $_SESSION['status'] = "Cart Not updated!";
			$_SESSION['status_code'] = "error";
            header('Location: ../View/edit_shoping-cart.php');
        }
    }
   
}


?>