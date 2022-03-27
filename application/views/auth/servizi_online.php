<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<div class="col-xl-10 col-lg-12 col-md-9">

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div align="center">
            <p style="font-size:25px">
            <a class="small" href="<?php echo site_url('imposta_lingua/IT/ServiziOnLine'); ?>">
                Italiano
            </a>
            &nbsp;&nbsp;&nbsp;    
            <a class="small" href="<?php echo site_url('imposta_lingua/IN/ServiziOnLine'); ?>">
                English
            </a>
            </p>
        </div>
        <div align="center">
        </div>
        <div class="card-body p-8">
            
            <font style="text-align:center" color="black">
                <p style="font-size:30px">
                    <b>ACCADEMIA ALFONSIANA</b>
                </p>                                 
            </font>  

            <div align="left">
            <font color="black"> 
                <table width="100%">
                    <tbody>
                        <tr>
                            <td width="35%" valign="top" align="center">
                                <img height=300px width=200px src="<?php echo base_url('assets/images/aaseal.jpg'); ?>" </img> 
                            </td> 
                            <td width="65%" valign="top">
                                <br/><br/>
                                <font style="text-align:left">
                                    <p style="font-size:16px">
                                        <?php if ($lingua=='IT'):?>
                                        <b>SERVIZI ONLINE</b>
                                        <?php elseif ($lingua=='IN'):?>
                                        <b>ONLINE SERVICES</b>
                                        <?php endif;?>
                                    </p>
                                    <p style="font-size:16px" align="left">
                                    <?php if($PREISCRIZIONI_SCHEDA=='1'):?>
                                        <?php if ($lingua=='IT'):?>
                                            <a  href="login"><i class='fas fa-hand-point-right'></i>&nbsp;&nbsp;Sono già preiscritto e voglio procedere con l'iscrizione</a>
                                            <br/><br/>
                                            <a  href="Preiscrizione"><i class='fas fa-hand-point-right'></i>&nbsp;&nbsp;Non sono già preiscritto, ma voglio fare la mia iscrizione online </a>
                                        <?php elseif ($lingua=='IN'):?>
                                            <a  href="login"><i class='fas fa-hand-point-right'></i>&nbsp;&nbsp;I am already pre-enrollment and I want to proceed with the registration</a>
                                            <br/><br/>
                                            <a  href="Preiscrizione"><i class='fas fa-hand-point-right'></i>&nbsp;&nbsp;I am not already pre-registered, but I want to register onlinen</a>
                                        <?php endif;?>
                                    <?php elseif($PREISCRIZIONI_SCHEDA=='0'):?>
                                        <?php if ($lingua=='IT'):?>
                                            <a  href="Preiscrizione"><i class='fas fa-hand-point-right'></i>&nbsp;&nbsp;Non sono preiscritto e voglio fare la mia preiscrizione</a>
                                            <br/><br/>
                                            <a  href="login"><i class='fas fa-hand-point-right'></i>&nbsp;&nbsp;Sono già preiscritto e voglio consultare la mia scheda di preiscrizione</a>
                                        <?php elseif ($lingua=='IN'):?>
                                            <a  href="Preiscrizione"><i class='fas fa-hand-point-right'></i>&nbsp;&nbsp;I am not pre-enrollment and I want to do my pre-registration</a>
                                            <br/><br/>
                                            <a  href="login"><i class='fas fa-hand-point-right'></i>&nbsp;&nbsp;I am already pre-enrollment and I want to consult my pre-registration form</a>
                                        <?php endif;?>
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
 




