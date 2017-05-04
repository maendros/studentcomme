<?php 
  if(!isset($_SESSION)){ 
        session_start(); 
    } 
if(!isset($_SESSION['user_email'])){
	
	echo "<script>window.open('login.php?not_admin=You are not an Admin!','_self')</script>";
}
else {

?>
  <div class="table-responsive" style="background: #fff;">
<table width="750" align="center" > 

	
	<tr align="center">
		<td colspan="6"><h2>View All Products Here</h2></td>
	</tr>
	
	<tr align="center" bgcolor="skyblue">
		<th>S.N</th>
		<th>Τίτλος</th>
		<th>Εικόνα</th>
		<th>Τιμή</th>
		<th>Επεξεργασία</th>
		<th>Διαγραφη</th>
	</tr>
	<?php 
	include("includes/db.php");
	$i = 0;
	$get_pro=$con->prepare("select * from products");
	$get_pro->execute();
	foreach ($get_pro as $row_pro) {
		$pro_id=$row_pro['product_id'];
		$pro_title=$row_pro['title'];
		$pro_price=$row_pro['price'];// fetch and show products to admin
		$pro_image=$row_pro['image'];
		$i++;

	?>
	<tr align="center">
		<td><?php echo $i;?></td>
		<td><?php echo $pro_title;?></td>
		<td><img src="product_images/<?php echo $pro_image;?>" width="60" height="60"/></td>
		<td><?php echo $pro_price;?></td>
		<td><a href="index.php?edit_pro=<?php echo $pro_id; ?>" class="btn btn-info" role="button">Επεξεργασία </a></td>
		<td><a href="delete_pro.php?delete_pro=<?php echo $pro_id;?>" class="btn btn-danger" role="button">Διαγραφή</a></td>
	
	</tr>
	<?php } ?>
</table>
</div>

<?php } ?>