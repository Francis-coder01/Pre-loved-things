<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/item.class.php');
    require_once(__DIR__ . '/../database/user.class.php');
    require_once(__DIR__ . '/../database/tags.class.php');

    require_once(__DIR__ . '/../templates/user.tpl.php');
    require_once(__DIR__ . '/../templates/item.tpl.php');

    $dbh = get_database_connection();

    $items = array();
    if ($session->isLoggedIn()) {
        $items = User::get_cart_items($dbh, $session->getId());
    }
    else {
        if ($session->hasItemsCart()) $items = Item::get_items_in_array($dbh, $session->getCart());
    }
    $items = Item::sort_by_user($items);
    get_header("cart", $dbh, $session);
    draw_cart($dbh, $items, $session);
    draw_footer();


