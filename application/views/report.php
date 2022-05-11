<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php echo strip_tags($this->config->item('site_name').' '.$this->config->item('site_version').' - '.$this->config->item('site_longname'));?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<meta http-equiv="imagetoolbar" content="no"/>

	<!-- favicon -->
	<link rel="Shortcut Icon" href="<?php echo (getCompany()->logo != '-' ? base_url().'arsip/'.getCompany()->logo : $this->config->item('site_icon'));?>" />
	<!-- Reset all CSS rule -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/reset.css" />
			
	<!-- Main stylesheed  (EDIT THIS ONE) -->
	<link rel="stylesheet" href="<?php echo base_url();?>css/report.css" type="text/css" />
			
	<!-- jQuery AND jQueryUI -->
	<script type="text/javascript" src="<?php echo base_url();?>js/jquery.min.js"></script>
	<?php $margins = explode('|', getCompany()->margin);?>
	<style>
		body {
            margin-top: <?php echo $margins[0].'cm';?>;
            margin-bottom: <?php echo $margins[1].'cm';?>;
            margin-left: <?php echo $margins[2].'cm';?>;
            margin-right: <?php echo $margins[3].'cm';?>;
        }
	</style>
</head>	
<body>
	<?php $this->load->view($content); ?>
</body>
</html>