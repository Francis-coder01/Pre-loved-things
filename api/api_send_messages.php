<?php
    require_once (__DIR__ . "/../database/message.class.php");
    require_once (__DIR__ . "/../database/connection.db.php");

    $chatroom = intval($_GET['chatroom']);
    $sender = intval($_GET['sender']);
    $message = $_GET['message'];

    $db = get_database_connection();

    Message::send_message($db, $chatroom, $sender, $message);
    echo "OK";