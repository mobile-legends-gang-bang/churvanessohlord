<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {
	public function index() {
		if(!$this->session->userdata('logged_in')) {
			$this->load->view('register/index');
		} else 
			$this->load->view('dashboard/index');
	}
	public function savedata() {
		$this->form_validation->set_rules('lname', 'Last Name', 'trim');
		$this->form_validation->set_rules('fname', 'First Name', 'trim');
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required');
		if ($this->form_validation->run()){
			$response['status'] = FALSE;
			$existUsername = $this->db->query("SELECT username FROM public.register WHERE username = ?", $this->input->post('username'));
			if ($existUsername->num_rows() > 0)
				$response['message'] = "Username already exists!";
			else {
				if ($this->input->post('password') != $this->input->post('confirm_password'))
					$response['message'] = "Passwords do not match!";
				else {
					$data = array(
						'lname' => $this->input->post('lname'),
						'fname' => $this->input->post('fname'),
						'username' => $this->input->post('username'),
						'password' => $this->input->post('password')
					);
					$this->db->insert('public.register', $data);
					$response['status'] = TRUE;
					$response['message'] = "Successfully registered data.";
				}
			}
			echo json_encode($response);
		} else 
			redirect('register','refresh');
	}
}
