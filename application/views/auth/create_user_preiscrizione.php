<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<script>
    function showPwd() {
        var input = document.getElementById('password');
        if (input.type === "password") {
          input.type = "text";
        } else {
          input.type = "password";
        }
      }
      
    function showPwdConf() {
        var input = document.getElementById('password_confirm');
        if (input.type === "password") {
          input.type = "text";
        } else {
          input.type = "password";
        }
      }
</script>


<style>
input[type=checkbox] {
    zoom: 1.5;
    vertical-align: middle;
}    
</style>

<?php if (isset($message)): ?>
    <div id="infoMessage" class="alert alert-primary" role="alert" role="alert" >
        <?php 
        if (substr($message,3,19)=='The Indirizzo Email'){
            if ($lingua=='IT'){
                $message='Indirizzo email giÃ  presente'; 
            }elseif ($lingua=='IN'){
                $message='Email address already present'; 
            }
        }
        if (substr($message,3,43)=='The email field must contain a unique value'){
            if ($lingua=='IT'){
                $message='Indirizzo email giÃ  presente nel sistema dell\'Accademia Alfonsiana'; 
            }elseif ($lingua=='IN'){
                $message='Email address already present in the Alphonsian Academy system'; 
            }
        }
        if (substr($message,3,56)=='The email field does not match the Indirizzo Email field'){
            if ($lingua=='IT'){
                $message='Il campo di conferma e-mail non corrisponde al campo e-mail'; 
            }elseif ($lingua=='IN'){
                $message=$message; 
            }
        }
            
        if (substr($message,3,51)=='The email confirm field must contain a unique value'){
            if ($lingua=='IT'){
                $message='Il campo di conferma e-mail non corrisponde al campo e-mail'; 
            }elseif ($lingua=='IN'){
                $message=$message; 
            }
        }
        if (substr($message,3,18)=='The Password field'){
            if ($lingua=='IT'){
                $message='Il campo di conferma password non corrisponde al campo password'; 
            }elseif ($lingua=='IN'){
                $message=$message; 
            }
        }
        ?>
        <?php echo $message; ?>
    </div>
<?php endif; ?>

