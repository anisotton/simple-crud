<?php if (!defined('APP_PATH')) exit('Acesso negado'); ?>
<div class="row">
    <div class="col">
        <h4 class="display-6 text-uppercase font-weight-bold">Cliente <?php echo $cliente['nome'] ?></h4>
        <hr />
        <form method="POST" action="<?php echo get_base_uri(); ?>cliente/save" enctype="multipart/form-data">
            <input type="hidden" value="<?php echo $cliente['id'] ?>" name="id" />

            <div class="row">

                <div class="col-md-2">
                    <div class="tower-file">
                        <div class="tower-file-details" style="margin: 5px 0px 5px;">
                            <div class="tower-input-preview-container" style="height: 110px;">
                            <img class="null" style="height: 100%;width: 100%;" src="<?php echo get_base_uri()?>assets/images/photos/<?php echo ($cliente['foto'])?$cliente['foto']:'profile-default.png';?>" />
                            </div>
                        </div>
                        <label for="mainDemoInput" class="btn btn-info" style="width: 100%;">
                            <span class="mdi mdi-upload"></span>Selecione a foto
                        </label>
                        <input name="photo" type="file" id="mainDemoInput" />
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <label for="nome">Nome</label>
                            <input type="text" value="<?php echo $cliente['nome'] ?>" name="nome" class="form-control" id="nome" placeholder="Nome" />
                        </div>
                        <div class="form-group col-md-4">
                            <label for="cpf">CPF</label>
                            <input type="text" value="<?php echo $cliente['cpf'] ?>" name="cpf" class="form-control cpf" id="cpf" placeholder="CPF" />
                        </div>
                        <div class="form-group col-md-3">
                            <label for="cep">CEP</label>
                            <input type="text" value="<?php echo $cliente['cep'] ?>" name="cep" class="form-control cep" id="cep" placeholder="CEP" />
                        </div>
                        <div class="form-group col-md-4">
                            <label for="cidade">Cidade</label>
                            <input type="text" value="<?php echo $cliente['cidade'] ?>" name="cidade" class="form-control" id="cidade" placeholder="Cidade" />
                        </div>
                        <div class="form-group col-md-2">
                            <label for="estado">Estado</label>
                            <input type="text" value="<?php echo $cliente['estado'] ?>" name="estado" class="form-control" id="estado" placeholder="Estado" />
                        </div>
                        <div class="form-group col-md-3">
                            <label for="bairro">Bairro</label>
                            <input type="text" value="<?php echo $cliente['bairro'] ?>" name="bairro" class="form-control" id="bairro" placeholder="Bairro" />
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-7">
                    <label for="endereco">Logradouro</label>
                    <input type="text" value="<?php echo $cliente['endereco'] ?>" name="endereco" class="form-control" id="endereco" placeholder="Logradouro" />
                </div>
                <div class="form-group col-md-2">
                    <label for="numero">Numero</label>
                    <input type="text" value="<?php echo $cliente['numero'] ?>" name="numero" class="form-control" id="numero" placeholder="Numero" />
                </div>
                <div class="form-group col-md-3">
                    <label for="complemento">Complemento</label>
                    <input type="text" value="<?php echo $cliente['complemento'] ?>" name="complemento" class="form-control" id="complemento" placeholder="Complemento" />
                </div>
                <div class="col-md-6">
                    <div class="card box-email">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5 class="text-uppercase font-weight-bold">E-mail</h5>
                                    <footer class="blockquote-footer"><cite title="Source Title">Selecione o e-mail principal</cite></footer>
                                </div>
                                <div class="col-md-6 text-right">
                                    <button type="button" class="btn btnAddInput btn-success">Add</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php if (is_array($cliente['email']) && count($cliente['email']) > 0) :
                                foreach ($cliente['email'] as $key => $value) : ?>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input value="<?php echo $value['email'] ?>" type="text" name="email[]" class="form-control" placeholder="mail@mail.com" />
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <input type="radio" <?php echo ($value['padrao'] == 1) ? 'checked' : ''; ?> value="<?php echo $key + 1 ?>" name="emailPadrao" />
                                                </div>
                                                <div class="input-group-text <?php echo ($key > 0) ? '' : 'd-none'; ?>">
                                                    <a href="#" class="removeInput">X</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>

                            <?php else : ?>
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="text" name="email[]" class="form-control" placeholder="mail@mail.com" />
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <input type="radio" value="1" name="emailPadrao" />
                                            </div>
                                            <div class="input-group-text d-none">
                                                <a href="#" class="removeInput">X</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="card-footer text-muted">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5 class="text-uppercase font-weight-bold">Telefone</h5>
                                    <footer class="blockquote-footer"><cite title="Source Title">Selecione o telefone principal</cite></footer>
                                </div>
                                <div class="col-md-6 text-right">
                                    <button type="button" class="btn btn-success btnAddInput">Add</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php if (is_array($cliente['telefone']) && count($cliente['telefone']) > 0) :
                                foreach ($cliente['telefone'] as $key => $value) : ?>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="text" value="<?php echo $value['numero'] ?>" name="telefone[]" class="form-control telefone" placeholder="(99) 99999-9999" />
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <input type="radio" <?php echo ($value['padrao'] == 1) ? 'checked' : ''; ?> value="<?php echo $key + 1 ?>" name="telefonePadrao" />
                                                </div>
                                                <div class="input-group-text <?php echo ($key > 0) ? '' : 'd-none'; ?>">
                                                    <a href="#" class="removeInput">X</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <?php endforeach; ?>
                            <?php else : ?>
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="text" name="telefone[]" class="form-control telefone" placeholder="(99) 99999-9999" />
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <input type="radio" value="1" name="telefonePadrao" />
                                            </div>
                                            <div class="input-group-text d-none">
                                                <a href="#" class="removeInput">X</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>




                        </div>
                        <div class="card-footer text-muted">
                        </div>
                    </div>
                </div>


            </div>
            <div class="col-md-12 text-right m-3">
                <button type="submit" class="btn btn-primary">Salvar</button>
                <a href="<?php echo get_base_uri() ?>" class="btn btn-secondary">Retornar</a>
            </div>
        </form>
    </div>
</div>