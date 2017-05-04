<?php  

                
                include("includes/db.php");       
                $usermail=$_SESSION['customer_email'];
                $get_user = $con->prepare("select * from customers where customer_email=:useremail"); 
                $get_user-> execute(array(':useremail' => $usermail ));// find customer
                $userinfo = $get_user->fetchAll();
                foreach ($userinfo as $info) {
                    $c_id=$info['customer_id'];
                    $cust_name=$info['customer_name'];
                    
                        $customer_email=$info['customer_email'];// take info
                    
                       
                        $customer_contact=$info['customer_contact'];
                        $customer_address=$info['customer_address'];
                }
               
?>

		
				<div id="signupbox" style=" margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                    <div class="panel panel-info" >
                        <div class="panel-heading">
                            <div class="panel-title">Επεξεργασία Λογαριασμού</div>
                            <div style="float:right; font-size: 85%; position: relative; top:-10px"></a></div>
                        </div>  
                        <div class="panel-body" >
                            <form id="signupform" class="form-horizontal" role="form" method="POST" action="" enctype="multipart-form-data">
                                
                                <div id="signupalert" style="display:none" class="alert alert-danger">
                                    <p>Error:</p>
                                    <span></span>
                                </div>
                                    
                                
                                  
                                <div class="form-group">
                                    <label for="email" class="col-md-3 control-label">Email</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="c_email" placeholder="<?php echo $customer_email; ?>" required/>
                                    </div>
                                </div>
                                    
                                <div class="form-group">
                                    <label for="firstname" class="col-md-3 control-label">Όνομα</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="c_name" placeholder="<?php echo $cust_name; ?>" required/>
                                    </div>
                                </div>
                          

                                 <div class="form-group">
                                    <label for="contact" class="col-md-3 control-label">Τηλέφωνο</label>
                                    <div class="col-md-9">
                                    <input type="tel" class="form-control" placeholder="<?php echo $customer_contact; ?>" name="c_contact" required/>
                                    </div>
                                        
                                </div>

                                <div class="form-group">
                                    <label for="address" class="col-md-3 control-label">Διεύθυνση</label>
                                    <div class="col-md-9">

                                    <textarea class="form-control" name="c_address" placeholder="<?php echo $customer_address; ?>"></textarea required/>
                                    </div>
                                       
                                 </div>
                                    

                                <div class="form-group">
                                    <!-- Button -->                                        
                                    <div class="col-md-offset-3 col-md-9">
                                        <button id="btn-signup" type="submit" name="update" class="btn btn-info"><i class="icon-hand-right"></i> &nbsp Επεξεργασία</button>
                                       
                                    </div>
                                </div>
                                
                                <div style="border-top: 1px solid #999; padding-top:20px"  class="form-group">                                        
                                </div>
                                
                                
                                
                            </form>
                         </div>
                    </div>


         
	
<?php 

    if (isset($_POST['update'])) {

        $ipget=getIp();
        $customer_id=$c_id;
        $c_name=$_POST["c_name"];
        $c_email=$_POST["c_email"];// take the data
      
     
        $c_contact=$_POST["c_contact"];
        $c_address=$_POST["c_address"];
 
        // update them
 

        $update_customer=$con->prepare("UPDATE   customers SET customer_ip=:customer_ip,customer_name=:customer_name,customer_email=:customer_email,customer_contact=:customer_contact, customer_address=:customer_address where customer_id=:c_id");

        $update_customer->execute( array(':customer_ip' => $ipget, ':customer_name' => $c_name,':customer_email' => $c_email,':customer_contact' => $c_contact,':customer_address' => $c_address,
            ':c_id' => $customer_id ));

     
          if($update_customer){
            echo "<script>alert('Ο λογιαριασμός σας επεξεργάστηκε επιτυχώς')</script>";// back toa ccount
            echo "<script>windows.open('my_account.php','_self');</script>";
            }

    }

 ?>


