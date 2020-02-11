<?php if (!defined('APP_PATH')) exit('Acesso negado'); ?>

<div class="row">
    <div class="col-md-6 pb-4">
        <h4 class="display-6 text-uppercase font-weight-bold">Clientes</h4>
    </div>
    <div class="col-md-6 text-right">
        <a href="<?php echo get_base_uri() ?>cliente/new" class="btn btn-success">Novo</a>
    </div>
    <div class="col">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col-1">Img</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Telefone</th>
                    <th scope="col">Email</th>
                    <th scope="col">#</th>
                </tr>
            </thead>
            <tbody>

                <?php
                if (count($clientes) > 0) :
                    foreach ($clientes as $key => $value) :
                        ?>
                        <tr>
                            <td><img class="null" style="height: 40px;width: 40px;" src="<?php echo get_base_uri()."assets/images/photos/{$value['foto']}"; ?>" /></td>
                            <td><?php echo $value['nome'] ?></td>
                            <td><?php echo $value['telefone'] ?></td>
                            <td><?php echo $value['email'] ?></td>
                            <th>

                                <a href="<?php echo get_base_uri(); ?>cliente/edit/<?php echo $value['id'] ?>">Editar</a> -
                                <a onclick="return confirm('Remover cliente - <?php echo $value['nome'] ?>')" href="<?php echo get_base_uri(); ?>cliente/remove/<?php echo $value['id'] ?>">Remover</a>
                            </th>
                        </tr>
                    <?php
                        endforeach;
                    else : ?>

                    <tr>
                        <td rowspan='3'>Nenhum cliente localizado</td>
                    </tr>
                <?php

                endif;
                ?>

            </tbody>
        </table>
    </div>
</div>