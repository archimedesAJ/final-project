<?php
//namespace App;
require('../Database/connection.php');

// inherit the methods from Connection
class Product extends Connection{

    //function to add product
	function add_product($productCat, $productTitle, $productPrice, $productDesc, $productImage, $productKeyword){
		// return true or false
		return $this->query("insert into products(product_cat, product_title, product_price, product_desc, product_image, product_keywords) values('$productCat', '$productTitle','$productPrice', '$productDesc', '$productImage' , '$productKeyword')");
	}

    
	//function to update a product
	function update_one_product($product_id,$productCat, $productBrand, $productTitle,$productPrice, $productDesc, $productImage, $productKeyword){
        //return true or false
        return $this->query("update products set product_cat='$productCat', product_title=' $productTitle', product_price='$productPrice', product_desc='$productDesc', product_image='$productImage', product_keywords='$productKeyword' where product_id='$product_id'");
    }

    //function to select all product
	function select_all_products(){
		// return array or false
		return $this->fetch("select * from products");
	}

    //function to select one product
	function select_one_product($id){
		// return associative array or false
		return $this->fetchOne("select * from products where product_id='$id'");
	}

    //function to retrieve product
	function retrieve_product($id){
		return $this->fetch("select product_image, product_title, product_price from products where product_id='$id' ");
	}

    //function to search product
    function select_product_search($keyword){
        return $this->fetch("select * from products where product_keywords LIKE '%$keyword%'");
    }

    //method for deleting one product
    function delete_one_product($id){
        //return true or false
        return $this->query("delete from products where product_id = '$id'");
    }

	

    /*CATEGORY METHODS*/
    //methods for adding category
    function add_category($cat_name){
        //retrun true or false
        return $this->query("insert into categories(cat_name) values('$cat_name')");
    }

    //methods for selecting all categories
    function select_all_categories(){
        //return array or false
        return $this->fetch("select * from categories");
    }

    //methods for selecting one brand
    function select_one_category($id){
        //return associative array or false
        return $this->fetchOne("select * from categories where cat_id='$id'");
    }

    //method for selecting one category name
    function select_one_category_name($id){
        //return associative array or false
        return $this->fetchOne("select cat_name from categories where cat_id='$id'");
    }

    //method for update one category
    function update_one_category($cat_id, $cat_name){
        //return true or false
        return $this->query("update categories set cat_name='$cat_name' where cat_id='$cat_id'");
    }



    /*CART QTY METHODS */
    //function to getCartQty when user is not logged In
    function getCartItemQty($ip_add){
        return $this->query("select *  from cart where ip_add='$ip_add'");
    }

    //function to getCartQty when user is logged In
    function getCartItemQty_Login($session){
        return $this->query("select * count_item from cart where c_id='$session'");
    }


    /**Borrow cart select items */

    function select_all_products_cart($ip_add){
        return $this->query("select p.product_id, p.product_cat, p.product_price, p.product_title, 
        p.product_desc, p.product_image, p.product_keywords, c.p_id, c.ip_add, c.qty 
        from products AS p JOIN cart AS c ON p.product_id = c.p_id AND c.ip_add = '$ip_add'");
    }

    function select_all_products_carts($session){
        return $this->query("select p.product_id, p.product_cat, p.product_price, p.product_title, 
        p.product_desc, p.product_image, p.product_keywords, c.p_id, c.ip_add, c.qty 
        from products AS p JOIN cart AS c ON p.product_id = c.p_id AND c.c_id = '$session'");
    }

    function getCartItemsAmount($ip_address){
        return $this->fetchOne("select sum(product_price * qty) as amount from products as p JOIN cart as c
                            ON p.product_id = c.p_id and c.ip_add = '$ip_address'");
		
	}


}

?>