<?php
include('PHPMailer/PHPMailerAutoload.php');
include('config.php');
session_start();
if(isset($_REQUEST['voting_time_to'])&& isset($_REQUEST['voting_time_from']))
{
	$from=$_REQUEST['voting_time_from'];
	$to=$_REQUEST['voting_time_to'];
	
    $voting_date=strtotime($from);
    $voting_date=date("Y-m-d",$voting_date);
    
    $vote_from=strtotime($from);
    $vote_from=date("h:i:sa",$vote_from);
    
    $vote_to=strtotime($to);
    $vote_to=date("h:i:sa",$vote_to);
   	$_SESSION['vote_from']=$vote_from;
	$_SESSION['vote_to']=$vote_to;
	$_SESSION['vote_date']=$voting_date;
	
	$mail = new PHPMailer;
	$mail->isSMTP();                                      // Set mailer to use SMTP
	$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
	$mail->SMTPAuth = true;                               // Enable SMTP authentication
	$mail->Username = 'votteransar@gmail.com';                 // SMTP username     
	$mail->Password = 'ansar123';                           // SMTP password      
	$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
	$mail->Port = 587;  
	header('Content-type: application/json');
	$query=mysqli_query($conn,"select vchr_emailid,vchr_voter_name from login join voterslist where pk_int_login_id=fk_int_login_id");
	while($result=mysqli_fetch_assoc($query)){
		$mail->setFrom('votteransar@gmail.com', 'E-Voting System');						
		$mail->addAddress($result['vchr_emailid'],$result['vchr_voter_name']);
		$mail->addReplyTo('votteransar@gmail.com', 'E-Voting System');      
		$mail->WordWrap = 50;
		$mail->isHTML(true);                                  
		$mail->Subject = 'Notice';
		$mail->Body    = "Please Login to your account on $voting_date and add your vote between".$vote_from."and". $vote_to;
		if(!$mail->send()) {
			$json=array("status" => "0", "msg" => "mail not send", "error" => $mail->ErrorInfo, "username" =>$result['vchr_voter_name']);


	    } else {
	    	
	    	$json=array("status" => "200", "msg" => "mail successfully send to ".$result['vchr_voter_name'] );
		}

		echo json_encode($json);
	}
	mysqli_close($conn);
		
}
else
	{
		header('Content-type: application/json');
		$json=array("status" => "0", "msg" => "voting time is not set" );
		echo json_encode($json);
	}

?>