<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");

include_once('db.php');

if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
}

$errors = [];
$submission_id = md5(mt_rand());
if(isset($_POST['json'])){
  $json = json_decode($_POST['json'], 1);
  foreach($json as $question){
    $question_title = isset($question['title']) ? $question['title'] : "";
    $question_text = isset($question['question']) ? $question['question'] : "";;
    $score = isset($question['answer']['score']) ? $question['answer']['score'] : null;
    $description = isset($question['answer']['description']) ? $question['answer']['description'] : null;
    $file1 = isset($question['answer']['files'][0]) ? $question['answer']['files'][0] : null;
    $file2 = isset($question['answer']['files'][1]) ? $question['answer']['files'][1] : null;
    $file3 = isset($question['answer']['files'][2]) ? $question['answer']['files'][2] : null;
    $file4 = isset($question['answer']['files'][3]) ? $question['answer']['files'][3] : null;

    if (!mysqli_query($con, "INSERT INTO answers (submission_id, question_title, question, answer_score, answer_text, answer_photo1, answer_photo2, answer_photo3, answer_photo4) VALUES ('$submission_id', '$question_title', '$question_text', '$score', '$description', '$file1', '$file2', '$file3', '$file4')")) {
      $errors[] = "Error inserting data";
    }
  }
}

mysqli_close($con);
echo json_encode($errors);
?>