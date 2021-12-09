<?php
session_start();
require('../Controllers/cart_controller.php');
// initialize a client url which we will use to send the reference to the paystack server for verification
$curl = curl_init();

// set options for the curl session insluding the url, headers, timeout, etc
curl_setopt_array($curl, array(
CURLOPT_URL => "https://api.paystack.co/transaction/verify/{$_GET['reference']}",
CURLOPT_RETURNTRANSFER => true,
CURLOPT_ENCODING => "",
CURLOPT_MAXREDIRS => 10,
CURLOPT_TIMEOUT => 30,
CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
CURLOPT_CUSTOMREQUEST => "GET",
CURLOPT_HTTPHEADER => array(
    "Authorization: Bearer sk_live_497a3a223893acf3ff8ecfd4dce1158b2fc9b088",
    "Cache-Control: no-cache",
),
));


// get the response and store
$response = curl_exec($curl);
// if there are any errors
$err = curl_error($curl);
// close the session
curl_close($curl);

// convert the response to PHP object
$decodedResponse = json_decode($response);

// check if the object has a status property and if its equal to 'success' ie. if verification was successful
if(isset($decodedResponse->data->status) && $decodedResponse->data->status === 'success'){
    // get form values
    $email = $_GET['email'];
    $amount = $_GET['amount'];
    $invoice = mt_rand(1000,10000);
    $reference = $_GET['reference'];
    $user_id = $_SESSION['user_id'];
    $ord_status = 'pending';

    // adding order
    $add_order = insert_order_controller($user_id, $invoice, $ord_status);

    // check if insertion was successful
   if ($add_order == true){
       $recent = recentOrder();
       

       $carts = get_Cartitem();
       foreach ($carts as $cart){
           $add_orderdetail = insert_order_details_controller($recent['recent'], $cart['p_id'], $cart['qty']);
       }
       $amt = getTotalItemAmountInCart();
       echo $amt['amount'];
       $insert_payment=insertpayment_controller($amt['amount'], $user_id, $recent['recent'],"GHS");

       if($insert_payment==true){
           $cart_delete = delete_cart_controller($user_id);

           if($cart_delete){
                $_SESSION['status'] = "Thank you for making a purchase! You will be contacted for the delivery";
			    $_SESSION['status_code'] = "success";
                header('Location: ../View/shoping-cart.php');

               //echo ("<script>alert('payment verified successfully'); window.location.href = '../view/cart.php';</script>");
           }
           else{
            $_SESSION['status'] = "Payment was Successful, Kindly Try again!";
            $_SESSION['status_code'] = "error";
            header('Location: ../View/payment.php');
            //echo ("<script>alert('payment not verified successfully'); window.location.href = '../view/cart.php';</script>");
           }
       }

   }
}

?>