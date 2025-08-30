<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Cliente;

class ClienteController extends Controller {
    private $clienteModel;

    public function __construct() {
        $this->clienteModel = new Cliente();
    }

    public function index() {
        $clientes = $this->clienteModel->getAll();
        $this->view('clientes/index', ['clientes' => $clientes]);
    }

    public function create() {
        if ($this->isPost()) {
            $data = [
                'nome' => $this->sanitizeInput($_POST['nome']),
                'email' => $this->sanitizeInput($_POST['email']),
                'telefone' => $this->sanitizeInput($_POST['telefone']),
                'data_nascimento' => $this->sanitizeInput($_POST['data_nascimento']),
                'peso' => $this->sanitizeInput($_POST['peso']),
                'altura' => $this->sanitizeInput($_POST['altura']),
                'objetivo' => $this->sanitizeInput($_POST['objetivo']),
                'restricoes' => $this->sanitizeInput($_POST['restricoes'])
            ];

            if ($this->clienteModel->create($data)) {
                $_SESSION['success'] = 'Cliente cadastrado com sucesso!';
                $this->redirect('/clientes');
            } else {
                $_SESSION['error'] = 'Erro ao cadastrar cliente.';
                $this->view('clientes/create', ['cliente' => (object)$data]);
            }
        } else {
            $this->view('clientes/create');
        }
    }

    public function edit($id) {
        if ($this->isPost()) {
            $data = [
                'nome' => $this->sanitizeInput($_POST['nome']),
                'email' => $this->sanitizeInput($_POST['email']),
                'telefone' => $this->sanitizeInput($_POST['telefone']),
                'data_nascimento' => $this->sanitizeInput($_POST['data_nascimento']),
                'peso' => $this->sanitizeInput($_POST['peso']),
                'altura' => $this->sanitizeInput($_POST['altura']),
                'objetivo' => $this->sanitizeInput($_POST['objetivo']),
                'restricoes' => $this->sanitizeInput($_POST['restricoes'])
            ];

            if ($this->clienteModel->update($id, $data)) {
                $_SESSION['success'] = 'Cliente atualizado com sucesso!';
                $this->redirect('/clientes');
            } else {
                $_SESSION['error'] = 'Erro ao atualizar cliente.';
                $this->view('clientes/edit', ['cliente' => (object)array_merge(['id' => $id], $data)]);
            }
        } else {
            $cliente = $this->clienteModel->getById($id);
            if ($cliente) {
                $this->view('clientes/edit', ['cliente' => (object)$cliente]);
            } else {
                $_SESSION['error'] = 'Cliente não encontrado.';
                $this->redirect('/clientes');
            }
        }
    }

    public function view($id) {
        $cliente = $this->clienteModel->getById($id);
        if ($cliente) {
            $clienteObj = (object)$cliente;
            $imc = $clienteObj->peso && $clienteObj->altura ? 
                   $clienteObj->peso / ($clienteObj->altura * $clienteObj->altura) : null;
            
            $this->view('clientes/view', [
                'cliente' => $clienteObj,
                'imc' => $imc
            ]);
        } else {
            $_SESSION['error'] = 'Cliente não encontrado.';
            $this->redirect('/clientes');
        }
    }

    public function delete($id) {
        if ($this->clienteModel->delete($id)) {
            $_SESSION['success'] = 'Cliente excluído com sucesso!';
        } else {
            $_SESSION['error'] = 'Erro ao excluir cliente.';
        }
        $this->redirect('/clientes');
    }

    public function search() {
        if ($this->isPost()) {
            $term = $this->sanitizeInput($_POST['search']);
            $clientes = $this->clienteModel->search($term);
            $this->view('clientes/index', ['clientes' => $clientes, 'searchTerm' => $term]);
        } else {
            $this->redirect('/clientes');
        }
    }
}