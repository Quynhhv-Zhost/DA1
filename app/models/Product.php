<?php
class Product extends Database
{
    // Lấy tất cả sản phẩm
    public function getAll()
    {
        return $this->query("SELECT * FROM products ORDER BY id DESC")->fetchAll();
    }

    // Lấy chi tiết 1 sản phẩm theo ID
    public function getById($id)
    {
        $stmt = $this->query("SELECT * FROM products WHERE id = ?", [$id]);
        $product = $stmt->fetch();

        $variations = $this->query("SELECT * FROM product_variations WHERE product_id = ?", [$id])->fetchAll();
        $product['variations'] = $variations;

        return $product;
    }
    public function getVariationById($variationId)
    {
        $stmt = $this->query("SELECT * FROM product_variations WHERE id = ?", [$variationId]);
        return $stmt->fetch();
    }


    // Thêm sản phẩm mới
    public function insert($data)
    {
        return $this->query("INSERT INTO products(name, price, description, image) VALUES(?, ?, ?, ?)", $data);
    }

    // Cập nhật sản phẩm
    public function update($id, $data)
    {
        return $this->query(
            "UPDATE products SET name=?, price=?, description=?, image=? WHERE id=?",
            [...$data, $id]
        );
    }

    // Xoá sản phẩm
    public function delete($id)
    {
        return $this->query("DELETE FROM products WHERE id = ?", [$id]);
    }

    //hàm tìm kiếm sản phẩm
    public function searchByname($name)
    {
        //tìm sản phẩm chứa chuỗi tìm kiếm (like %...%)
        return $this->query(
            "SELECT * FROM products WHERE name LIKE ? ORDER BY id DESC",
            ['%' . $name . '%']
        )->fetchAll();
    }
}
