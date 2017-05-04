<table width="795" align="center" bgcolor="pink"> 

	
	<tr align="center">
		<td colspan="6"><h2>Όλες οι Πληρωμές</h2></td>
	</tr>
	
	<tr align="center" bgcolor="skyblue">
		<th>S.N</th>
		<th>Email Πελάτη</th>
		<th>Προιόν</th>
		<th>Πληρωθέν ποσό</th>
		<th>ID Συναλλαγής</th>
		<th>Ημερομηνία πληρωμής</th>
	</tr>
	<?php 
	include("includes/db.php");

	$get_payment =$con->prepare("SELECT * from payments");
	$get_payment->execute(); 
	
	$i = 0;  // fetch and show payments to admin
	
	foreach ($get_payment as $row_payment ) { // for every payment row
		
		$amount = $row_payment['amount'];
		$trx_id = $row_payment['trx_id']; 
		$payment_date = $row_payment['payment_date'];
		$pro_id = $row_payment['product_id'];
		$c_id = $row_payment['customer_id'];
		
		$i++;
		 
		$get_pro =$con->prepare("select * from products where product_id=:pro_id");
		$get_pro->execute(array(':pro_id'=>$pro_id));// find product
		$row_pro=$get_pro->fetch();  
		
		$pro_image = $row_pro['image']; 
		$pro_title = $row_pro['title'];

		$get_c =$con->prepare("select * from customers where customer_id=:c_id");// of each customer
		$get_c->execute(array(':c_id'=>$c_id));
		$row_c=$get_c->fetch();    
		
		$c_email = $row_c['customer_email'];
	
	?>
	<tr align="center">
		<td><?php echo $i;?></td>
		<td><?php echo $c_email; ?></td>
		<td>
		<?php echo $pro_title;?><br>
		<img src="product_images/<?php echo $pro_image;?>" width="50" height="50" />
		</td>
		<td><?php echo $amount;?></td>
		<td><?php echo $trx_id;?></td>
		<td><?php echo $payment_date;?></td>
	
	</tr>
	<?php } ?>
</table>