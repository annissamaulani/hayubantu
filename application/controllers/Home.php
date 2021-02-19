<?php
class Home extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('m_tulisan');
		$this->load->model('m_pariwisata');
		$this->load->model('m_galeri');
		$this->load->model('m_files');
		$this->load->model('m_pengunjung');
		$this->m_pengunjung->count_visitor();
	}
	function index(){
			$x['berita']=$this->m_tulisan->get_berita_home();
			$x['wisata']=$this->m_pariwisata->get_wisata_home();
			$this->load->view('depan/v_home',$x);
	}

}
