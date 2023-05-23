<?php 
	class Post {
		protected $pdo, $gm, $get;

		public function __construct(\PDO $pdo) {
			$this->gm = new GlobalMethods($pdo);
			$this->get = new Get($pdo);
			$this->pdo = $pdo;
		}

		public function addpet($data)
		{
			
			$payload = [];
			$code = 404;
			$remarks = "failed";
			$message = "Unable to save data";
			
			$sql = "INSERT INTO pet_tbl (user_id, pet_name, pet_cm, pet_breed, birthdate,gender) VALUES (?,?,?,?,?,?)";
            $sql = $this->pdo->prepare($sql);
            $sql->execute([
                $data->user_id,
                $data->pet_name,
                $data->pet_cm,
                $data->pet_breed,
                $data->birthdate,
                $data->gender
            ]);

            $LAST_ID = $this->pdo->lastInsertId();
			
			$sql2 = "SELECT * FROM pet_tbl
						WHERE pet_tbl.pet_id = $LAST_ID ";
			
			$res2 = $this->gm->executeQuery($sql2);
			
			if ($res2['code']==200) {
				$payload = $res2['data'];
				$code = 200;
				$remarks = "success";
				$message = "Successfully retrieved requested records";
			}
			return $this->gm->response($payload, $remarks, $message, $code);
		}

		public function updateUsers($dt, $user_id) 
		{
			$payload = [];
			$code = 404;
			$remarks = "failed";
			$message = "Unable to save data";

			$res = $this->gm->update("users", $dt, "user_id=$user_id");

			
			$sql = "SELECT * FROM users WHERE user_id= $user_id LIMIT 1";
			$res = $this->gm->executeQuery($sql);
			
			$address = $res["data"][0]["address"];
			$contact = $res["data"][0]["contact"];
			$email = $res["data"][0]["email"];
			$id = $res["data"][0]["user_id"];
			$user_fname = $res["data"][0]["user_fname"];
			$user_lname = $res["data"][0]["user_lname"];

			if ($res['code']==200) {
				$payload = [
				"address"=>	$address,
				"contact"=>	$contact,
				"email"=>	$email,
				"id"=>	$id,
				"user_fname"=>	$user_fname,
				"user_lname"=>	$user_lname
				];
				$code = 200;
				$remarks = "success";
				$message = "Successfully retrieved requested records";
			}
			return $this->gm->response($payload, $remarks, $message, $code);
		}


		public function user_register($data)
		{
			
			$payload = [];
			$code = 404;
			$remarks = "failed";
			$message = "Unable to retrieve data";

			

			try {
				$sql = "SELECT * FROM users WHERE email = ?";
				$sql = $this->pdo->prepare($sql);
				$sql->execute([
					$data->email
				]);	

				$count = $sql->rowCount();

				if ($count) {
					$message = 'Email already registered';
					return $this->gm->response($payload, $remarks, $message, $code);
				} else {
					$sql = "INSERT INTO users (	user_fname,user_lname,contact,address,email,password) VALUES (?,?,?,?,?,?)";
					$sql = $this->pdo->prepare($sql);
					$sql->execute([$data->user_fname, 
									$data->user_lname,
									$data->contact,
									$data->address,
									$data->email,
									password_hash($data->password,PASSWORD_DEFAULT )
								]);

						$code = 200;
						$remarks = "success";
						$message = "Successfully retrieved requested records";
				
						return $this->gm->response($payload, $remarks, $message, $code);
				}

			}catch (\PDOException $e) {
				return $this->gm->response($payload, $remarks, $message, $code);
			}
		}

		public function addAppointment($data)
		{
			$payload = [];
			$code = 404;
			$remarks = "failed";
			$message = "Unable to retrieve data";

			try {

				$sql = "INSERT INTO appointment_tbl (user_id,pet_id,app_type,status,app_date	) VALUES (?,?,?,?,?)";
				$sql = $this->pdo->prepare($sql);
				$sql->execute([$data->user_id, 
								$data->pet_id,
								$data->app_type,
								$data->status,
								$data->app_date
							]);

					$code = 200;
					$remarks = "success";
					$message = "Successfully retrieved requested records";
			
				return $this->gm->response($payload, $remarks, $message, $code);
	

			}catch (\PDOException $e) {
				return $this->gm->response($payload, $remarks, $message, $code);
			}
		}

		public function updatePassword($data,$user_id)
		{
			$payload = [];
			$code = 404;
			$remarks = "failed";
			$message = "Unable to retrieve data";

			try {
			
				$sql = "SELECT * FROM users WHERE user_id = ?";
                $sql = $this->pdo->prepare($sql);
                $sql->execute([
                    $user_id,
                ]);

                 $res = $sql->fetch(PDO::FETCH_ASSOC);


				if($res && password_verify( $data->current_password,$res["password"]))
				{

					$sql = "UPDATE users SET password = ? WHERE user_id = ?";
					$sql = $this->pdo->prepare($sql);
					$sql->execute([password_hash($data->new_password,PASSWORD_DEFAULT),
									$user_id]);
					
					$code = 200;
					$remarks = "success";
					$message = "Successfully retrieved requested records";
				}
				
				return $this->gm->response($payload, $remarks, $message, $code);


			}catch (\PDOException $e) {
				return $this->gm->response($payload, $remarks, $message, $code);
			}
		}

		public function deletePet($pet_id)
		{
			$payload = [];
			$code = 404;
			$remarks = "failed";
			$message = "Unable to retrieve data";

			try {
			
				$sql = "DELETE FROM pet_tbl WHERE pet_id = ?";
                $sql = $this->pdo->prepare($sql);
                $sql->execute([
                    $pet_id,
                ]);


					$code = 200;
					$remarks = "success";
					$message = "Successfully Deleted Data";
			
				
				return $this->gm->response($payload, $remarks, $message, $code);


			}catch (\PDOException $e) {
				return $this->gm->response($payload, $remarks, $message, $code);
			}
		}

		public function updateAppointment($dt, $app_id) 
		{
			$payload = [];
			$code = 404;
			$remarks = "failed";
			$message = "Unable to save data";

			$res = $this->gm->update("appointment_tbl", $dt, "app_id = $app_id");

			if ($res['code']==200) {
				$payload = [];
				$code = 200;
				$remarks = "success";
				$message = "Successfully retrieved requested records";
			}
			return $this->gm->response($payload, $remarks, $message, $code);
		}


		//  ADD SCHEDULE FOR CLIENT
			// LAGAY MO NEIL SA EXECUTE
			public function addAppoinmentForClient($data)
			{
				$payload = [];
				$code = 404;
				$remarks = "failed";
				$message = "Unable to retrieve data";
				try {
					$sql = "INSERT INTO appointment_tbl (user_id,pet_id,app_type,status,app_date, app_time) VALUES (?,?,?,?,?)";
					$sql = $this->pdo->prepare($sql);
					$sql->execute([$data->user_id, 
									$data->pet_id,
									$data->app_type,
									'Pending',
									$data->app_date,
									$data->app_time
								]);
						$code = 200;
						$remarks = "success";
						$message = "Successfully retrieved requested records";
				
					return $this->gm->response($payload, $remarks, $message, $code);
		

				}catch (\PDOException $e) {
					return $this->gm->response($payload, $remarks, $message, $code);
				}
			}
		//  ADD SCHEDULE FOR CLIENT

		//  ADD COMPLETED HEALTH FOR CLIENT
			public function addHealthForClient($data)
			{
				$payload = [];
				$code = 404;
				$remarks = "failed";
				$message = "Unable to retrieve data";
				try {
					$sql = "INSERT INTO completed_tbl (user_id,pet_id,app_type,name_of_medicine,pet_weight, app_date) VALUES (?,?,?,?,?,?)";
					$sql = $this->pdo->prepare($sql);
					$sql->execute([$data->user_id, 
									$data->pet_id,
									$data->app_type,
									$data->name_of_medicine,
									$data->pet_weight,
									$data->app_date
								]);
						$code = 200;
						$remarks = "success";
						$message = "Successfully retrieved requested records";
				
					return $this->gm->response($payload, $remarks, $message, $code);
		

				}catch (\PDOException $e) {
					return $this->gm->response($payload, $remarks, $message, $code);
				}
			}
		// END ADD COMPLETED HEALTH FOR CLIENT




	}
?>