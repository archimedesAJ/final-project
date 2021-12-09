<?php

require('../Database/connection.php');

class Cart extends Connection{

    //method for adding cart(if user is logged in)
    function add_to_cart($p_id,$ip_add,$c_id, $qty){
        //retrun true or false
        return $this->query("insert into cart(p_id,ip_add,c_id,qty) values('$p_id','$ip_add','$c_id','$qty')");
    }

    //method for adding cart(if user is not logged in)
    function add_to_cart_notLogin($p_id,$ip_add, $qty){
        //retrun true or false
        return $this->query("insert into cart(p_id,ip_add,qty) values('$p_id','$ip_add','$qty')");
    }
    
    //method for selecting all cart products (not logged in)
    function select_all_products_cart($ip_add){
        return $this->query("select p.product_id, p.product_cat, p.product_price, p.product_title, 
        p.product_desc, p.product_image, p.product_keywords, c.p_id, c.ip_add, c.qty 
        from products AS p JOIN cart AS c ON p.product_id = c.p_id AND c.ip_add = '$ip_add'");
    }

    //method for selecting all cart products (when user is logged in)
    function select_all_products_carts($session){
        return $this->query("select p.product_id, p.product_cat, p.product_price, p.product_title, 
        p.product_desc, p.product_image, p.product_keywords, c.p_id, c.ip_add, c.qty 
        from products AS p JOIN cart AS c ON p.product_id = c.p_id AND c.c_id = '$session'");
    }

    //method for removing from cart when user is not logged in
    function remove_cart($prod_id,$ip_add){
        return $this->query("delete from cart where p_id = '$prod_id' and ip_add ='$ip_add'");
    }

    //method for removing from cart when user is logged in
    function remove_carts($prod_id,$session){
        return $this->query("delete from cart where p_id = '$prod_id' and c_id ='$session'");
    }

    //method to select one cart
    function select_one_cart($p_id, $ip_add){
        return $this->fetchOne("select * from cart where p_id='$p_id' and ip_add='$ip_add'");
    }

    //method to get the quantiy of items (when not logged In)
    function getCartItemQty($ip_add){
        return $this->query("select *  from cart where ip_add='$ip_add'");
    }

    //method to get the quantiy of items (when logged In)
    function getCartItemQty_Login($session){
        return $this->query("select * count_item from cart where c_id='$session'");
    }

    //method to get cart Amount
    function getCartItemAmt($ip_add){
        return $this->fetch("select sum(product_price * qty) as amount from products as p join cart as c on p.product_id = c.p_id and c.ip_add = '$ip_add'");
    }

    //Method to check if cart item already exist
    function getValidated($c_id, $p_id){
        return $this->fetchOne("select * from cart where c_id='$c_id' and p_id='$p_id'");
    }


    //method to update cart quantity when user is not logged In
    function updateCartQty_notLogin($qty, $prod_id, $ip_add){
        return $this->query("update cart set qty='$qty' where ip_add='$ip_add' and p_id='$prod_id'");
    }

    //method to update cart quantity when user is logged in
    function updateCartQty_Login($qty, $prod_id, $session){
        return $this->query("update cart set qty='$qty' where c_id='$session' and p_id='$prod_id'");
    }

    

    
    /*ORDER and PAYMENT METHODS */

    //Method to add orders
    function insert_order($user_id, $invoice, $status){
        return $this->query("insert into orders (customer_id, invoice_no, order_date, order_status) 
                           values('$user_id', '$invoice', NOW(), '$status')");
    }

    //Method to add payment
    function insertpayment($amt, $user_id, $order_id,$cc){
        return $this->query("insert into payment(amt, customer_id, order_id,currency, payment_date) values('$amt', '$user_id', '$order_id','$cc', NOW())");
    }

    //Method to add order details
    function insert_order_details ($order_id, $product_id, $qty){
        return $this->query("insert into orderdetails(order_id, product_id, qty) values ('$order_id', '$product_id', '$qty')");
    }

    //Method to get recent order
    function recentOrder(){
        return $this->fetchOne("select MAX(order_id) as recent from orders");
    }

    //Method to get orders
    function getOrder($ord_id){
        return $this->fetchOne("select c.customer_name, o.order_id, o.invoice_no, o.order_date, o.order_status
                              from customers AS c JOIN orders AS o ON c.customer_id = o.customer_id AND o.order_id = '$ord_id'");
    }

    //Method to get order details
    function getOrderDetails($ord_id){
        return $this->fetchOne("select p.product_title, p.product_price, ord.qty * p.product_price from 
                             products AS p JOIN orderdetails AS ord ON p.product_id = ord.product_id AND ord.order_id ='$ord_id'");
    }

    //Method to get total Amount in the cart
    function getCartItemsAmount($ip_address){
        return $this->fetchOne("select sum(product_price * qty) as amount from products as p JOIN cart as c
                            ON p.product_id = c.p_id and c.ip_add = '$ip_address'");
		
	}

    //Method to delete all items in the cart after payment
    function cart_whole_delete($user_id){
        return $this->query("delete from cart where c_id ='$user_id'");
    }

    //Method to select all customer orders
    function select_all_orders(){
        return $this->fetch("select * from orders");
    }

    //method to select on customer 
    function select_one_customer($id){
        return $this->fetchOne("select * from customer where customer_id='$id'");
    }

    //method to select all payments
    function select_all_payment(){
        return $this->fetch("select * from payment");
    }

    
}


?>