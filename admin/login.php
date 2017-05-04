<?php 
ob_start();
session_start();

?>
<!DOCTYPE>
<html>
	<head>
		<title>	Φόρμα Σύνδεσης</title>
<link rel="stylesheet" href="styles/login_style.css" media="all" /> 

	</head>
<body>
<div class="login">
<h2 style="color:white; text-align:center;"><?php echo @$_GET['not_admin']; ?></h2>

<h2 style="color:white; text-align:center;"><?php echo @$_GET['logged_out']; ?></h2>
	
	<h1>Είσοδος Διαχειριστή</h1>
    <form method="post" action="login.php">
    	<input type="text" name="email" placeholder="Eamil" required="required" />
        <input type="password" name="password" placeholder="Password" required="required" />
        <button type="submit" class="btn btn-primary btn-block btn-large" name="login">Σύνδεση</button>
    </form>
</div>


</body>
</html>
<?php 

include("includes/db.php"); 
	
	if(isset($_POST['login'])){
	
		$email = $_POST['email'];// get login inpit data
		$pass = $_POST['password'];
		$sel_user = $con->prepare("SELECT * from admins where user_email=:email AND user_pass=:pass ");
	$sel_user->execute( array(':email' =>$email ,':pass' =>$pass  ));
	
	
 
	
	 $check_user = $sel_user->rowCount();
	
	if($check_user==1){// if there is user
	
	$_SESSION['user_email']=$email; // session email
	
	echo "<script>window.open('index.php?logged_in=Συνδεθήκατε!','_self')</script>";

	}
	else {
	
	echo "<script>alert('Λάθος κωδικός ή email. Ξαναπροσπαθήστε !')</script>";
	
	}
	
	
	}
	
	
	
	
	








?>