<?php
//TODO 1: require db.php
require(__DIR__ . "/../../lib/functions.php");
/** Safe Echo Function
 * Takes in a value and passes it through htmlspecialchars()
 * or
 * Takes an array, a key, and default value and will return the value from the array if the key exists or the default value.
 * Can pass a flag to determine if the value will immediately echo or just return so it can be set to a variable
 */
function se($v, $k = null, $default = "", $isEcho = true) {
    if (is_array($v) && isset($k) && isset($v[$k])) {
        $returnValue = $v[$k];
    } else if (is_object($v) && isset($k) && isset($v->$k)) {
        $returnValue = $v->$k;
    } else {
        $returnValue = $v;
        //added 07-05-2021 to fix case where $k of $v isn't set
        //this is to kep htmlspecialchars happy
        if (is_array($returnValue) || is_object($returnValue)) {
            $returnValue = $default;
        }
    }
    if (!isset($returnValue)) {
        $returnValue = $default;
    }
    if ($isEcho) {
        //https://www.php.net/manual/en/function.htmlspecialchars.php
        echo htmlspecialchars($returnValue, ENT_QUOTES);
    } else {
        //https://www.php.net/manual/en/function.htmlspecialchars.php
        return htmlspecialchars($returnValue, ENT_QUOTES);
    }
}

//TODO 2: filter helpers
if(isset($POST[$email]) && isset($_POST["password"]) && isset($_POST["confirm"])){
    $email = se($POST, "email", false);
    $password = se($POST, "password", false);
    $confirm = se($POST, "confirm", false);
}
//TODO 3: User helpers
if(empty($email)){
    array_push($errors, "Email must be set");
}
if(empty($password)){
    array_push($errors, "Password must be set");
}
if(empty($confirm)){
    array_push($errors, "Confirm password must be set");
}
if(strlen($password)<8){
    array_push($errors, "Password must be 8 or more characters");
}
if(strlen($password)>0 && $password -! $confirm){
    array_push($errors, "Passwords do not match");
}
if(count($errors)>0){
    echo "<pre>" . var_export($errors, true) . "<pre>";
}
else{
    echo "Welcome, $email!";
}

//TODO 4: Flash Message Helpers
?>