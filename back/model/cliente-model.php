<?php
include_once '../config/database.php';

class ClienteModel {

    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function listarClientes() {
        try {
            $stmt = $this->conn->query("SELECT * FROM cliente");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Handle errors here
            error_log("Erro ao listar clientes: " . $e->getMessage());
            return false;
        }
    }

    public function adicionarCliente($dados) {
        $sql = "INSERT INTO cliente (Nome, Data_Nascimento, Cpf, Rg, Telefone) VALUES (:nome, :data_nascimento, :cpf, :rg, :telefone)";

        try {
            $query = $this->conn->prepare($sql);

            $query->bindParam(':nome', $dados['Nome']);
            $query->bindParam(':data_nascimento', $dados['Data_Nascimento']);
            $query->bindParam(':cpf', $dados['Cpf']);
            $query->bindParam(':rg', $dados['Rg']);
            $query->bindParam(':telefone', $dados['Telefone']);

            $query->execute();

            return $this->conn->lastInsertId();
        } catch (PDOException $e) {
            // Handle errors here
            error_log("Erro ao inserir cliente: " . $e->getMessage());
            return false;
        }
    }

    public function editarCliente($id, $novosDados) {
        try {
            $stmt = $this->conn->prepare("UPDATE cliente SET Nome=?, Data_Nascimento=?, Cpf=?, Rg=?, Telefone=? WHERE idCliente=?");
            $stmt->execute([$novosDados['Nome'], $novosDados['Data_Nascimento'], $novosDados['Cpf'], $novosDados['Rg'], $novosDados['Telefone'], $id]);
        } catch (PDOException $e) {
            // Handle errors here
            error_log("Erro ao editar cliente: " . $e->getMessage());
        }
    }

    public function excluirCliente($id) {
        try {
            $stmt = $this->conn->prepare("DELETE FROM cliente WHERE idCliente=?");
            $stmt->execute([$id]);
        } catch (PDOException $e) {
            // Handle errors here
            error_log("Erro ao excluir cliente: " . $e->getMessage());
        }
    }
}
