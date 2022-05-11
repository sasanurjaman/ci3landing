<?php 
    function getAccess($u = 'null', $c = '*', $p = 'read')
	{
		$ci = & get_instance();
        $ci->db->select('user.'.$c.' AS col');
        $ci->db->where('userid', $u);
        $query = $ci->db->get('user');
        
        if ($query->num_rows() > 0) 
        {
			$acc = explode('|', $query->row()->col);
			switch ($p) {
				case 'new':
					return $acc[1];
					break;
				case 'edit':
					return $acc[2];
					break;
				case 'delete':
					return $acc[3];
					break;
				case 'print':
					return $acc[4];
					break;
				default:
				   return $acc[0];
			}
		} 
		else 
		{
			return false;
		}
	}
	
	function getCompany()
	{
		$ci = & get_instance();
        $ci->db->select('logo, logolap, nama, alias, moto, bagian, alamat, kota, kodepos, telepon, fax, email, format, ukuran, autorefresh, bataswaktu, kertas, orentasi, margin');
		return $ci->db->get('perusahaan')->row();        
	}
    
    function searchArrayKeyVal($sKey, $id, $array)
    {
        foreach ($array AS $key => $val) {
            if ($val[$sKey] == $id)
                return $key;
        }
        return false;
    }
    
    function getFormlogo($col)
    {
        $ci = & get_instance();
        $menus = $ci->config->item('menu_sidebar');
        $k1 = searchArrayKeyVal('column', $col[0].'0', $menus);
        $k2 = searchArrayKeyVal('subcol', $col, $menus[$k1]['submenu']);
        
        return $menus[$k1]['submenu'][$k2]['sublogo'];
    }
    
    function getFormlogo_level1($col)
    {
        $ci = & get_instance();
        $menus = $ci->config->item('menu_sidebar');
        $k1 = searchArrayKeyVal('column', $col[0].'0', $menus);
        $k2 = searchArrayKeyVal('subcol', $col[0].'0', $menus[$k1]['submenu']);
        $k3 = searchArrayKeyVal('subcols', $col, $menus[$k1]['submenu'][$k2]['submenus']);
        
        return $menus[$k1]['submenu'][$k2]['submenus'][$k3]['sublogos'];
    }
    
    function getData($column, $table, $filter)
    {
        $ci = & get_instance();
        $ci->db->select($column.' AS data');
        $ci->db->where($filter);
        $query = $ci->db->get($table);
        
        return ($query->num_rows() > 0 ? $query->row()->data : null);
    }
    
    function terbilang($x)
	{
		$abil = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
		if ($x < 12)
		return " " . $abil[$x];
		elseif ($x < 20)
		return terbilang($x - 10) . "Belas";
		elseif ($x < 100)
		return terbilang($x / 10) . " Puluh" . terbilang($x % 10);
		elseif ($x < 200)
		return " seratus" . terbilang($x - 100);
		elseif ($x < 1000)
		return terbilang($x / 100) . " Ratus" . terbilang($x % 100);
		elseif ($x < 2000)
		return " seribu" . terbilang($x - 1000);
		elseif ($x < 1000000)
		return terbilang($x / 1000) . " Ribu" . terbilang($x % 1000);
		elseif ($x < 1000000000)
		return terbilang($x / 1000000) . " Juta" . terbilang($x % 1000000);
        elseif ($x < 1000000000000)
		return terbilang($x / 1000000000) . " Milyar" . terbilang($x % 1000000000);
    }
    
    function is_upper($str)
    {
        return($str === strtoupper($str) ? true : false);
    }
    
    function get_day($id)
    {
        $days = array(
            '1' => 'Senin',
            '2' => 'Selasa',
            '3' => 'Rabu',
            '4' => 'Kamis',
            '5' => 'Jumat',
            '6' => 'Sabtu',
            '7' => 'Minggu'
        );

        return $days[$id];
    }

    function leading_zero($n, $inc = false, $reset = false)
	{
		$s = strlen($n);
		$a = ($inc == true) ? (int)$n+1 : (int)$n;
		$a = ($reset == true) ? 1 : $a;
		$sa = strlen($a);
		$zero = '';

		for ($i = 0; $i < ($s - $sa); $i++)
		{
			$zero .= '0';
		}
		return $zero.$a;
	}
    
    function format_code($code) 
    {
		$angka = null;
        $huruf = null;
        
        for ($n = 0; $n < strlen($code); $n++)
        {
            if (preg_match('/^[0-9]+$/', substr($code, $n, 1))) 
            {
                $angka = $angka.substr($code, $n, 1);
            } 
            else 
            {
                if ($angka != null)
                {
                    $huruf = $huruf.$angka.substr($code, $n, 1);
                    $angka = null;
                }
                else
                {
                    $huruf = $huruf.substr($code, $n, 1);
                }
            }
        }
        
        return $huruf.sprintf("%0".strlen($angka)."d", $angka+1);
	}
    
    function month2rome($m = null)
	{
		$romes = array (
            '01' => 'I',
			'02' => 'II',
			'03' => 'III',
			'04' => 'IV',
			'05' => 'V',
			'06' => 'VI',
			'07' => 'VII',
			'08' => 'VIII',
			'09' => 'IX',
			'10' => 'X',
			'11' => 'XI',
			'12' => 'XII'
        );
            
        $month = ($m != null ? $m : date('m'));    
		return $romes[$month];
	}
    
	function month2ina($m = null) 
	{
		$months = array (
			"January"    => "Januari",
			"February"   => "Februari",
			"March"      => "Maret",
			"April"      => "April",
			"May"        => "Mei",
			"June"       => "Juni",
			"July"       => "Juli", 
			"August"     => "Agustus",
			"September"  => "September",
			"October"    => "Oktober", 
			"November"   => "November",
			"December"   => "Desember"
        );
        
        $month = ($m != null ? $m : date('F'));  
		return $months[$month];
	}
	
	function day2ina($d = null) 
	{
		$days = array (
			"Sunday"    => "Minggu",
			"Monday"    => "Senin",
			"Tuesday"   => "Selasa",
			"Wednesday" => "Rabu",
			"Thursday"  => "Kamis",
			"Friday"    => "Jumat",
			"Saturday"  => "Sabtu"
        );
		
        $day = ($d != null ? $d : date('l'));  
        return $days[$day];
	}
    
    function getColors($s) 
    {
        $colors = array(
            'fa-sign-in' => 'bg-green',
            'fa-user-times' => 'bg-yellow',
            'fa-sign-out' => 'bg-red',
            'fa-ban' => 'bg-red',
            'fa-folder-open-o' => 'bg-blue',
            'fa fa-list-alt' => 'bg-blue',
            'fa-plus' => 'bg-aqua',
            'fa-edit' => 'bg-purple',
            'fa-check-square-o' => 'bg-purple',
            'fa-save' => 'bg-green',
            'fa-trash-o' => 'bg-red',
            'fa-sticky-note-o' => 'bg-yellow',
            'fa-print' => 'bg-gray',
            'fa-check-square-o' => 'bg-green',
            'fa-eye' => 'bg-purple',
            'fa-undo' => 'bg-yellow',
            'fa-send' => 'bg-red',
            'fa-upload' => 'bg-yellow'
        );
        
        return $colors[$s];
    }
    
    function array_sort($array, $on, $order=SORT_ASC, $type=SORT_NUMERIC)
    {
            $new_array = array();
            $sortable_array = array();
         
            if (count($array) > 0) 
            {
                foreach ($array as $k => $v) 
                {
                    if (is_array($v)) {
                        foreach ($v as $k2 => $v2) {
                            if ($k2 == $on) {
                                $sortable_array[$k] = $v2;
                            }
                        }
                    } else {
                        $sortable_array[$k] = $v;
                    }
                }
                
                switch ($order) {
                    case SORT_ASC:
                        asort($sortable_array, $type);
                        break;
                    case SORT_DESC:
                        arsort($sortable_array, $type);
                        break;
                }
             
                foreach ($sortable_array as $k => $v) {
                    $new_array[] = $array[$k];
                }
            }   
             
            return $new_array;
    }
    
    function getBetween($content,$start,$end)
    {
        $r = explode($start, $content);
        if (isset($r[1])){
            $r = explode($end, $r[1]);
            return $r[0];
        }
        return '';
    }
    
    function user_log($log = null, $simbol = null)
	{
		$ci = & get_instance();
        $ci->db->select_max('id');
        $query = $ci->db->get('aktifitas');
        $id = ($query->num_rows() > 0 ? $query->row()->id + 1 : 1);
        
		$insert = array(
            'id' => $id,
            'waktu' => date("Y-m-d H:i:s"),
            'alamat' => $_SERVER['REMOTE_ADDR'],
            'pengguna' => ($ci->session->userdata('SESS_USER_ID')!=''?$ci->session->userdata('SESS_USER_ID'):getBetween($log, '`', '`')),
            'simbol' => ($simbol != null ? $simbol : 'fa-sticky-note-o'),
            'keterangan' => $log
        );	
        $ci->db->insert('aktifitas', $insert);
	}