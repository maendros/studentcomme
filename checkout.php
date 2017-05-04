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
					echo "<b>Καλωσήρθες:</b>" . $_SESSION['customer_email']  ;
					}
					else {
					echo "<b>Καλωσήρθες Guest:</b>";
					}
					?> </span><span style="float:right;font-size: 18px;padding: 5px;">	<mark>Συνολικά Αντικείμενα: <?php echo total_items(); ?>
					</mark><mark>Συνολική Τιμή: <?php 
					if((isset($_SESSION['total']))&&($_SESSION['total']>0)){
					
						echo $_SESSION['total'];
					}else{
						 total_price();
					} ?>  €  <a href="cart.php"><span class="fa fa-shopping-cart"></span></a></mark> <?php 
				if (!isset($_SESSION['customer_email'])) {
					echo "<a href='checkout.php' class='btn btn-primary' role='button'> Συνδεθείτε</a>";
				}else{

					echo "<a href='logout.php' class='btn btn-primary' role='button'> Αποσυνδεθείτε</a>";	

				 
				}
				?></span>
			</div>	
		<main >
			<aside >
				<div class="sidebar-title">Categories</div>

				<ul id="side-list">
				<?php getCategories(); ?>
				</ul>
				<div class="sidebar-title">Brands</div>
				<ul id="side-list">
				<?php getBrands(); ?>
				</ul>
			</aside>
			<?php cart(); ?>
			<section id="content-area" class="container-fluid">
				<?php 
				
				if(!isset($_SESSION['customer_email'])){// if u arent login
					include("customer_login.php");// have the from
				
				}else{
					include("payment.php"); // else move to payment
					}
				 ?>
				
			</section>
	<?php include("footer.php"); ?>