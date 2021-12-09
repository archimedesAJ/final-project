<?php
	require('../Database/core.php');
	require('../Controllers/customer_controller.php');

	if(isset($_POST['signin'])){
		$email = $_POST['email'];
		$password = $_POST['password'];

       // select customer details with this email
        $result = select_customer_givenEmail_controller($email);
		
        // check if there exist details with this email
		if (empty($result)){
			$_SESSION['status'] = "Cannot find account with the email";
			$_SESSION['status_code'] = "error";
			header('Location: ../Login-Register/login.php');

			
		}
        //If there exist details, verify the password
		else{
			if (password_verify($password, $result['customer_pass'])){
				$_SESSION['user_id'] = $result['customer_id'];
				$_SESSION['email_addres'] = $result['customer_email'];
                $_SESSION['status'] = "Welcome,"." ". $result['customer_name'];
                $_SESSION['status_code'] = "success";
                header('Location: ../index.php');
                $session = $_SESSION['user_id'];
				//checking if the ip address is set
				if (isset($_SESSION['ip_add'])){
					$ip_add = $_SESSION['ip_add'];
					//update the cart with the customer id
					updateCart_CID($session, $ip_add);
					header('Location: ../View/checkout.php');
                    
				}
				else{
					header("Location: ../View/index.php");
                    
				}
				
			}
			else{
                $_SESSION['status'] = "Incorrect password";
				$_SESSION['status_code'] = "warning";
                header('Location: ../Login-Register/login.php');

			}
		}	

	}
	else{
		$_SESSION['status'] = "Input customer credentials first";
        $_SESSION['status_code'] = "error";
        header('Location: ../Login-Register/login.php');
        
	}
	
?>

		