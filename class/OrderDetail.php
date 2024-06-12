<?php
class OrderDetail
{
    public $order_id;
    public $product_id;
    public $quantity;
    public $price;
    public $total;

    public static function getOrderDetail($pdo, $order_id)
    {
        $sql = "SELECT * FROM orderdetail WHERE order_id = $order_id";
        $stmt = $pdo->prepare($sql);

        if ($stmt->execute()) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'OrderDetail');
            return $stmt->fetchAll();
        }
        return null;
    }
    public static function createOrderDetail($pdo, $order_id, $product_id, $quantity, $price, $total)
    {
        try {
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO orderdetail (order_id, product_id, quantity, price, total) 
            VALUES (:order_id, :product_id, :quantity, :price, :total)";
            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(':order_id', $order_id);
            $stmt->bindParam(':product_id', $product_id);
            $stmt->bindParam(':quantity', $quantity);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':total', $total);

            if ($stmt->execute())
                return true;
            return false;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
