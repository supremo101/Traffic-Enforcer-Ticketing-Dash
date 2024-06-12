<?php

defined('BASEPATH') or exit('No direct script access allowed');

class ViolationModel extends CI_Model
{

	public $table = 'violation';

	public function getAll()
	{

		$this->db
			->select('
				v.id,
				v.violator_last_name,
				v.violator_first_name,
				v.violator_middle_name,
				v.violator_address,
				v.driver_license,
				v.expiration_date,
				v.birthdate,
				v.gender,
				v.registered_owner_last_name,
				v.registered_owner_first_name,
				v.registered_owner_middle_name,
				v.registered_owner_address,
				v.vehicle_make_type,
				v.plate_number,
				v.cr_number,
				v.franchise_number,
				v.violation_place,
				v.violation_date_time,
				v.due_date,
				v.remarks, 
				v.status,
				v.signature,
				user.id user_id,
				user.first_name  apprehending_officer_first_name,
				user.middle_name  apprehending_officer_middle_name,
				user.last_name apprehending_officer_last_name,
			
			')
			->from('violation v')
			->join('user', 'v.user_id = user.id', 'LEFT')
			->order_by('v.violation_date_time', 'desc');



		$query = $this->db->get();
		$data = $query->result();

		if (sizeof($data) > 0) {
			foreach ($data as $index => $row) {

				$violation_id = $row->id;
				$driver_violation = $this->db->query('SELECT * FROM driver_violation where violation_id =' . $violation_id)->result();

				if (sizeof($driver_violation)) {
					$penalty = [];
					$penalty_id = [];
					$total_amount = 0;
					foreach ($driver_violation as $violation) {

						$get_penalty_amount = $this->db->query('SELECT * FROM penalty where id =' . $violation->penalty_id)->row();



						$total_amount += (float) $get_penalty_amount->amount;
						$penalty_id[] = $violation->penalty_id;
						$penalty[] = $get_penalty_amount->penalty;
					}


					$data[$index]->penalty = implode(', ', $penalty);
					$data[$index]->violations = $penalty_id;
					$data[$index]->total_amount = $total_amount;  // total penalty amount

				} else {

					$data[$index]->violations = [''];
					$data[$index]->total_amount = 0;
					$data[$index]->penalty = '';
				}

			}
		}

		return $data;
	}

	public function getByUserID($user_id)
	{

		$this->db
			->select('
				v.id,
				v.violator_last_name,
				v.violator_first_name,
				v.violator_middle_name,
				v.violator_address,
				v.driver_license,
				v.expiration_date,
				v.birthdate,
				v.gender,
				v.registered_owner_last_name,
				v.registered_owner_first_name,
				v.registered_owner_middle_name,
				v.registered_owner_address,
				v.vehicle_make_type,
				v.plate_number,
				v.cr_number,
				v.franchise_number,
				v.violation_place,
				v.violation_date_time,
				v.due_date,
				v.remarks, 
				v.status,
				v.signature,
				user.id user_id,
				user.first_name  apprehending_officer_first_name,
				user.middle_name  apprehending_officer_middle_name,
				user.last_name apprehending_officer_last_name,
			
			')
			->from('violation v')
			->join('user', 'v.user_id = user.id', 'LEFT')
			->where('v.user_id', $user_id)
			->order_by('v.violation_date_time', 'desc');




		$query = $this->db->get();
		$data = $query->result();

		if (sizeof($data) > 0) {
			foreach ($data as $index => $row) {

				$violation_id = $row->id;
				$driver_violation = $this->db->query('SELECT * FROM driver_violation where violation_id =' . $violation_id)->result();

				if (sizeof($driver_violation)) {
					$penalty = [];
					$penalty_id = [];
					$total_amount = 0;
					foreach ($driver_violation as $violation) {

						$get_penalty_amount = $this->db->query('SELECT * FROM penalty where id =' . $violation->penalty_id)->row();



						$total_amount += (float) $get_penalty_amount->amount;
						$penalty_id[] = $violation->penalty_id;
						$penalty[] = $get_penalty_amount->penalty;
					}


					$data[$index]->penalty = implode(', ', $penalty);
					$data[$index]->violations = $penalty_id;
					$data[$index]->total_amount = $total_amount;  // total penalty amount

				} else {

					$data[$index]->violations = [''];
					$data[$index]->total_amount = 0;
					$data[$index]->penalty = '';
				}

			}
		}

		return $data;
	}


	public function getByName($name)
	{

		$this->db
			->select('
				v.id,
				v.violator_last_name,
				v.violator_first_name,
				v.violator_middle_name,
				v.violator_address,
				v.driver_license,
				v.expiration_date,
				v.birthdate,
				v.gender,
				v.registered_owner_last_name,
				v.registered_owner_first_name,
				v.registered_owner_middle_name,
				v.registered_owner_address,
				v.vehicle_make_type,
				v.plate_number,
				v.cr_number,
				v.franchise_number,
				v.violation_place,
				v.violation_date_time,
				v.due_date,
				v.remarks, 
				v.status,
				v.signature,
				user.id user_id,
				user.first_name  apprehending_officer_first_name,
				user.middle_name  apprehending_officer_middle_name,
				user.last_name apprehending_officer_last_name,
			
			')
			->from('violation v')
			->join('user', 'v.user_id = user.id', 'LEFT')
			->where("CONCAT(v.violator_first_name, ' ', v.violator_middle_name, ' ', v.violator_last_name) = '$name'")

			->order_by('v.violation_date_time', 'desc');



		$query = $this->db->get();
		$data = $query->result();

		if (sizeof($data) > 0) {
			foreach ($data as $index => $row) {

				$violation_id = $row->id;
				$driver_violation = $this->db->query('SELECT * FROM driver_violation where violation_id =' . $violation_id)->result();

				if (sizeof($driver_violation)) {
					$penalty = [];
					$penalty_id = [];
					$total_amount = 0;
					foreach ($driver_violation as $violation) {

						$get_penalty_amount = $this->db->query('SELECT * FROM penalty where id =' . $violation->penalty_id)->row();



						$total_amount += (float) $get_penalty_amount->amount;
						$penalty_id[] = $violation->penalty_id;
						$penalty[] = $get_penalty_amount->penalty;
					}


					$data[$index]->penalty = implode(', ', $penalty);
					$data[$index]->violations = $penalty_id;
					$data[$index]->total_amount = $total_amount;  // total penalty amount

				} else {

					$data[$index]->violations = [''];
					$data[$index]->total_amount = 0;
					$data[$index]->penalty = '';
				}

			}
		}

		return $data;
	}


	public function insert($data)
	{

		$insert = $this->db->insert($this->table, $data);
		if ($insert) {

			return $this->db->insert_id();
		}
	}

	public function find($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get($this->table);
		return $query->row();
	}


	public function update($id, $data)
	{
		$this->db->where('id', $id);
		return $this->db->update($this->table, $data);
	}

	public function delete($id)
	{
		return $this->db->delete($this->table, ['id' => $id]);
	}


}
