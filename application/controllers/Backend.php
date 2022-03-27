<?php

defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/tbswrapper.php';

/**
 * Default controller
 */
class Backend extends MY_Controller {

    public $dataset = [];

    public function __construct()
    {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('login', 'refresh');
        }
        if (!$this->ion_auth->is_admin() && !$this->ion_auth->in_group('Backend')) {
            redirect('frontend', 'refresh');
        }
        //$this->data['active_menu'] = 'vuota';
        
        /** Spostate su ci_bootstrap configurazione sezione controller->backend->exceptions... */
        /* $exceptions = [...]; */
        $this->mConfig['controller']['backend']['exceptions'];
        $this->sidebar = $this->buildSidebarMenuWthCurrentUriPermitted($this->mConfig['controller']['backend']['exceptions']);
        $this->data['sidebar'] = $this->buildSidebar($this->sidebar);
    }
    public function getTestData(){
        $this->db->select('CODICECOMUNE as value, DECODIF as label');
        $this->db->FROM('comune');
        $this->db->like('DECODIF', $this->input->post('term'), 'both');
        $this->db->order_by('DECODIF','ASC');
        $this->db->limit(500); //è eccessivo servire tutti i records
        $query = $this->db->get();
        $result = $query->result();
        $this->render_json1($result);
    }

