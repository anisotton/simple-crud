<?php
/*
 * MainModel
 * 
 * Classe do core do model
 * 
 * @package   Essentia Group
 * @uthor     Anderson Isotton <anderson@isotton.com.br>
 * @since     Version 0.0.1
 */
class MainModel
{
	/**
	 * O objeto da nossa conexão PDO
	 *
	 * @access public
	 */
	public $db;

	/**
	 * Atributo que recebe a tabela que o model ira gerenciar
	 *
	 * @var string
	 */
	protected $table;

	/**
	 * O objeto da nossa conexão PDO
	 *
	 * @access protected
	 */
	protected $editable = array();
	/**
	 * Coluna a ser ordenado por padrão
	 *
	 * @var string
	 */
	protected $colOrder = 'id';

	/**
	 * Chave primaria da tabela a ser manipulada
	 *
	 * @var string
	 */
	protected $primaryKey = 'id';

	/**
	 * __construct
	 *
	 * @return void
	 */
	public function __construct()
	{

		//Instancia a conexão com a base de dados
		$this->db = new DataBase(HOSTNAME, DB_USER, DB_PASSWORD, DB_NAME);

		//Verifica se algum parametro obrigatorio do modulo não esta devidamente setado
		foreach (get_object_vars($this) as $key => $value) {
			if (is_null($value)) {
				exit("Error attribute {$key} not set in " . get_called_class());
			}
		}
	}

	/**
	 * getPrimaryKey
	 * 
	 * Metodo para retornar o nome da Primary Key da tabela
	 *
	 * @return string
	 */
	public function getPrimaryKey()
	{
		return $this->primaryKey;
	}

	/**
	 * getItens
	 *
	 * Metodo que retorna os itens da tabela selecionada
	 * 
	 * @return array
	 */
	public function getItens()
	{
		return $this->db->fetchAll("SELECT * FROM `{$this->table}` ORDER BY {$this->colOrder} ASC");
	}

	/**
	 * getItem
	 *
	 * Metodo para retornar um item expecifico da tabela selecionada
	 * 
	 * @param [type] 	$key	Chave primaria da tabela
	 * @return array
	 */
	public function getItem($key)
	{
		return $this->db->fetch("SELECT * FROM `{$this->table}` WHERE `{$this->primaryKey}` = ?", array($key));
	}

	/**
	 * update
	 * 
	 * Metodo para fazer update em um registro da tabela
	 *
	 * @param [array] $data dados a serem editados na tabela
	 * @return void
	 */
	public function update($data)
	{
		//Adiciona a primary key aos valores a serem utilizados na consulta
		$values[':' . $this->primaryKey] = $data[$this->primaryKey];
		//Trata todos os valores editaveis na tabela
		foreach ($this->editable as $value) {
			$set[] = "{$value} = :{$value}";
			$values[':' . $value] = $data[$value];
		}
		//Agrupa os valores de forma a ser usado na SQL
		$set = implode(', ', $set);
		//SQL de update
		$query = "UPDATE {$this->table} SET {$set} WHERE {$this->primaryKey} = :{$this->primaryKey}";
		//Executa a SQL
		if ($this->db->update($query, $values)) {
			return $data[$this->primaryKey];
		} else {
			return false;
		}
	}

	/**
	 * insert
	 * 
	 * Metodo que inser um registro na tabela
	 *
	 * @param [array] $data	array contendo os dados do registro a ser inserido
	 * @return void
	 */
	public function insert($data)
	{
		//Trata todos os valores editaveis na tabela
		foreach ($this->editable as $value) {
			$set[] = ":{$value}";
			$values[':' . $value] = $data[$value];
		}
		//Agrupa os valores de forma a ser usado na SQL
		$set = implode(', ', $set);
		$cols = implode(', ', $this->editable);
		//SQL de insert
		$query = "INSERT INTO {$this->table} ({$cols}) VALUES ({$set})";
		//Executa a SQL
		if ($id = $this->db->insert($query, $values)) {
			return $id;
		} else {
			return false;
		}
	}

	/**
	 * Remove
	 * 
	 * Metodo que remove um registro da tabela
	 *
	 * @param [type] $key	Chave do registro a ser removido
	 * @return void
	 */
	public function remove($key)
	{
		$query = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = :{$this->primaryKey}";
		return $this->db->delete($query, array(":{$this->primaryKey}" => $key));
	}
}
