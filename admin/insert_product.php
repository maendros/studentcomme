<?php 

  if(!isset($_SESSION)){ 
        session_start(); 
    } 
if(!isset($_SESSION['user_email'])){
	
	echo "<script>window.open('login.php?not_admin=You are not an Admin!','_self')</script>";
}
else {

?>
<!DOCTYPE html>
<?php 
include("../functions/functions.php");
include("../includes/db.php"); ?>

<html>
<head>
	<title>Inserting product</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>
<script>
        tinymce.init({selector:'textarea'});
</script>
<body>


	
	<div class="container-fluid">


		<form class="form-horizontal" action="insert_product.php" method="post" enctype="multipart/form-data">


			<!-- Form Name -->
			<legend>Εισαγωγή προιόντος</legend>

			<!-- Button -->


			<!-- Text input-->
			<div class="form-group">
			  <label class="col-md-4 control-label" for="textinput">Όνομα Προιόντος</label>  
			  <div class="col-md-4">
			  <input id="textinput" name="product_title" type="text" placeholder="" class="form-control input-md" required />
			    
			  </div>
			</div>

			<!-- Textarea -->
			<div class="form-group">
			  <label class="col-md-4 control-label" for="textarea">Περιγραφή προιόντος</label>
			  <div class="col-md-4">                     
			    <textarea class="form-control" id="textarea" name="product_desc"></textarea>
			  </div>
			</div>

			<!-- Text input-->
			<div class="form-group">
			  <label class="col-md-4 control-label" for="textinput">Τιμή προιόντος</label>  
			  <div class="col-md-4">
			  <input id="textinput" name="product_price" type="text" placeholder="" class="form-control input-md" required />
			    
			  </div>
			</div>

			<!-- Select Basic -->
			<div class="form-group">
			  <label class="col-md-4 control-label" for="selectbasic">Επιλέξτε Κατηγορία</label>
			  <div class="col-md-4">
			    <select id="selectbasic" name="product_cat" class="form-control">
			    <option>Επιλέξτε Κατηγορία</option>
			    <?php selectCategories(); ?>
			    </select>
			  </div>
			</div>

						<!-- Select Basic -->
			<div class="form-group">
			  <label class="col-md-4 control-label" for="selectbasic">Επιλέξτε Μάρκα</label>
			  <div class="col-md-4">
			    <select id="selectbasic" name="product_brand" class="form-control">
			    <option>Επιλέξτε Μάρκα</option>
			    <?php  selectBrands(); ?>
			   
			    </select>
			  </div>
			</div>



			<!-- Text input-->
			<div class="form-group">
			  <label class="col-md-4 control-label" for="textinput">keyword</label>  
			  <div class="col-md-4">
			  <input id="textinput" name="product_keywords" type="text" placeholder="" class="form-control input-md" required />
			  <span class="help-block">example:alibaba</span>  
			  </div>
			</div>



			<!-- File Button --> 
			<div class="form-group">
			  <label class="col-md-4 control-label" for="filebutton">Ανέβασε Εικόνα</label>
			  <div class="col-md-4">
			    <input id="filebutton" name="product_image" class="input-file" type="file" required />
			  </div>
			</div>


			<div class="form-group">
			  <label class="col-md-4 control-label" for="singlebutton"></label>
			  <div class="col-md-4">
			    <button type="submit" id="singlebutton" name="insert_post" class="btn btn-success">Προσθήκη</button>
			  </div>
			</div>






		</form>

	</div>




</body>
</html>

<?php 

	if(isset($_POST['insert_post'])){
		

		global $con;
			// insert product
				$pro_title=$_POST['product_title'];
		$pro_cat=$_POST['product_cat'];
		$pro_desc=$_POST['product_desc'];
		$pro_brand=$_POST['product_brand'];
		$pro_keywords=$_POST['product_keywords'];// get all the input
		$pro_price=$_POST['product_price'];

		$pro_image=$_FILES['product_image']['name'];
		$pro_image_tmp=$_FILES['product_image']['tmp_name'];
	$stmt = $con->prepare("INSERT INTO products(category,brand,title,price,description,image,keywords) 
		VALUES(:pro_cat,:pro_brand,:pro_title,:pro_price,
		:pro_desc,:pro_image,:pro_keywords)");  // insert it

		 $stmt->bindParam(':pro_cat', $pro_cat);
		 $stmt->bindParam(':pro_brand', $pro_brand);
		 $stmt->bindParam(':pro_title', $pro_title);
		 $stmt->bindParam(':pro_price', $pro_price);
		 $stmt->bindParam(':pro_desc', $pro_desc);
		 $stmt->bindParam(':pro_image', $pro_image);
		 $stmt->bindParam(':pro_keywords', $pro_keywords);
				$stmt->execute();
			move_uploaded_file($pro_image_tmp, "product_images/$pro_image");// move the photos to that folder
    
        echo "<script>window.open('index.php','_self')</script>";
            echo "Product inserted";
		$stmt->close();



	}

 ?>

<?php  }?>

