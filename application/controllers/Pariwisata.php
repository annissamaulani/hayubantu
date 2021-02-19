<?php
class Pariwisata extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('m_pariwisata');
		$this->load->model('m_pengunjung');
		$this->m_pengunjung->count_visitor();
	}
	function index(){
		$jum=$this->m_pariwisata->wisata();
        $page=$this->uri->segment(3);
        if(!$page):
            $offset = 0;
        else:
            $offset = $page;
        endif;
        $limit=5;
        $config['base_url'] = base_url() . 'pariwisata/index/';
            $config['total_rows'] = $jum->num_rows();
            $config['per_page'] = $limit;
            $config['uri_segment'] = 3;
						//Tambahan untuk styling
	          $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
	          $config['full_tag_close']   = '</ul></nav></div>';
	          $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
	          $config['num_tag_close']    = '</span></li>';
	          $config['cur_tag_open']     = '<li class="page-item"><span class="page-link">';
	          $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
	          $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
	          $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
	          $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
	          $config['prev_tagl_close']  = '</span>Next</li>';
	          $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
	          $config['first_tagl_close'] = '</span></li>';
	          $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
	          $config['last_tagl_close']  = '</span></li>';
            $config['first_link'] = 'Awal';
            $config['last_link'] = 'Akhir';
            $config['next_link'] = 'Next >>';
            $config['prev_link'] = '<< Prev';
            $this->pagination->initialize($config);
            $x['page'] =$this->pagination->create_links();
						$x['data']=$this->m_pariwisata->wisata_perpage($offset,$limit);
						$x['populer']=$this->db->query("SELECT * FROM tbl_pariwisata ORDER BY pariwisata_views DESC LIMIT 5");
						$this->load->view('depan/v_pariwisata',$x);
	}
	function detail($slugs){
		$slug=htmlspecialchars($slugs,ENT_QUOTES);
		$query = $this->db->get_where('tbl_pariwisata', array('pariwisata_slug' => $slug));
		if($query->num_rows() > 0){
			$b=$query->row_array();
			$kode=$b['pariwisata_id'];
			$this->db->query("UPDATE tbl_pariwisata SET pariwisata_views=pariwisata_views+1 WHERE pariwisata_id='$kode'");
			$data=$this->m_pariwisata->get_pariwisata_by_kode($kode);
			$row=$data->row_array();
			$x['id']=$row['pariwisata_id'];
			$x['title']=$row['pariwisata_judul'];
			$x['image']=$row['pariwisata_gambar'];
			$x['pariwisata'] =$row['pariwisata_isi'];
			$x['tanggal']=$row['tanggal'];
			$x['author']=$row['pariwisata_author'];
			$x['slug']=$row['pariwisata_slug'];
			$x['show_komentar']=$this->m_pariwisata->show_komentar_by_pariwisata_id($kode);
			$x['populer']=$this->db->query("SELECT * FROM tbl_pariwisata ORDER BY pariwisata_views DESC LIMIT 5");
			$this->load->view('depan/v_pariwisata_detail',$x);
		}else{
			redirect('pariwisata');
		}
	}

    function search(){
        $keyword=str_replace("'", "", htmlspecialchars($this->input->get('keyword',TRUE),ENT_QUOTES));
        $query=$this->m_pariwisata->cari_pariwisata($keyword);
				if($query->num_rows() > 0){
					$x['data']=$query;
  				$x['populer']=$this->db->query("SELECT * FROM tbl_pariwisata ORDER BY pariwisata_views DESC LIMIT 5");
          $this->load->view('depan/v_parawisata',$x);
	 		 }else{
				 echo $this->session->set_flashdata('msg','<div class="alert alert-danger">Tidak dapat menemukan pariwisata dengan kata kunci <b>'.$keyword.'</b></div>');
				 redirect('pariwisata');
			 }
    }

		function komentar(){
				$kode = htmlspecialchars($this->input->post('id',TRUE),ENT_QUOTES);
				$data=$this->m_pariwisata->get_pariwisata_by_kode($kode);
				$row=$data->row_array();
				$slug=$row['pariwisata_slug'];
				$nama = htmlspecialchars($this->input->post('nama',TRUE),ENT_QUOTES);
				$email = htmlspecialchars($this->input->post('email',TRUE),ENT_QUOTES);
				$komentar = nl2br(htmlspecialchars($this->input->post('komentar',TRUE),ENT_QUOTES));
				if(empty($nama) || empty($email)){
					$this->session->set_flashdata('msg','<div class="alert alert-danger">Masukkan input dengan benar.</div>');
					redirect('pariwisata/'.$slug);
				}else{
					$data = array(
			        'komentar_nama' 			=> $nama,
			        'komentar_email' 			=> $email,
			        'komentar_isi' 				=> $komentar,
							'komentar_status' 		=> 0,
							'komentar_pariwisata_id' => $kode
					);

					$this->db->insert('tbl_komentar_pariwisata', $data);
					$this->session->set_flashdata('msg','<div class="alert alert-info">Komentar Anda akan tampil setelah moderasi.</div>');
					redirect('pariwisata/'.$slug);
				}
		}

}
