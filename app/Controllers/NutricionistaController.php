<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Nutricionista;

class NutricionistaController extends Controller {
    public function index() {
        $nutricionistaModel = new Nutricionista();
        $nutricionistas = $nutricionistaModel->all();
        
        $this->view('nutricionistas/index', [
            'nutricionistas' => $nutricionistas,
            'title' => 'Gerenciamento de Nutricionistas - EatWell'
        ]);
    }

    public function create() {
        if ($this->isPost()) {
            $nutricionista = new Nutricionista();
            
          
            $errors = $this->validarDados($_POST);
            if (!empty($errors)) {
                $this->view('nutricionistas/create', [
                    'errors' => $errors,
                    'nutricionista' => (object)$_POST,
                    'title' => 'Novo Nutricionista - EatWell'
                ]);
                return;
            }

            $nutricionista->nome = $this->sanitize($_POST['nome']);
            $nutricionista->email = $this->sanitize($_POST['email']);
            $nutricionista->telefone = $this->sanitize($_POST['telefone']);
            $nutricionista->crn = $this->sanitize($_POST['crn']);
            $nutricionista->especialidade = $this->sanitize($_POST['especialidade']);

            if ($nutricionista->save()) {
                $this->setFlash('success', 'Nutricionista cadastrado com sucesso!');
                $this->redirect('/nutricionistas');
            } else {
                $this->setFlash('error', 'Erro ao cadastrar nutricionista.');
                $this->view('nutricionistas/create', [
                    'nutricionista' => $nutricionista,
                    'title' => 'Novo Nutricionista - EatWell'
                ]);
            }
        } else {
            $this->view('nutricionistas/create', [
                'title' => 'Novo Nutricionista - EatWell'
            ]);
        }
    }

    public function edit($id) {
        $nutricionistaModel = new Nutricionista();
        $nutricionistaData = $nutricionistaModel->find($id);

        if (!$nutricionistaData) {
            $this->setFlash('error', 'Nutricionista não encontrado.');
            $this->redirect('/nutricionistas');
        }

        $nutricionista = new Nutricionista();
        foreach ($nutricionistaData as $key => $value) {
            $nutricionista->$key = $value;
        }

        if ($this->isPost()) {
            $errors = $this->validarDados($_POST, $id);
            if (!empty($errors)) {
                $this->view('nutricionistas/edit', [
                    'errors' => $errors,
                    'nutricionista' => (object)array_merge(['id' => $id], $_POST),
                    'title' => 'Editar Nutricionista - EatWell'
                ]);
                return;
            }

            $nutricionista->nome = $this->sanitize($_POST['nome']);
            $nutricionista->email = $this->sanitize($_POST['email']);
            $nutricionista->telefone = $this->sanitize($_POST['telefone']);
            $nutricionista->crn = $this->sanitize($_POST['crn']);
            $nutricionista->especialidade = $this->sanitize($_POST['especialidade']);

            if ($nutricionista->save()) {
                $this->setFlash('success', 'Nutricionista atualizado com sucesso!');
                $this->redirect('/nutricionistas');
            } else {
                $this->setFlash('error', 'Erro ao atualizar nutricionista.');
            }
        }

        $this->view('nutricionistas/edit', [
            'nutricionista' => $nutricionista,
            'title' => 'Editar Nutricionista - EatWell'
        ]);
    }

    public function view($id) {
        $nutricionistaModel = new Nutricionista();
        $nutricionistaData = $nutricionistaModel->find($id);

        if (!$nutricionistaData) {
            $this->setFlash('error', 'Nutricionista não encontrado.');
            $this->redirect('/nutricionistas');
        }

        $nutricionista = new Nutricionista();
        foreach ($nutricionistaData as $key => $value) {
            $nutricionista->$key = $value;
        }

   
        $clientes = $nutricionista->getClientes();
        $planos = $nutricionista->getPlanosAlimentares();
        $estatisticas = $nutricionista->getEstatisticas();

        $this->view('nutricionistas/view', [
            'nutricionista' => $nutricionista,
            'clientes' => $clientes,
            'planos' => $planos,
            'estatisticas' => $estatisticas,
            'title' => 'Perfil do Nutricionista - EatWell'
        ]);
    }

    public function delete($id) {
        $nutricionistaModel = new Nutricionista();
        
 
        $nutricionistaData = $nutricionistaModel->find($id);
        if ($nutricionistaData) {
            $nutricionista = new Nutricionista();
            foreach ($nutricionistaData as $key => $value) {
                $nutricionista->$key = $value;
            }
            
            $planos = $nutricionista->getPlanosAlimentares();
            if (!empty($planos)) {
                $this->setFlash('error', 'Não é possível excluir o nutricionista pois existem planos alimentares associados.');
                $this->redirect('/nutricionistas');
            }
        }

        if ($nutricionistaModel->delete($id)) {
            $this->setFlash('success', 'Nutricionista excluído com sucesso!');
        } else {
            $this->setFlash('error', 'Erro ao excluir nutricionista.');
        }
        
        $this->redirect('/nutricionistas');
    }

    public function search() {
        if ($this->isPost()) {
            $term = $this->sanitize($_POST['search']);
            $nutricionistaModel = new Nutricionista();
            $nutricionistas = $nutricionistaModel->search($term);
            
            $this->view('nutricionistas/index', [
                'nutricionistas' => $nutricionistas,
                'searchTerm' => $term,
                'title' => 'Resultados da Busca - Nutricionistas'
            ]);
        } else {
            $this->redirect('/nutricionistas');
        }
    }

    public function dashboard($id) {
        $nutricionistaModel = new Nutricionista();
        $nutricionistaData = $nutricionistaModel->find($id);

        if (!$nutricionistaData) {
            $this->setFlash('error', 'Nutricionista não encontrado.');
            $this->redirect('/nutricionistas');
        }

        $nutricionista = new Nutricionista();
        foreach ($nutricionistaData as $key => $value) {
            $nutricionista->$key = $value;
        }

        $clientes = $nutricionista->getClientes();
        $planos = $nutricionista->getPlanosAlimentares();
        $estatisticas = $nutricionista->getEstatisticas();

        $this->view('nutricionistas/dashboard', [
            'nutricionista' => $nutricionista,
            'clientes' => $clientes,
            'planos' => $planos,
            'estatisticas' => $estatisticas,
            'title' => 'Dashboard do Nutricionista - EatWell'
        ]);
    }

    private function validarDados($data, $id = null) {
        $errors = [];

        if (empty($data['nome'])) {
            $errors['nome'] = 'O nome é obrigatório.';
        } elseif (strlen($data['nome']) < 3) {
            $errors['nome'] = 'O nome deve ter pelo menos 3 caracteres.';
        }

       
        if (empty($data['email'])) {
            $errors['email'] = 'O email é obrigatório.';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email inválido.';
        } else {
            
            $nutricionistaModel = new Nutricionista();
            $existing = $nutricionistaModel->repository->findByEmail($data['email']);
            if ($existing && $existing['id'] != $id) {
                $errors['email'] = 'Este email já está em uso.';
            }
        }

   
        if (empty($data['crn'])) {
            $errors['crn'] = 'O CRN é obrigatório.';
        } else {
            
            $existing = $nutricionistaModel->repository->findByCRN($data['crn']);
            if ($existing && $existing['id'] != $id) {
                $errors['crn'] = 'Este CRN já está cadastrado.';
            }
        }

        if (empty($data['especialidade'])) {
            $errors['especialidade'] = 'A especialidade é obrigatória.';
        }

        return $errors;
    }
}