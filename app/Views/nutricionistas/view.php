<?php include '../Views/partials/header.php'; ?>

<h1 class="mb-4"><i class="fas fa-user-md me-2"></i>Perfil do Nutricionista</h1>

<div class="row">
    <div class="col-md-4">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="fas fa-id-card me-2"></i>Dados Pessoais</h5>
            </div>
            <div class="card-body text-center">
                <div class="mb-3">
                    <i class="fas fa-user-md fa-4x text-info"></i>
                </div>
                <h4><?= htmlspecialchars($nutricionista->nome) ?></h4>
                <p class="text-muted"><?= $nutricionista->especialidade ?></p>
                
                <div class="text-start">
                    <p><strong><i class="fas fa-envelope me-2"></i>Email:</strong><br>
                    <?= htmlspecialchars($nutricionista->email) ?></p>
                    
                    <p><strong><i class="fas fa-phone me-2"></i>Telefone:</strong><br>
                    <?= $nutricionista->telefone ? htmlspecialchars($nutricionista->telefone) : 'Não informado' ?></p>
                    
                    <p><strong><i class="fas fa-id-badge me-2"></i>CRN:</strong><br>
                    <span class="badge bg-secondary"><?= $nutricionista->crn ?></span></p>
                    
                    <p><strong><i class="fas fa-calendar me-2"></i>Cadastro:</strong><br>
                    <?= date('d/m/Y', strtotime($nutricionista->data_cadastro)) ?></p>
                </div>
            </div>
            <div class="card-footer">
                <div class="d-grid gap-2">
                    <a href="/nutricionistas/edit/<?= $nutricionista->id ?>" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit me-2"></i>Editar
                    </a>
                    <a href="/nutricionistas/dashboard/<?= $nutricionista->id ?>" class="btn btn-primary btn-sm">
                        <i class="fas fa-chart-line me-2"></i>Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8">
      
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white text-center">
                    <div class="card-body">
                        <h5><i class="fas fa-users"></i></h5>
                        <h3><?= $estatisticas['total_clientes'] ?? 0 ?></h3>
                        <p class="mb-0">Clientes</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white text-center">
                    <div class="card-body">
                        <h5><i class="fas fa-clipboard-list"></i></h5>
                        <h3><?= $estatisticas['total_planos'] ?? 0 ?></h3>
                        <p class="mb-0">Planos</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white text-center">
                    <div class="card-body">
                        <h5><i class="fas fa-chart-line"></i></h5>
                        <h3><?= round($estatisticas['media_dias_plano'] ?? 0) ?></h3>
                        <p class="mb-0">Dias/Plano</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-dark text-center">
                    <div class="card-body">
                        <h5><i class="fas fa-stethoscope"></i></h5>
                        <h3><?= $estatisticas['total_avaliacoes'] ?? 0 ?></h3>
                        <p class="mb-0">Avaliações</p>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="fas fa-users me-2"></i>Clientes Atendidos</h5>
            </div>
            <div class="card-body">
                <?php if (empty($clientes)): ?>
                    <p class="text-muted text-center">Nenhum cliente atendido ainda.</p>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Email</th>
                                    <th>Objetivo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($clientes as $cliente): ?>
                                <tr>
                                    <td><?= htmlspecialchars($cliente['nome']) ?></td>
                                    <td><?= htmlspecialchars($cliente['email']) ?></td>
                                    <td>
                                        <span class="badge bg-<?= 
                                            $cliente['objetivo'] == 'Perda de peso' ? 'warning' : 
                                            ($cliente['objetivo'] == 'Ganho de massa' ? 'success' : 'info')
                                        ?>">
                                            <?= $cliente['objetivo'] ?>
                                        </span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>

      
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-clipboard-list me-2"></i>Planos Alimentares</h5>
            </div>
            <div class="card-body">
                <?php if (empty($planos)): ?>
                    <p class="text-muted text-center">Nenhum plano alimentar criado.</p>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Cliente</th>
                                    <th>Início</th>
                                    <th>Término</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($planos as $plano): ?>
                                <tr>
                                    <td><?= htmlspecialchars($plano['cliente_nome']) ?></td>
                                    <td><?= date('d/m/Y', strtotime($plano['data_inicio'])) ?></td>
                                    <td><?= $plano['data_fim'] ? date('d/m/Y', strtotime($plano['data_fim'])) : 'Não definido' ?></td>
                                    <td>
                                        <span class="badge bg-<?= 
                                            !$plano['data_fim'] || strtotime($plano['data_fim']) > time() ? 'success' : 'secondary'
                                        ?>">
                                            <?= !$plano['data_fim'] || strtotime($plano['data_fim']) > time() ? 'Ativo' : 'Finalizado' ?>
                                        </span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="mt-3">
    <a href="/nutricionistas" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Voltar para Lista
    </a>
</div>

<?php include '../Views/partials/footer.php'; ?>