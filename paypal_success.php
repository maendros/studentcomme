<?php 
session_start(); 
?>



<html>
	<head>
		<title>Επιτυχής Πληρωμή!</title>
	</head>

<body>
<?php 
		include("includes/db.php");
		include("functions/functions.php");
		
		//this is all for product details
		
		
		
		global $con; 
		$ip =getIp();
		$sel_price=$con->prepare("select * from cart where ip_add=:ipadress"); 
		$sel_price->execute( array(':ipadress' => $ip ));// check from cart based on ip
		$prod_price=$sel_price->fetchAll(PDO::FETCH_ASSOC);

		foreach ($prod_price as $p_price ) {
			
			$pro_id = $p_price['prod_id']; 
			$pro_price=$con->prepare("select * from products where product_id=:pro_id"); 
			$pro_price->execute( array(':pro_id' => $pro_id ));// find in product table and fetch it
			$run_pro_price=$pro_price->fetchAll(PDO::FETCH_ASSOC);
			
			foreach ($run_pro_price as $pp_price ) {
					$product_price = array($pp_price['price']);
						$product_id = $pp_price['product_id'];
				
					$product_name = $pp_price['title'];// take info
					$values = array_sum($product_price);
					
			
	

			// getting Quantity of the product 
			$run_qty=$con->prepare("select * from cart where prod_id=:pro_id"); 
			$run_qty->execute( array(':pro_id' => $pro_id ));
			
			$row_qty = $run_qty->fetch(); 
			
			$qty = $row_qty['quantity'];
			
		
			
			
			
			
			
			
			
			
			
			
			// this is about the customer
			$user_email = $_SESSION['customer_email'];
	
			$get_customer=$con->prepare("select * from customers where customer_email=:user_email"); 
			$get_customer->execute(array(':user_email' => $user_email));
			$row_customer = $get_customer->fetch(); 
				
			$c_id = $row_customer['customer_id'];
			$c_email = $row_customer['customer_email'];
			$c_name = $row_customer['customer_name']; 
			
			//details of payment from paypal
			
			$amount = $_GET['amt']; //amount
			
			$currency = $_GET['cc']; //currency
			
			$trx_id = $_GET['tx']; // transtaction code

			$invoice = mt_rand();// generate random number  for invoice
			$status="In Progress"; // status passed in database
		//inserting the payment to table payments

		$insert_payment=$con->prepare("INSERT INTO payments (amount,customer_id,product_id,trx_id,currency,payment_date) VALUES (:amount,:customer_id,:product_id,:trx_id,:currency,NOW()) ");//now() adds the current date to that field

        $insert_payment->execute( array(':amount' => $amount, ':customer_id' => $c_id,':product_id' => $product_id,':trx_id' => $trx_id,':currency' => $currency));
        // and the order to orders
		$insert_order=$con->prepare("INSERT INTO orders (p_id,c_id,qty,invoice_no,order_date,status) VALUES (:p_id,:c_id,:qty,:invoice_no,NOW(),:status) ");// same here with now

        $insert_order->execute(array(':p_id' => $pro_id, ':c_id' => $c_id,':qty' => $qty,':invoice_no' => $invoice,':status'=>$status));        
		
				

		$_SESSION['total']=0;

			$message = "<html> 
			<p>
			
			Γεια σας <b style='color:blue;'>$c_name</b> έχετε παραγγείλει προιόντα από τον ιστότοπο studentcomme, παρακαλώ βρείτε τις λεπτομέρειες της πληρωμής, η παραγγελία σας θα επεξεργαστεί σύντομα. Σας ευχαριστούμε!</p>
			
				<table width='600' align='center' bgcolor='#FFCC99' border='2'>
			
					<tr align='center'><td colspan='6'><h2>Λεπτομέρεις πληρωμής </h2></td></tr>
					
					<tr align='center'>
						<th><b>S.N</b></th>
						<th><b>όνομα προιόντος</b></th>
						<th><b>Ποσότητα</b></th>
						<th><b>Πληρωθέν πόσο</b></th>
						<th>Invoice No</th>
					</tr>
					
					<tr align='center'>
						<td>1</td>
						<td>$product_name</td>
						<td>$qty</td>
						<td>$amount €</td>
						<td>$invoice</td>
					</tr>
			
				</table>
				
				<h3>Παρακαλώ πηγαίνετε στο λογαριασμό σας και δείτε τις λεπτομέρειες της παραγγελίας σας!</h3>
				
				<h2> <a href='https://studentcomme.herokuapp.com/customer/my_account.php'>Πατήστε εδώ</a> να συνδεθείτε στο λογαριασμό σας</h2>
				
				<h3> Ευχαριστούμε για την παραγγελία </h3>
				
			</html>
			
			";
				
				
    date_default_timezone_set('Etc/UTC');
   require 'vendor/phpmailer/phpmailer/PHPMailerAutoload.php';
    //Create a new PHPMailer instance
    $mail = new PHPMailer;
    //Tell PHPMailer to use SMTP - requires a local mail server
    //Faster and safer than using mail()
$mail->IsSMTP();
$mail->Host = "smtp.gmail.com";
$mail->SMTPAuth = true;
$mail->SMTPSecure = "tls";
                       
$mail->Port = "587";
   
    //Use a fixed address in your own domain as the from address
    //**DO NOT** use the submitter's address here as it will be forgery
    //and will cause your messages to fail SPF checks

    $mail->setFrom('studentcomme@gmail.com', 'studemt');
    //Send the message to yourself, or whoever should receive contact for submissions
    $mail->addAddress($c_email);
    //Put the submitter's address in a reply-to header
    //This will fail if the address provided is invalid,
    //in which case we should ignore the whole request
    if ($mail->addReplyTo($_POST['email'], $_POST['name'])) {
        $mail->Subject = 'Λεπτομέρεις Πληρωμής';
        //Keep it simple - don't use HTML
        $mail->isHTML(true);
        //Build a simple message body
        $mail->Body = <<<EOT
Email: {$_POST['email']}
Name: {$_POST['name']}
Message: {$message}
EOT;
        //Send the message, check for errors
        if (!$mail->send()) {
            //The reason for failing to send will be in $mail->ErrorInfo
            //but you shouldn't display errors to users - process the error, log it on your server.
            echo $mail->ErrorInfo; 
            $msg = 'Sorry, something went wrong. Please try again later.';
        } else {
            $msg = 'Message sent! Thanks for contacting us.';
        }
    } else {
        $msg = 'Invalid email address, message ignored.';
    }
		
		

			
		

			
		
			
						}
		}
				echo "<h2>Welcome:" . $_SESSION['customer_email']. "<br>" . "Η πληρωμή σας ήταν επιτυχής!  Ελεξτε το spam folder σας</h2>";
		echo "<a href='https://studentcomme.herokuapp.com/customer/my_account.php'>Πίσω στο λογαριασμό σας</a>";
		//removing the products from cart
				$empty_cart=$con->prepare("DELETE FROM cart");
		$empty_cart->execute();

?>

</body>
</html>







