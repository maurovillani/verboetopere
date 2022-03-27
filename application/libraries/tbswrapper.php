<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once(APPPATH.'libraries/tbs_us/tbs_class.php');
require_once(APPPATH.'libraries/tbs_us/plugins/tbs_plugin_opentbs.php');

// prevent from a PHP configuration problem when using mktime() and date()
if (version_compare(PHP_VERSION, '5.1.0')>=0) {
    if (ini_get('date.timezone')=='') {
        date_default_timezone_set('UTC');
    }
}

/**
 * Wrapper for Tiny But Strong Class
 * @author  Paolo Minervino <email@email.com>
 */
class Tbswrapper
{
    //ci instance
    //private $CI;

    /**
     * TinyButStrong instance
     *
     * @var object
     */
    private $TBS = null;

    /**
     * default constructor
     *
     */
    public function __construct()
    {
        //$this->CI = &get_instance();

        // Initialize the TBS instance
        if ($this->TBS == null) {
            $this->TBS = new clsTinyButStrong(); // new instance of TBS
        }
    }
    public function tbsInstall_OpenTbsPlugin()
    {
        $this->TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN); // load the OpenTBS plugin
    }

    public function openTBS_Chart($ChartNameOrNum, $SeriesNameOrNum, $NewValues, $NewLegend)
    {
        $this->TBS->PlugIn(OPENTBS_CHART, $ChartNameOrNum, $SeriesNameOrNum, $NewValues, $NewLegend);
    }

    public function openTBS_DeleteComments()
    {
        $this->TBS->PlugIn(OPENTBS_DELETE_COMMENTS);
    }
    
    public function openTBS_Download($output_file_name='')
    {
        if($output_file_name=='')
        $this->TBS->Show(OPENTBS_DOWNLOAD); // Also merges all [onshow] automatic fields.
        else
        $this->TBS->Show(OPENTBS_DOWNLOAD,$output_file_name); // Also merges all [onshow] automatic fields.


        // Be sure that no more output is done, otherwise the download file is corrupted with extra data.
        exit();
    }
    
    public function openTBS_File($output_file_name)
    {
        $this->TBS->Show(OPENTBS_FILE, $output_file_name); // Also merges all [onshow] automatic fields.

        // Be sure that no more output is done, otherwise the download file is corrupted with extra data.
        exit("File [$output_file_name] has been created.");
    }

    // Display the intented XML of the current sub-file, and exit.
    public function openTBS_DEBUG_XML_CURRENT(){
        $this->TBS->Plugin(OPENTBS_DEBUG_XML_CURRENT, true);
    }

    // Display information about the document, and exit.
    public function openTBS_DEBUG_INFO(){
        $this->TBS->Plugin(OPENTBS_DEBUG_INFO, true);
    }

    // Tells TBS to display information when the document is merged. No exit.
    public function openTBS_DEBUG_XML_SHOW(){
        $this->TBS->Plugin(OPENTBS_DEBUG_XML_SHOW);
    }

    public function tbsLoadTemplate1($File)
    {
        return $this->TBS->LoadTemplate($File, OPENTBS_ALREADY_UTF8);
    }

    public function tbsLoadTemplate($File, $HtmlCharSet='')
    {
        return $this->TBS->LoadTemplate($File, $HtmlCharSet);
    }

    public function tbsMergeBlock($BlockName, $Source)
    {
        return $this->TBS->MergeBlock($BlockName, $Source);
    }

    public function tbsMergeField($BaseName, $X)
    {
        return $this->TBS->MergeField($BaseName, $X);
    }

    public function tbsRender()
    {
        $this->TBS->Show(TBS_NOTHING);
        return $this->TBS->Source;
    }
    
    public function tbsData($data)
    {
        $this->TBS->VarRef=array_merge($this->TBS->VarRef, $data);
    }
}
