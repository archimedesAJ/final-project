<?php
require('../Models/product_model.php');

/*DETAILS ABOUT PRODUCTS */
//add product
function add_product_controller($productCat, $productTitle,$productPrice, $productDesc, $productImage, $productKeyword){
    //create an instance of the product class
    $product_instance = new Product();
    //call the method from the class
    return $product_instance->add_product($productCat, $productTitle,$productPrice, $productDesc, $productImage, $productKeyword);

}

//selecting products
function select_all_products_controller(){
    $product_instance = new Product();
    return $product_instance->select_all_products();
}

//deleting products
function delete_one_product_controller($id){
    $product_instance = new Product();
    return $product_instance->delete_one_product($id);
}

//updating products
function update_one_product_controller($product_id,$productCat, $productBrand, $productTitle,$productPrice, $productDesc, $productImage, $productKeyword){
    $product_instance = new Product();
    return $product_instance->update_one_product($product_id,$productCat, $productBrand, $productTitle,$productPrice, $productDesc, $productImage, $productKeyword);
}

//selecting one product
function select_one_product_controller($id){
    $product_instance = new Product();
    return $product_instance->select_one_product($id);
}

//search for particular product
function select_product_search_controller($keyword){
    $product_instance = new Product();
    return $product_instance->select_product_search($keyword);

}




/*DETAILS ABOUT CATEGORY*/
//adding category
function add_category_controller($cat_name){
    //create an instance of the product class
    $product_instance = new Product();
    //call the method from the class
    return $product_instance->add_category($cat_name);

}

//selecting all categories
function select_all_categories_controller(){
    //create an instance of the product class
    $product_instance = new Product();
    //call the method from the class
    return $product_instance->select_all_categories();
    
}

//selecting one category
function select_one_category_controller($id){
    //create an instance of the product class
    $product_instance = new Product();
    //call the method from the class
    return $product_instance->select_one_category($id);
    
}

//select category name
function select_one_category_name_category($id){
     //create an instance of the product class
     $product_instance = new Product();
     //call the method from the class
     return $product_instance->select_one_category_name($id);
}

//update category
function update_category_controller($cat_id, $cat_name){
    //create an instance of the product class
    $product_instance = new Product();
    //call the method from the class
    return $product_instance->update_one_category($cat_id, $cat_name);
    
}

//getting total item in cart
function getTotalItemsInCart(){
    $ip_add = getenv("REMOTE_ADDR");
    $product_instance = new Product();

    if (isset($_SESSION["user_id"])){
        $session = $_SESSION['user_id'];
        $response = $product_instance->getCartItemQty_Login($session);
    }
    $response = $product_instance->getCartItemQty($ip_add);

    if($response){
        $row = $product_instance->db_count();
        return ($row != null) ? $row : "0";
    }  else{
        return "0";
    }
}

//get cart itme
function get_Cartitem(){
    $product_array = array();

    //create an instance of the product class
    $product_instance = new Product();
  
    //run the search product method
    $ip_add = getenv("REMOTE_ADDR");

    if (isset($_SESSION["user_id"])){
        $session = $_SESSION['user_id'];
        $product_records = $product_instance->select_all_products_carts($session);
        
    }else{
        $product_records = $product_instance->select_all_products_cart($ip_add);
        
    }
    
  
    if ($product_records) {
  
        //loop to see if there is more than one result
        //fetch one at a time
        while($rec = $product_instance->db_fetch()){
            $product_array[] = $rec;

        }
           
      
    }
    return $product_array;
}


function getTotalItemAmountInCart(){
    $ip_add = getenv("REMOTE_ADDR");
    $product_instance = new Product();
    return $product_instance->getCartItemsAmount($ip_add);
}


?>