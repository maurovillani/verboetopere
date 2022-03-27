<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<style>
    .anyClass {
        height: 350px;
        overflow-y: scroll;
    }
    .modal-dialog {
        width: 800px;
        margin: 30px auto;
    }    
</style>
<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-9 mb-2 mt-2">
            <h1 class="h3 mb-4 text-gray-800">Scelta Corsi e Seminari&nbsp;&nbsp;&nbsp;<b><?php echo $studente; ?></b></h1>
        </div>
        <div class="col-lg-3 mb-2 mt-2">
            <h1 class="h4 mb-4 text-gray-800"></h1>
        </div>
    </div>
<?php
    $n_corsi=count($corsi)+count($seminari);
    echo form_open(site_url('backend/scelta_corsi_studente_salva/'.$MATRICOLA.'/'.$corsolaurea.'/'.$n_corsi)); 
    ?>
    <div class="row">
        <div class="col-lg-9 mb-2 mt-2">
            <h1 class="h3 mb-4 text-gray-800">CORSI</h1>
        </div>
        <div class="col-lg-3 mb-2 mt-2">
            <input type="submit" class="btn btn-primary" data-toggle="modal" data-target="#ConfermaSalvataggio_Modal" value="Salva">  
        </div>
    </div>
            
    <div class="row">
    <table class="table table-hover" id='corsilist'>
        <thead>
            <tr>
                <th width="15%" scope="col">Professore</th>
                <th width="10%" scope="col">Corso</th>
                <th width="60%" scope="col">Titolo</th>
                <th width="15%" scope="col">Tipo</th>
            </tr>
        </thead>
        <tbody>
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
                        <option <?php if ($corso['tipo'] === 'A') echo "selected='selected'"; ?> value='A'>Corso di Area</option>
                        <option <?php if ($corso['tipo'] === 'I') echo "selected='selected'"; ?> value='I'>Corso d'Indirizzo</option>
                        <option <?php if ($corso['tipo'] === 'L') echo "selected='selected'"; ?> value='L'>Corso Libero</option>
                    </select>  
                </td>
            </tr>
    <?php endforeach; ?>
        </tbody>
    </table>
    </div>

    <div class="row">
        <div class="col-lg-9 mb-2 mt-2">
            <h1 class="h3 mb-4 text-gray-800">SEMINARI</h1>
        </div>
        <div class="col-lg-3 mb-2 mt-2">
        </div>
    </div>
            
    <div class="row">
    <table class="table table-hover" id='corsilist'>
        <thead>
            <tr>
                <th width="15%" scope="col">Professore</th>
                <th width="10%" scope="col">Seminario</th>
                <th width="60%" scope="col">Titolo</th>
                <th width="15%" scope="col">Tipo</th>
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
                        <option <?php if ($corso['tipo'] === 'A') echo "selected='selected'"; ?> value='A'>Corso di Area</option>
                        <option <?php if ($corso['tipo'] === 'I') echo "selected='selected'"; ?> value='I'>Corso d'Indirizzo</option>
                        <option <?php if ($corso['tipo'] === 'L') echo "selected='selected'"; ?> value='L'>Corso Libero</option>
                    </select>  
                </td>
            </tr>
    <?php endforeach; ?>
<?php echo form_close(); ?>        
        </tbody>
    </table>
    </div>
</div>
<!-- /.container-fluid -->