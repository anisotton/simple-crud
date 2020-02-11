<?php
/*
 * OutPlan
 * 
 * Classe para gerenciar Models, Controllers e Views
 * 
 * @package   Essentia Group
 * @uthor     Anderson Isotton <anderson@isotton.com.br>
 * @since     Version 0.0.1
 */

class EssentiaGroup
{

    /**
     * $controller
     * Seta o controller envaido por paramentro da URL
     */
    private $controller;

    /**
     * $action
     * Recebe o valor da action via URL
     */
    private $action;

    /**
     * $param
     * Recebe um array dos parâmetros da URL
     */
    private $params;

    /**
     * __construct para essa classe
     * 
     * Inicia variaveis necessarias para 
     * o funcionamento da aplicação
     */
    public function __construct()
    {

        // Seta as variaveis
        $this->get_url_params();

        if (!$this->controller) {

            $defaultController = ucfirst(DEFAULT_CONTROLLER).'Controller';


            if (!file_exists(APP_CONTROLLER . $defaultController . '.php')) {
                // Página de erro
                error_page("Controller não localizado ".$defaultController);
            }
            // Adiciona o controlador padrão
            require_once APP_CONTROLLER . $defaultController . '.php';

            // Instancia o objeto do controller default
            $this->controller = new $defaultController();

            // Executa o método index()
            return $this->controller->index();
        }

        $this->controller = ucfirst($this->controller).'Controller';

        // Verifica se o controller setado existe
        if (!file_exists(APP_CONTROLLER . $this->controller . '.php')) {
            // Página de erro
            error_page("Controller não localizado ".$this->controller);
        }

        // Adiciona arquivo do controller
        require_once APP_CONTROLLER . $this->controller . '.php';

        // Verifica se a classe exite
        if (!class_exists($this->controller)) {
            // Página de erro
            error_page("Class do controller não localizada ".$this->controller);
        }

        // Cria o objeto da classe do controlador e envia os parâmentros
        $this->controller = new $this->controller($this->params);

        // Trata action
        $this->action = preg_replace('/[^a-zA-Z]/i', '', $this->action);

        // Se o método indicado existir, executa o método e envia os parâmetros
        if (method_exists($this->controller, $this->action)) {
            return $this->controller->{$this->action}($this->params);
        }

        // Empty action
        if (!$this->action && method_exists($this->controller, 'index')) {
            $this->controller->index($this->params);
        }

        // Página de erro
        error_page("Action não localizada: ".$this->action);
    }

    /**
     * Trata os paramentros de URL
     *
     */
    public function get_url_params()
    {

        // Verifica se o parâmetro path foi enviado
        if (isset($_GET['path'])) {

            // Captura o valor de $_GET['path']
            $path = $_GET['path'];

            // Limpa os dados
            $path = rtrim($path, '/');
            $path = filter_var($path, FILTER_SANITIZE_URL);

            // Cria um array de parâmetros
            $path = explode('/', $path);

            // Configura as propriedades
            $this->controller  = check_array($path, 0);
            $this->action      = check_array($path, 1);

            // Configura os parâmetros
            if (check_array($path, 2)) {
                unset($path[0]);
                unset($path[1]);

                // Os parâmetros sempre virão após a ação
                $this->params = array_values($path);
            }
        }
    }
}
