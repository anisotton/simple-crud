<?php
/**
 * Arquivo de configuração
 */
error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', 1);


// Raiz da aplicação
define( 'APP_PATH', dirname( __FILE__ ) );

// Raiz das classes
define( 'APP_CLASS', APP_PATH.'/class/');

// Raiz das views
define( 'APP_VIEW', APP_PATH.'/views/');

// Raiz dos controllers
define( 'APP_CONTROLLER', APP_PATH.'/controllers/');

// Raiz dos models
define( 'APP_MODEL', APP_PATH.'/models/');

// Pagina de erro
define( 'APP_NOT_FOUND', APP_PATH.'/404.php');

// URL da aplicação
define( 'APP_URI', 'http://localhost/essentia/' );

// Controller padrão
define( 'DEFAULT_CONTROLLER', 'cliente' );

// Configuração de base de dados
define( 'HOSTNAME', 'localhost' );
define( 'DB_NAME', 'essentia' );
define( 'DB_USER', 'root' );
define( 'DB_PASSWORD', '' );

// Carrega o arquivo de loader
require_once APP_PATH . '/loader.php';
?>