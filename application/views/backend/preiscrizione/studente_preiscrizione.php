<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<?php if (isset($tab_studente['ID'])): ?>
<script type="text/javascript">
function ConfermaInvio() {
    <?php echo $campo_CERTIFICATOPREISCRIZIONE; ?>
    <?php echo $campo_COGNOME; ?>  
    <?php echo $campo_NOMESTUD; ?>  
    <?php echo $campo_NASCDATA; ?>  
    <?php echo $campo_NASCCOMUNE; ?>  
    <?php echo $campo_NASCNAZI; ?> 
        if (document.myForm.ID_nazione.value == "1" && (document.myForm.ID_provincia.value == "" || document.myForm.ID_provincia.value == "500")){
            alert("Inserire la provincia nascita");
            document.myForm.ID_provincia.focus();
            return false;
        }        
        if (document.myForm.ID_nazione.value > "1" && (document.myForm.NASCPROV_ESTERA.value == "")){
            alert("Inserire la provincia nascita");
            document.myForm.NASCPROV_ESTERA.focus();
            return false;
        }            
    <?php echo $campo_CITTADI2; ?>  
    <?php echo $campo_STATOCIV; ?>  
        if (document.myForm.STATOCIV.value != "5" && document.myForm.STATOCIV.value != "6" && document.myForm.SUPERIORE.value == '') {
            alert("Inserire il nome del Superiore/Vescovo");
            document.myForm.SUPERIORE.focus();
            return false;
        }        
        if (document.myForm.STATOCIV.value != "5" && document.myForm.STATOCIV.value != "6" && document.myForm.SEMAIL.value == '') {
            alert("Inserire l'email del Superiore/Vescovo");
            document.myForm.SEMAIL.focus();
            return false;
        }        
    <?php echo $campo_SESSO; ?>  
    <?php //echo $campo_email; ?>  
    <?php echo $campo_CORSOLAUREA; ?>     
    <?php echo $campo_TITOLOSTUDIO; ?>  
        if (document.myForm.TITOLOSTUDIO.value == "0" && document.myForm.TITOLOSTUDIO_ALTRO.value == '') {
            alert("Specificare il titolo di studio");
            document.myForm.TITOLOSTUDIO_ALTRO.focus();
            return false;
        }  
        
    <?php if ($tab_studente['CERTIFICATOPREISCRIZIONE']=='S'): ?>   
        <?php echo $campo_TITOLOSTUDIO_PDF; ?>  
        <?php echo $campo_AUTSUP; ?>  
        <?php echo $campo_PRESAINCARICO; ?>  
        <?php echo $campo_CERTNASC; ?>  
        <?php echo $campo_CERTNASC_TIPO; ?>  
        if (document.myForm.CERTNASC_TIPO.value == "ALTRO" && document.myForm.CERTNASC_TIPO_ALTRO.value == '') {
            alert("Specificare il tipo di documento");
            document.myForm.CERTNASC_TIPO_ALTRO.focus();
            return false;
        }        
        <?php echo $campo_CERTNASC_NUMERO; ?>  
        <?php echo $campo_CERTNASC_DATARILASCIO; ?>  
        <?php echo $campo_CERTNASC_DATASCADENZA; ?>  
        <?php echo $campo_COLLEGIO; ?>  
        if (document.myForm.COLLEGIO.value != "0" && document.myForm.collegio.value == '') {
            alert("Specificare il nome del collegio");
            document.myForm.collegio.focus();
            return false;
        }
//        if (document.myForm.COLLEGIO.value == "0" && document.myForm.RECPRES.value == '') {
//            alert("Specificare Presso chi si vive");
//            document.myForm.RECPRES.focus();
//            return false;
//        }        
        if (document.myForm.COLLEGIO.value == "0" && document.myForm.RECINDS.value == '') {
            alert("Specificare l'indirizzo");
            document.myForm.RECINDS.focus();
            return false;
        }        
        if (document.myForm.COLLEGIO.value == "0" && document.myForm.RECCAP.value == '') {
            alert("Specificare il CAP");
            document.myForm.RECCAP.focus();
            return false;
        }        
        if (document.myForm.COLLEGIO.value == "0" && document.myForm.RECCOMUNE.value == '') {
            alert("Specificare il Comune");
            document.myForm.RECCOMUNE.focus();
            return false;
        }        
        
    <?php endif;?>
        
    document.getElementById("myForm").submit();
}
function VisualizzaDatiSuperioreVescovo() {
  document.getElementById('NomeSuperioreVescovo').style.visibility = 'hidden';     
  document.getElementById('EmailSuperioreVescovo').style.visibility = 'hidden';     
  var stato_religioso = document.getElementById('STATOCIV').value;
  if (stato_religioso!='5' && stato_religioso!='6'){
      document.getElementById('NomeSuperioreVescovo').style.visibility = 'visible';     
      document.getElementById('EmailSuperioreVescovo').style.visibility = 'visible';     
  } else {
      document.getElementById('NomeSuperioreVescovo').style.visibility = 'hidden';     
      document.getElementById('EmailSuperioreVescovo').style.visibility = 'hidden';     
  }
} 
//function VisualizzaProvinciaNascita() {
//  document.getElementById('provincia_nascita').style.visibility = 'hidden';     
//  var nazione_nascita = document.getElementById('ID_nazione').value;
//  if (nazione_nascita=='1'){
//      document.getElementById('provincia_nascita').style.visibility = 'visible';     
//  } else {
//      document.getElementById('provincia_nascita').style.visibility = 'hidden';     
//  }
//} 
function VisualizzaProvinciaNascita() {
  document.getElementById('ProvinciaNascita').style.visibility = 'hidden';     
  document.getElementById('NASCPROV_ESTERA').type = 'hidden';     
  document.getElementById('provincia').type = 'hidden';     
  var trova = document.getElementById('ID_nazione').value;
  if (trova=='1'){
      document.getElementById('ProvinciaNascita').style.visibility = 'visible';     
      document.getElementById('provincia').type = 'search';     
  } else {
      document.getElementById('ProvinciaNascita').style.visibility = 'visible';     
      document.getElementById('NASCPROV_ESTERA').type = 'text';     
  }
} 
function VisualizzaIndirizzoRoma() {
  document.getElementById('IndirizzoRomaCollegio').style.visibility = 'hidden';     
  document.getElementById('IndirizzoRomaPresso').style.visibility = 'hidden';     
  document.getElementById('IndirizzoRomaIndirizzo').style.visibility = 'hidden';     
  document.getElementById('IndirizzoRomaComune').style.visibility = 'hidden';     
  document.getElementById('IndirizzoRomaCap').style.visibility = 'hidden';     
  document.getElementById('IndirizzoRomaTelefono').style.visibility = 'hidden';     
  var trova = document.getElementById('COLLEGIO').value;
  if (trova=='0'){
      document.getElementById('IndirizzoRomaCollegio').style.visibility = 'hidden';     
      document.getElementById('IndirizzoRomaPresso').style.visibility = 'visible';     
      document.getElementById('IndirizzoRomaIndirizzo').style.visibility = 'visible';     
      document.getElementById('IndirizzoRomaComune').style.visibility = 'visible';     
      document.getElementById('IndirizzoRomaCap').style.visibility = 'visible';     
      document.getElementById('IndirizzoRomaTelefono').style.visibility = 'visible';     
  } else {
      document.getElementById('IndirizzoRomaCollegio').style.visibility = 'visible';     
      document.getElementById('IndirizzoRomaPresso').style.visibility = 'hidden';     
      document.getElementById('IndirizzoRomaIndirizzo').style.visibility = 'hidden';     
      document.getElementById('IndirizzoRomaComune').style.visibility = 'hidden';     
      document.getElementById('IndirizzoRomaCap').style.visibility = 'hidden';     
      document.getElementById('IndirizzoRomaTelefono').style.visibility = 'hidden';     
  }
} 
function VisualizzaTitoloStudioAltro() {
  document.getElementById('TitoloStudioAltro').style.visibility = 'hidden';     
  var trova = document.getElementById('TITOLOSTUDIO').value;
  if (trova=='0'){
      document.getElementById('TitoloStudioAltro').style.visibility = 'visible';     
  } else {
      document.getElementById('TitoloStudioAltro').style.visibility = 'hidden';     
  }
} 
function VisualizzaCertNascTipoAltro() {
  document.getElementById('CertNascTipoAltro').style.visibility = 'hidden';     
  var trova = document.getElementById('CERTNASC_TIPO').value;
  if (trova=='ALTRO'){
      document.getElementById('CertNascTipoAltro').style.visibility = 'visible';     
  } else {
      document.getElementById('CertNascTipoAltro').style.visibility = 'hidden';     
  }
} 
</script>
<?php if (isset($messaggio)):?>
    <div class="alert alert-danger">
    <?php echo $messaggio; ?>
    </div>
