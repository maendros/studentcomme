  <div class="table-responsive" style="background: #fff;">
<table width="795" align="center" bgcolor="pink"> 

	
	<tr align="center">
		<td colspan="6"><h2>Πελάτες</h2></td>
	</tr>
	
	<tr align="center" bgcolor="skyblue">
		<th>S.N</th>
		<th>Όνομα</th>
		<th>Email</th>
		<th>Διαγραφή</th>
	</tr>
	<?php 
	include("includes/db.php");

	$i = 0;
	$get_c = $con->prepare("SELECT * FROM customers");
	$get_c->execute(); // fetch and show customers to admin
	foreach ($get_c as $row_c) {
		$c_id = $row_c['customer_id'];
		$c_name = $row_c['customer_name'];
		$c_email = $row_c['customer_email'];
	
		$i++;

	?>
	<tr align="center">
		<td><?php echo $i;?></td>
		<td><?php echo $c_name;?></td>
		<td><?php echo $c_email;?></td>
		<td><a href="delete_c.php?delete_c=<?php echo $c_id;?>" class="btn btn-danger" role="button">Διαγραφή</a></td>
	
	</tr>
	<?php } ?>




</table>
</div>