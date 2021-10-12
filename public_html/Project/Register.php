<?php
require(__DIR__ . "/../../partials/nav.php");
require(__DIR__."/../../partials/flash.php");
?>
<form onsubmit="return validate(this)" method="POST">
    <div>
        <label for="email">Email</label>        
        <input type="email" name="email" required />
    </div>
    <div>
        <label for="username">Username</label>        
        <input type="username" name="username" required />
    </div>
    <div>
        <label for="pw">Password</label>
        <input type="password" id="pw" name="password" required minlength="8" />
    </div>
    <div>
        <label for="confirm">Confirm</label>
        <input type="password" name="confirm" required minlength="8" />
    </div>
    <input type="submit" value="Register" />
</form>
<script>
    function validate(form) {
        //TODO 1: implement JavaScript validation
        //ensure it returns false for an error and true for success

        return true;
    }
</script>
<?php
//TODO 2: add PHP Code
if (isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["confirm"])) {
    $email = se($_POST, "email", "", false);
    $username = se($_POST, "username", "", false);
    $password = se($_POST, "password", "", false);
    $confirm = se($_POST, "confirm", "", false);
    //TODO 3


    $errors = [];
    if (empty($email)) {
        array_push($errors, "Email must not be empty");
    }
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Email is invalid");
    }
    if (empty($password)) {
        array_push($errors, "Password must not be empty");
    }
    //if(!preg_match('/[^a-z_\0-9]/i'), $username){
    //    array_push($errors, "Username can only contain alphanumerical characters and _ or -")
    //}
    if (empty($confirm)) {
        array_push($errors, "Confirm Password must not be empty");
    }
    if (strlen($password) < 8) {
        array_push($errors, "Password too short");
    }
    if (strlen($password) > 0 && $password !== $confirm) {
        array_push($errors, "Passwords must match");
    }
    if (count($errors) > 0) {
        echo "<pre>" . var_export($errors, true) . "</pre>";
    } else {
        echo "Welcome, $email";
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO Users (email, password) VALUES(:email, :password)");
        try {
            $stmt->execute([":email" => $email, ":password" => $hash, ":username" =>$username]);
            echo "You've registered, yay...";
        } catch (Exception $e) {
            echo "There was a problem registering";
            echo "<pre>" . var_export($e, true) . "</pre>";
        }
    }
}
?>