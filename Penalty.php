<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/RestController.php';
require APPPATH . 'libraries/Format.php';

use chriskacerguis\RestServer\RestController;

class Penalty extends RestController
{

	function __construct()
	{
		// Construct the parent class
		parent::__construct();
		$this->load->model('PenaltyModel');
	}
	public function index_get()
	{
		$model = new PenaltyModel;
		$result = $model->getAll();
		$this->response($result, RestController::HTTP_OK);
	}


	public function insert_post()
	{

		$model = new PenaltyModel;
		$requestData = json_decode($this->input->raw_input_stream, true);

		$data = array(
			'penalty' => $requestData['penalty'],
			'amount' => $requestData['amount'],
		);
		$result = $model->insert($data);

		if ($result > 0) {
			$this->response([
				'status' => true,
				'message' => 'Successfully Inserted'
			], RestController::HTTP_OK);
		} else {

			$this->response([
				'status' => false,
				'message' => 'Failed to create penalty.'
			], RestController::HTTP_BAD_REQUEST);

		}


	}



	public function find_get($id)
	{
		$model = new PenaltyModel;
		$result = $model->find($id);

		$this->response($result, RestController::HTTP_OK);

	}

	public function update_put($id)
	{


		$model = new PenaltyModel;

		$requestData = json_decode($this->input->raw_input_stream, true);

		$data = array(
			'penalty' => $requestData['penalty'],
			'amount' => $requestData['amount'],

		);

		$update_result = $model->update($id, $data);

		if ($update_result > 0) {
			$this->response([
				'status' => true,
				'message' => 'Successfully Updated.'
			], RestController::HTTP_OK);
		} else {

			$this->response([
				'status' => false,
				'message' => 'Failed to update Course.'
			], RestController::HTTP_BAD_REQUEST);

		}
	}


	public function delete_delete($id)
	{
		$model = new PenaltyModel;
		$result = $model->delete($id);
		if ($result > 0) {
			$this->response([
				'status' => true,
				'message' => 'Successfully Deleted.'
			], RestController::HTTP_OK);
		} else {

			$this->response([
				'status' => false,
				'message' => 'Failed to delete course.'
			], RestController::HTTP_BAD_REQUEST);

		}
	}


}
