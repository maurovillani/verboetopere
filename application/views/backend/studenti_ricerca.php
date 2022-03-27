<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php //echo 'ciao'; ?>

<script>
function VisualizzaCambiSubordinati() {
  document.getElementById('subordinato').style.visibility = 'hidden';     
  var anno_acca = document.getElementById('ANNOACCA').value;
  if (anno_acca>0){
      document.getElementById('subordinato').style.visibility = 'visible';     
  } else {
      document.getElementById('subordinato').style.visibility = 'hidden';     
  }
/*  var x = document.getElementById(anno_acca);
  if (x.style.visibility === 'visible') {
    x.style.visibility = 'hidden';
  } else {
    x.style.visibility = 'visible';
  }*/
} 
</script>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    
    <div class="row">
        <div class="col-lg-12 mb-2 mt-2">
            <h1 class="h3 mb-4 text-gray-800">Ricerca Studenti</h1>
        </div>
    </div>
    
<div class="row">
    <div class="col-lg-8 mb-1 ml-3">
        <div class="row">
            <div class="col-lg-4 mb-1">
                <?php //echo form_open('backend/datatable/studenti'); ?>
                <?php echo form_open('backend/studenti_cartella/0'); ?>
                <div class="row">
                    <label for="COGNOME">Cognome</label>
                    <input type="text" class="form-control" id="COGNOME" name="COGNOME" value="<?php if(isset($COGNOME)) echo $COGNOME; ?>" />
                </div>
                <div class="row">
                    <label for="MATRICOL">Matricola</label>
                    <input type="text" class="form-control" id="MATRICOL" name="MATRICOL" value="<?php if(isset($COGNOME)) echo $MATRICOL; ?>" />
                </div>
                <div class="row">
                    <label for="ANNOACCA">Anno Accademico</label>
                    <select id="ANNOACCA" name="ANNOACCA" class="form-control" onchange="VisualizzaCambiSubordinati()">
                        <option selected='selected' value='tutti'></option>
                        <?php
                        foreach ($tab_anno_accademico as $key => $value) {
                            if(isset($ANNOACCA) && $value['ANNOACCA']===$ANNOACCA){
                                echo "<option selected='selected' value='" . $value['ANNOACCA'] . "'>" . $value['ANNOACCADEMICO'] . "</option>";
                            }else{
                                echo "<option  value='" . $value['ANNOACCA'] . "'>" . $value['ANNOACCADEMICO'] . "</option>";
                            }
                        }
                        ?>
                    </select>  
                </div>
<div style="visibility:hidden" id="subordinato">
                <div class="row">
                    <label for="ANNOCORSO">Anno/Semestre di Corso</label>
                    <select id="ANNOCORSO" name="ANNOCORSO" class="form-control">
                        <option selected='selected' value='tutti'></option>
                        <option value='1A'>1° Anno di corso</option>
                        <option value='2A'>2° Anno di corso</option>
                        <option value='F'>Fuori corso</option>
                        <option value='1S'>1° Semestre di corso</option>
                        <option value='2S'>2° Semestre di corso</option>
                        <option value='3S'>3° Semestre di corso</option>
                        <option value='4S'>4° Semestre di corso</option>
                    </select>                        
                </div>
                <div class="row">
                    <label for="CORSOLAUREA">Corso laurea</label>
                    <select id="CORSOLAUREA" name="CORSOLAUREA" class="form-control">
                        <option selected='selected' value='tutti'></option>
                        <?php
                        foreach ($tab_corsidilaurea as $key => $value) {
                            if(isset($CORSOLAUREA) && $value['CODICENU']===$CORSOLAUREA){
                                echo "<option selected='selected' value='" . $value['CODICENU'] . "'>" . $value['DECODIF'] . "</option>";
                            }else{
                                echo "<option  value='" . $value['CODICENU'] . "'>" . $value['DECODIF'] . "</option>";
                            }
                        }
                        ?>
                    </select>  
                </div>
</div>    
                <div class="row">
                    <div class="col-lg-12 mb-4">
                        <!--DIV PER SPAZIATURA DAL PULSANTE-->
                    </div>         
                    <input type="submit" class="btn btn-primary m-1" value="Cartella"></button>                
                    <!--<input type="submit" class="btn btn-primary" value="Elenco"></button>-->                
                    <?php echo form_close(); ?>    
                    <?php echo form_open(site_url('backend/studenti_ricerca_azzera')); ?>
                    <input type="submit" class="btn btn-primary m-1" value="Azzera">     
                    <?php echo form_close(); ?>    
                    
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- /.container-fluid -->
