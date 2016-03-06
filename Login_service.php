<?php
include_once('config.php');
session_start();
if(isset($_REQUEST['emailid'])&& isset($_REQUEST['password']))
{
    if(isset($_SESSION['vote_from'])&&isset($_SESSION['vote_to'])&&isset($_SESSION['vote_date']))
    {
        $from=$_SESSION['vote_from'];
        $vote_from=strtotime($from);

        $to=$_SESSION['vote_to'];
        $vote_to=strtotime($to);

        $vote_date=$_SESSION['vote_date'];
        $voting_date=strtotime($vote_date);

        $cur_date=date("Y-m-d");
        $current_date=strtotime($cur_date);

        date_default_timezone_set("Asia/Kolkata");
        $current_time=date("h:i:sa");
        $login_time=strtotime($current_time);


        if($current_date==$voting_date && $login_time>$vote_from && $login_time<$vote_to)
        {
            $emailid = $_REQUEST['emailid'];
            $password=$_REQUEST['password'];
            $query=mysqli_query($conn,"select pk_int_login_id,bln_login_status from login where vchr_emailid='$emailid' and vchr_password='$password'");
            $result=mysqli_fetch_array($query);
            if($result['bln_login_status']==0)
            {
                if(mysqli_num_rows($query)==1)
                {
                    $updation=mysqli_query($conn,"update login set bln_login_status=1 where vchr_emailid='$emailid' and vchr_password='$password'");
                    $json = array("status" => 200, "msg" => "login successfull", "login_time" => $login_time);

                }
                else
                    $json = array("status" => "0", "msg" => "Invalid username or password");
            }
            else
                $json = array("status" => "0", "msg" => "your vote is taken"); 
        }
        else
            $json = array("status" => "0", "msg" => "time out..!!!"); 
    }
    else
        $json = array("status" => "0", "msg" => "voting time is not set.Please wait..!");
}
else
        $json = array("status" =>"0", "msg" => "No data recieved");
mysqli_close($conn);
header('Content-type: application/json');
echo json_encode($json);
?>