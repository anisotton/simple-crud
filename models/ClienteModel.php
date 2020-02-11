<?php
/**
 * ContatoModel
 * 
 * Classe de modelo para Contatos
 *
 * @package Essentia Group
 * @author Anderson Isotton <anderson@isotton.com.br>
 * @access public
 * @since 0.0.1
 */
class ClienteModel extends MainModel
{
	/**
	 * Atributo que recebe a tabela que o model ira gerenciar
	 *
	 * @var string
	 */
	protected $table = 'clientes';

	/**
	 * Colunas na tabela que podem ser editadas
	 *
	 * @var array
	 */
	protected $editable = array('nome', 'cpf', 'cep', 'cidade', 'estado', 'endereco', 'numero', 'complemento', 'bairro', 'foto');

	/**
	 * getItens
	 * 
	 * Metodo que busca os itens e suas dependencias
	 *
	 * @return array
	 */
	public function getItens()
	{
		$query = "SELECT 
					{$this->table}.*, 
					telefone.numero AS telefone,
					email.email AS email  
				FROM {$this->table} 

				LEFT JOIN telefone 
				ON telefone.cliente_id = {$this->table}.id 
				AND telefone.padrao = 1 

				LEFT JOIN email 
				ON email.cliente_id = {$this->table}.id 
				AND email.padrao = 1
				
				ORDER BY {$this->colOrder} ASC";

		return $this->db->fetchAll($query);
	}

	/**
	 * getTelefone
	 * 
	 * Metodo que busca o telefone de um cliente
	 *
	 * @param 	int		$chaveContato	Chave primaria do cliente
	 * @return 	array	Array associativo com os telefones
	 */
	public function getTelefone($chaveContato)
	{
		return $this->db->fetchAll("SELECT * FROM telefone WHERE cliente_id = :cliente_id", array(':cliente_id' => $chaveContato));
	}

	/**
	 * getEmail
	 * 
	 * Metodo que busca os emails de um cliente
	 *
	 * @param 	int		$chaveContato	Chave primaria do cliente
	 * @return 	array	Array associativo com os emails
	 */
	public function getEmail($chaveContato, $padrao = false)
	{
		return $this->db->fetchAll("SELECT * FROM email WHERE cliente_id = :cliente_id", array(':cliente_id' => $chaveContato));
	}

	/**
	 * getItem
	 * 
	 * Metodo que busca o cliente e suas dependencias
	 *
	 * @param 	int		$chaveContato	Chave primaria do cliente
	 * @return 	array	Array associativo com o cliente
	 */
	public function getItem($key)
	{

		$cliente = parent::getItem($key);

		$cliente['telefone'] = $this->getTelefone($key);
		$cliente['email'] = $this->getEmail($key);

		return $cliente;
	}

	/**
	 * addTelefone
	 * 
	 * Metodo que adiciona os telefones a um cliente
	 *
	 * @param [int] 	$chaveContato	Chave primaria do cliente
	 * @param [array] 	$telefones		Array contendo os numeros dos telefones
	 * @param [int] 	$telefonePadrao	Numero do indice do telefone padrão (INDICE - 1)
	 * @return bolean
	 */
	public function addTelefone($chaveContato, $telefones, $telefonePadrao = null)
	{

		//Remove todos os telefones associados ao cliente
		$query = "DELETE FROM telefone WHERE cliente_id = :cliente_id";
		$this->db->delete($query, array(':cliente_id' => $chaveContato));

		//Verifica se foi enviado telefone padrão
		if (is_null($telefonePadrao)) {
			//Se não foi seleciona o primeiro como padrão
			$telefonePadrao = 1;
		}

		//Adiciona os telefones enviados por paramentro
		foreach ($telefones as $key => $value) {
			if (($key + 1) == $telefonePadrao) {
				$padrao = 1;
			} else {
				$padrao = 0;
			}
			$query = "INSERT INTO telefone (numero, cliente_id, padrao) VALUES (:numero, :cliente_id, :padrao)";
			$this->db->insert($query, array(':numero' => $value, ':cliente_id' => $chaveContato, ':padrao' => $padrao));
		}

		return true;
	}

	/**
	 * addEmail
	 * 
	 * Metodo que adiciona os emails a um cliente
	 *
	 * @param [int] 	$chaveContato	Chave primaria do cliente
	 * @param [array] 	$emails			Array contendo os emails
	 * @param [int] 	$emailPadrao	Numero do indice do email padrão (INDICE - 1)
	 * @return bolean
	 */
	public function addEmail($chaveContato, $emails, $emailPadrao = null)
	{
		//Remove todos os emails associados ao cliente
		$query = "DELETE FROM email WHERE cliente_id = :cliente_id";
		$this->db->delete($query, array(':cliente_id' => $chaveContato));

		//Verifica se foi enviado email padrão
		if (is_null($emailPadrao)) {
			//Se não foi seleciona o primeiro como padrão
			$emailPadrao = 1;
		}

		//Adiciona os emails enviados por paramentro
		foreach ($emails as $key => $value) {
			if (($key + 1) == $emailPadrao) {
				$padrao = 1;
			} else {
				$padrao = 0;
			}
			$query = "INSERT INTO email (email, cliente_id, padrao) VALUES (:email, :cliente_id, :padrao)";
			$this->db->insert($query, array(':email' => $value, ':cliente_id' => $chaveContato, ':padrao' => $padrao));
		}

		return true;
	}

	/**
	 * removeTelefone
	 * 
	 * Metodo para remover os telefones associados a um cliente
	 *
	 * @param [int] $chaveContato chave do cliente a ser removido os telefones
	 * @return bolean
	 */
	public function removeTelefone($chaveContato)
	{
		$query = "DELETE FROM telefone WHERE cliente_id = :cliente_id";
		return $this->db->delete($query, array(':cliente_id' => $chaveContato));
	}
	/**
	 * removeEmail
	 * 
	 * Metodo para remover os emails associados a um cliente
	 *
	 * @param [int] $chaveContato chave do cliente a ser removido os telefones
	 * @return bolean
	 */
	public function removeEmail($chaveContato)
	{
		$query = "DELETE FROM email WHERE cliente_id = :cliente_id";
		return $this->db->delete($query, array(':cliente_id' => $chaveContato));
	}

	/**
	 * remove
	 * 
	 * Metodo para remover o cliente e suas dependencias
	 *
	 * @param [int] $chaveContato chave do cliente a ser removido
	 * @return bolean
	 */
	public function remove($key)
	{

		$this->removeEmail($key);
		$this->removeTelefone($key);
		return parent::remove($key);
	}
}
