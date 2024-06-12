<?php
class Cart
{
    public $cart_id;
    public $username;
    public $product_id;
    public $amount;
    public $price;
    public $total;

    public static function getAll($pdo)
    {
        $sql = "SELECT * FROM cart";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute()) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Cart');
            return $stmt->fetchAll();
        }
    }
    public static function getOneCart($data, $username)
    {
        $result = [];
        foreach ($data as $item) {
            if ($item->username == $username) {
                $result[] = $item;
            }
        }
        return (object)$result;
    }
    public static function checkProduct($data_cart, $product_id)
    {
        foreach ($data_cart as $cart) {
            if ($cart->product_id == $product_id) {
                return $cart;
            }
        }
        return null;
    }
    public static function addCart($pdo, $product_id, $amount)
    {
        $data = Product::getAll($pdo, "", "", "", 0, 0);
        $sql = "INSERT INTO cart (username, product_id, amount, price, total) VALUES (:username, :product_id, :amount, :price, :total)";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':username', $_SESSION['logged_username']);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->bindParam(':amount', $amount);
        $price = Product::getOne($data, $product_id)->price;
        $stmt->bindParam(':price', $price);
        $total = $price * $amount;
        $stmt->bindParam(':total', $total);
   
        if ($stmt->execute())
            return true;
        return false;
    }
    public static function updateAmount($pdo, $amount, $product_id){
        $sql = "UPDATE cart 
        SET amount = amount + " .$amount. ", 
        total = amount * price 
        WHERE product_id = ".$product_id." AND username = '".$_SESSION['logged_username']."'";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute())
            return true;
        return false;
    }
    public static function delete_cart_item($pdo, $product_id){
        $sql = "DELETE FROM cart WHERE product_id = ".$product_id." AND username = '".$_SESSION['logged_username']."'";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute())
            return true;
        return false;
    }
}
