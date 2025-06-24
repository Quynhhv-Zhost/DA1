<?php
class Product extends Model
{
    protected $table = "products"; // Tên bảng
    private $conn;
    // Phương thức khởi tạo
    public function __construct()
    {
        $this->conn = new Model();
    }
    // Lấy ra tất cả bản ghi 
    public function getAllProduct()
    {
        $this->conn->setSql("SELECT * FROM $this->table");
        return $this->conn->all();
    }
    public function getIDProduct($id)
    {
        $this->conn->setSql("SELECT * FROM $this->table WHERE `id`= ?");
        return $this->conn->first([$id]);
    }
    public function addProduct($id, $name, $price, $image, $quantity)
    {
        $this->conn->setSql("INSERT INTO $this->table VALUES (?,?,?,?,?)");
        return $this->conn->execute([$id, $name, $price, $image, $quantity]);
    }
    public function editProduct($name, $price, $image, $quantity, $id)
    {
        $this->conn->setSql("UPDATE $this->table SET `name`= ?,`price`= ?,`image`= ?,`quantity`= ? WHERE `id`= ?");
        return $this->conn->execute([$name, $price, $image, $quantity, $id]);
    }
    public function deleteProduct($id)
    {
        $this->conn->setSql("DELETE FROM $this->table WHERE `id`= ?");
        return $this->conn->execute([$id]);
    }
}
