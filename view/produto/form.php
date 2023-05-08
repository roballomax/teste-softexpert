<div class="row cabecalho-form">
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <h2>
            <?= $titulo ?> de Produtos
        </h2>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <a class="bt" href="/produto/index">Voltar</a>
    </div>
</div>

<div class='row corpo-form'>
    <form action="/produto/<?= $urlForm ?>" method='post'>
        <?php
            if(isset($_produto['id'])) {
        ?>
            <input type="hidden" name="id" value="<?= $_produto['id'] ?>" />
        <?php
            }
        ?>

        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 campo obrigatorio">
            <label for="nome">Nome *</label>
            <input type="text" name="nome" id="nome" value="<?= (isset($_produto['nome']) ? $_produto['nome'] : '') ?>" placeholder="Nome" />
        </div>

        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 campo obrigatorio">
            <label for="tipo">Tipo *</label>
            <select name="tipo" id="tipo">
                <option value="">Selecione um tipo</option>
                <?php
                    foreach($_tipo as $_item) {
                        echo '<option value="' . $_item['id'] . '" ' . ($_item['id'] == $_produto['tipo_id'] ? 'selected' : '') . '>' . $_item['nome'] . '</option>';
                    }
                ?>
            </select>
        </div>

        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 campo obrigatorio">
            <label for="valor">Valor *</label>
            <input type="text" name="valor" id="valor" class="dinheiro" value="<?= (isset($_produto['valor']) ? $_produto['valor'] : '') ?>" placeholder="Valor" />
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 bt-enviar bt-enviar">
            <input type="submit" value="<?= $submit ?>" class="bt bt-success"/>  
        </div>
    </form>
</div>