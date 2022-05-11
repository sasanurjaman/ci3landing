<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<input type="hidden" name="search" value="<?php echo $search;?>">
<input type="hidden" name="page" value="<?php echo $page;?>">
<span id="paging" style="display:none"><?php echo $paging;?></span>
                            <?php if(isset($datas) and $datas != false): $i = 1;?>
                                <?php foreach ($datas as $row):?>
                                    <tr>
                                        <td class="center"><?php echo $page+$i;?></td>
                                        <td><?php echo ($row->nama != '-' ? $row->nama : null)?></td>
                                        <td><?php echo ($row->jabatan != '-' ? $row->jabatan : null);?></td>                                        
                                        <td class="center">
                                            <div class="btn-group">
                                                <?php if ($row->status == "Y"):?>
                                                    <a class="btn btn-success btn-sm" href="<?php echo base_url()."index.php/transactions/activeabsensi/".$search."/".$page."/".$row->id; ?>" title="Aktif Data"><i class="fa fa-check"></i></a>
                                                <?php else:?>
                                                    <a class="btn btn-danger btn-sm" href="<?php echo base_url()."index.php/transactions/activeabsensi/".$search."/".$page."/".$row->id; ?>" title="Aktif Data"><i class="fa fa-close"></i></a>
                                                <?php endif;?>
                                            </div>
                                        </td>
                                        <td class="center">
                                            <div class="btn-group">
                                                <?php if ($this->sim_model->access($this->session->userdata('SESS_USER_ID'), 'T4', 'edit') == 'Y'):?>
                                                    <a class="btn btn-info btn-sm" href="<?php echo base_url()."index.php/transactions/editabsensi/".$search."/".$page."/".$row->id;?>" title="Ubah Data"><i class="fa fa-edit"></i></a>
                                                <?php else:?>
                                                    <a class="btn btn-info btn-sm disabled" href="#" title="Ubah Data"><i class="fa fa-edit"></i></a>
                                                <?php endif;?>
                                                <?php if ($this->sim_model->access($this->session->userdata('SESS_USER_ID'), 'T4', 'delete') == 'Y'):?>
                                                    <a class="btn btn-danger btn-sm" href="<?php echo base_url()."index.php/transactions/delabsensi/".$search."/".$page."/".$row->id;?>" title="Hapus Data"><i class="fa fa-trash-o"></i></a>
                                                <?php else:?>    
                                                    <a class="btn btn-danger btn-sm disabled" href="#" title="Hapus Data"><i class="fa fa-trash-o"></i></a>
                                                <?php endif;?>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php $i++;?>
                                    <?php endforeach;?>
                                    <?php for ($j = $i; $j <= $this->config->item('show_data'); $j++):?>
                                        <tr>
                                            <td class="center"><?php echo $page+$j;?></td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    <?php endfor;?>	
                            <?php else:?>
                                <?php for ($j = 1; $j <= $this->config->item('show_data'); $j++):?>
                                    <tr>
                                        <td class="center"><?php echo $j;?></td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>                                        
                                    </tr>
                                <?php endfor;?>
                            <?php endif;?>