  <div class="table-responsive" style="background: #fff;">
<table width="795" align="center" bgcolor="pink"> 

	
	<tr align="center">
		<td colspan="6"><h2>Μάρκες</h2></td>
	</tr>
	
	<tr align="center" bgcolor="skyblue">
	<th>ID Μάρκας</th>
		<th>Τίτλος Μάρκας</th>
		<th>Επεξεργασία</th>
		<th>Διαγραφή</th>
	</tr>
	<?php 
	include("includes/db.php");

		$i = 0;
	$query_brand = $con->prepare("SELECT * FROM brands");
	$query_brand->execute(); // fetch and show brands to admin
	foreach ($query_brand as $row_brand) {
		$brand_title=$row_brand['title'];
		$brand_id=$row_brand['brand_id'];
		
			
		$i++;
	
	?>
	<tr align="center">
		<td><?php echo $i;?></td>
		<td><?php echo $brand_title;?></td>
		<td><a href="index.php?edit_brand=<?php echo $brand_id; ?>">Επεξεργασία</a></td>
		<td><a href="delete_brand.php?delete_brand=<?php echo $brand_id;?>">Διαγραφή</a></td>
	
	</tr>
	<?php } ?>




</table>
</div>