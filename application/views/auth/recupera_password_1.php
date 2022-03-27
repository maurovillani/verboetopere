<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<?php if (isset($message)): ?>
    <div id="infoMessage" class="alert alert-primary" role="alert" role="alert" >
        <?php if (substr($message,3,19)=='The Indirizzo Email') $message='Indirizzo email già presente'; ?>
        <?php echo $message; ?>
    </div>
<?php endif; ?>

<div class="col-xl-12 col-lg-12 col-md-9">

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-5">
            
            <font style="text-align:center" color="black">
                <p style="font-size:30px">
                    <b>ACCADEMIA ALFONSIANA</b>
                </p>                                 
                <p style="font-size:20px">
                    <b>Password Dimenticata</b>
                </p>                                 
            </font>  

    <div align="center">
<font color="black">        
<?php echo form_open("auth/email_recupera_password", ['class' => 'user']);?>
        <table>
            <tbody>
                <tr>
                    <td width="30%" valign="top" align="center">
                        <img height=300px width=200px src="<?php echo base_url('assets/images/aaseal.jpg'); ?>" </img> 
                    </td> 
                    <td width="70%" valign="top">
                        <font style="text-align:justify">
                        <p style="font-size:18px">
                            Inserire la propria email, 
                        <br/>
                            vi verrà inviata una email per reimpostare la vostra password
                        </p>
                        </font>
                        <br/>
                        <table>
                            <tbody>
                                <tr>
                                    <td width="50%" valign="top">
                                    Email
                                    </td>
                                    <td width="50%" valign="top">
                                    <?php echo form_input($email,$value = '', $extra = 'size="50"');?>
                                <?php
//                                $identity['type'] = 'email';
//                                $identity += [
//                                    //'class' => 'form-control form-control-user',
//                                    //'aria-describedby' => 'emailHelp',
//                                    'placeholder' => 'Enter Email Address...',
//                                    ' id' => 'exampleInputEmail'
//                                ];
//                                echo form_input($identity,$value = '', $extra = 'size="50"');
                                ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>    
                        <br/>
                        <p><?php echo form_submit('submit', 'Resetta la password');?></p>
                    </td>
                </tr>
            </tbody>
        </table>
<?php echo form_close();?>                        
    </div>
    </div>
    </div>
    </div>
</font>  




