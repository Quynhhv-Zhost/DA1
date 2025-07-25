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
        // Lấy thông tin sản phẩm
        $stmt = $this->query("SELECT * FROM products WHERE id = ?", [$id]);
        $product = $stmt->fetch();

        // Lấy các biến thể của sản phẩm
        $variations = $this->query("SELECT * FROM product_variations WHERE product_id = ?", [$id])->fetchAll();

        // Tính giá cuối cùng của biến thể
        foreach ($variations as &$variation) {
            // Tính giá của biến thể dựa trên giá gốc của sản phẩm cộng với price_diff
            $variation['final_price'] = $product['price'] + $variation['price_diff'];
        }

        // Gắn biến thể vào sản phẩm
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
}
