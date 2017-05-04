<html>

<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>E-Commerce site</title>
	<link rel="stylesheet"  href="styles/styles.css" media="all" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>	
	<div class="main-wrapper">
		<header>
			<a href="index.php"><img id="logo" src="images/ecommerce-logo.png"></a>
			<img id="banner" src="images/ecommerce-banner.jpg">
				
			
		</header>

		<nav class="menu-bar">
			<ul id="menu">
				<li><a href="index.php">Αρχική</a></li>
				<li><a href="customer/my_account.php">Λογαριασμός</a></li>
				<li><a href="contact.php">Επικοινωνία</a></li>
				<li><a href="cart.php">Καλάθι<span class="fa fa-shopping-cart"></span></a></li>
			</ul>

			<div id="form">
				<form method="get" action="results.php" enctype="multipart/form-data">
					<input type="text" name="user_query" placeholder="Search something">
					<input type="submit" name="search" value="Search">
				</form>
				

			</div>

		</nav>