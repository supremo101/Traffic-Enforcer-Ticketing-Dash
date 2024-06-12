<?php

defined('BASEPATH') or exit('No direct script access allowed');

class DriverViolationModel extends CI_Model
{

	public $table = 'driver_violation';

	public function insert($data)
	{

		return $this->db->insert($this->table, $data);

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
	public function deleteByViolationID($id)
	{
		return $this->db->delete($this->table, ['violation_id' => $id]);
	}


}
