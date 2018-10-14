<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Attendance extends CI_Controller {
	public function index() {
		if(!$this->session->userdata('logged_in')) {
			$this->load->view('login/index');
		} else 
			$data['title'] = "Edukit - Attendance";
			$data['name'] = "ATTENDANCE MONITORING";
			$this->load->view('attendance/index',$data);
	}
}
