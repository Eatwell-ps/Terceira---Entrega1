<?php include '../Views/partials/header.php'; ?>

<div class="container mt-4">
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <h1>Clientes</h1>
    
    <div class="d-flex justify-content-between mb-3">
        <a href="/clientes/create" class="btn btn-primary">Novo Cliente</a>
        <form method="POST" action="/clientes/search" class="d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Pesquisar..." 
                   value="<?= isset($searchTerm) ? $searchTerm : '' ?>">
            <button type="submit" class="btn btn-outline-secondary">Buscar</button>
        </form>
    </div>
    
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Telefone</th>
                <th>Peso</th>
                <th>Altura</th>
                <th>Objetivo</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($clientes)): ?>
            <tr>
                <td colspan="8" class="text-center">Nenhum cliente encontrado.</td>
            </tr>
            <?php else: ?>
            <?php foreach ($clientes as $cliente): ?>
            <tr>
                <td><?= $cliente['id'] ?></td>
                <td><?= htmlspecialchars($cliente['nome']) ?></td>
                <td><?= htmlspecialchars($cliente['email']) ?></td>
                <td><?= htmlspecialchars($cliente['telefone']) ?></td>
                <td><?= $cliente['peso'] ?> kg</td>
                <td><?= $cliente['altura'] ?> m</td>
                <td><?= $cliente['objetivo'] ?></td>
                <td>
                    <a href="/clientes/view/<?= $cliente['id'] ?>" class="btn btn-info btn-sm">Ver</a>
                    <a href="/clientes/edit/<?= $cliente['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                    <a href="/clientes/delete/<?= $cliente['id'] ?>" class="btn btn-danger btn-sm" 
                       onclick="return confirm('Tem certeza?')">Excluir</a>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include '../Views/partials/footer.php'; ?>