<?php endif; ?>

<?php echo $FormNascoste['html'] . PHP_EOL; ?>
    <?php //echo $FormNascosteTitoliAccademici['html'] . PHP_EOL; ?>
<?php endif; ?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <?php 
    $attributes = array('id' => 'myForm', 'name'=>'myForm');
    echo form_open(site_url('backend/edit_record/preiscrizione_studente_prima/'.$tab_studente['ID']),$attributes);
    ?>
    <div class="row">
        <div class="col-lg-4 mb-2 mt-2">
            <h1 class="h3 mb-1 text-gray-800">
                <?php if($lingua=='IT'): ?>
                <?php echo $page_heading; ?>
                <?php elseif($lingua=='IN'): ?>
                    Pre-registration form 
                <?php endif; ?>
            </h1>
            <i>
                <?php if($lingua=='IT'): ?>
                    I campi con (*) sono obbligatori
                <?php elseif($lingua=='IN'): ?>
                    Fields with (*) are mandatory 
                <?php endif; ?>
            </i>
        </div>
        <?php if ($this->studente_model->IsPreiscrizione($_SESSION['user_id'])==='7'):?>
        <div class="col-lg-3 mb-2 mt-2" align="center">
            <p style="font-size:20px">
            <a class="small" href="<?php echo site_url('backend/studente_preiscrizione/'. $tab_studente['ID'].'/NULL/IT'); ?>">
                Italiano
            </a>
            &nbsp;&nbsp;&nbsp;    
            <a class="small" href="<?php echo site_url('backend/studente_preiscrizione/'. $tab_studente['ID'].'/NULL/IN'); ?>">
                English
            </a>
            </p>
        </div>
        <?php endif;?>
        <?php if ($this->studente_model->IsPreiscrizione($_SESSION['user_id'])==='7'):?>
        <div class="col-lg-5 mb-2 mt-2" align="right">
        <?php elseif ($this->studente_model->IsSegreteria($_SESSION['user_id'])==='6'):?>
        <div class="col-lg-8 mb-2 mt-2" align="right">
        <?php endif;?>
            <?php 
                $this->load->model('studente_model');
                if (isset($tab_studente['ID'])): 
            ?>
            <?php 
            if ($this->studente_model->IsSegreteria($_SESSION['user_id'])==='6' && $tab_studente['CERTIFICATOPREISCRIZIONE']=="S"){
                if ($tab_studente['CERTIFICATOPREISCRIZIONE_PDF']=='N'){
                    echo anchor(site_url('backend/modulo_certificato_preiscrizione/'.$tab_studente['ID']), '<button type="button" class="btn btn-primary">Crea Certificato Preiscrizione</button>');
                }
            }elseif($this->studente_model->IsPreiscrizione($_SESSION['user_id'])==='7' && $tab_studente['CERTIFICATOPREISCRIZIONE_PDF']==='S'){?>
                <?php if($lingua=='IT'): ?>
                    <a href="<?php echo base_url('assets/images/preiscrizione/'.$tab_studente['ID'].'_CertificatoPreiscrizione.pdf');?>" target="_blank"><button type="button" class="btn btn-primary">Scarica Certificato Preiscrizione</button></a>        
                <?php elseif($lingua=='IN'): ?>
                    <a href="<?php echo base_url('assets/images/preiscrizione/'.$tab_studente['ID'].'_CertificatoPreiscrizione.pdf');?>" target="_blank"><button type="button" class="btn btn-primary">Download Pre-enrollment Certificate</button></a>        
                <?php endif; ?>
            <?php
            }
            ?>
        <?php if (!isset($tab_studente['CERTIFICATOPREISCRIZIONE']) 
                    || $tab_studente['CERTIFICATOPREISCRIZIONE']=='N'
                    || ($tab_studente['CERTIFICATOPREISCRIZIONE']=='S' && $tab_studente['CERTNASC']=='S')):?>
            <?php if ($this->studente_model->IsSegreteria($_SESSION['user_id'])==='6' || $this->studente_model->IsPreiscrizione($_SESSION['user_id'])==='7'): ?> 
            <?php if($lingua=='IT'): ?>
                <?php if ($this->studente_model->IsSegreteria($_SESSION['user_id'])==='6'):?>    
                    <input type="button" class="btn btn-primary" value="Salva" onclick="ConfermaInvio()">
                <?php elseif ($this->studente_model->IsPreiscrizione($_SESSION['user_id'])==='7'): ?> 
                    <input type="button" class="btn btn-primary" value="Invia alla Segreteria" onclick="ConfermaInvio()">
                <?php endif; ?>
                <?php if ($this->studente_model->IsPreiscrizione($_SESSION['user_id'])==='7'):?>
                    <br/><b><font color="red">Inserire i dati e premere il pulsante Invia</font></b> 
                <?php endif; ?>
            <?php elseif($lingua=='IN'): ?>
                <input type="button" class="btn btn-primary" value="Send to the Secretariat" onclick="ConfermaInvio()">
                <?php if ($this->studente_model->IsPreiscrizione($_SESSION['user_id'])==='7'):?>
                    <br/><b><font color="red">Enter the data and press the button Send</font></b>  
                <?php endif; ?>
            <?php endif; ?>
            <?php endif;?>
        <?php else: ?>
            <?php if ($this->studente_model->IsPreiscrizione($_SESSION['user_id'])==='7'):?>                    
                <?php if($lingua=='IT'): ?>
                    Sarà possibile inviare i dati alla segreteria solo dopo aver inserito tutti i documenti richiesti 
                <?php elseif($lingua=='IN'): ?>
                    It will be possible to send the data to the secretariat only after having entered all the required documents                
                <?php endif; ?>
            <?php endif; ?>
        <?php endif;?>
            <?php if ($this->studente_model->IsSegreteria($_SESSION['user_id'])==='6'): ?> 
                <input type="button" class="btn btn-danger" data-toggle="modal" data-target="#EliminazioneRecord_Modal" value="Elimina">  
                <?php
                echo anchor(site_url('backend/preiscrizione_ricerca/1'), '<button type="button" class="btn btn-secondary">Torna ad elenco filtrato</button>');
                ?>
            <?php endif;?>
        </div>
    </div>
    
