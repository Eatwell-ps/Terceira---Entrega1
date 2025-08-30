<?php
namespace App\Core;

abstract class Model {
    protected $repository;

    public function __construct($repository) {
        $this->repository = $repository;
    }

    public function getAll() {
        return $this->repository->findAll();
    }

    public function getById($id) {
        return $this->repository->findById($id);
    }

    public function save($data) {
        return $this->repository->save($data);
    }

    public function delete($id) {
        return $this->repository->delete($id);
    }

    public function search($term) {
        return $this->repository->search($term);
    }
}