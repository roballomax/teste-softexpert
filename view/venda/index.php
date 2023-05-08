
<?php
    if (!count($_produto)) {
?>
    <div class="row home-content">
        <div class="col-md-12 cabecalho">
            <h2>Atenção</h2>
            <hr/>
        </div>
        <div class="col-md-12 corpo">
            <p>Para utilizar essa tela, é necessário ter <strong>produtos</strong> cadastrados!</p>
        </div>
    </div>
<?php
    } else {
?>

<div class="row cabecalho-venda">
    <div class="col-xs-12 xol-sm-12 col-md-12 col-lg-12">
        <h2>Venda</h2>
        <hr/>
    </div>
</div>

<div class="row corpo-venda">
    <form action="/venda/adicionarProduto" method="post">
        <input type="hidden" name="venda_id" value="<?= $_vendaEmAberto['id'] ?>" />

        <div class="col-xs-8 xol-sm-6 col-md-6 col-lg-6 campo obrigatorio">
            <label for="produto">Escolha um produto *</label>
            <select name="produto" id="produto">
                <option value="">Selecione um produto</option>
                <?php
                    foreach($_produto as $_item) {
                        echo '<option value="' . $_item['id'] . '">' . $_item['nome'] . '</option>';
                    }
                ?>
            </select>
        </div>
        <div class="col-xs-2 xol-sm-2 col-md-2 col-lg-2 campo obrigatorio">
            <label for="quantidade">Quantidade *</label>
            <input type="number" name="quantidade" id="quantidade" />
        </div>

        <div class="col-xs-2 xol-sm-4 col-md-4 col-lg-4">
            <input type="submit" value="Adicionar" class="bt bt-info"/>
        </div>
    </form>

    <table class="col-xs-12 xol-sm-12 col-md-12 col-lg-12">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nome</th>
                <th>Tipo</th>
                <th>Valor</th>
                <th>Imposto</th>
                <th>Quantidade</th>
                <th>Ações</th>
            </tr>    
        </thead>
        <tbody>

                <?php
                    if(isset($_vendaEmAberto['_produto'])) foreach($_vendaEmAberto['_produto'] as $_produto_item) {
                    $_total['produto']  += ($_produto_item['produto_valor'] * $_produto_item['quantidade']);
                    $_total['imposto']  += ($_produto_item['produto_valor'] * ($_produto_item['tipo_imposto'] / 100));
                    $_total['geral']    = $_total['produto'] + $_total['imposto'];
                ?>

                    <tr>
                        <td><?= $_produto_item['produto_id'] ?></td>
                        <td><?= $_produto_item['produto_nome'] ?></td>
                        <td><?= $_produto_item['tipo_nome'] ?></td>
                        <td>R$ <?= number_format($_produto_item['produto_valor'], 2, ',', '.') ?></td>
                        <td>%<?= number_format($_produto_item['tipo_imposto'], 2, ',', '.') ?></td>
                        <td><?= $_produto_item['quantidade'] ?></td>
                        <td><a href="venda/removerProduto?produto_venda_id=<?= $_produto_item['id'] ?>">Remover</a></td>
                    </tr>
                <?php
                    }
                ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">Custo produtos: R$ <?= number_format($_total['produto'], 2, ',', '.') ?></td>
                <td colspan="2">Custo Imposto: R$ <?= number_format($_total['imposto'], 2, ',', '.') ?></td>
                <td colspan="3">Total: R$ <?= number_format($_total['geral'], 2, ',', '.') ?></td>
            </tr>
        </tfoot>
    </table>
</div>

<div class="row">
    <div class="col-xs-12 xol-sm-12 col-md-12 col-lg-12">
        <a href="venda/efetuarVenda" class="bt bt-success">Finalizar Compra</a>
    </div>
</div>

<?php
    }
?>