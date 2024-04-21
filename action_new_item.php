<?php

declare(strict_types=1);

session_start();

require_once ('database/item.class.php');
require_once ('database/connection.db.php');
require_once ('files.php');

$dbh = get_database_connection();

Item::register_item($dbh, $_POST['iname'], $_POST['description'],  $_POST['price'], $_POST['category'], $_SESSION['username']);
Item::register_item_images($dbh, array($_FILES['img1']['name'], $_FILES['img2']['name']));

upload_image('img1');
upload_image('img2');


header('Location: profile.php');