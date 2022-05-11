<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<script type="text/javascript">
    $(document).ready(function(){        
		window.print();		
    });
</script>
<div id="content-box">

	<div id="box-header" class="clear">
		<div class="left">
			<img src="<?php echo ($company->logo != '-' ? base_url().'images/'.$company->logo : $this->config->item('site_logo'));?>">
			<h4><?php echo ($company->nama != '-' ? $company->nama : $this->config->item('site_name').' '.$this->config->item('site_version'));?></h4>
            <h5><?php echo ($company->moto != '-' ? $company->moto : $this->config->item('site_longname'));?></h5>
			<h6 style="margin-top:15px;"><?php echo ($company->alamat != '-' ? $company->alamat.' '.$company->kota.' '.$company->kodepos : 'Web. '.$this->config->item('site_admin'));?></h6>
			<h6><?php echo ($company->telepon != '-' ? 'Tlp. '.$company->telepon.($company->fax != '-' ? ' Fax. '.$company->fax : null) : 'Email. '.$this->config->item('site_email'));?></h6>		
		</div>
		<div class="center">
			<!-- <h4><?php echo $caption;?></h4> -->
		</div>
		<div class="right">
			<h3 class="title"><?php echo "LAPORAN ".$caption;?></h3>
		</div>
	</div> <!-- end id box-header -->

	<div id="box-body" class="clear">
		<h6>Tanggal Periode: <?php echo date("d/m/Y", strtotime( $this->session->userdata('SES_REP_DATE1') ))." - ".date("d/m/Y", strtotime( $this->session->userdata('SES_REP_DATE2') ));?></h6>
		<table>
			<thead>
				<tr>
                    <th width="5%">No</th>
                    <th width="10%">Tanggal</th>
                    <th>Judul</th>
                    <th width="10%">Akhir</th>
                    <th width="8%">Status</th>
                </tr>
			</thead>
			<tbody>
				<?php if($datas): $i = 1;?>
					<?php foreach ($datas as $row):?>
						<tr>
							<td class="center"><?php echo $i;?></td>
							<td class="center"><?php echo $row->tanggal;?></td>
							<td><?php echo $row->judul;?></td>
							<td class="center"><?php echo $row->akhir;?></td>
							<td class="center end"><?php echo $row->status;?></td>
						</tr>
					<?php $i++; endforeach;?>
				<?php else:?>
				    <tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td class="end">&nbsp;</td>
					</tr>
				<?php endif;?>
			</tbody>
		</table>
	</div> <!-- end id box-body -->
    <div id="box-footer">
        <h6><?="Printed By: ".$this->session->userdata('SESS_USER_ID')." ".date("d/m/Y h:i:s");?></h6>
    </div> <!-- end id footer -->
</div> <!-- end id content-box -->