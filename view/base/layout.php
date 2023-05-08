<?php

$controllerName = 'Controller\\Home';
$actionName     = 'index';

// pega nomes de controllers e actions da url
$uri        = $_SERVER['REQUEST_URI'];
$_uri       = explode('/', $uri);
array_shift($_uri);

//pega o controller da url, caso haja
if(!empty($_uri[0])) {
    $controllerName = 'Controller\\' . ucwords($_uri[0]);
}

//pega a action da url, caso haja
if(!empty($_uri[1])) {

    if(strpos($_uri[1], '?') !== false) {
        $_uri[1] = explode('?', $_uri[1])[0];
    }

    $actionName = strtolower($_uri[1]);
}

// instancia o controller da tela
$controller = new $controllerName();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <base href="/" target="_self" />
    <link rel="stylesheet" href="/assets/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/assets/dist/css/style.css?no-cache=<?= time() ?>" />
    <title>Desafio Soft Expert<?= (!empty($controller->getTitle()) ? ' | ' . $controller->getTitle() : '') ?></title>
</head>
<body>
    <?php
        //pega html do header
        require_once('header.php');
    ?>
    
    <div class="container conteudo">
        <?php
            //chama a action da tela
            $controller->$actionName();
        ?>
    <div>
    
    <?php
        //pega html do footer
        require_once('footer.php');
    ?>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="assets/dist/js/script.js"></script>


    <script>
        $(function() {

            <?php
                if(!empty($_GET['msg'])) {
            ?>
                    alert('<?= $_GET['msg'] ?>');
            <?php
                }    
            ?>

        });
    </script>

</body>
</html>