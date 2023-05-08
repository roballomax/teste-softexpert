<div class="row cabecalho-form">
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <h2>
            <?= $titulo ?> de Tipos
        </h2>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <a class="bt" href="/tipo/index">Voltar</a>
    </div>
</div>

<div class='row corpo-form'>
    <form action="/tipo/<?= $urlForm; ?>" method='post'>

        <?php
            if(isset($_tipo['id'])) {
        ?>
            <input type="hidden" name="id" value="<?= $_tipo['id'] ?>" />
        <?php
            }
        ?>

        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 campo obrigatorio">
            <label for="nome">Nome *</label>
            <input type="text" name="nome" id="nome" value="<?= (isset($_tipo['nome']) ? $_tipo['nome']: '') ?>" placeholder="Nome"/>
        </div>

        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 campo obrigatorio">
            <label for="imposto">Imposto *</label>
            <input type="text" name="imposto" id="imposto" class="porcentagem" value="<?= (isset($_tipo['imposto']) ? $_tipo['imposto']: '') ?>" placeholder="Porcentagem de imposto"/>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 bt-enviar">
            <input type="submit" value="<?= $submit ?>" class="bt bt-success"/>  
        </div>
    </form>
</div>