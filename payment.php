




<div>
<h2 align="center" style="padding:2px;">Πληρωμή με Paypal:</h2>

			<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" >
				<input type="hidden" name="business" value="sriniv_1293527277_biz@inbox.com">
			<!-- Specify a Buy Now button. -->
		  <input type="hidden" name="cmd" value="_cart"> 
		  <input type="hidden" name="upload" value="1">
<?php 
		include("includes/db.php"); 
	
	
		$i=0;// the counter is needed for paypal api 
	
		global $con; 
		$ip = getIp(); 
		$sel_from_cart=$con->prepare("select * from cart where ip_add=:ipadress"); 
		$sel_from_cart->execute( array(':ipadress' => $ip )); // get everything from cart based on ip
		$fetch_from_cart=$sel_from_cart->fetchAll(PDO::FETCH_ASSOC);
	?>	<?php
		
		foreach ($fetch_from_cart as $fetched ) { // for everything fetched
			$pro_id = $fetched['prod_id'];  // get id of product

			$sel_prod=$con->prepare("select * from products where product_id=:pro_id"); // find it in db
			$sel_prod->execute( array(':pro_id' => $pro_id ));
			$fetch_prod=$sel_prod->fetchAll(PDO::FETCH_ASSOC);// fetch them

			
			foreach ($fetch_prod as $product ) {// for every product

			

				$i++; // increment this counter

					$product_price = array($product['price']);//take price
					$product_name = $product['title'];// name

					$values = array_sum($product_price);
					
					
			
		

			// getting Quantity of the product 
			$run_qty=$con->prepare("select * from cart where prod_id=:pro_id"); // check how much quantity the user slected from cart
			$run_qty->execute( array(':pro_id' => $pro_id ));// for each of that product
			
			$row_qty = $run_qty->fetch();
		
			$qty = $row_qty['quantity'];// assign it here
		
			
		// pass the data for the pay pal api which required item_name_1 item_name_2 item_name_3 or amount_1 amount_2 and etc ....
			// and this is how the paypal api passed data while for each item added while also multiplying qty with price of each item
			
			?>
	
		 <input type="hidden" name="item_name_<?php echo $i; ?>" value="<?php echo $product_name; ?>">


		<input type="hidden" name="amount_<?php echo $i; ?>" value="<?php echo $values; ?>">
		<input type="hidden" name="quantity_<?php echo $i; ?>" value="<?php echo $qty; ?>">
	<?php
				
}
}
	?>	

	


		<input type="hidden" name="currency_code" value="EUR">
			<!--these are the return pages after purchase-->
			<input type="hidden" name="return" value="https://studentcomme.herokuapp.com/paypal_success.php"/>
		<input type="hidden" name="cancel_return" value="https://studentcomme.herokuapp.com/paypal_cancel.php"/>
			<input type="image" name="submit" border="0"
		src="paypal_button.png"
		alt="PayPal - The safer, easier way to pay online">
		<img alt="" border="0" width="1" height="1"
		src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" >
		</form>


	




	

</div>