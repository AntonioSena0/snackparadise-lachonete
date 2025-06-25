<?php
class Conectar extends PDO
{
    private static $instancia;
    private $query;
    private $host = "127.0.0.1"; //servidor da etec 3306 casa
    private $usuario = "root"; //idem etec e casa
    private $senha = ""; //se aplica ao server Etec / Senha casa MariaDb 465877
    private $db = "snack"; // nome Sql / importar para casa sempre

    public function __construct ()
    {
        parent::__construct("mysql:host=$this->host;dbname=$this->db","$this->usuario","$this->senha");
    }

    // getInstance

    public static function getInstance()
    {
        if(!isset(self::$instancia))
        {
            try {
                self::$instancia = new Conectar;
                echo 'Conectado com sucesso';
            } catch (Exception $e) {
                echo 'Erro de Conexão';
                exit();
            }
        }
        return self::$instancia;
    }

    public function sql ($query)
    {
        $pdo = self::getInstance();
        $this->query = $query;
        $stmt = $pdo->prepare($this->query);
        $stmt->execute();
        $pdo = null;
    }
}
?>