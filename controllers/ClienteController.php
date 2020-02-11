<?php
/*
 * ClienteController
 * 
 * Classe de controller dos clientes
 * 
 * @package   Essentia Group
 * @uthor     Anderson Isotton <anderson@isotton.com.br>
 * @since     Version 0.0.1
 */
class ClienteController extends MainController
{
	/**
	 * index
	 *
	 * Metodo default de execução
	 * 
	 * @return void
	 */
	public function index()
	{
		// Título da página
		$this->title = 'Essentia Group - Cliente';
		//Busca os itens a serem listados
		$data['clientes'] = $this->model->getItens();
		//Renderiza a view
		$this->render_view('cliente/lista', $data);
	}

	/**
	 * edit
	 * 
	 * Metodo que edita um dado da tabela
	 *
	 * @param [type] $id Chave do item a ser editado
	 * @return void
	 */
	public function edit($id)
	{
		//Busca o cliente
		$data['cliente'] = parent::edit($id);
		// Título da página
		$this->title = 'Essentia Group - Cliente/Editar - ' . $data['cliente']['nome'];
		//Renderiza a view
		$this->render_view('cliente/cliente', $data);
	}

	/**
	 * save
	 * 
	 * Metodo para fazer o salvamento do dado na tabela
	 *
	 * @return void
	 */
	public function save()
	{
		//Extrai as variaveis vinda do formulario
		extract($_POST);
		
		if(!$file = $this->uploadPhoto($_FILES)){
			url_redirect('');
		}

		$_POST['foto'] = $file;
		//Salva o cliente
		if ($id = parent::save()) {
			//Upload da foto
			
			//Adiciona os telefones
			$this->model->addTelefone($id, array_filter($telefone), $telefonePadrao);
			//Adiciona os emails
			$this->model->addEmail($id, array_filter($email), $emailPadrao);
			//Redirecina para o edit do cliente
			url_redirect('cliente/edit/' . $id);
		} else {
			//Em caso de erro redireciona para listagem
			url_redirect('');
		}
	}
	/**
	 * uploadPhoto
	 * 
	 * Metodo para fazer upload da foto
	 *
	 * @return void
	 */
	public function uploadPhoto($file)
	{
		
		// Verifica se foi enviado um arquivo
		if (isset($file['photo']['name']) && $file['photo']['error'] == 0) {

			$fileTmpName = $file['photo']['tmp_name'];
			$name = $file['photo']['name'];
			$extValid = array('jpg', 'jpeg', 'gif', 'png');
			// Pega a extensão
			$ext = pathinfo($name, PATHINFO_EXTENSION);
			// Converte a extensão para minúsculo
			$ext = strtolower($ext);
			// Somente imagens, .jpg;.jpeg;.gif;.png
			if (in_array($ext, $extValid)) {
				// Cria um nome único para foto
				$newName = uniqid(time()) . '.' . $ext;
				// Concatena a pasta com o nome
				$dest = APP_PATH.'/assets/images/photos/' . $newName;
				// tenta mover o arquivo para o destino
				if (move_uploaded_file($fileTmpName, $dest)) {
					return $newName;
				}
			}
		}

		set_message('Erro ao salvar a foto. Tipos permitidos: ' . implode(', ',$extValid), 'danger');
		return false;
	}

	/**
	 * new
	 * 
	 * Metodo para renderizar o formulario de um novo cliente
	 *
	 * @return void
	 */
	public function new()
	{
		//Seta a primary key para -1
		//o indice é -1 quando o item é novo
		$data['cliente'][$this->model->getPrimaryKey()] = -1;
		//Renderiza a view
		$this->render_view('cliente/cliente', $data);
	}

	/**
	 * remove
	 * 
	 * Metodo para remover um item da tabela
	 *
	 * @param [type] $id	Chave do item a ser removido
	 * @return void
	 */
	public function remove($id)
	{
		//remove o item
		parent::remove($id);
		//redireciona para listagem
		url_redirect('');
	}
}
