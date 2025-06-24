<?php
// Nhận thấy tất các file ở tầng model đều cần kết 
// CSDL và thực thi câu lênh sql
// Nếu để mỗi file tự làm hết công việc như kết nối,..
// Dễ lặp code và rất dài
// Viết lớp cha có sẵn các tính đó để lớp kết thừa và giảm 
// thao tac
class Model
{
    // NV1: Kết nối đến csdl 
    // Các thuộc tính kết nối
    // Công thức tạo thuộc tính:
    // phạm_vi_truy_cập $tên_thuộc_tinh = giá_trị; (có thể gán giá trị luôn 
    // hoặc không)
    // phạm_vi_truy_cập: public, private, protected
    // private $host = "localhost"; //địa chỉ mysql server sẽ kết nối đến
    // private $dbname="web2041.02"; //tên database sẽ kết nối đến
    // private $username = "root"; //username để kết nối đến database 
    // private $password = ""; // mật khẩu để kết nối đến database
    // Tạo thuộc tính kết nối
    private $pdo;
    // Thuộc tính chứa SQL
    private $sql;
    // Thuộc tính lưu kết quả 
    private $sta;
    // Phương khởi tạo
    public function __construct()
    {
        $this->pdo = $this->getConnection();
    }
    // Phương thức kết nối csdl
    // 1: Viết test => public
    // 2: Sau khi test ok => private
    // Trong class gọi thuộc tính hay phương thức thì dùng $this->tentt/tenpt
    private function getConnection()
    {
        try {
            $connection = new PDO(
                "mysql:host=" . DB_HOST . "; 
                dbname=" . DB_NAME . ";",
                DB_USER,
                DB_PASS,
                DB_OPTIONS
            );
            // Dùng để test
            // if($connection){
            //     return "Kết nối thành công";
            // }
            return $connection;
        } catch (PDOException $e) {
            throw new Exception("Lỗi kết nối csdl: " . $e->getMessage());
        }
    }
    // Phưowng thức để nhân câu lệnh sql
    protected function setSql($sql)
    {
        $this->sql = $sql;
    }
    // Phương thực thi câu sql
    // Câu lệnh => nhưng câu cần nhập dự từ bên ngoài vào (có thể nhiều)
    protected function execute($option = [])
    {
        try {
            $this->sta = $this->pdo->prepare($this->sql);
            if (!empty($option)) {
                foreach ($option as $key => $value) {
                    $this->sta->bindValue($key + 1, $value);
                    // Sử dung bindValue, tự động xác đinh kiểu dữ liệu
                }
            }
            $this->sta->execute();
            return $this->sta;
        } catch (PDOException $e) {
            throw new Exception("Lỗi kết nối csdl: " . $e->getMessage());
        }
    }
    // Phương thức truy dự liệu và trả về kết quả 
    // có nhiều kết quả và 1 kết quả 
    const FETCH_ALL = 'all';
    const FETCH_FIRST = 'first';
    protected function executeQuery($option = [], $fetchModel = self::FETCH_ALL)
    {
        $result = $this->execute($option);
        if (!$result) {
            return false;
        }
        return $fetchModel == self::FETCH_ALL
            ? $result->fetchAll(PDO::FETCH_OBJ)
            : $result->fetch(PDO::FETCH_OBJ);
    }
    protected function all($option = [])
    {
        return $this->executeQuery($option);
    }
    protected function first($option = [])
    {
        return $this->executeQuery($option, self::FETCH_FIRST);
    }
}
