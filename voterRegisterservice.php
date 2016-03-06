<?php
include_once('config.php');
if(isset($_REQUEST['vchr_voter_name']) && isset($_REQUEST['vchr_father_name'])&& isset($_REQUEST['vchr_mother_name'])&& isset($_REQUEST['vchr_state'])&&isset($_REQUEST['district'])&&isset($_REQUEST['muncipality'])&&isset($_REQUEST['vchr_emailid']) && isset($_REQUEST['vchr_password']))
{
    $voter_name =$_REQUEST['vchr_voter_name'];
    $father_name=$_REQUEST['vchr_father_name'];
    $mother_name=$_REQUEST['vchr_mother_name'];
    $state=$_REQUEST['vchr_state'];
    $district=$_REQUEST['district'];
    $muncipality=$_REQUEST['muncipality'];
    $created_on_date = date("Y-m-d");
    date_default_timezone_set("Asia/Kolkata");
    $created_on_time= date("h:i:sa");
    $emailid=$_REQUEST['vchr_emailid'];
    $password=$_REQUEST['vchr_password'];
    $bln_status=0;
    $result=mysqli_query($conn,"call voterRegistration('$voter_name','$father_name','$mother_name','$state','$district','$muncipality','$created_on_date','$created_on_time','$emailid','$password',$bln_status)");
    if(!$result) 
  	{
		$json = array("status" => 0, "msg" => "Reporting Errors");
	}
    else
    {
        $json=array("status" => 200, "msg" => "Registered Successfully");
    }
}
else 
    $json=array("status" => 0, "msg" => "No data recieved");
mysqli_close($conn);
header('Content-type: application/json');
echo json_encode($json);
?>