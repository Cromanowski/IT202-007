<?php
//requires a duration to be set
require_once(__DIR__ . "/../../partials/nav.php");
if (!isset($duration)) {
    $duration = "day"; //choosing to default to day
}
else{
}
$results = get_top_10($duration);

switch ($duration) {
    case "day":
        $title = "Top Scores Today";
        break;
    case "week":
        $title = "Top Scores This Week";
        break;
    case "month":
        $title = "Top Scores This Month";
        break;
    case "lifetime":
        $title = "All Time Top Scores";
        break;
    default:
        $title = "Invalid Scoreboard";
        break;
}
?>
<div class="card bg-dark">
    <div class="card-body">
        <div class="card-title">
            <div class="fw-bold fs-3">
                <?php se($title); ?>
            </div>
        </div>
        <div class="card-text">
            <table class="table text-light">
                <thead>
                    <th>User</th>
                    <th>Score</th>
                    <th>Achieved</th>
                </thead>
                <tbody>
                    <?php if (!$results || count($results) == 0) : ?>
                        <tr>
                            <td colspan="100%">No scores available</td>
                        </tr>
                    <?php else : ?>
                        <?php foreach ($results as $result) : ?>
                            <tr>
                                <td>
                                    <!--<a href="profile.php?id=<?php se($result, 'user_id'); ?>"><?php se($result, "username"); ?></a>-->
                                    <?php se($result, "username"); ?>
                                </td>
                                <td><?php se($result, "score"); ?></td>
                                <td><?php se($result, "created"); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
        function button1() {
            header("Refresh:0");
            $duration = $_POST["day"];
            echo $duration;
        }
        function button2() {
            header("Refresh:0");
            $duration = $_POST["week"];
            echo $duration;
        }
        function button3() {
            header("Refresh:0");
            $duration = $_POST["month"];
            echo $duration;
        }
        function button4() {
            header("Refresh:0");
            $duration = $_POST["lifetime"];
            echo $duration;
        }
    ?>
  
    <form method="post">
        <input type="submit" name="button1"
                class="button" value="Day" />
          
        <input type="submit" name="button2"
                class="button" value="Week" />
        
        <input type="submit" name="button3"
                class="button" value="Month" />
        
        <input type="submit" name="button4"
                class="button" value="Lifetime" />     

    </form>