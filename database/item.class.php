<?php
declare(strict_types = 1);
require_once ('database/connection.db.php');

class Item {
    public int $id;
    public string $name;
    public array $images;
    public float $price;
    public string $description;
    public string $category;
    public int $quantity;
    public string $model;
    public string $brand;
    public string $condition;
    public string $size;
    public string $date;
    public string $user;
    public function __construct(PDO $db, int $id)
    {
        $this->id = $id;
        $this->images = get_item_images($db, $id);
    }

    public static function create_item(PDO $dbh, array $item): Item
    {
        $new_item = new Item($dbh, $item['id']);
        $new_item->brand = $item['brand'] != null ? $item['brand'] : "";
        $new_item->condition = $item['condition'] != null ? $item['condition'] : "";
        $new_item->price = $item['price'] != null ? $item['price'] : 0.0;
        $new_item->description = $item['description'] != null ? $item['description'] : "";
        $new_item->category = $item['category'] != null ? $item['category'] : "";
        $new_item->quantity = $item['quantity'] != null ? $item['quantity'] : 0;
        $new_item->model = $item['model'] != null ? $item['model'] : "";
        $new_item->size = $item['size'] != null ? $item['size'] : "";
        $new_item->name = $item['name'] != null ? $item['name'] : "";
        $new_item->user = $item['user'] != null ? $item['user'] : "";
        return $new_item;
    }

    public static function create_items(PDO $dbh, array $items): array
    {
        $new_items = array();
        foreach ($items as $item) {
            $new_items[] = self::create_item($dbh, $item['id']);
        }
        return $new_items;
    }

    public function get_main_image(): string
    {
        return $this->images[array_key_first($this->images)];
    }

    static function get_item_images(PDO $dbh, int $id) : array
    {
        $stmt = $dbh->prepare('SELECT imagePath FROM item_images WHERE item = ?');
        $stmt->execute(array($id));
        $images = array();
        while ($image = $stmt->fetch()) {
            $images[] = $image['imagePath'];
        }
        return $images;
    }
    static function get_items(PDO $dbh, int $count) : array {
        $stmt = $dbh->prepare('SELECT * FROM items LIMIT ?');
        $stmt->execute(array($count));
        return self::create_items($dbh, $stmt->fetchAll());
    }
    static function get_items_category(PDO $dbh, string $category) : array {
        $stmt = $dbh->prepare('SELECT * FROM items WHERE category = ?');
        $stmt->execute(array($category));
        return self::create_items($dbh, $stmt->fetchAll());
    }
    static function get_item(PDO $dbh, int $id) : Item{
        $stmt = $dbh->prepare('SELECT * FROM items WHERE id = ?');
        $stmt->execute(array($id));

        return self::create_item($dbh, $stmt->fetch());

    }
    static function get_user_items(PDO $dbh, string $username): array {
        $stmt = $dbh->prepare('SELECT * FROM items WHERE user = ?');
        $stmt->execute(array($username));
        return self::create_items($dbh, $stmt->fetchAll());
    }

    static function get_items_by_search(PDO $dbh, string $q): array
    {
        $stmt = $dbh->prepare(
            'SELECT * 
                FROM items 
                WHERE name LIKE ?'
        );
        $stmt->execute(array("%$q%"));

        return self::create_items($dbh, $stmt->fetchAll());
    }

    static function get_items_by_search_cat(PDO $dbh, string $q, string $cat): array
    {
        $stmt = $dbh->prepare(
            'SELECT * 
                FROM items 
                WHERE name LIKE ? AND category = ?'
        );
        $stmt->execute(array("%$q%", $cat));

        return self::create_items($dbh, $stmt->fetchAll());
    }

    static function get_items_by_range(PDO $dbh, int $first, int $second): array
    {
         $stmt = $dbh->prepare(
            'SELECT * 
                FROM items 
                WHERE price >= ? AND price <= ?'
        );
        $stmt->execute(array($first, $second));

        return self::create_items($dbh, $stmt->fetchAll());
    }

    static function get_items_by_condition(PDO $dbh, string $condition): array
    {
        $stmt = $dbh->prepare('SELECT * FROM items WHERE condition = ?');
        $stmt->execute(array($condition));

        return self::create_items($dbh, $stmt->fetchAll());
    }

    static function get_cart_items(PDO $dbh, string $user): array
    {
        $stmt = $dbh->prepare('SELECT user_cart.user, user_cart.item, items.user
    FROM user_cart JOIN items ON user_cart.item = items.id  WHERE user = ?');
        $stmt->execute(array($user));

        return self::create_items($dbh, $stmt->fetchAll());
    }
    static function get_items_user(PDO $dbh, string $user): array
    {
        $stmt = $dbh->prepare('SELECT * FROM items WHERE user = ?');
        $stmt->execute(array($user));

        return self::create_items($dbh, $stmt->fetchAll());
    }

    static function register_item(PDO $db, string $name, string $description, string $price, string $category, string $user) {
        $stmt = $db->prepare('INSERT INTO items (name, description, price, category, user) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([$name, $description, $price, $category, $user]);
    }
    static function register_item_images(PDO $db, array $images)
    {
        $stmt = $db->prepare('SELECT last_insert_rowid()');
        $stmt->execute();
        $id = $stmt->fetchColumn();
        foreach ($images as $image) {
            $stmt = $db->prepare('INSERT INTO item_images (item, imagePath) VALUES (?, ?)');
            $stmt->execute([$id, $image]);
        }
    }
}