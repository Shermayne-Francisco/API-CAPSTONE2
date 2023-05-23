<?php
	class Get {
		protected $pdo, $gm;

		public function __construct(\PDO $pdo) {
			$this->gm = new GlobalMethods($pdo);
			$this->pdo = $pdo;
		}

		public function getuserpet($user_id) 
		{
			$payload = [];
			$code = 404;
			$remarks = "failed";
			$message = "Unable to retrieve data";


			$sql = "SELECT * FROM pet_tbl ";
			if($user_id != null){
				$sql.=" WHERE user_id = $user_id";
			}
			$res = $this->gm->executeQuery($sql);
			
			if ($res['code']==200) {
				$payload = $res['data'];
				$code = 200;
				$remarks = "success";
				$message = "Successfully retrieved requested records";
			}
			return $this->gm->response($payload, $remarks, $message, $code);
		}

		public function getpet($user_id) 
		{
			$payload = [];
			$code = 404;
			$remarks = "failed";
			$message = "Unable to retrieve data";

			
			$sql = "SELECT * FROM pet_tbl ";
			if($user_id != null){
				$sql.=" WHERE user_id = $user_id";
			}
			$res = $this->gm->executeQuery($sql);
			
			if ($res['code']==200) {
				$payload = $res['data'];
				$code = 200;
				$remarks = "success";
				$message = "Successfully retrieved requested records";
			}
			return $this->gm->response($payload, $remarks, $message, $code);
		}
		public function getpetinfo($pet_id) 
		{
			$payload = [];
			$code = 404;
			$remarks = "failed";
			$message = "Unable to retrieve data";

			
			$sql = "SELECT * FROM pet_tbl ";
			if($pet_id != null){
				$sql.=" WHERE pet_id = $pet_id";
			}
			$res = $this->gm->executeQuery($sql);
			
			if ($res['code']==200) {
				$payload = $res['data'];
				$code = 200;
				$remarks = "success";
				$message = "Successfully retrieved requested records";
			}
			return $this->gm->response($payload, $remarks, $message, $code);
		}

		public function getPetinfos($data,$pet_id){
			$payload = [];
			$code = 404;
			$remarks = "failed";
			$message = "Unable to retrieve data";

			
			$sql = "SELECT * FROM appointment_tbl INNER JOIN completed_tbl ON appointment_tbl.pet_id = completed_tbl.pet_id ";
			if($pet_id != null){
				$sql.=" WHERE appointment_tbl.pet_id = $pet_id ";
			}
			if($data->type != null){
				$sql.=" AND appointment_tbl.app_type = $data->type";
			}

			$res = $this->gm->executeQuery($sql);
			
			if ($res['code']==200) {
				$payload = $res['data'];
				$code = 200;
				$remarks = "success";
				$message = "Successfully retrieved requested records";
			}
			return $this->gm->response($payload, $remarks, $message, $code);
		}

		public function getAppointment($user_id) 
		{
			$payload = [];
			$code = 404;
			$remarks = "failed";
			$message = "Unable to retrieve data";

			$sql = "SELECT * FROM appointment_tbl  
							INNER JOIN pet_tbl 
							ON appointment_tbl.pet_id = pet_tbl.pet_id ";
			if($user_id != null ){
			$sql.= " WHERE appointment_tbl.user_id = $user_id" ;
			}
			$res = $this->gm->executeQuery($sql);

			if ($res['code']==200) {
				$payload = $res['data'];
				$code = 200;
				$remarks = "success";
				$message = "Successfully retrieved requested records";
			}
			return $this->gm->response($payload, $remarks, $message, $code);
		}

		public function getRequestAppointment($data) 
		{
			$payload = [];
			$code = 404;
			$remarks = "failed";
			$message = "Unable to retrieve data";

			$sql = "SELECT appointment_tbl.*, pet_tbl.pet_name, users.user_id, users.user_fname, users.user_lname  
					FROM appointment_tbl  
					INNER JOIN pet_tbl ON appointment_tbl.pet_id = pet_tbl.pet_id
					INNER JOIN users ON appointment_tbl.user_id = users.user_id";

			if ($data->user_id != null) {
				$sql .= " WHERE appointment_tbl.user_id = $data->user_id";
			}
			
			$sql .= " AND appointment_tbl.status = '$data->status'";

			$res = $this->gm->executeQuery($sql);
			$count = count($res['data']);
			if ($res['code'] == 200) {
				$payload = [$res['data'], $count];
				$code = 200;
				$remarks = "success";
				$message = "Successfully retrieved requested records";
			}
			return $this->gm->response($payload, $remarks, $message, $code);
		}

		
		// public function getPendingAppointment($data) 
		// {
		// 	$payload = [];
		// 	$code = 404;
		// 	$remarks = "failed";
		// 	$message = "Unable to retrieve data";

		// 	$sql = "SELECT appointment_tbl.*, pet_tbl.pet_name, users.user_id, users.user_fname, users.user_lname  
		// 			FROM appointment_tbl  
		// 			INNER JOIN pet_tbl ON appointment_tbl.pet_id = pet_tbl.pet_id
		// 			INNER JOIN users ON appointment_tbl.user_id = users.user_id";

		// 	if ($data->user_id != null) {
		// 		$sql .= " WHERE appointment_tbl.user_id = $data->user_id";
		// 	}
			
		// 	$sql .= " AND appointment_tbl.status = '$data->status'";

		// 	$res = $this->gm->executeQuery($sql);
		// 	$count = count($res['data']);
		// 	if ($res['code'] == 200) {
		// 		$payload = [$res['data'], $count];
		// 		$code = 200;
		// 		$remarks = "success";
		// 		$message = "Successfully retrieved requested records";
		// 	}
		// 	return $this->gm->response($payload, $remarks, $message, $code);
		// }


		public function getAllAppointments(){
			$payload = [];
			$code = 404;
			$remarks = "failed";
			$message = "Unable to retrieve data";

			$sql = "SELECT users.user_id, users.user_fname, users.user_lname, pet_tbl.pet_id, pet_tbl.pet_name, 
			appointment_tbl.app_id, appointment_tbl.user_id, appointment_tbl.pet_id, 
			appointment_tbl.app_type, appointment_tbl.app_date, 
			appointment_tbl.app_time, appointment_tbl.status FROM users users, pet_tbl pet_tbl, 
			appointment_tbl appointment_tbl
			WHERE users.user_id = appointment_tbl.user_id AND pet_tbl.pet_id = appointment_tbl.pet_id";

			$res = $this->gm->executeQuery($sql);

			if ($res['code']==200) {
				$payload = $res['data'];
				$code = 200;
				$remarks = "success";
				$message = "Successfully retrieved requested records";
			}
			return $this->gm->response($payload, $remarks, $message, $code);
		}

		// COUNT ALL CLIENTS
		public function getAllClients() {
			$payload = [];
			$code = 404;
			$remarks = "failed";
			$message = "Unable to retrieve data";
		
			$sql = "SELECT count(*) FROM users ORDER BY user_id";
			$res = $this->gm->executeQuery($sql);

			if ($res['code']==200) {
				$payload = $res['data'];
				$code = 200;
				$remarks = "success";
				$message = "Successfully retrieved requested records";
			}
			return $this->gm->response($payload, $remarks, $message, $code);
		}

		// COUNT ALL REQUEST
		public function getAllRequest() {
			$payload = [];
			$code = 404;
			$remarks = "failed";
			$message = "Unable to retrieve data";
		
			$sql = "SELECT count(*) FROM appointment_tbl WHERE status = 'Appointed' ORDER BY app_id";
			$res = $this->gm->executeQuery($sql);
			
			if ($res['code']==200) {
				$payload = $res['data'];
				$code = 200;
				$remarks = "success";
				$message = "Successfully retrieved requested records";
			}
			return $this->gm->response($payload, $remarks, $message, $code);
		}

		// COUNT ALL COMPLETED
		public function getAllCompleted() {
			$payload = [];
			$code = 404;
			$remarks = "failed";
			$message = "Unable to retrieve data";
		
			$sql = "SELECT count(*) FROM appointment_tbl WHERE status = 'Completed' ORDER BY app_id";
			$res = $this->gm->executeQuery($sql);
			
			if ($res['code']==200) {
				$payload = $res['data'];
				$code = 200;
				$remarks = "success";
				$message = "Successfully retrieved requested records";
			}
			return $this->gm->response($payload, $remarks, $message, $code);
		}

		
		// COUNT ALL PENDING
		public function getAllPending() {
			$payload = [];
			$code = 404;
			$remarks = "failed";
			$message = "Unable to retrieve data";
		
			$sql = "SELECT count(*) FROM appointment_tbl WHERE status = 'Pending' ORDER BY app_id";
			$res = $this->gm->executeQuery($sql);
			
			if ($res['code']==200) {
				$payload = $res['data'];
				$code = 200;
				$remarks = "success";
				$message = "Successfully retrieved requested records";
			}
			return $this->gm->response($payload, $remarks, $message, $code);
		}

		
		// CLIENTS TABLE
			public function getALLClientsInfo() {
				$payload = [];
				$code = 404;
				$remarks = "failed";
				$message = "Unable to retrieve data";
			
				$sql = "SELECT user_id, user_fname, user_lname FROM users ORDER BY user_id";
				$res = $this->gm->executeQuery($sql);

				if ($res['code']==200) {
					$payload = $res['data'];
					$code = 200;
					$remarks = "success";
					$message = "Successfully retrieved requested records";
				}
				return $this->gm->response($payload, $remarks, $message, $code);
			}
		// END CLIENTS TABLE

		// CERTAIN CLIENT
			public function getSpecificClientInfo($user_id) {
				$payload = [];
				$code = 404;
				$remarks = "failed";
				$message = "Unable to retrieve data";
			
				$sql = "SELECT * FROM users INNER JOIN pet_tbl ON users.user_id = pet_tbl.user_id WHERE users.user_id = $user_id;";
				$res = $this->gm->executeQuery($sql);

				if ($res['code']==200) {
					$payload = $res['data'];
					$code = 200;
					$remarks = "success";
					$message = "Successfully retrieved requested records";
				}
				return $this->gm->response($payload, $remarks, $message, $code);
			}
		// END CERTAIN CLIENT

		// VACCINATION TREATMENT
			public function getAllVaccinationReports() {
				$payload = [];
				$code = 404;
				$remarks = "failed";
				$message = "Unable to retrieve data";
			
				$sql = "SELECT * FROM appointment_tbl WHERE app_type = 'Vaccination' AND status = 'Completed'";
				$res = $this->gm->executeQuery($sql);

				if ($res['code']==200) {
					$payload = $res['data'];
					$code = 200;
					$remarks = "success";
					$message = "Successfully retrieved requested records";
				}
				return $this->gm->response($payload, $remarks, $message, $code);
			}
		// END VACCINATION TREATMENT

		// DEWORMING TREATMENT
			public function getAllDewormingReports() {
				$payload = [];
				$code = 404;
				$remarks = "failed";
				$message = "Unable to retrieve data";
			
				$sql = "SELECT * FROM appointment_tbl WHERE app_type = 'Deworming' AND status = 'Completed'";
				$res = $this->gm->executeQuery($sql);

				if ($res['code']==200) {
					$payload = $res['data'];
					$code = 200;
					$remarks = "success";
					$message = "Successfully retrieved requested records";
				}
				return $this->gm->response($payload, $remarks, $message, $code);
			}
		// END DEWORMING TREATMENT

		// HEARTWORM TREATMENT
			public function getAllHeartWormReports() {
				$payload = [];
				$code = 404;
				$remarks = "failed";
				$message = "Unable to retrieve data";
			
				$sql = "SELECT * FROM appointment_tbl WHERE app_type = 'Heartworm' AND status = 'Completed'";
				$res = $this->gm->executeQuery($sql);

				if ($res['code']==200) {
					$payload = $res['data'];
					$code = 200;
					$remarks = "success";
					$message = "Successfully retrieved requested records";
				}
				return $this->gm->response($payload, $remarks, $message, $code);
			}
		// END HEARTWORM TREATMENT

		// GROOMING TREATMENT
			public function getAllGroomingReports() {
				$payload = [];
				$code = 404;
				$remarks = "failed";
				$message = "Unable to retrieve data";
			
				$sql = "SELECT * FROM appointment_tbl WHERE app_type = 'Grooming' AND status = 'Completed'";
				$res = $this->gm->executeQuery($sql);

				if ($res['code']==200) {
					$payload = $res['data'];
					$code = 200;
					$remarks = "success";
					$message = "Successfully retrieved requested records";
				}
				return $this->gm->response($payload, $remarks, $message, $code);
			}
		// END GROOMING TREATMENT

		// OTHER REPORTS
			public function getAllOtherReports() {
				$payload = [];
				$code = 404;
				$remarks = "failed";
				$message = "Unable to retrieve data";
			
				$sql = "SELECT * FROM appointment_tbl WHERE app_type != 'Grooming' AND app_type != 'Vaccination'
				AND app_type != 'Deworming' AND app_type != 'Heartworm' AND status = 'Completed'";
				$res = $this->gm->executeQuery($sql);

				if ($res['code']==200) {
					$payload = $res['data'];
					$code = 200;
					$remarks = "success";
					$message = "Successfully retrieved requested records";
				}
				return $this->gm->response($payload, $remarks, $message, $code);
			}
		// END OTHER REPORTS

		// REQUEST TABLE
			public function getAllRequestForTable() {
				$payload = [];
				$code = 404;
				$remarks = "failed";
				$message = "Unable to retrieve data";
			
				$sql = "SELECT * FROM appointment_tbl WHERE status = 'Pending' ORDER BY app_id";
				$res = $this->gm->executeQuery($sql);
				
				if ($res['code']==200) {
					$payload = $res['data'];
					$code = 200;
					$remarks = "success";
					$message = "Successfully retrieved requested records";
				}
				return $this->gm->response($payload, $remarks, $message, $code);
			}
		// REQUEST TABLE

		// PRINT REPORTS
				public function printVaccinationReports() {
					$payload = [];
					$code = 404;
					$remarks = "failed";
					$message = "Unable to retrieve data";
				
					$sql = "SELECT * FROM appointment_tbl WHERE app_type = 'Vaccination' AND status = 'Completed'";
					$res = $this->gm->executeQuery($sql);

					if ($res['code']==200) {
						$payload = $res['data'];
						$code = 200;
						$remarks = "success";
						$message = "Successfully retrieved requested records";
					}
					return $this->gm->response($payload, $remarks, $message, $code);
				}

				public function printDewormingReports() {
					$payload = [];
					$code = 404;
					$remarks = "failed";
					$message = "Unable to retrieve data";
				
					$sql = "SELECT * FROM appointment_tbl WHERE app_type = 'Deworming' AND status = 'Completed'";
					$res = $this->gm->executeQuery($sql);

					if ($res['code']==200) {
						$payload = $res['data'];
						$code = 200;
						$remarks = "success";
						$message = "Successfully retrieved requested records";
					}
					return $this->gm->response($payload, $remarks, $message, $code);
				}

				public function printHeartWormReports() {
					$payload = [];
					$code = 404;
					$remarks = "failed";
					$message = "Unable to retrieve data";
				
					$sql = "SELECT * FROM appointment_tbl WHERE app_type = 'Heartworm' AND status = 'Completed'";
					$res = $this->gm->executeQuery($sql);

					if ($res['code']==200) {
						$payload = $res['data'];
						$code = 200;
						$remarks = "success";
						$message = "Successfully retrieved requested records";
					}
					return $this->gm->response($payload, $remarks, $message, $code);
				}

				public function printGroomingReports() {
					$payload = [];
					$code = 404;
					$remarks = "failed";
					$message = "Unable to retrieve data";
				
					$sql = "SELECT * FROM appointment_tbl WHERE app_type = 'Grooming' AND status = 'Completed'";
					$res = $this->gm->executeQuery($sql);

					if ($res['code']==200) {
						$payload = $res['data'];
						$code = 200;
						$remarks = "success";
						$message = "Successfully retrieved requested records";
					}
					return $this->gm->response($payload, $remarks, $message, $code);
				}

				public function printOtherReports() {
					$payload = [];
					$code = 404;
					$remarks = "failed";
					$message = "Unable to retrieve data";
				
					$sql = "SELECT * FROM appointment_tbl WHERE app_type != 'Grooming' AND app_type != 'Vaccination'
					AND app_type != 'Deworming' AND app_type != 'Heartworm' AND status = 'Completed'";
					$res = $this->gm->executeQuery($sql);

					if ($res['code']==200) {
						$payload = $res['data'];
						$code = 200;
						$remarks = "success";
						$message = "Successfully retrieved requested records";
					}
					return $this->gm->response($payload, $remarks, $message, $code);
				}
		// END PRINT REPORTS
	}
?>


