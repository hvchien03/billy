<?php
class Orders
{
    public $order_id;
    public $username;
    public $date;
    public $total;
    public $payment_status;
    public $delivery_status;
    public $delivery_address;
    public static function get_all_orders($pdo)
    {
        $sql = "SELECT * FROM orders ORDER BY order_id DESC";

        $stmt = $pdo->prepare($sql);
        if ($stmt->execute()) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Orders');
            return $stmt->fetchAll();
        }
        return null;
    }
    public static function get_order($pdo, $username)
    {
        $sql = "SELECT * FROM orders";
        if (!empty($username)) {
            $sql = $sql . " WHERE username = '" . $username . "'";
        }
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute()) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Orders');
            return $stmt->fetchAll();
        }
        return null;
    }
    public static function get_id($pdo, $username, $date)
    {
        $sql = "SELECT * FROM orders WHERE username = '$username' AND date = '$date'";
        $stmt = $pdo->prepare($sql);

        if ($stmt->execute()) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Orders');
            return $stmt->fetch();
        }
        return null;
    }
    public static function get_orders_by_id($pdo, $id)
    {
        $sql = "SELECT * FROM orders WHERE order_id = $id";
        $stmt = $pdo->prepare($sql);

        if ($stmt->execute()) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Orders');
            return $stmt->fetch();
        }
        return null;
    }
    public static function create_Order($pdo, $username, $date, $total, $payment_status, $delivery_status, $delivery_address)
    {
        try {
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO orders (username, date, total, payment_status, delivery_status, delivery_address) 
            VALUES (:username, :date, :total, :payment_status, :delivery_status, :delivery_address)";
            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':date', $date);
            $stmt->bindParam(':total', $total);
            $stmt->bindParam(':payment_status', $payment_status);
            $stmt->bindParam(':delivery_status', $delivery_status);
            $stmt->bindParam(':delivery_address', $delivery_address);
            if ($stmt->execute())
                return true;
            return false;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    public static function cancel_order($pdo, $order_id)
    {
        try {
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "DELETE FROM orders WHERE order_id = $order_id and delivery_status = 'Chưa duyệt'";
            $stmt = $pdo->prepare($sql);
            if ($stmt->execute())
                return true;
            return false;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    public static function updateStatus($pdo, $order_id, $status)
    {
        try {
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE orders SET delivery_status = :status WHERE order_id = :order_id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':order_id', $order_id);
            if ($stmt->execute())
                return true;
            return false;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
