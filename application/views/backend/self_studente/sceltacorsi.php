<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<!--<style>
    .anyClass {
        height: 350px;
        overflow-y: scroll;
    }
</style>-->

<style>
        .table th, .table td { 
        color:black
        }
</style>

<?php
    $n_corsi=count($corsi)+count($seminari);
    echo form_open(site_url('backend/scelta_corsi_studente_salva/'.$MATRICOLA.'/'.$corsolaurea.'/'.$n_corsi)); 
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-9 mb-2 mt-2">
            <h1 class="h3 mb-4 text-gray-800">Scelta Corsi e Seminari &nbsp;&nbsp;&nbsp;<b><?php echo $studente; ?></b></h1>
            <i><h3 class="h3 mb-4 text-gray-800">Anno Accademico <b><?php echo ($annoaccademico-1).'/'.$annoaccademico; ?></b>&nbsp&nbsp Semestre <b><?php echo $semestre; ?></b></h3></i>
        </div>
        <div class="col-lg-3 mb-2 mt-2">
            <input type="submit" class="btn btn-primary" value="Salva">  
            <?php
            echo anchor(site_url('backend/modulo_iscrizione_corsi/'.$MATRICOLA.'/'.$corsolaurea.'/'.$semestre.'/'.$annoaccademico), '<button type="button" class="btn btn-primary">Stampa modulo</button>');
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-2 mb-2 mt-2">
        </div>
        <div class="col-lg-10 mb-2 mt-2">
            <h5 class="h5 mb-4 text-gray-800">
                <?php if ($corsolaurea==='210'): ?>
                <i>Scegliere il Tipo tra: <b>A</b>=Corso di Area, <b>I</b>=Corso d'Indirizzo, <b>L</b>=Corso Libero</i>
                <?php endif; ?>
            </h5>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6 mb-2 mt-2">
<!--Pannello di sinistra--> 
<!--    <div class="row">
        <div class="col-lg-9 mb-2 mt-2">
            <h1 class="h3 mb-4 text-gray-800">CORSI</h1>
        </div>
        <div class="col-lg-3 mb-2 mt-2">
        </div>
    </div>-->
            
    <div class="row">
    <table class="table table-hover" id='corsilist'>
        <thead>
            <tr>
                <th width="10%" scope="col">Professore</th>
                <th width="32%" scope="col" colspan="2">Corso</th>
                <!--<th width="27%" scope="col">Titolo</th>-->
                <th width="8%" scope="col">Tipo</th>
            </tr>
        </thead>
        <tbody>
        <input type="hidden" name="semestre" value="<?php echo $semestre; ?>"/>
        <input type="hidden" name="annoaccademico" value="<?php echo $annoaccademico; ?>"/>
    <?php
        $row=0;
        foreach ($corsi as $corso) :
            $row+=1;
        ?>            
            <tr id=<?php echo $corso['CORSI']; ?>>
                <td>
                    <input type="hidden" name="CORSI_<?php echo $row; ?>" value="<?php echo $corso['CORSI']; ?>"/>
                    <?php echo $corso['COGNOME']; ?>
                </td>
                <td>
                    <input type="hidden" name="sigla_<?php echo $row; ?>" value="<?php echo $corso['sigla']; ?>"/>
                    <?php echo $corso['sigla']; ?>
                </td>
                <td>
                    <?php echo $corso['DESCRIZIONECORSI']; ?>
                </td>
                <td>
                    <select name="tipo_<?php echo $row; ?>" class="form-control">
                        <option value=''></option>
                        <?php if ($corsolaurea==='210'): ?>
                        <option <?php if ($corso['tipo'] === 'A') echo "selected='selected'"; ?> value='A'>A - Corso di Area</option>
                        <option <?php if ($corso['tipo'] === 'I') echo "selected='selected'"; ?> value='I'>I - Corso d'Indirizzo &nbsp</option>
                        <option <?php if ($corso['tipo'] === 'L') echo "selected='selected'"; ?> value='L'>L - Corso Libero</option>
                        <?php else: ?>
                        <option <?php if ($corso['tipo'] === 'X') echo "selected='selected'"; ?> value='X'>X</option>
                        <?php endif; ?>
                    </select>  
                </td>
            </tr>
    <?php endforeach; ?>
        </tbody>
    </table>
    </div>
        </div>
<!--Pannello di destra-->        
        <div class="col-lg-6 mb-2 mt-2">
<!--    <div class="row">
        <div class="col-lg-9 mb-2 mt-2">
            <h1 class="h3 mb-4 text-gray-800">SEMINARI</h1>
        </div>
        <div class="col-lg-3 mb-2 mt-2">
        </div>
    </div>-->
            
    <div class="row">
    <table class="table table-hover" id='corsilist'>
        <thead>
            <tr>
                <th width="10%" scope="col">Professore</th>
                <th width="32%" scope="col" colspan="2">Seminario</th>
                <!--<th width="27%" scope="col">Titolo</th>-->
                <th width="8%" scope="col">Tipo</th>
            </tr>
        </thead>
        <tbody>
    <?php
        //$row=0;
        foreach ($seminari as $corso) :
            $row+=1;
        ?>            
            <tr id=<?php echo $corso['CORSI']; ?>>
                <td>
                    <input type="hidden" name="CORSI_<?php echo $row; ?>" value="<?php echo $corso['CORSI']; ?>"/>
                    <?php echo $corso['COGNOME']; ?>
                </td>
                <td>
                    <input type="hidden" name="sigla_<?php echo $row; ?>" value="<?php echo $corso['sigla']; ?>"/>
                    <?php echo $corso['sigla']; ?>
                </td>
                <td>
                    <?php echo $corso['DESCRIZIONECORSI']; ?>
                </td>
                <td>
                    <select name="tipo_<?php echo $row; ?>" class="form-control">
                        <option value=''></option>
                        <option <?php if ($corso['tipo'] === 'A') echo "selected='selected'"; ?> value='A'>A - Corso di Area</option>
                        <option <?php if ($corso['tipo'] === 'I') echo "selected='selected'"; ?> value='I'>I - Corso d'Indirizzo &nbsp</option>
                        <option <?php if ($corso['tipo'] === 'L') echo "selected='selected'"; ?> value='L'>L - Corso Libero</option>
                    </select>  
                </td>
            </tr>
    <?php endforeach; ?>
<?php echo form_close(); ?>        
        </tbody>
    </table>
    </div>
        </div>
    </div>
</div>