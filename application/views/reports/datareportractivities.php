<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<input type="hidden" name="page" value="<?php echo $page;?>">
<span id="paging" style="display:none"><?php echo $paging;?></span>
                            <?php if(isset($datas) and $datas != false): $i = 1;?>
                                <?php foreach ($datas as $row):?>
                                    <tr>
                                        <td class="center"><?php echo $page+$i;?></td>
                                        <td class="center"><?php echo $row->tanggal;?></td>
                                        <td class="center"><?php echo $row->waktu;?></td>
                                        <td class="center"><?php echo $row->alamat;?></td>
                                        <td><?php echo $row->keterangan;?></td>                                        
                                    </tr>
                                <?php $i++; endforeach;?>	
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
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                <?php endfor;?>
                            <?php endif;?>