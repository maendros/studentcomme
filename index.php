<!DOCTYPE html>
<?php 

		
session_start();

include("functions/functions.php"); 
include("header.php");?>

			<div id="shopping-cart">
				<span style="float:none;font-size: 18px;padding: 5px;">			
					<?php 
					if(isset($_SESSION['customer_email'])){
					echo "<b>Καλωσήρθες:</b>" . $_SESSION['customer_email']  ;// welcome user if he is logged in 
					}
					else {
					echo "<b>Καλωσήρθες Guest:</b>"; // or welcome guess
					}
					?> </span><span style="float:right;font-size: 18px;padding: 5px;">	<mark>Συνολικά Αντικείμενα: <?php echo total_items(); // show all items based on  a function from function/functions.php file?>
					</mark><mark>Συνολική Τιμή: <?php 
					if((isset($_SESSION['total']))&&($_SESSION['total']>0)){
						// session total is set and its more than 0 echo it
						echo $_SESSION['total'];
					}else{
						 total_price(); // else echo total price  from function/functions.php file. 
					} ?>  €  <a href="cart.php"><span class="fa fa-shopping-cart"></span></a></mark> <?php 
				if (!isset($_SESSION['customer_email'])) { //based on login or not
					echo "<a href='products.php' class='btn btn-primary' role='button'> Συνδεθείτε</a>";// logint
				}else{

					echo "<a href='logout.php' class='btn btn-primary' role='button'> Αποσυνδεθείτε</a>";	// or logout

				 
				}
				?></span>
			</div>		

		<main >
			<aside >
				<div class="sidebar-title">Κατηγορίες</div>

				<ul id="side-list">
				<?php getCategories(); //get categorions from function/functions.php file?>
				</ul>
				<div class="sidebar-title">Μάρκες</div>
				<ul id="side-list">
				<?php getBrands(); // get brands from  function/functions.php file?>
				</ul>
			</aside>
			<?php cart(); // get cart from function/functions.php file?>

			<section id="content-area" class="container-fluid">
				<div class"row">
				<?php displayProducts(); 
					  displayProductsByCategory(); // display everything from function/functions.php file
					  displayProductsByBrand();
				 ?>
				 </div>
			</section>
			
			<?php include("footer.php"); ?>