<?php if (!isset($tab_studente['ID'])): ?>
    NESSUN RECORD TROVATO
<?php else: ?>
    <div>                
<?php endif;?>
    <?php if ($tab_studente['PREISCRIZIONE_TERMINATA']=='1'): ?>
        <div class="row">
            <div class="col-lg-12 mb-2" align="center">
            <font color="red">
            <h1>
                <?php if($lingua=='IT'): ?>
                    PREISCRIZIONE TERMINATA
                <?php elseif($lingua=='IN'): ?>
                    PRE-ENROLLMENT COMPLETED
                <?php endif; ?>
            </h1>
            <h2>
                <?php if ($tab_studente['CERTIFICATOPREISCRIZIONE']=='S' && $tab_studente['CERTIFICATOPREISCRIZIONE_PDF']!='S'): ?>
                    <?php if($lingua=='IT'): ?>
                        Il certificato le sarà inviato per email
                    <?php elseif($lingua=='IN'): ?>
                        The certificate will be emailed to you
                    <?php endif; ?>
                <?php endif; ?>
            </h2>
            </font>
            </div>
        </div>
    <?php endif;?>        
        <div class="row">
            <div class="col-lg-5 mb-2">
                <label for="COGNOME">
                <?php if($lingua=='IT'): ?>
                    Cognome *
                <?php elseif($lingua=='IN'): ?>
                    Last Name *
                <?php endif; ?>
                </label>
                <div class="input-group input-group-lg">
                <input type="hidden" id="EMAIL_CERTIFICATO" name="EMAIL_CERTIFICATO" value="<?php echo $tab_studente['EMAIL_CERTIFICATO']; ?>">
                <input type="hidden" id="TAB" name="TAB" value="<?php echo $tab_studente['TAB']; ?>">
                <input type="hidden" id="LINGUA" name="LINGUA" value="<?php echo $lingua; ?>">
                <input type="text" class="form-control" id="COGNOME" name="COGNOME" value="<?php echo $tab_studente['COGNOME']; ?>" required />
                </div>
            </div>
            <div class="col-lg-5 mb-2">
                <label for="NOMESTUD">
                <?php if($lingua=='IT'): ?>
                    Nome *
                <?php elseif($lingua=='IN'): ?>
                    First Name *
                <?php endif; ?>
                </label>
                <div class="input-group input-group-lg">
                <input type="text" class="form-control" id="NOMESTUD" name="NOMESTUD" value="<?php echo $tab_studente['NOMESTUD']; ?>" required />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-10 mb-2" align="center">
                <label for="CERTIFICATOPREISCRIZIONE">
                <b>
                <?php if($lingua=='IT'): ?>
                Si richiede un certificato di preiscrizione
                <?php if(isset($tab_studente['SESSO'])): ?>
                    &nbsp;<input type="radio" id="CERTIFICATOPREISCRIZIONE" name="CERTIFICATOPREISCRIZIONE" value="S" <?php if ($tab_studente['CERTIFICATOPREISCRIZIONE']==='S') echo 'checked';?> onclick="this.form.submit();" required>&nbsp;SI
                    &nbsp;<input type="radio" id="CERTIFICATOPREISCRIZIONE" name="CERTIFICATOPREISCRIZIONE" value="N" <?php if ($tab_studente['CERTIFICATOPREISCRIZIONE']==='N') echo 'checked';?> onclick="this.form.submit();" required>&nbsp;NO
                <?php else: ?>
                    &nbsp;<input type="radio" id="CERTIFICATOPREISCRIZIONE" name="CERTIFICATOPREISCRIZIONE" value="S" <?php if ($tab_studente['CERTIFICATOPREISCRIZIONE']==='S') echo 'checked';?> required>&nbsp;SI
                    &nbsp;<input type="radio" id="CERTIFICATOPREISCRIZIONE" name="CERTIFICATOPREISCRIZIONE" value="N" <?php if ($tab_studente['CERTIFICATOPREISCRIZIONE']==='N') echo 'checked';?> required>&nbsp;NO
                <?php endif; ?>
                <?php elseif($lingua=='IN'): ?>
                Pre-enrollment certificate required
                <?php if(isset($tab_studente['SESSO'])): ?>
                    &nbsp;<input type="radio" id="CERTIFICATOPREISCRIZIONE" name="CERTIFICATOPREISCRIZIONE" value="S" <?php if ($tab_studente['CERTIFICATOPREISCRIZIONE']==='S') echo 'checked';?> onclick="this.form.submit();" required>&nbsp;YES
                    &nbsp;<input type="radio" id="CERTIFICATOPREISCRIZIONE" name="CERTIFICATOPREISCRIZIONE" value="N" <?php if ($tab_studente['CERTIFICATOPREISCRIZIONE']==='N') echo 'checked';?> onclick="this.form.submit();" required>&nbsp;NO
                <?php else: ?>
                    &nbsp;<input type="radio" id="CERTIFICATOPREISCRIZIONE" name="CERTIFICATOPREISCRIZIONE" value="S" <?php if ($tab_studente['CERTIFICATOPREISCRIZIONE']==='S') echo 'checked';?> required>&nbsp;YES
                    &nbsp;<input type="radio" id="CERTIFICATOPREISCRIZIONE" name="CERTIFICATOPREISCRIZIONE" value="N" <?php if ($tab_studente['CERTIFICATOPREISCRIZIONE']==='N') echo 'checked';?> required>&nbsp;NO
                <?php endif; ?>
                <?php endif; ?>
                    </b>
                </label>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 mb-4">
            <!--DIV PER SPAZIATURA PRIMA DELLA TAB-->
        </div>
    </div>
    <div class="row">
        <div class="col-lg-10 mb-1">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="<?php echo ($_SESSION['tab_attivo_studente']==='tab1'? 'nav-link active':'nav-link'); ?>" id="<?php echo $tab1['id'] ?>-tab" data-toggle="tab" href="#<?php echo $tab1['id'] ?>" role="tab" aria-controls="home" aria-selected="true">
                        <?php echo $tab1['name'] ?>
                    </a>
                </li>
