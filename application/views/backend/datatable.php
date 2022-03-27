<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php 
if (isset($FormNascoste)) echo $FormNascoste['html'] . PHP_EOL; ?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <?php if(isset($headerPage)): ?>
    <!--<h1 class="h3 mb-2 text-gray-800"><?php //echo $headerPage; ?></h1>-->
    <div class="row">
        <div class="col-lg-12 mb-2 mt-2">
            <h1 class="h3 mb-4 text-gray-800"><?php echo $headerPage; ?></h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 mt-n4">
            <?php echo $Filtri; ?>
        </div>
        <div class="col-lg-6 mt-n4" align="right">
            <?php if(isset($n_record)) echo 'Numero record trovati: '.$n_record.'&nbsp;&nbsp;'; ?>
        </div>
    </div>
    <?php endif; ?>
    <?php if(isset($btnNewRecord)): ?>
    <div class="card-body" align="right"> 
        <div class="row">
        <div class="col-lg-10 mb-2 mt-2">
        <?php if ($_SESSION['datable_attiva']==='importotasse'): ?>
        <a><button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#DuplicaRecord_Modal"><?php echo $labelDuplicaRecord; ?></button></a>
        <?php endif; ?>    
        <?php if ($_SESSION['datable_attiva']==='scadenze'): ?>
        <a><button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#DuplicaRecord_Modal"><?php echo $labelDuplicaRecord; ?></button></a>
        <?php endif; ?>    
        </div>
        <div class="col-lg-2 mb-2 mt-2">
        <a><button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#NuovoRecord_Modal"><?php echo $labelNewRecord; ?></button></a>
        </div>
        </div>
    </div>
    <?php endif; ?>    
    <?php if(isset($headerDescription)): ?>    
    <p class="mb-4"><?php echo $headerDescription; ?></p>
    <?php endif; ?>
    <div class="row">
        <div class="col-md-12">

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
            <?php if(isset($headerTitle)): ?>    
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><?php echo $headerTitle; ?></h6>
                </div>
            <?php endif; ?>
                <div class="card-body">
                    <?php echo $table; ?>
                </div>
            </div>        
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 mt-n4">
            <?php //echo $Filtri; ?>
        </div>
        <div class="col-lg-6 mt-n4" align="right">
            <?php if(isset($n_record)) echo 'Numero record trovati: '.$n_record.'&nbsp;&nbsp;'; ?>
        </div>
    </div>

</div>
<!-- /.container-fluid -->