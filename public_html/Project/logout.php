<?php
require(__DIR__."/../../lib/functions.php");
session_start();
session_unset();
session_destroy();
session_start();
flash("Successfully logged out");
header("Location: login.php");