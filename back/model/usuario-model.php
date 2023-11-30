<?php
include_once '../config/database.php';

class UsuarioModel {

    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getUsuario($idUsuario) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM usuario WHERE idUsuario = ?");
            $stmt->execute([$idUsuario]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao obter usuário: " . $e->getMessage());
            return false;
        }
    }

    public function adicionarUsuario($dados) {
        $sql = "INSERT INTO usuario (Nome, Email, Senha) VALUES (:nome, :Email, :senha)";

        try {
            $query = $this->conn->prepare($sql);

            $query->bindParam(':nome', $dados['Nome']);
            $query->bindParam(':email', $dados['Email']);
            $query->bindParam(':senha', $dados['Senha']);

            $query->execute();

            return $this->conn->lastInsertId();
        } catch (PDOException $e) {
            error_log("Erro ao inserir usuário: " . $e->getMessage());
            return false;
        }
    }

    public function editarUsuario($idUsuario, $novosDados) {
        $sql = "UPDATE usuario SET Nome = :nome, Email = :Email, Senha = :senha WHERE idUsuario = :id";

        try {
            $query = $this->conn->prepare($sql);

            $query->bindParam(':id', $idUsuario);
            $query->bindParam(':nome', $novosDados['Nome']);
            $query->bindParam(':email', $novosDados['Email']);
            $query->bindParam(':senha', $novosDados['Senha']);

            $query->execute();

            return true;
        } catch (PDOException $e) {
            error_log("Erro ao editar usuário: " . $e->getMessage());
            return false;
        }
    }

    public function excluirUsuario($idUsuario) {
        $sql = "DELETE FROM usuario WHERE idUsuario = :id";

        try {
            $query = $this->conn->prepare($sql);
            $query->bindParam(':id', $idUsuario);
            $query->execute();

            return true;
        } catch (PDOException $e) {
            error_log("Erro ao excluir usuário: " . $e->getMessage());
            return false;
        }
    }
}
