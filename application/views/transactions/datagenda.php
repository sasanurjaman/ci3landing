<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<input type="hidden" name="search" value="<?php echo $search;?>">
<input type="hidden" name="page" value="<?php echo $page;?>">
<span id="paging" style="display:none"><?php echo $paging;?></span>
                            <?php if(isset($datas) and $datas != false): $i = 1;?>
                                <?php foreach ($datas as $row):?>
                                    <tr>
                                        <td class="center"><?php echo $page+$i;?></td>
                                        <td class="center"><?php echo ($row->tanggal != '-' ? $row->tanggal : null);?></td>
                                        <td class="center"><?php echo ($row->waktu != '-' ? $row->waktu : null);?></td>
                                        <td><?php echo ($row->kegiatan != '-' ? $row->kegiatan : null)?></td>
                                        <td><?php echo ($row->keterangan != '-' ? $row->keterangan : null)?></td>
                                        <td class="center">
                                            <div class="btn-group">
                                                <?php if ($row->status == "Y"):?>
                                                    <a class="btn btn-success btn-sm" href="<?php echo base_url()."index.php/transactions/activeagenda/".$search."/".$page."/".$row->id; ?>" title="Aktif Data"><i class="fa fa-check"></i></a>
                                                <?php else:?>
                                                    <a class="btn btn-danger btn-sm" href="<?php echo base_url()."index.php/transactions/activeagenda/".$search."/".$page."/".$row->id; ?>" title="Aktif Data"><i class="fa fa-close"></i></a>
                                                <?php endif;?>
                                            </div>
                                        </td>
                                        <td class="center">
                                            <div class="btn-group">
                                                <?php if (getAccess($this->session->userdata('SESS_USER_ID'), 'T3', 'edit') == 'Y'):?>
                                                    <a class="btn btn-info btn-sm" href="<?php echo base_url()."index.php/transactions/editagenda/".$search."/".$page."/".$row->id;?>" title="Ubah Data"><i class="fa fa-edit"></i></a>
                                                <?php else:?>
                                                    <a class="btn btn-info btn-sm disabled" href="#" title="Ubah Data"><i class="fa fa-edit"></i></a>
                                                <?php endif;?>
                                                <?php if (getAccess($this->session->userdata('SESS_USER_ID'), 'T3', 'delete') == 'Y'):?>
                                                    <a class="btn btn-danger btn-sm" href="<?php echo base_url()."index.php/transactions/delagenda/".$search."/".$page."/".$row->id;?>" title="Hapus Data"><i class="fa fa-trash-o"></i></a>
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
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                <?php endfor;?>
                            <?php endif;?>