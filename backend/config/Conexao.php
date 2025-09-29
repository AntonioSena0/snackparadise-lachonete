<?php
class Conectar extends PDO
{
    private static $instancia;
    private $host = "127.0.0.1";
    private $usuario = "root";
    private $senha = "";
    private $db = "snack";

    public function __construct()
    {
        try {
            parent::__construct("mysql:host=$this->host;dbname=$this->db", $this->usuario, $this->senha);
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new Exception("Erro de conexão: " . $e->getMessage());
        }
    }

    public static function getInstance()
    {
        if(!isset(self::$instancia)) {
            try {
                self::$instancia = new Conectar();
            } catch (Exception $e) {
                throw new Exception("Erro de Conexão: " . $e->getMessage());
            }
        }
        return self::$instancia;
    }

    public function sql($query)
    {
        $pdo = self::getInstance();
        $stmt = $pdo->prepare($query);
        return $stmt->execute();
    }
}
?>