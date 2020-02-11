<?php

/*
 * MainController
 * 
 * Classe de controller do core da aplicação
 * 
 * @package   Essentia Group
 * @uthor     Anderson Isotton <anderson@isotton.com.br>
 * @since     Version 0.0.1
 */

class MainController
{
	/**
	 * Model padrão do controller
	 *
	 * @access public
	 */
	public $model;
	/**
	 * $title
	 *
	 * Título das páginas 
	 *
	 * @access public
	 */
	public $title;

	/**
	 * $params
	 *
	 * @access public
	 */
	public $params = array();

	/**
	 * Construtor da classe
	 *
	 * Configura as propriedades e métodos da classe.
	 *
	 * @since 0.1
	 * @access public
	 */
	public function __construct($params = array())
	{
		$this->params = $params;

		$this->model = $this->load_model(ucfirst(str_replace('controller', 'Model', strtolower(get_called_class()))));
	}

	/**
	 * Load model
	 *
	 * Carrega os modelos presentes na pasta /models/.
	 *
	 * @access public
	 */
	public function load_model($model_class = false)
	{

		if (!$model_class) return;

		//Seta o model
		$model_path = APP_MODEL . $model_class . '.php';

		// Verifica se o arquivo existe
		if (file_exists($model_path)) {

			require_once $model_path;

			// Verifica se a classe existe
			if (class_exists($model_class)) {

				// Retorna um objeto da classe
				return new $model_class();
			}
		}
		return false;
	}

	/**
	 * Load view
	 *
	 * Carrega as views.
	 *
	 * @access public
	 */
	public function load_view($view, $data = array())
	{
		if (!$view) return;

		//Seta o view
		$view_name =  strtolower($view);
		$view_path = APP_VIEW . $view_name . '.php';

		// Verifica se o arquivo existe
		if (file_exists($view_path)) {
			extract($data);
			require_once $view_path;
			return;
		}
		error_page('View não localizada: ' . $view);
	}

	/**
	 * Render view
	 *
	 * Carrega as views já com o layout.
	 *
	 * @access public
	 */
	public function render_view($view, $data = array())
	{
		$this->load_view('layout/head');
		$this->load_view('layout/header');
		$this->load_view($view, $data);
		$this->load_view('layout/footer');
	}

	/**
	 * edit
	 * 
	 * Metodo para exibir o formulario de editar um item na tabela
	 *
	 * @param [type] $primaryKey	Chave primaria do item a ser editado
	 * @return void
	 */
	public function edit($primaryKey)
	{
		//verifica se o parametro foi enviado corretamente
		if (empty($primaryKey) or is_null($primaryKey[0])) {
			error_page("Chave primaria não informada para o item a ser editado");
		}

		//busca o item na tabela
		$data = $this->model->getItem($primaryKey[0]);
		//verifica se o item exite
		if (empty($data)) {
			error_page("Chave não localizada");
		}

		return $data;
	}

	/**
	 * save
	 * 
	 * Metodo para insert e update de um item na tabela
	 *
	 * @return void
	 */
	public function save()
	{
		$data = $_POST;
		//verifica se o iten é novo ou existente
		if ($data['id'] == -1) {
			$function = 'insert';
		} else {
			$function = 'update';
		}
		//executa a função conforme verificação anterior
		if ($id = $this->model->$function($data)) {
			set_message('Sucesso ao salvar dado');
			return $id;
		} else {
			set_message('Erro ao salvar dado', 'danger');
			return false;
		}
	}

	/**
	 * remove
	 * 
	 * Metodo para remover o dado da tabela
	 *
	 * @param [int] $primaryKey chave do iten a ser removido
	 * @return void
	 */
	public function remove($primaryKey)
	{
		//verifica se o parametro foi enviado corretamente
		if (empty($primaryKey) or is_null($primaryKey[0])) {
			error_page("Chave primaria não informada para o item a ser excluido");
		}
		//busca o item na tabela
		$data = $this->model->getItem($primaryKey[0]);
		//verifica se o item existe
		if (empty($data)) {
			error_page("Chave não localizada");
		}
		//remove o item
		if ($this->model->remove($primaryKey[0])) {
			set_message('Sucesso ao excluir dado');
			return true;
		} else {
			set_message('Erro ao excluir dado', 'danger');
			return false;
		}
	}
}
