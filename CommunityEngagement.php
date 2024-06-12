<?php
// header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Methods: GET, OPTIONS, POST, GET, PUT");
// header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");

defined('BASEPATH') or exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *"); // Replace * with your React app's domain if possible
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE");


require APPPATH . 'libraries/RestController.php';
require APPPATH . 'libraries/Format.php';

use chriskacerguis\RestServer\RestController;

class CommunityEngagement extends RestController
{

	function __construct()
	{
		// Construct the parent class
		parent::__construct();
		$this->load->model('CommunityEngagementModel');
		$this->load->helper(array('form', 'url'));

		$this->load->library('upload');

	}

	public function index_get()
	{
		$model = new CommunityEngagementModel;
		$result = $model->getAll();
		$this->response($result, RestController::HTTP_OK);
	}

	public function approved_list_get()
	{
		$model = new CommunityEngagementModel;

		$requestData = $this->input->get();
		$result = $model->get($requestData);
		$this->response($result, RestController::HTTP_OK);
	}
	public function get_community_engagement_get()
	{
		$model = new CommunityEngagementModel;

		$requestData = $this->input->get();
		$result = $model->get($requestData);
		$this->response($result, RestController::HTTP_OK);
	}


	public function insert_post()
	{

		$model = new CommunityEngagementModel;

		if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
			if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
				header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
			if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
				header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
			exit(0);
		}
		$files = $_FILES;
		$photos = [];
		$numberOfFiles = count($files['photos']['name']);
		$requestData = json_decode($this->input->post('data'), true);


		for ($i = 0; $i < $numberOfFiles; $i++) {
			$_FILES['photo']['name'] = $files['photos']['name'][$i];
			$_FILES['photo']['type'] = $files['photos']['type'][$i];
			$_FILES['photo']['tmp_name'] = $files['photos']['tmp_name'][$i];
			$_FILES['photo']['error'] = $files['photos']['error'][$i];
			$_FILES['photo']['size'] = $files['photos']['size'][$i];

			$this->upload->initialize($this->set_upload_options());

			if ($this->upload->do_upload('photo')) {
				$uploadData = $this->upload->data();
				$photos[] = $uploadData['file_name'];
				// You can store $uploadData['file_name'] in the database here if needed
			} else {
				$errors[] = $this->upload->display_errors();
			}

		}


		$data = array(
			'title' => $requestData['title'],
			'description' => $requestData['description'],
			'status' => $requestData['status'],
			'photos' => implode(', ', $photos),
			'user_id' => $requestData['user_id'],
		);

		$result = $model->insert($data);


		if ($result > 0) {
			$this->response([
				'status' => true,
				'message' => 'Successfully Inserted.'
			], RestController::HTTP_OK);
		} else {

			$this->response([
				'status' => false,
				'message' => 'Failed to update  .'
			], RestController::HTTP_BAD_REQUEST);

		}
	}


	private function set_upload_options()
	{

		// Ensure the specific folder exists and has write permissions
		$uploadPath = './assets/image/community_engagement/';
		if (!is_dir($uploadPath)) {
			mkdir($uploadPath, 0777, true);
		}

		return [
			'upload_path' => $uploadPath, // Adjust the upload path
			'allowed_types' => 'gif|jpg|png|jpeg',
			// 'max_size' => 2048, // 2MB
			// 'max_width' => 1024,
			// 'max_height' => 768,
		];
	}



	public function find_get($id)
	{
		$model = new CommunityEngagementModel;
		$result = $model->find($id);

		$this->response($result, RestController::HTTP_OK);

	}


	public function update_post($id)
	{

		$model = new CommunityEngagementModel;

		if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
			if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
				header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
			if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
				header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
			exit(0);
		}
		// $files = $_FILES;
		// $photos = [];
		// $numberOfFiles = count($files['photos']['name']);
		$requestData = json_decode($this->input->post('data'), true);




		$data = array(
			'title' => $requestData['title'],
			'description' => $requestData['description'],
			'status' => $requestData['status'],
		); 

		$result = $model->update($id, $data);
 

		if ($result > 0) {
			$this->response([
				'status' => true,
				'message' => 'Successfully Updated.'
			], RestController::HTTP_OK);
		} else {

			$this->response([
				'status' => false,
				'message' => 'Failed to update  .'
			], RestController::HTTP_BAD_REQUEST);

		}



	}


	public function delete_delete($id)
	{
		$model = new CommunityEngagementModel;
		$result = $model->delete($id);
		if ($result > 0) {
			$this->response([
				'status' => true,
				'message' => 'Successfully Deleted.'
			], RestController::HTTP_OK);
		} else {

			$this->response([
				'status' => false,
				'message' => 'Failed to delete  .'
			], RestController::HTTP_BAD_REQUEST);

		}
	}


}
