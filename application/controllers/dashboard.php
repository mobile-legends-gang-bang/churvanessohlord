<?php error_reporting(0); ?>
<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('dashboard_model');
		$this->load->model('behavior_model');
		$this->load->model('attendance_model');
		$this->load->model('section_model');
		$this->load->model('note_model');
	}

	public function index() {
		if(!$this->session->userdata('logged_in')) {
			redirect('login', 'refresh');
		} else 
			$data['title'] = "Edukit - Dashboard";
			$data['name'] = "DASHBOARD";
			$data['classlist'] = $this->section_model->getclasslist();
			$data['subjectlist'] = $this->section_model->getsubject();
			$data['class_id'] = $this->section_model->getclassid();
			$data['class'] = $this->section_model->getclass();
			$data['uniqueclass'] = $this->section_model->getUniqueclass();
			$data['scorez'] = $this->section_model->getScoreType();
			$data['content'] = "dashboard/index";
			$data['notesview'] = $this->note_model->getnotesToday();
			$data['countnotes'] = $this->note_model->countnotesToday();
			$this->load->view('main/index', $data);
	}

	public function getstudentsBySection(){
        if($this->session->userdata('logged_in')){
            $data = $this->dashboard_model->getstudentsBySection();
             echo json_encode($data);
        }
        else
            redirect('login', 'refresh');        
    }

    public function getbehaviorPositive(){
    	if($this->session->userdata('logged_in')){
            $countpositive = $this->dashboard_model->getbehaviorPositive()->row()->behavior_type;
            $countnegative = $this->dashboard_model->getbehaviorNegative()->row()->behavior_type;
            $percent1 = ($countpositive/($countpositive+$countnegative))*100;
            $percent2 = ($countnegative/($countpositive+$countnegative))*100;

            $data['point1'] = number_format($percent1, 2,'.','');
            $data['name1'] = 'Positive';
            $data['point2'] =number_format($percent2, 2,'.','');
            $data['name2'] = 'Negative';
            echo json_encode($data);
        }
        else
            redirect('login', 'refresh');
    }

    public function getStudRank(){
    	$data['namaste'] = $this->dashboard_model->getstudentRank()->row()->name;
    	$data['numberste'] = $this->dashboard_model->getstudentRank()->row()->score;
        echo json_encode($data);
    }



    public function rankstudents(){
        if($this->session->userdata('logged_in')){
            $data['records'] = $this->dashboard_model->rankstudents();
            $data['formula'] = $this->dashboard_model->getformula();
            $this->load->view('dashboard/rank', $data);
        }
        else
            redirect('login', 'refresh');
    }

    public function lessperforming(){
        if($this->session->userdata('logged_in')){
            $data['records'] = $this->dashboard_model->rankstudents();
            $data['formula'] = $this->dashboard_model->getformula();
            $this->load->view('dashboard/lessperforming', $data);
        }
        else
            redirect('login', 'refresh');
    }

    public function rankabsences(){
        if($this->session->userdata('logged_in')){
            $data['records'] = $this->dashboard_model->rankabsent();
            $this->load->view('dashboard/absences', $data);
        }
        else
            redirect('login', 'refresh');
    }

    public function getattendancerecord(){
        if($this->session->userdata('logged_in')){
            $date = trim($this->dashboard_model->getattendancerecord()->row()->dates,"{}");
            $newdate = explode(',', $date);
            $count_present = trim($this->dashboard_model->getattendancerecord()->row()->present_count,"{}");
            $newcount = explode(',', $count_present);
            $data['dates'] = $newdate;
            $data['count'] = $newcount;    
            echo json_encode($data);
        }
        else
            redirect('login', 'refresh');
    }
}
