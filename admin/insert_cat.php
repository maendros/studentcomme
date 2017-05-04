
<form action="" method="post" style="padding:80px;">

<b>Insert New Category:</b>
<input type="text" name="new_cat" required/> 
<input type="submit" name="add_cat" value="Add Category" /> 

</form>

<?php 
include("includes/db.php"); 

	if(isset($_POST['add_cat'])){
	
	$new_cat = $_POST['new_cat'];
	
	$run_cat = $con->prepare("INSERT INTO categories(title) 
			VALUES(:new_cat)");  // insert categories
		$run_cat->execute(array(":new_cat"=>$new_cat));
	
	if($run_cat){
	
	echo "<script>alert('Εισήχθε νέα κατηγορία!')</script>";
	echo "<script>window.open('index.php?view_cats','_self')</script>";
	}
	}

?>