<?php 
	class DbConnect {
		private $host = 'localhost';
		private $dbName = 'u1791370_starsstore';
		private $user = 'u1791370_mds';
		private $pass = '9*We9~yduFXm';

		public function connect() {
			try {
				$conn = new PDO('mysql:host=' . $this->host . '; dbname=' . $this->dbName, $this->user, $this->pass);
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				return $conn;
			} catch( PDOException $e) {
				echo 'Database Error: ' . $e->getMessage();
			}
		}
	}
 ?>