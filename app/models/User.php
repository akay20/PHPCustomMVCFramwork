<?php 

class User {

	private $db;

	public function __construct(){
		$this->db = new Database;
	}

	public function findUserByEmail($email){

		$this->db->query('SELECT email from users where email = :email');
		$this->db->bind(':email', $email);
		
		$row = $this->db->single();

		// Check row count
		if($this->db->rowCount() > 0 ){
			return TRUE;
		} else {
			return FALSE;
		}

	}

}

?>