<?php if (isset($tab_studente['CERTIFICATOPREISCRIZIONE']) && $tab_studente['CERTIFICATOPREISCRIZIONE']=='S'): ?>
                <li class="nav-item">
                    <a class="<?php echo ($_SESSION['tab_attivo_studente']==='tab6'? 'nav-link active':'nav-link'); ?>" id="<?php echo $tab6['id'] ?>-tab" data-toggle="tab" href="#<?php echo $tab6['id'] ?>" role="tab" aria-controls="home" aria-selected="false">
                        <?php echo $tab6['name'] ?>
                    </a>
                </li>
<?php endif; ?>
<?php if ($this->studente_model->IsSegreteria($_SESSION['user_id'])==='6'): ?> 
                <li class="nav-item">
                    <a class="<?php echo ($_SESSION['tab_attivo_studente']==='tab20'? 'nav-link active':'nav-link'); ?>" id="<?php echo $tab20['id'] ?>-tab" data-toggle="tab" href="#<?php echo $tab20['id'] ?>" role="tab" aria-controls="home" aria-selected="false">
                        <?php echo $tab20['name'] ?>
                    </a>
                </li>
<?php endif; ?>
            </ul>

            <div class="tab-content" id="myTabContent">
                <?php echo $tab1['html'] . PHP_EOL; ?>
