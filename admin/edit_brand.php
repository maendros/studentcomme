<?php 
include("includes/db.php"); 

if(isset($_GET['edit_brand'])){

	$brand_id = $_GET['edit_brand']; 
	
		$brand_id = $_GET['edit_brand']; 

//find brands

	$get_brand=$con->prepare("select * from brands where brand_id=:brand_id");
	$get_brand->execute(array(':brand_id' => $brand_id ));
	$run_brand=$get_brand->fetch();// find brands
	$brand_id = $run_brand['brand_id'];// get the fields
	$brand_title = $run_brand['title'];
}


?>
<form action="" method="post" style="padding:80px;">

<b>Επεξεργασία Μάρκας</b>
<input type="text" name="new_brand" value="<?php echo $brand_title;?>"/> 
<input type="submit" name="update_brand" value="Update Brand" /> 

</form>

<?php  

	if(isset($_POST['update_brand'])){
	

	$update_id = $brand_id;
	
	$new_brand = $_POST['new_brand'];
	//update them

	$update_brand=$con->prepare("UPDATE   brands SET title=:new_brand   WHERE brand_id=:update_id");

    $update_brand->execute( array(':new_brand' => $new_brand, ':update_id' => $update_id));


	
		if($update_brand){
		
			echo "<script>alert('Η Μάρκα επεξεργάστηκε!')</script>";
			echo "<script>window.open('index.php?view_cats','_self')</script>";
		}
	}

?>