<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");
header("Content-Type: application/json");

include_once('db.php');

if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
}

$results = [];
if(!isset($_GET['submission_id'])){
  $sql = "SELECT submission_id,`submitted_on` from answers group by submission_id order by submitted_on desc";
} else {
  $sql = "SELECT id,submission_id,question_title,question,answer_text,answer_score,OCTET_LENGTH(answer_photo1)/1000000 as answer_photo1,OCTET_LENGTH(answer_photo2)/1000000 as answer_photo2,OCTET_LENGTH(answer_photo3)/1000000 as answer_photo3,OCTET_LENGTH(answer_photo4)/1000000 as answer_photo4 from answers where submission_id='" . $_GET['submission_id'] . "'";
}

$result = mysqli_query($con, $sql);
while($row = mysqli_fetch_assoc($result)){
  $results[] = $row;
}

mysqli_close($con);
echo json_encode($results);
?>