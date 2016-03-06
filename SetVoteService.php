<?php
include_once('config.php');
if(isset($_REQUEST['party_id'])){
	$id=$_REQUEST['party_id'];
	$result=mysqli_query($conn,"select vchr_party_name from countVotes where pk_int_party_id='$id'");
	if(mysqli_num_rows($result)==1){
		$query=mysqli_query($conn,"update countVotes set int_vote_count=int_vote_count+1 where pk_int_party_id='$id'");
		if(!$query)
		{
		$json = array("status" => "0", "msg" => "Vote not taken");
		}
		else
		{
		$json = array("status" => "200", "msg" => "Voting successfull");
		}
	}
	else{
		$json = array("status" => "0", "msg" => "Candidate does not exist");
	}	
}
else
{
	$json = array("status" => "0", "msg" => "No data recieved");
}
mysqli_close($conn);
header('Content-type: application/json');
echo json_encode($json);
?>