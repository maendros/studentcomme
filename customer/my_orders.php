<table width="795" align="center" bgcolor="pink"> 

	
	<tr align="center">
		<td colspan="6"><h2>Λεπτομέρειες της παραγγελίας σας: </h2></td>
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
	
	
	$get_order =$con->prepare("select * from orders");// take everything from orders
	$get_order->execute(); 
	
	$i = 0;
	$run_order=$get_order->fetchAll(); 
	foreach ($run_order as $row_order ) {// for every order
		
		$order_id = $row_order['order_id'];
		$qty = $row_order['qty'];
		$pro_id = $row_order['p_id'];
		$invoice_no = $row_order['invoice_no'];
		$order_date = $row_order['order_date'];
		$status = $row_order['status'];
		$i++;

		$get_pro =$con->prepare("select * from products where product_id=:p_id");// find it also in products
		$get_pro->execute(array(':p_id'=>$pro_id));// a
	
		$row_pro=$get_pro->fetch();

		$pro_image = $row_pro['image']; 
		$pro_title = $row_pro['title'];
	
		

	// echo info
	?>
	<tr align="center">
		<td><?php echo $i;?></td>
		<td>
		<?php echo $pro_title;?>
		<img src="../admin/product_images/<?php echo $pro_image;?>" width="50" height="50" />
		</td>
		<td><?php echo $qty;?></td>
		<td><?php echo $invoice_no;?></td>
		<td><?php echo $order_date;?></td>
		<td><?php echo $status;?></td>
	
	</tr>
	<?php } ?>
</table>