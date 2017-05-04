<?php 
//connect to db
include("includes/db.php"); 
//getting user ip adress
function getIp() {
    $ip = $_SERVER['REMOTE_ADDR'];
 
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {// functions that finds ip
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
 
    return $ip;
}

 // getting the total added items
 
 function total_items(){
 global $con; 
	if(isset($_GET['add_cart'])){//
	
		
	
		$ip = getIp(); 
		
		
		$get_items=$con->prepare("select * from cart where ip_add=:ip"); 
		$get_items->execute(array("ip"=>$ip));
		$count_items =$get_items->rowCount();

		
		}
		
		else {
		
		$ip = getIp(); 
		
		$get_items=$con->prepare("select * from cart where ip_add=:ip"); 
		$get_items->execute(array("ip"=>$ip));
		$count_items =$get_items->rowCount();
		
		}
	
	return $count_items;
	}
  
// Getting the total price of the items in the cart 
	
	function total_price(){
	
		$total = 0;
		
		global $con; 
		
		$ip = getIp(); 
		
		
		
		$get_the_id_from_cart=$con->prepare("select * from cart where ip_add=:ip"); 
		$get_the_id_from_cart->execute(array(':ip' => $ip));
		
		while($p_price=$get_the_id_from_cart->fetch(PDO::FETCH_ASSOC)){
			
			$pro_id = $p_price['prod_id']; 
			
			
			$get_the_product_id=$con->prepare("select * from products where product_id=:pro_id"); 
			$get_the_product_id->execute(array(':pro_id' => $pro_id));
			
			
			
			while ($prod_price = $get_the_product_id->fetch(PDO::FETCH_ASSOC)){
			
			$product_price = array($prod_price['price']);
			
			$values = array_sum($product_price);
			
			$total +=$values;
			
			}
		
		
		}
		
		echo "$" . $total;
		
	
	}









 // creating shopping cart 
 function cart(){

 	if(isset($_GET['add_cart'])){
 		global $con;

 		$ip=getIp();
 		$pro_id=$_GET['add_cart'];

 		$check_product="select * FROM cart where ip_add='$ip' AND prod_id='$pro_id'";
 		$run=$con->query($check_product); 
 		if ($run->rowCount() > 0) {// if there is one in cart for that ip show it 
 			echo "<span style='color:red;float:right;' class='alert alert-warning'>Είναι ήδη στην κάρτα</span>";
 		}else{
 		// get them inside the cart and give them 1 quantity
 		$stmt = $con->prepare("INSERT INTO cart(prod_id,ip_add,quantity) 
			VALUES(:prod_id,:ip_add,1)");  // 1 for quantity
		$stmt->execute(array(":prod_id"=>$pro_id,":ip_add"=>$ip));
			echo "<script>window.open('index.php','_self')</script>";
 			
 			
 		}

 		

 	}
 }



// get categories and generate them in html
function getCategories(){

	global $con;
	$query_cat="select * FROM categories";   
	$stm = $con->prepare($query_cat);
	$stm->execute();
	foreach ($stm as $row_categories) {
		$category_title=$row_categories['title'];
		$category_id=$row_categories['category_id'];
		echo "<li><a href='index.php?category=$category_id'>$category_title</a></li>";
			
	}

}
// select categories and generate them for form
function selectCategories(){

	global $con;
	$query_cat="select * FROM categories";   
	$stm = $con->prepare($query_cat);
	$stm->execute();
	foreach ($stm as $row_categories) {
		$category_title=$row_categories['title'];
		$category_id=$row_categories['category_id'];
		echo "<option value='$category_id'>$category_title</option>";
	}
	


}

// get brands and generate them in html

function getBrands(){

	global $con;
	$query_brand="select * FROM brands";
	$stm = $con->prepare($query_brand);
	$stm->execute();
	foreach ($stm as $row_brands) {
		$brand_id=$row_brands['brand_id'];
		$brand_title=$row_brands['title'];

	echo "<li><a href='index.php?brand=$brand_id'>$brand_title</a></li>";
	}

}
// select brands and generate them for form

function selectBrands(){

	global $con;
	$query_brand="select * FROM brands";
	$stm = $con->prepare($query_brand);
	$stm->execute();
	foreach ($stm as $row_brands) {
		$brand_id=$row_brands['brand_id'];
		$brand_title=$row_brands['title'];

	echo "<option value='$brand_id'>$brand_title</option>";
	}


} 

// show products
function displayProducts(){

	if(!isset($_GET['category'])){
		if(!isset($_GET['brand'])){// if there is nothing set
	global $con;
	$display_pro="select * from products order by RAND() LIMIT 0,12";// show at least 12
	$run=$con->query($display_pro);

	while($row_pro=$run->fetch(PDO::FETCH_ASSOC)){ // fetch them 
		$pro_id=$row_pro['product_id'];
		$pro_category=$row_pro['category'];
		$pro_title=$row_pro['title'];// get the data for each product
		$pro_price=$row_pro['price'];
		$pro_image=$row_pro['image'];
		$pro_brand=$row_pro['brand'];
		$pro_keywords=$row_pro['keywords'];
		$pro_desc=$row_pro['description'];

// generate each of them
			echo "
        <div class='col-md-4 column productbox'>
   			 <img src='admin/product_images/$pro_image' width='100%' alt='$pro_keywords'>
    		 <div class='producttitle'>$pro_title</div>
    		 	<div class='pricetext'> € $pro_price </div>
   		     <div class='productprice'>
   		         <div class='pull-left'>
   		 			<a href='index.php?add_cart=$pro_id'><button class='btn btn-default' title='Προσθήκη στο καλάθι'>
        					<span class='fa fa-shopping-cart'></span>
        				</button></a>
   		 	    </div>
   		 	 	<div class='pull-right'>
   		 			<a href='details.php?pro_id=$pro_id' class='btn btn-info btn-sm' role='button'>Λεπτομέρειες</a>
   		 	    </div>

   		 	
   		     </div>
		</div>

        ";
		}
	 }
  }
}
function displayProduct($id){
	global $con;

	$find_id=$con->prepare("select * from products where product_id=$id");
	$find_id->execute();// get the product based on id of url
	foreach ($find_id as $row_pro) {
		$pro_id=$row_pro['product_id'];
		$pro_category=$row_pro['category'];
		$pro_title=$row_pro['title'];
		$pro_price=$row_pro['price'];// get its fields
		$pro_image=$row_pro['image'];
		$pro_brand=$row_pro['brand'];
		$pro_keywords=$row_pro['keywords'];
		$pro_desc=$row_pro['description'];
		//generate each of the fields
		echo "
		<div class='container'>
			 <div class='content-wrapper'>	
				<div class='item-container'>	
					<div class='container'>	
							<div class='col-md-12'>
								<div id='product_box' class='product col-md-3 service-image-left'>
			                    
									
										<img id='item-display' src='admin/product_images/$pro_image' alt='$pro_keywords'></img>
									
								</div>
								
					
							</div>
								
							<div class='col-md-7'>
								<div class='product-title'>$pro_title <span class='product-price'>€ $pro_price</span></div>
								
							
								<hr>
								
								
								<hr>
								<div class='btn-group cart'>
									<button type='button' class='btn btn-default'>
										<a href='index.php'>Back</a> 
									</button>
								</div>
								<div class='btn-group cart'>
									<button type='button' class='btn btn-default'>
										<a href='index.php?add_cart=$pro_id'><span class='fa fa-shopping-cart'>  Προσθήκη στο καλάθι</span></a>
									</button>
								</div>
								

									<div class='container-fluid'>		
										<div class='col-md-12 product-info'>
												<ul id='myTab' class='nav nav-tabs nav_tabs'>
													
													<li class='active'><a href='#service-one' data-toggle='tab'>Περιγραφή</a></li>
											
													
												</ul>
												<div id='myTabContent' class='tab-content'>
														<div class='tab-pane fade in active' id='service-one'>
						 
														<div>
															$pro_desc
														</div>
										  
						</div>
			
				
				</div>

											<hr>
										</div>
									</div>

							</div>
						</div> 
					</div>
				</div>
			
		 </div>";
	}

}
// show product of each category
function displayProductsByCategory(){

  if(isset($_GET['category'])){
		$categ_id=$_GET['category'];
	    global $con;
		$display_pro="select * from products where category=$categ_id";
		$run=$con->query($display_pro);// find products with that category id
		if ($run->rowCount() == 0) {
			echo "Δεν υπάρχουν προιοντα σε αυτήν την κατηγορία";
		}

		while($row_pro= $run->fetch(PDO::FETCH_ASSOC)){ // fetch them 
			$pro_id=$row_pro['product_id'];
			$pro_category=$row_pro['category'];
			$pro_title=$row_pro['title'];
			$pro_price=$row_pro['price'];
			$pro_image=$row_pro['image'];//get the fields
			$pro_brand=$row_pro['brand'];
			$pro_keywords=$row_pro['keywords'];
			$pro_desc=$row_pro['description'];
			// show them

				echo "
<div class='col-md-4 column productbox'>
   			 <img src='admin/product_images/$pro_image' width='100%' alt='$pro_keywords'>
    		 <div class='producttitle'>$pro_title</div>
    		 	<div class='pricetext'> € $pro_price </div>
   		     <div class='productprice'>
   		         <div class='pull-left'>
   		 			<a href='index.php?add_cart=$pro_id'><button class='btn btn-default' title='Προσθήκη στο καλάθι'>
        					<span class='fa fa-shopping-cart'></span>
        				</button></a>
   		 	    </div>
   		 	 	<div class='pull-right'>
   		 			<a href='details.php?pro_id=$pro_id' class='btn btn-info btn-sm' role='button'>Λεπτομέρειες</a>
   		 	    </div>

   		 	
   		     </div>
		</div>
";
			}
		 }
	  
}
// show product of each brand
function displayProductsByBrand(){

	if(isset($_GET['brand'])){
		$brand_id=$_GET['brand'];
	global $con;
	$display_pro="select * from products where brand=$brand_id";
	$run=$con->query($display_pro);// find products with that brand id
	if ($run->rowCount() == 0) {
		echo "Δεν υπάρχουν προιοντα σε αυτήν την Mάρκα";
	}

	while($row_pro= $run->fetch(PDO::FETCH_ASSOC)){ // fetch them 
		$pro_id=$row_pro['product_id'];
		$pro_category=$row_pro['category'];
		$pro_title=$row_pro['title'];
		$pro_price=$row_pro['price'];//get the fields
		$pro_image=$row_pro['image'];
		$pro_brand=$row_pro['brand'];
		$pro_keywords=$row_pro['keywords'];
		$pro_desc=$row_pro['description'];

			// show them
			echo "
<div class='col-md-4 column productbox'>
   			 <img src='admin/product_images/$pro_image' width='100%' alt='$pro_keywords'>
    		 <div class='producttitle'>$pro_title</div>
    		 	<div class='pricetext'> € $pro_price </div>
   		     <div class='productprice'>
   		         <div class='pull-left'>
   		 			<a href='index.php?add_cart=$pro_id'><button class='btn btn-default' title='Προσθήκη στο καλάθι'>
        					<span class='fa fa-shopping-cart'></span>
        				</button></a>
   		 	    </div>
   		 	 	<div class='pull-right'>
   		 			<a href='details.php?pro_id=$pro_id' class='btn btn-info btn-sm' role='button'>Λεπτομέρειες</a>
   		 	    </div>

   		 	
   		     </div>
		</div>
";
		}
	 }
  
}
// function that show everything based on search
function displayQuery(){

	if(isset($_GET['search'])){
		$search_query="%".$_GET['user_query']."%";
		// user submits query we get them and use % needed to like in sql qeury
		
		global $con;
				$display_pro=$con->prepare("SELECT * from products where keywords LIKE :search_query OR title LIKE :search_query");
                                     //find if the word matches any in keywords
		 $display_pro->execute(array(':search_query' => $search_query)); 
	
		while($row_pro=$display_pro->fetch(PDO::FETCH_ASSOC)){ // fetch them 
			$pro_id=$row_pro['product_id'];
			$pro_category=$row_pro['category'];
			$pro_title=$row_pro['title'];
			$pro_price=$row_pro['price'];// get the fields
			$pro_image=$row_pro['image'];
			$pro_brand=$row_pro['brand'];
			$pro_keywords=$row_pro['keywords'];
			$pro_desc=$row_pro['description'];

			// show them
				echo "

<div class='col-md-4 column productbox'>
   			 <img src='admin/product_images/$pro_image' width='100%' alt='$pro_keywords'>
    		 <div class='producttitle'>$pro_title</div>
    		 	<div class='pricetext'> € $pro_price </div>
   		     <div class='productprice'>
   		         <div class='pull-left'>
   		 			<a href='index.php?add_cart=$pro_id'><button class='btn btn-default' title='Προσθήκη στο καλάθι'>
        					<span class='fa fa-shopping-cart'></span>
        				</button></a>
   		 	    </div>
   		 	 	<div class='pull-right'>
   		 			<a href='details.php?pro_id=$pro_id' class='btn btn-info btn-sm' role='button'>Λεπτομέρειες</a>
   		 	    </div>

   		 	
   		     </div>
		</div>";
			}
	 }
	  
}




 ?>
