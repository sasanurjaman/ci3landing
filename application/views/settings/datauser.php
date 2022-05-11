<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<input type="hidden" name="search" value="<?php echo $search;?>">
<input type="hidden" name="page" value="<?php echo $page;?>">
<span id="paging" style="display:none"><?php echo $paging;?></span>
                            <?php if(isset($datas) and $datas != false): $i = 1;?>
                                <?php foreach ($datas as $row):?>
                                    <tr data-href="<?php echo base_url()."settings/edituser/".$search."/".$page."/".$row->id;?>">
                                        <td class="text-center"><?php echo $page+$i;?></td>
                                        <td class="hidden-lg hidden-md hidden-sm hidden-xs">
                                            <div class="col-xs-2 no-padding text-center"><img src="<?php echo base_url().'arsip/photo/'.$row->foto;?>" width="40" height="40"></div>
                                            <div class="col-xs-5"><strong><?php echo $row->userid;?></strong></div>
                                            <div class="col-xs-5 text-right no-padding"><em><?php echo ($row->tanggal != "-" ? $row->tanggal : "&nbsp;");?></em></div>
                                            <div class="col-xs-10"><?php echo $row->nama;?></div>
                                        </td>
                                        <td class="text-center hidden-xs"><?php echo $row->userid;?></td>
                                        <td class="hidden-xs"><?php echo $row->nama;?></td>
                                        <td class="text-center hidden-xs"><?php echo $row->level;?></td>
                                        <td class="text-center hidden-xs">
                                            <div class="btn-group">
                                                <?php if ($row->aktif == 'Y'):?>
                                                    <?php if ($row->userid != 'admin' && getAccess($this->session->userdata('SESS_USER_ID'), 'S2', 'edit') == 'Y'):?>
                                                        <a class="btn btn-success btn-sm" href="<?php echo base_url()."settings/activeuser/".$search."/".$page."/".$row->id; ?>" title="Aktif Data"><i class="fa fa-check"></i></a>
                                                    <?php else:?>
                                                        <a class="btn btn-success btn-sm disabled" href="#" title="Aktif Data"><i class="fa fa-check"></i></a>
                                                    <?php endif;?>
                                                <?php else:?>
                                                    <?php if ($row->userid != 'admin' && getAccess($this->session->userdata('SESS_USER_ID'), 'S2', 'edit') == 'Y'):?>
                                                        <a class="btn btn-danger btn-sm" href="<?php echo base_url()."settings/activeuser/".$search."/".$page."/".$row->id; ?>" title="Aktif Data"><i class="fa fa-close"></i></a>
                                                    <?php else:?>
                                                        <a class="btn btn-danger btn-sm disabled" href="#"><i class="fa fa-close"></i></a>
                                                    <?php endif;?>
                                                <?php endif;?>
                                            </div>
                                        </td>
                                        <td class="text-center hidden-xs">
                                            <div class="btn-group">
                                                <?php if ($row->userid != 'admin' && getAccess($this->session->userdata('SESS_USER_ID'), 'S2', 'edit') == 'Y'):?>
                                                    <a class="btn btn-warning btn-sm" href="<?php echo base_url()."settings/resetuser/".$search."/".$page."/".$row->id; ?>" title="Reset Data"><i class="fa fa-refresh"></i></a>
                                                <?php else:?>
                                                    <a class="btn btn-warning btn-sm disabled" href="#" title="Reset Data"><i class="fa fa-refresh"></i></a>
                                                <?php endif;?>
                                            </div>
                                        </td>
                                        <td class="text-center hidden-xs">
                                            <div class="btn-group">
                                                <?php if (getAccess($this->session->userdata('SESS_USER_ID'), 'S2', 'delete') == 'Y'):?>
                                                    <a class="btn btn-info btn-sm" href="<?php echo base_url()."settings/edituser/".$search."/".$page."/".$row->id;?>" title="Ubah Data"><i class="fa fa-edit"></i></a>
                                                <?php else:?>
                                                    <a class="btn btn-info btn-sm disabled" href="#" title="Ubah Data"><i class="fa fa-edit"></i></a>
                                                <?php endif;?>
                                                <?php if ($row->userid != 'admin' && getAccess($this->session->userdata('SESS_USER_ID'), 'S2', 'delete') == 'Y'):?>
                                                    <a class="btn btn-danger btn-sm" href="<?php echo base_url()."settings/deluser/".$search."/".$page."/".$row->id;?>" title="Hapus Data" col="1"><i class="fa fa-trash-o"></i></a>
                                                <?php else:?>
                                                    <a class="btn btn-danger btn-sm disabled" href="#" title="Hapus Data"><i class="fa fa-trash-o"></i></a>
                                                <?php endif;?>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php $i++;?>
                                <?php endforeach;?>	
                                <?php for ($j = $i; $j <= $this->config->item('show_data'); $j++):?>
                                    <tr data-href="">
                                        <td class="text-center"><?php echo $page+$j;?></td>
                                        <td>&nbsp;</td>
                                        <td class="hidden-xs">&nbsp;</td>
                                        <td class="hidden-xs">&nbsp;</td>
                                        <td class="hidden-xs">&nbsp;</td>
                                        <td class="hidden-xs">&nbsp;</td>
                                        <td class="hidden-xs">&nbsp;</td>
                                    </tr>
                                <?php endfor;?>
                            <?php else:?>
                                <?php for ($j = 1; $j <= $this->config->item('show_data'); $j++):?>
                                    <tr data-href="">
                                        <td class="text-center"><?php echo $j;?></td>
                                        <td>&nbsp;</td>
                                        <td class="hidden-xs">&nbsp;</td>
                                        <td class="hidden-xs">&nbsp;</td>
                                        <td class="hidden-xs">&nbsp;</td>
                                        <td class="hidden-xs">&nbsp;</td>
                                        <td class="hidden-xs">&nbsp;</td>
                                    </tr>
                                <?php endfor;?>
                            <?php endif;?>