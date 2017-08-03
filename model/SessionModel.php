<?php

namespace model;

use core\DBDriverInterface;
use core\ValidatorInterface;
use core\DBDriver;

class SessionModel extends BaseModel
{
	/**
	 * UserModel constructor
	 * @param DBDriverInterface $db
	 */
	public function __construct(DBDriverInterface $db, ValidatorInterface $validator)
	{
		parent::__construct($db, $validator);
		$this->table = 'session';
		$this->validator->setSchema([
			
			'id' => [
				'type' => 'integer',
				'require' => false
			],

			'user_id' => [
				'type' => 'string',
				'length' => 16,
				'require' => true
			],

			'sid' => [
				'type' => 'string',
				'length' => 16,
				'require' => true
			],

		]);
	}

	public function getBySID($sid)
	{
		return $this->db->query(
				"SELECT * FROM {$this->table} WHERE sid = :sid",
				['login' => $sid],
				DBDriver::FETCH_ONE
			);
		
	}
}