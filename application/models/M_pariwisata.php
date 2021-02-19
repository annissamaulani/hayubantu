<?php
class M_pariwisata extends CI_Model{

	function get_all_pariwisata(){
		$hsl=$this->db->query("SELECT tbl_pariwisata.*,DATE_FORMAT(pariwisata_tanggal,'%d/%m/%Y') AS tanggal FROM tbl_pariwisata ORDER BY pariwisata_id DESC");
		return $hsl;
	}
	function simpan_pariwisata($judul,$isi,$imgslider,$user_id,$user_nama,$gambar,$slug){
		$hsl=$this->db->query("insert into tbl_pariwisata(pariwisata_judul,pariwisata_isi,pariwisata_img_slider,pariwisata_pengguna_id,pariwisata_author,pariwisata_gambar,pariwisata_slug) values ('$judul','$isi','$imgslider','$user_id','$user_nama','$gambar','$slug')");
		return $hsl;
	}
	function get_pariwisata_by_kode($kode){
		$hsl=$this->db->query("SELECT tbl_pariwisata.*,DATE_FORMAT(pariwisata_tanggal,'%d/%m/%Y') AS tanggal FROM tbl_pariwisata where pariwisata_id='$kode'");
		return $hsl;
	}
	function update_pariwisata($pariwisata_id,$judul,$isi,$imgslider,$user_id,$user_nama,$gambar,$slug){
		$hsl=$this->db->query("update tbl_pariwisata set pariwisata_judul='$judul',pariwisata_isi='$isi',pariwisata_img_slider='$imgslider',pariwisata_pengguna_id='$user_id',pariwisata_author='$user_nama',pariwisata_gambar='$gambar',pariwisata_slug='$slug' where pariwisata_id='$pariwisata_id'");
		return $hsl;
	}
	function update_pariwisata_tanpa_img($pariwisata_id,$judul,$isi,$imgslider,$user_id,$user_nama,$slug){
		$hsl=$this->db->query("update tbl_pariwisata set pariwisata_judul='$judul',pariwisata_isi='$isi',pariwisata_img_slider='$imgslider',pariwisata_pengguna_id='$user_id',pariwisata_author='$user_nama',pariwisata_slug='$slug' where pariwisata_id='$pariwisata_id'");
		return $hsl;
	}
	function hapus_pariwisata($kode){
		$hsl=$this->db->query("delete from tbl_pariwisata where pariwisata_id='$kode'");
		return $hsl;
	}

	//Front-End
	function get_wisata_slider(){
		$hsl=$this->db->query("SELECT tbl_pariwisata.*,DATE_FORMAT(pariwisata_tanggal,'%d/%m/%Y') AS tanggal FROM tbl_pariwisata where pariwisata_img_slider='1' ORDER BY pariwisata_id DESC");
		return $hsl;
	}
	function get_wisata_home(){
		$hsl=$this->db->query("SELECT tbl_pariwisata.*,DATE_FORMAT(pariwisata_tanggal,'%d/%m/%Y') AS tanggal FROM tbl_pariwisata ORDER BY pariwisata_id DESC limit 4");
		return $hsl;
	}

	function wisata_perpage($offset,$limit){
		$hsl=$this->db->query("SELECT tbl_pariwisata.*,DATE_FORMAT(pariwisata_tanggal,'%d/%m/%Y') AS tanggal FROM tbl_pariwisata ORDER BY pariwisata_id DESC limit $offset,$limit");
		return $hsl;
	}

	function wisata(){
		$hsl=$this->db->query("SELECT tbl_pariwisata.*,DATE_FORMAT(pariwisata_tanggal,'%d/%m/%Y') AS tanggal FROM tbl_pariwisata ORDER BY pariwisata_id DESC");
		return $hsl;
	}
	function get_wisata_by_kode($kode){
		$hsl=$this->db->query("SELECT tbl_pariwisata.*,DATE_FORMAT(pariwisata_tanggal,'%d/%m/%Y') AS tanggal FROM tbl_pariwisata where pariwisata_id='$kode'");
		return $hsl;
	}

	function cari_wisata($keyword){
		$hsl=$this->db->query("SELECT tbl_pariwisata.*,DATE_FORMAT(pariwisata_tanggal,'%d/%m/%Y') AS tanggal FROM tbl_pariwisata WHERE pariwisata_judul LIKE '%$keyword%' LIMIT 5");
		return $hsl;
	}

	function show_komentar_by_pariwisata_id($kode){
		$hsl=$this->db->query("SELECT * FROM tbl_komentar_pariwisata WHERE komentar_pariwisata_id='$kode' AND komentar_status='1' AND komentar_parent='0'");
		return $hsl;
	}


}
