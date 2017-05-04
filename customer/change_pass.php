 			<?php  if(isset($_GET['Message'])){
                     echo $_GET['Message'];
                                }  ?>
            <div id="signupbox" style=" margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                    <div class="panel panel-info" >
                        <div class="panel-heading">
                            <div class="panel-title">Επεξεργασία Κωδικού</div>
                            <div style="float:right; font-size: 85%; position: relative; top:-10px"></a></div>
                        </div>  
                        <div class="panel-body" >

                            <form id="signupform" class="form-horizontal" role="form" method="POST" action="" enctype="multipart-form-data">
                                
                                <div class="form-group">
                                    <label for="password" class="col-md-3 control-label">Παλιός Κωδικός</label>
                                    <div class="col-md-9">
                                        <input type="password" class="form-control" name="current_pass" placeholder="Password" required/>
                                    </div>
                                 </div>

                                <div class="form-group">
                                     <label for="password" class="col-md-3 control-label">Νέος Κωδικός</label>
                                    <div class="col-md-9">
                                        <input type="password" class="form-control" name="new_pass" placeholder="Password" required/>
                                    </div>
                                 </div>

                                  <div class="form-group">
                                     <label for="password" class="col-md-3 control-label">Επαλήθευση</label>
                                    <div class="col-md-9">
                                        <input type="password" class="form-control" name="new_pass_again" placeholder="Password" required/>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <!-- Button -->                                        
                                    <div class="col-md-offset-3 col-md-9">
                                        <button id="btn-signup" type="submit" name="change_pass" class="btn btn-info"><i class="icon-hand-right"></i> Αλλαγη Κωδικού</button>
                                       
                                    </div>
                                </div>
                             </form>
                           </div>
                        </div>



 <?php

                                include("../includes/db.php"); 





       

if(isset($_POST['change_pass'])){
                     $usermail=$_SESSION['customer_email'];
              


                     $current_pass = $_POST['current_pass']; 
                    $new_pass = $_POST['new_pass']; // get all the info of the input fields
                    $new_again = $_POST['new_pass_again']; 
                    if($new_pass==$new_again){// first check the 2 news if they match and if they do
                  
                   $sel_customer=$con->prepare("SELECT * FROM customers WHERE customer_email =:email   ");
                   $sel_customer->execute(array(':email' => $usermail));
                   $data=$sel_customer->fetch();// procceed to check password
            
              
                           $validPassword = password_verify($current_pass, $data['customer_pass']); // check current password with the on in database
                           if($validPassword){// if its valid
                                  $passwordHash = password_hash($new_pass, PASSWORD_BCRYPT, array("cost" => 12));// has it
                                    // update it to database
                                  $update_pass = $con->prepare ("update customers set customer_pass=:new_pass where customer_email=:usermail");
                              $update_pass-> execute(array(':new_pass' => $new_pass, ':usermail' => $usermail));
                                    echo "<script>alert('Ο κωδικός σας άλλαξε!')</script>";
                        echo "<script>window.open('my_account.php','_self')</script>";// back to account


                      
      

                           }else{
                                     echo "<script>alert('Λάθος κωδικός!')</script>";// password not valid
                        echo "<script>window.open('edit_account.php','_self')</script>";

                     
                           }
          
           
      
                           }else{
                                   echo "<script>alert('Βάλτε τον ίδιο κωδικό')</script>";// the new passwords arent the same
                        echo "<script>window.open('edit_account.php','_self')</script>";
                           }

        
    }








?>

