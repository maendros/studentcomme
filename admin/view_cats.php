
<table width="795" align="center" bgcolor="pink"> 

	
	<tr align="center">
		<td colspan="6"><h2>Κατηγορίες</h2></td>
	</tr>
	
	<tr align="center" bgcolor="skyblue">
		<th>ID Κατηγορίας</th>
		<th>Τίτλος Κατηγορίας</th>
		<th>Επεξεργασία</th>
		<th>Διαγραφή</th>
	</tr>
	<?php 
	include("includes/db.php");

	$i = 0;
	$query_cat = $con->prepare("select * FROM categories");
	$query_cat->execute(); // fetch and show categories to admin
	foreach ($query_cat as $row_cat) {
		$cat_title=$row_cat['title'];
		$cat_id=$row_cat['category_id'];
		
			
		$i++;
	
	?>
	<tr align="center">
		<td><?php echo $i;?></td>
		<td><?php echo $cat_title;?></td>
		<td><a href="index.php?edit_cat=<?php echo $cat_id; ?>">Επεξεργασία</a></td>
		<td><a href="delete_cat.php?delete_cat=<?php echo $cat_id;?>">Διαγραφή</a></td>
	
	</tr>
	<?php } ?>




</table>