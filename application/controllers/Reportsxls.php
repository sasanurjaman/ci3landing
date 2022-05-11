<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class ReportsXLS extends Controller 
{
	function ReportsXLS()
	{
		parent::Controller();
		if(!$this->session->userdata('SESS_USER_ID'))
		{
			redirect('login');
 		} 
	}
	
    function berkas()
    {
		$this->load->model('berkas_model');
        
        $company = $this->sim_model->data();
        $data = $this->berkas_model->printlist();
        
        $this->writer->send("laporan-berkas-lamaran.xls");
        $format1 = $this->writer->addFormat();
        $format1->setBold();
        $format1->setSize(12);
        $format2 = $this->writer->addFormat();
        $format2->setBold();
        $format2->setSize(10);
        $format2->setAlign('right');
        $format3 = $this->writer->addFormat();
        $format3->setBold();
        $column = $this->writer->addFormat();
        $column->setBold();
        $column->setTop(1);
        $column->setLeft(1);
        $column->setRight(1);
        $column->setBottom(1);
        $column->setFgColor('#cccccc');
        $column->setAlign('center');
        $content = $this->writer->addFormat();
        $content->setLeft(1);
        $content->setRight(1);
        $content->setBottom(1);
        $center = $this->writer->addFormat();
        $center->setLeft(1);
        $center->setRight(1);
        $center->setBottom(1);
        $center->setAlign('center');
        $sheet = $this->writer->addWorksheet('Berkas Lamaran');
        
        //setMerge($first_row, $first_col, $last_row, $last_col)
        $sheet->setMerge(0, 0, 0, 6);
        $sheet->setMerge(1, 0, 1, 2);
        $sheet->setMerge(1, 3, 1, 6);
        $sheet->setMerge(3, 0, 3, 1);
        
        //setColumn($firstcol, $lastcol, $width, $format = 0, $hidden = 0, $level = 0)
        $sheet->setColumn(0, 0, 4, 0, 0, 0);
        $sheet->setColumn(1, 1, 30, 0, 0, 0);
        $sheet->setColumn(2, 2, 15, 0, 0, 0);
        $sheet->setColumn(3, 3, 5, 0, 0, 0);
        $sheet->setColumn(4, 4, 60, 0, 0, 0);
        $sheet->setColumn(5, 5, 15, 0, 0, 0);
        $sheet->setColumn(6, 6, 15, 0, 0, 0);
        
        $sheet->writeString(0, 0, ($company->nama != '-' ? $company->nama : $this->config->item('site_name').' '.$this->config->item('version')), $format1);
        $sheet->writeString(1, 0, ($company->alamat != '-' ? $company->alamat.' '.$company->kota.' '.$company->kodepos : $this->config->item('site_admin')), 0);
        $sheet->writeString(1, 3, "Laporan Berkas Lamaran", $format2);
        $sheet->writeString(4, 0, "No", $column);
        $sheet->writeString(4, 1, "Nama", $column);
        $sheet->writeString(4, 2, "Tgl.Lahir", $column);
        $sheet->writeString(4, 3, "JK", $column);
        $sheet->writeString(4, 4, "Alamat", $column);
        $sheet->writeString(4, 5, "Telepon", $column);	
        $sheet->writeString(4, 6, "Selular", $column);	
        
        $r = 4;
        $n = 1;
        if ($total > 0)
        {
            $filterdata = array();
            $filterdata[] = 'p.kode = b.kode';
            if ($this->session->userdata('SESS_DATE1') != '' && $this->session->userdata('SESS_DATE2') != '')
                $filterdata[] = 'p.tanggal >= \''.$this->session->userdata('SESS_DATE1').'\' AND p.tanggal <= \''.$this->session->userdata('SESS_DATE2').'%\')';
            if ($this->session->userdata('SESS_POSITION'))
                $filterdata[] = 'b.posisi LIKE \'%'.$this->session->userdata('SESS_POSITION').'%\'';
            $where = (count($filterdata) > 0 ? 'WHERE '.implode(' AND ', $filterdata) : null);
            
            $query = $this->db->query('SELECT * FROM pelamar p, berkas b '.$where);
            $total = $query->num_rows();
            $sheet->writeString(3, 0, "TotalData: ".$total, $format3);
            
            foreach ( $data as $row ) 
            {
                $r++;
                $sheet->writeString($r, 0, $n++, $center);
                $sheet->writeString($r, 1, $row->nama, $content);
                $sheet->writeString($r, 2, $row->tglahir, $center);
                $sheet->writeString($r, 3, $row->kelamin, $center);
                $sheet->writeString($r, 4, $row->alamat, $content);
                $sheet->writeString($r, 5, $row->telepon, $content);
                $sheet->writeString($r, 6, $row->selular, $content);
            }
        }
        else
        {
            $sheet->writeString(3, 0, "TotalData: 0", $format3);
            $sheet->writeString(4, 0, "-", $center);
            $sheet->writeString(4, 1, "-", $content);
            $sheet->writeString(4, 2, "-", $center);
            $sheet->writeString(4, 3, "-", $center);
            $sheet->writeString(4, 4, "-", $content);
            $sheet->writeString(4, 5, "-", $content);
            $sheet->writeString(4, 6, "-", $content);
        }
        $this->writer->close();
	}
    
    function seleksi()
    {
		$this->load->model('seleksi_model');
        
        $company = $this->sim_model->data();
        $data = $this->seleksi_model->printlist();
        
        $this->writer->send("laporan-seleksi-lamaran.xls");
        $format1 = $this->writer->addFormat();
        $format1->setBold();
        $format1->setSize(12);
        $format2 = $this->writer->addFormat();
        $format2->setBold();
        $format2->setSize(10);
        $format2->setAlign('right');
        $format3 = $this->writer->addFormat();
        $format3->setBold();
        $column = $this->writer->addFormat();
        $column->setBold();
        $column->setTop(1);
        $column->setLeft(1);
        $column->setRight(1);
        $column->setBottom(1);
        $column->setFgColor('#cccccc');
        $column->setAlign('center');
        $content = $this->writer->addFormat();
        $content->setLeft(1);
        $content->setRight(1);
        $content->setBottom(1);
        $center = $this->writer->addFormat();
        $center->setLeft(1);
        $center->setRight(1);
        $center->setBottom(1);
        $center->setAlign('center');
        $sheet = $this->writer->addWorksheet('Seleksi Lamaran');
        
        //setMerge($first_row, $first_col, $last_row, $last_col)
        $sheet->setMerge(0, 0, 0, 6);
        $sheet->setMerge(1, 0, 1, 2);
        $sheet->setMerge(1, 3, 1, 6);
        $sheet->setMerge(3, 0, 3, 1);
        
        //setColumn($firstcol, $lastcol, $width, $format = 0, $hidden = 0, $level = 0)
        $sheet->setColumn(0, 0, 4, 0, 0, 0);
        $sheet->setColumn(1, 1, 30, 0, 0, 0);
        $sheet->setColumn(2, 2, 15, 0, 0, 0);
        $sheet->setColumn(3, 3, 5, 0, 0, 0);
        $sheet->setColumn(4, 4, 60, 0, 0, 0);
        $sheet->setColumn(5, 5, 15, 0, 0, 0);
        $sheet->setColumn(6, 6, 15, 0, 0, 0);
        
        $sheet->writeString(0, 0, ($company->nama != '-' ? $company->nama : $this->config->item('site_name').' '.$this->config->item('version')), $format1);
        $sheet->writeString(1, 0, ($company->alamat != '-' ? $company->alamat.' '.$company->kota.' '.$company->kodepos : $this->config->item('site_admin')), 0);
        $sheet->writeString(1, 3, "Laporan Seleksi Lamaran", $format2);
        $sheet->writeString(4, 0, "No", $column);
        $sheet->writeString(4, 1, "Nama", $column);
        $sheet->writeString(4, 2, "Tgl.Lahir", $column);
        $sheet->writeString(4, 3, "JK", $column);
        $sheet->writeString(4, 4, "Alamat", $column);
        $sheet->writeString(4, 5, "Telepon", $column);	
        $sheet->writeString(4, 6, "Selular", $column);	
        
        $r = 4;
        $n = 1;
        if ($data != false)
        {
            $filterdata = array();
            $filterdata[] = 'p.kode = s.kode';
            if ($this->session->userdata('SESS_DATE1') != '' && $this->session->userdata('SESS_DATE2') != '')
                $filterdata[] = 's.tanggal >= \''.$this->session->userdata('SESS_DATE1').'\' AND s.tanggal <= \''.$this->session->userdata('SESS_DATE2').'%\')';
            if ($this->session->userdata('SESS_TYPE'))
                $filterdata[] = 's.idjenis = \''.$this->session->userdata('SESS_TYPE').'\'';
            $where = (count($filterdata) > 0 ? 'WHERE '.implode(' AND ', $filterdata) : null);
            
            $query = $this->db->query('SELECT * FROM pelamar p, seleksi s '.$where);
            $total = $query->num_rows();
            $sheet->writeString(3, 0, "TotalData: ".$total, $format3);
            
            foreach ( $data as $row ) 
            {
                $r++;
                $sheet->writeString($r, 0, $n++, $center);
                $sheet->writeString($r, 1, $row->nama, $content);
                $sheet->writeString($r, 2, $row->tglahir, $center);
                $sheet->writeString($r, 3, $row->kelamin, $center);
                $sheet->writeString($r, 4, $row->alamat, $content);
                $sheet->writeString($r, 5, $row->telepon, $content);
                $sheet->writeString($r, 6, $row->selular, $content);
            }
        }
        else
        {
            $sheet->writeString(3, 0, "TotalData: 0", $format3);
            $sheet->writeString(4, 0, "-", $center);
            $sheet->writeString(4, 1, "-", $content);
            $sheet->writeString(4, 2, "-", $center);
            $sheet->writeString(4, 3, "-", $center);
            $sheet->writeString(4, 4, "-", $content);
            $sheet->writeString(4, 5, "-", $content);
            $sheet->writeString(4, 6, "-", $content);
        }
        $this->writer->close();
	}
    
    function calon()
    {
		$this->load->model('calon_model');
        
        $company = $this->sim_model->data();
        $data = $this->calon_model->printlist();
        
        $this->writer->send("laporan-calon-karyawan.xls");
        $format1 = $this->writer->addFormat();
        $format1->setBold();
        $format1->setSize(12);
        $format2 = $this->writer->addFormat();
        $format2->setBold();
        $format2->setSize(10);
        $format2->setAlign('right');
        $format3 = $this->writer->addFormat();
        $format3->setBold();
        $column = $this->writer->addFormat();
        $column->setBold();
        $column->setTop(1);
        $column->setLeft(1);
        $column->setRight(1);
        $column->setBottom(1);
        $column->setFgColor('#cccccc');
        $column->setAlign('center');
        $content = $this->writer->addFormat();
        $content->setLeft(1);
        $content->setRight(1);
        $content->setBottom(1);
        $center = $this->writer->addFormat();
        $center->setLeft(1);
        $center->setRight(1);
        $center->setBottom(1);
        $center->setAlign('center');
        $sheet = $this->writer->addWorksheet('Calon Karyawan');
        
        //setMerge($first_row, $first_col, $last_row, $last_col)
        $sheet->setMerge(0, 0, 0, 6);
        $sheet->setMerge(1, 0, 1, 2);
        $sheet->setMerge(1, 3, 1, 6);
        $sheet->setMerge(3, 0, 3, 1);
        
        //setColumn($firstcol, $lastcol, $width, $format = 0, $hidden = 0, $level = 0)
        $sheet->setColumn(0, 0, 4, 0, 0, 0);
        $sheet->setColumn(1, 1, 30, 0, 0, 0);
        $sheet->setColumn(2, 2, 15, 0, 0, 0);
        $sheet->setColumn(3, 3, 5, 0, 0, 0);
        $sheet->setColumn(4, 4, 60, 0, 0, 0);
        $sheet->setColumn(5, 5, 15, 0, 0, 0);
        $sheet->setColumn(6, 6, 15, 0, 0, 0);
        
        $sheet->writeString(0, 0, ($company->nama != '-' ? $company->nama : $this->config->item('site_name').' '.$this->config->item('version')), $format1);
        $sheet->writeString(1, 0, ($company->alamat != '-' ? $company->alamat.' '.$company->kota.' '.$company->kodepos : $this->config->item('site_admin')), 0);
        $sheet->writeString(1, 3, "Laporan Calon Karyawan", $format2);
        $sheet->writeString(4, 0, "No", $column);
        $sheet->writeString(4, 1, "Nama", $column);
        $sheet->writeString(4, 2, "Tgl.Lahir", $column);
        $sheet->writeString(4, 3, "JK", $column);
        $sheet->writeString(4, 4, "Alamat", $column);
        $sheet->writeString(4, 5, "Telepon", $column);	
        $sheet->writeString(4, 6, "Selular", $column);	
        
        if ($data != false)
        {
            $filterdata = array();
            $filterdata[] = 'p.kode = c.kode';
            $filterdata[] = 'p.kode = b.kode';
            if ($this->session->userdata('SESS_DATE1') != '' && $this->session->userdata('SESS_DATE2') != '')
                $filterdata[] = 'c.tanggal >= \''.$this->session->userdata('SESS_DATE1').'\' AND c.tanggal <= \''.$this->session->userdata('SESS_DATE2').'%\')';
            if ($this->session->userdata('SESS_POSITION'))
                $filterdata[] = 'b.posisi LIKE \'%'.$this->session->userdata('SESS_POSITION').'%\'';
            $where = (count($filterdata) > 0 ? 'WHERE '.implode(' AND ', $filterdata) : null);
            
            $query = $this->db->query('SELECT * FROM pelamar p, calon c, berkas b '.$where);
            $total = $query->num_rows();
            $sheet->writeString(3, 0, "TotalData: ".$total, $format3);
            
            $r = 4;
            $n = 1;
            foreach ( $data as $row ) 
            {
                $r++;
                $sheet->writeString($r, 0, $n++, $center);
                $sheet->writeString($r, 1, $row->nama, $content);
                $sheet->writeString($r, 2, $row->tglahir, $center);
                $sheet->writeString($r, 3, $row->kelamin, $center);
                $sheet->writeString($r, 4, $row->alamat, $content);
                $sheet->writeString($r, 5, $row->telepon, $content);
                $sheet->writeString($r, 6, $row->selular, $content);
            }
        }
        else
        {
            $sheet->writeString(3, 0, "TotalData: 0", $format3);
            $sheet->writeString(4, 0, "-", $center);
            $sheet->writeString(4, 1, "-", $content);
            $sheet->writeString(4, 2, "-", $center);
            $sheet->writeString(4, 3, "-", $center);
            $sheet->writeString(4, 4, "-", $content);
            $sheet->writeString(4, 5, "-", $content);
            $sheet->writeString(4, 6, "-", $content);
        }
        $this->writer->close();
	}
}
?>