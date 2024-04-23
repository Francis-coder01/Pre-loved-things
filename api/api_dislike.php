<?php

declare(strict_types=1);

session_start();

require_once(__DIR__ . '/../database/user.class.php');
require_once(__DIR__ . '/../database/connection.db.php');

$dbh = get_database_connection();

User::dislike_item($dbh, (int)$_SESSION['user_id'], (int)$_GET['item']);