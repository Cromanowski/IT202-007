<?php
require_once(__DIR__ . "/../../../lib/functions.php");
?>
<script>
console.log('It worked');
</script>
<?php

session_start();
$user_id = get_user_id();
$comp_id = se($_POST, "comp_id", -1, false);
$comp_name = $_POST["title"];
$starting_reward = $_POST["starting_reward"];
$min_score = $_POST["min_score"];
$duration = $_POST["duration"];
$join_fee = $_POST["fee"];
$min_participants = $_POST["participants"];
$payout_option = $_POST["payout_option"];
switch($payout_option){
    case '34-33-33':
       $first = 34;
       $second = 33;
       $third = 33;
       break;
    case '40-35-25':
       $first = 40;
       $second = 35;
       $third = 25;
       break;
    case '50-30-20':
       $first = 50;
       $second = 30;
       $third = 20;
       break;
    case '60-25-15':
       $first = 60;
       $second = 25;
       $third = 15;
       break;
    case '70-20-10':
       $first = 70;
       $second = 20;
       $third = 10;
       break;
    case '80-15-5':
       $first = 80;
       $second = 15;
       $third = 5;
       break;
    case '100-0-0':
       $first = 100;
       $second = 0;
       $third = 0;
       break;
}
error_log(var_export($_POST, true));
    
if ($user_id <= 0) {
    error_log("User not logged in");
    http_response_code(403);
}
else{
    $db = getDB();
    $stmt = $db->prepare("
    UPDATE Competitions set comp_name = :cn, starting_reward = :sr, min_score = :ms, duration = :d, join_fee = :jf, 
    min_participants = :mp, first_place_per = :fp, second_place_per = :sp, third_place_per = :tp WHERE id = :id");
    try{
    $stmt->execute([ ":cn" => $comp_name, ":sr" => $starting_reward, 
    ":ms" => $min_score, ":d" => $duration, ":jf" => $join_fee, ":mp" => $min_participants,  ":fp" => $first, ":sp" => $second, ":tp" => $third, ":id" => $comp_id]);
    error_log("List competitions error: " . var_export($e, true));

    }
    catch (PDOException $e) {
      flash("There was a problem editing competitions, please try again later", "danger");
      error_log("List competitions error: " . var_export($e, true));
  }
}