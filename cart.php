<!DOCTYPE html>

<?php
ob_start();
 session_start();


include("functions/functions.php"); 
include("header.php");?>
			<div id="shopping-cart">
				<span style="float:none;font-size: 18px;padding: 5px;">			
					<?php 
					if(isset($_SESSION['customer_email'])){
					echo "<b>Καλωσήρθατε:</b>" . $_SESSION['customer_email']  ;
					}
					else {
					echo "<b>Welcome Guest:</b>";
					} 
					?> </span><span style="float:right;font-size: 18px;padding: 5px;">	<?php 
				if (!isset($_SESSION['customer_email'])) {
					echo "<a href='checkout.php' class='btn btn-primary' role='button'> Συνδεθείτε</a>";
				}else{// he can connect here  

					echo "<a href='logout.php' class='btn btn-primary' role='button'> Αποσυνδεθείτε</a>";	

				 
				}
				?></span>
			</div>	
		<main >
			<aside >
				<div class="sidebar-title">Κατηγορίες</div>

				<ul id="side-list">
				<?php getCategories(); ?>
				</ul>
				<div class="sidebar-title">Μάρκες</div>
				<ul id="side-list">
				<?php getBrands(); ?>
				</ul>
			</aside>
			<?php cart(); ?>
			<section id="content-area" class="container-fluid">
				    <div class="row">
        <div class="col-sm-12 col-md-10 col-md-offset-1">
            <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Προιόν</th>                     
                        <th class="text-center">Τιμή</th>
                        <th>Ποσότητα</th>
                        <th></th>
                        <th>Διαγραφή</th>
                    </tr>
                </thead>
                <?php 
                		// tacking 2 totals 
    					 $total=0; // 1 for everything
    					 $current=0;// 1 per item
    				
					$ip = getIp(); 
					 
					$sel_price=$con->prepare("select * from cart where ip_add=:ipadress"); 
					$sel_price->execute( array(':ipadress' => $ip ));// find all items stores in cart based on ip selected
					$prod_price=$sel_price->fetchAll(PDO::FETCH_ASSOC);
					
						foreach ($prod_price as $p_price ) {
							$pro_id = $p_price['prod_id'];             
							$_SESSION['qty']=$p_price['quantity'];// get id and quantity from cart
							$pro_price=$con->prepare("select * from products where product_id=:pro_id"); 
							$pro_price->execute( array(':pro_id' => $pro_id )); // select that product now from the product table
							$run_pro_price=$pro_price->fetchAll(PDO::FETCH_ASSOC);// fetch
							foreach ($run_pro_price as $pp_price ) {
								
									$product_price = array($pp_price['price']); 

									$product_title = $pp_price['title'];
																			// store price image title in new variables
									$product_image = $pp_price['image']; 
									
									$single_price = $pp_price['price'];
									
									$values = array_sum($product_price);
									
									 $total +=$values; 
									 
									
										
										$_SESSION['qty']=1; // set quantity so it can appear like that in the input box

										// and now for every product in cart  generate the info

						?>
				<tbody>
                    <tr>
                        <td class='col-sm-8 col-md-6'>
                        <div class='media'>
                            <a class='thumbnail pull-left' href='admin/product_images/<?php echo $product_image; ?>'> <img class='media-object' src='admin/product_images/<?php echo $product_image; ?>' style='width: 72px; height: 72px;''> </a>
                            <div class='media-body'>
                                <h4 class='media-heading'><a href='#'><?php echo $product_title; ?></a></h4>
                            
                                
                            </div>
                        </div></td>
                        
                        <td class='col-sm-1 col-md-1 text-center'><strong>
                       <?php echo $single_price; // its price   ?></strong></td> 
                    
                        <td class='col-sm-1 col-md-1' style='text-align: center;'>
	                  		 <?php 
							if(isset($_POST['update_cart'])){ // if the user wants to edit the quantity
						
								$qty =$_POST[$pro_id]; // get the number based on id

								$run_qty = $con->prepare("UPDATE cart SET quantity = :quantity where prod_id=:pro_id");
								$run_qty->execute(array(':quantity' => $qty,":pro_id"=>$pro_id )); // update the quantity in database 
															

								
								$_SESSION['qty']=$qty; // update the session so it can apperar like that
								
								 
								$values = $values*$qty;// update the singular value of avery item based on quantity
							
								
								
								
							}
							?>
                        <input type='number' class='form-control' name='<?php  echo $pro_id; //id so we can track it ?>' value="<?php echo $_SESSION['qty']; // quantity shown and tracked ?>"/></td>
  						   <td><button type='submit' name='update_cart' class='btn btn-primary' value="<?php echo $pro_id;?>">
                            Επεξεργασία <span class='glyphicon glyphicon-refresh'></span>
                            </button>
                          </td>
                           <?php 
							if(isset($_POST['remove_cart'])){// remove an item
						
								$remove_id =$_POST['remove_cart']; 

								$remove=$con->prepare("DELETE FROM cart where prod_id=:remove_id");//based on id tracked
								$remove->execute(array(":remove_id"=>$remove_id));

								if($remove){
			
												header('Location: cart.php' ,true,  301 ); // reload page
									                ob_end_flush();
									                exit;
												
								}
								
							
							}
							?>
                              <td><button type='submit' name='remove_cart' class='btn btn-danger' value="<?php echo $pro_id;// tracking id?>">
                            Διαγραφή <span class='glyphicon glyphicon-remove'></span>
                          		  </button>
                          		</td>
                       
                       
                       
                     
                      
                    </tr>
                    
                   
                    <tr>
                        <td>   </td>
                        <td>   </td>
                        <td>   </td>
                        <td>   </td>
                        <td>   </td>
                    </tr>

                </tbody>
					<?php 
					
					

				
			
				$current+=$values;  // adding the values of each item in  a variable
				$total=$current; // and then giving them to the total
				$_SESSION['total']=$total;// give the total to a session so we can track it for more pages
			

				}
			

				} 	 

					if(total_items()==0){ // if total items in cart is 0   make total price 0 as well
							$_SESSION['total']=0;
					}

					
					
						
					

				?>
							
					<tr>
						<td></td>
						
						
					 <td><h5>Σύνολο </h5></td><td></td>
                        <td class='text-right'><h5><strong>€ <?php echo  $_SESSION['total']; // show total price?> </strong></h5></td>
                    </tr>		
					<tr>
                        <td>   </td>
                        <td>   </td>

                  
                        <td><a href='checkout.php'><button type='button' class='btn btn-success'>
                            Checkout <span class='glyphicon glyphicon-play'></span>
                        </button></a></td>
                        <td><a href='index.php'><button type='button' name='continue' class='btn btn-default'>
                            Continue Shopping<span class='glyphicon glyphicon-shopping-cart'></span> 
                        </button></a></td>
                        <td>   </td>
                    </tr>
				
            </table>
        </form>



        </div>
    </div>
			

			</section>
	<?php include("footer.php"); ?>