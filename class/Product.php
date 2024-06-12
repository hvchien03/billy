<?php
class Product
{
    public $product_id;
    public $name;
    public $price;
    public $image;
    public $category;
    public $description;


    public static function getAll($pdo, $search = "", $column = "", $order = "", $cateid = 0, $page = 1)
    {
        $record_per_page = 9;
        $offset = ($page - 1) * $record_per_page;
        $sql = "SELECT * FROM product WHERE name LIKE '%"
            . $search . "%'";
        if ($cateid != 0) {
            $sql = "SELECT * FROM product WHERE category = $cateid";
        }
        if ($column != "" && $order != "" && $cateid == 0) {
            $sql = "SELECT * FROM product WHERE name LIKE '%"
                . $search . "%' ORDER BY $column $order";
        }
        if ($column != "" && $order != "" && $cateid != 0) {
            $sql = "SELECT * FROM product WHERE category = '"
                . $cateid . "' ORDER BY $column $order";
        }
        if ($page != 0) {
            $sql .= " LIMIT " . $offset . ", " . $record_per_page . "";
        }
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute()) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Product');
            return $stmt->fetchAll();
        }
    }

    public static function getOne($data, $product_id)
    {
        foreach ($data as $item) {
            if ($item->product_id == $product_id) {
                return $item;
            }
        }
        return null;
    }
    public static function getOneById($pdo, $product_id)
    {
        $sql = "SELECT * FROM product WHERE product_id = :product_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':product_id', $product_id);
        if ($stmt->execute()) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Product');
            return $stmt->fetch();
        }
    }

    public static function addProduct($pdo, $name, $price, $image, $category, $description)
    {
        try {
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO product (name, price, image, category, description) VALUES (:name, :price, :image, :category, :description)";
            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':price', $price);
            if (empty($image)) {
                $image = "no-image.png";
            }
            $stmt->bindParam(':image', $image);
            $stmt->bindParam(':category', $category);
            $stmt->bindParam(':description', $description);
            if ($stmt->execute())
                return true;
            return false;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    public static function delete($pdo, $product_id)
    {
        $sql = "DELETE FROM product WHERE product_id = :product_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':product_id', $product_id);
        if ($stmt->execute())
            return true;
        return false;
    }
    public static function update($pdo, $product_id, $name, $price, $image, $category, $description)
    {
        if (empty($image)) {
            $sql = "UPDATE product SET name=:name, price=:price, category=:category, description=:description WHERE product_id=:product_id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':product_id', $product_id);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':category', $category);
            $stmt->bindParam(':description', $description);
            if ($stmt->execute())
                return true;
            return false;
        } else {
            $sql = "UPDATE product SET name=:name, price=:price, image=:image, category=:category, description=:description WHERE product_id=:product_id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':product_id', $product_id);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':image', $image);
            $stmt->bindParam(':category', $category);
            $stmt->bindParam(':description', $description);
            if ($stmt->execute())
                return true;
            return false;
        }
    }
}
