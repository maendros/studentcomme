<?php 
session_start(); 
   require __DIR__ . '/vendor/autoload.php';
?>

<!DOCTYPE html>


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

			$message = "<!DOCTYPE html><body>
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
				</body>
			</html>
			
			";
				
$sender_email="studentcomme@gmail.com";
    $from = new SendGrid\Email(null, $sender_email);
$subject = "Λεπτομέρειες Πληρωμής";
$to = new SendGrid\Email(null, $c_email);
$content = new SendGrid\Content("text/html", $message );
$mail = new SendGrid\Mail($from, $subject, $to, $content);

$apiKey = getenv('SENDGRID_API_KEY');
$sg = new \SendGrid($apiKey);


$response = $sg->client->mail()->send()->post($mail);
//echo $response->statusCode();
//echo $response->headers();
//echo $response->body();
		

			
		

			
		
			
						}
		}
				echo "<h2>Welcome:" . $_SESSION['customer_email']. "<br>" . "Η πληρωμή σας ήταν επιτυχής! </h2>";
		echo "<a href='https://studentcomme.herokuapp.com/customer/my_account.php'>Πίσω στο λογαριασμό σας</a>";
		//removing the products from cart
				$empty_cart=$con->prepare("DELETE FROM cart");
		$empty_cart->execute();

?>

</body>
</html>







