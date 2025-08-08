<?php
class Database
{
    
    protected $pdo;

    public function __construct()
    {
        $this->pdo = new PDO("mysql:host=localhost;dbname=sell_products", 'root', '');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function query($sql, $params = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
}