public function pianostudi()
    {
        $this->data['sidebar'] = $this->buildSidebar($this->sidebar, 2);
        $this->load->model('studente_model');
        $this->data['c_metodologia'] = $this->studente_model->listacorsi('Metodologia');
        $this->data['c_antico_testamento'] = $this->studente_model->listacorsi('%');
        $this->data['c_nuovo_testamento'] = $this->studente_model->listacorsi('%');
        
        $myscript_update = '

        $(document).ready(function() {
            var rowId;
            //triggered when modal is about to be shown
            $(\'.modal\').on(\'show.bs.modal\', function(e) {

                //get data-id attribute of the clicked element
                rowId = $(e.relatedTarget).data(\'row-id\');

                //populate the textbox
                //$("#exampleModalCenterTitle.modal-title").text(\'Corso \'+rowId);
                $("#exampleModalCenterTitle.modal-title").text(\'Scelta corso \');
            });
            $(\'.btn-save\').click( function(pao){
                var ref_this = $(pao.currentTarget.parentNode.parentNode).find(".active");
                $(\'.modal\').modal(\'hide\');

                var duplicato=false;
                if(ref_this.length!=0){
                    var codice=$(ref_this[1]).data(\'codice\');
                    $(\'#corsilist tr\').each(function(index) {
                        if (index !== 0) {
                            $row = $(this);
                            var id = $row.find("td:nth-child(2)").text();
                            if (id === codice) {
                                duplicato=true;
                                alert(\'Esame già presente\');
                                return false;
                            }
                        }
                    });
                    
                    if(!duplicato){
                    var cols=$(\'#\'+rowId).children("td");
                    $(cols[0]).text($(ref_this[1]).data(\'codice\'));
                    $(cols[1]).text($(ref_this[1]).data(\'titolo\'));
                    $(cols[2]).text($(ref_this[1]).data(\'prof\'));
                    $(\'#row_\'+rowId).val($(ref_this[1]).data(\'codice\'));
                    }

                }else{
                alert(\'There is no active element\');
                }
            });
        });
        ';
        $this->add_scriptSource($myscript_update);
        $myscript_empty = '
        function corsoDelete(ctl) {
            var row = $(ctl).parents("tr");
            var cols = row.children("td");
            $(cols[0]).text(\'\');
            $(cols[1]).text(\'\');
            $(cols[2]).text(\'\');
            $(\'#row_\'+row[0].id).val(\'\');
        };
        ';
        $this->add_scriptSource($myscript_empty);

        $attributes = array('id' => 'mycorsi');
        $myform = form_open('backend/test_send', $attributes);
        
        $data = array(
            'type'  => 'hidden',
            'name'  => 'row_1',
            'id'    => 'row_1',
            'value' => ''
        );
        $myform .=  form_input($data);

        $data = array(
            'type'  => 'hidden',
            'name'  => 'row_2',
            'id'    => 'row_2',
            'value' => ''
        );
        $myform .=  form_input($data);

        $data = array(
            'type'  => 'hidden',
            'name'  => 'row_3',
            'id'    => 'row_3',
            'value' => ''
        );
        $myform .=  form_input($data);

        $data = [
            'name'          => 'button',
            'id'            => 'button',
            'value'         => 'true',
            'type'          => 'submit',
            'content'       => 'Save',
            'class'         => 'btn btn-primary'
        ];
        $myform .= form_button($data);
        $myform .= form_close();

        $this->data['myform'] = $myform;

        $this->renderView('backend' . DIRECTORY_SEPARATOR . 'pianostudi');
    }
    

    public function pianostudi_studente($id,$corsolaurea)
    {
        $this->data['sidebar'] = $this->buildSidebar($this->sidebar, 2);
        $this->load->model('studente_model');
        $corsi_inseriti=$this->studente_model->tab_pianistudiostudente($id,$corsolaurea);
        $this->data['tab_pianistudiostudente'] = $corsi_inseriti;
        $this->data['listacorsi'] = $this->studente_model->listacorsi('%');
        $schema=$this->studente_model->tab_pianostudi_schema();
        $this->data['tab_pianostudi_schema']=$schema;
        $this->data['studente'] = $this->studente_model->trova_nome_studente_da_matricola($id);
        $this->data['MATRICOLA'] = $id;

        $x=1;
        foreach ($schema as $righe) {
            for ($i=1; $i<=$righe['numero_esami']; $i++) {
                foreach ($corsi_inseriti as $corsi) {
                    if ($x===(int)($corsi['riga'])) {                    
                        $sigla=$corsi['sigla'];
                        $corso=$corsi['DESCRIZIONECORSI'];
                        $professore=$corsi['professore'];
                        $voto=$corsi['voto'];
                        break;
                    }else{
                        $sigla='';
                        $corso='';
                        $professore='';
                        $voto='0';
                    }
                }
                if ($righe['numero_esami']==='1'){
                    $schema_ps[$x][1] = [
                        'pos' => $righe['tipocorso'],
                        'tipocorso' => $righe['tipocorso'],
                        'numero' => $x,
                        'sigla' => $sigla,
                        'corso' => $corso,
                        'professore' => $professore,
                        'riga' => $x,
                        'voto' => $voto
                    ];
                }else{
                    $schema_ps[$x][1] = [
                        'pos' => $righe['tipocorso'].' '.$i,
                        'tipocorso' => $righe['tipocorso'],
                        'numero' => $x,
                        'sigla' => $sigla,
                        'corso' => $corso,
                        'professore' => $professore,
                        'riga' => $i,
                        'voto' => $voto
                    ];
                }
            $x=$x+1;
            }            
        }
        $this->data['schema']=$schema_ps;

        $myscript_update = '

        $(document).ready(function() {
            var rowId;
            //triggered when modal is about to be shown
            $(\'.modal\').on(\'show.bs.modal\', function(e) {

                //get data-id attribute of the clicked element
                rowId = $(e.relatedTarget).data(\'row-id\');

                //populate the textbox
                //$("#exampleModalCenterTitle.modal-title").text(\'Corso \'+rowId);
                $("#exampleModalCenterTitle.modal-title").text(\'Scelta corso \');
            });
            $(\'.btn-save\').click( function(pao){
                var ref_this = $(pao.currentTarget.parentNode.parentNode).find(".active");
                $(\'.modal\').modal(\'hide\');

                var duplicato=false;
                if(ref_this.length!=0){
                    var codice=$(ref_this[1]).data(\'codice\');
                    $(\'#corsilist tr\').each(function(index) {
                        if (index !== 0) {
                            $row = $(this);
                            var id = $row.find("td:nth-child(2)").text();
                            if (id === codice) {
                                duplicato=true;
                                alert(\'Esame già presente\');
                                return false;
                            }
                        }
                    });
                    
                    if(!duplicato){
                    var cols=$(\'#\'+rowId).children("td");
                    $(cols[0]).text($(ref_this[1]).data(\'codice\'));
                    $(cols[1]).text($(ref_this[1]).data(\'titolo\'));
                    $(cols[2]).text($(ref_this[1]).data(\'prof\'));
                    $(\'#row_\'+rowId).val($(ref_this[1]).data(\'codice\'));
                    }

                }else{
                alert(\'There is no active element\');
                }
            });
        });
        ';
        $this->add_scriptSource($myscript_update);
        $myscript_empty = '
        function corsoDelete(ctl) {
            var row = $(ctl).parents("tr");
            var cols = row.children("td");
            $(cols[0]).text(\'\');
            $(cols[1]).text(\'\');
            $(cols[2]).text(\'\');
            $(\'#row_\'+row[0].id).val(\'\');
        };
        ';
        $this->add_scriptSource($myscript_empty);

        $attributes = array('id' => 'mycorsi');
        $myform = form_open('backend/pianostudi_studente_salva', $attributes);

        
        $data = array(
            'type'  => 'hidden',
            'name'  => 'MATRICOL',
            'id'    => 'MATRICOL',
            'value' => $id
        );
        $myform .=  form_input($data);

        $data = array(
            'type'  => 'hidden',
            'name'  => 'CORSOLAU',
            'id'    => 'CORSOLAU',
            'value' => $corsolaurea
        );
        $myform .=  form_input($data);

        $data = array(
            'type'  => 'submit',
            'name'  => 'btnSub',
            'value' => 'Salva',
            'class' => 'btn btn-primary',
        );
        $myform .=  form_input($data);        

        $data = array(
            'type'  => 'submit',
            'name'  => 'btnClose',
            'value' => 'Chiudi',
            'class' => 'btn btn-primary',
        );
        $myform .=  form_input($data);        
        
        foreach ($schema_ps as $numero => $valore) {
            $data = array(
                'type'  => 'hidden',
                'name'  => 'row_'.$numero,
                'id'    => 'row_'.$numero,
                'value' => $valore[1]['sigla']
            );
            $myform .=  form_input($data);            
            $data = array(
                'type'  => 'hidden',
                'name'  => 'old_'.$numero,
                'id'    => 'old_'.$numero,
                'value' => $valore[1]['sigla']
            );
            $myform .=  form_input($data);         
            $data = array(
                'type'  => 'hidden',
                'name'  => 'tipocorso_'.$numero,
                'id'    => 'tipocorso_'.$numero,
                'value' => $valore[1]['tipocorso']
            );
            $myform .=  form_input($data);                  
        }

        $myform .= form_close();

        $this->data['myform'] = $myform;

        $this->renderView('backend' . DIRECTORY_SEPARATOR . 'studente'. DIRECTORY_SEPARATOR . 'pianostudi');
    }
    
    public function pianostudi_studente_salva()
    {
        $this->load->model('studente_model');
        $post=$this->input->post();
        if(isset($post['btnSub'])){
            for ($i=1; $i<=19; $i++) { //trovare il modo di parametrizzare il 19 che è il numero degli esami previsti
                $row=$post['row_'.$i];
                $old=$post['old_'.$i];
                $tipocorso=$post['tipocorso_'.$i];
                if ($old !==''){
                    $this->studente_model->EliminaEsamePianoStudiStudente_old($post['MATRICOL'],$post['CORSOLAU'],$old);
                }
                if ($row !==''){
                    $this->studente_model->InserisciEsamePianoStudiStudente_old($post['MATRICOL'],$post['CORSOLAU'],$row,$tipocorso,$i);
                }
            }
            //redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'studente' . DIRECTORY_SEPARATOR . $post['MATRICOL']));
            //        var_dump($this->input->post());
            //        exit();
            echo "<script>alert('Dati salvati');</script>";
        }    
        echo "<script>window.close();</script>";
        exit();
    }
    public function test()
    {
        $myscript_update = '

        $(document).ready(function() {
            var rowId;
            //triggered when modal is about to be shown
            $(\'.modal\').on(\'show.bs.modal\', function(e) {

                //get data-id attribute of the clicked element
                rowId = $(e.relatedTarget).data(\'row-id\');

                //populate the textbox
                $("#exampleModalCenterTitle.modal-title").text(\'Corso \'+rowId);
            });
            $(\'#close-modal\').click( function(){
                var ref_this = $("div.tab-content").find(".active");
                $(\'.modal\').modal(\'hide\');

                if(ref_this.length!=0){
                    var cols=$(\'#\'+rowId).children("td");
                    $(cols[0]).text(ref_this.data(\'codice\'));
                    $(cols[1]).text(ref_this.data(\'titolo\'));
                    $(cols[2]).text(ref_this.data(\'prof\'));
                    $(\'#row_\'+rowId).val(ref_this.data(\'codice\'));
                }else{
                alert(\'There is no active element\');
                }
            });
        });
        ';
        $this->add_scriptSource($myscript_update);
        $myscript_empty = '
        function corsoDelete(ctl) {
            var row = $(ctl).parents("tr");
            var cols = row.children("td");
            $(cols[0]).text(\'\');
            $(cols[1]).text(\'\');
            $(cols[2]).text(\'\');
            $(\'#row_\'+row[0].id).val(\'\');
        };
        ';
        $this->add_scriptSource($myscript_empty);

        $attributes = array('id' => 'mycorsi');
        $myform = form_open('backend/test_send', $attributes);
        
        $data = array(
            'type'  => 'hidden',
            'name'  => 'row_1',
            'id'    => 'row_1',
            'value' => ''
        );
        $myform .=  form_input($data);

        $data = array(
            'type'  => 'hidden',
            'name'  => 'row_2',
            'id'    => 'row_2',
            'value' => ''
        );
        $myform .=  form_input($data);

        $data = array(
            'type'  => 'hidden',
            'name'  => 'row_3',
            'id'    => 'row_3',
            'value' => ''
        );
        $myform .=  form_input($data);

        $data = [
            'name'          => 'button',
            'id'            => 'button',
            'value'         => 'true',
            'type'          => 'submit',
            'content'       => 'Save',
            'class'         => 'btn btn-primary'
        ];
        $myform .= form_button($data);
        $myform .= form_close();

        $this->data['myform'] = $myform;

        $this->renderView('backend' . DIRECTORY_SEPARATOR . 'paolo');
    }
    public function test_send()
    {
        var_dump($this->input->post());
        exit();
    }
    
    public function test_old()
    {
        $this->load->library('components');
        $this->components->addSearchBoxNew("#txtAllowSearch", "#txtAllowSearchID", base_url("backend/getTestData"));
        $this->components->connectedSortableBox("#sortable1", "#sortable2");
        $this->load->model('studente_model');
        $this->data['rec'] = $this->studente_model->tab_test();

        $myscript = '
            $( function() {
                $("#salva").click(function() {
                    var myarray=[];
                    $("#sortable2").children("li").each(function(){
                        myarray.push($(this).attr("id"));
                        });
                        if (myarray.length>0) {
                            $.post( "'.site_url('backend/edit_record/test/0').'", {data : myarray})
                            .done(function( data ) {
                              alert( "Data Loaded: " + myarray );
                            });
                        }
                        else{
                            alert("Scegliere almeno un corso!");
                        }
                });
            });
        ';
        $this->add_scriptSource($myscript);
        $this->renderView('backend' . DIRECTORY_SEPARATOR . 'paolo');
    }    
    
    public function index() {
//        $this->renderView('backend' . DIRECTORY_SEPARATOR . 'blank');
        $this->home();
    }

    public function error404() {
        $this->renderView('backend' . DIRECTORY_SEPARATOR . '404');
    }

    public function home() {
        $this->load->model('studente_model');
        unset($_SESSION['filtri_scheda_studente']);
        unset($_SESSION['filtri_scheda_professore']);
        unset($_SESSION['post_studenti_ricerca']);
        unset($_SESSION['post_professori_ricerca']);
        $_SESSION['tab_attivo_studente'] = 'tab1';

        if ($this->studente_model->IsSegreteria($_SESSION['user_id'])==='6'){
            $this->data['sidebar'] = $this->buildSidebar($this->sidebar, 2);
            $this->data['tab_anno_accademico'] = $this->studente_model->tab_anno_accademico();
            $this->data['tab_corsidilaurea'] = $this->studente_model->tab_corsidilaurea();
            $this->data['tab_statocivile'] = $this->studente_model->tab_statocivile();
            $this->renderView('backend' . DIRECTORY_SEPARATOR . 'studenti_ricerca');
        }elseif($this->studente_model->IsPreiscrizione($_SESSION['user_id'])==='7'){
            redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'studente_preiscrizione/'.$_SESSION['user_id']));
        }elseif($this->studente_model->IsStudente($_SESSION['user_id'])==='8'){
            $matricola=$this->studente_model->MatricolaUsers($_SESSION['user_id'],'studente');
            redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'self_studente/'.$matricola));
        }elseif($this->studente_model->IsProfessore($_SESSION['user_id'])==='3'){
            $matricola=$this->studente_model->MatricolaUsers($_SESSION['user_id'],'professore');
            redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'self_professore/'.$matricola));
        }elseif($this->studente_model->IsPreside($_SESSION['user_id'])==='10'){
            $this->data['sidebar'] = $this->buildSidebar($this->sidebar, 43);
            redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'datatable' . DIRECTORY_SEPARATOR . 'preiscrizione'));
        }elseif($this->studente_model->IsAmministrazione($_SESSION['user_id'])==='9'){
            $this->data['sidebar'] = $this->buildSidebar($this->sidebar, 43);
            redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'datatable' . DIRECTORY_SEPARATOR . 'preiscrizione'));
        }else{
           $this->renderView('backend' . DIRECTORY_SEPARATOR . 'cartella');
        }
    }

    
    public function home_old() {
        $this->load->model('studente_model');
        $this->data['tab_anno_accademico'] = $this->studente_model->tab_anno_accademico();
        $this->data['tab_corsidilaurea'] = $this->studente_model->tab_corsidilaurea();
        $this->data['tab_statocivile'] = $this->studente_model->tab_statocivile();

        $scriptSource = '
            $(document).ready(function() {
                $(document).on("change", "#ANNOACCA", function(answer) {
                    $("#ANNOACCA2").val(answer.currentTarget.value);
                });
            });
            ';
        $this->add_scriptSource(($scriptSource));
        $scriptSource = '
            $(document).ready(function() {
                $(document).on("change", "#ANNOCORSO", function(answer) {
                    $("#ANNOCORSO2").val(answer.currentTarget.value);
                });
            });
            ';
        $this->add_scriptSource(($scriptSource));
        $scriptSource = '
            $(document).ready(function() {
                $(document).on("change", "#CATEGORIA", function(answer) {
                    $("#CATEGORIA2").val(answer.currentTarget.value);
                });
            });
            ';
        $this->add_scriptSource(($scriptSource));

        $scriptSource = '
            $(document).ready(function() {
                $(document).on("change", "#CORSOLAUREA", function(answer) {
                    $("#CORSOLAUREA2").val(answer.currentTarget.value);
                });
            });
            ';
        $this->add_scriptSource(($scriptSource));

        $scriptSource = '
            $(document).ready(function() {
                $(document).on("change", "#STATOCIV", function(answer) {
                    $("#STATOCIV2").val(answer.currentTarget.value);
                });
            });
            ';
        $this->add_scriptSource(($scriptSource));


        unset($_SESSION['filtri_scheda_studente']);
        unset($_SESSION['filtri_scheda_professore']);
        $_SESSION['tab_attivo_studente'] = 'tab1';

        $this->renderView('backend' . DIRECTORY_SEPARATOR . 'ricerca');
    }

    public function preiscrizione_ricerca_azzera(){
        $this->data['sidebar'] = $this->buildSidebar($this->sidebar, 43);
        unset($_SESSION['post_preiscrizione_ricerca']);
        $this->load->model('studente_model');
        $this->data['tab_anno_accademico'] = $this->studente_model->tab_anno_accademico();
        $this->data['tab_corsidilaurea'] = $this->studente_model->tab_corsidilaurea();
        $this->renderView('backend' . DIRECTORY_SEPARATOR . 'preiscrizione_ricerca');
    }    
    
    public function studenti_ricerca_azzera(){
        $this->data['sidebar'] = $this->buildSidebar($this->sidebar, 2);
        unset($_SESSION['post_studenti_ricerca']);
        $this->load->model('studente_model');
        $this->data['tab_anno_accademico'] = $this->studente_model->tab_anno_accademico();
        $this->data['tab_corsidilaurea'] = $this->studente_model->tab_corsidilaurea();
        $this->renderView('backend' . DIRECTORY_SEPARATOR . 'studenti_ricerca');
    }

    public function preiscrizione_ricerca($azzera='0') {
        $this->load->model('studente_model');
        $this->data['tab_anno_accademico'] = $this->studente_model->tab_anno_accademico();
        $this->data['tab_corsidilaurea'] = $this->studente_model->tab_corsidilaurea();

        unset($_SESSION['filtri_scheda_preiscrizione']);
        if ($azzera=='1'){
            redirect(site_url('backend/preiscrizione_cartella/1'));
        }else{
            $this->renderView('backend' . DIRECTORY_SEPARATOR . 'preiscrizione_ricerca');
        }
    }    
    
    public function studenti_ricerca($azzera='0') {
        $this->load->model('studente_model');
        $this->data['tab_anno_accademico'] = $this->studente_model->tab_anno_accademico();
        $this->data['tab_corsidilaurea'] = $this->studente_model->tab_corsidilaurea();

        unset($_SESSION['filtri_scheda_studente']);
//        unset($_SESSION['post_studenti_ricerca']);
        
/*
            if (isset($_SESSION['post_studenti_ricerca'])){
                $this->data['COGNOME']=$_SESSION['post_studenti_ricerca']['COGNOME'];
                $this->data['MATRICOL']=$_SESSION['post_studenti_ricerca']['MATRICOL'];
                $this->data['ANNOACCA']=$_SESSION['post_studenti_ricerca']['ANNOACCA'];
                $this->data['ANNOCORSO']=$_SESSION['post_studenti_ricerca']['ANNOCORSO'];
                $this->data['CATEGORIA']=$_SESSION['post_studenti_ricerca']['CATEGORIA'];
                $this->data['CORSOLAUREA']=$_SESSION['post_studenti_ricerca']['CORSOLAUREA'];
            }else{
                $this->data['COGNOME']='';
                $this->data['MATRICOL']='';
                $this->data['ANNOACCA']='';
                $this->data['ANNOCORSO']='';
                $this->data['CATEGORIA']='';
                $this->data['CORSOLAUREA']='';
            }  
*/
        if ($azzera=='1'){
            redirect(site_url('backend/studenti_cartella/1'));
        }else{
            $this->renderView('backend' . DIRECTORY_SEPARATOR . 'studenti_ricerca');
        }
    }
    public function preiscrizione_cartella($azzera='0') {
        $this->data['sidebar'] = $this->buildSidebar($this->sidebar, 43);
        $this->load->model('studente_model');
        if ($azzera=='0'){
            $filter = $this->input->post();
        }else{
            $filter['CERTIFICATOPREISCRIZIONE']=$_SESSION['post_preiscrizione_ricerca']['CERTIFICATOPREISCRIZIONE'];
            $filter['CORSOLAUREA']=$_SESSION['post_preiscrizione_ricerca']['CORSOLAUREA'];
        }
        $qry = 'select s.ID from studente_preiscrizione s ';
        $where= ' where s.deleted=0 ';
        $join=' inner join users u ON u.id=s.ID AND u.active=1';
        if (isset($_SESSION['post_preiscrizione_ricerca'])){
            $this->data['CERTIFICATOPREISCRIZIONE']=$_SESSION['post_preiscrizione_ricerca']['CERTIFICATOPREISCRIZIONE'];
            $this->data['CORSOLAUREA']=$_SESSION['post_preiscrizione_ricerca']['CORSOLAUREA'];
        }else{
            $this->data['CERTIFICATOPREISCRIZIONE']='';
            $this->data['CORSOLAUREA']='';
        }
        foreach ($filter as $field => $value) {
            if ($value === 'tutti' || $value===''){
                continue;
            }
            elseif ($field === 'CORSOLAUREA'){
                $where .= " AND s.CORSOLAUREA = ".$value; 
            }
            elseif ($field === 'CERTIFICATOPREISCRIZIONE'){
                $where .= " AND s.CERTIFICATOPREISCRIZIONE='".$value."'" ; 
            }
        }        
        $str_query="SELECT count(*) as nrec from (".$qry.$join.$where.") x"; 
        $query=$this->db->query($str_query);
        $num_rec = $query->row_array(); 
        $_SESSION['post_preiscrizione_ricerca'] = $filter;
//        $_SESSION['tab_attivo_studente'] = 'tab1';
        $_SESSION['numero_record'] = $num_rec['nrec'];
        redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'datatable' . DIRECTORY_SEPARATOR . 'preiscrizione'));
    }

    public function studenti_cartella($azzera='0') {
        $this->data['sidebar'] = $this->buildSidebar($this->sidebar, 2);
        $this->load->model('studente_model');
        if ($azzera=='0'){
            $filter = $this->input->post();
        }else{
                $filter['COGNOME']=$_SESSION['post_studenti_ricerca']['COGNOME'];
                $filter['MATRICOL']=$_SESSION['post_studenti_ricerca']['MATRICOL'];
                $filter['ANNOACCA']=$_SESSION['post_studenti_ricerca']['ANNOACCA'];
                $filter['ANNOCORSO']=$_SESSION['post_studenti_ricerca']['ANNOCORSO'];
                $filter['CATEGORIA']=$_SESSION['post_studenti_ricerca']['CATEGORIA'];
                $filter['CORSOLAUREA']=$_SESSION['post_studenti_ricerca']['CORSOLAUREA'];
        }
        $qry = 'select s.MATRICOL from studente s ';
        $where= ' where s.deleted=0 ';
        $join='';
//        $conta=0;
        $AA=0;
        if (isset($_SESSION['post_studenti_ricerca'])){
            $this->data['COGNOME']=$_SESSION['post_studenti_ricerca']['COGNOME'];
            $this->data['MATRICOL']=$_SESSION['post_studenti_ricerca']['MATRICOL'];
            $this->data['ANNOACCA']=$_SESSION['post_studenti_ricerca']['ANNOACCA'];
            $this->data['ANNOCORSO']=$_SESSION['post_studenti_ricerca']['ANNOCORSO'];
            $this->data['CATEGORIA']=$_SESSION['post_studenti_ricerca']['CATEGORIA'];
            $this->data['CORSOLAUREA']=$_SESSION['post_studenti_ricerca']['CORSOLAUREA'];
        }else{
            $this->data['COGNOME']='';
            $this->data['MATRICOL']='';
            $this->data['ANNOACCA']='';
            $this->data['ANNOCORSO']='';
            $this->data['CATEGORIA']='';
            $this->data['CORSOLAUREA']='';
        }
        foreach ($filter as $field => $value) {
            if ($value === 'tutti' || $value==='')
                continue;
            elseif ($field === 'COGNOME'){
//                $conta=$conta+1;
                $where .= " AND s.COGNOME Like '%".$value."%'"; 
            }
            elseif ($field === 'MATRICOL'){
//                $conta=$conta+1;
                $where .= " AND s.MATRICOL=".$value ; 
            }
            elseif ($field === 'ANNOACCA'){
                $join .= " inner join iscrizionistudente AA on s.MATRICOL=AA.MATRICOL
                           and AA.ANNOACCA=" . $value;
                $AA=1;
            }
            elseif ($field === 'ANNOCORSO' && $AA===1){
                if ($value=='1A'){
                    $join .= " and AA.SEMESTRECORSO in(1,2)";
                }elseif ($value=='2A'){
                    $join .= " and AA.SEMESTRECORSO in(3,4)";
                }elseif($value=='F'){
                    $join .= " and AA.SEMESTRECORSO>4";
                }elseif($value=='1S'){
                    $join .= " and AA.SEMESTRECORSO=1";
                }elseif($value=='2S'){
                    $join .= " and AA.SEMESTRECORSO=2";
                }elseif($value=='3S'){
                    $join .= " and AA.SEMESTRECORSO=3";
                }elseif($value=='4S'){
                    $join .= " and AA.SEMESTRECORSO=4";
                }
            }
            elseif ($field === 'CORSOLAUREA' && $AA===1){
                $join .= " and AA.CORSOLAUREA=" . $value;
            }
        }        
        $num_rec=$this->studente_model->filtro_ricerca_conta($qry.$join.$where);
        $_SESSION['post_studenti_ricerca'] = $filter;
        $_SESSION['tab_attivo_studente'] = 'tab1';
        $_SESSION['numero_record'] = $num_rec['nrec'];
        if ($num_rec['nrec']!=='1'){
            redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'datatable' . DIRECTORY_SEPARATOR . 'studenti'));
        }else{
//            $this->renderView('backend' . DIRECTORY_SEPARATOR . 'studenti_ricerca');
            redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'studente/'.$num_rec['MATRICOL'].'/uno'));
        }
    }
    
    public function studente($id,$upload_errato=NULL) {
        $this->data['sidebar'] = $this->buildSidebar($this->sidebar, 2);
        $uno=0;
        if ($upload_errato=='uno'){
            $upload_errato='';
            $uno=1;
        }
        $this->load->model('studente_model');
        $this->load->model('tabelle_model');
        if ($uno==0){
            $filtro_scheda=$this->input->post();
        }else{
            $filtro_scheda='';
        }
        $qry = 'select studente.* from studente';
        $filter = $_SESSION['post_studenti_ricerca']; //$this->input->post();
        if (isset($filtro_scheda['ValoreFiltro'])){
            $filter['CampoFiltro'] = $filtro_scheda['CampoFiltro'];
            $filter['ValoreFiltro'] = $filtro_scheda['ValoreFiltro'];
            $_SESSION['filtri_scheda_studente']['CampoFiltro']=$filter['CampoFiltro'];
            $_SESSION['filtri_scheda_studente']['ValoreFiltro']=$filter['ValoreFiltro'];
        }
        if (isset($_SESSION['filtri_scheda_studente']['CampoFiltro'])){
            $filter['CampoFiltro'] = $_SESSION['filtri_scheda_studente']['CampoFiltro'];
            $filter['ValoreFiltro'] = $_SESSION['filtri_scheda_studente']['ValoreFiltro'];
            $this->data['ValoreFiltro'] =$_SESSION['filtri_scheda_studente']['ValoreFiltro'];
            $this->data['CampoFiltro'] = $_SESSION['filtri_scheda_studente']['CampoFiltro'];
        }
        $FormLabel = '';
        foreach ($filter as $field => $value) {
            if ($value === 'tutti' || $value==='')
                continue;
            if ($field === 'COGNOME')
                $FormLabel .= ' - cognome: ' . $value;
            if ($field === 'MATRICOL')
                $FormLabel .= ' - matricola: ' . $value;
            if ($field === 'ANNOACCA')
                $FormLabel .= ' - anno accademico: ' . ($value - 1) . '/' . $value;
            if ($field === 'ANNOCORSO')
                switch ($value) {
                    case '1A':
                        $FormLabel .= ' - anno corso: 1';
                        break;
                    case '2A':
                        $FormLabel .= ' - anno corso: 2';
                        break;
                    case 'F':
                        $FormLabel .= ' - semestre corso: fuori corso';
                        break;
                    case '1S':
                        $FormLabel .= ' - semestre corso: 1';
                        break;
                    case '2S':
                        $FormLabel .= ' - semestre corso: 2';
                        break;
                    case '3S':
                        $FormLabel .= ' - semestre corso: 3';
                        break;
                    case '4S':
                        $FormLabel .= ' - semestre corso: 4';
                        break;
                }
            elseif ($field === 'CORSOLAUREA') {
                $value = $this->studente_model->corsodilaurea($value);
                $FormLabel .= ' - corso di laurea: ' . $value['DECODIF'];
            }
        }
        $FormLabel=substr($FormLabel,3);
        $this->data['page_heading'] = 'Studente';
        $this->data['Filtri'] = $FormLabel;

        $where=' where studente.deleted=0 ';
        if (isset($_SESSION['post_studenti_ricerca'])){
            if ($_SESSION['post_studenti_ricerca']['COGNOME']!=='') $where .= " AND studente.COGNOME Like '%".$_SESSION['post_studenti_ricerca']['COGNOME']."%'"; 
            if ($_SESSION['post_studenti_ricerca']['MATRICOL']!=='') $where .= " AND studente.MATRICOL = ".$_SESSION['post_studenti_ricerca']['MATRICOL']; 
        }
        
//        if ($upload_errato!=''){
//            if ($upload_errato!='uploadok'){
//                $this->data['upload_errato']=$upload_errato;
//                $this->data['messaggio']="Caricamento file fallito: tipo di file consentito ".$upload_errato." e la dimensione non deve superiore i 2 megabyte ";
//            }
//            $_SESSION['tab_attivo_studente']='tab6';
//        }  
        
        if ($upload_errato!=''){
            if ($upload_errato!='uploadok'){
                $this->data['upload_errato']=$upload_errato;
                if ($upload_errato=='_File'){
                    $this->data['messaggio']="Caricamento file fallito: tipo di file non consentito la dimensione non deve superiore i 2 megabyte ";
                }elseif ($upload_errato=='FileEsistente'){
//                    $this->data['messaggio']="Caricamento file fallito: esiste già un file con questo nome";
                    $this->data['messaggio']=$_SESSION['avviso_importazione'].", non caricato già presente file con lo stesso nome";
                }else{
                    $this->data['messaggio']="Caricamento file fallito: tipo di file consentito ".$upload_errato." e la dimensione non deve superiore i 2 megabyte ";
                }
            }
            if ($_SESSION['tab_attivo_studente']!='tab20'){
                $_SESSION['tab_attivo_studente']='tab6';
            }
        }        
        
        if ($id === '0') { //id=0 quando dalla scheda si preme per la prima volta il pulsante avanti
            $_SESSION['tab_attivo_studente'] = 'tab1';
            if ($filter['ANNOACCA'] !== 'tutti') {
                $qry = "select studente.* from studente 
                      inner join iscrizionistudente on studente.MATRICOL=iscrizionistudente.MATRICOL
                      and iscrizionistudente.ANNOACCA=" . $filter['ANNOACCA'];
                if ($filter['ANNOCORSO'] !== 'tutti') {
//                    $qry .= " and iscrizionistudente.ANNOCORSO=" . $filter['ANNOCORSO'];// . "'";
                    switch ($value) {
                        case '1A':
                            $qry .= " and iscrizionistudente.SEMESTRECORSO in(1,2)";
                            break;
                        case '2A':
                            $qry .= " and iscrizionistudente.SEMESTRECORSO in(3,4)";
                            break;
                        case 'F':
                            $qry .= " and iscrizionistudente.SEMESTRECORSO>4";
                            break;
                        case '1S':
                            $qry .= " and iscrizionistudente.SEMESTRECORSO=1";
                            break;
                        case '2S':
                            $qry .= " and iscrizionistudente.SEMESTRECORSO=2";
                            break;
                        case '3S':
                            $qry .= " and iscrizionistudente.SEMESTRECORSO=3";
                            break;
                        case '4S':
                            $qry .= " and iscrizionistudente.SEMESTRECORSO=4";
                            break;
                    }
                }
                if ($filter['CORSOLAUREA'] !== 'tutti') {
                    $qry .= " and iscrizionistudente.CORSOLAUREA='" . $filter['CORSOLAUREA'] . "'";
                }
            }
            if (isset($filter['ValoreFiltro'])) {
                if ($filter['ValoreFiltro'] !== '') {
                    if ($filter['CampoFiltro'] === 'MATRICOLA')
                        $where .= " AND studente.MATRICOL=" . $filter['ValoreFiltro'];
                    if ($filter['CampoFiltro'] === 'COGNOME')
                        $where .= " AND studente.COGNOME Like '%" . $filter['ValoreFiltro'] . "%'";
                    $this->data['ValoreFiltro'] = $filter['ValoreFiltro'];
                    $this->data['CampoFiltro'] = $filter['CampoFiltro'];
                }
            }
            $qry .= $where;
            $qry .= " GROUP BY studente.MATRICOL";
            $posizione = '0';
            $pos = '0';
        } else {
            if ($filter['ANNOACCA'] !== 'tutti') {
                $qry = "select studente.* from studente 
                      inner join iscrizionistudente on studente.MATRICOL=iscrizionistudente.MATRICOL
                      and iscrizionistudente.ANNOACCA=" . $filter['ANNOACCA'];
                if ($filter['ANNOCORSO'] !== 'tutti') {
                    switch ($filter['ANNOCORSO']) {
                        case '1A':
                            $qry .= " and iscrizionistudente.SEMESTRECORSO in(1,2)";
                            break;
                        case '2A':
                            $qry .= " and iscrizionistudente.SEMESTRECORSO in(3,4)";
                            break;
                        case 'F':
                            $qry .= " and iscrizionistudente.SEMESTRECORSO>4";
                            break;
                        case '1S':
                            $qry .= " and iscrizionistudente.SEMESTRECORSO=1";
                            break;
                        case '2S':
                            $qry .= " and iscrizionistudente.SEMESTRECORSO=2";
                            break;
                        case '3S':
                            $qry .= " and iscrizionistudente.SEMESTRECORSO=3";
                            break;
                        case '4S':
                            $qry .= " and iscrizionistudente.SEMESTRECORSO=4";
                            break;
                    }
                }
                if ($filter['CORSOLAUREA'] !== 'tutti') {
                    $qry .= " and iscrizionistudente.CORSOLAUREA='" . $filter['CORSOLAUREA'] . "'";
                }
            }
            if (isset($filter['ValoreFiltro'])) {
                if ($filter['ValoreFiltro'] !== '') {
                    if ($filter['CampoFiltro'] === 'MATRICOLA')
                        $where .= " AND studente.MATRICOL=" . $filter['ValoreFiltro'];
                    if ($filter['CampoFiltro'] === 'COGNOME')
                        $where .= " AND studente.COGNOME Like '%" . $filter['ValoreFiltro'] . "%'";
                    $this->data['ValoreFiltro'] = $filter['ValoreFiltro'];
                    $this->data['CampoFiltro'] = $filter['CampoFiltro'];
                }
            }
            $qry .= $where;
            $qry .= " GROUP BY studente.MATRICOL";
            $pos = $this->studente_model->tab_studente_pos($id, $qry);
            if ($pos['row'] === '1') {
                $posizione = '0';
                $pos = '0';
            } else {
                $posizione = $pos['row'];
                $pos = strval(intval($pos['row']) - 2);
            }
        } 
        $this->data['tab_pulsanti_scheda'] = $this->studente_model->tab_pulsanti_scheda_studente($pos, $qry);
        if (isset($this->data['tab_pulsanti_scheda']) && count($this->data['tab_pulsanti_scheda']) !== 0) {
            if (count($this->data['tab_pulsanti_scheda']) === 4) {
                $this->data['tab_pulsanti_scheda']['4']['pos'] = '5';
                $this->data['tab_pulsanti_scheda']['4']['MATRICOL'] = $id;
                $id = $this->data['tab_pulsanti_scheda']['2']['MATRICOL'];
            }
            if ($pos === '0' && $posizione === '0') {
                $this->data['tab_pulsanti_scheda']['3']['MATRICOL'] = $this->data['tab_pulsanti_scheda']['2']['MATRICOL'];
                $this->data['tab_pulsanti_scheda']['2']['MATRICOL'] = $this->data['tab_pulsanti_scheda']['0']['MATRICOL'];
                //$id=$this->data['tab_pulsanti_scheda']['2']['MATRICOL'];
            }
            $id = $this->data['tab_pulsanti_scheda']['2']['MATRICOL'];
        } else {
            $posizione = '-';
        }
        if ($posizione === '0'){
            $posizione = '1';
        }
        $this->data['posizione'] = $posizione;
        $this->data['numero_record'] = $this->studente_model->tab_numero_record($qry);
        if (intval($this->data['numero_record']['rec'])>0){
            $this->data['max_matricola'] = $this->studente_model->tab_max_matricola('studente');
            $this->data['tab_studente'] = $this->studente_model->tab_studente($id);
            $this->data['tab_note_anagrafiche'] = $this->studente_model->tab_note_anagrafiche($id);
            $this->data['tab_statocivile'] = $this->studente_model->tab_statocivile();
            $this->data['tab_iscrizioni'] = $this->studente_model->tab_iscrizioni($id);
            $this->data['tab_tasse'] = $this->studente_model->tab_tasse($id);
            $this->data['tab_corsi'] = $this->studente_model->tab_corsi($id);
            $this->data['tab_titoli_accademici'] = $this->studente_model->tab_titoli_accademici($id);
            $this->data['tab_diocesi'] = $this->studente_model->tab_diocesi($this->data['tab_studente']['DIOCESI']);
            $this->data['tab_ordine'] = $this->studente_model->tab_ordine($this->data['tab_studente']['ORDINE']);
            $this->data['tab_collegio'] = $this->studente_model->tab_collegio($this->data['tab_studente']['COLLEGIO']);
            $this->data['tab_studente_indirizzi_permanenti'] = $this->studente_model->tab_studente_indirizzi_permanenti($this->data['tab_studente']['MATRICOL']);
            $this->data['tab_statodocumenti'] = $this->studente_model->tab_statodocumenti($this->data['tab_studente']['MATRICOL']);
            $this->data['tab_lingue_moderne'] = $this->studente_model->tab_lingue_moderne();

            $this->data['tab_studente_residenza'] = $this->studente_model->tab_dati_nazione($this->data['tab_studente']['RESNAZI']);
            $this->data['tab_studente_residenza']['PROVINCIA'] = $this->studente_model->tab_dati_provincia($this->data['tab_studente']['RESPROV']);

    //        $this->data['tab_studente_recapito'] = $this->studente_model->tab_dati_nazione($this->data['tab_studente']['RECNAZI']);
            $this->data['tab_studente_recapito']['PROVINCIA'] = $this->studente_model->tab_dati_provincia($this->data['tab_studente']['RECPROV']);

            $this->data['tab_studente_nascita'] = $this->studente_model->tab_dati_nazione($this->data['tab_studente']['NASCNAZI']);
            $this->data['tab_studente_nascita']['PROVINCIA'] = $this->studente_model->tab_dati_provincia($this->data['tab_studente']['NASCPROV']);

            //serve per la griglia iscrizioni studente
            $this->data['tab_anno_accademico'] = $this->studente_model->tab_anno_accademico();
            //$this->data['tab_corsidilaurea'] = $this->studente_model->tab_corsidilaurea();
            $this->data['tab_corsidilaurea'] = $this->studente_model->tab_corsidilaurea_da_fare($id);
            $this->data['tab_indirizzolaurea'] = $this->studente_model->tab_indirizzolaurea();
            $this->data['tab_causaletassa'] = $this->studente_model->tab_causaletassa();
            $this->data['tab_posizioneiscrizione'] = $this->studente_model->tab_posizioneiscrizione();
            //serve per la griglia iscrizioni studente
            //serve per la griglia titoli accademici
            $this->data['tab_tipotitolosup'] = $this->studente_model->tab_tipotitolosup();
            $this->data['tab_universitatrasf'] = $this->studente_model->tab_universitatrasf();
            $this->data['tab_tipodocumentazione'] = $this->studente_model->tab_tipodocumentazione();
            $this->data['tab_indirizzolicenza'] = $this->studente_model->tab_indirizzolicenza($this->data['tab_studente']['MATRICOL']);
            $this->data['tab_qualificalicenza'] = $this->studente_model->tab_qualifica($this->data['tab_studente']['MATRICOL'],'210');
            $this->data['tab_qualificadottorato'] = $this->studente_model->tab_qualifica($this->data['tab_studente']['MATRICOL'],'230');
            $this->data['tab_esamidilaurea'] = $this->studente_model->tab_esamidilaurea($this->data['tab_studente']['MATRICOL']);
            $this->data['parametri']=$this->tabelle_model->tab_parametri_iscrizione_corsi();
            //serve per la griglia iscrizioni studente
        }
//// CAMPI DATA
        $this->data['campo_NASCDATA']=$this->ControllaFormatoData('myForm','NASCDATA','data di nascita',true);
        $this->data['campo_DATAAGGIORN']=$this->ControllaFormatoData('myForm','DATAAGGIORN','data aggiornamento dati',false);
        $this->data['campo_datascad_permessosogg']=$this->ControllaFormatoData('myForm','datascad_permessosogg','data scadenza permesso di soggiorno',false);
        $this->data['campo_datascad_extracollegio']=$this->ControllaFormatoData('myForm','datascad_extracollegio','data scadenza extra collegialità',false);
        $this->data['campo_PRIVACY']=$this->ControllaFormatoData('myForm','PRIVACY','data firmato accordo privacy',false);
//// FINE CAMPI DATA        
        
        $this->searchBarsStudente();
        $myreset = '
            $(document).ready(function () {
                $(\'body\').on(\'hidden.bs.modal\', \'.modal\', function () {
                    $(this).removeData(\'bs.modal\');
            });
            });
        ';
        $this->add_scriptSource($myreset);
        ///////////////Cartella File
        if (!is_dir(FCPATH . 'assets/images/students/'.$id.'/')){
            mkdir('./assets/images/students/'.$id);
        }
        if (!is_dir(FCPATH . 'assets/images/students/'.$id.'/File/')){
            mkdir('./assets/images/students/'.$id.'/File');
        }
        $f1 = glob('./assets/images/students/'.$id.'/File/*.*');
        if (isset($f1[0])){
            $this->data['elencofile']=$f1;
        }
        ///////////////
        $this->data['FormNascoste'] = [
            'id' => 'form_nascoste'
        ];
        $this->data['FormNascoste']['html'] = $this->renderView('backend' . DIRECTORY_SEPARATOR . 'studente' . DIRECTORY_SEPARATOR . 'form_nascoste', 'empty', true);

        $this->data['FormNascosteIscrizione'] = [
            'id' => 'form_nascoste_iscrizione'
        ];
        $this->data['FormNascosteIscrizione']['html'] = $this->renderView('backend' . DIRECTORY_SEPARATOR . 'studente' . DIRECTORY_SEPARATOR . 'form_nascoste_iscrizione', 'empty', true);

        $this->data['FormNascosteTitoliAccademici'] = [
            'id' => 'form_nascoste_titoli_accademici'
        ];
        $this->data['FormNascosteTitoliAccademici']['html'] = $this->renderView('backend' . DIRECTORY_SEPARATOR . 'studente' . DIRECTORY_SEPARATOR . 'form_nascoste_titoli_accademici', 'empty', true);

        $this->data['FormNascosteTasse'] = [
            'id' => 'form_nascoste_tasse'
        ];
        $this->data['FormNascosteTasse']['html'] = $this->renderView('backend' . DIRECTORY_SEPARATOR . 'studente' . DIRECTORY_SEPARATOR . 'form_nascoste_tasse', 'empty', true);

        $this->data['FormNascosteCorsi'] = [
            'id' => 'form_nascoste_corsi'
        ];
        $this->data['FormNascosteCorsi']['html'] = $this->renderView('backend' . DIRECTORY_SEPARATOR . 'studente' . DIRECTORY_SEPARATOR . 'form_nascoste_corsi', 'empty', true);
        
        
        $this->data['tab1'] = [
            'id' => 'dati_personali',
            'name' => 'Dati anagrafici'
        ];
        $this->data['tab1']['html'] = $this->renderView('backend' . DIRECTORY_SEPARATOR . 'studente' . DIRECTORY_SEPARATOR . 'dati_personali', 'empty', true);

        $this->data['tab2'] = [
            'id' => 'ordinario_religioso',
            'name' => 'Ordinario religioso'
        ];
        $this->data['tab2']['html'] = $this->renderView('backend' . DIRECTORY_SEPARATOR . 'studente' . DIRECTORY_SEPARATOR . 'ordinario_religioso', 'empty', true);

        $this->data['tab3'] = [
            'id' => 'info_collegio',
            'name' => 'Info collegio'
        ];
        $this->data['tab3']['html'] = $this->renderView('backend' . DIRECTORY_SEPARATOR . 'studente' . DIRECTORY_SEPARATOR . 'info_collegio', 'empty', true);

        $this->data['tab4'] = [
            'id' => 'indirizzi',
            'name' => 'Indirizzi'
        ];
        $this->data['tab4']['html'] = $this->renderView('backend' . DIRECTORY_SEPARATOR . 'studente' . DIRECTORY_SEPARATOR . 'indirizzi', 'empty', true);

        $this->data['tab5']['html'] = $this->renderTab5($id);

        $this->data['tab6'] = [
            'id' => 'documenti_requisiti',
            'name' => 'Documenti requisiti'
        ];
        $this->data['tab6']['html'] = $this->renderView('backend' . DIRECTORY_SEPARATOR . 'studente' . DIRECTORY_SEPARATOR . 'documenti_requisiti', 'empty', true);

        $this->data['tab7']['html'] = $this->renderTab7($id);

        $this->data['tab8']['html'] = $this->renderTab8($id);

        $this->data['tab9']['html'] = $this->renderTab9($id);

        $this->data['tab20'] = [
            'id' => 'file',
            'name' => 'File'
        ];
        $this->data['tab20']['html'] = $this->renderView('backend' . DIRECTORY_SEPARATOR . 'studente' . DIRECTORY_SEPARATOR . 'file', 'empty', true);
        
        if ($uno==1){
            $_SESSION['post_studenti_ricerca']['COGNOME']="";
            $_SESSION['post_studenti_ricerca']['MATRICOL']="";
            $_SESSION['post_studenti_ricerca']['ANNOACCA']="tutti";
            $_SESSION['post_studenti_ricerca']['ANNOCORSO']="tutti";
            $_SESSION['post_studenti_ricerca']['CATEGORIA']="tutti";
            $_SESSION['post_studenti_ricerca']['CORSOLAUREA']="tutti";
        }
        
        $this->renderView('backend' . DIRECTORY_SEPARATOR . 'studente' . DIRECTORY_SEPARATOR . 'studente');
    }

    public function professori_ricerca_azzera(){
        $this->data['sidebar'] = $this->buildSidebar($this->sidebar, 7);
        unset($_SESSION['post_professori_ricerca']);
        $this->load->model('studente_model');
        $this->data['tab_anno_accademico'] = $this->studente_model->tab_anno_accademico();
        $this->renderView('backend' . DIRECTORY_SEPARATOR . 'professori_ricerca');
    }    
    
   public function professori_ricerca() {
        $this->load->model('studente_model');
        $this->data['tab_anno_accademico'] = $this->studente_model->tab_anno_accademico();
//        $this->data['tab_corsidilaurea'] = $this->studente_model->tab_corsidilaurea();
//        $this->data['tab_statocivile'] = $this->studente_model->tab_statocivile();

        unset($_SESSION['filtri_scheda_professore']);
        
        if (isset($_SESSION['post_professori_ricerca'])){
            $this->data['COGNOME']=$_SESSION['post_professori_ricerca']['COGNOME'];
            $this->data['MATRICOL']=$_SESSION['post_professori_ricerca']['MATRICOL'];
            $this->data['ANNOACCA']=$_SESSION['post_professori_ricerca']['ANNOACCA'];
        }else{
            $this->data['COGNOME']='';
            $this->data['MATRICOL']='';
            $this->data['ANNOACCA']='';
        }        
        $this->renderView('backend' . DIRECTORY_SEPARATOR . 'professori_ricerca');
    }    
    
    public function professori_cartella() {
        $this->data['sidebar'] = $this->buildSidebar($this->sidebar, 7);
        $this->load->model('studente_model');
        $filter = $this->input->post();
        $qry = 'select p.MATRICOL from professore p ';
        $where= ' where p.deleted=0 ';
        $join='';
        $group='';
//        $conta=0;
        if (isset($_SESSION['post_professori_ricerca'])){
            $this->data['COGNOME']=$_SESSION['post_professori_ricerca']['COGNOME'];
            $this->data['MATRICOL']=$_SESSION['post_professori_ricerca']['MATRICOL'];
            $this->data['ANNOACCA']=$_SESSION['post_professori_ricerca']['ANNOACCA'];
        }else{
            $this->data['COGNOME']='';
            $this->data['MATRICOL']='';
            $this->data['ANNOACCA']='';
        }
        foreach ($filter as $field => $value) {
            if ($value === 'tutti' || $value==='')
                continue;
            elseif ($field === 'COGNOME'){
//                $conta=$conta+1;
                $where .= " AND p.COGNOME Like '%".$value."%'"; 
            }
            elseif ($field === 'MATRICOL'){
//                $conta=$conta+1;
                $where .= " AND p.MATRICOL=".$value ; 
            }
            elseif ($field === 'ANNOACCA'){
                $join=" INNER JOIN professore_materia m ON m.MATRICOL=p.MATRICOL AND m.ANNOACCA=" . $value;
                $group=" GROUP BY p.MATRICOL";
            }
        }        
        $num_rec=$this->studente_model->filtro_ricerca_conta($qry.$join.$where.$group);
        $_SESSION['post_professori_ricerca'] = $filter;
        $_SESSION['numero_record'] = $num_rec['nrec'];
        if ($num_rec['nrec']!=='1'){
            redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'datatable' . DIRECTORY_SEPARATOR . 'professori'));
        }else{
            redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'professore/'.$num_rec['MATRICOL']));
        }
    }
    
    
    public function professore($id) {
        //serve soltanto  come riferimento visivo per chi sta lavorando
        $this->data['sidebar'] = $this->buildSidebar($this->sidebar, 7);
        $this->load->model('studente_model');
        $filtro_scheda=$this->input->post();
        $qry = 'select professore.* from professore ';
        $filter = $_SESSION['post_professori_ricerca']; //$this->input->post();
        if (isset($filtro_scheda['ValoreFiltro'])){
            $filter['CampoFiltro'] = $filtro_scheda['CampoFiltro'];
            $filter['ValoreFiltro'] = $filtro_scheda['ValoreFiltro'];
            $_SESSION['filtri_scheda_professore']['CampoFiltro']=$filter['CampoFiltro'];
            $_SESSION['filtri_scheda_professore']['ValoreFiltro']=$filter['ValoreFiltro'];
        }
        if (isset($_SESSION['filtri_scheda_professore']['CampoFiltro'])){
            $filter['CampoFiltro'] = $_SESSION['filtri_scheda_professore']['CampoFiltro'];
            $filter['ValoreFiltro'] = $_SESSION['filtri_scheda_professore']['ValoreFiltro'];
            $this->data['ValoreFiltro'] =$_SESSION['filtri_scheda_professore']['ValoreFiltro'];
            $this->data['CampoFiltro'] = $_SESSION['filtri_scheda_professore']['CampoFiltro'];
        }
        $FormLabel = '';

        foreach ($filter as $field => $value) {
            if ($value === 'tutti' || $value==='')
                continue;
            if ($field === 'COGNOME')
                $FormLabel .= ' - cognome: ' . $value;
            if ($field === 'MATRICOL')
                $FormLabel .= ' - matricola: ' . $value;
            if ($field === 'ANNOACCA')
                $FormLabel .= ' - anno accademico: ' . ($value - 1) . '/' . $value;
        }
         $FormLabel=substr($FormLabel,3);
        $this->data['page_heading'] = 'Professore';
        $this->data['Filtri'] = substr($FormLabel, 3);

        $where=' where professore.deleted=0 ';
        if (isset($_SESSION['post_professori_ricerca'])){
            if ($_SESSION['post_professori_ricerca']['COGNOME']!=='') $where .= " AND professore.COGNOME Like '%".$_SESSION['post_professori_ricerca']['COGNOME']."%'"; 
            if ($_SESSION['post_professori_ricerca']['MATRICOL']!=='') $where .= " AND professore.MATRICOL = ".$_SESSION['post_professori_ricerca']['MATRICOL']; 
        }
        
        if ($id === '0') {
            if ($filter['ANNOACCA'] !== 'tutti') {
                $qry = "select professore.* from professore 
                      inner join professore_materia  ON professore_materia.MATRICOL=professore.MATRICOL
                      and professore_materia.ANNOACCA=" . $filter['ANNOACCA'];
            }
            if (isset($filter['ValoreFiltro'])) {
                if ($filter['ValoreFiltro'] !== '') {
                    if ($filter['CampoFiltro'] === 'MATRICOLA')
                        $where .= " AND professore.MATRICOL=" . $filter['ValoreFiltro'];
                    if ($filter['CampoFiltro'] === 'COGNOME')
                        $where .= " AND professore.COGNOME Like '%" . $filter['ValoreFiltro'] . "%'";
                    $this->data['ValoreFiltro'] = $filter['ValoreFiltro'];
                    $this->data['CampoFiltro'] = $filter['CampoFiltro'];
                }
            }
            $qry .= $where;
            $qry .= " GROUP BY professore.MATRICOL";
            $posizione = '0';
            $pos = '0';
        } else {
            if(!isset($filter['ANNOACCA'])) $filter['ANNOACCA']='tutti';
            if ($filter['ANNOACCA'] !== 'tutti') {
                $qry = "select professore.* from professore 
                      inner join professore_materia ON professore_materia.MATRICOL=professore.MATRICOL
                      and professore_materia.ANNOACCA=" . $filter['ANNOACCA'];
            }
            if (isset($filter['ValoreFiltro'])) {
                if ($filter['ValoreFiltro'] !== '') {
                    if ($filter['CampoFiltro'] === 'MATRICOLA')
                        $where .= " AND professore.MATRICOL=" . $filter['ValoreFiltro'];
                    if ($filter['CampoFiltro'] === 'COGNOME')
                        $where .= " AND professore.COGNOME Like '%" . $filter['ValoreFiltro'] . "%'";
                    $this->data['ValoreFiltro'] = $filter['ValoreFiltro'];
                    $this->data['CampoFiltro'] = $filter['CampoFiltro'];
                }
            }
            $qry .= $where;
            $qry .= " GROUP BY professore.MATRICOL";
            $pos = $this->studente_model->tab_professore_pos($id, $qry);
            if ($pos['row'] === '1') {
                $posizione = '0';
                $pos = '0';
            } else {
                $posizione = $pos['row'];
                $pos = strval(intval($pos['row']) - 2);
            }
        } 
        $this->data['tab_pulsanti_scheda'] = $this->studente_model->tab_pulsanti_scheda_professore($pos, $qry);
        if (isset($this->data['tab_pulsanti_scheda']) && count($this->data['tab_pulsanti_scheda']) !== 0) {
            if (count($this->data['tab_pulsanti_scheda']) === 4) {
                $this->data['tab_pulsanti_scheda']['4']['pos'] = '5';
                $this->data['tab_pulsanti_scheda']['4']['MATRICOL'] = $id;
                $id = $this->data['tab_pulsanti_scheda']['2']['MATRICOL'];
            }
            if ($pos === '0' && $posizione === '0') {
                $this->data['tab_pulsanti_scheda']['3']['MATRICOL'] = $this->data['tab_pulsanti_scheda']['2']['MATRICOL'];
                $this->data['tab_pulsanti_scheda']['2']['MATRICOL'] = $this->data['tab_pulsanti_scheda']['0']['MATRICOL'];
                //$id=$this->data['tab_pulsanti_scheda']['2']['MATRICOL'];
            }
            $id = $this->data['tab_pulsanti_scheda']['2']['MATRICOL'];
        } else {
            $posizione = '-';
        }
        if ($posizione === '0')
            $posizione = '1';
        $this->data['posizione'] = $posizione;
        $this->data['numero_record'] = $this->studente_model->tab_numero_record($qry);
        $this->data['max_matricola'] = $this->studente_model->tab_max_matricola('professore');
        $this->data['tab_professore'] = $this->studente_model->tab_professore($id);
        $this->data['tab_statocivile'] = $this->studente_model->tab_statocivile();
        $this->data['tab_diocesi'] = $this->studente_model->tab_diocesi($this->data['tab_professore']['DIOCESI']);
        $this->data['tab_ordine'] = $this->studente_model->tab_ordine($this->data['tab_professore']['ORDIPROF']);

        $this->data['tab_professore_residenza'] = $this->studente_model->tab_dati_nazione($this->data['tab_professore']['RESNAZI']);
        $this->data['tab_professore_residenza']['PROVINCIA'] = $this->studente_model->tab_dati_provincia($this->data['tab_professore']['RESPROV']);

        $this->data['tab_professore_recapito'] = $this->studente_model->tab_dati_nazione($this->data['tab_professore']['RECNAZI']);
        $this->data['tab_professore_recapito']['PROVINCIA'] = $this->studente_model->tab_dati_provincia($this->data['tab_professore']['RECPROV']);

        $this->data['tab_professore_nascita'] = $this->studente_model->tab_dati_nazione($this->data['tab_professore']['NASCNAZI']);
        $this->data['tab_professore_nascita']['PROVINCIA'] = $this->studente_model->tab_dati_provincia($this->data['tab_professore']['NASCPROV']);

//// CAMPI DATA
        $this->data['campo_NASCDATA']=$this->ControllaFormatoData('myForm','NASCDATA','data di nascita',true);
//        $this->data['campo_DATAAGGIORN']=$this->ControllaFormatoData('myForm','DATAAGGIORN','data aggiornamento dati',false);
//        $this->data['campo_datascad_permessosogg']=$this->ControllaFormatoData('myForm','datascad_permessosogg','data scadenza permesso di soggiorno',false);
//        $this->data['campo_datascad_extracollegio']=$this->ControllaFormatoData('myForm','datascad_extracollegio','data scadenza extra collegialità',false);
//        $this->data['campo_PRIVACY']=$this->ControllaFormatoData('myForm','PRIVACY','data firmato accordo privacy',false);
//// FINE CAMPI DATA        
        
        $this->searchBarsProfessore();

        $this->data['FormNascoste'] = [
            'id' => 'form_nascoste'
        ];
        $this->data['FormNascoste']['html'] = $this->renderView('backend' . DIRECTORY_SEPARATOR . 'professore' . DIRECTORY_SEPARATOR . 'form_nascoste', 'empty', true);

        $this->data['tab1'] = [
            'id' => 'dati_personali',
            'name' => 'Dati anagrafici'
        ];
        $this->data['tab1']['html'] = $this->renderView('backend' . DIRECTORY_SEPARATOR . 'professore' . DIRECTORY_SEPARATOR . 'dati_personali', 'empty', true);

        $this->data['tab2'] = [
            'id' => 'indirizzi',
            'name' => 'Indirizzi'
        ];
        $this->data['tab2']['html'] = $this->renderView('backend' . DIRECTORY_SEPARATOR . 'professore' . DIRECTORY_SEPARATOR . 'indirizzi', 'empty', true);
        $this->renderView('backend' . DIRECTORY_SEPARATOR . 'professore' . DIRECTORY_SEPARATOR . 'professore');
    }

    private function searchBarsProfessore() {
        $this->load->library('components');
        
        $this->components->addSearchBoxNew("#provincia","#ID_provincia",base_url("backend/getLists/provincia"));
        $this->components->addSearchBoxNew("#provinciaresidenza","#ID_provinciaresidenza",base_url("backend/getLists/provincia"));
        $this->components->addSearchBoxNew("#provinciarecapito","#ID_provinciarecapito",base_url("backend/getLists/provincia"));
        $this->components->addSearchBoxNew("#nazione","#ID_nazione",base_url("backend/getLists/nazione"));
        $this->components->addSearchBoxNew("#nazioneresidenza","#ID_nazioneresidenza",base_url("backend/getLists/nazione"));
        $this->components->addSearchBoxNew("#nazionerecapito","#ID_nazionerecapito",base_url("backend/getLists/nazione"));
        
        //QUESTO BLOCCO VA A POPOLARE LE CASELLE CITTADINANZA_NASCITA,CONTINENTE_NASCITA
        $scriptSource = '
            $(document).ready(function() {
                $(document).on("change", "#ID_nazione", function(answer) {
                    var selected = answer.currentTarget;
                    var id=selected.value;
                    $.post("' . site_url('backend/getLists/nazionedati') . '", { term: selected.value }).done(function(data) {
                        $("#CITTADINANZA_NASCITA").val(data[\'nazionalita\']);
                    });
                });
            });
            ';
        $this->add_scriptSource(($scriptSource));
        //FINE BLOCCO CHE VA A POPOLARE ALTRE CASELLE

        $this->components->addSearchBoxNew("#cittadinanza","#ID_cittadinanza",base_url("backend/getLists/cittadinanza"));

        $this->components->addSearchBoxNew("#ordine","#ID_ordine",base_url("backend/getLists/ordine"));
        $this->components->addSearchBoxNew("#diocesi","#ID_diocesi",base_url("backend/getLists/diocesi"));
    }

    private function searchBarsStudente() {
        $this->load->library('components');
        $this->components->addSearchBoxNew("#provincia","#ID_provincia",base_url("backend/getLists/provincia"));
        $this->components->addSearchBoxNew("#provinciaresidenza","#ID_provinciaresidenza",base_url("backend/getLists/provincia"));
        $this->components->addSearchBoxNew("#provinciarecapito","#ID_provinciarecapito",base_url("backend/getLists/provincia"));
        $this->components->addSearchBoxNew("#nazione","#ID_nazione",base_url("backend/getLists/nazione"));
        $this->components->addSearchBoxNew("#nazioneresidenza","#ID_nazioneresidenza",base_url("backend/getLists/nazione"));

        //QUESTO BLOCCO VA A POPOLARE LE CASELLE CITTADINANZA_NASCITA,CONTINENTE_NASCITA
        $scriptSource = '
            $(document).ready(function() {
                $(document).on("change", "#ID_nazione", function(answer) {
                    var selected = answer.currentTarget;
                    var id=selected.value;
                    $.post("' . site_url('backend/getLists/nazionedati') . '", { term: selected.value }).done(function(data) {
                        $("#CITTADINANZA_NASCITA").val(data[\'nazionalita\']);
                        $("#CONTINENTE_NASCITA").val(data[\'continente\']);
                    });
                });
            });
            ';
        $this->add_scriptSource(($scriptSource));
        //FINE BLOCCO CHE VA A POPOLARE ALTRE CASELLE

        $this->components->addSearchBoxNew("#cittadinanza","#ID_cittadinanza",base_url("backend/getLists/cittadinanza"));

        //QUESTO BLOCCO VA A POPOLARE LA CASELLA CONTINENTE ATTUALE
        $scriptSource = '
            $(document).ready(function() {
                $(document).on("change", "#ID_cittadinanza", function(answer) {
                    var selected = answer.currentTarget;
                    var id=selected.value;
                    $.post("' . site_url('backend/getLists/continente') . '", { term: selected.value }).done(function(data) {
                        $("#CONTINENTE_ATTUALE").val(data[\'continente\']);
                    });
                });
            });
            ';
        $this->add_scriptSource(($scriptSource));
        //FINE BLOCCO CHE VA A POPOLARE CONTINENTE ATTUALE

        //QUESTO BLOCCO VA A POPOLARE LA CASELLA CONTINENTE RESIDENZA
        $scriptSource = '
            $(document).ready(function() {
                $(document).on("change", "#ID_nazioneresidenza", function(answer) {
                    var selected = answer.currentTarget;
                    var id=selected.value;
                    $.post("' . site_url('backend/getLists/continente') . '", { term: selected.value }).done(function(data) {
                        $("#CONTINENTE_RESIDENZA").val(data[\'continente\']);
                    });
                });
            });
            ';
        $this->add_scriptSource(($scriptSource));
        //FINE BLOCCO CHE VA A POPOLARE CONTINENTE ATTUALE
        
        $this->components->addSearchBoxNew("#ordine","#ID_ordine",base_url("backend/getLists/ordine"));
        $this->components->addSearchBoxNew("#diocesi","#ID_diocesi",base_url("backend/getLists/diocesi"));
        $this->components->addSearchBoxNew("#collegio","#ID_collegio",base_url("backend/getLists/collegio"));

        //QUESTO BLOCCO VA A POPOLARE LE CASELLE DEL COLLEGIO
        $scriptSource = '
            $(document).ready(function() {
                $(document).on("change", "#ID_collegio", function(answer) {
                    var selected = answer.currentTarget;
                    var id=selected.id;
                    $.post("' . site_url('backend/getLists/collegiodati') . '", { term: selected.value }).done(function(data) {
                        $("#INDIRIZZO_COLLEGIO").val(data[\'INDIRIZZO\']);
                        $("#collegio").val(data[\'COLLEGIO\']);
                        $("#NOME_COLLEGIO").val(data[\'NOME_COLLEGIO\']);
                        $("#CAP_COLLEGIO").val(data[\'CAP\']);
                        $("#codice_pug").val(data[\'codice_pug\']);
                        $("#COMUNE_COLLEGIO").val(data[\'COMUNE\']);
                        $("#PROVINCIA_COLLEGIO").val(data[\'PROVINCIA\']);
                        $("#TELEFONO_COLLEGIO").val(data[\'TELEFONO\']);
                        $("#RETTORE_COLLEGIO").val(data[\'rettore\']);
                        $("#email_rettore").val(data[\'email_rettore\']);
                        $("#tel_rettore").val(data[\'tel_rettore\']);
                        $("#DIRETTORE_STUDI").val(data[\'direttore_studi\']);
                        $("#email_dirstudi").val(data[\'email_dirstudi\']);
                        $("#tel_dirstudi").val(data[\'tel_dirstudi\']);
                        $("#NOTE_COLLEGIO").val(data[\'note\']);
                    });
                });
            });
            ';
        $this->add_scriptSource(($scriptSource));
        
        $this->components->addSearchBoxNew("#istituzioneprovenienza","#ID_istituzioneprovenienza",base_url("backend/getLists/istituzioneprovenienza"));
        //QUESTO BLOCCO VA A POPOLARE LE CRUIPRO e Accordo_mobil
        $scriptSource = '
            $(document).ready(function() {
                $(document).on("change", "#ID_istituzioneprovenienza", function(answer) {
                    var selected = answer.currentTarget;
                    var id=selected.id;
                    $.post("' . site_url('backend/getLists/istituzioneprovenienzadati') . '", { term: selected.value }).done(function(data) {
                        $("#CRUIPRO").val(data[\'CRUIPRO\']);
                        $("#Accordo_mobil").val(data[\'Accordo_mobil\']);
                    });
                });
            });
            ';
        $this->add_scriptSource(($scriptSource));        
    }

    private function renderTab5($id) {
        /**
         * TAB5
         */
        //$this->data['tab_titoli_accademici'] = $this->studente_model->tab_titoli_accademici($id);
        $this->data['tab5'] = [
            'id' => 'titoli_accademici',
            'name' => 'Titoli accademici'
        ];
        $this->load->library('components');
        $this->components->addDataTablePanel('titoliAccademici');
        return $this->renderView('backend' . DIRECTORY_SEPARATOR . 'studente' . DIRECTORY_SEPARATOR . 'titoli_accademici', 'empty', true);
    }

    private function renderTab7($id) {
        /**
         * TAB7
         */
//        $this->data['tab_iscrizioni'] = $this->studente_model->tab_iscrizioni($id);
        $this->data['tab7'] = [
            'id' => 'dati_iscrizione',
            'name' => 'Iscrizione'
        ];
        $this->load->library('components');
        $this->components->addDataTablePanel('datiIscrizione');
        return $this->renderView('backend' . DIRECTORY_SEPARATOR . 'studente' . DIRECTORY_SEPARATOR . 'dati_iscrizione', 'empty', true);
    }

    private function renderTab8($id) {
        $this->data['tab8'] = [
            'id' => 'tasse',
            'name' => 'Conto economico'
        ];
        $this->load->library('components');
        $this->components->addDataTablePanel('Tasse');
        return $this->renderView('backend' . DIRECTORY_SEPARATOR . 'studente' . DIRECTORY_SEPARATOR . 'tasse', 'empty', true);
    }

    private function renderTab9($id) {
        $this->data['tab9'] = [
            'id' => 'corsi',
            'name' => 'Corsi'
        ];
        $this->load->library('components');
        $this->components->addDataTablePanel('Corsi');
        return $this->renderView('backend' . DIRECTORY_SEPARATOR . 'studente' . DIRECTORY_SEPARATOR . 'corsi', 'empty', true);
    }

    
    public function iscrizionistudente($id, $annoaccademico) {
        //serve soltanto  come riferimento visivo per chi sta lavorando
        $this->data['sidebar'] = $this->buildSidebar($this->sidebar, 2);
        $this->data['page_heading'] = 'Iscrizione studente';

        $this->load->model('studente_model');
        $this->data['tab_iscrizioni'] = $this->studente_model->tab_iscrizione($id, $annoaccademico);
        $this->data['tab_anno_accademico'] = $this->studente_model->tab_anno_accademico();
        $this->data['tab_corsidilaurea'] = $this->studente_model->tab_corsidilaurea();
        $this->data['tab_indirizzolaurea'] = $this->studente_model->tab_indirizzolaurea();

        $this->renderView('backend' . DIRECTORY_SEPARATOR . 'studente' . DIRECTORY_SEPARATOR . 'iscrizionistudente');
    }

    public function collegio($id) {
        //serve soltanto  come riferimento visivo per chi sta lavorando
        $this->data['sidebar'] = $this->buildSidebar($this->sidebar, 35);
        $this->data['page_heading'] = 'Collegio';

        $this->load->model('tabelle_model');
        $this->data['tab_collegio'] = $this->tabelle_model->tab_collegio($id);

        $this->load->library('components');
        $this->components->addSearchBoxNew("#provincia","#ID_provincia",base_url("backend/getLists/provincia"));

        $this->renderView('backend' . DIRECTORY_SEPARATOR . 'tabelle' . DIRECTORY_SEPARATOR . 'collegio');
    }

    public function new_record($nomeTabella) {
        $this->load->model('tabelle_model');
        $this->load->model('studente_model');
        $post = $this->input->post();
        switch ($nomeTabella) {
//            case 'provincia':
//                $this->tabelle_model->SalvaModificaProvincia($id, $post);
//                redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'datatable' . DIRECTORY_SEPARATOR . 'province'));
//                break;
            case 'studente':
                $this->studente_model->SalvaNuovoStudente($post);
                redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'studente' . DIRECTORY_SEPARATOR . $post['MATRICOL']));
                break;
            case 'iscrizionistudente':
                $this->studente_model->SalvaNuovaIscrizioniStudente($post);
                //$this->studente_model->SalvaNuovaTassaSelfStudenteAutomatica($post);
                $_SESSION['tab_attivo_studente'] = 'tab7';
                redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'studente' . DIRECTORY_SEPARATOR . $post['MATRICOL']));
                break;
            case 'iscrizioniselfstudente':
                $this->studente_model->SalvaNuovaIscrizioniStudente($post);
                $this->studente_model->SalvaNuovaTassaSelfStudenteAutomatica($post);
                $_SESSION['tab_attivo_studente'] = 'tab7';
                redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'self_studente' . DIRECTORY_SEPARATOR . $post['MATRICOL']));
                break;
            case 'iscrizionisemestre':
                $this->studente_model->SalvaNuovaIscrizioniSemestre($post);
                $_SESSION['tab_attivo_studente'] = 'tab7';
                redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'studente' . DIRECTORY_SEPARATOR . $post['MATRICOL']));
                break;
            case 'iscrizioniselfstudentesemestre':
                $this->studente_model->SalvaNuovaIscrizioniSemestre($post);
                $_SESSION['tab_attivo_studente'] = 'tab7';
                redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'self_studente' . DIRECTORY_SEPARATOR . $post['MATRICOL']));
                break;
            case 'esamistudente':
                $this->studente_model->SalvaNuovoCorsoStudente($post);
                $_SESSION['tab_attivo_studente'] = 'tab9';
//                redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'studente' . DIRECTORY_SEPARATOR . $post['MATRICOL']));
                redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'studente' . DIRECTORY_SEPARATOR . $post['MATRICOL']), 'refresh');
                break;
            case 'tassestudente':
                $this->studente_model->SalvaNuovaTassaStudente($post);
                $_SESSION['tab_attivo_studente'] = 'tab8';
                redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'studente' . DIRECTORY_SEPARATOR . $post['MATRICOL']));
                break;
            case 'tasseselfstudente':
                $this->studente_model->SalvaNuovaTassaSelfStudente($post);
                $_SESSION['tab_attivo_studente'] = 'tab8';
                redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'self_studente' . DIRECTORY_SEPARATOR . $post['MATRICOL']));
                break;
            case 'titolistudente':
                $this->studente_model->SalvaNuovoTitoloStudente($post);
                $_SESSION['tab_attivo_studente'] = 'tab5';
                redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'studente' . DIRECTORY_SEPARATOR . $post['MATRICOL']));
                break;
            case 'titolistudente_preiscrizione':
                $this->studente_model->SalvaNuovoTitoloStudentePreiscrizione($post);
                $_SESSION['tab_attivo_studente'] = 'tab5';
                redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'studente_preiscrizione' . DIRECTORY_SEPARATOR . $post['ID']));
                break;
            case 'professore':
                $this->studente_model->SalvaNuovoProfessore($post);
                redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'professore' . DIRECTORY_SEPARATOR . $post['MATRICOL']));
                break;
            case 'collegio':
                $this->tabelle_model->SalvaNuovoCollegio($post);
                redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'collegio' . DIRECTORY_SEPARATOR . $post['CODICE']));
                break;
            case 'diocesi':
                $this->tabelle_model->SalvaNuovaDiocesi($id, $post);
                redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'datatable' . DIRECTORY_SEPARATOR . 'diocesis'));
                break;
            case 'ordine':
                $this->tabelle_model->SalvaNuovoOrdine($post);
                redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'datatable' . DIRECTORY_SEPARATOR . 'ordini'));
                break;
            case 'statocivile':
                $this->tabelle_model->SalvaNuovoStatoCivile($post);
                redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'datatable' . DIRECTORY_SEPARATOR . 'statocivili'));
                break;   
            case 'importitasse':
                $this->tabelle_model->SalvaNuovoImportoTasse($post);
                redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'datatable' . DIRECTORY_SEPARATOR . 'importotasse'));
                break;   
            case 'duplicaimportitasse':
                $this->tabelle_model->DuplicaImportiTasse($post);
                redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'datatable' . DIRECTORY_SEPARATOR . 'importotasse'));
                break;   
            case 'scadenze':
                $this->tabelle_model->SalvaNuovaScadenza($post);
                redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'datatable' . DIRECTORY_SEPARATOR . 'scadenze'));
                break;   
            case 'duplicascadenze':
                $this->tabelle_model->DuplicaScadenze($post);
                redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'datatable' . DIRECTORY_SEPARATOR . 'scadenze'));
                break;   
        }
    }

    public function edit_record($nomeTabella, $id) {
        $this->load->model('tabelle_model');
        $this->load->model('studente_model');
        $post = $this->input->post();
        switch ($nomeTabella) {
            case 'studente':
                $this->studente_model->SalvaModificaStudente($id, $post);
                $this->studente_model->SalvaNoteAnagrafiche($id, $post);
                $this->studente_model->SalvaModificaStudenteIndirizziPermanenti($id, $post);
                $this->studente_model->SalvaModificaStatoDocumenti($id, $post);
                redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'studente' . DIRECTORY_SEPARATOR . $post['MATRICOL']));
                break;
            case 'self_studente':
                $this->studente_model->SalvaModificaStudente($id, $post);
                $this->studente_model->SalvaNoteAnagrafiche($id, $post);
                $this->studente_model->SalvaModificaStudenteIndirizziPermanenti($id, $post);
                $this->studente_model->SalvaModificaStatoDocumenti($id, $post);
                redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'self_studente' . DIRECTORY_SEPARATOR . $post['MATRICOL']));
                break;
            case 'preiscrizione_studente':
                $this->studente_model->SalvaModificaStudentePreiscrizione($id, $post);
                redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'studente_preiscrizione' . DIRECTORY_SEPARATOR . $id));
                break;
            case 'preiscrizione_studente_prima':
                $this->studente_model->SalvaModificaStudentePreiscrizionePrima($id, $post);
                if($post['CERTIFICATOPREISCRIZIONE']==='S' && $this->studente_model->IsPreiscrizione($_SESSION['user_id'])==='7' && isset($post['COLLEGIO']) && $post['EMAIL_CERTIFICATO']=='N'){
                    $identity=$post['NOMESTUD'].' '.$post['COGNOME'];
                    redirect(site_url('create_email_richiesta_certificato_preiscrizione' . DIRECTORY_SEPARATOR . $id. DIRECTORY_SEPARATOR .$identity.'/'.$post['LINGUA']));
                }else{
                    redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'studente_preiscrizione' . DIRECTORY_SEPARATOR . $id.'/NULL/'.$post['LINGUA']));
                }
                break;
            case 'preiscrizione_studente_corsolaurea':
                $this->studente_model->SalvaModificaStudentePreiscrizioneCorsoLaurea($id);
                redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'studente_preiscrizione' . DIRECTORY_SEPARATOR . $id));
                break;
            case 'parametri_preiscrizione':
                $this->tabelle_model->SalvaModificaParametriPreiscrizione($post);
                redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'parametri_preiscrizione'));
                break;     
            case 'parametri_iscrizione_corsi':
                $this->tabelle_model->SalvaModificaParametriIscrizioneCorsi($post);
                redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'parametri_iscrizione_corsi'));
                break;     
            case 'verificapassaggiosemestrecorso':
                $parametri=$this->tabelle_model->tab_parametri_iscrizione_corsi();
                $this->studente_model->VerificaPassaggioSemestreCorso($parametri['ANNOACCA'],$parametri['SEMESTRE'],'0');
                redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'datatable' . DIRECTORY_SEPARATOR . 'scadenze'));
                //redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'parametri_iscrizione_corsi'));
                break;        
            case 'preiscrizione_conferma':
                $id_new=$this->studente_model->tab_max_matricola('studente');
                $id_new=$id_new['MAX_MATRICOL'];
                $this->studente_model->SalvaNuovoStudentePreiscrizione($id_new,$id);

                $file = './assets/images/preiscrizione/'.$id.'.jpg';
                $newfile = './assets/images/students/'.$id_new.'.jpg';
                copy($file, $newfile);
                unlink($file);
//spostamento file
                if (!is_dir(FCPATH . 'assets/images/students/'.$id_new.'/')){
                    mkdir('./assets/images/students/'.$id_new);
                }
                $files = scandir('./assets/images/preiscrizione');
                $inizio=$id.'_';
                $len_inizio=strlen($inizio);
                foreach ($files as $file) {
                    if (in_array($file, array(".",".."))) {
                        continue;
                    }else{
                        if (substr($file,0,$len_inizio)==$inizio){
                            $file1 = './assets/images/preiscrizione/'.$file;
                            $newfile = './assets/images/students/'.$id_new.'/'.substr($file,$len_inizio);
                            copy($file1, $newfile);
                            unlink($file1);
                        }
                    }
               }
//fine spostamento file                
                unset($_SESSION['filtri_scheda_studente']);
                $_SESSION['post_studenti_ricerca']['COGNOME']="";
                $_SESSION['post_studenti_ricerca']['MATRICOL']=$id_new;
                $_SESSION['post_studenti_ricerca']['ANNOACCA']="tutti";
                $_SESSION['post_studenti_ricerca']['ANNOCORSO']="tutti";
                $_SESSION['post_studenti_ricerca']['CATEGORIA']="tutti";
                $_SESSION['post_studenti_ricerca']['CORSOLAUREA']="tutti";
                
                redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'studente' . DIRECTORY_SEPARATOR . $id_new));
                break;            
            case 'iscrizionistudente':
                $this->studente_model->SalvaModificaIscrizioniStudente($id, $post);
                $_SESSION['tab_attivo_studente'] = 'tab7';
//                redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'studente' . DIRECTORY_SEPARATOR . $id), 'refresh');
                redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'studente' . DIRECTORY_SEPARATOR . $post['MATRICOL']), 'refresh');
                break;
            case 'tassestudente':
                $this->studente_model->SalvaModificaTasseStudente($id, $post);
                $_SESSION['tab_attivo_studente'] = 'tab8';
                redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'studente' . DIRECTORY_SEPARATOR . $post['MATRICOL']), 'refresh');
                break;
            case 'esamistudente':
                $this->studente_model->SalvaModificaCorsoStudente($id, $post);
                $_SESSION['tab_attivo_studente'] = 'tab9';
                redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'studente' . DIRECTORY_SEPARATOR . $id), 'refresh');
                break;
            case 'esamedilaurea':
                $this->studente_model->SalvaModificaEsameLaurea($id, $post);
                $_SESSION['tab_attivo_studente'] = 'tab7';
                redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'studente' . DIRECTORY_SEPARATOR . $id), 'refresh');
                break;
            case 'titolistudente':
                $this->studente_model->SalvaModificaTitoliStudente($id, $post);
                $_SESSION['tab_attivo_studente'] = 'tab5';
                redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'studente' . DIRECTORY_SEPARATOR . $id), 'refresh');
                break;
            case 'titolistudente_preiscrizione':
                $this->studente_model->SalvaModificaTitoliStudentePreiscrizione($id, $post);
                $_SESSION['tab_attivo_studente'] = 'tab5';
                redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'studente_preiscrizione' . DIRECTORY_SEPARATOR . $id), 'refresh');
                break;
            case 'professore':
                $this->studente_model->SalvaModificaProfessore($id, $post);
                redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'professore' . DIRECTORY_SEPARATOR . $post['MATRICOL']));
                break;
            case 'nazione':
                $this->tabelle_model->SalvaModificaNazione($id, $post);
                redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'datatable' . DIRECTORY_SEPARATOR . 'nazioni'));
                break;
            case 'provincia':
                $this->tabelle_model->SalvaModificaProvincia($id, $post);
                redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'datatable' . DIRECTORY_SEPARATOR . 'province'));
                break;
            case 'collegio':
                $this->tabelle_model->SalvaModificaCollegio($id, $post);
                redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'datatable' . DIRECTORY_SEPARATOR . 'collegi'));
                break;
            case 'diocesi':
                $this->tabelle_model->SalvaModificaDiocesi($id, $post);
                //echo "<script>alert('Dati salvati');</script>";
                //echo "<script>window.close();</script>";                
                redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'datatable' . DIRECTORY_SEPARATOR . 'diocesis'));
                break;
            case 'ordine':
                $this->tabelle_model->SalvaModificaOrdine($id, $post);
                redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'datatable' . DIRECTORY_SEPARATOR . 'ordini'));
                break;        
            case 'statocivile':
                $this->tabelle_model->SalvaModificaStatoCivile($id, $post);
                redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'datatable' . DIRECTORY_SEPARATOR . 'statocivili'));
                break;        
            case 'importitasse':
                $this->tabelle_model->SalvaModificaImportiTasse($id, $post);
                redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'datatable' . DIRECTORY_SEPARATOR . 'importotasse'));
                break;        
            case 'scadenze':
                $this->tabelle_model->SalvaModificaScadenze($id, $post);
                redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'datatable' . DIRECTORY_SEPARATOR . 'scadenze'));
                break;        
            case 'test':
                break;        
            
        }
    }

    public function delete_record($nomeTabella, $id, $cartella=NULL) {
        $this->load->model('tabelle_model');
        $this->load->model('studente_model');
        switch ($nomeTabella) {
            case 'users':
                $this->studente_model->EliminaUsers($id);
                if($cartella=='preiscrizione'){
                    $file=FCPATH . 'assets/images/'.$cartella.'/'.$id.'.jpg';
                    unlink($file);  
                    $f1 = glob('./assets/images/'.$cartella.'/'.$id.'_*.*');
                    if (isset($f1[0])){
                        $n_file=count($f1);
                        for ($i=0; $i<$n_file; $i++) {
                           $file=FCPATH . $f1[$i]; 
                           unlink($file);  
                        }
                    }
                    if (is_dir(FCPATH . 'assets/images/'.$cartella.'/'.$id.'/File/')){
                        $f1 = glob('./assets/images/'.$cartella.'/'.$id.'/File/*.*');
                        if (isset($f1[0])){
                            $n_file=count($f1);
                            for ($i=0; $i<$n_file; $i++) {
                               $file=FCPATH . $f1[$i]; 
                               unlink($file);  
                            }
                        }
                    }
                    rmdir(FCPATH . './assets/images/'.$cartella.'/'.$id.'/File');
                    rmdir(FCPATH . './assets/images/'.$cartella.'/'.$id);
                }
                redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'datatable' . DIRECTORY_SEPARATOR . 'preiscrizione'));
                break;
            case 'studente':
                $this->studente_model->EliminaStudente($id);
                $post = $this->input->post();
                redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'studente' . DIRECTORY_SEPARATOR . $post['MATRICOL_PREC']));
                break;
            case 'iscrizionistudente':
                $this->studente_model->EliminaIscrizioniStudente($id, $this->input->post());
                $_SESSION['tab_attivo_studente'] = 'tab7';
                redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'studente' . DIRECTORY_SEPARATOR . $id), 'refresh');
                break;
            case 'tassestudente':
                $this->studente_model->EliminaTassaStudente($id, $this->input->post());
                $_SESSION['tab_attivo_studente'] = 'tab8';
                redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'studente' . DIRECTORY_SEPARATOR . $id), 'refresh');
                break;
            case 'pianistudiostudente':
                $this->studente_model->EliminaCorsoStudente($id, $this->input->post());
                $_SESSION['tab_attivo_studente'] = 'tab9';
                redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'studente' . DIRECTORY_SEPARATOR . $id), 'refresh');
                break;
            case 'titolistudente':
                $this->studente_model->EliminaTitoloStudente($id, $this->input->post());
                $_SESSION['tab_attivo_studente'] = 'tab5';
                redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'studente' . DIRECTORY_SEPARATOR . $id), 'refresh');
                break;
            case 'titolistudente_preiscrizione':
                $this->studente_model->EliminaTitoloStudentePreiscrizione($id, $this->input->post());
                $_SESSION['tab_attivo_studente'] = 'tab5';
                redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'studente_preiscrizione' . DIRECTORY_SEPARATOR .  $id), 'refresh');
                break;
            case 'professore':
                $this->studente_model->EliminaProfessore($id);
                redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'datatable' . DIRECTORY_SEPARATOR . 'professori'));
                break;
            case 'nazione':
                $this->tabelle_model->EliminaNazione($id);
                redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'datatable' . DIRECTORY_SEPARATOR . 'nazioni'));
                break;
            case 'provincia':
                $this->tabelle_model->EliminaProvincia($id);
                redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'datatable' . DIRECTORY_SEPARATOR . 'province'));
                break;
            case 'collegio':
                $this->tabelle_model->EliminaCollegio($id);
                redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'datatable' . DIRECTORY_SEPARATOR . 'collegi'));
                break;
            case 'diocesi':
                $this->tabelle_model->EliminaDiocesi($id);
                redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'datatable' . DIRECTORY_SEPARATOR . 'diocesis'));
                break;
            case 'ordine':
                $this->tabelle_model->EliminaOrdine($id);
                redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'datatable' . DIRECTORY_SEPARATOR . 'ordini'));
                break;
            case 'statocivile':
                $this->tabelle_model->EliminaStatoCivile($id);
                redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'datatable' . DIRECTORY_SEPARATOR . 'statocivili'));
                break;
            case 'importitasse':
                $this->tabelle_model->EliminaImportoTasse($id);
                redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'datatable' . DIRECTORY_SEPARATOR . 'importotasse'));
                break;
            case 'preiscrizione_upload':
                $post = $this->input->post();
                if ($post['tipo_documento']=='_Foto'){
                    $post['tipo_documento']='';
                }
                $f1 = glob('./assets/images/preiscrizione/'.$id.$post['tipo_documento'].'.*');
                if (isset($f1[0])){
                    unlink($f1[0]);
                }   
                if ($post['tipo_documento']==='_File'){
                    unlink($post['nome_file']);
                }
                switch($post['tipo_documento']){
                    case '_Foto':
                    case '':
                        $campo='FOTOGRAF';
                        break;
                    case '_DocumentoIdentita':
                        $campo='CERTNASC';
                        break;
                    case '_Celebret':
                        $campo='celebret';
                        break;
                    case '_Greco':
                        $campo='GRECO';
                        break;
                    case '_Latino':
                        $campo='LATINO';
                        break;
                    case '_PermessoSoggiorno':
                        $campo='permessosogg';
                        break;
                    case '_AutorizzazioneSuperiore':
                        $campo='AUTSUP';
                        break;
                    case '_AutorizzazioneIstitutoProvenienza':
                        $campo='AUT_UNIV';
                        break;
                    case '_CertificatoIscrizioneAltraUniv':
                        $campo='CERT_ISCR_ALTRA_UNIV';
                        break;
                    case '_TesiLicenza':
                        $campo='TESI_LICENZA';
                        break;
                    case '_DichiarazionePermanenzaRoma':
                        $campo='DICHIARAZIONE_PERMANENZA_ROMA';
                        break;
                    case '_PresaInCarico':
                        $campo='PRESAINCARICO';
                        break;
                    case '_TitoloStudio':
                        $campo='TITOLOSTUDIO_PDF';
                        break;
                    case '_CertificatoPreiscrizione':
                        $campo='CERTIFICATOPREISCRIZIONE_PDF';
                        break;
                    case '_QCERTA2':
                        $campo='ITASTRANIERI';
                        break;
                }
                if($post['tipo_documento']!='_File'){
                    $this->studente_model->SalvaUploadStudentePreiscrizione($id,$campo,'N');
                }else{
                    $_SESSION['tab_attivo_studente'] = 'tab20';
                }
                redirect(site_url('backend/studente_preiscrizione/'.$id.'/uploadok'));
            break;
            case 'students_upload':
                $post = $this->input->post();
                if ($post['tipo_documento']=='_Foto'){
                    $tipo_documento='';
                    $f1 = glob('./assets/images/students/'.$id.'.*');
                }else{
                    $tipo_documento=substr($post['tipo_documento'],1);
                    $f1 = glob('./assets/images/students/'.$id.'/'.$tipo_documento.'.*');
                }
                if (isset($f1[0])){
                    unlink($f1[0]);
                }   
                if ($post['tipo_documento']==='_File'){
                    unlink($post['nome_file']);
                }
                switch($post['tipo_documento']){
                    case '_Foto':
                        $campo='FOTOGRAF';
                        break;
                    case '_DocumentoIdentita':
                        $campo='CERTNASC';
                        break;
                    case '_Celebret':
                        $campo='celebret';
                        break;
                    case '_Greco':
                        $campo='GRECO';
                        break;
                    case '_Latino':
                        $campo='LATINO';
                        break;
                    case '_PermessoSoggiorno':
                        $campo='permessosogg';
                        break;
                    case '_AutorizzazioneSuperiore':
                        $campo='AUTSUP';
                        break;
                    case '_AutorizzazioneIstitutoProvenienza':
                        $campo='AUT_UNIV';
                        break;
                    case '_CertificatoIscrizioneAltraUniv':
                        $campo='CERT_ISCR_ALTRA_UNIV';
                        break;
                    case '_TesiLicenza':
                        $campo='TESI_LICENZA';
                        break;
                    case '_DichiarazionePermanenzaRoma':
                        $campo='DICHIARAZIONE_PERMANENZA_ROMA';
                        break;
                    case '_PresaInCarico':
                        $campo='PRESAINCARICO';
                        break;
                    case '_TitoloStudio':
                        $campo='TITOLOSTUDIO_PDF';
                        break;   
                    case '_CertificatoPreiscrizione':
                        $campo='CERTIFICATOPREISCRIZIONE_PDF';
                        break;
                    case '_QCERTA2':
                        $campo='ITASTRANIERI';
                        break;
                    }
                if($post['tipo_documento']!='_File'){
                    $this->studente_model->SalvaUploadStudente($id,$campo,'N');
                }else{
                    $_SESSION['tab_attivo_studente'] = 'tab20';
                }
                redirect(site_url('backend/studente/'.$id.'/uploadok'));
            break;
        }
    }
    
    public function preiscrizione_elimina_documenti($id_user,$tipo_documento) {
        //$config['upload_path'] = './assets/uploads/preiscrizione/';
            //elimina il file precedente
        $f1 = glob('./assets/uploads/preiscrizione/'.$id_user.'_'.$tipo_documento.'.*');
        if (isset($f1[0])){
            unlink($f1[0]);
        }            
        $this->load->model('pua_model');
        $this->pua_model->SalvaPreiscrizioneDocumenti($id_user,$tipo_documento,'no');
        redirect(site_url('pua/preiscrizione/3/0'));
    }    
    

    public function datatable($nomeDataset, $sidebarParent = 0) {
        //$this->input->post('ANN')
        $_SESSION['datable_attiva']=$nomeDataset;
        $this->data['sidebar'] = $this->buildSidebar($this->sidebar, intval($sidebarParent));
        $this->load->library('components');
        switch ($nomeDataset) {
            case "studenti":
                $this->dataset = $this->setDataset($nomeDataset, $_SESSION['post_studenti_ricerca']);
                break;
            case "professori":
                $this->dataset = $this->setDataset($nomeDataset, $_SESSION['post_professori_ricerca']);
                break;
            case "preiscrizione":
                $this->dataset = $this->setDataset($nomeDataset, $_SESSION['post_preiscrizione_ricerca']);
                break;
            default:
                $this->dataset = $this->setDataset($nomeDataset, $this->input->post());
                break;
        }
        $this->session->set_userdata('dataset', $this->dataset);
        $this->data['table'] = $this->components->addDataTableSS($nomeDataset, base_url('backend/getLists/' . $nomeDataset));
        $this->load->model('studente_model');
        $this->load->model('tabelle_model');
        $gridLabel = '';
        switch ($nomeDataset) {
            case "studenti":
                $this->data['sidebar'] = $this->buildSidebar($this->sidebar, 2);
//                foreach ($this->input->post() as $field => $value) {
                foreach ($_SESSION['post_studenti_ricerca'] as $field => $value) {
                    if ($value === 'tutti' || $value==='')
                        continue;
                    if ($field === 'COGNOME')
                        $gridLabel .= ' - cognome: ' . $value;
                    if ($field === 'MATRICOL')
                        $gridLabel .= ' - matricola: ' . $value;
                    if ($field === 'ANNOACCA')
                        $gridLabel .= ' - anno accademico: ' . ($value - 1) . '/' . $value;
                    if ($field === 'ANNOCORSO')
//                        $gridLabel .= ' - anno corso: ' . $value;
                        switch ($value) {
                            case '1A':
                                $gridLabel .= ' - anno corso: 1';
                                break;
                            case '2A':
                                $gridLabel .= ' - anno corso: 2';
                                break;
                            case 'F':
                                $gridLabel .= ' - semestre corso: fuori corso';
                                break;
                            case '1S':
                                $gridLabel .= ' - semestre corso: 1';
                                break;
                            case '2S':
                                $gridLabel .= ' - semestre corso: 2';
                                break;
                            case '3S':
                                $gridLabel .= ' - semestre corso: 3';
                                break;
                            case '4S':
                                $gridLabel .= ' - semestre corso: 4';
                                break;
                        }
                    if ($field === 'CORSOLAUREA') {
                        $value = $this->studente_model->corsodilaurea($value);
                        $gridLabel .= ' - corso di laurea: ' . $value['DECODIF'];
                    }
                }
                $gridLabel = substr($gridLabel, 3);
                $this->data['n_record'] = $_SESSION['numero_record'];
                break;
            case "professori":
                $this->data['sidebar'] = $this->buildSidebar($this->sidebar, 7);
                foreach ($_SESSION['post_professori_ricerca'] as $field => $value) {
//                foreach ($this->input->post() as $field => $value) {
                    if ($value === 'tutti' || $value==='')
                        continue;
                    if ($field === 'COGNOME')
                        $gridLabel .= ' - cognome: ' . $value;
                    if ($field === 'MATRICOL')
                        $gridLabel .= ' - matricola: ' . $value;
                    if ($field === 'ANNOACCA')
                        $gridLabel .= ' - anno accademico: ' . ($value - 1) . '/' . $value;
                }
                $gridLabel = substr($gridLabel, 3);
                $this->data['n_record'] = $_SESSION['numero_record'];
                break;
            case 'preiscrizione':
                $this->data['sidebar'] = $this->buildSidebar($this->sidebar, 43);

                foreach ($_SESSION['post_preiscrizione_ricerca'] as $field => $value) {
                    if ($value === 'tutti' || $value===''){
                        continue;
                    }
                    if ($field === 'CORSOLAUREA'){
                        $value = $this->studente_model->corsodilaurea($value);
                        $gridLabel .= ' - tipo iscrizione: ' . $value['DECODIF'];
                    }
                    if ($field === 'CERTIFICATOPREISCRIZIONE'){
                        if($value=='S'){
                            $value='SI';
                        }elseif($value=='N'){
                            $value=="NO";
                        }
                        $gridLabel .= ' - richiesta certificato: ' . $value;
                    }
                }
                $gridLabel = substr($gridLabel, 3);
                $this->data['n_record'] = $_SESSION['numero_record'];
                
//                $this->data['tab_preiscrizione'] = $this->tabelle_model->tab_preiscrizione();
//                $this->data['n_record'] = $_SESSION['numero_record'];
//                $this->data['n_record'] = count($this->data['tab_preiscrizione']);
                $this->data['headerPage'] = 'Elenco nominativi preiscritti';
                break;        
        }
        $this->data['headerPage'] = 'Elenco ' . $nomeDataset;
        if ($nomeDataset==='diocesis') $this->data['headerPage'] = 'Elenco diocesi';
        if ($nomeDataset==='statocivili') $this->data['headerPage'] = 'Elenco stato civili';
        if ($nomeDataset==='importotasse') $this->data['headerPage'] = 'Importi tasse';
        $this->data['Filtri'] = $gridLabel;

        switch ($nomeDataset) {
            case 'province':
                $this->data['tab_province'] = $this->tabelle_model->tab_province();
                //$this->data['n_record'] = count($this->data['tab_province']);
                $this->data['FormNascoste'] = [
                    'id' => 'form_nascoste'
                ];
                $this->data['FormNascoste']['html'] = $this->renderView('backend' . DIRECTORY_SEPARATOR . 'tabelle' . DIRECTORY_SEPARATOR . 'provincia', 'empty', true);
                break;
            case 'nazioni':
                $this->data['tab_nazioni'] = $this->tabelle_model->tab_nazioni();
                //$this->data['n_record'] = count($this->data['tab_nazioni']);
                $this->data['tab_continenti'] = $this->studente_model->tab_continenti();
                $this->data['FormNascoste'] = [
                    'id' => 'form_nascoste'
                ];
                $this->data['FormNascoste']['html'] = $this->renderView('backend' . DIRECTORY_SEPARATOR . 'tabelle' . DIRECTORY_SEPARATOR . 'nazione', 'empty', true);
                break;
            case 'collegi':
                $this->data['labelNewRecord'] = 'Nuovo collegio';
                $this->data['btnNewRecord'] = 'collegio';
                $this->data['max_codice'] = $this->tabelle_model->tab_max_codice_collegio();
                $this->data['FormNascoste'] = [
                    'id' => 'form_nascoste'
                ];
                $this->data['FormNascoste']['html'] = $this->renderView('backend' . DIRECTORY_SEPARATOR . 'tabelle' . DIRECTORY_SEPARATOR . 'collegio_new', 'empty', true);
                break;
            case 'diocesis':
                $this->data['labelNewRecord'] = 'Nuova diocesi';
                $this->data['btnNewRecord'] = 'diocesi';
                $this->data['tab_diocesi'] = $this->tabelle_model->tab_diocesi();
                //$this->data['n_record'] = count($this->data['tab_diocesi']);
                $this->data['max_codice'] = $this->tabelle_model->tab_max_codice_diocesi();
                $this->data['FormNascoste'] = [
                    'id' => 'form_nascoste'
                ];
                $this->data['FormNascoste']['html'] = $this->renderView('backend' . DIRECTORY_SEPARATOR . 'tabelle' . DIRECTORY_SEPARATOR . 'diocesi', 'empty', true);
                break;
            case 'ordini':
                $this->data['labelNewRecord'] = 'Nuovo ordine';
                $this->data['btnNewRecord'] = 'ordine';
                $this->data['tab_ordine'] = $this->tabelle_model->tab_ordine();
                //$this->data['n_record'] = count($this->data['tab_ordine']);
                $this->data['max_codice'] = $this->tabelle_model->tab_max_codice_ordine();
                $this->data['FormNascoste'] = [
                    'id' => 'form_nascoste'
                ];
                $this->data['FormNascoste']['html'] = $this->renderView('backend' . DIRECTORY_SEPARATOR . 'tabelle' . DIRECTORY_SEPARATOR . 'ordine', 'empty', true);
                break;        
            case 'statocivili':
                $this->data['labelNewRecord'] = 'Nuovo stato';
                $this->data['btnNewRecord'] = 'statocivile';
                $this->data['tab_statocivile'] = $this->tabelle_model->tab_statocivile();
                //$this->data['n_record'] = count($this->data['tab_statocivile']);
                $this->data['max_codice'] = $this->tabelle_model->tab_max_codice_statocivile();
                $this->data['FormNascoste'] = [
                    'id' => 'form_nascoste'
                ];
                $this->data['FormNascoste']['html'] = $this->renderView('backend' . DIRECTORY_SEPARATOR . 'tabelle' . DIRECTORY_SEPARATOR . 'statocivile', 'empty', true);
                break;                    
            case 'importotasse':
                $this->data['labelDuplicaRecord'] = 'Duplica importi tasse anno';
                $this->data['labelNewRecord'] = 'Nuova tassa';
                $this->data['btnNewRecord'] = 'importitasse';
                $this->data['tab_importitasse'] = $this->tabelle_model->tab_importitasse();
                //$this->data['n_record'] = count($this->data['tab_importitasse']);
                $this->data['tab_anno_accademico'] = $this->studente_model->tab_anno_accademico();
                $this->data['tab_corsidilaurea'] = $this->tabelle_model->tab_corsidilaurea();
                $this->data['tab_causaletassa'] = $this->studente_model->tab_causaletassa();
                $this->data['FormNascoste'] = [
                    'id' => 'form_nascoste'
                ];
                $this->data['FormNascoste']['html'] = $this->renderView('backend' . DIRECTORY_SEPARATOR . 'tabelle' . DIRECTORY_SEPARATOR . 'importitasse', 'empty', true);
                break;                    
            case 'scadenze':
                $this->data['labelDuplicaRecord'] = 'Duplica scadenze anno';
                $this->data['labelNewRecord'] = 'Nuovo anno';
                $this->data['btnNewRecord'] = 'scadenze';
                $this->data['tab_scadenze'] = $this->tabelle_model->tab_scadenze('%');
                //$this->data['max_codice'] = $this->tabelle_model->tab_max_codice_statocivile();
                $this->data['tab_anno_accademico'] = $this->studente_model->tab_anno_accademico();
                $this->data['FormNascoste'] = [
                    'id' => 'form_nascoste'
                ];
                $this->data['FormNascoste']['html'] = $this->renderView('backend' . DIRECTORY_SEPARATOR . 'tabelle' . DIRECTORY_SEPARATOR . 'scadenze', 'empty', true);
                break;                    
        }

        $this->renderView('backend' . DIRECTORY_SEPARATOR . 'datatable');
    }

    public function getLists($tablename) {
        switch ($tablename) {
            case 'provincia': //da usare per elenco province
                $this->db->select('CODICENU as value, DECODIF as label');
                $this->db->FROM('provincia');
                $this->db->like('DECODIF', $this->input->post('term'), 'both');
                $this->db->where('deleted','0');
                $this->db->order_by('DECODIF','ASC');
                $this->db->limit(500); //è eccessivo servire tutti i records
                $query = $this->db->get();
                $result = $query->result();
                $this->render_json1($result);
                break;
            case 'nazione': //da usare per elenco nazioni
                $this->db->select('CODICENU as value, DECODIF as label');
                $this->db->FROM('nazione');
                $this->db->like('DECODIF', $this->input->post('term'), 'both');
                $this->db->where('deleted','0');
                $this->db->order_by('DECODIF','ASC');
                $this->db->limit(500); //è eccessivo servire tutti i records
                $query = $this->db->get();
                $result = $query->result();
                $this->render_json1($result);
                break;
            case 'nazionedati': //restituisce la nazionalità e il continente a partire dal codice nazione
                $this->db->select('n.CITTADINANZA as nazionalita,a.descrizione AS continente');
                $this->db->FROM('nazione n');
                $this->db->join('area_cittadinanza a', 'n.ALFAUNO=a.cod_area', 'inner');
                $this->db->where('n.CODICENU', $this->input->post('term'));

                $query = $this->db->get();
                $result = $query->row_array();
                $find = $result;
                $this->render_json($find);
                break;
            case 'cittadinanza': //da usare per elenco cittadinanza
                $this->db->select('CODICENU as value, CITTADINANZA as label');
                $this->db->FROM('nazione');
                $this->db->like('CITTADINANZA', $this->input->post('term'), 'both');
                $this->db->where('deleted','0');
                $this->db->order_by('CITTADINANZA','ASC');
                $this->db->limit(500); //è eccessivo servire tutti i records
                $query = $this->db->get();
                $result = $query->result();
                $this->render_json1($result);
                break;
            case 'continente': //restituisce il continente a partire dal codice nazione
                $this->db->select('nazione.CITTADINANZA AS nazionalita, area_cittadinanza.descrizione AS continente');
                $this->db->FROM('nazione');
                $this->db->join('area_cittadinanza', 'nazione.ALFAUNO=area_cittadinanza.cod_area', 'inner');
                $this->db->where('nazione.CODICENU', $this->input->post('term'));
                $query = $this->db->get();
                $result = $query->row_array();
                $find = $result;
                $this->render_json($find);
                break;
            case 'ordine':
                $this->db->select('CODICENU as value, DECODIF as label');
                $this->db->FROM('ordine');
                $this->db->like('DECODIF', $this->input->post('term'), 'both');
                $this->db->where('deleted','0');
                $this->db->order_by('DECODIF','ASC');
                $this->db->limit(500); //è eccessivo servire tutti i records
                $query = $this->db->get();
                $result = $query->result();
                $this->render_json1($result);
                break;
            case 'diocesi':
                $this->db->select('CODICE as value, DIOCESI as label');
                $this->db->FROM('diocesi');
                $this->db->like('DIOCESI', $this->input->post('term'), 'both');
                $this->db->where('deleted','0');
                $this->db->order_by('DIOCESI','ASC');
                $this->db->limit(500); //è eccessivo servire tutti i records
                $query = $this->db->get();
                $result = $query->result();
                $this->render_json1($result);
                break;
            case 'collegio':
                $this->db->select('CODICE as value, Concat(codice_pug,\' | \',COLLEGIO,\' | \',INDIRIZZO) as label');
                $this->db->FROM('collegi');
                $this->db->like('Concat(codice_pug,\' | \',COLLEGIO,\' | \',INDIRIZZO)', $this->input->post('term'), 'both');
                $this->db->where('deleted','0');
                $this->db->order_by('codice_pug','ASC');
                $this->db->order_by('COLLEGIO','ASC');
                $this->db->limit(500); //è eccessivo servire tutti i records
                $query = $this->db->get();
                $result = $query->result();
                $this->render_json1($result);
                break;                
            case 'collegiodati':
                $this->db->select('c.CODICE,c.COLLEGIO,c.INDIRIZZO,c.CAP,c.COMUNE,c.TELEFONO,c.FAX,c.codice_pug,
                                    p.DECODIF AS PROVINCIA,c.TELEFONO,c.FAX,c.rettore,c.direttore_studi,c.email_rettore,c.tel_rettore,
                                    c.email_dirstudi,c.tel_dirstudi,c.note,
                                    Concat(c.codice_pug,\' | \',c.COLLEGIO) AS NOME_COLLEGIO');
                $this->db->FROM('collegi c');
                $this->db->join('provincia p', 'c.PROVINCIA=p.CODICENU', 'left');
                $this->db->where('c.CODICE', $this->input->post('term'));
                $query = $this->db->get();
                $result = $query->row_array();
                $find = $result;
                $this->render_json($find);
                break;
            case 'istituzioneprovenienza': 
                $this->db->select('Codice as value, Nome_istituzione as label');
                $this->db->FROM('istituzione_provenienza');
                $this->db->like('Nome_istituzione', $this->input->post('term'), 'both');
                //$this->db->where('delete','1');
                $this->db->order_by('Nome_istituzione','ASC');
                $this->db->limit(500); //è eccessivo servire tutti i records
                $query = $this->db->get();
                $result = $query->result();
                $this->render_json1($result);
                break;            
            case 'istituzioneprovenienzadati': 
                $this->db->select('Codice as value, Nome_istituzione as label, CRUIPRO, Accordo_mobil');
                $this->db->FROM('istituzione_provenienza');
                $this->db->where('Codice', $this->input->post('term'));

                $query = $this->db->get();
                $result = $query->row_array();
                $find = $result;
                $this->render_json($find);
                break;
            default:
                $this->load->library('components');
                $this->render_json($this->components->getLists($_POST));
        }
    }
    
    
    public function getLists_old($tablename) {
        switch ($tablename) {
            case 'provincia': //da usare per elenco province
                $this->db->select('CODICENU, DECODIF');
                $this->db->FROM('provincia');
                $this->db->like('DECODIF', $this->input->post('term'), 'both');
                //$this->db->order_by('DECODIF');
                $this->db->limit(500); //è eccessivo servire tutti i records
                $query = $this->db->get();

                $num_rows = $query->num_rows();
                if ($num_rows > 0) {
                    $result = $query->result_array();
                    //uasort($result, 'compare_DECODIF');//è più veloce ordinare array che 11k record... :D
                    myArrayASortFunction($result, 'DECODIF');
                    $this->load->library('components');
                    $output = $this->components->getLists($result, 'searchbar');
                } else {
                    $output = "<p>No matches found</p>";
                }
                $this->render_json($output);
                break;
            case 'provinciaresidenza': //da usare per elenco province
                $this->db->select('CODICENU, DECODIF');
                $this->db->FROM('provincia');
                $this->db->like('DECODIF', $this->input->post('term'), 'both');
                //$this->db->order_by('DECODIF');
                $this->db->limit(500); //è eccessivo servire tutti i records
                $query = $this->db->get();

                $num_rows = $query->num_rows();
                if ($num_rows > 0) {
                    $result = $query->result_array();
                    //uasort($result, 'compare_DECODIF');//è più veloce ordinare array che 11k record... :D
                    myArrayASortFunction($result, 'DECODIF');
                    $this->load->library('components');
                    $output = $this->components->getLists($result, 'searchbar');
                } else {
                    $output = "<p>No matches found</p>";
                }
                $this->render_json($output);
                break;
            case 'provinciarecapito': //da usare per elenco province
                $this->db->select('CODICENU, DECODIF');
                $this->db->FROM('provincia');
                $this->db->like('DECODIF', $this->input->post('term'), 'both');
                //$this->db->order_by('DECODIF');
                $this->db->limit(500); //è eccessivo servire tutti i records
                $query = $this->db->get();

                $num_rows = $query->num_rows();
                if ($num_rows > 0) {
                    $result = $query->result_array();
                    //uasort($result, 'compare_DECODIF');//è più veloce ordinare array che 11k record... :D
                    myArrayASortFunction($result, 'DECODIF');
                    $this->load->library('components');
                    $output = $this->components->getLists($result, 'searchbar');
                } else {
                    $output = "<p>No matches found</p>";
                }
                $this->render_json($output);
                break;
            case 'nazione': //da usare per elenco nazioni
                $this->db->select('CODICENU, DECODIF');
                $this->db->FROM('nazione');
                $this->db->like('DECODIF', $this->input->post('term'), 'both');
                //$this->db->order_by('DECODIF');
                $this->db->limit(500); //è eccessivo servire tutti i records
                $query = $this->db->get();

                $num_rows = $query->num_rows();
                if ($num_rows > 0) {
                    $result = $query->result_array();
                    //uasort($result, 'compare_DECODIF');//è più veloce ordinare array che 11k record... :D
                    myArrayASortFunction($result, 'DECODIF');
                    $this->load->library('components');
                    $output = $this->components->getLists($result, 'searchbar');
                } else {
                    $output = "<p>No matches found</p>";
                }
                $this->render_json($output);
                break;
            case 'nazioneresidenza': //da usare per elenco nazioni
                $this->db->select('CODICENU, DECODIF');
                $this->db->FROM('nazione');
                $this->db->like('DECODIF', $this->input->post('term'), 'both');
                //$this->db->order_by('DECODIF');
                $this->db->limit(500); //è eccessivo servire tutti i records
                $query = $this->db->get();

                $num_rows = $query->num_rows();
                if ($num_rows > 0) {
                    $result = $query->result_array();
                    //uasort($result, 'compare_DECODIF');//è più veloce ordinare array che 11k record... :D
                    myArrayASortFunction($result, 'DECODIF');
                    $this->load->library('components');
                    $output = $this->components->getLists($result, 'searchbar');
                } else {
                    $output = "<p>No matches found</p>";
                }
                $this->render_json($output);
                break;
            case 'nazionerecapito': //da usare per elenco nazioni
                $this->db->select('CODICENU, DECODIF');
                $this->db->FROM('nazione');
                $this->db->like('DECODIF', $this->input->post('term'), 'both');
                //$this->db->order_by('DECODIF');
                $this->db->limit(500); //è eccessivo servire tutti i records
                $query = $this->db->get();

                $num_rows = $query->num_rows();
                if ($num_rows > 0) {
                    $result = $query->result_array();
                    //uasort($result, 'compare_DECODIF');//è più veloce ordinare array che 11k record... :D
                    myArrayASortFunction($result, 'DECODIF');
                    $this->load->library('components');
                    $output = $this->components->getLists($result, 'searchbar');
                } else {
                    $output = "<p>No matches found</p>";
                }
                $this->render_json($output);
                break;
            case 'nazionedati': //restituisce la nazionalità e il continente a partire dal codice nazione
                $this->db->select('n.CITTADINANZA as nazionalita,a.descrizione AS continente');
                $this->db->FROM('nazione n');
                $this->db->join('area_cittadinanza a', 'n.ALFAUNO=a.cod_area', 'inner');
                $this->db->where('n.CODICENU', $this->input->post('term'));

                $query = $this->db->get();
                $result = $query->row_array();
                $find = $result;
                $this->render_json($find);
                break;
            case 'provinciadati': //restituisce la provincia, la nazione, il continente a partire dal codice comune
                $this->db->select('provincia.DECODIF AS provincia,nazione.DECODIF AS nazione, nazione.CITTADINANZA AS nazionalita, area_cittadinanza.descrizione AS continente');
                $this->db->FROM('provincia');
                $this->db->join('comune', 'comune.PROVINCIA=provincia.CODICENU', 'inner');
                $this->db->join('nazione', 'comune.NAZIONE=nazione.CODICENU', 'inner');
                $this->db->join('area_cittadinanza', 'nazione.ALFAUNO=area_cittadinanza.cod_area', 'inner');
                $this->db->where('comune.CODICECOMUNE', $this->input->post('term'));
                $query = $this->db->get();
                $result = $query->row_array();
                $find = $result;
                $this->render_json($find);
                break;
            case 'cittadinanza': //da usare per elenco cittadinanza
                $this->db->select('CODICENU,CITTADINANZA');
                $this->db->FROM('nazione');
                $this->db->like('CITTADINANZA', $this->input->post('term'), 'both');

                $this->db->limit(500); //è eccessivo servire tutti i records
                $query = $this->db->get();

                $num_rows = $query->num_rows();
                if ($num_rows > 0) {
                    $result = $query->result_array();
                    //uasort($result, 'compare_DECODIF');//è più veloce ordinare array che 11k record... :D
                    myArrayASortFunction($result, 'CITTADINANZA');
                    $this->load->library('components');
                    $output = $this->components->getLists($result, 'searchbar');
                } else {
                    $output = "<p>No matches found</p>";
                }
                $this->render_json($output);
                break;
            case 'continente': //restituisce il continente a partire dal codice nazione
                $this->db->select('nazione.CITTADINANZA AS nazionalita, area_cittadinanza.descrizione AS continente');
                $this->db->FROM('nazione');
                $this->db->join('area_cittadinanza', 'nazione.ALFAUNO=area_cittadinanza.cod_area', 'inner');
                $this->db->where('nazione.CODICENU', $this->input->post('term'));
                $query = $this->db->get();
                $result = $query->row_array();
                $find = $result;
                $this->render_json($find);
                break;
            case 'ordine':
                $this->db->select('CODICENU, DECODIF');
                $this->db->FROM('ordine');
                $this->db->like('DECODIF', $this->input->post('term'), 'both');
                //$this->db->order_by('DECODIF');
                $this->db->limit(500); //è eccessivo servire tutti i records
                $query = $this->db->get();

                $num_rows = $query->num_rows();
                if ($num_rows > 0) {
                    $result = $query->result_array();
                    myArrayASortFunction($result, 'DECODIF');
                    $this->load->library('components');
                    $output = $this->components->getLists($result, 'searchbar');
                } else {
                    $output = "<p>No matches found</p>";
                }
                $this->render_json($output);
                break;
            case 'diocesi':
                $this->db->select('CODICE, DIOCESI');
                $this->db->FROM('diocesi');
                $this->db->like('DIOCESI', $this->input->post('term'), 'both');
                //$this->db->order_by('DECODIF');
                $this->db->limit(500); //è eccessivo servire tutti i records
                $query = $this->db->get();

                $num_rows = $query->num_rows();
                if ($num_rows > 0) {
                    $result = $query->result_array();
                    myArrayASortFunction($result, 'DIOCESI');
                    $this->load->library('components');
                    $output = $this->components->getLists($result, 'searchbar');
                } else {
                    $output = "<p>No matches found</p>";
                }
                $this->render_json($output);
                break;
            case 'collegio':
                $this->db->select('CODICE, Concat(codice_pug,\' | \',COLLEGIO,\' | \',INDIRIZZO) AS DESCRIZIONE,COLLEGIO');
                $this->db->FROM('collegi');
//                $this->db->like('COLLEGIO', $this->input->post('term'), 'both');
                $this->db->like('Concat(codice_pug,\' | \',COLLEGIO,\' | \',INDIRIZZO)', $this->input->post('term'), 'both');
                $this->db->limit(500); //è eccessivo servire tutti i records
                $query = $this->db->get();

                $num_rows = $query->num_rows();
                if ($num_rows > 0) {
                    $result = $query->result_array();
                    myArrayASortFunction($result, 'COLLEGIO');
                    $this->load->library('components');
                    $output = $this->components->getLists($result, 'searchbar');
                } else {
                    $output = "<p>No matches found</p>";
                }
                $this->render_json($output);
                break;
            case 'collegiodati':
                $this->db->select('c.CODICE,c.COLLEGIO,c.INDIRIZZO,c.CAP,c.COMUNE,c.TELEFONO,c.FAX,c.codice_pug,
                                    p.DECODIF AS PROVINCIA,c.TELEFONO,c.FAX,c.rettore,c.direttore_studi,c.email_rettore,c.tel_rettore,
                                    c.email_dirstudi,c.tel_dirstudi,c.note,
                                    Concat(c.codice_pug,\' | \',c.COLLEGIO) AS NOME_COLLEGIO');
                $this->db->FROM('collegi c');
                $this->db->join('provincia p', 'c.PROVINCIA=p.CODICENU', 'left');
                $this->db->where('c.CODICE', $this->input->post('term'));
                $query = $this->db->get();
                $result = $query->row_array();
                $find = $result;
                $this->render_json($find);
                break;
            default:
                $this->load->library('components');
                $this->render_json($this->components->getLists($_POST));
        }
    }

    public function cartella() {
        $this->renderView('backend' . DIRECTORY_SEPARATOR . 'cartella');
    }

    public function pagelle() {
        $this->renderView('backend' . DIRECTORY_SEPARATOR . 'pagelle');
    }

    public function tessere() {
        $this->renderView('backend' . DIRECTORY_SEPARATOR . 'tessere');
    }

    public function tinybutstrong() {
        $this->load->library('tbswrapper');
        $this->load->model('tinybutstrong_model');

        $data['appTitle'] = 'My APP';

        $data['vars']['userData'] = $this->tinybutstrong_model->getUserData();

        $this->tbswrapper->tbsLoadTemplate(APPPATH . '../vendor/tbs_us/templates/my_view.html');

        $list = array('X', 'Y', 'Z');
        $this->tbswrapper->tbsMergeBlock('userData', $list);
        $this->data['tbsRender'] = $this->tbswrapper->tbsRender();

        $this->data['data'] = $data;
        $this->renderView('backend' . DIRECTORY_SEPARATOR . 'tbs');
    }

    public function report($report) {
        $this->load->library('tbswrapper');
        $this->load->model('tinybutstrong_model');
        switch ($report) {
            case 'html':
                $this->Report_html();
                break;
            case 'word':
                $this->Report_word();
                break;
        }
    }
    public function do_upload_multipla($estensione,$cartella,$id,$nome_file) {
        $config['upload_path'] = FCPATH.'assets/images/' . $cartella . '/'; 
        if ($nome_file!='_File'){
            $config['allowed_types'] = $estensione; //'jpg'; // 'gif|jpg|png';
            $config['max_size'] = 2*1024;  //kilobytes
        }else{
//            $config['allowed_types'] = 'gif|jpg|png|bpm|pdf|txt|csv|docx|doc|xls|xlsx|mpeg|mp4';
            $config['allowed_types'] = 'gif|jpg|png|bpm|pdf|txt|csv|docx|doc|xls|xlsx';
            $config['max_size'] = 0;
        }
//        $config['max_size'] = 400000;
//        $config['max_width'] = 640;
//        $config['max_height'] = 480;
        $file=$_FILES['userfile']['name'];
        
        $countfiles = count($file);
        $amf=$file;
    // Looping all files
    for($i=0;$i<$countfiles;$i++){
        $file = $amf[$i];
        $estensione_file=substr($file,strlen($file)-3,3);
        switch ($nome_file){
            case '':
            case '_Foto':
                $campo='FOTOGRAF';
                break;
            case '_DocumentoIdentita':
                $campo='CERTNASC';
                break;
            case '_Celebret':
                $campo='celebret';
                break;
            case '_Greco':
                $campo='GRECO';
                break;
            case '_Latino':
                $campo='LATINO';
                break;
            case '_PermessoSoggiorno':
                $campo='permessosogg';
                break;
            case '_AutorizzazioneSuperiore':
                $campo='AUTSUP';
                break;
            case '_AutorizzazioneIstitutoProvenienza':
                $campo='AUT_UNIV';
                break;
            case '_CertificatoIscrizioneAltraUniv':
                $campo='CERT_ISCR_ALTRA_UNIV';
                break;
            case '_TesiLicenza':
                $campo='TESI_LICENZA';
                break;
            case '_DichiarazionePermanenzaRoma':
                $campo='DICHIARAZIONE_PERMANENZA_ROMA';
                break;
            case '_PresaInCarico':
                $campo='PRESAINCARICO';
                break;
            case '_TitoloStudio':
                $campo='TITOLOSTUDIO_PDF';
                break;
            case '_CertificatoPreiscrizione':
                $campo='CERTIFICATOPREISCRIZIONE_PDF';
                break;
            case '_QCERTA2':
                $campo='ITASTRANIERI';
                break;
        } 
        if ($nome_file != '_File') {
            if (strtolower($estensione_file) != strtolower($estensione)) {
                if ($cartella == 'preiscrizione') {
                    redirect(site_url('backend/studente_preiscrizione/' . $id . '/' . $estensione));
                } elseif ($cartella == 'students') {
                    redirect(site_url('backend/studente/' . $id . '/' . $estensione));
                }
            }
        }
        $this->load->library('upload', $config);
        $this->load->model('studente_model');

        if (!$this->upload->do_upload_multipla('userfile',$i)) {
//            $error = array('error' => $this->upload->display_errors());
            if ($cartella=='preiscrizione'){
                redirect(site_url('backend/studente_preiscrizione/'.$id.'/'.$nome_file));
            }
            elseif ($cartella=='students'){
                redirect(site_url('backend/studente/'.$id.'/'.$nome_file));
            }
//            $this->load->view('upload_form', $error);
        } else {
            if ($nome_file=='_Foto'){
                $nome_file='';
            }
            $file1 = $this->upload->upload_path . $this->upload->file_name;
            $data = array('upload_data' => $this->upload->data());
            if ($cartella=='preiscrizione'){
                $file2 = FCPATH . 'assets/images/'.$cartella.'/'.$id.$nome_file.'.'.$estensione;
            }
            elseif ($cartella=='students'){
                if (!is_dir(FCPATH . 'assets/images/'.$cartella.'/'.$id.'/')){
                    mkdir('./assets/images/students/'.$id);
                }
                if ($nome_file==''){
                    $file2 = FCPATH . 'assets/images/'.$cartella.'/'.$id.'.'.$estensione;
                }else{
                    $file2 = FCPATH . 'assets/images/'.$cartella.'/'.$id.'/'.substr($nome_file,1).'.'.$estensione;
                }
            }
            if ($nome_file=='_File'){
                $_SESSION['tab_attivo_studente'] = 'tab20';
                $file2=FCPATH . 'assets/images/'.$cartella.'/'.$id.'/File/'.$file;
                $f1 = glob($file2);
                if (isset($f1[0])){
                    $amf_importato[$i]='0';
                    unlink($file1);
                }else{
                    $amf_importato[$i]='1';
                }
            }
            rename($file1, $file2);
        }
    }
    $_SESSION['avviso_importazione']='';
    for($i=0;$i<$countfiles;$i++){
        if($amf_importato[$i]=='0'){
            $_SESSION['avviso_importazione']=$_SESSION['avviso_importazione'].' '.$amf[$i];
        }
    }
    if ($_SESSION['avviso_importazione']!=''){
                if ($cartella=='preiscrizione'){
                    redirect(site_url('backend/studente_preiscrizione/'.$id.'/FileEsistente'));
                }
                elseif ($cartella=='students'){
                    redirect(site_url('backend/studente/'.$id.'/FileEsistente'));
                }
    }else{
            switch ($cartella) {
                case 'students':
                    if ($nome_file!='_File'){
                        $this->studente_model->SalvaUploadStudente($id,$campo,'S');
                    }
                    redirect(site_url('backend/studente/'.$id.'/uploadok'));
                    break;
                case 'professors':
                    redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'professore' . DIRECTORY_SEPARATOR . $id));
                    break;
                case 'preiscrizione':
                    if ($nome_file!='_File'){
                        $this->studente_model->SalvaUploadStudentePreiscrizione($id,$campo,'S');
                    }
                    redirect(site_url('backend/studente_preiscrizione/'.$id.'/uploadok'));
                    break;
            }
}
    }

    public function do_upload($estensione,$cartella,$id,$nome_file) {
        $config['upload_path'] = FCPATH.'assets/images/' . $cartella . '/'; 
        if ($nome_file!='_File'){
            $config['allowed_types'] = $estensione; //'jpg'; // 'gif|jpg|png';
            $config['max_size'] = 2*1024;  //kilobytes
        }else{
//            $config['allowed_types'] = 'gif|jpg|png|bpm|pdf|txt|csv|docx|doc|xls|xlsx|mpeg|mp4';
            $config['allowed_types'] = 'gif|jpg|png|bpm|pdf|txt|csv|docx|doc|xls|xlsx';
            $config['max_size'] = 0;
        }
//        $config['max_size'] = 400000;
//        $config['max_width'] = 640;
//        $config['max_height'] = 480;
        $file=$_FILES['userfile']['name'];
        $estensione_file=substr($file,strlen($file)-3,3);

        $this->load->model('studente_model');
        switch ($nome_file){
            case '':
            case '_Foto':
                $campo='FOTOGRAF';
                break;
            case '_DocumentoIdentita':
                $campo='CERTNASC';
                break;
            case '_Celebret':
                $campo='celebret';
                break;
            case '_Greco':
                $campo='GRECO';
                break;
            case '_Latino':
                $campo='LATINO';
                break;
            case '_PermessoSoggiorno':
                $campo='permessosogg';
                break;
            case '_AutorizzazioneSuperiore':
                $campo='AUTSUP';
                break;
            case '_AutorizzazioneIstitutoProvenienza':
                $campo='AUT_UNIV';
                break;
            case '_CertificatoIscrizioneAltraUniv':
                $campo='CERT_ISCR_ALTRA_UNIV';
                break;
            case '_TesiLicenza':
                $campo='TESI_LICENZA';
                break;
            case '_DichiarazionePermanenzaRoma':
                $campo='DICHIARAZIONE_PERMANENZA_ROMA';
                break;
            case '_PresaInCarico':
                $campo='PRESAINCARICO';
                break;
            case '_TitoloStudio':
                $campo='TITOLOSTUDIO_PDF';
                break;
            case '_CertificatoPreiscrizione':
                $campo='CERTIFICATOPREISCRIZIONE_PDF';
                break;
            case '_QCERTA2':
                $campo='ITASTRANIERI';
                break;
        } 
        if ($nome_file != '_File') {
            if (strtolower($estensione_file) != strtolower($estensione)) {
                if ($cartella == 'preiscrizione') {
                    redirect(site_url('backend/studente_preiscrizione/' . $id . '/' . $estensione));
                } elseif ($cartella == 'students') {
                    redirect(site_url('backend/studente/' . $id . '/' . $estensione));
                }
            }
        }
        $this->load->library('upload', $config);
        $this->load->model('studente_model');

        if (!$this->upload->do_upload('userfile')) {
//            $error = array('error' => $this->upload->display_errors());
            if ($cartella=='preiscrizione'){
                redirect(site_url('backend/studente_preiscrizione/'.$id.'/'.$nome_file));
            }
            elseif ($cartella=='students'){
                redirect(site_url('backend/studente/'.$id.'/'.$nome_file));
            }
//            $this->load->view('upload_form', $error);
        } else {
            if ($nome_file=='_Foto'){
                $nome_file='';
            }
            $file1 = $this->upload->upload_path . $this->upload->file_name;
            $data = array('upload_data' => $this->upload->data());
            if ($cartella=='preiscrizione'){
                $file2 = FCPATH . 'assets/images/'.$cartella.'/'.$id.$nome_file.'.'.$estensione;
            }
            elseif ($cartella=='students'){
                if (!is_dir(FCPATH . 'assets/images/'.$cartella.'/'.$id.'/')){
                    mkdir('./assets/images/students/'.$id);
                }
                if ($nome_file==''){
                    $file2 = FCPATH . 'assets/images/'.$cartella.'/'.$id.'.'.$estensione;
                }else{
                    $file2 = FCPATH . 'assets/images/'.$cartella.'/'.$id.'/'.substr($nome_file,1).'.'.$estensione;
                }
            }
            if ($nome_file=='_File'){
                $_SESSION['tab_attivo_studente'] = 'tab20';
                $file2=FCPATH . 'assets/images/'.$cartella.'/'.$id.'/File/'.$file;
                $f1 = glob($file2);
                if (isset($f1[0])){
                    unlink($file1);
                    if ($cartella=='preiscrizione'){
                        redirect(site_url('backend/studente_preiscrizione/'.$id.'/FileEsistente'));
                    }
                    elseif ($cartella=='students'){
                        redirect(site_url('backend/studente/'.$id.'/FileEsistente'));
                    }
                }
            }
            rename($file1, $file2);
            //unlink($file1);
            switch ($cartella) {
                case 'students':
                    if ($nome_file!='_File'){
                        $this->studente_model->SalvaUploadStudente($id,$campo,'S');
                    }
                    redirect(site_url('backend/studente/'.$id.'/uploadok'));
                    break;
                case 'professors':
                    redirect(site_url('backend' . DIRECTORY_SEPARATOR . 'professore' . DIRECTORY_SEPARATOR . $id));
                    break;
                case 'preiscrizione':
                    if ($nome_file!='_File'){
                        $this->studente_model->SalvaUploadStudentePreiscrizione($id,$campo,'S');
                    }
                    if ($nome_file=='_PresaInCarico'){
                        $post=$this->input->post();
                        $this->studente_model->SalvaResponsabilePresaInCarico($id,$post['PRESAINCARICO_RESP']);
                    }
                    if ($nome_file=='_CertificatoPreiscrizione'){
                        redirect(site_url('create_email_invio_certificato_preiscrizione/'.$id));
                    }else{
                        redirect(site_url('backend/studente_preiscrizione/'.$id.'/uploadok/'.$_SESSION['lingua']));
                    }
                    break;
            }
        }
    }
    private function Report_word() {
        $this->load->library('tbswrapper');
        $yourname = 'Paolo Minervino';

        // A recordset for merging tables 
        $data = array();
        $data[] = array('rank' => 'A', 'firstname' => 'Sandra', 'name' => 'Hill', 'number' => '1523d', 'score' => 200, 'email_1' => 'sh@tbs.com', 'email_2' => 'sandra@tbs.com', 'email_3' => 's.hill@tbs.com');
        $data[] = array('rank' => 'A', 'firstname' => 'Roger', 'name' => 'Smith', 'number' => '1234f', 'score' => 800, 'email_1' => 'rs@tbs.com', 'email_2' => 'robert@tbs.com', 'email_3' => 'r.smith@tbs.com');
        $data[] = array('rank' => 'B', 'firstname' => 'William', 'name' => 'Mac Dowell', 'number' => '5491y', 'score' => 130, 'email_1' => 'wmc@tbs.com', 'email_2' => 'william@tbs.com', 'email_3' => 'w.m.dowell@tbs.com');

        // Other single data items 
        $x_num = 3152.456;
        $x_pc = 0.2567;
        $x_dt = mktime(13, 0, 0, 2, 15, 2010);
        $x_bt = true;
        $x_bf = false;
        $x_delete = 1;

        // ----------------- 
        // Load the template 
        // ----------------- 
        $template = APPPATH . '..\vendor\tbs_us\plugins\tbs_plugin_opentbs_1.9.12\demo\demo_ms_word.docx';
        $this->tbswrapper->tbsLoadTemplate($template); // Also merge some [onload] automatic fields (depends of the type of document). 
        // Merge data in the body of the document 
        $this->tbswrapper->tbsMergeBlock('a,b', $data);
        // Merge data in colmuns 
        $data = [
            array('date' => '2013-10-13', 'thin' => 156, 'heavy' => 128, 'total' => 284),
            array('date' => '2013-10-14', 'thin' => 233, 'heavy' => 25, 'total' => 284),
            array('date' => '2013-10-15', 'thin' => 110, 'heavy' => 412, 'total' => 130),
            array('date' => '2013-10-16', 'thin' => 258, 'heavy' => 522, 'total' => 258),
        ];
        $this->tbswrapper->tbsMergeBlock('c', $data);

        // Change chart series 
        $ChartNameOrNum = 'a nice chart'; // Title of the shape that embeds the chart 
        $SeriesNameOrNum = 'Series 2';
        $NewValues = array(array('Category A', 'Category B', 'Category C', 'Category D'), array(3, 1.1, 4.0, 3.3));
        $NewLegend = "Updated series 2";
        //        $this->tbswrapper->tbsOpenTbsChart($ChartNameOrNum, $SeriesNameOrNum, $NewValues, $NewLegend);
        // Delete comments 
        //$this->tbswrapper->tbsOpenTbsDeleteComment();
        // ----------------- 
        // Output the result 
        // ----------------- 
        // Define the name of the output file 
        $save_as = (isset($_POST['save_as']) && (trim($_POST['save_as']) !== '') && ($_SERVER['SERVER_NAME'] == 'localhost')) ? trim($_POST['save_as']) : '';
        $output_file_name = str_replace('.', '_' . date('Y-m-d') . $save_as . '.', $template);

        if ($save_as === '') {
            // Output the result as a downloadable file (only streaming, no data saved in the server) 
            $this->tbswrapper->tbsOpenTbsShow(APPPATH . 'paolo.docx'); // Also merges all [onshow] automatic fields. 
            // Be sure that no more output is done, otherwise the download file is corrupted with extra data. 
            exit();
        } else {
            // Output the result as a file on the server. 
            $this->tbswrapper->tbsOpenTbsShow($output_file_name); // Also merges all [onshow] automatic fields. 
            // The script can continue. 
            exit("File [$output_file_name] has been created.");
        }
    }

    private function Report_html() {
        $title = "This site is powered by TinyButStrong";
        $metaDesc = "this is the coolest site on the net";
        $metaKeywords = "cool,site,internet,number one,ever,created with TinyButStrong";
        $mainContent = "Lorem ipsum dolor sit amet, tritani dissentiunt ne est, an commune maluisset consequat sed. Cu sit odio voluptua, quidam evertitur nam no. Usu ne assum feugait scriptorem. Qui luptatum instructior in. Alterum interpretaris at pro, nibh etiam mucius an est. Sed fugit augue constituam ne .";
        $rightContent = "This is the right column content";
        $footerContent = "This is footer content";

        $this->tbswrapper->tbsVarRef('title', $title);
        $this->tbswrapper->tbsVarRef('metaDesc', $metaDesc);
        $this->tbswrapper->tbsVarRef('metaKeywords', $metaKeywords);
        $this->tbswrapper->tbsVarRef('mainContent', $mainContent);
        $this->tbswrapper->tbsVarRef('rightContent', $rightContent);
        $this->tbswrapper->tbsVarRef('footerContent', $footerContent);
        //$this->tbswrapper->tbsMergeBlock('title', $title);

        $this->tbswrapper->tbsSetIniClass(array('chr_open' => '{{', 'chr_close' => '}}'));
        $this->tbswrapper->tbsLoadTemplate(APPPATH . '../vendor/tbs_us/templates/index.tpl');
        $this->data['tbsRender'] = $this->tbswrapper->tbsRender();
        $this->tbswrapper->tbsResetVarRef();
        $this->renderView('backend' . DIRECTORY_SEPARATOR . 'tbs_html', 'empty');
    }

    private function Report_html1() {
        $title = "This site is powered by TinyButStrong";
        $metaDesc = "this is the coolest site on the net";
        $metaKeywords = "cool,site,internet,number one,ever,created with TinyButStrong";
        $mainContent = "Lorem ipsum dolor sit amet, tritani dissentiunt ne est, an commune maluisset consequat sed. Cu sit odio voluptua, quidam evertitur nam no. Usu ne assum feugait scriptorem. Qui luptatum instructior in. Alterum interpretaris at pro, nibh etiam mucius an est. Sed fugit augue constituam ne .";
        $rightContent = "This is the right column content";
        $footerContent = "This is footer content";

        $this->tbswrapper->tbsVarRef('title', $title);
        $this->tbswrapper->tbsVarRef('metaDesc', $metaDesc);
        $this->tbswrapper->tbsVarRef('metaKeywords', $metaKeywords);
        $this->tbswrapper->tbsVarRef('mainContent', $mainContent);
        $this->tbswrapper->tbsVarRef('rightContent', $rightContent);
        $this->tbswrapper->tbsVarRef('footerContent', $footerContent);
        //$this->tbswrapper->tbsMergeBlock('title', $title);

        $this->tbswrapper->tbsSetIniClass(array('chr_open' => '{{', 'chr_close' => '}}'));
        $this->tbswrapper->tbsLoadTemplate(APPPATH . '../vendor/tbs_us/templates/index.tpl');
        $this->data['tbsRender'] = $this->tbswrapper->tbsRender();
        $this->tbswrapper->tbsResetVarRef();
        $this->renderView('backend' . DIRECTORY_SEPARATOR . 'tbs_html', 'empty');
    }

    private function setDataset($nomeDataset, $filter = []) {
        switch ($nomeDataset) {
            case 'studenti':
                $dataset = [];
                $where = " where s.deleted=0 ";
                $join = "";
                $AA=0;
                $dataset['table'] = '(select DISTINCT s.* from studente s ';
                if (!empty($filter)) {
                    foreach ($filter as $field => $value) {
                        if ($value === 'tutti' || $value==='')
                            continue;
                        elseif ($field === 'COGNOME'){
                            $where .= " AND s.COGNOME Like '%".$value."%'"; 
                        }
                        elseif ($field === 'MATRICOL'){
                            $where .= " AND s.MATRICOL=".$value ; 
                        }
                        elseif ($field === 'ANNOACCA'){
                            $join .= " inner join iscrizionistudente AA on s.MATRICOL=AA.MATRICOL
                                  and AA.ANNOACCA=" . $value;
                            $AA=1;
                        }                    
                        elseif ($field === 'ANNOCORSO' && $AA===1){
                            switch ($value) {
                                case '1A':
                                    $join .= " and AA.SEMESTRECORSO in(1,2)";
                                    break;
                                case '2A':
                                    $join .= " and AA.SEMESTRECORSO in(3,4)";
                                    break;
                                case 'F':
                                    $join .= " and AA.SEMESTRECORSO>4";
                                    break;
                                case '1S':
                                    $join .= " and AA.SEMESTRECORSO=1";
                                    break;
                                case '2S':
                                    $join .= " and AA.SEMESTRECORSO=2";
                                    break;
                                case '3S':
                                    $join .= " and AA.SEMESTRECORSO=3";
                                    break;
                                case '4S':
                                    $join .= " and AA.SEMESTRECORSO=4";
                                    break;
                            }
                        }
                        elseif ($field === 'CORSOLAUREA' && $AA===1){
                            $join .= " and AA.CORSOLAUREA=" . $value;
                        }
                    }
                    $dataset['table'] .= $join.$where;
                }

                $dataset['table'] .= ') tmp';

                $dataset['order'] = array('COGNOME' => 'asc');

                $dataset['columns'] = [
                    [
                        'key' => 'MATRICOL',
                        'name' => 'MATRICOL',
                        'label' => 'Matricola',
                        'data' => 'MATRICOL',
                        'searchable' => true,
                        'orderable' => true,
                        'visible' => true
                    ],
                    [
                        'name' => 'COGNOME',
                        'label' => 'Cognome',
                        'data' => 'COGNOME',
                        'searchable' => true,
                        'orderable' => true,
                        'visible' => true
                    ],
                    [
                        'name' => 'NOMESTUD',
                        'label' => 'Nome',
                        'data' => 'NOMESTUD',
                        'searchable' => true,
                        'orderable' => true,
                        'visible' => true
                    ],
                    [//da rivedere nel caso di combinazioni di dati e azioni ora è esclusiva
                        'name' => 'actions',
                        'label' => 'Azioni',
                        'data' => null,
                        'searchable' => false,
                        'orderable' => false,
                        'visible' => true,
                        'actions' => [
                            anchor(site_url('backend/studente/currentRecord[\'MATRICOL\']'), '<i class="far fa-edit"></i>', 'title="modifica"')
                        ] //!!questo array è da valorizzare nel caso si prevedano delle azioni.
                    ]
                ];
                break;
            case 'professori':
                $dataset = [];
                $where = " where p.deleted=0 ";
                $join = "";
                $group = "";
                $dataset['table'] = '(select p.* from professore p ';
                if (!empty($filter)) {
                    foreach ($filter as $field => $value) {
                        if ($value === 'tutti' || $value===''){
                            continue;
                        }
                        elseif ($field === 'COGNOME'){
                            $where .= " AND p.COGNOME Like '%".$value."%'"; 
                        }
                        elseif ($field === 'MATRICOL'){
                            $where .= " AND p.MATRICOL=".$value; 
                        }
                        elseif ($field === 'ANNOACCA'){
                            $join=" INNER JOIN professore_materia m ON m.MATRICOL=p.MATRICOL AND m.ANNOACCA=" . $value;
                            $group=" GROUP BY p.MATRICOL";
                        }    
                        //$_SESSION['filtri_scheda_professore']['ANNOACCA'] = $filter['ANNOACCA'];
                    }
                    $dataset['table'] .= $join.$where.$group;
                }
                $dataset['table'] .= ') tmp';

                $dataset['order'] = array('COGNOME' => 'asc');

                $dataset['columns'] = [
                    [
                        'key' => 'MATRICOL',
                        'name' => 'MATRICOL',
                        'label' => 'Matricola',
                        'data' => 'MATRICOL',
                        'searchable' => true,
                        'orderable' => true,
                        'visible' => true
                    ],
                    [
                        'name' => 'COGNOME',
                        'label' => 'Cognome',
                        'data' => 'COGNOME',
                        'searchable' => true,
                        'orderable' => true,
                        'visible' => true
                    ],
                    [
                        'name' => 'NOME',
                        'label' => 'Nome',
                        'data' => 'NOME',
                        'searchable' => true,
                        'orderable' => true,
                        'visible' => true
                    ],
                    [//da rivedere nel caso di combinazioni di dati e azioni ora è esclusiva
                        'name' => 'actions',
                        'label' => 'Azioni',
                        'data' => null,
                        'searchable' => false,
                        'orderable' => false,
                        'visible' => true,
                        'actions' => [
                            anchor(site_url('backend/professore/currentRecord[\'MATRICOL\']'), '<i class="far fa-edit"></i>', 'title="modifica"')
                        ] //!!questo array è da valorizzare nel caso si prevedano delle azioni.
                    ]
                ];
                break;
            case 'province':
                $dataset = [];
                $dataset['table'] = '(SELECT p.CODICENU,
                                             p.DECODIF AS PROVINCIA,
                                             p.ALFAUNO AS SIGLA 
                                      FROM provincia p
                                      WHERE p.deleted=0
                                      ) tmp';

                $dataset['order'] = ['PROVINCIA' => 'asc'];
                $dataset['columns'] = [
                    [
                        'key' => 'CODICENU',
                        'name' => 'CODICENU',
                        'label' => 'CODICENU',
                        'data' => 'CODICENU',
                        'searchable' => true,
                        'orderable' => true,
                        'visible' => false
                    ],
                    [
                        'name' => 'PROVINCIA',
                        'label' => 'Provincia',
                        'data' => 'PROVINCIA',
                        'searchable' => true,
                        'orderable' => true,
                        'visible' => true
                    ],
                    [
                        'name' => 'SIGLA',
                        'label' => 'Sigla',
                        'data' => 'SIGLA',
                        'searchable' => true,
                        'orderable' => true,
                        'visible' => true
                    ],
                    [
                        'name' => 'actions',
                        'label' => 'Azioni',
                        'data' => null,
                        'searchable' => false,
                        'orderable' => false,
                        'visible' => true,
                        'actions' => [
                            '<a data-toggle="modal" data-target="#ModificaRecord_Modal_currentRecord[\'CODICENU\']" title="modifica"><i class="far fa-edit"></i></a>',
                            '<a data-toggle="modal" data-target="#EliminaRecord_Modal_currentRecord[\'CODICENU\']" title="elimina"><i class="far fa-trash-alt"></i></a>'
//                            anchor(site_url('backend/provincia/currentRecord[\'CODICENU\']'), '<i class="far fa-edit"></i>', 'title="modifica"'),
//                            anchor(site_url('backend/delete_record/provincia/currentRecord[\'CODICENU\']'), '<i class="fas fa-trash-alt"></i>', 'title="elimina"')
                        ] //!!questo array è da valorizzare nel caso si prevedano delle azioni.
                    ]
                ];
                break;
            case 'nazioni':
                $dataset = [];
                $dataset['table'] = '(SELECT n.CODICENU,
                                                   n.DECODIF AS NAZIONE, 
                                                   n.CITTADINANZA,
                                                   a.DESCRIZIONE AS CONTINENTE
                                            from nazione n
                                            LEFT JOIN area_cittadinanza a ON n.ALFAUNO=a.cod_area
                                            WHERE n.deleted=0) tmp';
                $dataset['order'] = array('NAZIONE' => 'asc');
                $dataset['columns'] = [
                    [
                        'key' => 'CODICENU',
                        'name' => 'CODICENU',
                        'label' => 'CODICENU',
                        'data' => 'CODICENU',
                        'searchable' => true,
                        'orderable' => true,
                        'visible' => false
                    ],
                    [
                        'name' => 'NAZIONE',
                        'label' => 'Nazione',
                        'data' => 'NAZIONE',
                        'searchable' => true,
                        'orderable' => true,
                        'visible' => true
                    ],
                    [
                        'name' => 'CITTADINANZA',
                        'label' => 'Nazionalità',
                        'data' => 'CITTADINANZA',
                        'searchable' => true,
                        'orderable' => true,
                        'visible' => true
                    ],
                    [
                        'name' => 'CONTINENTE',
                        'label' => 'Continente',
                        'data' => 'CONTINENTE',
                        'searchable' => true,
                        'orderable' => true,
                        'visible' => true
                    ],
                    [
                        'name' => 'actions',
                        'label' => 'Azioni',
                        'data' => null,
                        'searchable' => false,
                        'orderable' => false,
                        'visible' => true,
                        'actions' => [
                            '<a data-toggle="modal" data-target="#ModificaRecord_Modal_currentRecord[\'CODICENU\']" title="modifica"><i class="far fa-edit"></i></a>',
                            '<a data-toggle="modal" data-target="#EliminaRecord_Modal_currentRecord[\'CODICENU\']" title="elimina"><i class="far fa-trash-alt"></i></a>'
                        ] //!!questo array è da valorizzare nel caso si prevedano delle azioni.
                    ]
                ];
                break;
            case 'collegi':
                $dataset = [];
                $dataset['table'] = '(SELECT CODICE,
                                             COLLEGIO,
                                             INDIRIZZO,
                                             codice_pug
                                      from collegi
                                      where deleted=0) tmp';
                $dataset['order'] = array('COLLEGIO' => 'asc');
                $dataset['columns'] = [
                    [
                        'key' => 'CODICE',
                        'name' => 'CODICE',
                        'label' => 'CODICE',
                        'data' => 'CODICE',
                        'searchable' => true,
                        'orderable' => true,
                        'visible' => false
                    ],
                    [
                        'name' => 'COLLEGIO',
                        'label' => 'Collegio',
                        'data' => 'COLLEGIO',
                        'searchable' => true,
                        'orderable' => true,
                        'visible' => true
                    ],
                    [
                        'name' => 'INDIRIZZO',
                        'label' => 'Indirizzo',
                        'data' => 'INDIRIZZO',
                        'searchable' => true,
                        'orderable' => true,
                        'visible' => true
                    ],
                    [
                        'name' => 'codice_pug',
                        'label' => 'Codice pug',
                        'data' => 'codice_pug',
                        'searchable' => true,
                        'orderable' => true,
                        'visible' => true
                    ],
                    [
                        'name' => 'actions',
                        'label' => 'Azioni',
                        'data' => null,
                        'searchable' => false,
                        'orderable' => false,
                        'visible' => true,
                        'actions' => [
                            anchor(site_url('backend/collegio/currentRecord[\'CODICE\']'), '<i class="far fa-edit"></i>', 'title="modifica"')
                        ] //!!questo array è da valorizzare nel caso si prevedano delle azioni.
                    ]
                ];
                break;
            case 'diocesis':
                $dataset = [];
                $dataset['table'] = '(SELECT CODICE,
                                             DIOCESI
                                      FROM diocesi 
                                      WHERE deleted=0
                                      ) tmp';

                $dataset['order'] = ['DIOCESI' => 'asc'];
                $dataset['columns'] = [
                    [
                        'key' => 'CODICE',
                        'name' => 'CODICE',
                        'label' => 'CODICE',
                        'data' => 'CODICE',
                        'searchable' => true,
                        'orderable' => true,
                        'visible' => false
                    ],
                    [
                        'name' => 'DIOCESI',
                        'label' => 'Diocesi',
                        'data' => 'DIOCESI',
                        'searchable' => true,
                        'orderable' => true,
                        'visible' => true
                    ],
                    [
                        'name' => 'actions',
                        'label' => 'Azioni',
                        'data' => null,
                        'searchable' => false,
                        'orderable' => false,
                        'visible' => true,
                        'actions' => [
                            anchor(site_url('backend/diocesi/currentRecord[\'CODICE\']'), '<i class="far fa-edit"></i>', 'title="modifica"'),
                            //anchor(site_url('backend/diocesi/currentRecord[\'CODICE\']'), '<i class="far fa-edit"></i>', 'target="_blank"', 'title="modifica"'),
                            //'<a data-toggle="modal" data-target="#ModificaRecord_Modal_currentRecord[\'CODICE\']" title="modifica"><i class="far fa-edit"></i></a>',
                            //'<a data-toggle="modal" data-target="#EliminaRecord_Modal_currentRecord[\'CODICE\']" title="elimina"><i class="far fa-trash-alt"></i></a>'
                        ] //!!questo array è da valorizzare nel caso si prevedano delle azioni.
                    ]
                ];
                break;
            case 'ordini':
                $dataset = [];
                $dataset['table'] = '(SELECT CODICENU,
                                             DECODIF,DECODIFBREVE
                                      FROM ordine 
                                      WHERE deleted=0
                                      ) tmp';

                $dataset['order'] = ['DECODIF' => 'asc'];
                $dataset['columns'] = [
                    [
                        'key' => 'CODICENU',
                        'name' => 'CODICENU',
                        'label' => 'CODICENU',
                        'data' => 'CODICENU',
                        'searchable' => true,
                        'orderable' => true,
                        'visible' => false
                    ],
                    [
                        'name' => 'DECODIF',
                        'label' => 'Ordine',
                        'data' => 'DECODIF',
                        'searchable' => true,
                        'orderable' => true,
                        'visible' => true
                    ],
                    [
                        'name' => 'DECODIFBREVE',
                        'label' => 'Sigla',
                        'data' => 'DECODIFBREVE',
                        'searchable' => true,
                        'orderable' => true,
                        'visible' => true
                    ],
                    [
                        'name' => 'actions',
                        'label' => 'Azioni',
                        'data' => null,
                        'searchable' => false,
                        'orderable' => false,
                        'visible' => true,
                        'actions' => [
                            //anchor(site_url('backend/ordini/currentRecord[\'CODICENU\']'), '<i class="far fa-edit"></i>', 'title="modifica"')
                           '<a data-toggle="modal" data-target="#ModificaRecord_Modal_currentRecord[\'CODICENU\']" title="modifica"><i class="far fa-edit"></i></a>',
                           '<a data-toggle="modal" data-target="#EliminaRecord_Modal_currentRecord[\'CODICENU\']" title="elimina"><i class="far fa-trash-alt"></i></a>'
                        ] //!!questo array è da valorizzare nel caso si prevedano delle azioni.
                    ]
                ];
                break;
            case 'statocivili':
                $dataset = [];
                $dataset['table'] = '(SELECT CODICENU,
                                             DECODIF
                                      FROM statocivile 
                                      WHERE deleted=0
                                      ) tmp';

                $dataset['order'] = ['DECODIF' => 'asc'];
                $dataset['columns'] = [
                    [
                        'key' => 'CODICENU',
                        'name' => 'CODICENU',
                        'label' => 'CODICENU',
                        'data' => 'CODICENU',
                        'searchable' => true,
                        'orderable' => true,
                        'visible' => false
                    ],
                    [
                        'name' => 'DECODIF',
                        'label' => 'Stato civile',
                        'data' => 'DECODIF',
                        'searchable' => true,
                        'orderable' => true,
                        'visible' => true
                    ],
                    [
                        'name' => 'actions',
                        'label' => 'Azioni',
                        'data' => null,
                        'searchable' => false,
                        'orderable' => false,
                        'visible' => true,
                        'actions' => [
                            //anchor(site_url('backend/ordini/currentRecord[\'CODICENU\']'), '<i class="far fa-edit"></i>', 'title="modifica"')
                           '<a data-toggle="modal" data-target="#ModificaRecord_Modal_currentRecord[\'CODICENU\']" title="modifica"><i class="far fa-edit"></i></a>',
                           '<a data-toggle="modal" data-target="#EliminaRecord_Modal_currentRecord[\'CODICENU\']" title="elimina"><i class="far fa-trash-alt"></i></a>'
                        ] //!!questo array è da valorizzare nel caso si prevedano delle azioni.
                    ]
                ];
                break;
            case 'importotasse':
                $dataset = [];
                $dataset['table'] = '(SELECT ID,
                                             CONCAT(ANNOACCADEMICO-1,"/",ANNOACCADEMICO) AS ANNOACCADEMICO,
                                             c.DECODIF AS CORSODILAUREA,
                                             if(ANNODICORSO=99,"",ANNODICORSO) as ANNODICORSO,
                                             t.DECODIFICA AS CAUSALETASSA,
                                             IMPORTOTASSA,
                                             CONCAT(ANNOACCADEMICO,
                                                IF(CORSODILAUREA=999,100,CORSODILAUREA),
                                                IF(ANNODICORSO=1,3,IF(ANNODICORSO=2,2,0)),
                                                IF(CAUSALETASSA="RU",9,IF(CAUSALETASSA="1R",8,IF(CAUSALETASSA="2R",7,0)))
                                                ) AS ORDINE
                                      FROM importitasse i
                                      INNER JOIN corsidilaurea c ON i.CORSODILAUREA=c.CODICENU
                                      INNER JOIN causaletassa t ON i.CAUSALETASSA=t.CODICECAUSALE
                                      WHERE ANNOACCADEMICO>=2019
                                      ) tmp';

                $dataset['order'] = ['ORDINE' => 'desc'];
                $dataset['columns'] = [
                    [
                        'key' => 'ID',
                        'name' => 'ID',
                        'label' => 'ID',
                        'data' => 'ID',
                        'searchable' => true,
                        'orderable' => true,
                        'visible' => false
                    ],
                    [
                        'name' => 'ORDINE',
                        'label' => 'Ordine',
                        'data' => 'ORDINE',
                        'searchable' => false,
                        'orderable' => true,
                        'visible' => false
                    ],
                    [
                        'name' => 'ANNOACCADEMICO',
                        'label' => 'Anno accademico',
                        'data' => 'ANNOACCADEMICO',
                        'searchable' => true,
                        'orderable' => true,
                        'visible' => true
                    ],
                    [
                        'name' => 'CORSODILAUREA',
                        'label' => 'Corso di laurea',
                        'data' => 'CORSODILAUREA',
                        'searchable' => true,
                        'orderable' => true,
                        'visible' => true
                    ],
                    [
                        'name' => 'ANNODICORSO',
                        'label' => 'Anno di corso',
                        'data' => 'ANNODICORSO',
                        'searchable' => true,
                        'orderable' => true,
                        'visible' => true
                    ],
                    [
                        'name' => 'CAUSALETASSA',
                        'label' => 'Causale tassa',
                        'data' => 'CAUSALETASSA',
                        'searchable' => true,
                        'orderable' => true,
                        'visible' => true
                    ],
                    [
                        'name' => 'IMPORTOTASSA',
                        'label' => 'Importo',
                        'data' => 'IMPORTOTASSA',
                        'searchable' => true,
                        'orderable' => true,
                        'visible' => true
                    ],
                    [
                        'name' => 'actions',
                        'label' => 'Azioni',
                        'data' => null,
                        'searchable' => false,
                        'orderable' => false,
                        'visible' => true,
                        'actions' => [
                           // anchor(site_url('backend/importitasse/currentRecord[\'CODICENU\']'), '<i class="fas fa-calculator"></i>', 'title="importi tasse"')
                           '<a data-toggle="modal" data-target="#ModificaRecord_Modal_currentRecord[\'ID\']" title="modifica"><i class="far fa-edit"></i></a>',
                           '<a data-toggle="modal" data-target="#EliminaRecord_Modal_currentRecord[\'ID\']" title="elimina"><i class="far fa-trash-alt"></i></a>'
                        ] //!!questo array è da valorizzare nel caso si prevedano delle azioni.
                    ]
                ];
                break;
            case 'preiscrizione':
                $dataset = [];
                $where = " where s.deleted=0 ";
                $join = "";
                $group = "";
                $dataset['table'] = '(select s.*,a.ANNOACCADEMICO,c.DECODIF AS CORSO_LAUREA from studente_preiscrizione s LEFT JOIN anni_accademici a ON s.ANNOACCA=a.ANNOACCA INNER JOIN users u ON u.id=s.ID AND u.active=1 LEFT JOIN corsidilaurea c ON s.CORSOLAUREA=c.CODICENU';
                if (!empty($filter)) {
                    foreach ($filter as $field => $value) {
                        if ($value === 'tutti' || $value===''){
                            continue;
                        }
                        elseif ($field === 'CORSOLAUREA'){
                            $where .= " AND s.CORSOLAUREA =".$value; 
                        }
                        elseif ($field === 'CERTIFICATOPREISCRIZIONE'){
                            $where .= " AND s.CERTIFICATOPREISCRIZIONE ='".$value."'"; 
                        }
                    }
                    $dataset['table'] .= $join.$where.$group;
                }
                $dataset['table'] .= ') tmp';

                $dataset['order'] = array('COGNOME' => 'asc');

                $dataset['columns'] = [
                    [
                        'key' => 'ID',
                        'name' => 'ID',
                        'label' => 'ID',
                        'data' => 'ID',
                        'searchable' => true,
                        'orderable' => true,
                        'visible' => false
                    ],                    [
                        'name' => 'COGNOME',
                        'label' => 'Cognome',
                        'data' => 'COGNOME',
                        'searchable' => true,
                        'orderable' => true,
                        'visible' => true
                    ],
                    [
                        'name' => 'NOMESTUD',
                        'label' => 'Nome',
                        'data' => 'NOMESTUD',
                        'searchable' => true,
                        'orderable' => true,
                        'visible' => true
                    ],
                    [
                        'name' => 'ANNOACCADEMICO',
                        'label' => 'A.A.',
                        'data' => 'ANNOACCADEMICO',
                        'searchable' => true,
                        'orderable' => true,
                        'visible' => true
                    ],
                    [
                        'name' => 'SEMESTREACCA',
                        'label' => 'Semestre',
                        'data' => 'SEMESTREACCA',
                        'searchable' => true,
                        'orderable' => true,
                        'visible' => true
                    ],
                    [
                        'name' => 'CORSO_LARUEA',
                        'label' => 'Tipo iscrizione',
                        'data' => 'CORSO_LAUREA',
                        'searchable' => true,
                        'orderable' => true,
                        'visible' => true
                    ],
                    [
                        'name' => 'email',
                        'label' => 'Email',
                        'data' => 'email',
                        'searchable' => true,
                        'orderable' => true,
                        'visible' => true
                    ],
                    [
                        'name' => 'CERTIFICATOPREISCRIZIONE_PDF',
                        'label' => 'Certificato fatto',
                        'data' => 'CERTIFICATOPREISCRIZIONE_PDF',
                        'searchable' => true,
                        'orderable' => true,
                        'visible' => true
                    ],
                    [//da rivedere nel caso di combinazioni di dati e azioni ora è esclusiva
                        'name' => 'actions',
                        'label' => 'Azioni',
                        'data' => null,
                        'searchable' => false,
                        'orderable' => false,
                        'visible' => true,
                        'actions' => [
                            anchor(site_url('backend/studente_preiscrizione/currentRecord[\'ID\']'), '<i class="far fa-edit"></i>', 'title="modifica"'),
                            //anchor(site_url('backend/edit_record/preiscrizione_conferma/currentRecord[\'ID\']'), '&nbsp;<i class="fas fa-angle-double-right"></i>', 'title="conferma iscrizione"')
                        ] //!!questo array è da valorizzare nel caso si prevedano delle azioni.
                    ]
                ];
                break;
            case 'scadenze':
                $dataset = [];
                $dataset['table'] = '(SELECT ANNOACCADEMICO,
                                             CONCAT(ANNOACCADEMICO-1,\'-\',ANNOACCADEMICO) AS ANNOACCA,
                                             if (ATTIVO=1,\'Si\',\'No\') as ATTIVO,if (ATTIVO=1,SEMESTRE,\'\') as SEMESTRE
                                      from scadenze) tmp';
                $dataset['order'] = array('ANNOACCADEMICO' => 'desc');
                $dataset['columns'] = [
                    [
                        'key' => 'ANNOACCADEMICO',
                        'name' => 'ANNOACCADEMICO',
                        'label' => 'ANNOACCADEMICO',
                        'data' => 'ANNOACCADEMICO',
                        'searchable' => true,
                        'orderable' => true,
                        'visible' => false
                    ],
                    [
                        'name' => 'ANNOACCA',
                        'label' => 'Anno accademico',
                        'data' => 'ANNOACCA',
                        'searchable' => true,
                        'orderable' => true,
                        'visible' => true
                    ],
                    [
                        'name' => 'ATTIVO',
                        'label' => 'Attivo',
                        'data' => 'ATTIVO',
                        'searchable' => true,
                        'orderable' => true,
                        'visible' => true
                    ],
                    [
                        'name' => 'SEMESTRE',
                        'label' => 'Semestre',
                        'data' => 'SEMESTRE',
                        'searchable' => false,
                        'orderable' => false,
                        'visible' => true
                    ],
                    [
                        'name' => 'actions',
                        'label' => 'Azioni',
                        'data' => null,
                        'searchable' => false,
                        'orderable' => false,
                        'visible' => true,
                        'actions' => [
                            anchor(site_url('backend/scadenza/currentRecord[\'ANNOACCADEMICO\']'), '<i class="far fa-edit"></i>', 'title="modifica"')
                        ] //!!questo array è da valorizzare nel caso si prevedano delle azioni.
                    ]
                ];
                break;
            }
        return $dataset;
    }
    public function diocesi($id) {
        $this->data['sidebar'] = $this->buildSidebar($this->sidebar, 35);
//        $this->load->model('tabelle_model');
        $this->load->model('studente_model');
        $this->data['tab_diocesi']=$this->studente_model->tab_diocesi($id);
        $this->renderView('backend' . DIRECTORY_SEPARATOR . 'tabelle' . DIRECTORY_SEPARATOR . 'diocesi_modifica');
       
    }
    public function parametri_preiscrizione() {
        $this->data['sidebar'] = $this->buildSidebar($this->sidebar, 53);
        $this->load->model('tabelle_model');
        $this->load->model('studente_model');
        $this->data['tab_anno_accademico'] = $this->studente_model->tab_anno_accademico();
        $this->data['tab_parametri_preiscrizione']=$this->tabelle_model->tab_parametri_preiscrizione();
        $this->data['campo_INIZIOPREISCRIZIONI_SEM1']=$this->ControllaFormatoData('myForm','INIZIOPREISCRIZIONI_SEM1','Data inizio Preiscrizioni I sem.',true);
        $this->data['campo_INIZIOPREISCRIZIONI_SEM2']=$this->ControllaFormatoData('myForm','INIZIOPREISCRIZIONI_SEM2','Data inizio Preiscrizioni II sem.',true);
        $this->data['campo_INIZIOISCRIZIONI_SEM1']=$this->ControllaFormatoData('myForm','INIZIOISCRIZIONI_SEM1','Data inizio Iscrizioni I sem.',true);
        $this->data['campo_INIZIOISCRIZIONI_SEM2']=$this->ControllaFormatoData('myForm','INIZIOISCRIZIONI_SEM2','Data inizio Iscrizioni II sem.',true);
        $this->data['campo_FINEPREISCRIZIONI_SEM1']=$this->ControllaFormatoData('myForm','FINEPREISCRIZIONI_SEM1','Data fine Preiscrizioni I sem.',true);
        $this->data['campo_FINEPREISCRIZIONI_SEM2']=$this->ControllaFormatoData('myForm','FINEPREISCRIZIONI_SEM2','Data fine Preiscrizioni II sem.',true);
        $this->data['campo_FINEISCRIZIONI_SEM1']=$this->ControllaFormatoData('myForm','FINEISCRIZIONI_SEM1','Data fine Iscrizioni I sem.',true);
        $this->data['campo_FINEISCRIZIONI_SEM2']=$this->ControllaFormatoData('myForm','FINEISCRIZIONI_SEM2','Data fine Iscrizioni II sem.',true);
        $this->renderView('backend' . DIRECTORY_SEPARATOR . 'parametri_preiscrizione');
    }

    public function parametri_iscrizione_corsi() {
        $this->data['sidebar'] = $this->buildSidebar($this->sidebar, 53);
        $this->load->model('tabelle_model');
        $this->load->model('studente_model');
        $this->data['tab_anno_accademico'] = $this->studente_model->tab_anno_accademico();
        $this->data['tab_parametri_iscrizione_corsi']=$this->tabelle_model->tab_parametri_iscrizione_corsi();
        $this->data['campo_INIZIOISCRIZIONI_SEM1']=$this->ControllaFormatoData('myForm','INIZIOISCRIZIONI_SEM1','Inizio iscrizioni 1° semestre',false);
        $this->data['campo_FINEISCRIZIONI_SEM1']=$this->ControllaFormatoData('myForm','FINEISCRIZIONI_SEM1','Fine iscrizioni 1° semestre',false);
        $this->data['campo_SCONTOISCRIZIONE_SEM1']=$this->ControllaFormatoData('myForm','SCONTOISCRIZIONE_SEM1','Sconto iscrizioni 1° semestre',false);
        $this->data['campo_INIZIOISCRCORSISEM_SEM1']=$this->ControllaFormatoData('myForm','INIZIOISCRCORSISEM_SEM1','Inizio iscrizioni corsi e seminari 1° semestre',false);
        $this->data['campo_FINEISCRIZIONISEMINARI_SEM1']=$this->ControllaFormatoData('myForm','FINEISCRIZIONISEMINARI_SEM1','Fine iscrizioni seminari 1° semestre',false);
        $this->data['campo_FINEISCRIZIONICORSI_SEM1']=$this->ControllaFormatoData('myForm','FINEISCRIZIONICORSI_SEM1','Fine iscrizioni Corsi 1° semestre',false);
        $this->data['campo_INIZIOLEZIONI_SEM1']=$this->ControllaFormatoData('myForm','INIZIOLEZIONI_SEM1','Inizio lezioni 1° semestre',false);
        $this->data['campo_INIZIOPRENOTESAMI_SEM1']=$this->ControllaFormatoData('myForm','INIZIOPRENOTESAMI_SEM1','Inizio prenotazioini esami 1° semestre',false);
        $this->data['campo_FINEPRENOTESAMI_SEM1']=$this->ControllaFormatoData('myForm','FINEPRENOTESAMI_SEM1','Fine prenotazioni esami 1° semestre',false);
        $this->data['campo_INIZIOPRENOTRECENSIONE']=$this->ControllaFormatoData('myForm','INIZIOPRENOTRECENSIONE','Inizio prenotazioini recensioni',false);
        $this->data['campo_FINEPRENOTRECENSIONE']=$this->ControllaFormatoData('myForm','FINEPRENOTRECENSIONE','fine prenotazioni recensioni',false);
        $this->data['campo_FINELEZIONI_SEM1']=$this->ControllaFormatoData('myForm','FINELEZIONI_SEM1','Fine lezioni 1° semestre',false);
        $this->data['campo_INIZIOESAMI_SEM1']=$this->ControllaFormatoData('myForm','INIZIOESAMI_SEM1','Inizio esami 1° semestre',false);
        $this->data['campo_FINEESAMI_SEM1']=$this->ControllaFormatoData('myForm','FINEESAMI_SEM1','Fine esami 1° semestre',false);

        $this->data['campo_INIZIOISCRIZIONI_SEM2']=$this->ControllaFormatoData('myForm','INIZIOISCRIZIONI_SEM2','Inizio iscrizioni 2° semestre',false);
        $this->data['campo_FINEISCRIZIONI_SEM2']=$this->ControllaFormatoData('myForm','FINEISCRIZIONI_SEM2','Fine iscrizioni 2° semestre',false);
        $this->data['campo_SCONTOISCRIZIONE_SEM2']=$this->ControllaFormatoData('myForm','SCONTOISCRIZIONE_SEM2','Sconto iscrizioni 2° semestre',false);
        $this->data['campo_INIZIOISCRCORSISEM_SEM2']=$this->ControllaFormatoData('myForm','INIZIOISCRCORSISEM_SEM2','Inizio iscrizioni corsi e seminari 2° semestre',false);
        $this->data['campo_FINEISCRIZIONISEMINARI_SEM2']=$this->ControllaFormatoData('myForm','FINEISCRIZIONISEMINARI_SEM2','Fine iscrizioni seminari 2° semestre',false);
        $this->data['campo_FINEISCRIZIONICORSI_SEM2']=$this->ControllaFormatoData('myForm','FINEISCRIZIONICORSI_SEM2','Fine iscrizioni Corsi 2° semestre',false);
        $this->data['campo_INIZIOLEZIONI_SEM2']=$this->ControllaFormatoData('myForm','INIZIOLEZIONI_SEM2','Inizio lezioni 2° semestre',false);
        $this->data['campo_INIZIOPRENOTESAMI_SEM2']=$this->ControllaFormatoData('myForm','INIZIOPRENOTESAMI_SEM2','Inizio prenotazioini esami 2° semestre',false);
        $this->data['campo_FINEPRENOTESAMI_SEM2']=$this->ControllaFormatoData('myForm','FINEPRENOTESAMI_SEM2','Fine prenotazioni esami 2° semestre',false);
        $this->data['campo_FINELEZIONI_SEM2']=$this->ControllaFormatoData('myForm','FINELEZIONI_SEM2','Fine lezioni 2° semestre',false);
        $this->data['campo_INIZIOESAMI_SEM2']=$this->ControllaFormatoData('myForm','INIZIOESAMI_SEM2','Inizio esami 2° semestre',false);
        $this->data['campo_FINEESAMI_SEM2']=$this->ControllaFormatoData('myForm','FINEESAMI_SEM2','Fine esami 2° semestre',false);
        
        $this->data['FormNascoste'] = [
            'id' => 'form_nascoste'
        ];

        $this->renderView('backend' . DIRECTORY_SEPARATOR . 'parametri_iscrizione_corsi');
    }    

    public function scadenza($anno) {
        $this->data['sidebar'] = $this->buildSidebar($this->sidebar, 53);
        $this->load->model('tabelle_model');
        $this->load->model('studente_model');
        if ($anno=='0'){
            
        }
        $this->data['page_heading'] = 'Scadenze Accademia Alfonsiana';
//        $this->data['tab_anno_accademico'] = $this->studente_model->tab_anno_accademico();
        $this->data['tab_scadenze']=$this->tabelle_model->tab_scadenze($anno);

        $this->data['FormNascoste'] = [
            'id' => 'form_nascoste'
        ];
        
        $this->renderView('backend' . DIRECTORY_SEPARATOR .'tabelle' . DIRECTORY_SEPARATOR . 'scadenza');
    }   
    
    public function scelta_corsi_studente($id,$corsolaurea,$semestre,$annoaccademico,$semestrecorso)
    {
        $this->data['sidebar'] = $this->buildSidebar($this->sidebar, 47);
        $this->load->model('studente_model');
        $this->data['corsi']=$this->studente_model->tab_sceltacorsistudente($id,$corsolaurea,$semestre,$annoaccademico,'M');
        $this->data['seminari']=$this->studente_model->tab_sceltacorsistudente($id,$corsolaurea,$semestre,$annoaccademico,'S');
        $this->data['studente'] = $this->studente_model->trova_nome_studente_da_matricola($id);
        $this->data['MATRICOLA'] = $id;
        $this->data['corsolaurea'] = $corsolaurea;
        $this->data['semestre'] = $semestre;
        $this->data['annoaccademico'] = $annoaccademico;
        $this->data['semestrecorso'] = $semestrecorso;

        $this->renderView('backend' . DIRECTORY_SEPARATOR . 'studente'. DIRECTORY_SEPARATOR . 'sceltacorsi');
    }    

    public function scelta_corsi_studente_salva($id,$corsolaurea,$n_corsi)
    {
        $this->load->model('studente_model');
        $post=$this->input->post();
        $c=0;
        for ($i=1; $i<=$n_corsi; $i++) {
            $tipo=substr($post['sigla_'.$i],0,1);
            $this->studente_model->EliminaEsamePianoStudiStudente($id,$corsolaurea,$post['CORSI_'.$i]);
            if ($post['tipo_'.$i]!=''){
                if ($tipo=='M'){
                    $c+=1;
                }
                $this->studente_model->InserisciEsamePianoStudiStudente($id,$corsolaurea,$post['sigla_'.$i],$post['CORSI_'.$i],$post['tipo_'.$i]);
            }
        }
        if ($corsolaurea==='210' && ($c<2 || $c>6)){
            echo "<script>alert('Per la licenza è necessario scegliere dai 2 ai 6 corsi');</script>";
            $this->scelta_corsi_studente($id,$corsolaurea,$post['semestre'],$post['annoaccademico']);
        }else{
            echo "<script>alert('Dati salvati');</script>";
            echo "<script>window.close();</script>";
            exit();
        }
    }

