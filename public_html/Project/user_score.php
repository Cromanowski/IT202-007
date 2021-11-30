<style>
<?php include 'styles.css'; ?>
</style>
<?php
$id = get_user_id();
$results = get_best_scores($id, 10);
$results2 = get_latest_scores($id, 10);
?>
<table>
    <tr>
    <td id = 'top'>        
    <h2 >Top 10 scores</h2>
        <?php
            if (!$results || count($results) == 0) : ?>
                <div id = scores>
                <li>
                    <td colspan="100%">No scores available</td>
                </li>
            <?php else : ?>
                <?php foreach ($results as $result) : ?>
                    <ul>
                            <li>Score : <?php se($result, "score"); ?> </li>
                            <li>Date: <?php se($result, "created"); ?> </li>
                        </ul>
                    <?php endforeach; ?>
        <?php endif; ?>
    </td>
    <td id = 'recent'>
    <h2>Most recent scores</h2>
        <?php
            if (!$results2 || count($results2) == 0) : ?>
                <li>
                    <td colspan="100%">No scores available</td>
                </li>
            <?php else : ?>  
                <?php foreach ($results2 as $result2) : ?>
                        <ul>
                        <li>Score : <?php se($result2, "score"); ?> </li>
                            <li>Date: <?php se($result2, "created"); ?></li>
                        </ul>
                    <?php endforeach; ?>
                </div>
        
        </td>        <?php endif; ?>
    </tr>
    </table>
