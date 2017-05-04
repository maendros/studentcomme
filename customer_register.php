<!DOCTYPE html>
<?php 
ob_start();
session_start();


include("includes/db.php");
include("functions/functions.php"); 
include("header.php");?>
            <div id="shopping-cart">
                <span style="float:none;font-size: 18px;padding: 5px;">         
                    <?php 
                    if(isset($_SESSION['customer_email'])){
                    echo "<b>Καλωσήρθες: </b>" . $_SESSION['customer_email']  ;
                    }
                    else {
                    echo "<b>Καλωσήρθες Guest:</b>";
                    }
                    ?> </span><span style="float:right;font-size: 18px;padding: 5px;">  <mark>Συνολικά Αντικείμενα: <?php total_items(); ?> </mark><mark>Συνολική Τιμή: <?php  total_price(); ?> €  <a href="cart.php"><span class="fa fa-shopping-cart"></span></a></mark> </span>
            </div>  
		<main >

			
			<section id="content-area" class="container-fluid">
            
				<div id="signupbox" style=" margin-top:50px" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="panel-title">Δημιουργία ή<a href='checkout.php' class='btn btn-primary' role='button' style="color:#fff;"> Σύνδεση</a></div>
                            <div style="float:right; font-size: 85%; position: relative; top:-30px">   </div>
                           
                        </div>  
                        <div class="panel-body" >
                            <form id="signupform" class="form-horizontal" role="form" method="POST" action="customer_register.php" enctype="multipart-form-data">
                                
                                <div id="signupalert" style="display:none" class="alert alert-danger">
                                    <p>Error:</p>
                                    <span></span>
                                </div>
                                    
                                
                                  
                                <div class="form-group">
                                    <label for="email" class="col-md-3 control-label">Email</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="c_email" placeholder="Email Address" required/>
                                    </div>
                                </div>
                                    
                                <div class="form-group">
                                    <label for="firstname" class="col-md-3 control-label">Όνομα</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="c_name" placeholder="First Name" required/>
                                    </div>
                                </div>
                          
                                <div class="form-group">
                                    <label for="password" class="col-md-3 control-label">Κωδικός</label>
                                    <div class="col-md-9">
                                        <input type="password" class="form-control" name="c_pass" placeholder="Password" required/>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label for="city" class="col-md-3 control-label">Πόλη</label>
                                    <div class="col-md-9" required/>
                                      
                                    <select class="form-control" name="c_city" placeholder="Επιλέξτε Πόλη">
                                        <option>ΑΘΗΝΑ</option>
                                        <option>ΘΕΣΣΑΛΟΝΙΚΗ</option>
                                        <option>ΠΑΤΡΑ</option>
                                        <option>ΛΑΡΙΣΣΑ</option>
                                        <option>ΗΡΑΚΛΕΙΟ</option>
                                    </select>
                                    </div>
                                </div>

                                 <div class="form-group">
                                    <label for="contact" class="col-md-3 control-label">Τηλέφωνο</label>
                                    <div class="col-md-9">
                                    <input type="tel" class="form-control" name="c_contact" required/>
                                    </div>
                                        
                                </div>

                                <div class="form-group">
                                    <label for="address" class="col-md-3 control-label">Διεύθυνση</label>
                                    <div class="col-md-9">

                                    <textarea class="form-control" name="c_address" placeholder="Διεύθυνση"></textarea required/>
                                    </div>
                                       
                                 </div>
                                    

                                <div class="form-group">
                                    <!-- Button -->                                        
                                    <div class="col-md-offset-3 col-md-9">
                                        <button id="btn-signup" type="submit" name="register" class="btn btn-info"><i class="icon-hand-right"></i> &nbsp Δημιουργία</button>
                                       
                                    </div>
                                </div>
                                
                                <div style="border-top: 1px solid #999; padding-top:20px"  class="form-group">                                        
                                </div>
                                
                                
                                
                            </form>
                         </div>
                    </div>


			</section>
			
			<footer>footer</footer>
		</main>
		

	</div>

</body>
</html>
<?php 
    if (isset($_POST['register'])) {

        $ipget=getIp();
        $c_name=$_POST["c_name"];
        $c_email=$_POST["c_email"];
        $c_pass=$_POST["c_pass"];// take all the info of customer
        $c_city=$_POST["c_city"];
        $c_contact=$_POST["c_contact"];
        $c_address=$_POST["c_address"];
         
    $check_email = $con->prepare("SELECT * FROM customers WHERE customer_email = :c_email");
    
    $check_email->execute(array(':c_email'=> $c_email));//check email
    
  
    $rows_email = $check_email->rowCount();// count rows in table
    

    if($rows_email  > 0){//if there is one show it
        die('Αυτό το email υπάρχει ήδη!');
    } else{
        // else
     
        $passwordHash = password_hash($c_pass, PASSWORD_BCRYPT, array("cost" => 12));// hash the password

        // insert it the database in customers
        $insert_customer=$con->prepare("INSERT INTO customers (customer_ip,customer_name,customer_email,customer_pass,customer_city,customer_contact, customer_address) VALUES (:customer_ip,:customer_name,:customer_email,:passwordHash,:customer_city,:customer_contact,:customer_address) ");

        $insert_customer->execute( array(':customer_ip' => $ipget, ':customer_name' => $c_name,':customer_email' => $c_email,':passwordHash' => $passwordHash,':customer_city' => $c_city,':customer_contact' => $c_contact,':customer_address' => $c_address));

        $select_cart=$con->prepare("SELECT * FROM cart where ip_add=:ip");//check   cart
        $select_cart->execute(array(':ip' => $ipget ));
        $iprows=$select_cart->rowCount();
         if( $iprows==0){                                    // if he  has nothing  something in cart
            $_SESSION['customer_email']= $c_email;
            echo  "<div class='alert alert-success'>
    <strong>Επιτυχής εγγραφή</strong>
</div>";
           // echo "<script>windows.open('customer/my_account.php','_self');</script>";
           // header("Location: http://localhost/ecommerce/");
            header('Location: index.php' ,true,  301 ); // redirect him to index
            ob_end_flush();
                exit;
         }else {
            $_SESSION['customer_email']= $c_email;
            echo  "<div class='alert alert-success'>
    <strong>Επιτυχής εγγραφή</strong>
</div>";
            //echo "<script>windows.open('checkout.php','_self');</script>";
             header('Location: checkout.php' ,true,  301 );// else redirect to checkout for payment
             ob_end_flush();
             exit; 

            }
         }
    }

 ?>
