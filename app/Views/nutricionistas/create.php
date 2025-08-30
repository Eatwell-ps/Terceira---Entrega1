<?php include '../Views/partials/header.php'; ?>

<h1 class="mb-4"><i class="fas fa-plus me-2"></i>Novo Nutricionista</h1>

<div class="card shadow-sm">
    <div class="card-header bg-success text-white">
        <h5 class="mb-0"><i class="fas fa-user-plus me-2"></i>Cadastrar Novo Nutricionista</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="/nutricionistas/create">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome Completo *</label>
                        <input type="text" class="form-control <?= isset($errors['nome']) ? 'is-invalid' : '' ?>" 
                               id="nome" name="nome" value="<?= $nutricionista->nome ?? '' ?>" required>
                        <?php if (isset($errors['nome'])): ?>
                            <div class="invalid-feedback"><?= $errors['nome'] ?></div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email *</label>
                        <input type="email" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" 
                               id="email" name="email" value="<?= $nutricionista->email ?? '' ?>" required>
                        <?php if (isset($errors['email'])): ?>
                            <div class="invalid-feedback"><?= $errors['email'] ?></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="telefone" class="form-label">Telefone</label>
                        <input type="tel" class="form-control" id="telefone" name="telefone" 
                               value="<?= $nutricionista->telefone ?? '' ?>">
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="crn" class="form-label">CRN (Registro Profissional) *</label>
                        <input type="text" class="form-control <?= isset($errors['crn']) ? 'is-invalid' : '' ?>" 
                               id="crn" name="crn" value="<?= $nutricionista->crn ?? '' ?>" required>
                        <?php if (isset($errors['crn'])): ?>
                            <div class="invalid-feedback"><?= $errors['crn'] ?></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="especialidade" class="form-label">Especialidade *</label>
                <select class="form-control <?= isset($errors['especialidade']) ? 'is-invalid' : '' ?>" 
                        id="especialidade" name="especialidade" required>
                    <option value="">Selecione uma especialidade</option>
                    <option value="Nutrição Clínica" <?= (isset($nutricionista->especialidade) && $nutricionista->especialidade == 'Nutrição Clínica') ? 'selected' : '' ?>>Nutrição Clínica</option>
                    <option value="Nutrição Esportiva" <?= (isset($nutricionista->especialidade) && $nutricionista->especialidade == 'Nutrição Esportiva') ? 'selected' : '' ?>>Nutrição Esportiva</option>
                    <option value="Nutrição Infantil" <?= (isset($nutricionista->especialidade) && $nutricionista->especialidade == 'Nutrição Infantil') ? 'selected' : '' ?>>Nutrição Infantil</option>
                    <option value="Nutrição Geriátrica" <?= (isset($nutricionista->especialidade) && $nutricionista->especialidade == 'Nutrição Geriátrica') ? 'selected' : '' ?>>Nutrição Geriátrica</option>
                    <option value="Nutrição Funcional" <?= (isset($nutricionista->especialidade) && $nutricionista->especialidade == 'Nutrição Funcional') ? 'selected' : '' ?>>Nutrição Funcional</option>
                    <option value="Nutrição Oncológica" <?= (isset($nutricionista->especialidade) && $nutricionista->especialidade == 'Nutrição Oncológica') ? 'selected' : '' ?>>Nutrição Oncológica</option>
                </select>
                <?php if (isset($errors['especialidade'])): ?>
                    <div class="invalid-feedback"><?= $errors['especialidade'] ?></div>
                <?php endif; ?>
            </div>

            <div class="d-flex justify-content-between">
                <a href="/nutricionistas" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Voltar
                </a>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save me-2"></i>Cadastrar Nutricionista
                </button>
            </div>
        </form>
    </div>
</div>

<?php include '../Views/partials/footer.php'; ?>