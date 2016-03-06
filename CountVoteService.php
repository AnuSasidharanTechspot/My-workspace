<?php
include('config.php');
if(isset($_REQUEST['value']))
{
$query=mysqli_query($conn,"select vchr_nominee_name,int_vote_count from countVotes");
$data=array();
$i=0;
while($result=mysqli_fetch_assoc($query)){
	$data[]=$result;
}
 $data[0]['ResponseCode']="200";
  $data[0]['Msg']="Success";
mysqli_close($conn);
header('Content-type: application/json');
echo json_encode($data);

}
?>