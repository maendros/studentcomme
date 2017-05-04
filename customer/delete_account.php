
<br>

<h2 style="text-align:center; ">Θέλετε στα αλήθεια να διαγράψεται το λογαριασμό σας?</h2>

<form action="" method="post">

<br>
<input type="submit" name="yes" value="Ναι θέλω" /> 
<input type="submit" name="no" value=" Όχι δεν θέλω" />


</form>

<?php 
include("../includes/db.php"); 

	 $usermail=$_SESSION['customer_email'];
    
	
	if(isset($_POST['yes'])){
		 $delete = $con->prepare("DELETE FROM customers where customer_email=:useremail"); // delete
         $delete-> execute(array(':useremail' => $usermail ));
		session_destroy();
	
	echo "<script>alert('Ο λογιαριασμός σας έχει διαγραφεί!')</script>";
	echo "<script>window.open('../index.php','_self')</script>";
	}
	if(isset($_POST['no'])){
	
	
	echo "<script>window.open('my_account.php','_self')</script>";
	
	}
	


?>