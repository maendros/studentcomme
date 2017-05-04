<?php 

include("includes/db.php");
		$empty_cart=$con->prepare("DELETE FROM cart");// empty cart
		$empty_cart->execute();
 ?>