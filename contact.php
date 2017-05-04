

<?php 
session_start();
 
$msg = '';
//Don't run this unless we're handling a form submission
if (array_key_exists('email', $_POST)) {
    date_default_timezone_set('Etc/UTC');
   require 'vendor/phpmailer/phpmailer/PHPMailerAutoload.php';
    //Create a new PHPMailer instance
    $mail = new PHPMailer;
    //Tell PHPMailer to use SMTP - requires a local mail server
    //Faster and safer than using mail()
$mail->IsSMTP();
$mail->Host = "smtp.gmail.com";
$mail->SMTPAuth = true;
$mail->SMTPSecure = "ssl";
                       
$mail->Port = "587";
   
    //Use a fixed address in your own domain as the from address
    //**DO NOT** use the submitter's address here as it will be forgery
    //and will cause your messages to fail SPF checks
            $name=$_POST['name'];
    $sender_email=$_POST['email'];
    $mail->setFrom($sender_email, $name);
    //Send the message to yourself, or whoever should receive contact for submissions
    $mail->addAddress('studentcomme@gmail.com');
    //Put the submitter's address in a reply-to header
    //This will fail if the address provided is invalid,
    //in which case we should ignore the whole request
    if ($mail->addReplyTo($_POST['email'], $_POST['name'])) {
        $mail->Subject = 'Studentcomm support';
        //Keep it simple - don't use HTML
        $mail->isHTML(false);
        //Build a simple message body
        $mail->Body = <<<EOT
Email: {$_POST['email']}
Name: {$_POST['name']}
Message: {$_POST['message']}
EOT;
        //Send the message, check for errors
        if (!$mail->send()) {
            //The reason for failing to send will be in $mail->ErrorInfo
            //but you shouldn't display errors to users - process the error, log it on your server.
            echo $mail->ErrorInfo; 
            $msg = 'Sorry, something went wrong. Please try again later.';
        } else {
            $msg = 'Message sent! Thanks for contacting us.';
        }
    } else {
        $msg = 'Invalid email address, message ignored.';
    }
}

?>
<!DOCTYPE html>
<?php  


include("functions/functions.php"); 
include("header.php");?>
		<main>

		
<div class="jumbotron jumbotron-sm">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-lg-12">
                <h1 class="h1">
                   <small> Επικοινωνείστε μαζί  μας </small></h1>
                   <?php if (!empty($msg)) {
    echo "<h2>$msg</h2>";
} ?>
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
