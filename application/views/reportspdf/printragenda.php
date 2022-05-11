<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<h4 class="caption"><?php echo $mainpage.' '.$caption;?></h4>

	<div class="box-body">
		<h6>Tanggal Periode: <?php echo date("d/m/Y", strtotime( $this->session->userdata('SES_REP_DATE1') ))." - ".date("d/m/Y", strtotime( $this->session->userdata('SES_REP_DATE2') ));?></h6>
		<table>
			<thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="10%">Tanggal</th>
                    <th width="8%">Waktu</th>
                    <th>Acara</th>
                    <th class="borderight" width="8%">Status</th>
                </tr>
			</thead>
			<tbody>
				<?php if($datas): $i = 1;?>
					<?php foreach ($datas as $row):?>
						<tr>
							<td class="txtcenter <?php echo ($i == count($datas) ? 'borderbottom' : '');?>"><?php echo $i;?></td>
                            <td class="txtcenter <?php echo ($i == count($datas) ? 'borderbottom' : '');?>"><?php echo $row->tanggal;?></td>
                            <td class="txtcenter <?php echo ($i == count($datas) ? 'borderbottom' : '');?>"><?php echo $row->waktu;?></td>
							<td class="<?php echo ($i == count($datas) ? 'borderbottom' : '');?>"><?php echo $row->kegiatan;?></td>
							<td class="txtcenter borderight <?php echo ($i == count($datas) ? 'borderbottom' : '');?>"><?php echo $row->status;?></td>
						</tr>
					<?php $i++; endforeach;?>
				<?php else:?>
				    <tr>
						<td class="borderbottom">&nbsp;</td>
						<td class="borderbottom">&nbsp;</td>
                        <td class="borderbottom">&nbsp;</td>
                        <td class="borderbottom">&nbsp;</td>
						<td class="borderight">&nbsp;</td>
					</tr>
				<?php endif;?>
			</tbody>
		</table>
	</div>