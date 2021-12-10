<?php
require_once(__DIR__ . "/../../partials/nav.php");
is_logged_in(true);

if (is_logged_in()) : ?>
            <ul>
                <li class = comp><a href="<?php echo get_url ('create_competitions.php'); ?>">Create a new competion</a></li>
                <li class = comp><a href="<?php echo get_url('join_competitions.php'); ?>">Join competitions</a></li>
            </ul>
<?php endif; ?>
