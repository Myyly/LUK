<?php
class Database {
    private $servername = "localhost"; 
    private $username = "root";
    private $password = ""; 
    private $dbname = "LUX_SocialNetwwork"; 
    private $conn;

    public function __construct() {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        if ($this->conn->connect_error) {
            die("Kết nối đến cơ sở dữ liệu thất bại: " . $this->conn->connect_error);
        }
    }
    public function getConnection() {
        return $this->conn;
    }
}
// $database = new Database();
// $conn = $database->getConnection();
// if ($conn) {
//     echo "Kết nối đến cơ sở dữ liệu thành công!";
// } else {
//     echo "Kết nối không thành công.";
// }
// $conn->close();
?>
