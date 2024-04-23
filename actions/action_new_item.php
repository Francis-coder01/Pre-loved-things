<?php

declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/item.class.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../files.php');

$dbh = get_database_connection();

Item::register_item($dbh, $_POST['iname'], $_POST['description'],  $_POST['price'], $_POST['category'], $session->getId(), $_FILES['img1']['name']);
Item::register_item_images($dbh, array($_FILES['img1']['name'], $_FILES['img2']['name']));

upload_image('img1');
upload_image('img2');


header('Location: ../pages/profile.php');