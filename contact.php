<!DOCTYPE html>
<?php 
session_start();

include("functions/functions.php"); 
include("header.php");?>

		<main >

		
<div class="jumbotron jumbotron-sm">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-lg-12">
                <h1 class="h1">
                   <small> Επικοινωνείστε μαζί  μας </small></h1>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="well well-sm">
                <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">
                                Όνομα</label>
                            <input type="text" class="form-control" id="name" placeholder="Συμπληρώστε το Όνομα σας" required="required" name="name" />
                        </div>
                        <div class="form-group">
                            <label for="email">
                                Email </label>
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span>
                                </span>
                                <input type="email" class="form-control" id="email" placeholder="Συμπληρώστε το email σας" required="required" name="email" /></div>
                        </div>
               
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">
                                Μήνυμα</label>
                            <textarea name="message" id="message" class="form-control" rows="9" cols="25" required="required"
                                placeholder="Μήνυμα" ></textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary pull-right" id="btnContactUs" name="send">
                            Αποστολή</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
        
    </div>
</div>

			
	   <?php include("footer.php"); ?>
<?php 
   if (isset($_POST['send'])) {
        $name=$_POST['name'];
    $sender_email=$_POST['email'];
    $msg=$_POST['message'];
    $support_email="studentcomme@gmail.com";// send all items to that email
            
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= 'From: <$sender_email>' . "\r\n";
            
            $subject = "support";
            
            $message =$msg;
            
            mail($support_email,$subject,$message,$headers);

            
        
    } 

 ?>


