<?php
// Config de segurança
if ( ! defined('APP_PATH')) exit;
 
// Inicia a sessão
session_start();

// Carrega arquivo de funçoes uteis
require_once APP_PATH . '/functions/core.php';

// Carrega a aplicação
$essentiaGroup= new EssentiaGroup();
