<?php
class Message{
    public $message_id;
    public $name;
    public $email;
    public $message;
    public $date;
    public $product_id;

    public static function getOneMessage($pdo, $product_id)
    {
        $sql = "SELECT * FROM reviews WHERE product_id = $product_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_CLASS, "Message");
        return $data;
    }
    public static function addReview($pdo, $name, $email, $message, $product_id)
    {
        $sql = "INSERT INTO reviews (name, email, message, product_id) VALUES (:name, :email, :message, :product_id)";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':message', $message);
        $stmt->bindParam(':product_id', $product_id);
   
        if ($stmt->execute())
            return true;
        return false;
    }
}