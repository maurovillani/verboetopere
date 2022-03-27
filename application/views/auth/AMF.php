<?php

// TinyButStrong (TBS)
// Include TBS classes, initialize the TBS and OpenTBS instances and set some TBS and OpenTBS options

// Include TBS classes

//require_once('../../TBS/tbs_us/tbs_class.php'); // Load the TinyButStrong template engine
//require_once('../../TBS/tbs_plugin_opentbs/tbs_plugin_opentbs.php'); // version 1.9.9, on 2017-05-28
require_once(APPPATH.'libraries/tbs_us/tbs_class.php');
require_once(APPPATH.'libraries/tbs_us/plugins/tbs_plugin_opentbs.php');


// Initalize the TBS instance and the OpenTBS plugin
$TBS = new clsTinyButStrong; // new instance of TBS
$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN); // load the OpenTBS plugin

//Set some OpenTBS options
$TBS->OtbsConvertApostrophes = false;


//To include some  functions that I use in my Word Templates
//require_once('_JM_TBS_functions.php');


//Per connessione alla base dati in MySQL
// Sostituire con i dati di accesso pertinenti al contesto

$host = '127.0.0.1'; // or localhost
$db   = 'verboetopere';
$user = 'verboetopere';
$pass = 'verboetopere';
$charset = 'utf8'; // or utf8mb4

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
try {
     $dbh = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
     throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

// Retrieve the template to open
$template = "mod_certificato_preiscrizione.docx";
// $TBS->Plugin(OPENTBS_MAKE_OPTIMIZED_TEMPLATE, $template, $new_template);


$id = 90;

//Query modificata JM
$sql = "SELECT
                    s.COGNOME,
                    s.NOMESTUD AS NOME,
                    DATE_FORMAT(s.NASCDATA, '%d/%m/%Y') AS NASCDATA,
                    s.NASCCOMUNE,
                    n.DECODIF AS STATO,
                    p.DECODIF AS PROV,
                    c.CITTADINANZA,
                    if(s.CERTNASC_TIPO='PASSAPORTO',
                    s.CERTNASC_TIPO,
                    s.CERTNASC_TIPO_ALTRO) AS TIPO_DOCUMENTO,
                    s.CERTNASC_NUMERO,
                    DATE_FORMAT(s.CERTNASC_DATARILASCIO, '%d/%m/%Y') AS CERTNASC_DATARILASCIO,
                    DATE_FORMAT(s.CERTNASC_DATASCADENZA, '%d/%m/%Y') AS CERTNASC_DATASCADENZA,
                    l.DECODIF AS TIPO_ISCRIZIONE,
                    CONCAT(s.ANNOACCA-1,'-',s.ANNOACCA) AS ANNO1,
                    CONCAT(s.ANNOACCA,'-',s.ANNOACCA+1) AS ANNO2,
                    sc.INIZIOLEZIONI_SEM1,
                    sc.FINELEZIONI_SEM2,
                    if(s.COLLEGIO=0,s.RECPRES,cl.COLLEGIO) AS PRESSO,
                    if(s.COLLEGIO=0,s.RECINDS,cl.INDIRIZZO) AS INDIRIZZO,
                    if(s.COLLEGIO=0,s.RECCOMUNE,cl.COMUNE) AS COMUNE,
                    if(s.COLLEGIO=0,p.DECODIF,pc.DECODIF) AS PROV,
                    if(s.COLLEGIO=0,s.RECCAP,cl.CAP) AS CAP
                FROM studente_preiscrizione s
                LEFT JOIN nazione n ON n.CODICENU=s.NASCNAZI
                LEFT JOIN provincia p ON p.CODICENU=s.RECPROV
                LEFT JOIN nazione c ON c.CODICENU=s.CITTADI2
                INNER JOIN corsidilaurea l ON l.CODICENU=s.CORSOLAUREA
                INNER JOIN scadenze sc ON sc.ANNOACCADEMICO=s.ANNOACCA
                LEFT JOIN collegi cl ON cl.CODICE=s.COLLEGIO
                LEFT JOIN provincia pc ON pc.CODICENU=cl.PROVINCIA
                WHERE s.ID= ?";
               

// Create array or object for data
$stmt = $dbh->prepare($sql);
$stmt->execute([$id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$TBS->VarRef = $row;


// Load template

$TBS->LoadTemplate($template,OPENTBS_ALREADY_UTF8); // Also merge some [onload] automatic fields (depends of the type of document).

// Merge data in the body of the document when there are more records

// $TBS->MergeBlock('blk_res1',$dbh,$sql);


// Opzioni di debug
// $TBS->Plugin(OPENTBS_DEBUG_XML_CURRENT, true); // Display the intented XML of the current sub-file, and exit.
// $TBS->Plugin(OPENTBS_DEBUG_INFO, true); // Display information about the document, and exit.
// $TBS->Plugin(OPENTBS_DEBUG_XML_SHOW); // Tells TBS to display information when the document is merged. No exit.



// -----------------
// Output the result
// -----------------

$output_file_name = $id . "-Certificato preiscrizione";

$TBS->Show(OPENTBS_DOWNLOAD, $output_file_name); // Also merges all [onshow] automatic fields.

?>