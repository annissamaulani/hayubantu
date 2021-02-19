<?php
class Umkm extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('m_umkm');
		$this->load->model('m_pengunjung');
		$this->m_pengunjung->count_visitor();
	}
	function index(){
		$jum=$this->m_umkm->ukm();
        $page=$this->uri->segment(3);
        if(!$page):
            $offset = 0;
        else:
            $offset = $page;
        endif;
        $limit=5;
        $config['base_url'] = base_url() . 'umkm/index/';
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
						$x['data']=$this->m_umkm->ukm_perpage($offset,$limit);
						$x['populer']=$this->db->query("SELECT * FROM tbl_umkm ORDER BY umkm_views DESC LIMIT 5");
						$this->load->view('depan/v_umkm',$x);
	}
	function detail($slugs){
		$slug=htmlspecialchars($slugs,ENT_QUOTES);
		$query = $this->db->get_where('tbl_umkm', array('umkm_slug' => $slug));
		if($query->num_rows() > 0){
			$b=$query->row_array();
			$kode=$b['umkm_id'];
			$this->db->query("UPDATE tbl_umkm SET umkm_views=umkm_views+1 WHERE umkm_id='$kode'");
			$data=$this->m_umkm->get_umkm_by_kode($kode);
			$row=$data->row_array();
			$x['id']=$row['umkm_id'];
			$x['title']=$row['umkm_judul'];
			$x['image']=$row['umkm_gambar'];
			$x['umkm'] =$row['umkm_isi'];
			$x['tanggal']=$row['tanggal'];
			$x['author']=$row['umkm_author'];
			$x['slug']=$row['umkm_slug'];
			$x['show_komentar']=$this->m_umkm->show_komentar_by_umkm_id($kode);
			$x['populer']=$this->db->query("SELECT * FROM tbl_umkm ORDER BY umkm_views DESC LIMIT 5");
			$this->load->view('depan/v_umkm_detail',$x);
		}else{
			redirect('umkm');
		}
	}

    function search(){
        $keyword=str_replace("'", "", htmlspecialchars($this->input->get('keyword',TRUE),ENT_QUOTES));
        $query=$this->m_umkm->cari_umkm($keyword);
				if($query->num_rows() > 0){
					$x['data']=$query;
  				$x['populer']=$this->db->query("SELECT * FROM tbl_umkm ORDER BY umkm_views DESC LIMIT 5");
          $this->load->view('depan/v_umkm',$x);
	 		 }else{
				 echo $this->session->set_flashdata('msg','<div class="alert alert-danger">Tidak dapat menemukan umkm dengan kata kunci <b>'.$keyword.'</b></div>');
				 redirect('umkm');
			 }
    }

		function komentar(){
				$kode = htmlspecialchars($this->input->post('id',TRUE),ENT_QUOTES);
				$data=$this->m_umkm->get_umkm_by_kode($kode);
				$row=$data->row_array();
				$slug=$row['umkm_slug'];
				$nama = htmlspecialchars($this->input->post('nama',TRUE),ENT_QUOTES);
				$email = htmlspecialchars($this->input->post('email',TRUE),ENT_QUOTES);
				$komentar = nl2br(htmlspecialchars($this->input->post('komentar',TRUE),ENT_QUOTES));
				if(empty($nama) || empty($email)){
					$this->session->set_flashdata('msg','<div class="alert alert-danger">Masukkan input dengan benar.</div>');
					redirect('umkm/'.$slug);
				}else{
					$data = array(
			        'komentar_nama' 			=> $nama,
			        'komentar_email' 			=> $email,
			        'komentar_isi' 				=> $komentar,
							'komentar_status' 		=> 0,
							'komentar_umkm_id' => $kode
					);

					$this->db->insert('tbl_komentar_umkm', $data);
					$this->session->set_flashdata('msg','<div class="alert alert-info">Komentar Anda akan tampil setelah moderasi.</div>');
					redirect('umkm/'.$slug);
				}
		}

}
