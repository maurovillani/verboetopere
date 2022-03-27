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
                                <br/><br/>
                                <font style="text-align:center">
                                    <?php //if ($lingua=='IT'):?>
                                    <p style="font-size:16px">
                                        <?php if ($lingua=='IT'):?>
                                        <b>UTENTE CREATO</b>
                                        <?php elseif ($lingua=='IN'):?>
                                        <b>USER CREATE</b>
                                        <?php endif;?>
                                    </p>
                                    <p style="font-size:13px" align="left">
                                        <?php if ($lingua=='IT'):?>
                                        Seguire ora le istruzioni che arriveranno a breve via e-mail all’indirizzo appena fornito
                                        <?php elseif ($lingua=='IN'):?>
                                        Follow now the instructions that will arrive shortly by e-mail at the address just provided
                                        <?php endif;?>
                                    </p>
                                    <p style="font-size:13px" align="left">
                                        <?php if ($lingua=='IT'):?>
                                        Se non arriva l'email, verificare nella cartella di posta indesiderata (spam).
                                        In caso di problemi è possibile contattare per e-mail <a href="mailto:gestoreVO@alfonsiana.org">gestoreVO@alfonsiana.org</a>
                                        <?php elseif ($lingua=='IN'):?>
                                        If the email does not arrive, check your junk mail folder (spam).
                                        In case of problems, you can contact by e-mail <a href="mailto:gestoreVO@alfonsiana.org">gestoreVO@alfonsiana.org</a>
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
 




