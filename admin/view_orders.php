<table width="795" align="center" bgcolor="pink"> 

	
	<tr align="center">
		<td colspan="6"><h2>View all orders here</h2></td>
	</tr>
	
	<tr align="center" bgcolor="skyblue">
		<th>S.N</th>
		<th>Προιόν</th>
		<th>Ποσότητα</th>
		<th>Αριθμός Invoice</th>
		<th>Ημερομηνία παραγγελίας</th>
		<th>Status</th>
	</tr>
	<?php 
	include("includes/db.php");
	
$get_order =$con->prepare("select * from orders");
	$get_order->execute(); 
	
	$i = 0; // fetch and show orders to admin
	$run_order=$get_order->fetchAll(); 
	foreach ($run_order as $row_order ) {
		
		$order_id = $row_order['order_id'];
		$qty = $row_order['qty'];
		$pro_id = $row_order['p_id'];
		$c_id = $row_order['c_id'];
		$invoice_no = $row_order['invoice_no'];
		$order_date = $row_order['order_date'];
		$i++;
		
		$get_pro =$con->prepare("select * from products where product_id=:pro_id");
		$get_pro->execute(array(':pro_id'=>$pro_id)); // find product
		$row_pro=$get_pro->fetch();  
		
		$pro_image = $row_pro['image']; 
		$pro_title = $row_pro['title'];
		

		$get_c =$con->prepare("select * from customers where customer_id=:c_id"); // of each customer
		$get_c->execute(array(':c_id'=>$c_id));
		$row_c=$get_c->fetch();
		
		$c_email = $row_c['customer_email'];
	?>
	<tr align="center">
		<td><?php echo $i;?></td>
	
		<td>
		<?php echo $pro_title;?><br>
		<img src="product_images/<?php echo $pro_image;?>" width="50" height="50" />
		</td>
		<td><?php echo $qty;?></td>
		<td><?php echo $invoice_no;?></td>
		<td><?php echo $order_date;?></td>
		<td><a href="index.php?confirm_order=<?php echo $order_id; ?>">Ολοκληρώστε την παραγγελία</a></td>
	
	</tr>
	<?php } ?>
</table>

