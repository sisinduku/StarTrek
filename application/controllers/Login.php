<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	
	public function __construct()
	{
	
		parent::__construct();
	}
	
	public function index(){
		if($this->load->cek_sesi(false)){
			$this->output->set_header("Location: ".site_url("/main"));
			return;
		}
		if($this->input->get('url') !== null)
			$data['location'] = htmlspecialchars($this->input->get('url'));
		$data['pageTitle'] = "Halaman Login StarTrek";
		$this->load->view("login_form", $data);
	}
	
	public function login(){
		$data['pageTitle'] = "Halaman Login StarTrek";
		if($this->input->post('location') !== null)
			$data['location'] = $this->input->post('location');
	
		if ($this->form_validation->run() == FALSE){
			
		}else{
			$this->load->model("admin");
			$data['errors'] = $this->admin->adminLogin();
			if (empty($data['errors']) && $this->input->post('location') == "")
				header("Location:".site_url("/main"));
			if (empty($data['errors']) && $this->input->post('location') != "")
				header("Location:".base_url($this->input->post('location')));
		}
		$this->load->view("login_form", $data);
	}
	
	public function logout(){
		$this->load->model('admin');
		$this->admin->adminLogout();
		$this->output->set_header("Location: ".site_url("/login"));
	}
}