<?php
declare(strict_types = 1);

session_start();

require_once('templates/item.tpl.php');
require_once('database/item.class.php');
require_once ('database/connection.db.php');

$db = get_database_connection();
$items = Item::get_favorite_items($db, $_SESSION['username']);
draw_header("favorite");
draw_items($items);
draw_footer();
