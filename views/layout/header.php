<?php if (!defined('APP_PATH')) exit('Acesso negado'); ?>

<header class="container-fluid">
    <div class="row navbar">
        <div class="col-2">
            <img src="<?php echo APP_URI; ?>/assets/images/logo.png" class="rounded float-left" alt="...">
        </div>
        <div class="col">
            <nav class="nav justify-content-end text-uppercase">
                <a class="nav-link" href="<?php echo get_base_uri()?>">Clientes</a>
            </nav>
        </div>
    </div>
</header>


<div class="container" style="padding: 30px 0px 50px;">

    <?php $msg = get_message();
    if (is_array($msg)) :  ?>
        <div class="alert alert-<?php echo $msg['type'] ?>">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <?php echo $msg['text'] ?>
        </div>
    <?php endif; ?>