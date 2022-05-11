<?php
    $this->fpdf->AddPage('L', 'A4');
    $this->fpdf->Image('logo.jpg', 10, 10);
	$this->fpdf->SetFont('Times', '',12);
    $qprov = $this->db->query("SELECT nama FROM wilayah WHERE propinsi = '".$company->propinsi."' AND kabupatenkota = '00' AND kecamatan = '00' AND kelurahan = '0000'"); 
    $rprov = $qprov->row(); 
    $namaprov = ($rprov->nama != null ? 'PEMERINTAH PROVINSI '.strtoupper($rprov->nama) : $this->config->item('site_name'));
    $this->fpdf->Text(27, 15, $namaprov);
    $this->fpdf->SetFont('Times', 'B',14);
    $qsatker = $this->db->query("SELECT nama FROM satker WHERE id = '".$headers->satker."'"); 
    $rsatker = $qsatker->row(); 
    $namasatker = ($namasatker != null ? strtoupper($namasatker) : $this->config->item('site_longname'));
    $this->fpdf->Text(27, 18, $namasatker);
	$this->fpdf->SetFont('Times','B',8);
	$this->fpdf->Text(27, 19, ($headers->alamat != '-' ? $headers->alamat : $this->config->item('site_longname')));
    $this->fpdf->Text(27, 23, ($headers->telepon != '-' && $headers->fax != '-' ? 'Tlp. '.$headers->telepon.' Fax. '.$headers->fax : $this->config->item('site_admin')));
	$this->fpdf->SetFont('Arial','',10);
	$this->fpdf->Text(257, 30, $caption);
	$this->fpdf->SetLineWidth(0.4);
	$this->fpdf->Line(10, 32, 286, 32);
		
	/*Colors, line width and bold font*/
	$this->fpdf->SetTextColor(0);
	$this->fpdf->SetDrawColor(61);
	$this->fpdf->SetLineWidth(.3);
	$this->fpdf->SetY(35);
	
    /*Header*/
    $this->fpdf->SetFillColor(129);
	$this->fpdf->SetFont('Arial','',7);
	$this->fpdf->Cell(8, 15, 'No', 1, 0, 'C', true);
	$this->fpdf->Cell(18, 15, 'Unit Kerja', 1, 0, 'C', true);
    $x = $this->fpdf->GetX();
    $y = $this->fpdf->GetY();
    $this->fpdf->MultiCell(38, 7.5, "Nama Lengkap \n NIP/Tempat/Tgl. Lahir", 1, 'C', true);
    $this->fpdf->SetXY($x + 38, $y);
    $this->fpdf->Cell(36, 5, 'Pangkat/Gol.Ruang', 1, 0, 'C', true);
    $this->fpdf->Cell(18, 15, 'Jabatan', 1, 0, 'C', true);
    $this->fpdf->Cell(108, 5, 'Pendidikan Umum dan Diklat Jabatan Terakhir', 1, 0, 'C', true);
    $x = $this->fpdf->GetX();
    $this->fpdf->MultiCell(15, 7.5, "Masa\nKerja", 1, 'C', true);
    $this->fpdf->SetXY($x + 15, $y);
    $x = $this->fpdf->GetX();
    $this->fpdf->MultiCell(15, 7.5, "Jenis\nKelamin", 1, 'C', true);
    $this->fpdf->SetXY($x + 15, $y);
    $x = $this->fpdf->GetX();
	$this->fpdf->MultiCell(20, 7.5, "Nama\nJabatan", 1, 'C', true);
    $this->fpdf->SetXY($x + 20, $y);
    $this->fpdf->Ln(5);
    $this->fpdf->Cell(8, 5, '', 0, 0, 'C', false);
	$this->fpdf->Cell(18, 5, '', 0, 0, 'C', false);
	$this->fpdf->Cell(38, 5, '', 0, 0, 'C', false);
    $x = $this->fpdf->GetX();
    $y = $this->fpdf->GetY();
    $this->fpdf->MultiCell(18, 5, "CPNS\nT.M.T", 1, 'C', true);
    $this->fpdf->SetXY($x + 18, $y);
    $x = $this->fpdf->GetX();
    $this->fpdf->MultiCell(18, 5, "PNS\nT.M.T", 1, 'C', true);
    $this->fpdf->SetXY($x + 18, $y);
    $this->fpdf->Cell(18, 5, '', 0, 0, 'C', false);    
    $this->fpdf->Cell(36, 5, 'Pend.Umum', 1, 0, 'C', true);
    $this->fpdf->Cell(36, 5, 'Struktural', 1, 0, 'C', true);
    $this->fpdf->Cell(18, 5, 'Fungsional', 1, 0, 'C', true);
    $this->fpdf->Cell(18, 5, 'Teknis', 1, 0, 'C', true);
    $this->fpdf->Cell(15, 5, '', 0, 0, 'C', false);
    $this->fpdf->Cell(15, 5, '', 0, 0, 'C', false);
	$this->fpdf->Cell(20, 5, '', 0, 1, 'C', false);
    $this->fpdf->Cell(8, 5, '', 0, 0, 'C', false);
	$this->fpdf->Cell(18, 5, '', 0, 0, 'C', false);
	$this->fpdf->Cell(38, 5, '', 0, 0, 'C', false);
	$this->fpdf->Cell(18, 5, '', 0, 0, 'C', false);
    $this->fpdf->Cell(18, 5, '', 0, 0, 'C', false);
    $this->fpdf->Cell(18, 5, '', 0, 0, 'C', false);
    $this->fpdf->Cell(18, 5, 'Tingkat', 1, 0, 'C', true);
    $this->fpdf->Cell(18, 5, 'Jurusan', 1, 0, 'C', true);
    $this->fpdf->Cell(18, 5, 'Nama', 1, 0, 'C', true);
    $this->fpdf->Cell(18, 5, 'Lulus', 1, 0, 'C', true);
    $this->fpdf->Cell(18, 5, 'Tanggal', 1, 0, 'C', true);
    $this->fpdf->Cell(18, 5, 'Tanggal', 1, 0, 'C', true);
    $this->fpdf->Cell(15, 5, '', 0, 0, 'C', false);
    $this->fpdf->Cell(15, 5, '', 0, 0, 'C', false);
	$this->fpdf->Cell(20, 5, '', 0, 1, 'C', false);
    $this->fpdf->Cell(8, 5, '1', 1, 0, 'C', true);
	$this->fpdf->Cell(18, 5, '2', 1, 0, 'C', true);
	$this->fpdf->Cell(38, 5, '3', 1, 0, 'C', true);
	$this->fpdf->Cell(18, 5, '4', 1, 0, 'C', true);
    $this->fpdf->Cell(18, 5, '5', 1, 0, 'C', true);
    $this->fpdf->Cell(18, 5, '6', 1, 0, 'C', true);
    $this->fpdf->Cell(18, 5, '7', 1, 0, 'C', true);
    $this->fpdf->Cell(18, 5, '8', 1, 0, 'C', true);
    $this->fpdf->Cell(18, 5, '9', 1, 0, 'C', true);
    $this->fpdf->Cell(18, 5, '10', 1, 0, 'C', true);
    $this->fpdf->Cell(18, 5, '11', 1, 0, 'C', true);
    $this->fpdf->Cell(18, 5, '12', 1, 0, 'C', true);
    $this->fpdf->Cell(15, 5, '13', 1, 0, 'C', true);
    $this->fpdf->Cell(15, 5, '14', 1, 0, 'C', true);
	$this->fpdf->Cell(20, 5, '15', 1, 1, 'C', true);
    
    /*Color and font restoration*/
	$this->fpdf->SetFillColor(224,235,255);
	$this->fpdf->SetTextColor(0);
	$this->fpdf->SetFont('Arial', '', 7);
		
	/*Show Data*/
	$this->fpdf->SetWidths(array(8, 18, 38, 18, 18, 18, 18, 18, 18, 18, 18, 18, 15, 15, 20));
	$this->fpdf->SetAligns(array('C', 'L', 'L', 'C', 'C', 'L', 'C', 'C', 'L', 'C', 'C', 'C', 'C', 'C', 'L'));
	$no = 1;
    $fill = 'D';
	foreach ($datas as $baris) 
    {
		if ($no % 8 == 0)
        {
            $this->fpdf->AddPage('L', 'A4');
            //$logo = ($headers->logo != '-' ? 'images/'.$headers->logo : $this->config->item('site_laporan_logo'));
            //$this->fpdf->Image($logo, 10, 10, 15, 20);
            $this->fpdf->SetFont('Times','B',12);
            $qnama = $this->db->query("SELECT nama FROM satker WHERE id = '".$headers->satker."'"); $rnama = $qnama->row(); $namacom = ($qnama->num_rows > 0 ? strtoupper($rnama->nama) : null);
            $qpro = $this->db->query("SELECT propinsi as kode, nama FROM wilayah WHERE id = '".$headers->propinsi."'"); $rpro = $qpro->row(); $namapro = ($qpro->num_rows() > 0 ? 'PROVINSI '.strtoupper($rpro->nama) : null);
            $this->fpdf->Text(27, 15, ($namacom != null ? $namacom.' '.$namapro : $this->config->item('site_author')));
            $this->fpdf->SetFont('Times','B',8);
            $this->fpdf->Text(27, 19, ($headers->alamat != '-' ? $headers->alamat : $this->config->item('site_longname')));
            $this->fpdf->Text(27, 23, ($headers->telepon != '-' && $headers->fax != '-' ? 'Tlp. '.$headers->telepon.' Fax. '.$headers->fax : $this->config->item('site_admin')));
            $this->fpdf->SetFont('Arial','',10);
            $this->fpdf->Text(257, 30, $caption);
            $this->fpdf->SetLineWidth(0.4);
            $this->fpdf->Line(10, 32, 286, 32);
            $this->fpdf->SetTextColor(0);
	
            $this->fpdf->SetDrawColor(61);
            $this->fpdf->SetLineWidth(.3);
            $this->fpdf->SetY(35);
    
            $this->fpdf->SetFillColor(129);
            $this->fpdf->SetFont('Arial','',7);
            $this->fpdf->Cell(8, 15, 'No', 1, 0, 'C', true);
            $this->fpdf->Cell(18, 15, 'Unit Kerja', 1, 0, 'C', true);
            $x = $this->fpdf->GetX();
            $y = $this->fpdf->GetY();
            $this->fpdf->MultiCell(38, 7.5, "Nama Lengkap \n NIP/Tempat/Tgl. Lahir", 1, 'C', true);
            $this->fpdf->SetXY($x + 38, $y);
            $this->fpdf->Cell(36, 5, 'Pangkat/Gol.Ruang', 1, 0, 'C', true);
            $this->fpdf->Cell(18, 15, 'Jabatan', 1, 0, 'C', true);
            $this->fpdf->Cell(108, 5, 'Pendidikan Umum dan Diklat Jabatan Terakhir', 1, 0, 'C', true);
            $x = $this->fpdf->GetX();
            $this->fpdf->MultiCell(15, 7.5, "Masa\nKerja", 1, 'C', true);
            $this->fpdf->SetXY($x + 15, $y);
            $x = $this->fpdf->GetX();
            $this->fpdf->MultiCell(15, 7.5, "Jenis\nKelamin", 1, 'C', true);
            $this->fpdf->SetXY($x + 15, $y);
            $x = $this->fpdf->GetX();
            $this->fpdf->MultiCell(20, 7.5, "Nama\nJabatan", 1, 'C', true);
            $this->fpdf->SetXY($x + 20, $y);
            $this->fpdf->Ln(5);
            $this->fpdf->Cell(8, 5, '', 0, 0, 'C', false);
            $this->fpdf->Cell(18, 5, '', 0, 0, 'C', false);
            $this->fpdf->Cell(38, 5, '', 0, 0, 'C', false);
            $x = $this->fpdf->GetX();
            $y = $this->fpdf->GetY();
            $this->fpdf->MultiCell(18, 5, "CPNS\nT.M.T", 1, 'C', true);
            $this->fpdf->SetXY($x + 18, $y);
            $x = $this->fpdf->GetX();
            $this->fpdf->MultiCell(18, 5, "PNS\nT.M.T", 1, 'C', true);
            $this->fpdf->SetXY($x + 18, $y);
            $this->fpdf->Cell(18, 5, '', 0, 0, 'C', false);    
            $this->fpdf->Cell(36, 5, 'Pend.Umum', 1, 0, 'C', true);
            $this->fpdf->Cell(36, 5, 'Struktural', 1, 0, 'C', true);
            $this->fpdf->Cell(18, 5, 'Fungsional', 1, 0, 'C', true);
            $this->fpdf->Cell(18, 5, 'Teknis', 1, 0, 'C', true);
            $this->fpdf->Cell(15, 5, '', 0, 0, 'C', false);
            $this->fpdf->Cell(15, 5, '', 0, 0, 'C', false);
            $this->fpdf->Cell(20, 5, '', 0, 1, 'C', false);
            $this->fpdf->Cell(8, 5, '', 0, 0, 'C', false);
            $this->fpdf->Cell(18, 5, '', 0, 0, 'C', false);
            $this->fpdf->Cell(38, 5, '', 0, 0, 'C', false);
            $this->fpdf->Cell(18, 5, '', 0, 0, 'C', false);
            $this->fpdf->Cell(18, 5, '', 0, 0, 'C', false);
            $this->fpdf->Cell(18, 5, '', 0, 0, 'C', false);
            $this->fpdf->Cell(18, 5, 'Tingkat', 1, 0, 'C', true);
            $this->fpdf->Cell(18, 5, 'Jurusan', 1, 0, 'C', true);
            $this->fpdf->Cell(18, 5, 'Nama', 1, 0, 'C', true);
            $this->fpdf->Cell(18, 5, 'Lulus', 1, 0, 'C', true);
            $this->fpdf->Cell(18, 5, 'Tanggal', 1, 0, 'C', true);
            $this->fpdf->Cell(18, 5, 'Tanggal', 1, 0, 'C', true);
            $this->fpdf->Cell(15, 5, '', 0, 0, 'C', false);
            $this->fpdf->Cell(15, 5, '', 0, 0, 'C', false);
            $this->fpdf->Cell(20, 5, '', 0, 1, 'C', false);
            $this->fpdf->Cell(8, 5, '1', 1, 0, 'C', true);
            $this->fpdf->Cell(18, 5, '2', 1, 0, 'C', true);
            $this->fpdf->Cell(38, 5, '3', 1, 0, 'C', true);
            $this->fpdf->Cell(18, 5, '4', 1, 0, 'C', true);
            $this->fpdf->Cell(18, 5, '5', 1, 0, 'C', true);
            $this->fpdf->Cell(18, 5, '6', 1, 0, 'C', true);
            $this->fpdf->Cell(18, 5, '7', 1, 0, 'C', true);
            $this->fpdf->Cell(18, 5, '8', 1, 0, 'C', true);
            $this->fpdf->Cell(18, 5, '9', 1, 0, 'C', true);
            $this->fpdf->Cell(18, 5, '10', 1, 0, 'C', true);
            $this->fpdf->Cell(18, 5, '11', 1, 0, 'C', true);
            $this->fpdf->Cell(18, 5, '12', 1, 0, 'C', true);
            $this->fpdf->Cell(15, 5, '13', 1, 0, 'C', true);
            $this->fpdf->Cell(15, 5, '14', 1, 0, 'C', true);
            $this->fpdf->Cell(20, 5, '15', 1, 1, 'C', true);
            $this->fpdf->SetFillColor(224,235,255);
        }
        $this->fpdf->Row(
			array($no++, 
			($baris->unitkerja != "-" ? $baris->unitkerja : "--"), 
			($baris->gelar1 != "-" ? $baris->gelar1." " : null).($baris->nama != "-" ? $baris->nama : null).($baris->gelar2 != "-" ? ", ".$baris->gelar2 : "--")."\n".
            ($baris->nip1 != "-" ? "NIP: ".$baris->nip1."\n" : null).
			($baris->tglahir != "00/00/0000" ? "TTL: ".$baris->kotalahir.", ".$baris->tglahir : null), 
			($baris->golcpns != "" && $baris->ruangcpns != "" ? $baris->golcpns."/".$baris->ruangcpns."\n".$baris->tmtcpns : "--"), 
			($baris->golpns != "" && $baris->ruangpns != "" ? $baris->golpns."/".$baris->ruangpns."\n".$baris->tmtpns : "--"), 
			($baris->jabatan != "-" ? $baris->jabatan : "--"),
            ($baris->tingkat != "-" ? $baris->tingkat : "--"),
            ($baris->jurusan != "-" ? $baris->jurusan : "--"),
            ($baris->sekolah != "-" ? $baris->sekolah : "--"),
            ($baris->lulus != "-" ? $baris->lulus : "--"),
            ($baris->tglmulai1 != "" ? $baris->tglmulai1 : "--")."\ns/d\n".($baris->tglselesai1 != "" ? $baris->tglselesai1 : "--"),
            ($baris->tglmulai2 != "" ? $baris->tglmulai2 : "--")."\ns/d\n".($baris->tglselesai2 != "" ? $baris->tglselesai2 : "--"),
            ($baris->masa > 0 ? floor($baris->masa/12)." (Thn)\n".($baris->masa-(floor($baris->masa/12)*12))." (Bln)" : "0 (Thn)<br>0 (Bln)"),
            ($baris->jeniskelamin != "-" ? $baris->jeniskelamin : "--"),
            ($baris->eselon != "-" ? $baris->eselon : "--")), $fill
        );
        $fill = ($fill == 'D' ? 'FD' : 'D');
        if ($no % 7 == 0)
            $this->fpdf->footerLandscape($this->session->userdata('SESS_USER_ID'));
	}
    
    $this->fpdf->footerLandscape($this->session->userdata('SESS_USER_ID'));
	$this->fpdf->Output('laporan-pegawai-tetap.pdf', 'I');
?>