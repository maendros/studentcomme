<!DOCTYPE>

<?php 

include("includes/db.php");

if(isset($_GET['edit_pro'])){

	$get_id = $_GET['edit_pro']; 
	
	
	$get_pro=$con->prepare("select * from products where product_id=:get_id");
	$get_pro->execute(array(':get_id' => $get_id ));// get product

	
	$i = 0;
	
	foreach ($get_pro as $row_pro) {
		$pro_id=$row_pro['product_id'];
		$pro_category=$row_pro['category'];
		$pro_title=$row_pro['title'];
		$pro_price=$row_pro['price'];// get the data
		$pro_image=$row_pro['image'];
		$pro_brand=$row_pro['brand'];
		$pro_keywords=$row_pro['keywords'];
		$pro_desc=$row_pro['description'];

		$get_cat=$con->prepare("select * from categories where category_id=:get_cat");
		$get_cat->execute(array(':get_cat' => $pro_category ));// find its category
		$row_cat=$get_cat->fetch();
		$category_title = $row_cat['title'];


		$get_brand=$con->prepare("select * from brands where brand_id=:get_brand");
		$get_brand->execute(array(':get_brand' => $pro_brand ));// and its brand
		$row_brand=$get_brand->fetch();
		$brand_title = $row_brand['title'];
		
//show them so each can be updatet
}
?>
<html>
	<head>
		<title>Ενημέρωση Προιόντος</title> 
		
<script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>
<script>
        tinymce.init({selector:'textarea'});
</script>
	</head>
	
<body bgcolor="skyblue">


	<form action="" method="post" enctype="multipart/form-data"> 
		
		<table align="center" width="795" border="2" bgcolor="#187eae">
			
			<tr align="center">
				<td colspan="7"><h2>Επεξεργασία  Προιόντος</h2></td>
			</tr>
			
			<tr>
				<td align="right"><b>Τίτλος Προιόντος:</b></td>
				<td><input type="text" name="product_title" size="60" value="<?php echo $pro_title;?>"/></td>
			</tr>
			
			<tr>
				<td align="right"><b>Κατηγορία Προιόντος:</b></td>
				<td>
				<select name="product_cat" >
					<option><?php echo $category_title; ?></option>
					<?php 


		$get_cats=$con->prepare("select * from categories");
		$get_cats->execute();
		foreach ($get_cats as $row_cats) {
			$cat_id=$row_cats['category_id'];// find categories
			$cat_title=$row_cats['title'];
		
		
			echo "<option value='$cat_id'>$cat_title</option>";
	
	
	}
					
					?>
				</select>
				
				
				</td>
			</tr>
			
			<tr>
				<td align="right"><b>Product Brand:</b></td>
				<td>
				<select name="product_brand" >
					<option><?php echo $brand_title; ?></option>
					<?php 

		$get_brands=$con->prepare("select * from brands");
		$get_brands->execute();
		foreach ($get_brands as $row_brands) {
			$brand_id=$row_brands['brand_id'];
			$brand_title=$row_brands['title'];
			echo "<option value='$brand_id'>$brand_title</option>";
	
	
		}
					
					?>
				</select>
				
				
				</td>
			</tr>
			
			<tr>
				<td align="right"><b>Product Image:</b></td>
				<td><input type="file" name="product_image" /><img src="product_images/<?php echo $pro_image; ?>" width="60" height="60"/></td>
			</tr>
			
			<tr>
				<td align="right"><b>Product Price:</b></td>
				<td><input type="text" name="product_price" value="<?php echo $pro_price;?>"/></td>
			</tr>
			
			<tr>
				<td align="right"><b>Product Description:</b></td>
				<td><textarea name="product_desc" cols="20" rows="10"><?php echo $pro_desc;?></textarea></td>
			</tr>
			
			<tr>
				<td align="right"><b>Product Keywords:</b></td>
				<td><input type="text" name="product_keywords" size="50" value="<?php echo $pro_keywords;?>"/></td>
			</tr>
			
			<tr align="center">
				<td colspan="7"><input type="submit" name="update_product" value="Update Product"/></td>
			</tr>
		
		</table>
	
	
	</form>


</body> 
</html>
<?php 

	if(isset($_POST['update_product'])){
	
		//getting the text data from the fields
		
		$update_id = $pro_id;
		
		$product_title = $_POST['product_title'];
		$product_cat= $_POST['product_cat'];
		$product_brand = $_POST['product_brand'];
		$product_price = $_POST['product_price'];
		$product_desc = $_POST['product_desc'];
		$product_keywords = $_POST['product_keywords'];
	
		//getting the image from the field
		$product_image = $_FILES['product_image']['name'];
		$product_image_tmp = $_FILES['product_image']['tmp_name'];
		
		move_uploaded_file($product_image_tmp,"product_images/$product_image");
	
		$update_product=$con->prepare("UPDATE   products SET category=:category,brand=:brand,title=:title,price=:price,description=:description, image=:image,keywords=:keywords where product_id=:update_id");

        $update_product->execute( array(':category' => $product_cat, ':brand' => $product_brand,':title' => $product_title,':price' => $product_price,':description' => $product_desc,':image' => $product_image,
            ':keywords' => $product_keywords,':update_id' => $update_id ));


		 
		 
		 
		 if($update_product){
		 
			 echo "<script>alert('Το στοιχεία του προιόντος επεξεργάστηκαν !')</script>";
		 
			 echo "<script>window.open('index.php?view_products','_self')</script>";
		 
			 }
		}
}

?>












