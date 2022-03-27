<?php
$amf=APPPATH;
include_once(APPPATH.'TBS/tbs_class.php');
include_once(APPPATH.'TBS/plugins/tbs_plugin_opentbs.php');

$TBS = new clsTinyButStrong; // new instance of TBS
$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN); // load the OpenTBS plugin

//Set some OpenTBS options
$TBS->OtbsConvertApostrophes = false;

//$template = "mod_certificato_preiscrizione.docx";
$template=APPPATH.'views/stampe/AMF.docx';
// $TBS->Plugin(OPENTBS_MAKE_OPTIMIZED_TEMPLATE, $template, $new_template);

$id=100;
$row['COGNOME']='FILICE';
$row['NOME']='ANNA MARIA';
$TBS->VarRef = $row;

// Load template

$TBS->LoadTemplate($template,OPENTBS_ALREADY_UTF8); // Also merge some [onload] automatic fields (depends of the type of document).

$output_file_name = $id . "-Certificato preiscrizione.docx";

$TBS->Show(OPENTBS_DOWNLOAD, $output_file_name); 

?>