<?php
class M_umkm extends CI_Model{

	function get_all_umkm(){
		$hsl=$this->db->query("SELECT tbl_umkm.*,DATE_FORMAT(umkm_tanggal,'%d/%m/%Y') AS tanggal FROM tbl_umkm ORDER BY umkm_id DESC");
		return $hsl;
	}
	function simpan_umkm($judul,$isi,$imgslider,$user_id,$user_nama,$gambar,$slug){
		$hsl=$this->db->query("insert into tbl_umkm(umkm_judul,umkm_isi,umkm_img_slider,umkm_pengguna_id,umkm_author,umkm_gambar,umkm_slug) values ('$judul','$isi','$imgslider','$user_id','$user_nama','$gambar','$slug')");
		return $hsl;
	}
	function get_umkm_by_kode($kode){
		$hsl=$this->db->query("SELECT tbl_umkm.*,DATE_FORMAT(umkm_tanggal,'%d/%m/%Y') AS tanggal FROM tbl_umkm where umkm_id='$kode'");
		return $hsl;
	}
	function update_umkm($umkm_id,$judul,$isi,$imgslider,$user_id,$user_nama,$gambar,$slug){
		$hsl=$this->db->query("update tbl_umkm set umkm_judul='$judul',umkm_isi='$isi',umkm_img_slider='$imgslider',umkm_pengguna_id='$user_id',umkm_author='$user_nama',umkm_gambar='$gambar',umkm_slug='$slug' where umkm_id='$umkm_id'");
		return $hsl;
	}
	function update_umkm_tanpa_img($umkm_id,$judul,$isi,$imgslider,$user_id,$user_nama,$slug){
		$hsl=$this->db->query("update tbl_umkm set umkm_judul='$judul',umkm_isi='$isi',umkm_img_slider='$imgslider',umkm_pengguna_id='$user_id',umkm_author='$user_nama',umkm_slug='$slug' where umkm_id='$umkm_id'");
		return $hsl;
	}
	function hapus_umkm($kode){
		$hsl=$this->db->query("delete from tbl_umkm where umkm_id='$kode'");
		return $hsl;
	}

	//Front-End
	function get_ukm_slider(){
		$hsl=$this->db->query("SELECT tbl_umkm.*,DATE_FORMAT(umkm_tanggal,'%d/%m/%Y') AS tanggal FROM tbl_umkm where umkm_img_slider='1' ORDER BY umkm_id DESC");
		return $hsl;
	}
	function get_ukm_home(){
		$hsl=$this->db->query("SELECT tbl_umkm.*,DATE_FORMAT(umkm_tanggal,'%d/%m/%Y') AS tanggal FROM tbl_umkm ORDER BY umkm_id DESC limit 4");
		return $hsl;
	}

	function ukm_perpage($offset,$limit){
		$hsl=$this->db->query("SELECT tbl_umkm.*,DATE_FORMAT(umkm_tanggal,'%d/%m/%Y') AS tanggal FROM tbl_umkm ORDER BY umkm_id DESC limit $offset,$limit");
		return $hsl;
	}

	function ukm(){
		$hsl=$this->db->query("SELECT tbl_umkm.*,DATE_FORMAT(umkm_tanggal,'%d/%m/%Y') AS tanggal FROM tbl_umkm ORDER BY umkm_id DESC");
		return $hsl;
	}
	function get_ukm_by_kode($kode){
		$hsl=$this->db->query("SELECT tbl_umkm.*,DATE_FORMAT(umkm_tanggal,'%d/%m/%Y') AS tanggal FROM tbl_umkm where umkm_id='$kode'");
		return $hsl;
	}

	function cari_ukm($keyword){
		$hsl=$this->db->query("SELECT tbl_umkm.*,DATE_FORMAT(umkm_tanggal,'%d/%m/%Y') AS tanggal FROM tbl_umkm WHERE umkm_judul LIKE '%$keyword%' LIMIT 5");
		return $hsl;
	}

	function show_komentar_by_umkm_id($kode){
		$hsl=$this->db->query("SELECT * FROM tbl_komentar_umkm WHERE komentar_umkm_id='$kode' AND komentar_status='1' AND komentar_parent='0'");
		return $hsl;
	}


}
