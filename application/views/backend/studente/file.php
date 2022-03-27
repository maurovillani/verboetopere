<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//echo 'documenti_requisiti';
$classe_tab='tab-pane fade';
if($_SESSION['tab_attivo_studente']==='tab20') $classe_tab .='  fade  show active';
?>

<div class="<?php echo $classe_tab; ?>" id="<?php echo $tab20['id'] ?>" role="tabpanel" aria-labelledby="<?php echo $tab20['id'] ?>-tab">
    <div class="row">
        <div class="col-lg-10 mb-2 mt-2">
            <div class="row">
                <div class="col-lg-12 mb-2">
<?php if(isset($elencofile)):  ?>
<?php foreach ($elencofile as $indice => $file):  ?>
<font size="2">
<?php echo $indice+1;?>)&nbsp;<a href="<?php echo base_url($file);?>" target="_blank"><?php echo str_replace("./assets/images/students/".$tab_studente['MATRICOL']."/File/","",$file); ?></a>        
&nbsp;
<a title="elimina" data-toggle="modal" data-target="#EliminazioneFile_Modal_<?php echo $indice;?>"><span class="badge badge-secondary" style="cursor:pointer"><i class='fas fa-trash'></i></span></a>
<br/>
</font>    
<?php endforeach;?>
<?php endif;?>
                </div>
            </div>
        </div>
<!--Pannello di destra-->        
        <div class="col-lg-2 mb-2 mt-2">
            <div class="row">
                <div class="col-lg-12 mb-2">
                <input type="button" class="btn btn-primary" data-toggle="modal" data-target="#CaricaFile_Modal" value="Carica File">  
                </div>
            </div>
        </div>
    </div>
</div>
