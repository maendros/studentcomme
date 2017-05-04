<?php 
include("includes/db.php"); 

if(isset($_GET['edit_cat'])){

	$cat_id = $_GET['edit_cat']; 



	$get_pro=$con->prepare("select * from categories where category_id=:cat_id");
	$get_pro->execute(array(':cat_id' => $cat_id ));
	$run_cut=$get_pro->fetch();// find categories
	$cat_id = $run_cut['category_id'];// get the fields
	$cat_title = $run_cut['title'];




}


?>
<form action="" method="post" style="padding:80px;">

<b>Επεξεργασία κατηγορίας:</b>
<input type="text" name="new_cat" value="<?php echo $cat_title;?>"/> 
<input type="submit" name="update_cat" value="Update Category" /> 

</form>

<?php 


	if(isset($_POST['update_cat'])){
	
	$update_id = $cat_id;
	
	$new_cat = $_POST['new_cat'];
	
// update them
	$update_cat=$con->prepare("UPDATE   categories SET title=:new_cat  WHERE category_id=:update_id");

    $update_cat->execute( array(':new_cat' => $new_cat, ':update_id' => $update_id));


	
		if($update_cat){
		
			echo "<script>alert('Η Κατηγορία επεξεργάστηκε!')</script>";
			echo "<script>window.open('index.php?view_cats','_self')</script>";
		}
	}

?>