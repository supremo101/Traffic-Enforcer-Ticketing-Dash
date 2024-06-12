<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/RestController.php';
require APPPATH . 'libraries/Format.php';

use chriskacerguis\RestServer\RestController;

class Violation extends RestController
{

	function __construct()
	{
		// Construct the parent class
		parent::__construct();
		$this->load->model('ViolationModel');
		$this->load->model('DriverViolationModel');

	}
	public function index_get()
	{
		$model = new ViolationModel;

		$result = $model->getAll();
		$this->response($result, RestController::HTTP_OK);
	}





	public function get_violation_get()
	{
		$model = new ViolationModel;

		$requestData = $this->input->get();
		$result = $model->getByUserID($requestData['user_id']);

		$this->response($result, RestController::HTTP_OK);
	}


	public function get_driver_violation_get()
	{
		$model = new ViolationModel;

		$requestData = $this->input->get();


		$result = $model->getByName($requestData['name']);
		$this->response($result, RestController::HTTP_OK);
	}

	public function insert_post()
	{

		$model = new ViolationModel;
		$driverViolationModel = new DriverViolationModel;

		$signatureFile = $_FILES['signature'];
		$requestData = json_decode($this->input->post('data'), true);
		$data = array(
			'violator_last_name' => $requestData['violator_last_name'],
			'violator_first_name' => $requestData['violator_first_name'],
			'violator_middle_name' => $requestData['violator_middle_name'],
			'violator_address' => $requestData['violator_address'],
			'driver_license' => $requestData['driver_license'],
			'expiration_date' => $requestData['expiration_date'],
			'birthdate' => $requestData['birthdate'],
			'gender' => $requestData['gender'],
			'registered_owner_last_name' => $requestData['registered_owner_last_name'],
			'registered_owner_first_name' => $requestData['registered_owner_first_name'],
			'registered_owner_middle_name' => $requestData['registered_owner_middle_name'],
			'registered_owner_address' => $requestData['registered_owner_address'],
			'vehicle_make_type' => $requestData['vehicle_make_type'],
			'plate_number' => $requestData['plate_number'],
			'cr_number' => $requestData['cr_number'],
			'franchise_number' => $requestData['franchise_number'],
			'violation_place' => $requestData['violation_place'],
			'violation_date_time' => $requestData['violation_date_time'],
			'remarks' => $requestData['remarks'],
			'user_id' => $requestData['user_id'],
			'status' => $requestData['status'],
			'due_date' => $requestData['due_date'],

		);


		// Define the file path to save the file
		$uploadPath = './assets/image/signatures/';
		$fileName = time() . '.png';
		$filePath = $uploadPath . $fileName;

		// Ensure the upload directory exists
		if (!is_dir($uploadPath)) {
			mkdir($uploadPath, 0755, true);
		}

		if (move_uploaded_file($signatureFile['tmp_name'], $filePath)) {
			// Save the file path to the database
			$data['signature'] = $fileName;

			$violation_id = $model->insert($data);



			foreach ($requestData['violations'] as $violation) {
				$driver_violation = array(
					'penalty_id' => $violation,
					'violation_id' => $violation_id,
				);

				$driverViolationModel->insert($driver_violation);
			}


			$this->response([
				'status' => true,
				'message' => 'Successfully Inserted'
			], RestController::HTTP_OK);
		} else {
			$this->response([
				'status' => false,
				'message' => 'Failed to upload the signature'
			], RestController::HTTP_INTERNAL_SERVER_ERROR);
		}
	}


	public function update_post($id)
	{


		$model = new ViolationModel;
		$driverViolationModel = new DriverViolationModel;



		$requestData = json_decode($this->input->post('data'), true);

		$data = array(
			'violator_last_name' => $requestData['violator_last_name'],
			'violator_first_name' => $requestData['violator_first_name'],
			'violator_middle_name' => $requestData['violator_middle_name'],
			'violator_address' => $requestData['violator_address'],
			'driver_license' => $requestData['driver_license'],
			'expiration_date' => $requestData['expiration_date'],
			'birthdate' => $requestData['birthdate'],
			'gender' => $requestData['gender'],
			'registered_owner_last_name' => $requestData['registered_owner_last_name'],
			'registered_owner_first_name' => $requestData['registered_owner_first_name'],
			'registered_owner_middle_name' => $requestData['registered_owner_middle_name'],
			'registered_owner_address' => $requestData['registered_owner_address'],
			'vehicle_make_type' => $requestData['vehicle_make_type'],
			'plate_number' => $requestData['plate_number'],
			'cr_number' => $requestData['cr_number'],
			'franchise_number' => $requestData['franchise_number'],
			'violation_place' => $requestData['violation_place'],
			'violation_date_time' => $requestData['violation_date_time'],
			'remarks' => $requestData['remarks'],
			'user_id' => $requestData['user_id'],
			'status' => $requestData['status'],
			'due_date' => $requestData['due_date'],

		);

		// update the data then delete the driver violation then insert new violation
		$result = $model->update($id, $data);
		$driverViolationModel->deleteByViolationID($id);

		foreach ($requestData['violations'] as $violation) {
			$driver_violation = array(
				'penalty_id' => $violation,
				'violation_id' => $id,
			);

			$driverViolationModel->insert($driver_violation);

		}

		if ($result > 0) {
			$this->response([
				'status' => true,
				'message' => 'Successfully Updated.'
			], RestController::HTTP_OK);
		} else {

			$this->response([
				'status' => false,
				'message' => 'Failed to delete.'
			], RestController::HTTP_BAD_REQUEST);

		}




	}

	public function payment_put($id)
	{


		$model = new ViolationModel;


		$requestData = json_decode($this->input->raw_input_stream, true);
 
		$data = array(
			'status' => $requestData['status'],
		);

		$result = $model->update($id, $data);


		if ($result > 0) {
			$this->response([
				'status' => true,
				'message' => 'Payment Successful.'
			], RestController::HTTP_OK);
		} else {

			$this->response([
				'status' => false,
				'message' => 'Failed to delete.'
			], RestController::HTTP_BAD_REQUEST);

		}




	}
	public function delete_delete($id)
	{
		$model = new ViolationModel;
		$driverViolationModel = new DriverViolationModel;


		$driverViolationModel->deleteByViolationID($id);
		$result = $model->delete($id);
		if ($result > 0) {
			$this->response([
				'status' => true,
				'message' => 'Successfully Deleted.'
			], RestController::HTTP_OK);
		} else {

			$this->response([
				'status' => false,
				'message' => 'Failed to delete.'
			], RestController::HTTP_BAD_REQUEST);

		}
	}


}
