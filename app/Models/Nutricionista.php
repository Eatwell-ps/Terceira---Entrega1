<?php
namespace App\Models;

use App\Core\Model;
use App\Repositories\NutricionistaRepository;

class Nutricionista extends Model {
    public $id;
    public $nome;
    public $email;
    public $telefone;
    public $crn;
    public $especialidade;
    public $data_cadastro;

    public function __construct() {
        parent::__construct(new NutricionistaRepository());
    }

    public function save() {
        $data = [
            'nome' => $this->nome,
            'email' => $this->email,
            'telefone' => $this->telefone,
            'crn' => $this->crn,
            'especialidade' => $this->especialidade
        ];

        if ($this->id) {
            return $this->repository->update($this->id, $data);
        } else {
            return $this->repository->create($data);
        }
    }

    public function getClientes() {
        return $this->repository->getClientesByNutricionista($this->id);
    }

    public function getPlanosAlimentares() {
        return $this->repository->getPlanosByNutricionista($this->id);
    }

    public function getEstatisticas() {
        return $this->repository->getEstatisticas($this->id);
    }
}