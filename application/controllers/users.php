<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
	public function __construct(){
		parent ::__construct();
		$this->output->enable_profiler(TRUE);
		$this->load->model('User');
	}
	public function index(){
		// $this->session->sess_destroy();
		$this->load->view("main");
	}
	public function create(){
		$this->User->reg_user($this->input->post());
		redirect ('/');
	}
	public function userLogin(){
		// die('reached login?');
		$data = $this->User->login_user($this->input->post());
		// var_dump($data);
		// die('userLogin - data');
		if($data['logged_in']===FALSE){
			redirect ('/');
		} else {
			$this->session->set_userdata('current_user', $data);
			redirect ('/dashboard');
		}
	}
	public function dashboard(){
		// var_dump($this->session->userdata('current_user'));
		// die('in dashboard');
		$data['quotes']=$this->User->unfaved_quotes();
		$data['favedQuotes']=$this->User->faved_quotes();
		$data['userdata'] = $this->session->userdata('current_user');
		// var_dump($data['userdata']);
		// die('dashboard - quotes');
		$this->load->view('quotes', $data);
	}
	public function add(){
		$this->User->add_quote($this->input->post());
		redirect ('/dashboard');
	}
	public function update(){
		// var_dump($this->input->post());
		// die('in update');
		$this->User->add_to_list($this->input->post());
		redirect ('/dashboard');
	}
	public function remove(){
		$this->User->remove_from_list($this->input->post());
		redirect ('/dashboard');
	}
	public function delete(){
		$this->session->sess_destroy();
		redirect ('/');
	}
}
?>