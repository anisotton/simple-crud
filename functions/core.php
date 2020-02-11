<?php
/*
 * Arquivo de funções do core da aplicação
 * 
 * @package   Essentia Group
 * @uthor     Anderson Isotton <anderson@isotton.com.br>
 * @since     Version 0.0.1
 */


spl_autoload_register('autoload');
/**
 * __autoload
 *
 * Função para carregar automaticamente todas as classes padrão
 * 
 * @param [string] $class_name Nome da classe a ser caregada
 * @return void
 */
function autoload($class_name)
{
	$file = APP_CLASS . $class_name . '.php';
	if (!file_exists($file)) {
		error_page("Arquivo não encontrado: {$class_name}.php");
	}
	require_once $file;

}



/**
 * check_array
 *
 * Verifica chaves de arrays
 * 
 * @param [array] $array
 * @param [type] $key
 * @return void
 */
function check_array($array, $key)
{
	if (isset($array[$key]) && !empty($array[$key])) {
		return $array[$key];
	}
	return null;
}

/**
 * get_base_uri
 *
 * Função que retorna a URL base da aplicação
 * 
 * @return void
 */
function get_base_uri()
{
	return APP_URI;
}

/**
 * error_page
 * 
 * Função que requisita a pagina de erro da aplicação
 *
 * @param string $msg
 * @return void
 */
function error_page($msg = 'Erro ao executar aplicação.')
{
	require_once APP_NOT_FOUND;
	exit($msg);
}

/**
 * set_message
 *
 * Função que seta as mensagens da aplicação
 * 
 * @param [string] $msg Mensagem a ser seteda
 * @param string $type success|danger
 * @return void
 */
function set_message($msg, $type = 'success')
{
	unset($_SESSION['message']);
	$_SESSION['message']['text'] = $msg;
	$_SESSION['message']['type'] = $type;
}
/**
 * get_message
 *
 * Função para retornar as menssagens da aplicação
 * 
 * @return void
 */
function get_message()
{
	$msg =  $_SESSION['message'];
	unset($_SESSION['message']);
	return $msg;
}

/**
 * url_redirect
 * 
 * Função para redirecionamento das paginas
 *
 * @param [type] $path pagina a ser redirecionada
 * @return void
 */
function url_redirect($path)
{

	$url = get_base_uri() . $path;
	header("Location: {$url}");
}
