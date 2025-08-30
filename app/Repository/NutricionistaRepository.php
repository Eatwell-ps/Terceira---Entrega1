<?php
namespace App\Repositories;

use App\Core\Repository;

class NutricionistaRepository extends Repository {
    protected $table = 'nutricionistas';

    public function create(array $data) {
        $sql = "INSERT INTO {$this->table} (nome, email, telefone, crn, especialidade) 
                VALUES (:nome, :email, :telefone, :crn, :especialidade)";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':nome' => $data['nome'],
            ':email' => $data['email'],
            ':telefone' => $data['telefone'],
            ':crn' => $data['crn'],
            ':especialidade' => $data['especialidade']
        ]);
    }

    public function update($id, array $data) {
        $sql = "UPDATE {$this->table} SET 
                nome = :nome, email = :email, telefone = :telefone, 
                crn = :crn, especialidade = :especialidade 
                WHERE id = :id";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':nome' => $data['nome'],
            ':email' => $data['email'],
            ':telefone' => $data['telefone'],
            ':crn' => $data['crn'],
            ':especialidade' => $data['especialidade'],
            ':id' => $id
        ]);
    }

    public function search($term) {
        $sql = "SELECT * FROM {$this->table} 
                WHERE nome LIKE :term 
                OR email LIKE :term 
                OR crn LIKE :term 
                OR especialidade LIKE :term";
        
        $stmt = $this->db->prepare($sql);
        $searchTerm = "%{$term}%";
        $stmt->bindParam(':term', $searchTerm);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function findByCRN($crn) {
        $sql = "SELECT * FROM {$this->table} WHERE crn = :crn";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':crn', $crn);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function findByEmail($email) {
        $sql = "SELECT * FROM {$this->table} WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getClientesByNutricionista($nutricionistaId) {
        $sql = "SELECT c.* FROM clientes c
                INNER JOIN plano_alimentar pa ON c.id = pa.cliente_id
                WHERE pa.nutricionista_id = :nutricionista_id
                GROUP BY c.id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nutricionista_id', $nutricionistaId);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getPlanosByNutricionista($nutricionistaId) {
        $sql = "SELECT pa.*, c.nome as cliente_nome 
                FROM plano_alimentar pa
                INNER JOIN clientes c ON pa.cliente_id = c.id
                WHERE pa.nutricionista_id = :nutricionista_id
                ORDER BY pa.data_inicio DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nutricionista_id', $nutricionistaId);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getEstatisticas($nutricionistaId) {
        $sql = "SELECT 
                COUNT(DISTINCT pa.cliente_id) as total_clientes,
                COUNT(pa.id) as total_planos,
                AVG(DATEDIFF(pa.data_fim, pa.data_inicio)) as media_dias_plano,
                (SELECT COUNT(*) FROM avaliacoes a 
                 INNER JOIN plano_alimentar pa2 ON a.cliente_id = pa2.cliente_id 
                 WHERE pa2.nutricionista_id = :nutricionista_id) as total_avaliacoes
                FROM plano_alimentar pa
                WHERE pa.nutricionista_id = :nutricionista_id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nutricionista_id', $nutricionistaId);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getTopNutricionistas($limit = 5) {
        $sql = "SELECT n.*, COUNT(pa.id) as total_planos
                FROM nutricionistas n
                LEFT JOIN plano_alimentar pa ON n.id = pa.nutricionista_id
                GROUP BY n.id
                ORDER BY total_planos DESC
                LIMIT :limit";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}