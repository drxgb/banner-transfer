<?php

namespace App\Repository;

use DateTime;
use DB\Connection;
use Exception;
use PDO;

class TransfererRepository
{
	/** @var PDO $db */
	private $db;
	private $table;

	public function __construct()
	{
		$this->db = Connection::get();
		$this->table =  Connection::getConfiguration('table');
	}


	public function getSourcePosition(int $id)
	{
		$userColumn = Connection::getConfiguration('user_column');
		$sourceColumn = Connection::getConfiguration('source_column');

		$query = $this->db->query(
			"SELECT $sourceColumn
				FROM $this->table
				WHERE $userColumn = $id;"
		);
		return $query->fetchColumn();
	}


	public function setDestinationPosition(int $id, int $pos)
	{
		try
		{
			$this->db->beginTransaction();
			$userColumn = Connection::getConfiguration('user_column');
			$destinationColumn = Connection::getConfiguration('destination_column');
			$dateColumn = Connection::getConfiguration('date_column');
			$now = time();

			$stmt = $this->db->prepare(
				"UPDATE $this->table
					SET $destinationColumn = :pos,
						$dateColumn = :d
					WHERE $userColumn = :id"
			);
	
			$stmt->bindParam(':pos', $pos);
			$stmt->bindParam(':d', $now);
			$stmt->bindParam(':id', $id);
			$stmt->execute();

			$this->db->commit();
		}
		catch (Exception $e)
		{
			$this->db->rollBack();
			throw $e;
		}

	}
}