<div class="col-xl-12 col-lg-12 col-md-9">

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div align="center">
            <p style="font-size:25px">
            <a class="small" href="<?php echo site_url('imposta_lingua/IT/Preiscrizione'); ?>">
                Italiano
            </a>
            &nbsp;&nbsp;&nbsp;    
            <a class="small" href="<?php echo site_url('imposta_lingua/IN/Preiscrizione'); ?>">
                English
            </a>
            </p>
        </div>
        <div class="card-body p-5">
            
            <font style="text-align:center" color="black">
                <p style="font-size:30px">
                    <b>ACCADEMIA ALFONSIANA</b>
                </p>                                 
            </font>  

            <div align="left">
            <font color="black">   
            <?php echo form_open("auth/create_user_preiscrizione/".$lingua, ['class' => 'user']);?>
                <table>
                    <tbody>
                        <tr>
                            <td width="30%" valign="top" align="center">
                                <img height=300px width=200px src="<?php echo base_url('assets/images/aaseal.jpg'); ?>" </img> 
                            </td> 
                            <td width="70%" valign="top">
                                <font style="text-align:justify">
                                    <?php if ($lingua=='IT'):?>
                                    <p style="font-size:16px">
                                        <b>CREAZIONE UTENTE</b>
                                    </p>                                 
                                    <p style="font-size:13px">
                                        Ãˆ qui possibile attivare la procedura di preiscrizione all'Accademia attraverso 3 semplici passaggi:
                                        <br/>1 - Leggere l'Informativa sulla Privacy e prestare il proprio consenso; 
                                        <br/>2 - Scrivere nel modulo i dati personali richiesti. Premendo il tasto â€œCrea Utenteâ€� a fine pagina, si inoltreranno sia i dati inseriti sia il consenso al trattamento. 
                                        <br/>3 - Seguire le istruzioni che troverÃ  nella mail che ricever&agrave;  a breve.
                                    </p>
                                    <?php elseif ($lingua=='IN'):?>
                                    <p style="font-size:16px">
                                        <b>USER CREATION</b>
                                    </p>                                 
                                    <p style="font-size:13px">
                                        Here you can activate the procedure of pre-enrolment to the Academy through 3 simple steps: 
                                        <br/>1 - Read the Privacy Policy and give your consent; 
                                        <br/>2 - Write in the form the personal data required. Pressing the "Create User" button at the end of the page, you will submit both the data entered and the consent to treatment. 
                                        <br/>3- Follow the instructions that you will find in the email you will receive shortly.â€�>
                                    </p>
                                    <?php endif;?>
                                </font>
                                <font color="red">
                                <b>
                                    <p style="font-size:13px">
                                    <?php if ($lingua=='IT'):?>
                                        1 - Leggere l'Informativa sulla Privacy e prestare il proprio consenso
                                    <?php elseif ($lingua=='IN'):?> 
                                        1 - Read the Privacy Policy and give your consent
                                    <?php endif;?>
                                    </p>
                                </b>
                                </font>
                                <font style="text-align:left">
                                    <p style="font-size:13px">
                                    <?php if ($lingua=='IT'):?>    
                                        Ai sensi e per gli effetti di cui all'art. 13 del Regolamento UE 2016/679, 
                                        relativo alla protezione delle persone fisiche con riguardo al trattamento dei dati personali 
                                        nonch&egrave; alla libera circolazione degli stessi, 
                                        si invita a prendere atto e visione della seguente <b><a href="<?php echo base_url('assets/uploads/Informativa privacy studenti AA-ita.pdf');?>" target="_blank">INFORMATIVA SULLA PRIVACY</a></b>,
                                        <b>che &egrave; valida sia per la preiscrizione che per la successiva iscrizione.</b>
                                    <?php elseif ($lingua=='IN'):?> 
                                        Pursuant to and for the purposes of art. 13 of the EU Regulation 2016/679 
                                        on the protection of individuals with regard to the processing of personal data 
                                        and on the free circulation of such data, 
                                        you are invited to acknowledge and read the following <b><a href="<?php echo base_url('assets/uploads/Informativa privacy studenti AA-eng.pdf');?>" target="_blank">PRIVACY POLICY STATEMENT</a></b>, 
                                        <b>which is valid both for the pre-registration and for the subsequent registration.</b>
                                    <?php endif;?>
                                    </p>
                                    <p style="font-size:13px">
                                    <?php if ($lingua=='IT'):?>    
                                        Titolare del trattamento dei dati forniti nella fase di preiscrizione 
                                        e nella successiva iscrizione &egrave; l'ente Accademia Alfonsiana, 
                                        nella persona del suo rappresentante legale, 
                                        che ha designato un coordinatore del trattamento; 
                                        l'interessato ha diritto di revocare il proprio consenso in qualsiasi momento, 
                                        scrivendo alla sua casella: <a href="mailto:privacy@alfonsiana.org">privacy@alfonsiana.org</a>. 
                                        La revoca del consenso non pregiudicherÃ  la liceitÃ  del trattamento effettuato 
                                        prima della revoca.                              
                                    <?php elseif ($lingua=='IN'):?>
                                        The controller of the processing of data provided in the pre-registration 
                                        and subsequent enrollment is the Accademia Alfonsiana, 
                                        in the person of its legal representative, 
                                        who has designated a coordinator of the treatment; 
                                        the person concerned has the right to revoke his consent at any time, 
                                        writing to his mailbox: <a href="mailto:privacy@alfonsiana.org">privacy@alfonsiana.org</a>. 
                                        The revocation of consent will not affect the lawfulness of the treatment 
                                        carried out before the revocation.  
                                    <?php endif;?>    
                                    </p>
                                    <p style="font-size:13px">
                                    <?php if ($lingua=='IT'):?> 
                                        Preso atto e visione dell'informativa proposta dal Titolare del Trattamento, 
                                        <b>esprimere il consenso al trattamento descritto spuntando la seguente casella</b>&nbsp;&nbsp;&nbsp;<input type="checkbox" name="informativa" value="1" size="10" required/>
                                    <?php elseif ($lingua=='IN'):?> 
                                        Having acknowledged and seen the policy proposed by the Data Controller, 
                                        <b>please express your consent to the processing described by ticking the following box</b>&nbsp;&nbsp;&nbsp;<input type="checkbox" name="informativa" value="1" size="10" required/>
                                    <?php endif;?>     
                                   </p>
                                </font>
                                <font color="red">
                                <b>
                                    <p style="font-size:13px">
                                    <?php if ($lingua=='IT'):?>
                                        2 - Scrivere nei seguenti campi obbligatori i dati personali richiesti
                                    <?php elseif ($lingua=='IN'):?> 
                                        2 - Write in the following mandatory fields the personal data required
                                    <?php endif;?>
                                    </p>
                                </b>
                                </font>
                        </tr>
                        <tr>
                            <td width="30%" valign="top" align="right">
                            </td> 
                            <td width="70%" valign="top" align="left">
                                <table width="70%">
                                    <tbody>
                                        <tr>
                                            <td width="100%" colspan="2">
                                            <?php if ($lingua=='IT'):?>
                                                NOME
                                            <?php elseif ($lingua=='IN'):?>
                                                NAME
                                            <?php endif;?>    
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="100%" colspan="2">
                                            <?php echo form_input($first_name,$value = '', $extra = 'size="65"');?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="100%" colspan="2">
                                            <?php if ($lingua=='IT'):?>
                                                COGNOME
                                            <?php elseif ($lingua=='IN'):?>
                                                LAST NAME
                                            <?php endif;?>    
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="100%" colspan="2">
                                            <?php echo form_input($last_name,$value = '', $extra = 'size="65"');?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="100%" colspan="2">
                                            E-MAIL
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="100%" colspan="2">
                                            <?php echo form_input($email,$value = '', $extra = 'size="65"');?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="100%" colspan="2">
                                            <?php if ($lingua=='IT'):?>
                                                CONFERMA E-MAIL
                                            <?php elseif ($lingua=='IN'):?>
                                                CONFIRM E-MAIL
                                            <?php endif;?>    
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="100%" colspan="2">
                                                <input type="email" id="email_confirm" name="email_confirm" value="" size="65" required>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="40%" valign="top" align="left">
                                            <?php if ($lingua=='IT'):?>
                                                CREA PASSWORD
                                            <?php elseif ($lingua=='IN'):?>
                                                CREATE PASSWORD
                                            <?php endif;?>    
                                            </td>
                                            <td width="60%" valign="top" align="right">
                                            <?php if ($lingua=='IT'):?>
                                                <p style="font-size:12px; margin-top:0px; ; margin-bottom:0px;" align="right">
                                                <i>mostra password&nbsp;</i><input type="checkbox" onclick="showPwd()">
                                                </p>
                                            <?php elseif ($lingua=='IN'):?>
                                                <p style="font-size:12px; margin-top:0px; ; margin-bottom:0px;" align="right">
                                                <i>show password&nbsp;</i><input type="checkbox" onclick="showPwd()">
                                                </p>
                                            <?php endif;?>    
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="100%" colspan="2">
                                            <?php if ($lingua=='IT'):?>
                                                <?php echo form_input($password,$value = '', $extra = 'size="65" required pattern="((?=.*[0-9])(?=.*[A-Z])(?=.*[a-z]).{8,})" title="La password deve essere lunga almeno 8 caratteri, deve contenere almeno: una lettera maiscola, una lettera minuscola e un numero"');?>
                                                <br/>
                                                <p style="font-size:12px; margin-top:0px; ; margin-bottom:0px;" align="left">
                                                    <i>Otto o piÃ¹ caratteri, con almeno un numero, una lettera minuscola e una maiuscola.</i>
                                                </p>
                                            <?php elseif ($lingua=='IN'):?>
                                                <?php echo form_input($password,$value = '', $extra = 'size="65" required pattern="((?=.*[0-9])(?=.*[A-Z])(?=.*[a-z]).{8,})" title="The password must be at least 8 characters long, it must contain at least: one upper case letter, one lower case letter and one number"');?>
                                                <br/>
                                                <p style="font-size:12px; margin-top:0px; ; margin-bottom:0px;" align="left">
                                                    <i>Eight or more characters, with at least one number, one lowercase and one uppercase letter.</i>
                                                </p>
                                            <?php endif;?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="40%" valign="top" align="left">
                                            <?php if ($lingua=='IT'):?>
                                                CONFERMA PASSWORD
                                            <?php elseif ($lingua=='IN'):?>
                                                CONFIRM PASSWORD
                                            <?php endif;?>    
                                            </td>
                                            <td width="60%" valign="top" align="right">
                                            <?php if ($lingua=='IT'):?>
                                                <p style="font-size:12px; margin-top:0px; ; margin-bottom:0px;" align="right">
                                                <i>mostra conferma password&nbsp;</i><input type="checkbox" onclick="showPwdConf()">
                                                </p>
                                            <?php elseif ($lingua=='IN'):?>
                                                <p style="font-size:12px; margin-top:0px; ; margin-bottom:0px;" align="right">
                                                <i>show confirm password&nbsp;</i><input type="checkbox" onclick="showPwdConf()">
                                                </p>
                                            <?php endif;?>    
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="100%" colspan="2">
                                            <?php echo form_input($password_confirm,$value = '', $extra = 'size="65"');?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>    
                            </td>
                        </tr>
                        <tr>
                            <td width="30%" valign="top" align="right">
                            </td> 
                            <td width="70%" valign="top" align="left">
                                <br/>
                                <p>
                                <?php if ($lingua=='IT'):?>
                                    <?php echo form_submit('submit', 'CREA UTENTE');?>
                                <?php elseif ($lingua=='IN'):?>
                                    <?php echo form_submit('submit', 'CREATE USER');?>
                                <?php endif;?>
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <?php echo form_close();?>                        
            </div>
        </div>
    </div>
</div>
 




