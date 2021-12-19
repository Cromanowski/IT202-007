<?php
require(__DIR__."/../../partials/nav.php");
?>
<h1>Home</h1>
<?php
if(isset($_SESSION["user"]) && isset($_SESSION["user"]["email"])){
 echo "Welcome, " . $_SESSION["user"]["email"]; 
}
else{
  echo "You're not logged in";
}

$db = getDB();
$stmt =$db->prepare("SELECT count(1) from UserComps where user_id = :uid");
$comp_id = $stmt->execute([":uid" => get_user_id()]);
$user_id = get_current_user();
$per_page = 10;
$query = "SELECT count(1) as total FROM Competitions WHERE id = $comp_id";

paginate($query, [":uid"=>get_user_id()], $per_page);
$params = [":uid"=>get_user_id(), ":offset"=>$offset, ":count"=>$per_page];
$stmt =$db->prepare("SELECT Competitions.id, comp_name, min_participants, current_participants,  duration, min_score, join_fee, expires 
from UserComps JOIN Competitions on Competitions.id = UserComps.comp_id WHERE user_id = :uid LIMIT :offset, :count");

foreach ($params as $key => $value){
  $type = is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR;
  $stmt->bindValue($key, $value, $type);
}
$params = null;

$db = getDB();

$stmt->execute($params);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);



?>
<div class="container-fluid">
    <h1>Competitions History</h1>
    <table class="table text-light">
        <thead>
            <th>Title</th>
            <th>Participants</th>
            <th>Min Score</th>
            <th>Expires</th>
            <th>Actions</th>
        </thead>
        <tbody>
            <?php if (count($results) > 0) : ?>
                <?php foreach ($results as $row) : ?>
                    <tr>
                        <td><?php se($row, "title"); ?><?php se($row, "comp_name"); ?></td>
                        <td><?php se($row, "current_participants"); ?>/<?php se($row, "min_participants"); ?></td>
                        <td><?php se($row, "min_score"); ?></td>
                        <td><?php se($row, "expires", "-"); ?></td>
                        <td>
                            <?php if (se($row, "joined", 0, false)) : ?>
                                <button class="btn btn-primary disabled" onclick="event.preventDefault()" disabled>Already Joined</button>
                            <?php else : ?>
                                <form method="POST">
                                    <input type="hidden" name="comp_id" value="<?php se($row, 'id'); ?>" />
                                    <input type="hidden" name="cost" value="<?php se($row, 'join_fee', 0); ?>" />
                                </form>
                            <?php endif; ?>
                            <a class="btn btn-secondary" href="view_competitions.php?id=<?php se($row, 'id'); ?>">View</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="100%">No competitions found</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php
require("pagination.php");
?>
<Table id = 'Leaderboard'>
<tr>
<td><?php  
$duration = 'day';
require("score_table.php");
?> </td>
<td><?php  
$duration = 'week';
require("score_table.php");
?> </td>
<td><?php  
$duration = 'month';
require("score_table.php");
?> </td>
<td><?php  
$duration = 'lifetime';
require("score_table.php");
?> </td>
</tr>
</Table>