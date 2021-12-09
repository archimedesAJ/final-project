<?php

require('../Models/customer_model.php');

//Addding customer
function add_customer_controller($full_name, $email, $password,$country, $city, $contact_number){
    //create an instance of the product class
    $customer_instance = new Customer();
    //call the method from the class
    return $customer_instance->add_customer($full_name, $email, $password,$country, $city, $contact_number);

}

//deleting customer
function delete_customer_controller($id){
    //create an instance of the product class
    $customer_instance = new Customer();
    //call the method from the class
    return $customer_instance->delete_one_customer($id);
    
}

//updating customer
function update_customer_controller($id, $full_name, $email, $password,$country, $city, $contact_number){
    //create an instance of the product class
    $customer_instance = new Customer();
    //call the method from the class
    return $customer_instance->update_one_customer($id, $full_name, $email, $password,$country, $city, $contact_number);
    
}

//select all customers
function select_all_customers_controller(){
    //create an instance of the product class
    $customer_instance = new Customer();
    //call the method from the class
    return $customer_instance->select_all_customers();
    
}

//selecting one customer
function select_one_customer_controller($id){
    //create an instance of the product class
    $customer_instance = new Customer();
    //call the method from the class
    return $customer_instance->select_one_customer($id);
    
}

// selecting customer based on email
function select_customer_givenEmail_controller($email){
    //create an instance of the product class
    $customer_instance = new Customer();
    //call the method from the class
    return $customer_instance->select_customer_givenEmail($email);
}

//updating cart customer id 
function updateCart_CID($session, $ip_add){
    $customer_instance = new Customer();
    return $customer_instance->updateCart_CID($session, $ip_add);
}
?>