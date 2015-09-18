<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

Class User extends CI_Model {


	public function reg_user($post){
		$this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[3]');
		$this->form_validation->set_rules('alias', 'Alias', 'trim|required|min_length[3]');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[users.email]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
		$this->form_validation->set_rules('pass_conf', 'Password confirmation', 'trim|required|matches[password]');
		$this->form_validation->set_rules('dob', 'Date of Birth', 'required');
		if ($this->form_validation->run()===FALSE){
			$this->session->set_flashdata('errors', validation_errors());
		} else {
			$email = strtolower($post['email']);
			$query = "INSERT INTO users (name, alias, email, password, date_of_birth, created_at, updated_at) VALUES (?,?,?,?,?,NOW(),NOW())";
			$values = array($post['name'], $post['alias'], $email, $post['password'], $post['dob']);
			$this->db->query($query, $values);
			$this->session->set_flashdata('success', 'You have successfully registered. Please login.');
		}

	}
	public function get_user_by_email($email){
		$query = "SELECT id, name, password FROM users WHERE email = ?";
		return $this->db->query($query, $email)->row_array();
	}
	public function login_user($post){
		$this->form_validation->set_rules('email', 'Email', 'trim|required');
		if($this->form_validation->run() === FALSE){
			$this->session->set_flashdata('errors', validation_errors());
			$data['logged_in'] = FALSE;
		} else {

			$get_user = $this->get_user_by_email($post['email']);
			if(!$get_user){
				$this->session->set_flashdata('errors', 'Entered email is not registered.');
				$data['logged_in'] = FALSE;
			} else {
				if($post['password'] === $get_user['password']){
					$data['logged_in'] = TRUE;
					$data['name'] = $get_user['name'];
					$data['id'] = $get_user['id'];
				} else {
					$this->session->set_flashdata('errors', "Entered password does not match registered email's password." );
					$data['logged_in'] = FALSE;
				}
			}
		}
		return $data;
	}
	public function unfaved_quotes(){
		$current_user = $this->session->userdata('current_user');
		$id = $current_user['id'];
		$query = "SELECT users.alias as posted_by, quotes.id as quote_id, quotes.originator as origin, quotes.quote as quote FROM quotes LEFT JOIN users ON quotes.posted_users_id = users.id WHERE quotes.id NOT IN (SELECT favorites.quotes_id FROM favorites WHERE favorites.users_id = ? )";
		return $this->db->query($query, $id)->result_array();
	}
	public function faved_quotes(){
		$current_user = $this->session->userdata('current_user');
		$id = $current_user['id'];
		$query = "SELECT users.alias as posted_by, quotes.id as quote_id, quotes.originator as origin, quotes.quote as quote FROM quotes LEFT JOIN users ON quotes.posted_users_id = users.id WHERE quotes.id IN (SELECT favorites.quotes_id FROM favorites WHERE favorites.users_id = ? )";
		return $this->db->query($query, $id)->result_array();

	}
	public function add_quote($post){
		$current_user = $this->session->userdata('current_user');
		$id = $current_user['id'];
		$query = "INSERT INTO quotes (originator, quote, created_at, updated_at, posted_users_id) VALUES (?,?,NOW(),NOW(),?)";
		$values = array($post['origin'], $post['quote'], $id);
		$this->db->query($query, $values);
	}
	public function add_to_list($post){
		// var_dump($post);
		// die('in model');
		$current_user = $this->session->userdata('current_user');
		$id = $current_user['id'];
		$query = "INSERT INTO favorites (users_id, quotes_id) VALUES (?,?)";
		$values = array($id, $post['quote_id']);
		$this->db->query($query, $values);
	}
	public function remove_from_list($post){
		$current_user = $this->session->userdata('current_user');
		$id = $current_user['id'];
		$query = "DELETE FROM favorites WHERE favorites.quotes_id = ? AND favorites.users_id = ?";
		$values = array($post['quote_id'], $id);
		$this->db->query($query, $values);
	}

}
?>