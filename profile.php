<?php

    declare(strict_types=1);
    session_start();

    require_once('database/connection.db.php');
    require_once('database/users.db.php');
    require_once ('database/item.class.php');
    require_once('templates/user.tpl.php');
    require_once('templates/common.tpl.php');
    require_once('templates/item.tpl.php');

    $db = get_database_connection();
    draw_header("profile");
    ?>
    <article class="userPage">
    <?php
    $username = $_SESSION['username'];
    $user = get_user($db, $username);
    $feedback = get_user_feedback($db, $username);
    $items = Item::get_user_items($db, $username);
    draw_profile_details($user);
    draw_user_feedback($user, $feedback); ?>
        <a href="new.php" class="logout">New Item</a>
    <?php foreach ($items as $item) {
        draw_item($item);
    }
    ?> </article>
<?php
    draw_footer();