<?php if (isset($tab_studente['CERTIFICATOPREISCRIZIONE']) && $tab_studente['CERTIFICATOPREISCRIZIONE']=='S'): ?>
                <?php echo $tab6['html'] . PHP_EOL; ?>
<?php endif; ?>
<?php if ($this->studente_model->IsSegreteria($_SESSION['user_id'])==='6'): ?> 
                <?php echo $tab20['html'] . PHP_EOL; ?>
<?php endif; ?>
            </div>
        </div>
        <div class="col-lg-2 mb-1">
            <div class="row">
<?php if (isset($tab_studente['CERTIFICATOPREISCRIZIONE'])): ?>
    <?php if ($tab_studente['CERTIFICATOPREISCRIZIONE']=='N' 
            || ($tab_studente['CERTIFICATOPREISCRIZIONE']=='S' && isset($tab_studente['COLLEGIO']))): ?>
                <div class="card" style="width: 18rem;">
                    <?php if($lingua=='IT'): ?>
                    <img src="<?php echo base_url('assets/images/preiscrizione/' . $tab_studente['ID'] . '.jpg'); ?>" class="card-img-top" alt="Caricare la fotografia in formato jpg">
                    <?php elseif($lingua=='IN'): ?>
                    <img src="<?php echo base_url('assets/images/preiscrizione/' . $tab_studente['ID'] . '.jpg'); ?>" class="card-img-top" alt="Upload the photograph in jpg format">
                    <?php endif; ?>
                    <div class="card-body">
                        <p class="card-text"></p>
                    </div>
                </div>
    <?php endif; ?>
<?php endif; ?>
            </div>
    <?php echo form_close(); ?>   
            <div class="row">
<?php if (isset($tab_studente['CERTIFICATOPREISCRIZIONE'])): ?>
    <?php if ($tab_studente['CERTIFICATOPREISCRIZIONE']=='N' 
            || ($tab_studente['CERTIFICATOPREISCRIZIONE']=='S' && isset($tab_studente['COLLEGIO']))): ?>
                <?php if($lingua=='IT'): ?>
                    <a><button type="button" title="Formato jpg" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#CaricamentoFoto_Modal">Caricamento Foto</button></a>
                <?php elseif($lingua=='IN'): ?>
                    <a><button type="button" title="Format jpg" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#CaricamentoFoto_Modal">Upload photo</button></a>
                <?php endif; ?>
    <?php endif; ?>
<?php endif; ?>
            </div>
        </div>
        
    </div>
<?php endif; ?>
    
</div>
<!-- /.container-fluid -->