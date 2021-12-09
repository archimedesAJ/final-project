<?php

session_start();
require('../Controllers/customer_controller.php');

if(isset($_POST['signup'])){

    $full_name = $_POST["full_name"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $country =  $_POST["country"];
    $city = $_POST["city"];
    $contact_number = $_POST["contact"];

    //before adding check whether the customer is already added

    $customerExist = select_customer_givenEmail_controller($email);
    if (!empty($customerExist)){
        $_SESSION['status'] = "This email already exist!";
        $_SESSION['status_code'] = "error";
        header("Location: ../Login-Register/register.php");
    }
    //else insert the customer
    $result = add_customer_controller($full_name, $email, $password,$country, $city, $contact_number);

    if($result === true){
        $_SESSION['status'] = "Sucessfully Registered!";
        $_SESSION['status_code'] = "success";
        
        header("Location: ../Login-Register/login.php");
    }else{
        $_SESSION['error'] = "Not successful!";
        $_SESSION['status_code'] = "error";
        header("Location: ../Login-Register/register.php");
       
    }
   
}

?>