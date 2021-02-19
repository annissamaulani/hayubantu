<?php
class Map extends CI_Controller{
	function __construct(){
		parent::__construct();

	}
	function index(){
		$this->load->library('googlemaps');
        $config=array();
        $config['center']='-6.13952, 106.92075';
        $config['zoom']=17;
        $config['map_height']="400px";
        $this->googlemaps->initialize($config);
        $marker=array();
        $marker['position']='-6.13952, 106.92075';
        $this->googlemaps->add_marker($marker);
        $data['map']=$this->googlemaps->create_map();
		$this->load->view('depan/v_map',$data);
	}
}