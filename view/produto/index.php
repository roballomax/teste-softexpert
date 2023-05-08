<?php
    if(!$mostraListagem) {
?>
    <div class="row home-content">
        <div class="col-md-12 cabecalho">
            <h2>Atenção</h2>
            <hr/>
        </div>
        <div class="col-md-12 corpo">
            <p>Para utilizar essa tela, é necessário ter <strong>tipos de produtos</strong> cadastrados!</p>
        </div>
    </div>
<?php
    } else {
?>
        <div class="row cabecalho-listagem">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <h2>
                    Listagem de Produtos
                </h2>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <a class="bt bt-info" href="/produto/cadastrar">Cadastrar Produto</a>
            </div>
        </div>
        <div class="row corpo-listagem">
            <table class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nome</th>
                        <th>Tipo</th>
                        <th>Valor</th>
                        <th>Ações</th>
                    </tr>    
                </thead>
                <tbody>
                <?php
                    foreach($_produto AS $_item) {
                ?>
                    <tr>
                        <td><?= $_item['id'] ?></td>
                        <td><?= $_item['nome'] ?></td>
                        <td><?= $_item['tipo'] ?></td>
                        <td>R$ <?= number_format($_item['valor'], 2, ',', '.') ?></td>
                        <td><a href="produto/editar?id=<?= $_item['id'] ?>">Editar</a> | <a href="produto/deletar?id=<?= $_item['id'] ?>">Excluir</a></td>
                    </tr>
                <?php
                    }
                ?>
                </tbody>
            </table>
        </div>
<?php
    }
?>