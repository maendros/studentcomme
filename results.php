<!DOCTYPE html>
<?php 
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
					?> </span><span style="float:right;font-size: 18px;padding: 5px;">	<mark>Συνολικά Αντικείμενα: <?php total_items(); ?> </mark><mark>Συνολική Τιμή: <?php  total_price(); ?> €  <a href="cart.php"><span class="fa fa-shopping-cart"></span></a></mark> <?php 
				if (!isset($_SESSION['customer_email'])) {
					echo "<a href='checkout.php' class='btn btn-primary' role='button'> Συνδεθείτε</a>";
				}else{

					echo "<a href='logout.php' class='btn btn-primary' role='button'> Αποσυνδεθείτε</a>";	

				 
				}
				?></span>
			</div>	
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

			<section id="content-area" class="container-fluid">
				<div>
				<?php displayQuery();// δείχνει τα προιόντα based on query
					 
				 ?>
				 </div>
			</section>
	<?php include("footer.php"); ?>