<?php
class User
{
    public $username;
    public $password;
    public $name;
    public $phone;
    public $email;
    public $address;
    public $role;

    public static function getAll($pdo)
    {
        $sql = "SELECT * FROM user";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute()) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
            return $stmt->fetchAll();
        }
        return null;
    }
    public static function search($pdo, $search, $page = 1)
    {
        $record_per_page = 7;
        $offset = ($page - 1) * $record_per_page;
        $sql = "SELECT * FROM user WHERE username LIKE '%" . $search . "%' OR name LIKE '%" . $search . "%'";
        if ($page != 0) {
            $sql .= " LIMIT " . $offset . ", " . $record_per_page . "";
        }
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute()) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
            return $stmt->fetchAll();
        }
        return null;
    }
    public static function findUsername($pdo, $username)
    {
        $sql = "SELECT * FROM user WHERE username = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':username', $username);

        if ($stmt->execute()) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
            return $stmt->fetch();
        }
        return null;
    }
    public static function findEmail($pdo, $email)
    {
        $sql = "SELECT * FROM user WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);

        $stmt->execute();
        return $stmt->rowCount() == 1;
    }
    public static function check_login($pdo, $username, $password)
    {
        $user = User::findUsername($pdo, $username);
        if ($user == null) {
            return "Đăng nhập không thành công.";
        } else {
            if ($user->role == "admin") {
                if (password_verify($password, $user->password)) {
                    $_SESSION['logged_user'] = $user->name;
                    $_SESSION['logged_username'] = $username;
                    return header("location: admin/home_admin.php");
                } else {
                    return "Đăng nhập không thành công.";
                }
            } else {
                if (password_verify($password, $user->password)) {
                    $_SESSION['logged_user'] = $user->name;
                    $_SESSION['logged_username'] = $username;
                    return header("location: index.php");
                } else {
                    return "Đăng nhập không thành công.";
                }
            }
        }
    }
    public static function logout()
    {
        unset($_SESSION['logged_user']);
        header("location: .../BILLY/index.php");
        exit;
    }
    public static function register($pdo, $username, $password, $name, $phone, $email, $address, $role)
    {
        $sql = "INSERT INTO user (username, password, name, phone, email, address, role) VALUES (:username, :password, :name, :phone, :email, :address, :role)";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':username', $username);
        $Hash_Password = password_hash($password, PASSWORD_DEFAULT);
        $stmt->bindParam(':password', $Hash_Password);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':role', $role);

        if ($stmt->execute())
            return true;
        return false;
    }
    public static function changePassword($pdo, $username, $password)
    {
        $Hash_Password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE user SET password = '" . $Hash_Password . "' WHERE username = '" . $username . "'";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute())
            return true;
        return false;
    }
    public static function updateUser($pdo, $username, $name, $phone, $email, $address, $role)
    {
        $sql = "UPDATE user 
        SET name = '" . $name . "',
        phone = " . $phone . ",
        email = '" . $email . "',
        address = '" . $address . "',
        role = '" . $role . "'
        WHERE username = '" . $username . "'";

        $stmt = $pdo->prepare($sql);
        if ($stmt->execute())
            return true;
        return false;
    }
    public static function deleteUser($pdo, $username)
    {
        $sql = "DELETE FROM user WHERE username = '" . $username . "'";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute())
            return true;
        return false;
    }
}