//    public function studente_preiscrizione($id,$upload_errato=NULL,$lingua='IT') {
    public function studente_preiscrizione($id,$upload_errato=NULL,$lingua=NULL) {
        $this->data['sidebar'] = $this->buildSidebar($this->sidebar, 43);
        $this->load->model('studente_model');
        $this->load->model('tabelle_model');
        $tab_parametri_preiscrizione=$this->tabelle_model->tab_parametri_preiscrizione();
        if ($this->studente_model->IsSegreteria($_SESSION['user_id'])==='6'){
            $lingua='IT';
            $_SESSION['lingua']='IT';
        }
        if ($lingua==NULL) {
            if (isset($_SESSION['lingua'])){
                $lingua=$_SESSION['lingua'] ;
            }else{
                $lingua='IT';
            }
        }
        $this->data['lingua'] = $lingua;
        $_SESSION['lingua'] = $lingua;
        if ($upload_errato=='NULL'){
           $upload_errato='';
        }        
        if ($upload_errato!=''){
            if ($upload_errato!='uploadok'){
                $this->data['upload_errato']=$upload_errato;
                if ($upload_errato=='_File'){
                    $this->data['messaggio']="Caricamento file fallito: tipo di file non consentito la dimensione non deve superiore i 2 megabyte ";
                }elseif ($upload_errato=='FileEsistente'){
//                    $this->data['messaggio']="Caricamento file fallito: esiste già un file con questo nome";
                    $this->data['messaggio']=$_SESSION['avviso_importazione'].", non caricato già presente file con lo stesso nome";
                    
                }else{
                    if ($lingua=='IT'){
                        $this->data['messaggio']="Caricamento file fallito: tipo di file consentito ".$upload_errato." e la dimensione non deve superiore i 2 megabyte ";
                    }elseif ($lingua=='IN'){
                        $this->data['messaggio']="File upload failed: file type allowed ".$upload_errato." and the size must not exceed 2 megabytes ";
                    }
                }
            }
            if ($_SESSION['tab_attivo_studente']!='tab20'){
                $_SESSION['tab_attivo_studente']='tab6';
            }
        }        

        $qry = 'select studente_preiscrizione.* from studente_preiscrizione as studente';

        if($tab_parametri_preiscrizione['PREISCRIZIONI_SCHEDA']=='0'){
            $this->data['page_heading'] = 'Scheda preiscrizione';
        }else{
            $this->data['page_heading']='Scheda iscrizione';
        }
        
        $where=' where studente.deleted=0 and studente.ID='.$id;
        IF (!isset($_SESSION['tab_attivo_studente'])){
            $_SESSION['tab_attivo_studente'] = 'tab1';
        }
        $this->data['tab_studente'] = $this->studente_model->tab_studente_preiscrizione($id);
        if ($tab_parametri_preiscrizione['PREISCRIZIONI_SCHEDA']=='0'){
            if (!isset($this->data['tab_studente']['CERTIFICATOPREISCRIZIONE'])
                || $this->data['tab_studente']['CERTIFICATOPREISCRIZIONE']=='N'){
                $_SESSION['tab_attivo_studente'] = 'tab1';
            }
        }
        if ($tab_parametri_preiscrizione['PREISCRIZIONI_SCHEDA']=='1' && $this->data['tab_studente']['ISCRIZIONE_INIZIO']=='0'){
            if ($this->data['tab_studente']['SESSO']!=''){
                $this->data['tab_studente']['ISCRIZIONE_INIZIO']='1';
                $this->data['tab_studente']['TAB']='1';
                $_SESSION['tab_attivo_studente'] = 'tab1';
            }
        }
        //$this->data['tab_note_anagrafiche'] = $this->studente_model->tab_note_anagrafiche($id);
        $this->data['tab_statocivile'] = $this->studente_model->tab_statocivile();
        $this->data['tab_iscrizioni'] = $this->studente_model->tab_preiscrizioni($id); 
        $this->data['tab_titoli_accademici'] = $this->studente_model->tab_titoli_accademici_preiscrizione($id);
        $this->data['tab_diocesi'] = $this->studente_model->tab_diocesi($this->data['tab_studente']['DIOCESI']);
        $this->data['tab_ordine'] = $this->studente_model->tab_ordine($this->data['tab_studente']['ORDINE']);
        $this->data['tab_collegio'] = $this->studente_model->tab_collegio($this->data['tab_studente']['COLLEGIO']);
//        $this->data['tab_collegi'] = $this->tabelle_model->tab_collegi();
        if (!isset($this->data['tab_studente']['COLLEGIO'])){
            $this->data['tab_collegio']['COLLEGIO']='';
        }
        $this->data['tab_lingue_moderne'] = $this->studente_model->tab_lingue_moderne();

        $this->data['tab_studente_residenza'] = $this->studente_model->tab_dati_nazione($this->data['tab_studente']['RESNAZI']);
        $this->data['tab_studente_residenza']['PROVINCIA'] = $this->studente_model->tab_dati_provincia($this->data['tab_studente']['RESPROV']);

        $this->data['tab_studente_recapito']['PROVINCIA'] = $this->studente_model->tab_dati_provincia($this->data['tab_studente']['RECPROV']);

        $this->data['tab_studente_nascita'] = $this->studente_model->tab_dati_nazione($this->data['tab_studente']['NASCNAZI']);
        $this->data['tab_studente_nascita']['PROVINCIA'] = $this->studente_model->tab_dati_provincia($this->data['tab_studente']['NASCPROV']);

        //serve per la griglia iscrizioni studente
        $this->data['tab_anno_accademico'] = $this->studente_model->tab_anno_accademico();
        $this->data['tab_corsidilaurea'] = $this->studente_model->tab_corsidilaurea();
        $this->data['tab_titolistudio'] = $this->studente_model->tab_titolistudio();
        $this->data['tab_indirizzolaurea'] = $this->studente_model->tab_indirizzolaurea();
        $this->data['tab_tipotitolosup'] = $this->studente_model->tab_tipotitolosup();
        $this->data['tab_universitatrasf'] = $this->studente_model->tab_universitatrasf();
        $this->data['tab_tipodocumentazione'] = $this->studente_model->tab_tipodocumentazione();
        $this->data['tab_istituzione_provenienza'] = $this->studente_model->tab_istituzione_provenienza();
        $this->data['tab_studente_istituzione_provenienza'] = $this->studente_model->tab_dati_istituzione_provenienza($this->data['tab_studente']['ISTITUTO_PROVENIENZA']);

        $this->data['CRUIPRO'] ='1';
//        if (!isset($this->data['tab_studente']['ISTITUTO_PROVENIENZA']) && !isset($this->data['tab_studente']['ISTITUTO_PROVENIENZA_ALTRO'])) {
        if (!isset($this->data['tab_studente']['ISTITUTO_PROVENIENZA']) || $this->data['tab_studente']['ISTITUTO_PROVENIENZA']=='999') {
            $this->data['CRUIPRO'] ='0';
        }
//INIZIO VERIFICA DOCUMENTI INSERITI 
        $doc_inseriti=1;
        if ($doc_inseriti==1 && isset($this->data['tab_studente']['FOTOGRAF']) && $this->data['tab_studente']['FOTOGRAF']=='S') {
           $doc_inseriti=1; 
        }else{
           $doc_inseriti=0; 
        }
        if ($doc_inseriti==1 && isset($this->data['tab_studente']['TITOLOSTUDIO_PDF']) && $this->data['tab_studente']['TITOLOSTUDIO_PDF']=='S') {
           $doc_inseriti=1; 
        }else{
           $doc_inseriti=0; 
        }
        if ($doc_inseriti==1 && isset($this->data['tab_studente']['AUTSUP']) && $this->data['tab_studente']['AUTSUP']=='S') {
           $doc_inseriti=1; 
        }else{
           $doc_inseriti=0; 
        }
        if ($doc_inseriti==1 && isset($this->data['tab_studente']['PRESAINCARICO']) && $this->data['tab_studente']['PRESAINCARICO']=='S') {
           $doc_inseriti=1; 
        }else{
           $doc_inseriti=0; 
        }
        if ($this->data['tab_studente']['CORSOLAUREA']>'800' && $this->data['CRUIPRO']=='1'){
            if ($doc_inseriti==1 && isset($this->data['tab_studente']['AUT_UNIV']) && $this->data['tab_studente']['AUT_UNIV']=='S') {
               $doc_inseriti=1; 
            }else{
               $doc_inseriti=0; 
            }
        }
        if ($this->data['tab_studente']['CORSOLAUREA']>'800' && (isset($this->data['tab_studente']['ISTITUTO_PROVENIENZA']) || isset($this->data['tab_studente']['ISTITUTO_PROVENIENZA_ALTRO']))){
            if ($doc_inseriti==1 && isset($this->data['tab_studente']['CERT_ISCR_ALTRA_UNIV']) && $this->data['tab_studente']['CERT_ISCR_ALTRA_UNIV']=='S') {
               $doc_inseriti=1; 
            }else{
               $doc_inseriti=0; 
            }
        }
        if ($this->data['tab_studente']['CORSOLAUREA']=='230'){
            if ($doc_inseriti==1 && isset($this->data['tab_studente']['TESI_LICENZA']) && $this->data['tab_studente']['TESI_LICENZA']=='S') {
               $doc_inseriti=1; 
            }else{
               $doc_inseriti=0; 
            }
            if ($doc_inseriti==1 && isset($this->data['tab_studente']['DICHIARAZIONE_PERMANENZA_ROMA']) && $this->data['tab_studente']['DICHIARAZIONE_PERMANENZA_ROMA']=='S') {
               $doc_inseriti=1; 
            }else{
               $doc_inseriti=0; 
            }
        }
        if ($this->data['tab_studente']['CORSOLAUREA']<='250' || ($this->data['tab_studente']['CORSOLAUREA']=='888' && $this->data['CRUIPRO']=='0')){
            if ($doc_inseriti==1 && isset($this->data['tab_studente']['LATINO']) && $this->data['tab_studente']['LATINO']=='S') {
               $doc_inseriti=1; 
            }else{
               $doc_inseriti=0; 
            }
            if ($doc_inseriti==1 && isset($this->data['tab_studente']['GRECO']) && $this->data['tab_studente']['GRECO']=='S') {
               $doc_inseriti=1; 
            }else{
               $doc_inseriti=0; 
            }
        }
        if ($this->data['tab_studente']['CITTADI2']!='1'){
            if ($doc_inseriti==1 && isset($this->data['tab_studente']['ITASTRANIERI']) && $this->data['tab_studente']['ITASTRANIERI']=='S') {
               $doc_inseriti=1; 
            }else{
               $doc_inseriti=0; 
            }
            if ($doc_inseriti==1 && isset($this->data['tab_studente']['permessosogg']) && $this->data['tab_studente']['permessosogg']=='S') {
               $doc_inseriti=1; 
            }else{
               $doc_inseriti=0; 
            }
        }
        $this->data['doc_inseriti'] =$doc_inseriti;
//FINE VERIFICA DOCUMENTI INSERITI 
        
        if ($this->studente_model->IsSegreteria($_SESSION['user_id'])==='6'){
            $this->data['tipo_utente']='segreteria';
        }
        elseif ($this->studente_model->IsPreiscrizione($_SESSION['user_id'])==='7'){
            $this->data['tipo_utente']='preiscrizione';
        }
        else{
            $this->data['tipo_utente']='';
        }
        if ($lingua=='IT'){
            $this->data['campo_COGNOME']=$this->ControllaCampiObbligatori('myForm','COGNOME','Inserire il cognome');
            $this->data['campo_NOMESTUD']=$this->ControllaCampiObbligatori('myForm','NOMESTUD','Inserire il nome');
            $this->data['campo_NASCDATA']=$this->ControllaFormatoData('myForm','NASCDATA','data di nascita',true);
            $this->data['campo_NASCCOMUNE']=$this->ControllaCampiObbligatori('myForm','NASCCOMUNE','Inserire il luogo di nascita');
            $this->data['campo_SESSO']=$this->ControllaCampiObbligatori('myForm','SESSO','Scegliere il sesso');
            $this->data['campo_NASCNAZI']=$this->ControllaCampiObbligatori('myForm','ID_nazione','Inserire la nazione di nascita');
            $this->data['campo_NASCPROV']=$this->ControllaCampiObbligatori('myForm','ID_provincia','Inserire la provincia nascita');
            $this->data['campo_STATOCIV']=$this->ControllaCampiObbligatori('myForm','STATOCIV','Scegliere lo stato religioso');
            $this->data['campo_CITTADI2']=$this->ControllaCampiObbligatori('myForm','ID_cittadinanza','Inserire la cittadinanza attuale');
            $this->data['campo_email']=$this->ControllaCampiObbligatori('myForm','email','Inserire l\'indirizzo di posta elettronica');
            $this->data['campo_CORSOLAUREA']=$this->ControllaCampiObbligatori('myForm','CORSOLAUREA','la scelta del tipo di iscrizione è obbligatoria');
            $this->data['campo_TITOLOSTUDIO']=$this->ControllaCampiObbligatori('myForm','TITOLOSTUDIO','la scelta del titolo di studio è obbligatoria');

            $this->data['campo_SUPERIORE']=$this->ControllaCampiObbligatori('myForm','SUPERIORE','Inserire il nome del Superiore/Vescovo');
            $this->data['campo_SEMAIL']=$this->ControllaCampiObbligatori('myForm','SEMAIL','Inserire l\'email del Superiore/Vescovo');
            $this->data['campo_CERTIFICATOPREISCRIZIONE']=$this->ControllaCampiObbligatori('myForm','CERTIFICATOPREISCRIZIONE','Inserire se si vuole il certificato di preiscrizione');
            $this->data['campo_COLLEGIO']=$this->ControllaCampiObbligatori('myForm','COLLEGIO','Inserire il nome del collegio');
            $this->data['campo_CERTNASC']=$this->ControllaCampiCheckObbligatori('myForm','CERTNASC','Caricare il file della carta d\'identità in formato pdf','N');
            $this->data['campo_CERTNASC_TIPO']=$this->ControllaCampiObbligatori('myForm','CERTNASC_TIPO','la scelta del tipo di documento è obbligagoria');
            $this->data['campo_CERTNASC_NUMERO']=$this->ControllaCampiObbligatori('myForm','CERTNASC_NUMERO','inserire il numero del documento');
            $this->data['campo_CERTNASC_DATARILASCIO']=$this->ControllaFormatoData('myForm','CERTNASC_DATARILASCIO','data rilascio documento',true);
            $this->data['campo_CERTNASC_DATASCADENZA']=$this->ControllaFormatoData('myForm','CERTNASC_DATASCADENZA','data scadenza documento',true);
            $this->data['campo_AUTSUP']=$this->ControllaCampiCheckObbligatori('myForm','AUTSUP','Caricare il file dell\'autorizzazione del superiore regligiso in formato pdf','N');
            $this->data['campo_PRESAINCARICO']=$this->ControllaCampiCheckObbligatori('myForm','PRESAINCARICO','Caricare il file della presa in carico in formato pdf','N');
            $this->data['campo_TITOLOSTUDIO_PDF']=$this->ControllaCampiCheckObbligatori('myForm','TITOLOSTUDIO_PDF','Caricare il file del titolo studio in formato pdf','N');
        }elseif ($lingua=='IN'){
            $this->data['campo_COGNOME']=$this->ControllaCampiObbligatori('myForm','COGNOME','Enter last name');
            $this->data['campo_NOMESTUD']=$this->ControllaCampiObbligatori('myForm','NOMESTUD','Enter name');
            $this->data['campo_NASCDATA']=$this->ControllaFormatoData_IN('myForm','NASCDATA','Date of Birth',true);
            $this->data['campo_NASCCOMUNE']=$this->ControllaCampiObbligatori('myForm','NASCCOMUNE','Enter Place of Birth');
            $this->data['campo_SESSO']=$this->ControllaCampiObbligatori('myForm','SESSO','Choose your sex');
            $this->data['campo_NASCNAZI']=$this->ControllaCampiObbligatori('myForm','ID_nazione','Enter Birth Country');
            $this->data['campo_NASCPROV']=$this->ControllaCampiObbligatori('myForm','ID_provincia','Enter Birth Province');
            $this->data['campo_STATOCIV']=$this->ControllaCampiObbligatori('myForm','STATOCIV','Choose Religious status');
            $this->data['campo_CITTADI2']=$this->ControllaCampiObbligatori('myForm','ID_cittadinanza','Enter Current Citizenship');
            $this->data['campo_email']=$this->ControllaCampiObbligatori('myForm','email','Enter Email address');
            $this->data['campo_CORSOLAUREA']=$this->ControllaCampiObbligatori('myForm','CORSOLAUREA','the choice of the Enrollment type is mandatory');
            $this->data['campo_TITOLOSTUDIO']=$this->ControllaCampiObbligatori('myForm','TITOLOSTUDIO','the choice of the Title of study is mandatory');

            $this->data['campo_SUPERIORE']=$this->ControllaCampiObbligatori('myForm','SUPERIORE','Enter Name of Superior or Bishop');
            $this->data['campo_SEMAIL']=$this->ControllaCampiObbligatori('myForm','SEMAIL','Enter Email of Superior or Bishop');
            $this->data['campo_CERTIFICATOPREISCRIZIONE']=$this->ControllaCampiObbligatori('myForm','CERTIFICATOPREISCRIZIONE','Enter the pre-enrollment certificate if you want');
            $this->data['campo_COLLEGIO']=$this->ControllaCampiObbligatori('myForm','COLLEGIO','Enter Collage Name');
            $this->data['campo_CERTNASC']=$this->ControllaCampiCheckObbligatori('myForm','CERTNASC','Upload Identity document','N');
            $this->data['campo_CERTNASC_TIPO']=$this->ControllaCampiObbligatori('myForm','CERTNASC_TIPO','the choise of Document type is mandatory');
            $this->data['campo_CERTNASC_NUMERO']=$this->ControllaCampiObbligatori('myForm','CERTNASC_NUMERO','Enter Document number');
            $this->data['campo_CERTNASC_DATARILASCIO']=$this->ControllaFormatoData_IN('myForm','CERTNASC_DATARILASCIO','Document issue date',true);
            $this->data['campo_CERTNASC_DATASCADENZA']=$this->ControllaFormatoData_IN('myForm','CERTNASC_DATASCADENZA','Document expiration date',true);
            $this->data['campo_AUTSUP']=$this->ControllaCampiCheckObbligatori('myForm','AUTSUP','Upload Authorization of religious superior','N');
            $this->data['campo_PRESAINCARICO']=$this->ControllaCampiCheckObbligatori('myForm','PRESAINCARICO','Upload Assumption of responsibility','N');
            $this->data['campo_TITOLOSTUDIO_PDF']=$this->ControllaCampiCheckObbligatori('myForm','TITOLOSTUDIO_PDF','Upload Study title','N');
        }
//        $this->data['campo_IND_SUP1']=$this->ControllaCampiObbligatori('myForm','IND_SUP1','Inserire l\'indirizzo del Superiore/Vescovo');
//        $this->data['campo_S_COUNTRY']=$this->ControllaCampiObbligatori('myForm','S_COUNTRY','Inserire la nazione del Superiore/Vescovo');
//        $this->data['campo_SUP_CITY']=$this->ControllaCampiObbligatori('myForm','SUP_CITY','Inserire il comune del Superiore/Vescovo');
//        $this->data['campo_SZIPEUR']=$this->ControllaCampiObbligatori('myForm','SZIPEUR','Inserire il cap del Superiore/Vescovo');
//        $this->data['campo_SUP_STATE']=$this->ControllaCampiObbligatori('myForm','SUP_STATE','Inserire la provincia del Superiore/Vescovo');
        
        
//        $this->data['campo_COLLEGIO']=$this->ControllaCampiObbligatori('myForm','ID_collegio','Inserire il nome del collegio');

        //$this->data['campo_DATAAGGIORN']=$this->ControllaFormatoData('myForm','DATAAGGIORN','data aggiornamento dati',false);
        $this->data['campo_CERTNASC_TIPO']=$this->ControllaCampiObbligatori('myForm','CERTNASC_TIPO','Inserire il tipo di documento');
        $this->data['campo_CERTNASC_NUMERO']=$this->ControllaCampiObbligatori('myForm','CERTNASC_NUMERO','Inserire il numero del documento');
        $this->data['campo_CERTNASC_DATARILASCIO']=$this->ControllaFormatoData('myForm','CERTNASC_DATARILASCIO','data rilascio documento',true);
        $this->data['campo_CERTNASC_DATASCADENZA']=$this->ControllaFormatoData('myForm','CERTNASC_DATASCADENZA','data scadenza documento',true);
//        $this->data['campo_datascad_permessosogg']=$this->ControllaFormatoData('myForm','datascad_permessosogg','data scadenza permesso di soggiorno',true);
//        $this->data['campo_datascad_extracollegio']=$this->ControllaFormatoData('myForm','datascad_extracollegio','data scadenza extra collegialità',false);
//        $this->data['campo_PRIVACY']=$this->ControllaFormatoData('myForm','PRIVACY','data firmato accordo privacy',false);
//        $this->data['campo_PAGAMENTODATA']=$this->ControllaFormatoData('myForm','PAGAMENTODATA','data presunta di pagamento',true);
//        $this->data['campo_CATEGORIA']=$this->ControllaCampiObbligatori('myForm','CATEGORIA','la scelta della categoria è obbligagoria');
        $this->data['campo_PAGAMENTOMOD']=$this->ControllaCampiObbligatori('myForm','PAGAMENTOMOD','la scelta della modalità di pagamento è obbligatoria');
//        $this->data['campo_NOME_PAGANTE']=$this->ControllaCampiObbligatori('myForm','NOME_PAGANTE','il nome del pagante è obbligatoria');
//        $this->data['campo_EMAIL_PAGANTE']=$this->ControllaCampiObbligatori('myForm','EMAIL_PAGANTE','l\'email del pagante è obbligatoria');

//        $this->data['campo_FOTOGRAF']=$this->ControllaCampiCheckObbligatori('myForm','FOTOGRAF','Caricare il file della foto in formato jpg','N');

        //serve per la griglia iscrizioni studente

////// SCELTA MODALITA' PAGAMENTO
        if ($tab_parametri_preiscrizione['PREISCRIZIONI_SCHEDA']=='1'){
            $corso_laurea='';
            if(isset($this->data['tab_studente']['CORSOLAUREA'])){
                $corso_laurea=$this->data['tab_studente']['CORSOLAUREA'];
            }
            $specchietto_corso='';
            $specchietto_titolo='';
            $specchietto='';
            $specchietto_nota1='';
            $specchietto_nota2='';            
            $specchietto=array();
            $data_pagamento = array();
            
            //verifica se gli importitasse dell'anno accademico sono stati caricati
            $TASSE_CARICATE = $this->tabelle_model->ultimo_anno_accademico_importitasse();
            if ($this->data['tab_studente']['ANNOACCA']<=$TASSE_CARICATE){
                switch ($corso_laurea) {
                    case '210':
                        $IMPORTOTASSA_INTERA = $this->tabelle_model->trova_importo_tassa('RU',$this->data['tab_studente']['ANNOACCA'],$this->data['tab_studente']['CORSOLAUREA'],'1');
                        $IMPORTOTASSA_RATA = $this->tabelle_model->trova_importo_tassa('1R',$this->data['tab_studente']['ANNOACCA'],$this->data['tab_studente']['CORSOLAUREA'],'1');
                        $PAGAMENTO = $this->tabelle_model->trova_data_scadenza('FINEISCRIZIONI_SEM1');
                        $PAGANTICIPATO = $this->tabelle_model->trova_data_scadenza('SCONTOISCRIZIONE_SEM1');
                        $PENALE = $this->tabelle_model->trova_importo_tassa('MG',$this->data['tab_studente']['ANNOACCA'],$this->data['tab_studente']['CORSOLAUREA'],'');
                        $SCONTO = $this->tabelle_model->trova_importo_tassa('SC',$this->data['tab_studente']['ANNOACCA'],$this->data['tab_studente']['CORSOLAUREA'],'');
                        $specchietto_corso='LICENZA IN TEOLOGIA MORALE';
                        $specchietto_titolo='Iscrizione annuale 1° anno';
                        $specchietto[0]['tipo']='Rata unica';
                        $specchietto[0]['causale_tassa']='1';
                        $specchietto[0]['importo']=$IMPORTOTASSA_INTERA; 
                        $specchietto[1]['tipo']='2 Rate';
                        $specchietto[1]['causale_tassa']='2';
                        $specchietto[1]['importo']=$IMPORTOTASSA_RATA; 
                        $specchietto_nota1='La data di scadenza per il pagamento è il '.$PAGAMENTO.', <br/>se si paga dopo questa data verrà applicata una penale di Euro '.$PENALE;
                        $specchietto_nota2='Se si paga la Rata unica entro il '.$PAGANTICIPATO.', <br/> si ha diritto ad uno sconto di Euro '.$SCONTO;
                        $data_pagamento[0]['etichetta'] = $PAGAMENTO;
                        $data_pagamento[0]['valore'] = substr($PAGAMENTO,6,4).'-'.substr($PAGAMENTO,3,2).'-'.substr($PAGAMENTO,0,2);
                        $data_pagamento[1]['etichetta'] = $PAGANTICIPATO;
                        $data_pagamento[1]['valore'] = substr($PAGANTICIPATO,6,4).'-'.substr($PAGANTICIPATO,3,2).'-'.substr($PAGANTICIPATO,0,2);
                        break;
                    case '230':
                        $IMPORTOTASSA_INTERA = $this->tabelle_model->trova_importo_tassa('RU',$this->data['tab_studente']['ANNOACCA'],$this->data['tab_studente']['CORSOLAUREA'],'1');
                        $IMPORTOTASSA_RATA = $this->tabelle_model->trova_importo_tassa('1R',$this->data['tab_studente']['ANNOACCA'],$this->data['tab_studente']['CORSOLAUREA'],'1');
                        $PAGAMENTO = $this->tabelle_model->trova_data_scadenza('FINEISCRIZIONI_SEM1');
    //                    $PAGANTICIPATO = $this->tabelle_model->trova_data_scadenza('SCONTOISCRIZIONE_SEM1');
                        $PENALE = $this->tabelle_model->trova_importo_tassa('MG',$this->data['tab_studente']['ANNOACCA'],$this->data['tab_studente']['CORSOLAUREA'],'');
    //                    $SCONTO = $this->tabelle_model->trova_importo_tassa('SC',$this->data['tab_studente']['ANNOACCA'],$this->data['tab_studente']['CORSOLAUREA'],'');
                        $specchietto_corso='DOTTORATO IN TEOLOGIA MORALE';
                        $specchietto_titolo='Iscrizione per il biennio';
                        $specchietto[0]['tipo']='Rata unica';
                        $specchietto[0]['causale_tassa']='1';
                        $specchietto[0]['importo']=$IMPORTOTASSA_INTERA; 
                        $specchietto[1]['tipo']='2 Rate';
                        $specchietto[1]['causale_tassa']='2';
                        $specchietto[1]['importo']=$IMPORTOTASSA_RATA; 
                        $specchietto_nota1='La data di scadenza per il pagamento è il '.$PAGAMENTO.', <br/>se si paga dopo questa data verrà applicata una penale di Euro '.$PENALE;
                        $specchietto_nota2='';
                        $data_pagamento[0]['etichetta'] = $PAGAMENTO;
                        $data_pagamento[0]['valore'] = substr($PAGAMENTO,6,4).'-'.substr($PAGAMENTO,3,2).'-'.substr($PAGAMENTO,0,2);
                        break;
                    case '240':
                        $IMPORTOTASSA_INTERA = $this->tabelle_model->trova_importo_tassa('RU',$this->data['tab_studente']['ANNOACCA'],$this->data['tab_studente']['CORSOLAUREA'],'');
                        $PAGAMENTO = $this->tabelle_model->trova_data_scadenza('FINEISCRIZIONI_SEM1');
                        $PENALE = $this->tabelle_model->trova_importo_tassa('MG',$this->data['tab_studente']['ANNOACCA'],$this->data['tab_studente']['CORSOLAUREA'],'');
                        $specchietto_corso='POST DOTTORATO IN TEOLOGIA MORALE';
                        $specchietto_titolo='Iscrizione annuale';
                        $specchietto[0]['tipo']='Rata unica';
                        $specchietto[0]['causale_tassa']='1';
                        $specchietto[0]['importo']=$IMPORTOTASSA_INTERA; 
                        $specchietto_nota1='La data di scadenza per il pagamento è il '.$PAGAMENTO.', <br/>se si paga dopo questa data verrà applicata una penale di Euro '.$PENALE;
                        $specchietto_nota2='';
                        $data_pagamento[0]['etichetta'] = $PAGAMENTO;
                        $data_pagamento[0]['valore'] = substr($PAGAMENTO,6,4).'-'.substr($PAGAMENTO,3,2).'-'.substr($PAGAMENTO,0,2);
                        break;
                    case '250':
                        $IMPORTOTASSA_INTERA = $this->tabelle_model->trova_importo_tassa('RU',$this->data['tab_studente']['ANNOACCA'],$this->data['tab_studente']['CORSOLAUREA'],'');
                        $PAGAMENTO = $this->tabelle_model->trova_data_scadenza('FINEISCRIZIONI_SEM1');
                        $PENALE = $this->tabelle_model->trova_importo_tassa('MG',$this->data['tab_studente']['ANNOACCA'],$this->data['tab_studente']['CORSOLAUREA'],'');
                        $specchietto_corso='DIPLOMA IN TEOLOGIA MORALE';
                        $specchietto_titolo='Iscrizione annuale';
                        $specchietto[0]['tipo']='Rata unica';
                        $specchietto[0]['causale_tassa']='1';
                        $specchietto[0]['importo']=$IMPORTOTASSA_INTERA; 
                        $specchietto_nota1='La data di scadenza per il pagamento è il '.$PAGAMENTO.', <br/>se si paga dopo questa data verrà applicata una penale di Euro '.$PENALE;
                        $specchietto_nota2='';
                        $data_pagamento[0]['etichetta'] = $PAGAMENTO;
                        $data_pagamento[0]['valore'] = substr($PAGAMENTO,6,4).'-'.substr($PAGAMENTO,3,2).'-'.substr($PAGAMENTO,0,2);
                        break;
                    case '888':
                        $IMPORTOTASSA_INTERA = $this->tabelle_model->trova_importo_tassa('SR',$this->data['tab_studente']['ANNOACCA'],$this->data['tab_iscrizioni'][0]['CORSOLAUREA'],'');
                        $specchietto_corso='STUDENTE STRAORDINARIO';
                        $PAGAMENTO = $this->tabelle_model->trova_data_scadenza('FINEISCRIZIONI_SEM1');
                        $PENALE = $this->tabelle_model->trova_importo_tassa('MG',$this->data['tab_studente']['ANNOACCA'],$this->data['tab_studente']['CORSOLAUREA'],'');
                        $specchietto_titolo='Iscrizione per ogni corso';
                        $specchietto[0]['tipo']='Rata unica';
                        $specchietto[0]['causale_tassa']='1';
                        $specchietto[0]['importo']=$IMPORTOTASSA_INTERA; 
                        $specchietto_nota1='La data di scadenza per il pagamento è il '.$PAGAMENTO.', <br/>se si paga dopo questa data verrà applicata una penale di Euro '.$PENALE;
                        $specchietto_nota2='';
                        $data_pagamento[0]['etichetta'] = $PAGAMENTO;
                        $data_pagamento[0]['valore'] = substr($PAGAMENTO,6,4).'-'.substr($PAGAMENTO,3,2).'-'.substr($PAGAMENTO,0,2);
                        break;
                    case '999':
                        $IMPORTOTASSA_INTERA = $this->tabelle_model->trova_importo_tassa('UD',$this->data['tab_studente']['ANNOACCA'],$this->data['tab_iscrizioni'][0]['CORSOLAUREA'],'');
                        $specchietto_corso='STUDENTE UDITORE';
                        $PAGAMENTO = $this->tabelle_model->trova_data_scadenza('FINEISCRIZIONI_SEM1');
                        $PENALE = $this->tabelle_model->trova_importo_tassa('MG',$this->data['tab_studente']['ANNOACCA'],$this->data['tab_studente']['CORSOLAUREA'],'');
                        $specchietto_titolo='Iscrizione per ogni corso';
                        $specchietto[0]['tipo']='Rata unica';
                        $specchietto[0]['causale_tassa']='1';
                        $specchietto[0]['importo']=$IMPORTOTASSA_INTERA; 
                        $specchietto_nota1='La data di scadenza per il pagamento è il '.$PAGAMENTO.', <br/>se si paga dopo questa data verrà applicata una penale di Euro '.$PENALE;
                        $specchietto_nota2='';
                        $data_pagamento[0]['etichetta'] = $PAGAMENTO;
                        $data_pagamento[0]['valore'] = substr($PAGAMENTO,6,4).'-'.substr($PAGAMENTO,3,2).'-'.substr($PAGAMENTO,0,2);
                        break;
                    default:
                        break;
                }
                $this->data['specchietto_corso']=$specchietto_corso;
                $this->data['specchietto_titolo']=$specchietto_titolo;
                $this->data['specchietto']=$specchietto;
                $this->data['specchietto_nota1']=$specchietto_nota1;
                $this->data['specchietto_nota2']=$specchietto_nota2;
                $this->data['data_pagamento']=$data_pagamento;                        
            }
        }
////// FINE SCELTA MODALITA' PAGAMENTO 
////// RICERCA FILE ALLEGATI
//        $f1 = glob('./assets/images/preiscrizione/'.$id.'.*');
//        if (isset($f1[0])){
//            $this->data['file_Foto']=$f1[0];
//        }
//        $f1 = glob('./assets/images/preiscrizione/'.$id.'_DocumentoIdentita.*');
//        if (isset($f1[0])){
//            $this->data['file_DocumentoIdentita']=$f1[0];
//        }
////// FINE RICERCA FILE ALLEGATI       
        $this->searchBarsStudente();
        $myreset = '
            $(document).ready(function () {
                $(\'body\').on(\'hidden.bs.modal\', \'.modal\', function () {
                    $(this).removeData(\'bs.modal\');
            });
            });
        ';
        $this->add_scriptSource($myreset);

        ///////////////Cartella File
        if (!is_dir(FCPATH . 'assets/images/preiscrizione/'.$id.'/')){
            mkdir('./assets/images/preiscrizione/'.$id);
        }
        if (!is_dir(FCPATH . 'assets/images/preiscrizione/'.$id.'/File/')){
            mkdir('./assets/images/preiscrizione/'.$id.'/File');
        }
        $f1 = glob('./assets/images/preiscrizione/'.$id.'/File/*.*');
        if (isset($f1[0])){
            $this->data['elencofile']=$f1;
        }
        ///////////////
        if ($tab_parametri_preiscrizione['PREISCRIZIONI_SCHEDA']=='0'){
            $this->data['FormNascoste'] = [
                'id' => 'form_nascoste'
            ];
            $this->data['FormNascoste']['html'] = $this->renderView('backend' . DIRECTORY_SEPARATOR . 'preiscrizione' . DIRECTORY_SEPARATOR . 'form_nascoste', 'empty', true);
            if ($lingua=='IT'){
                $this->data['tab1'] = [
                    'id' => 'dati_personali',
                    'name' => 'Dati generali'
                ];
                $this->data['tab1']['html'] = $this->renderView('backend' . DIRECTORY_SEPARATOR . 'preiscrizione' . DIRECTORY_SEPARATOR . 'dati_personali_preiscrizione', 'empty', true);

                $this->data['tab6'] = [
                    'id' => 'dati_certificato',
                    'name' => 'Documenti per il certificato'
                ];
                $this->data['tab6']['html'] = $this->renderView('backend' . DIRECTORY_SEPARATOR . 'preiscrizione' . DIRECTORY_SEPARATOR . 'documenti_certificato', 'empty', true);
            }elseif($lingua=='IN'){
                $this->data['tab1'] = [
                    'id' => 'dati_personali',
                    'name' => 'General Data'
                ];
                $this->data['tab1']['html'] = $this->renderView('backend' . DIRECTORY_SEPARATOR . 'preiscrizione' . DIRECTORY_SEPARATOR . 'dati_personali_preiscrizione', 'empty', true);

                $this->data['tab6'] = [
                    'id' => 'dati_certificato',
                    'name' => 'Documents for the certificate'
                ];
                $this->data['tab6']['html'] = $this->renderView('backend' . DIRECTORY_SEPARATOR . 'preiscrizione' . DIRECTORY_SEPARATOR . 'documenti_certificato', 'empty', true);
            }
            $this->data['tab20'] = [
                'id' => 'file',
                'name' => 'File'
            ];
            $this->data['tab20']['html'] = $this->renderView('backend' . DIRECTORY_SEPARATOR . 'preiscrizione' . DIRECTORY_SEPARATOR . 'file', 'empty', true);
            
            $this->renderView('backend' . DIRECTORY_SEPARATOR . 'preiscrizione' . DIRECTORY_SEPARATOR . 'studente_preiscrizione');
            
        }elseif ($tab_parametri_preiscrizione['PREISCRIZIONI_SCHEDA']=='1'){
            $this->data['FormNascoste'] = [
                'id' => 'form_nascoste'
            ];
            $this->data['FormNascoste']['html'] = $this->renderView('backend' . DIRECTORY_SEPARATOR . 'preiscrizione' . DIRECTORY_SEPARATOR . 'form_nascoste', 'empty', true);

            $this->data['FormNascosteTitoliAccademici'] = [
                'id' => 'form_nascoste_titoli_accademici'
            ];
            $this->data['FormNascosteTitoliAccademici']['html'] = $this->renderView('backend' . DIRECTORY_SEPARATOR . 'preiscrizione' . DIRECTORY_SEPARATOR . 'form_nascoste_titoli_accademici', 'empty', true);

            $this->data['tab1'] = [
                'id' => 'dati_personali',
                'name' => 'Dati generali'
            ];
            $this->data['tab1']['html'] = $this->renderView('backend' . DIRECTORY_SEPARATOR . 'preiscrizione' . DIRECTORY_SEPARATOR . 'dati_personali', 'empty', true);

            $this->data['tab2'] = [
                'id' => 'indirizzi',
                'name' => 'Indirizzi'
            ];
            $this->data['tab2']['html'] = $this->renderView('backend' . DIRECTORY_SEPARATOR . 'preiscrizione' . DIRECTORY_SEPARATOR . 'indirizzi', 'empty', true);

            $this->data['tab3'] = [
                'id' => 'dati_iscrizione',
                'name' => 'Tipo Iscrizione'
            ];
            $this->data['tab3']['html'] = $this->renderView('backend' . DIRECTORY_SEPARATOR . 'preiscrizione' . DIRECTORY_SEPARATOR . 'dati_iscrizione', 'empty', true);
            
            $this->data['tab4'] = [
                'id' => 'tipo_pagamento',
                'name' => 'Tipo pagamento'
            ];
            $this->data['tab4']['html'] = $this->renderView('backend' . DIRECTORY_SEPARATOR . 'preiscrizione' . DIRECTORY_SEPARATOR . 'tipo_pagamento', 'empty', true);

            $this->data['tab5'] = [
                'id' => 'ordinario_religioso',
                'name' => 'Ordinario religioso'
            ];
            $this->data['tab5']['html'] = $this->renderView('backend' . DIRECTORY_SEPARATOR . 'preiscrizione' . DIRECTORY_SEPARATOR . 'ordinario_religioso', 'empty', true);

            $this->data['tab6'] = [
                'id' => 'documenti_requisiti',
                'name' => 'Documenti requisiti'
            ];
            $this->data['tab6']['html'] = $this->renderView('backend' . DIRECTORY_SEPARATOR . 'preiscrizione' . DIRECTORY_SEPARATOR . 'documenti_requisiti', 'empty', true);

            $this->data['tab7'] = [
                'id' => 'info_collegio',
                'name' => 'Info collegio'
            ];
            $this->data['tab7']['html'] = $this->renderView('backend' . DIRECTORY_SEPARATOR . 'preiscrizione' . DIRECTORY_SEPARATOR . 'info_collegio', 'empty', true);
            
            $this->data['tab8']['html'] = $this->renderTab8Preiscrizione($id); //Titoli accademici

            $this->data['tab20'] = [
                'id' => 'file',
                'name' => 'File'
            ];
            $this->data['tab20']['html'] = $this->renderView('backend' . DIRECTORY_SEPARATOR . 'preiscrizione' . DIRECTORY_SEPARATOR . 'file', 'empty', true);

            $this->renderView('backend' . DIRECTORY_SEPARATOR . 'preiscrizione' . DIRECTORY_SEPARATOR . 'studente');
        }
            
    }
    
    private function renderTab8Preiscrizione($id) {
        $this->data['tab8'] = [
            'id' => 'titoli_accademici',
            'name' => 'Titoli accademici'
        ];
        $this->load->library('components');
        $this->components->addDataTablePanel('titoliAccademici');
        return $this->renderView('backend' . DIRECTORY_SEPARATOR . 'preiscrizione' . DIRECTORY_SEPARATOR . 'titoli_accademici', 'empty', true);
    }

    private function renderTab7Preiscrizione($id) {
        $this->data['tab7'] = [
            'id' => 'dati_iscrizione',
            'name' => 'Iscrizione'
        ];
        $this->load->library('components');
        $this->components->addDataTablePanel('datiIscrizione');
        return $this->renderView('backend' . DIRECTORY_SEPARATOR . 'preiscrizione' . DIRECTORY_SEPARATOR . 'dati_iscrizione', 'empty', true);
    }

    /**
     * Modulo1
     */
    public function modulo_iscrizione_corsi($id,$corsolaurea,$semestre,$annoaccademico,$semestrecorso)
    {
        $this->load->library('tbswrapper');
        $this->load->model('studente_model');
        $this->load->model('tiny_model');
        $this->tbswrapper->tbsInstall_OpenTbsPlugin();
        

        //$row=$this->tiny_model->iscrizione(123457, 2018);
        $row=$this->studente_model->ModuloIscrizioneCorsi($id,$annoaccademico,$semestrecorso);
        if($semestre==='1'){
            $row['SEMESTRE'] = 'PRIMO';
        }else{
            $row['SEMESTRE'] = 'SECONDO';
        }
        if (isset($row)) {
            $data_tiny['MATRICOL']= $row['MATRICOL'];
            $data_tiny['COGNOME']= $row['COGNOME'];
            $data_tiny['NOME']= $row['NOME'];
            $data_tiny['ANNO_ACCADEMICO']= $row['ANNO_ACCADEMICO'];
            //$data_tiny['CATEGORIA']= $row['CATEGORIA'];
            $data_tiny['CORSO_LAUREA']= $row['CORSO_LAUREA'];
            $data_tiny['INDIRIZZO_LAUREA']= $row['INDIRIZZO_LAUREA'];
            //$data_tiny['ANNOCORSO']= $row['ANNOCORSO'];
            $data_tiny['SEMESTRECORSO']= $row['SEMESTRECORSO'];
            $data_tiny['DATAG']= date("d/m/Y H.i.s");
            $data_tiny['SEMESTRE']= $row['SEMESTRE'];
        }
        $this->tbswrapper->tbsData($data_tiny);
        $template=APPPATH.'views/stampe/mod_iscrizione_corsi.docx';
        $this->tbswrapper->tbsLoadTemplate1($template); 
        //$this->tbswrapper->OPENTBS_DEBUG_XML_CURRENT();

        // A recordset for merging tables
        //$data=$this->tiny_model->iscrizioneCorsi('M');
        $data=$this->studente_model->tab_sceltacorsistudente($id,$corsolaurea,$semestre,$annoaccademico,'M');

        // Merge data in the body of the document
        $this->tbswrapper->tbsMergeBlock('corsi', $data);

//        $data=$this->tiny_model->iscrizioneCorsi('S');
        $data=$this->studente_model->tab_sceltacorsistudente($id,$corsolaurea,$semestre,$annoaccademico,'S');

        // Merge data in the body of the document
        $this->tbswrapper->tbsMergeBlock('seminari', $data);
        
        
        //$this->tbswrapper->openTBS_DEBUG_XML_SHOW();
        $output_file_name ='aa_mod_iscrizione'. '_'.date('YmdHis').'.docx';
        $this->tbswrapper->openTBS_Download($output_file_name);
        
    }
    
    public function modulo_certificato_preiscrizione_prove($id){
        $amf=APPPATH;
        require_once(APPPATH.'TBS/tbs_class.php');
        require_once(APPPATH.'TBS/plugins/tbs_plugin_opentbs.php');

        $TBS = new clsTinyButStrong; 
        $TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN); 

        $TBS->OtbsConvertApostrophes = false;

