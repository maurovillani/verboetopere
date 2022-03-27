<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<div class="col-xl-6 col-lg-12 col-md-9">

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div align="center">
        </div>
        <div class="card-body p-5">
            
            <font style="text-align:center" color="black">
                <p style="font-size:30px">
                    <b>ACCADEMIA ALFONSIANA</b>
                </p>                                 
            </font>  

            <div align="left">
            <font color="black"> 
                <table>
                    <tbody>
                        <tr>
                            <td width="50%" valign="top" align="center">
                                <img height=300px width=200px src="<?php echo base_url('assets/images/aaseal.jpg'); ?>" </img> 
                            </td> 
                            <td width="50%" valign="top">
                                <br/><br/><br/><br/>
                                <font style="text-align:center">
                                    <?php //if ($lingua=='IT'):?>
                                    <p style="font-size:16px">
                                        <?php if ($lingua=='IT'):?>
                                        <b>EMAIL NON CORRETTA</b>
                                        <br/><a class="small" href="Preiscrizione"><?php echo 'Torna alla pagina di Preiscrizione'; ?></a>
                                        <?php elseif ($lingua=='IN'):?>
                                        <b>INCORRECT EMAIL</b>
                                        <br/><a class="small" href="Preiscrizione"><?php echo 'Go back to the Pre-enrollment page'; ?></a>
                                        <?php endif;?>
                                    </p>

                                </font>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
 




