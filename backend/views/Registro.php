<?php

include_once __DIR__ . '/../config/Conexao.php'; 

// Classe Produto
class Registro
{
    private int $id;
    private string $nome;
    private string $pasword;
    private string $email;
    private ?PDO $conn = null;

    // Getters e Setters
    public function getId(): int
    {
        return $this->id;
    }
    public function setId(int $id): void
    {
        $this->id = $id;
    }
    public function getNome(): string
    {
        return $this->nome;
    }
    public function setNome(string $nome): void
    {
        $this->nome = $nome;
    }
    public function getPasword(): string
    {
        return $this->pasword;
    }
    public function setPasword(string $pasword): void
    {
        $this->pasword = $pasword;
    }
    public function getEmail(): string
    {
        return $this->email;
    }
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
    // Método para inserir REGISTRO

    public function inserir()
    {
        try {
            $this->conn = new Conectar; // Conectar método getConnection()
            $sql = $this->conn->prepare("INSERT INTO produtos (Nome, Pasword, Email) VALUES (:nome, :pasword, :email)");
            $sql->bindValue(':nome', $this->getNome());
            $sql->bindValue(':pasword', $this->getPasword());
            $sql->bindValue(':email', $this->getEmail());
            $sql->execute();
            $this->conn = null; // Fechar conexão
        } catch (PDOException $exc) {
            echo "Erro ao executar consulta: " . $exc->getMessage();
        }
    }
    // Método para editar registro
    public function editar()
    {
        try {
            $this->conn = new Conectar; // Conectar método getConnection()
            $sql = $this->conn->prepare("UPDATE produtos SET Nome = :nome, Pasword = :pasword, Email = :email WHERE id = :id");
            $sql->bindValue(':id', $this->getId());
            $sql->bindValue(':nome', $this->getNome());
            $sql->bindValue(':pasword', $this->getPasword());
            $sql->bindValue(':email', $this->getEmail());
            $sql->execute();
            $this->conn = null; // Fechar conexão
        } catch (PDOException $exc) {
            echo "Erro ao executar consulta: " . $exc->getMessage();
        }
    }

    //metodo so pra alterar o email porraaaaaa
    public function editaremail()
    {
        try {
            $this->conn = new Conectar; // Conectar método getConnection()
            $sql = $this->conn->prepare("UPDATE users SET Email = :email WHERE id = :id");
            @$sql->bindValue(':id', $this->getId());
            @$sql->bindValue(':email', $this->getEmail());
            $sql->execute();
            $this->conn = null; // Fechar conexão
        } catch (PDOException $exc) {
            echo "Erro ao executar consulta: " . $exc->getMessage();
        }
    }
    // Método para excluir registro

    public function excluir()
    {
        try {
            $this->conn = new Conectar; // Conectar método getConnection()
            $sql = $this->conn->prepare("DELETE FROM produtos WHERE id = :id");
            $sql->bindValue(':id', $this->getId());
            $sql->execute();
            $this->conn = null; // Fechar conexão
        } catch (PDOException $exc) {
            echo "Erro ao executar consulta: " . $exc->getMessage();
        }
    }

    // Método para listar registros
    public function listar()
    {
        try {
            $this->conn = new Conectar; // Conectar método getConnection()
            $sql = $this->conn->prepare("SELECT * FROM users");
            $sql->execute();
            $result = $sql->fetchAll(PDO::FETCH_ASSOC);
            $this->conn = null; // Fechar conexão
            return $result;
        } catch (PDOException $exc) {
            echo "Erro ao executar consulta: " . $exc->getMessage();
        }

        function logar()
        {
            try {
                $this-> conn = new Conectar; // Conectar método getConnection()
                $sql = $this->conn->prepare("SELECT * FROM users WHERE email = LIKE ? and pasword = :?");
                @$sql->bindValue(1, $this->getEmail());
                @$sql->bindValue(2, $this->getPasword());
                $sql->execute();
                return $sql->fetchAll();
                $this->conn = null; // Fechar conexão
            } catch (PDOException $exc) {
               echo "<span class='text-green-200'>Erro ao executar consulta: <span> " . $exc->getMessage();
                
            }
        }
    }
}
?>