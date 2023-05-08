<div class="row cabecalho-listagem">
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <h2>
            Listagem de Tipos
        </h2>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <a class="bt bt-info" href="/tipo/cadastrar">Cadastrar Tipo</a>
    </div>
</div>
<div class="row corpo-listagem">
    <table class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nome</th>
                <th>Imposto</th>
                <th>Ações</th>
            </tr>    
        </thead>
        <tbody>
            <?php
                foreach($_tipo as $_item) {
            ?>
                <tr>
                    <td><?= $_item['id'] ?></td>
                    <td><?= $_item['nome'] ?></td>
                    <td>%<?= number_format($_item['imposto'], 2, ',', '.') ?></td>
                    <td><a href="tipo/editar?id=<?= $_item['id'] ?>">Editar</a> | <a href="tipo/deletar?id=<?= $_item['id'] ?>">Excluir</a></td>
                </tr>
            <?php
                }
            ?>
        </tbody>
    </table>
</div>