<?php
class Category
{
    public $category_id;
    public $category_name;

    public static function getAll($pdo)
    {
        $sql = "SELECT * FROM category";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute()) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Category');
            return $stmt->fetchAll();
        }
    }

    public static function getOne($pdo, $category_id)
    {
        $sql = "SELECT * FROM category WHERE category_id = " . $category_id . "";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute()) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Category');
            return $stmt->fetch();
            // return (object)$stmt->fetchAll()[0];
        }
        return null;
    }
    // public static function getAllName($pdo)
    // {
    //     $sql = "SELECT category_name FROM category";
    //     $stmt = $pdo->prepare($sql);
    //     if ($stmt->execute()) {
    //         $stmt->setFetchMode(PDO::FETCH_CLASS, 'Category');
    //         return $stmt->fetchAll();
    //     }
    // }
    public static function checkName($pdo, $cate_name)
    {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM category WHERE category_name = ?");
        $stmt->execute([$cate_name]);
        return $stmt->fetchColumn() > 0;
    }

    public static function addCate($pdo, $cate_name)
    {
        try {
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO category(category_name) VALUES (:cate_name)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':cate_name', $cate_name);
            if ($stmt->execute())
                return true;
            return false;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    public static function delete($pdo, $category_id)
    {
        $sql = "DELETE FROM category WHERE category_id = $category_id";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute())
            return true;
        return false;
    }
    public static function update($pdo, $id, $name)
    {
        try {
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE category SET category_name= :name WHERE category_id= :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':name', $name);
            if ($stmt->execute())
                return true;
            return false;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
