<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");
if(isset($_GET['preview'])){
  header("Content-type: image/jpeg");
} else {
  header('Content-Disposition: attachment;filename="attachment.jpeg"');
  header('Content-Type: application/force-download');
}

$con = mysqli_connect("localhost","root","root","questions-app", 8889);

if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
}

if(isset($_GET['id']) && isset($_GET['photo'])){
  $sql = "SELECT `" . $_GET['photo'] . "` from answers where id='" . $_GET['id'] . "'";
} 

$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);

mysqli_close($con);
echo base64_decode($row[$_GET['photo']]);
?>