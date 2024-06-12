<?php

defined('BASEPATH') or exit('No direct script access allowed');

class CommunityEngagementModel extends CI_Model
{

	public $table = 'community_engagement';

	public function getAll()
	{
		$query = $this->db
			->select('community_engagement.*, user.first_name, user.last_name, user.middle_name')
			->where('community_engagement.user_id =   user.id')
			->order_by('datetime', 'desc')
			->get('community_engagement, user');
		return $query->result();
	}


	public function insert($data)
	{

		return $this->db->insert($this->table, $data);
	}


	public function get($data)
	{ 
		$query = $this->db
			->select('community_engagement.*, user.first_name, user.last_name, user.middle_name')
			->where('community_engagement.user_id =   user.id')
			->where($data)
			->order_by('datetime', 'desc')
			->get('community_engagement, user');
		return $query->result();
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
