<?php 
ob_start();
include("includes/db.php");
include_once("functions/functions.php");
  if(!isset($_SESSION)){ // if there isnt session start one
        session_start(); 
    } 

 ?>

      <div class="container">    
        <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
            <div class="panel panel-info" >
                    <div class="panel-heading">
                        <div class="panel-title">Σύνδεση</div>
                        <div style="float:right; font-size: 80%; position: relative; top:-10px"><a href="checkout.php?forgot_pass">Ξεχάσατε τον κωδικό</a></div>
                    </div>     

                    <div style="padding-top:30px" class="panel-body" >

                        <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>
                            
                        <form id="loginform" class="form-horizontal" role="form" method="POST" action="customer_login.php">
                                    
                            <div style="margin-bottom: 25px" class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                        <input id="login-username" type="email" class="form-control" name="email" value="" placeholder="username or email">                                        
                                    </div>
                                
                            <div style="margin-bottom: 25px" class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                        <input id="login-password" type="password" class="form-control" name="pass" placeholder="Κωδικός">
                                    </div>
                                    

                                
                            <div class="input-group">
                                      <div class="checkbox">
                                        <label>
                                          <input id="login-remember" type="checkbox" name="remember" value="1"> Θυμήσου με
                                        </label>
                                      </div>
                                    </div>


                                <div style="margin-top:10px" class="form-group">
                                    

                                    <div class="col-sm-12 controls">
                                     
                                      <button id="btn-login" class="btn btn-success" type="submit" name="login" >Συνδεθείτε</button>
                                     
                                    </div>
                                </div>


                                <div class="form-group">
                                    <div class="col-md-12 control">
                                        <div style="border-top: 1px solid#888; padding-top:15px; font-size:85%" >
                                            Δεν έχετε Λογαριασμό 
                                        <a href="customer_register.php" >
                                            Δημιουργήστε έναν
                                        </a>
                                        </div>
                                    </div>
                                </div>    
                            </form><?php

             if(isset($_GET['Message'])){
                     echo $_GET['Message'];
                                }

if (isset($_POST['login'])) {
   
       $c_email=$_POST['email'];
       $c_pass=$_POST['pass'];
      
       $sel_customer=$con->prepare("SELECT * FROM customers WHERE customer_email =:email ");
       $sel_customer->execute(array(':email' => $c_email));
       $data=$sel_customer->fetch(); // select customers based on email
       $checkcustomer=$sel_customer->rowCount();//count
       if($checkcustomer==1){// if there is one aka you found him
           $validPassword = password_verify($c_pass, $data['customer_pass']); // verify password against the db one
           if($validPassword){// if true
              $ip=getIp();//get ip
              $select_cart=$con->prepare("SELECT * FROM cart where ip_add=:ip");// select from the cart
              $select_cart->execute(array(':ip' => $ip));
              $check_cart=$select_cart->rowCount(); // find if the has anyting in cart
           
              if( $checkcustomer>0 AND $check_cart==0){ // if he has account and not anything in cart send to account 
                 $_SESSION['customer_email']= $c_email; // session the email
           
              header('Location: customer/my_account.php', true,  301 );  exit;
                ob_end_flush();
                exit;
                
               }else{                          // else send to checkout
                 $_SESSION['customer_email']= $c_email;

                header('Location: checkout.php' ,true,  301 ); 
                ob_end_flush();
                exit;
    
                 
                }
            
            
            } else{
            
                $Message = urlencode("<div class='alert alert-danger'>
  <strong>Λάθος email η κωδικός!</strong> 
</div>");
             
                 header('Location: checkout.php?Message='.$Message ,true,  301 ); // wrong password or email display it under from
               
                ob_end_flush();
                exit;
             }
         } else{
            
                 
                $Message = urlencode("<div class='alert alert-danger'>
  <strong>Λάθος email η κωδικός!</strong>
</div>");
             
                 header('Location: checkout.php?Message='.$Message ,true,  301 ); // same as above
               
                ob_end_flush();
                exit;
          }


  }



 ?>

                        </div>                     
                    </div>  
        </div>
      