//        $template=APPPATH.'views/stampe/mod_certificato_preiscrizione.docx';
        $template=APPPATH.'views/stampe/AMF.docx';

        $row['COGNOME']= 'FILICE';
        $row['NOME']= 'ANNA MARIA';

        $TBS->VarRef = $row;

        $TBS->LoadTemplate($template,OPENTBS_ALREADY_UTF8); 
        
// Opzioni di debug
// $TBS->Plugin(OPENTBS_DEBUG_XML_CURRENT, true); // Display the intented XML of the current sub-file, and exit.
// $TBS->Plugin(OPENTBS_DEBUG_INFO, true); // Display information about the document, and exit.
// $TBS->Plugin(OPENTBS_DEBUG_XML_SHOW); // Tells TBS to display information when the document is merged. No exit.        

        $output_file_name = $id . "-Certificato preiscrizione.docx";

        $TBS->Show(OPENTBS_DOWNLOAD, $output_file_name); 
    }

    public function modulo_certificato_preiscrizione($id)
    {
        $this->load->library('tbswrapper');
        $this->load->model('studente_model');
        //$this->load->model('tiny_model');
        $this->tbswrapper->tbsInstall_OpenTbsPlugin();

        //$row=$this->tiny_model->iscrizione(123457, 2018);
        $row=$this->studente_model->ModuloCertificatoPreiscrizione($id);
        if (isset($row)) {
            $data_tiny['COGNOME']= $row['COGNOME'];
            $data_tiny['NOME']= $row['NOMESTUD'];
            $data_tiny['NASCDATA']= $row['NASCDATA'];
            $data_tiny['NASCCOMUNE']= $row['NASCCOMUNE'];
            $data_tiny['STATO']= $row['STATO'];
            $data_tiny['CITTADINANZA']= $row['CITTADINANZA'];
            $data_tiny['TIPO_DOCUMENTO']= $row['TIPO_DOCUMENTO'];
            $data_tiny['CERTNASC_NUMERO']= $row['CERTNASC_NUMERO'];
            $data_tiny['CERTNASC_DATARILASCIO']= $row['CERTNASC_DATARILASCIO'];
            $data_tiny['CERTNASC_DATASCADENZA']= $row['CERTNASC_DATASCADENZA'];
            $data_tiny['TIPO_ISCRIZIONE']= $row['TIPO_ISCRIZIONE'];
            $data_tiny['ANNO1']= $row['ANNO1'];
            $data_tiny['ANNO2']= $row['ANNO2'];
            $data_tiny['INIZIOLEZIONI_SEM1']= $this->data_estesa($row['INIZIOLEZIONI_SEM1']);
            $data_tiny['FINELEZIONI_SEM2']= $this->data_estesa($row['FINELEZIONI_SEM2']);
            $data_tiny['PRESSO']= $row['PRESSO'];
            $data_tiny['INDIRIZZO']= $row['INDIRIZZO'];
            $data_tiny['COMUNE']= $row['COMUNE'];
            $data_tiny['CAP']= $row['CAP'];
            if (isset($row['PROV'])){
                $data_tiny['PROV']= $row['PROV'];
            }else{
                $data_tiny['PROV']= '';
            }
            if (isset($row['TELEFONO'])){
                $data_tiny['TELEFONO']= $row['TELEFONO'];
            }else{
                $data_tiny['TELEFONO']= '--';
            }
            $data_tiny['PRESAINCARICO_RESP']= $row['PRESAINCARICO_RESP'];
        }
        $this->tbswrapper->tbsData($data_tiny);
        $template=APPPATH.'views/stampe/mod_certificato_preiscrizione.docx';
        $this->tbswrapper->tbsLoadTemplate1($template); 
        //$this->tbswrapper->OPENTBS_DEBUG_XML_CURRENT();

        // A recordset for merging tables
        //$data=$this->tiny_model->iscrizioneCorsi('M');
        //$this->tbswrapper->openTBS_DEBUG_XML_SHOW();
        $output_file_name ='aa_mod_certificato_preiscrizione'. '_'.date('YmdHis').'.docx';
        $this->tbswrapper->openTBS_Download($output_file_name);
    }
    private function data_estesa($data){
        $m=date("m",strtotime($data));
        switch ($m){
            case 1:
                $mese='gennaio';
                break;
            case 2:
                $mese='febbraio';
                break;
            case 3:
                $mese='marzo';
                break;
            case 4:
                $mese='aprile';
                break;
            case 5:
                $mese='maggio';
                break;
            case 6:
                $mese='giugno';
                break;
            case 7:
                $mese='luglio';
                break;
            case 8:
                $mese='agosto';
                break;
            case 9:
                $mese='settembre';
                break;
            case 10:
                $mese='ottobre';
                break;
            case 11:
                $mese='novembre';
                break;
            case 12:
                $mese='dicembre';
                break;
        }
        $g=date("d",strtotime($data));
        switch($g){
            case 1:
                $giorno='1°';
                break;
            case 2:
                $giorno='2';
                break;
            case 3:
                $giorno='3';
                break;
            case 4:
                $giorno='4';
                break;
            case 5:
                $giorno='5';
                break;
            case 6:
                $giorno='6';
                break;
            case 7:
                $giorno='7';
                break;
            case 8:
                $giorno='8';
                break;
            case 9:
                $giorno='9';
                break;
            default:
                $giorno=date("d",strtotime($data));
        }
        $data=$giorno.' '.$mese.' '.date("Y",strtotime($data));
        return $data;
    }
    
    
    public function self_studente($id) {
        $this->data['sidebar'] = $this->buildSidebar($this->sidebar, 47);
        $this->load->model('studente_model');
        if ($id==='0'){
            if($this->studente_model->IsStudente($_SESSION['user_id'])==='8'){
                $id=$this->studente_model->MatricolaUsers($_SESSION['user_id'],'studente');
            }else{
                $this->data['sidebar'] = $this->buildSidebar($this->sidebar, 2);
                $this->data['tab_anno_accademico'] = $this->studente_model->tab_anno_accademico();
                $this->data['tab_corsidilaurea'] = $this->studente_model->tab_corsidilaurea();
                $this->data['tab_statocivile'] = $this->studente_model->tab_statocivile();
                $this->renderView('backend' . DIRECTORY_SEPARATOR . 'studenti_ricerca');
            }
        }
        $qry = 'select studente.* from studente as studente';
        $this->data['page_heading'] = 'Scheda studente';

//        $where=' where studente.deleted=0 and studente.ID='.$id;
        $where=' where studente.deleted=0 and studente.MATRICOL='.$id;
        IF (!isset($_SESSION['tab_attivo_studente'])){
            $_SESSION['tab_attivo_studente'] = 'tab1';
        }
        $this->data['tab_studente'] = $this->studente_model->tab_studente($id);
        $this->data['tab_note_anagrafiche'] = $this->studente_model->tab_note_anagrafiche($id);
        $this->data['tab_statocivile'] = $this->studente_model->tab_statocivile();
        $this->data['tab_iscrizioni'] = $this->studente_model->tab_iscrizioni($id);
        //serve per la griglia iscrizioni studente
        $this->data['tab_anno_accademico'] = $this->studente_model->tab_anno_accademico();
        $this->data['tab_corsidilaurea'] = $this->studente_model->tab_corsidilaurea();
        $this->data['tab_indirizzolaurea'] = $this->studente_model->tab_indirizzolaurea();
//        $this->data['tab_tipotitolosup'] = $this->studente_model->tab_tipotitolosup();
//        $this->data['tab_universitatrasf'] = $this->studente_model->tab_universitatrasf();
//        $this->data['tab_tipodocumentazione'] = $this->studente_model->tab_tipodocumentazione();
        //serve per la griglia iscrizioni studente
        
        $this->data['tab_tasse'] = $this->studente_model->tab_tasse($id);
////// record tassa da scegliere
        $tassa_attiva='';//$this->studente_model->tab_tassa_attiva($id);
//        if(isset($tassa_attiva)){ //è tutto da rivedere
        if($tassa_attiva=='da rivedere'){
            $this->data['tassa_attiva']=$tassa_attiva;
            $specchietto=array();
            switch ($tassa_attiva['CORSODILAUREA']) {
                case '210':
                    $str_query="SELECT IMPORTOTASSA 
                                FROM importitasse 
                                WHERE CAUSALETASSA='RU' 
                                   AND CORSODILAUREA=".$tassa_attiva['CORSODILAUREA']
                                ." AND ANNOACCADEMICO=".$tassa_attiva['ANNOACCADEMICO']
                                ." AND ANNODICORSO=".$tassa_attiva['ANNOCORSO'];
                    $query=$this->db->query($str_query);
                    $row = $query->row();
                    $IMPORTOTASSA_INTERA = $row->IMPORTOTASSA;                  

                    $str_query="SELECT IMPORTOTASSA 
                                FROM importitasse 
                                WHERE CAUSALETASSA in('1R','2R')" 
                                ." AND CORSODILAUREA=".$tassa_attiva['CORSODILAUREA']
                                ." AND ANNOACCADEMICO=".$tassa_attiva['ANNOACCADEMICO']
                                ." AND ANNODICORSO=".$tassa_attiva['ANNOCORSO'];
                    $query=$this->db->query($str_query);
                    $row = $query->row();
                    $IMPORTOTASSA_RATA = $row->IMPORTOTASSA;                  

                    $specchietto_corso='LICENZA IN TEOLOGIA MORALE';
                    $specchietto_titolo='Iscrizione annuale '.$tassa_attiva['ANNOCORSO'].'° anno';
                    $specchietto[0]['tipo']='Rata unica';
                    $specchietto[0]['causale_tassa']='1';
                    $specchietto[0]['importo']=$IMPORTOTASSA_INTERA; //'1920';
                    $specchietto[1]['tipo']='2 Rate';
                    $specchietto[1]['causale_tassa']='2';
                    $specchietto[1]['importo']=$IMPORTOTASSA_RATA; //'970';
                    $specchietto_nota1='La data di scadenza per il pagamento è il '.$tassa_attiva['PAGAMENTO'].', <br/>se si paga dopo questa data verrà applicata una penale di Euro '.$tassa_attiva['PENALE'];
                    $specchietto_nota2='Se si paga la Rata unica entro il '.$tassa_attiva['PAGANTICIPATO'].', <br/> si ha diritto ad uno sconto di Euro '.$tassa_attiva['SCONTO'];
                    break;
                case '230':
                    $str_query="SELECT IMPORTOTASSA 
                                FROM importitasse 
                                WHERE CAUSALETASSA='RU' 
                                   AND CORSODILAUREA=".$tassa_attiva['CORSODILAUREA']
                                ." AND ANNOACCADEMICO=".$tassa_attiva['ANNOACCADEMICO']
                                ." AND ANNODICORSO=".$tassa_attiva['ANNOCORSO'];
                    $query=$this->db->query($str_query);
                    $row = $query->row();
                    $IMPORTOTASSA_INTERA = $row->IMPORTOTASSA;                  

                    $str_query="SELECT IMPORTOTASSA 
                                FROM importitasse 
                                WHERE CAUSALETASSA in('1R','2R')" 
                                ." AND CORSODILAUREA=".$tassa_attiva['CORSODILAUREA']
                                ." AND ANNOACCADEMICO=".$tassa_attiva['ANNOACCADEMICO']
                                ." AND ANNODICORSO=".$tassa_attiva['ANNOCORSO'];
                    $query=$this->db->query($str_query);
                    $row = $query->row();
                    $IMPORTOTASSA_RATA = $row->IMPORTOTASSA;                  

                    $specchietto_corso='DIPLOMA IN TEOLOGIA MORALE';
                    $specchietto_titolo='Iscrizione per il biennio';
                    $specchietto[0]['tipo']='Rata unica';
                    $specchietto[0]['causale_tassa']='1';
                    $specchietto[0]['importo']=$IMPORTOTASSA_INTERA; //'1920';
                    $specchietto[1]['tipo']='2 Rate';
                    $specchietto[1]['causale_tassa']='2';
                    $specchietto[1]['importo']=$IMPORTOTASSA_RATA; //'970';
                    $specchietto_nota1='La data di scadenza per il pagamento è il '.$tassa_attiva['PAGAMENTO'].', <br/>se si paga dopo questa data verrà applicata una penale di Euro '.$tassa_attiva['PENALE'];
                    $specchietto_nota2='Se si paga la Rata unica entro il '.$tassa_attiva['PAGANTICIPATO'].', <br/> si ha diritto ad uno sconto di Euro '.$tassa_attiva['SCONTO'];
                    break;
                default:
                    break;
            }
            $this->data['specchietto_corso']=$specchietto_corso;
            $this->data['specchietto_titolo']=$specchietto_titolo;
            $this->data['specchietto']=$specchietto;
            $this->data['specchietto_nota1']=$specchietto_nota1;
            $this->data['specchietto_nota2']=$specchietto_nota2;
        }
/////////////////        
        $this->data['tab_corsi'] = $this->studente_model->tab_corsi($id);
        $this->data['tab_titoli_accademici'] = $this->studente_model->tab_titoli_accademici($id);
        $this->data['tab_diocesi'] = $this->studente_model->tab_diocesi($this->data['tab_studente']['DIOCESI']);
        $this->data['tab_ordine'] = $this->studente_model->tab_ordine($this->data['tab_studente']['ORDINE']);
        $this->data['tab_collegio'] = $this->studente_model->tab_collegio($this->data['tab_studente']['COLLEGIO']);
        $this->data['tab_studente_indirizzi_permanenti'] = $this->studente_model->tab_studente_indirizzi_permanenti($this->data['tab_studente']['MATRICOL']);
        $this->data['tab_statodocumenti'] = $this->studente_model->tab_statodocumenti($this->data['tab_studente']['MATRICOL']);
        $this->data['tab_lingue_moderne'] = $this->studente_model->tab_lingue_moderne();

        $this->data['tab_studente_residenza'] = $this->studente_model->tab_dati_nazione($this->data['tab_studente']['RESNAZI']);
        $this->data['tab_studente_residenza']['PROVINCIA'] = $this->studente_model->tab_dati_provincia($this->data['tab_studente']['RESPROV']);

        $this->data['tab_studente_recapito']['PROVINCIA'] = $this->studente_model->tab_dati_provincia($this->data['tab_studente']['RECPROV']);

        $this->data['tab_studente_nascita'] = $this->studente_model->tab_dati_nazione($this->data['tab_studente']['NASCNAZI']);
        $this->data['tab_studente_nascita']['PROVINCIA'] = $this->studente_model->tab_dati_provincia($this->data['tab_studente']['NASCPROV']);

        //serve per la griglia iscrizioni studente
        $this->data['tab_anno_accademico'] = $this->studente_model->tab_anno_accademico();
//        $this->data['tab_corsidilaurea'] = $this->studente_model->tab_corsidilaurea();
        $this->data['tab_corsidilaurea'] = $this->studente_model->tab_corsidilaurea_da_fare($id);
        $this->data['tab_indirizzolaurea'] = $this->studente_model->tab_indirizzolaurea();
        $this->data['tab_causaletassa'] = $this->studente_model->tab_causaletassa();
        //serve per la griglia iscrizioni studente
        //serve per la griglia titoli accademici
        $this->data['tab_tipotitolosup'] = $this->studente_model->tab_tipotitolosup();
        $this->data['tab_universitatrasf'] = $this->studente_model->tab_universitatrasf();
        $this->data['tab_tipodocumentazione'] = $this->studente_model->tab_tipodocumentazione();
        //serve per la griglia iscrizioni studente

        $this->searchBarsStudente();
        $myreset = '
            $(document).ready(function () {
                $(\'body\').on(\'hidden.bs.modal\', \'.modal\', function () {
                    $(this).removeData(\'bs.modal\');
            });
            });
        ';
        $this->add_scriptSource($myreset);

        $this->data['FormNascoste'] = [
            'id' => 'form_nascoste'
        ];
        $this->data['FormNascoste']['html'] = $this->renderView('backend' . DIRECTORY_SEPARATOR . 'self_studente' . DIRECTORY_SEPARATOR . 'form_nascoste', 'empty', true);

        $this->data['FormNascosteIscrizione'] = [
            'id' => 'form_nascoste_iscrizione'
        ];
        $this->data['FormNascosteIscrizione']['html'] = $this->renderView('backend' . DIRECTORY_SEPARATOR . 'self_studente' . DIRECTORY_SEPARATOR . 'form_nascoste_iscrizione', 'empty', true);

//        $this->data['FormNascosteTitoliAccademici'] = [
//            'id' => 'form_nascoste_titoli_accademici'
//        ];
//        $this->data['FormNascosteTitoliAccademici']['html'] = $this->renderView('backend' . DIRECTORY_SEPARATOR . 'self_studente' . DIRECTORY_SEPARATOR . 'form_nascoste_titoli_accademici', 'empty', true);
//
        $this->data['FormNascosteTasse'] = [
            'id' => 'form_nascoste_tasse'
        ];
        $this->data['FormNascosteTasse']['html'] = $this->renderView('backend' . DIRECTORY_SEPARATOR . 'self_studente' . DIRECTORY_SEPARATOR . 'form_nascoste_tasse', 'empty', true);
//
//        $this->data['FormNascosteCorsi'] = [
//            'id' => 'form_nascoste_corsi'
//        ];
//        $this->data['FormNascosteCorsi']['html'] = $this->renderView('backend' . DIRECTORY_SEPARATOR . 'self_studente' . DIRECTORY_SEPARATOR . 'form_nascoste_corsi', 'empty', true);
        
        
        $this->data['tab1'] = [
            'id' => 'dati_personali',
            'name' => 'Dati anagrafici'
        ];
        $this->data['tab1']['html'] = $this->renderView('backend' . DIRECTORY_SEPARATOR . 'self_studente' . DIRECTORY_SEPARATOR . 'dati_personali', 'empty', true);

        $this->data['tab2'] = [
            'id' => 'ordinario_religioso',
            'name' => 'Ordinario religioso'
        ];
        $this->data['tab2']['html'] = $this->renderView('backend' . DIRECTORY_SEPARATOR . 'self_studente' . DIRECTORY_SEPARATOR . 'ordinario_religioso', 'empty', true);

        $this->data['tab3'] = [
            'id' => 'info_collegio',
            'name' => 'Info collegio'
        ];
        $this->data['tab3']['html'] = $this->renderView('backend' . DIRECTORY_SEPARATOR . 'self_studente' . DIRECTORY_SEPARATOR . 'info_collegio', 'empty', true);

        $this->data['tab4'] = [
            'id' => 'indirizzi',
            'name' => 'Indirizzi'
        ];
        $this->data['tab4']['html'] = $this->renderView('backend' . DIRECTORY_SEPARATOR . 'self_studente' . DIRECTORY_SEPARATOR . 'indirizzi', 'empty', true);

        $this->data['tab5']['html'] = $this->renderTab5self_studente($id);

        $this->data['tab6'] = [
            'id' => 'documenti_requisiti',
            'name' => 'Documenti requisiti'
        ];
        $this->data['tab6']['html'] = $this->renderView('backend' . DIRECTORY_SEPARATOR . 'self_studente' . DIRECTORY_SEPARATOR . 'documenti_requisiti', 'empty', true);

        $this->data['tab7']['html'] = $this->renderTab7self_studente($id);

        $this->data['tab8']['html'] = $this->renderTab8self_studente($id);

        $this->data['tab9']['html'] = $this->renderTab9self_studente($id);

        $this->renderView('backend' . DIRECTORY_SEPARATOR . 'self_studente' . DIRECTORY_SEPARATOR . 'studente');
    }
    
    private function renderTab5self_studente($id) {
        $this->data['tab5'] = [
            'id' => 'titoli_accademici',
            'name' => 'Titoli accademici'
        ];
        $this->load->library('components');
        $this->components->addDataTablePanel('titoliAccademici');
        return $this->renderView('backend' . DIRECTORY_SEPARATOR . 'self_studente' . DIRECTORY_SEPARATOR . 'titoli_accademici', 'empty', true);
    }    

    private function renderTab7self_studente($id) {
        $this->data['tab7'] = [
            'id' => 'dati_iscrizione',
            'name' => 'Iscrizione'
        ];
        $this->load->library('components');
        $this->components->addDataTablePanel('datiIscrizione');
        return $this->renderView('backend' . DIRECTORY_SEPARATOR . 'self_studente' . DIRECTORY_SEPARATOR . 'dati_iscrizione', 'empty', true);
    }

    private function renderTab8self_studente($id) {
        $this->data['tab8'] = [
            'id' => 'tasse',
            'name' => 'Conto economico'
        ];
        $this->load->library('components');
        $this->components->addDataTablePanel('Tasse');
        return $this->renderView('backend' . DIRECTORY_SEPARATOR . 'self_studente' . DIRECTORY_SEPARATOR . 'tasse', 'empty', true);
    }

    private function renderTab9self_studente($id) {
        $this->data['tab9'] = [
            'id' => 'corsi',
            'name' => 'Corsi'
        ];
        $this->load->library('components');
        $this->components->addDataTablePanel('Corsi');
        return $this->renderView('backend' . DIRECTORY_SEPARATOR . 'self_studente' . DIRECTORY_SEPARATOR . 'corsi', 'empty', true);
    }

    
    public function self_studente_iscrizione_corsi() {
        $this->data['sidebar'] = $this->buildSidebar($this->sidebar, 47);
        $this->load->model('studente_model');
        $this->load->model('tabelle_model');
        if($this->studente_model->IsStudente($_SESSION['user_id'])==='8'){
            $id=$this->studente_model->MatricolaUsers($_SESSION['user_id'],'studente');
            $parametri=$this->tabelle_model->tab_parametri_iscrizione_corsi();
            $annoaccademico=$parametri['ANNOACCA'];
            $semestre=$parametri['SEMESTRE'];
            $datafine=date('Y/m/d', strtotime($parametri['DATAFINE']));
            $datainizio=date('Y/m/d', strtotime($parametri['DATAINIZIO']));
            $datagiorno=date("Y/m/d");
            if ($datagiorno<=$datafine && $datagiorno>=$datainizio){
                $tab_iscrizioni=$this->studente_model->tab_iscrizione($id,$annoaccademico);
                $this->scelta_corsi_studente($id,$tab_iscrizioni['CORSOLAUREA'],$semestre,$annoaccademico);
            }else{
                $this->renderView('backend/self_studente' . DIRECTORY_SEPARATOR . 'no_iscrizione_corsi');
            }
        }else{
            $this->data['sidebar'] = $this->buildSidebar($this->sidebar, 2);
            $this->data['tab_anno_accademico'] = $this->studente_model->tab_anno_accademico();
            $this->data['tab_corsidilaurea'] = $this->studente_model->tab_corsidilaurea();
            $this->data['tab_statocivile'] = $this->studente_model->tab_statocivile();
            $this->renderView('backend' . DIRECTORY_SEPARATOR . 'studenti_ricerca');
        }
    }    
    
    
    public function self_professore($id) {
        $this->data['sidebar'] = $this->buildSidebar($this->sidebar, 49);
        $this->load->model('studente_model');
        if ($id==='0'){
            if($this->studente_model->IsProfessore($_SESSION['user_id'])==='3'){
                $id=$this->studente_model->MatricolaUsers($_SESSION['user_id'],'professore');
            }else{
                $this->renderView('backend' . DIRECTORY_SEPARATOR . 'professori_ricerca');
            }
        }
        $qry = 'select professore.* from professore ';
        $this->data['page_heading'] = 'Scheda professore';
        $this->data['tab_professore'] = $this->studente_model->tab_professore($id);
        $this->data['tab_statocivile'] = $this->studente_model->tab_statocivile();
        $this->data['tab_diocesi'] = $this->studente_model->tab_diocesi($this->data['tab_professore']['DIOCESI']);
        $this->data['tab_ordine'] = $this->studente_model->tab_ordine($this->data['tab_professore']['ORDIPROF']);

        $this->data['tab_professore_residenza'] = $this->studente_model->tab_dati_nazione($this->data['tab_professore']['RESNAZI']);
        $this->data['tab_professore_residenza']['PROVINCIA'] = $this->studente_model->tab_dati_provincia($this->data['tab_professore']['RESPROV']);

        $this->data['tab_professore_recapito'] = $this->studente_model->tab_dati_nazione($this->data['tab_professore']['RECNAZI']);
        $this->data['tab_professore_recapito']['PROVINCIA'] = $this->studente_model->tab_dati_provincia($this->data['tab_professore']['RECPROV']);

        $this->data['tab_professore_nascita'] = $this->studente_model->tab_dati_nazione($this->data['tab_professore']['NASCNAZI']);
        $this->data['tab_professore_nascita']['PROVINCIA'] = $this->studente_model->tab_dati_provincia($this->data['tab_professore']['NASCPROV']);

        $this->searchBarsProfessore();

        $this->data['FormNascoste'] = [
            'id' => 'form_nascoste'
        ];
        $this->data['FormNascoste']['html'] = $this->renderView('backend' . DIRECTORY_SEPARATOR . 'self_professore' . DIRECTORY_SEPARATOR . 'form_nascoste', 'empty', true);

        $this->data['tab1'] = [
            'id' => 'dati_personali',
            'name' => 'Dati anagrafici'
        ];
        $this->data['tab1']['html'] = $this->renderView('backend' . DIRECTORY_SEPARATOR . 'self_professore' . DIRECTORY_SEPARATOR . 'dati_personali', 'empty', true);

        $this->data['tab2'] = [
            'id' => 'indirizzi',
            'name' => 'Indirizzi'
        ];
        $this->data['tab2']['html'] = $this->renderView('backend' . DIRECTORY_SEPARATOR . 'self_professore' . DIRECTORY_SEPARATOR . 'indirizzi', 'empty', true);
        
        $this->renderView('backend' . DIRECTORY_SEPARATOR . 'self_professore' . DIRECTORY_SEPARATOR . 'professore');
    }


    
}
