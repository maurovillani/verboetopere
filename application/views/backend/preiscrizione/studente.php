<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<?php if (isset($tab_studente['ID'])): ?>
<script type="text/javascript">
function tab1(){
    document.myForm.TAB_ATTIVO.value='tab1';
}
function tab2(){
    document.myForm.TAB_ATTIVO.value='tab2';
}
function tab3(){
    document.myForm.TAB_ATTIVO.value='tab3';
}
function tab4(){
    document.myForm.TAB_ATTIVO.value='tab4';
}
function tab5(){
    document.myForm.TAB_ATTIVO.value='tab5';
}
function tab6(){
    document.myForm.TAB_ATTIVO.value='tab6';
}

function ConfermaInvio() {
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
        if (document.myForm.cellulare.value == ""){
            alert("Inserire il cellulare");
            document.myForm.cellulare.focus();
            return false;
        }        
    <?php echo $campo_SESSO; ?>  
    <?php echo $campo_STATOCIV; ?> 
        if (document.myForm.ID_ordine.value == "" && (document.myForm.STATOCIV.value == '1' || document.myForm.STATOCIV.value == '3' || document.myForm.STATOCIV.value == '4')){
            alert("Inserire l'Ordine");
            document.myForm.ID_ordine.focus();
            return false;
        }
        if (document.myForm.ID_diocesi.value == "" && (document.myForm.STATOCIV.value == '2' || document.myForm.STATOCIV.value >= 5)){
            alert("Inserire la diocesi");
            document.myForm.ID_diocesi.focus();
            return false;
        }
        if (document.myForm.CERTIFICATOPREISCRIZIONE.value == ""){
            alert("Specificare se si richiede il certificato di preiscrizione");
            document.myForm.CERTIFICATOPREISCRIZIONE.focus();
            return false;
        }
    <?php if (intval($tab_studente['TAB'])>1): ?>    
//        if (document.myForm.RESINDS.value == ""){
//            alert("Inserire l'indirizzo fiscale");
//            document.myForm.RESINDS.focus();
//            return false;
//        }
//        if (document.myForm.RESCAP.value == ""){
//            alert("Inserire il cap fiscale");
//            document.myForm.RESCAP.focus();
//            return false;
//        }
//        if (document.myForm.RESCOMUNE.value == ""){
//            alert("Inserire il comune fiscale");
//            document.myForm.RESCOMUNE.focus();
//            return false;
//        }
//        if (document.myForm.ID_nazioneresidenza.value == ""){
//            alert("Inserire la nazione fiscale");
//            document.myForm.ID_nazioneresidenza.focus();
//            return false;
//        }
//        if (document.myForm.ID_nazioneresidenza.value == "1" && (document.myForm.ID_provinciaresidenza.value == "" || document.myForm.ID_provinciaresidenza.value == "500")){
//            alert("Inserire la provincia fiscale");
//            document.myForm.ID_provinciaresidenza.focus();
//            return false;
//        }
//        if (document.myForm.RESTELE.value == ""){
//            alert("Inserire il telefono");
//            document.myForm.RESTELE.focus();
//            return false;
//        }
        if (document.myForm.COLLEGIO.value == ""){
            alert("Inserire se si vive in collegio o fuori collegio");
            document.myForm.COLLEGIO.focus();
            return false;
        }
        if (document.myForm.COLLEGIO.value == "-1" && document.myForm.ID_collegio.value == "" ){
            alert("Inserire il nome del collegio");
            document.myForm.ID_collegio.focus();
            return false;
        }
        if (document.myForm.COLLEGIO.value == "0" && document.myForm.RECINDS.value == "" ){
            alert("Inserire l'indirizzo a Roma");
            document.myForm.RECINDS.focus();
            return false;
        }
        if (document.myForm.COLLEGIO.value == "0" && document.myForm.RECCOMUNE.value == "" ){
            alert("Inserire il comune dell'indirizzo di Roma");
            document.myForm.RECCOMUNE.focus();
            return false;
        }
        if (document.myForm.COLLEGIO.value == "0" && document.myForm.RECCAP.value == "" ){
            alert("Inserire il cap dell'indirizzo di Roma");
            document.myForm.RECCAP.focus();
            return false;
        }
        if (document.myForm.COLLEGIO.value == "0" && document.myForm.RECTELE.value == "" ){
            alert("Inserire il recapito telefonico a Roma");
            document.myForm.RECTELE.focus();
            return false;
        }
    <?php endif; ?>    
    <?php if (intval($tab_studente['TAB'])>2): ?>    
        if (document.myForm.CORSOLAUREA.value == ""){
            alert("Inserire il tipo di iscrizione");
            document.myForm.CORSOLAUREA.focus();
            return false;
        }
        if (document.myForm.CORSOLAUREA.value > "800" && document.myForm.CheckStraordinarioOspite.value == "1" && document.myForm.ID_istituzioneprovenienza.value == "" && document.myForm.ISTITUTO_PROVENIENZA_ALTRO.value == ""){
            alert("Specificare il nome dell'istituzione di provenienza");
            document.myForm.ISTITUTO_PROVENIENZA_ALTRO.focus();
            return false;
        }
        if (document.myForm.CORSOLAUREA.value > "800" && document.myForm.CheckStraordinarioOspite.value == "1" && document.myForm.CICLO_ALTRA_UNIV.value == ""){
            alert("Specificare il ciclo altra università");
            document.myForm.CICLO_ALTRA_UNIV.focus();
            return false;
        }
        if (document.myForm.TITOLOSTUDIO.value == ""){
            alert("Inserire il titolo di studio");
            document.myForm.TITOLOSTUDIO.focus();
            return false;
        }
        if (document.myForm.TITOLOSTUDIO.value == "0" && document.myForm.TITOLOSTUDIO_ALTRO.value == ""){
            alert("Specificare il titolo di studio");
            document.myForm.TITOLOSTUDIO_ALTRO.focus();
            return false;
        }
    <?php endif; ?>    
        
    <?php //if (isset($tab_iscrizioni[0]['CORSOLAUREA']) && intval($tab_iscrizioni[0]['CORSOLAUREA'])>0): ?>    
    <?php if (intval($tab_studente['TAB'])>3 && $CRUIPRO==0): ?> 
        <?php echo $campo_PAGAMENTOMOD; ?>     
        <?php //echo $campo_PAGAMENTODATA; ?>     
        if (document.myForm.PAGAMENTODATA.value==""){
            alert("Specificare la data in cui si intente pagare");
            document.myForm.PAGAMENTODATA.focus();
            return false;
        }
        if (document.myForm.CODFISCA.value == "" && document.myForm.DETRAZIONE_FISCALE.value == "1"){
            alert("Attenzione: \nPer avere la detrazione fiscale serve il Codice Fiscale. \nInserirlo nella tab dati generali");
            document.myForm.DETRAZIONE_FISCALE.focus();
            return false;
        }
    <?php endif; ?>    

    <?php if (intval($tab_studente['TAB'])>4): ?> 
        if (document.myForm.STATOCIV.value != '5' && document.myForm.STATOCIV.value != '6' && document.myForm.SUPERIORE.value==""){
            alert("Specificare il nome del Superiore/Vescovo");
            document.myForm.SUPERIORE.focus();
            return false;
        }
    <?php endif; ?>    
    <?php if (intval($tab_studente['TAB'])>=6): ?>    
        if (document.myForm.CERTNASC.value == "S"){
            <?php echo $campo_CERTNASC_TIPO; ?>              
            if (document.myForm.CERTNASC_TIPO.value == "ALTRO" && document.myForm.CERTNASC_TIPO_ALTRO.value == ""){
                alert("Specificare il tipo di documento");
                document.myForm.CERTNASC_TIPO_ALTRO.focus();
                return false;
            }
            <?php echo $campo_CERTNASC_NUMERO; ?>              
            <?php echo $campo_CERTNASC_DATARILASCIO; ?>  
            <?php echo $campo_CERTNASC_DATASCADENZA; ?>  
        }
            <?php //if ($tab_studente['CERTNASC_TIPO']!=''): ?> 
                <?php //if ($tab_studente['permessosogg']=='S'):?>                    
                    <?php //echo $campo_datascad_permessosogg; ?>     
                <?php //endif;?>
            <?php //endif;?>
    <?php endif; ?>  
        
    <?php if ($tipo_utente=='segreteria'): ?>
        var annulla = window.confirm("Questo studente non ha ancora completato la sua preiscrizione, si vuole comunque procedere al completamento da parte della segreteria?");
        if (annulla) {
            document.getElementById("myForm").submit();
            return true;
            }
        else {
            return false;
        }
    <?php elseif ($tipo_utente=='preiscrizione'): ?>
        document.getElementById("myForm").submit();
    <?php endif; ?>  

//    if (document.myForm.CODFISCA.value == "" && document.myForm.DETRAZIONE_FISCALE.value == "1") {
//        alert("Attenzione: \nNella tab Dati generali non hai inserito tutti i dati richiesti. \nPotrai comunque completare i dati mancanti in seguito");
//        alert("Attenzione: \nPer avere la detrazione fiscale serve il Codice Fiscale. \nPotrai comunque inserirlo in seguito");
//    }
    if (document.myForm.TAB.value > 4 && document.myForm.STATOCIV.value != "5" && document.myForm.STATOCIV.value != "6" && document.myForm.SEMAIL.value == ""){
        alert("Attenzione: \nNella tab Ordinario religioso Non hai inserito tutti i dati richiesti. \nPotrai comunque completare i dati mancanti in seguito");
    }
    <?php if ($tab_studente['TAB']>5):?>                    
    else if (document.myForm.TITOLOSTUDIO_PDF.value != "S" 
        || document.myForm.AUTSUP.value != "S" 
        || document.myForm.PRESAINCARICO.value != "S"
        || (document.myForm.CORSOLAUREA.value<="250" && document.myForm.LATINO.value != "S")
        || (document.myForm.CORSOLAUREA.value<="250" && document.myForm.GRECO.value != "S")
        || (document.myForm.CORSOLAUREA.value=="888" && document.myForm.CheckStraordinarioOspite.value=='0' && document.myForm.LATINO.value != "S")
        || (document.myForm.CORSOLAUREA.value=="888" && document.myForm.CheckStraordinarioOspite.value=='0' && document.myForm.GRECO.value != "S")
//        || (document.myForm.ID_cittadinanza.value!="1" && document.myForm.permessosogg.value!="S")
        || (document.myForm.CORSOLAUREA.value=="230" && document.myForm.TESI_LICENZA.value != "S")
        || (document.myForm.CORSOLAUREA.value=="230" && document.myForm.DICHIARAZIONE_PERMANENZA_ROMA.value != "S")
        || (document.myForm.CORSOLAUREA.value>"230" && document.myForm.CheckStraordinarioOspite.value=='1' && document.myForm.AUT_UNIV.value != "S")
        || (document.myForm.CORSOLAUREA.value>"230" && document.myForm.CheckStraordinarioOspite.value=='1' && document.myForm.CERT_ISCR_ALTRA_UNIV.value != "S")
        ){
//        alert("Attenzione: \nNon hai inserito tutti i documenti richiesti. \nPotrai comunque completare i dati mancanti in seguito");
        alert("Attenzione: \nNon hai inserito tutti i documenti PDF richiesti. \nPotrai comunque completare i dati mancanti in seguito");
    }
    <?php endif; ?> 
    <?php if ($tab_studente['TAB']>5 && $tab_studente['CERTNASC_TIPO']!=''):?>                    
    else if (document.myForm.PRIMALINGUA.value == "0" 
        || (document.myForm.CORSOLAUREA.value != "999" && document.myForm.SECLINGUA.value == "0")
        || (document.myForm.CORSOLAUREA.value == "999" && document.myForm.CheckStraordinarioOspite.value=='1' && document.myForm.SECLINGUA.value == "0")
        || (document.myForm.CORSOLAUREA.value < "250" && document.myForm.TERLINGUA.value == "0")
        || (document.myForm.ID_cittadinanza.value!="1" && document.myForm.ITASTRANIERI.value != "S")
        ){
//        alert("Attenzione: \nNon hai inserito le lingue richieste. \nPotrai comunque completare i dati mancanti in seguito");
        alert("Attenzione: \nNella tab Documenti richiesti non hai inserito tutti i dati richiesti. \nPotrai comunque completare i dati mancanti in seguito");
    }
    <?php endif; ?>          
//    if (document.myForm.CODFISCA.value == ""
//        || (document.myForm.TAB.value > 3 && document.myForm.STATOCIV.value != "5" && document.myForm.STATOCIV.value != "6" && document.myForm.SEMAIL.value == "")
//        || (document.myForm.TAB.value > 5 && document.myForm.CERTNASC.value == "S" && document.myForm.PRIMALINGUA.value != "" && document.myForm.ITASTRANIERI.value != "S" )
//       ) {
//        alert("Attenzione: Non hai riempito tutti i campi obbligatori. Potrai completare i dati mancanti in seguito");
//    }
}
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
function VisualizzaOrdineDiocesi() {
  document.getElementById('ordine').style.visibility = 'hidden';     
  document.getElementById('diocesi').style.visibility = 'hidden';     
  var stato_religioso = document.getElementById('STATOCIV').value;
  if (stato_religioso!='1' && stato_religioso!='3' && stato_religioso!='4'){
    document.getElementById('lblOrdineDiocesi').style.visibility = 'visible';     
    document.getElementById('lblOrdineDiocesi').value='Diocesi';
    document.getElementById('diocesi').style.visibility = 'visible';     
    document.getElementById('ordine').type = 'hidden';     
    document.getElementById('diocesi').type = 'search'; 
  } else {
    document.getElementById('lblOrdineDiocesi').style.visibility = 'visible';     
    document.getElementById('lblOrdineDiocesi').value='Ordine';
    document.getElementById('ordine').style.visibility = 'visible';     
    document.getElementById('diocesi').type = 'hidden';     
    document.getElementById('ordine').type = 'search';     
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
function VisualizzaTipoIscrizione() {
  document.getElementById('IndirizzoLaurea').style.visibility = 'hidden';  
  document.getElementById('StraordinarioOspite').style.visibility = 'hidden';  
  document.getElementById('IstitutoPovenienza').style.visibility = 'hidden';  
  document.getElementById('IstitutoPovenienzaAltro').style.visibility = 'hidden';  
  document.getElementById('CicloAltraUniv').style.visibility = 'hidden';  
//  document.getElementById('AutUniv').style.visibility = 'hidden';  
//  document.getElementById('CertIscrAltraUniv').style.visibility = 'hidden';
  var tipo_iscrizione = document.getElementById('CORSOLAUREA').value;
  if (tipo_iscrizione=='210'){
      document.getElementById('IndirizzoLaurea').style.visibility = 'visible';     
      document.getElementById('StraordinarioOspite').style.visibility = 'hidden';     
  } else if (tipo_iscrizione=='888' || tipo_iscrizione=='999'){
      document.getElementById('IndirizzoLaurea').style.visibility = 'hidden';     
      document.getElementById('StraordinarioOspite').style.visibility = 'visible';     
        var istituto_provenienza = document.getElementById('CheckStraordinarioOspite').value;
        if (istituto_provenienza=='1'){
            document.getElementById('IstitutoPovenienza').style.visibility = 'visible';  
            document.getElementById('IstitutoPovenienzaAltro').style.visibility = 'visible';  
            document.getElementById('CicloAltraUniv').style.visibility = 'visible';  
//            document.getElementById('AutUniv').style.visibility = 'visible';  
//            document.getElementById('CertIscrAltraUniv').style.visibility = 'visible';
        } else {
            document.getElementById('IstitutoPovenienza').style.visibility = 'hidden';  
            document.getElementById('IstitutoPovenienzaAltro').style.visibility = 'hidden';  
            document.getElementById('CicloAltraUniv').style.visibility = 'hidden';  
//            document.getElementById('AutUniv').style.visibility = 'hidden';
//            document.getElementById('CertIscrAltraUniv').style.visibility = 'hidden';
        } 
  } 
} 
function VisualizzaIstitutoProvenienza() {
  document.getElementById('IstitutoPovenienza').style.visibility = 'hidden';  
  document.getElementById('IstitutoPovenienzaAltro').style.visibility = 'hidden';  
  document.getElementById('CicloAltraUniv').style.visibility = 'hidden';  
//  document.getElementById('AutUniv').style.visibility = 'hidden';  
  var istituto_provenienza = document.getElementById('CheckStraordinarioOspite').value;
  if (istituto_provenienza=='1'){
      document.getElementById('IstitutoPovenienza').style.visibility = 'visible';  
      document.getElementById('IstitutoPovenienzaAltro').style.visibility = 'visible';  
      document.getElementById('CicloAltraUniv').style.visibility = 'visible';  
//      document.getElementById('AutUniv').style.visibility = 'visible';  
  } else {
      document.getElementById('IstitutoPovenienza').style.visibility = 'hidden';  
      document.getElementById('IstitutoPovenienzaAltro').style.visibility = 'hidden';  
      document.getElementById('CicloAltraUniv').style.visibility = 'hidden';  
//      document.getElementById('AutUniv').style.visibility = 'hidden';  
  } 
} 
</script>
<?php 
ECHO '';
?>

<?php if (isset($messaggio)):?>
    <div class="alert alert-danger">
    <?php echo $messaggio; ?>
    </div>
<?php endif; ?>

<?php //if (isset($tab_studente['ID'])): ?>
    <?php echo $FormNascoste['html'] . PHP_EOL; ?>
    <?php echo $FormNascosteTitoliAccademici['html'] . PHP_EOL; ?>
<?php endif; ?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <?php 
    $attributes = array('id' => 'myForm', 'name'=>'myForm');
    echo form_open(site_url('backend/edit_record/preiscrizione_studente/'.$tab_studente['ID']),$attributes);
    ?>
    <div class="row">
        <div class="col-lg-4 mb-2 mt-2">
            <h1 class="h3 mb-1 text-gray-800"><?php echo $page_heading; ?></h1>
            <i>I campi con (*) sono obbligatori</i>
        </div>
        <?php if ($tipo_utente=='preiscrizione' ):?>
        <div class="col-lg-3 mb-2 mt-2">
            <!--Qui ci andrebbe Italiano English-->
        </div>
        <?php endif;?>
        <?php if ($tipo_utente=='preiscrizione' ):?>
        <div class="col-lg-5 mb-2 mt-2" align="right">
        <?php elseif ($tipo_utente=='segreteria' ):?>
        <div class="col-lg-8 mb-2 mt-2" align="right">
        <?php endif;?>
            
            <?php 
                $this->load->model('studente_model');
                if (isset($tab_studente['ID'])): 
            ?>
            <?php 
            if ($tipo_utente=='segreteria'  && $tab_studente['CERTIFICATOPREISCRIZIONE']=="S"){
                if ($tab_studente['CERTIFICATOPREISCRIZIONE_PDF']=='N'){
                    echo anchor(site_url('backend/modulo_certificato_preiscrizione/'.$tab_studente['ID']), '<button type="button" class="btn btn-primary">Crea Certificato Preiscrizione</button>');
                }
            }elseif($tipo_utente=='preiscrizione' && $tab_studente['CERTIFICATOPREISCRIZIONE_PDF']==='S'){?>
                <a href="<?php echo base_url('assets/images/preiscrizione/'.$tab_studente['ID'].'_CertificatoPreiscrizione.pdf');?>" target="_blank"><button type="button" class="btn btn-primary">Scarica Certificato Preiscrizione</button></a>
            <?php
            }
            ?>
            <?php //if ($tab_studente['TAB']>=6): ?>
            <?php if ($doc_inseriti==1):?>    
                <input type="button" class="btn btn-primary" value="Salva" onclick="ConfermaInvio()">  
            <?php else: ?>
                <input type="button" class="btn btn-primary" value="Avanti" onclick="ConfermaInvio()">  
            <?php endif; ?>
            <?php if ($tipo_utente=='preiscrizione' && $tab_studente['TAB']<6):?>
                <?php 
                    if($CRUIPRO==0){
                        $tab=$tab_studente['TAB'];
                        $tab_totali='6';
                    }else{
                        if ($tab_studente['TAB']==5) $tab='4';
                        $tab_totali='5';
                    };
                ?>
                <br/><b><font color="red">Tab <?php echo $tab.' di '.$tab_totali;?></font></b> 
            <?php endif; ?>
                
            <?php 
                $this->load->model('studente_model');
//                echo anchor(site_url('backend/delete_record/users/'.$tab_studente['ID']), '<button type="button" class="btn btn-danger">Elimina</button>');
                if ($tipo_utente=='segreteria'  && isset($tab_studente['PAGAMENTOMOD'])): 
                    echo anchor(site_url('backend/edit_record/preiscrizione_conferma/'.$tab_studente['ID']), '<button type="button" class="btn btn-primary">Immatricola</button>');
                endif;
            ?>
            <?php if ($tipo_utente=='segreteria' ): ?> 
                <input type="submit" class="btn btn-danger" data-toggle="modal" data-target="#EliminazioneRecord_Modal" value="Elimina">  
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
    <?php if ($tab_studente['ISCRIZIONE_TERMINATA']=='1'): ?>
        <div class="row">
            <div class="col-lg-12 mb-2" align="center">
            <font color="red">
            <h1> ISCRIZIONE ONLINE TERMINATA</h1>
            <p align="center">
                Per completare l’iscrizione, devi passare 
            </p>
            <p align="center">
                1º in Segreteria per ricevere la matricola e la badge 
            </p>
            <p align="center">
                2º in Economato per pagare la quota partecipativa
            </p>
           
            <h2>
                <?php 
                if ($tipo_utente=='preiscrizione' && $tab_studente['CERTIFICATOPREISCRIZIONE']=='S' && $tab_studente['CERTIFICATOPREISCRIZIONE_PDF']!='S'): ?>
                    Il certificato le sarà inviato per email
                <?php endif; ?>
            </h2>
            </font>
            </div>
        </div>
    <?php elseif ($tab_studente['ISCRIZIONE_TERMINATA']=='0' && $tab_studente['PREISCRIZIONE_TERMINATA']=='1'): ?>
        <div class="row">
            <div class="col-lg-12 mb-2" align="center">
            <font color="red">
            <!--<h1> PROVVEDA A COMPLETARE I DATI CHE MANCANO</h1>-->
            <p align="center">
                Per trasformare la preiscrizione in iscrizione, provveda a completare i dati che mancano 
            </p>
            </font>
            </div>
        </div>
    <?php endif;?>        
        <div class="row">
            <div class="col-lg-5 mb-2">
                <label for="COGNOME">Cognome *</label>
                <div class="input-group input-group-lg">
                <input type="hidden" id="TAB" name="TAB" value="<?php echo $tab_studente['TAB']; ?>">
                <input type="hidden" id="TAB_ATTIVO" name="TAB_ATTIVO" value="<?php echo $tab_studente['TAB']; ?>">
                <input type="hidden" id="CRUIPRO_verifica" name="CRUIPRO_verifica" value="<?php echo $CRUIPRO; ?>">
                <input type="hidden" id="ISCRIZIONE_INIZIO" name="ISCRIZIONE_INIZIO" value="<?php echo $tab_studente['ISCRIZIONE_INIZIO']; ?>">
                <input type="text" class="form-control" id="COGNOME" name="COGNOME" value="<?php echo $tab_studente['COGNOME']; ?>" required />
                </div>
            </div>
            <div class="col-lg-5 mb-2">
                <label for="NOMESTUD">Nome *</label>
                <div class="input-group input-group-lg">
                <input type="text" class="form-control" id="NOMESTUD" name="NOMESTUD" value="<?php echo $tab_studente['NOMESTUD']; ?>" required />
                </div>
            </div>
        </div>
    </div>
        <div class="row">
            <div class="col-lg-10 mb-2" align="center">
                <label for="CERTIFICATOPREISCRIZIONE">
                <b>
                Si richiede un certificato di preiscrizione
                <?php if(isset($tab_studente['SESSO'])): ?>
                    &nbsp;<input type="radio" id="CERTIFICATOPREISCRIZIONE" name="CERTIFICATOPREISCRIZIONE" value="S" <?php if ($tab_studente['CERTIFICATOPREISCRIZIONE']==='S') echo 'checked';?> onclick="this.form.submit();" required>&nbsp;SI
                    &nbsp;<input type="radio" id="CERTIFICATOPREISCRIZIONE" name="CERTIFICATOPREISCRIZIONE" value="N" <?php if ($tab_studente['CERTIFICATOPREISCRIZIONE']==='N') echo 'checked';?> onclick="this.form.submit();" required>&nbsp;NO
                <?php else: ?>
                    &nbsp;<input type="radio" id="CERTIFICATOPREISCRIZIONE" name="CERTIFICATOPREISCRIZIONE" value="S" <?php if ($tab_studente['CERTIFICATOPREISCRIZIONE']==='S') echo 'checked';?> required>&nbsp;SI
                    &nbsp;<input type="radio" id="CERTIFICATOPREISCRIZIONE" name="CERTIFICATOPREISCRIZIONE" value="N" <?php if ($tab_studente['CERTIFICATOPREISCRIZIONE']==='N') echo 'checked';?> required>&nbsp;NO
                <?php endif; ?>
                </b>
                </label>
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
                    <a class="<?php echo ($_SESSION['tab_attivo_studente']==='tab1'? 'nav-link active':'nav-link'); ?>" id="<?php echo $tab1['id'] ?>-tab" data-toggle="tab" href="#<?php echo $tab1['id'] ?>" role="tab" aria-controls="home" aria-selected="true" onclick="tab1()">
                        <?php echo $tab1['name'] ?>
                    </a>
                </li>
<?php if (intval($tab_studente['TAB'])>1): ?>
                <li class="nav-item">
                    <a class="<?php echo ($_SESSION['tab_attivo_studente']==='tab2'? 'nav-link active':'nav-link'); ?>" id="<?php echo $tab2['id'] ?>-tab" data-toggle="tab" href="#<?php echo $tab2['id'] ?>" role="tab" aria-controls="home" aria-selected="false" onclick="tab2()">
                        <?php echo $tab2['name'] ?>
                    </a>
                </li>
<?php endif; ?>
<?php if (intval($tab_studente['TAB'])>2): ?>
                <li class="nav-item">
                    <a class="<?php echo ($_SESSION['tab_attivo_studente']==='tab3'? 'nav-link active':'nav-link'); ?>" id="<?php echo $tab3['id'] ?>-tab" data-toggle="tab" href="#<?php echo $tab3['id'] ?>" role="tab" aria-controls="home" aria-selected="false" onclick="tab3()">
                        <?php echo $tab3['name'] ?>
                    </a>
                </li>
<?php endif; ?>
<?php if (intval($tab_studente['TAB'])>3): ?>
<?php if ($tab_studente['CORSOLAUREA']<800 || ($tab_studente['CORSOLAUREA']>800 && $CRUIPRO=='0')): ?>
                <li class="nav-item">
                    <a class="<?php echo ($_SESSION['tab_attivo_studente']==='tab4'? 'nav-link active':'nav-link'); ?>" id="<?php echo $tab3['id'] ?>-tab" data-toggle="tab" href="#<?php echo $tab4['id'] ?>" role="tab" aria-controls="home" aria-selected="false" onclick="tab4()">
                        <?php echo $tab4['name'] ?>
                    </a>
                </li>
<?php endif; ?>
<?php endif; ?>
<?php if (intval($tab_studente['TAB'])>4): ?>
                <li class="nav-item">
                    <a class="<?php echo ($_SESSION['tab_attivo_studente']==='tab5'? 'nav-link active':'nav-link'); ?>" id="<?php echo $tab5['id'] ?>-tab" data-toggle="tab" href="#<?php echo $tab5['id'] ?>" role="tab" aria-controls="home"  aria-selected="false" onclick="tab5()">
                        <?php echo $tab5['name'] ?>
                    </a>
                </li>
<?php endif; ?>
<?php if (intval($tab_studente['TAB'])>5): ?>
                <li class="nav-item">
                    <a class="<?php echo ($_SESSION['tab_attivo_studente']==='tab6'? 'nav-link active':'nav-link'); ?>" id="<?php echo $tab6['id'] ?>-tab" data-toggle="tab" href="#<?php echo $tab6['id'] ?>" role="tab" aria-controls="home"  aria-selected="false" onclick="tab6()">
                        <?php echo $tab6['name'] ?>
                    </a>
                </li>
<?php endif; ?>
<?php if ($tipo_utente=='segreteria' ): ?> 
<!--                <li class="nav-item">
                    <a class="<?php //echo ($_SESSION['tab_attivo_studente']==='tab5'? 'nav-link active':'nav-link'); ?>" id="<?php //echo $tab5['id'] ?>-tab" data-toggle="tab" href="#<?php //echo $tab5['id'] ?>" role="tab" aria-controls="home"  aria-selected="false">
                        <?php //echo $tab5['name'] ?>
                    </a>
                </li>-->
                <li class="nav-item">
                    <a class="<?php echo ($_SESSION['tab_attivo_studente']==='tab7'? 'nav-link active':'nav-link'); ?>" id="<?php echo $tab7['id'] ?>-tab" data-toggle="tab" href="#<?php echo $tab7['id'] ?>" role="tab" aria-controls="home"  aria-selected="false">
                        <?php echo $tab7['name'] ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="<?php echo ($_SESSION['tab_attivo_studente']==='tab8'? 'nav-link active':'nav-link'); ?>" id="<?php echo $tab8['id'] ?>-tab" data-toggle="tab" href="#<?php echo $tab8['id'] ?>" role="tab" aria-controls="home"  aria-selected="false">
                        <?php echo $tab8['name'] ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="<?php echo ($_SESSION['tab_attivo_studente']==='tab20'? 'nav-link active':'nav-link'); ?>" id="<?php echo $tab20['id'] ?>-tab" data-toggle="tab" href="#<?php echo $tab20['id'] ?>" role="tab" aria-controls="home" aria-selected="false">
                        <?php echo $tab20['name'] ?>
                    </a>
                </li>
<?php endif; ?>
            </ul>
            <div class="tab-content" id="myTabContent">
                <?php echo $tab1['html'] . PHP_EOL; ?>
<?php if (intval($tab_studente['TAB'])>1): ?>
                <?php echo $tab2['html'] . PHP_EOL; ?>
<?php endif; ?>
<?php if (intval($tab_studente['TAB'])>2): ?>
                <?php echo $tab3['html'] . PHP_EOL; ?>
<?php endif; ?>
<?php if (intval($tab_studente['TAB'])>3): ?>
                <?php echo $tab4['html'] . PHP_EOL; ?>
<?php endif; ?>
<?php if (intval($tab_studente['TAB'])>4): ?>
                <?php echo $tab5['html'] . PHP_EOL; ?>
<?php endif; ?>
<?php if (intval($tab_studente['TAB'])>5): ?>
                <?php echo $tab6['html'] . PHP_EOL; ?>
<?php endif; ?>

<?php if ($tipo_utente=='segreteria' ):?>    
                <?php //echo $tab5['html'] . PHP_EOL; ?>
                <?php echo $tab7['html'] . PHP_EOL; ?>
                <?php echo $tab8['html'] . PHP_EOL; ?>
                <?php echo $tab20['html'] . PHP_EOL; ?>
<?php endif; ?>
            </div>
        </div>
        <div class="col-lg-2 mb-1">
<?php if ($tab_studente['TAB']>=6): ?>
            <div class="row">
                <div class="card" style="width: 18rem;">
                    <img src="<?php echo base_url('assets/images/preiscrizione/' . $tab_studente['ID'] . '.jpg'); ?>" class="card-img-top" alt="Foto non disponibile">
                    <div class="card-body">
                        <p class="card-text"></p>
                    </div>
                </div>
            </div>
<!--            <div class="row">
                <a><button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#CaricamentoFoto_Modal">Caricamento Foto</button></a>
            </div>-->
<?php endif; ?>   
        </div>
    <?php echo form_close(); ?>   
        
    </div>
<?php endif; ?>
    
</div>
<!-- /.container-fluid -->