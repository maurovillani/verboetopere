<?php

defined('BASEPATH') or exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


class Components extends MY_Controller
{
    protected $CI;
    public function __construct()
    {
        $this->CI  = &get_instance();
        $this->CI->load->helper('url');
        $this->CI->load->library('session');
    }
    
    public function addSearchBoxNew($myinputbox,$hiddenfield,$getTestData){
        $this->CI->add_script(base_url('vendor/ui/1.12.1/jquery-ui.js'));
        $this->CI->add_stylesheet(base_url('assets/css/custominputbox.css'));
        $this->CI->add_stylesheet(base_url('vendor/ui/1.12.1/themes/base/jquery-ui.css'));
        $this->CI->add_stylesheet(base_url('assets/css/paolo.css'));
        
        $myscript = '
            $( function() {
                $("'.$myinputbox.'").autocomplete({
                    delay: 0,
                    minLength: 2,
                    source: function(request, response) {
                        $.ajax({
                            type: "POST",
                            url: "'.$getTestData.'",
                            dataType: "json",
                            data: { term: request.term },
                            success: function(data) {
                                var result;
                                if (data.length) {
                                    result = $.map(data, function(item) {
                                        return {
                                            label: item.label,
                                            value: item.label,
                                            id: item.value
                                        };
                                    });
                                }
                                response(result);
                            }
                        });
                    },
                    select: function(event, ui) {
                        $("'.$hiddenfield.'").val(ui.item.id).trigger(\'change\'); // save selected id to hidden input
                        console.log("Selected: " + ui.item.value + " aka " + ui.item.id);
                    }
                });
            });
        ';
        $this->CI->add_scriptSource($myscript);
    }
    public function connectedSortableBox($control1='#sortable1',$control2='#sortable2'){
        $this->CI->add_script(base_url('vendor/ui/1.12.1/jquery-ui.js'));
        $this->CI->add_stylesheet(base_url('vendor/ui/1.12.1/themes/base/jquery-ui.css'));
        $this->CI->add_stylesheet(base_url('assets/css/paolo.css'));
        $myscript = '
            $( function() {
                $("'.$control1.', '.$control2.'").sortable({
                    connectWith: ".connectedSortable"
                }).disableSelection();
            })
        ';

        $this->CI->add_scriptSource($myscript);
    }

    public function addDataTable($name = 'menus')
    {
        $this->CI->load->model('service_model', 'serviceDB');
        $this->CI->data['menus'] = $this->CI->sidebar = $this->CI->serviceDB->buildSidebarMenu(false);

        foreach ($this->CI->data['menus'] as $k => $menu) {
            $this->CI->data['menus'][$k]->groups = $this->CI->serviceDB->get_menus_groups($menu->id)->result();
        }

        $this->CI->add_stylesheet('vendor/datatables/dataTables.bootstrap4.min.css');
        $this->CI->add_script('vendor/datatables/jquery.dataTables.min.js');
        $this->CI->add_script('vendor/datatables/dataTables.bootstrap4.min.js');
        $script = '
            $(document).ready(function(){
                    $(\'#' . $name . '\').DataTable({
                                stateSave: true,
                                "columnDefs": [
                                {"targets": \'no-sort\',  "orderable": false},
                                {"targets": \'no-search\',  "searchable": false}
                                ]
                    });
                });
        ';
        $this->CI->add_scriptSource($script);
    }
    public function addDataTablePanel($name = 'menus')
    {
        $this->CI->load->model('service_model', 'serviceDB');
        $this->CI->data['menus'] = $this->CI->sidebar = $this->CI->serviceDB->buildSidebarMenu(false);

        foreach ($this->CI->data['menus'] as $k => $menu) {
            $this->CI->data['menus'][$k]->groups = $this->CI->serviceDB->get_menus_groups($menu->id)->result();
        }

        $this->CI->add_stylesheet('vendor/datatables/select.bootstrap4.min.css');
        $this->CI->add_stylesheet('vendor/datatables/dataTables.bootstrap4.min.css');
        $this->CI->add_script('vendor/datatables/jquery.dataTables.min.js');
        $this->CI->add_script('vendor/datatables/dataTables.bootstrap4.min.js');
        $this->CI->add_script('vendor/datatables/dataTables.select.min.js');
        $script = '
            $(\'a[data-toggle="tab"]\').on( \'shown.bs.tab\', function (e) {
                $.fn.dataTable.tables( {visible: true, api: true} ).columns.adjust();
            });
            $(document).ready(function(){
                var selected = [];
                    var ' . $name . 'Table = $(\'#' . $name . '\').DataTable({
                        "paging" : false,
                        "info" : false,
                        "ordering" : false,
                        "searching" : false,
                        "select" : {
                            "style": \'os\',
                            "items": \'row\'
                        },
                        "stateSave" : false ,
                        "scrollY" : 300,
                        "scrollX" : true
                    });
                    /*
                    $(\'#' . $name . ' tbody\').on( \'click\', \'tr\', function () {
                        alert( \'Row index: \'+ ' . $name . 'Table.row( this ).index() + " id: " + this.id );
                    });
                    */
                });
        ';
        $this->CI->add_scriptSource($script);
    }
    public function addRadiobutton()
    {
        $script = '
        $(\'#radioBtn a\').on(\'click\', function(){
            var sel = $(this).data(\'title\');
            var tog = $(this).data(\'toggle\');
            $(\'#\'+tog).prop(\'value\', sel);
            
            $(\'a[data-toggle="\'+tog+\'"]\').not(\'[data-title="\'+sel+\'"]\').removeClass(\'active\').addClass(\'notActive\');
            $(\'a[data-toggle="\'+tog+\'"][data-title="\'+sel+\'"]\').removeClass(\'notActive\').addClass(\'active\');
        })
        ';
        $this->CI->add_scriptSource($script);
    }
    public function addSearchBox($searchComboId, $ajaxPost, $value = ['id' => 0, 'descrizione' => 'trova...'], $class = 'form-control')
    {
        $myscript = '
        $(document).ready(function() {

            
            function callAjax(myObject) {
                var inputVal = myObject.val();
                myObject.css("background-color","lightyellow");
                var resultDropdown = myObject.siblings("#' . $searchComboId . '_elenco");
                if (inputVal.length) {
                    $.post("' . $ajaxPost . '", { term: inputVal }).done(function(data) {
                        resultDropdown.html(data);
                    });
                } else {
                    resultDropdown.empty();
                }
            }
            
            // Init a timeout variable to be used below
            var timeout = null;

            $("#' . $searchComboId . '").on("keyup input", function() {
                clearTimeout(timeout);
                var myThis=$(this);
                myThis.css("background-color","lightblue");
                timeout   = setTimeout(function(){callAjax(myThis)}, 500);
            });

            $(document).on("click", "#' . $searchComboId . '_elenco p", function(answer) {
                var selected = answer.currentTarget;
                var myinput=$("#' . $searchComboId . '");	
                myinput.css("background-color","white");
                myinput.val(selected.textContent);
                if(selected.id.length){
                    $("#ID_' . $searchComboId . '").attr("value", selected.id);
                }else{
                    $("#ID_' . $searchComboId . '").attr("value", 0);

                }
                $(this)
                .parent("#' . $searchComboId . '_elenco")
                .empty();
            });
        });
        ';
        $this->CI->add_stylesheet('assets/css/filter_dropdown.css');
        $this->CI->add_scriptSource($myscript);
        $mydropdown = '
                <input type="text" class="' . $class . '" id="' . $searchComboId . '" name="' . $searchComboId . '" autocomplete="off" placeholder="Trova ' . $searchComboId . '..." value="' . $value['descrizione'] . '"/>
                <input type="hidden" id="ID_' . $searchComboId . '" name="ID_' . $searchComboId . '" value="' . $value['id'] . '"/>
                <div id="' . $searchComboId . '_elenco" class="result"></div>
        ';
        return $mydropdown;
    }

    public function addDataTableSS($nomeDataset = 'film', $AjaxUrl = '')
    {
        $this->CI->add_stylesheet('vendor/datatables/fixedHeader.dataTables.min.css');
        $this->CI->add_stylesheet('vendor/datatables/dataTables.bootstrap4.min.css');
        $this->CI->add_script('vendor/datatables/jquery.dataTables.min.js');
        $this->CI->add_script('vendor/datatables/dataTables.buttons.min.js');
        $this->CI->add_script('vendor/datatables/jszip.min.js');
        $this->CI->add_script('vendor/datatables/pdfmake.min.js');
        $this->CI->add_script('vendor/datatables/vfs_fonts.js');
        $this->CI->add_script('vendor/datatables/buttons.html5.min.js');
        $this->CI->add_script('vendor/datatables/buttons.colVis.min.js');
        $this->CI->add_script('vendor/datatables/dataTables.fixedHeader.min.js');
        $this->CI->add_script('vendor/datatables/dataTables.bootstrap4.min.js');

        $script = '
            $(document).ready(function(){
                function multifilterSet(){
                    $(\'#table_' . $nomeDataset . ' thead tr\').clone(true).appendTo(\'#table_' . $nomeDataset . ' thead\');
                    $(\'#table_' . $nomeDataset . ' thead tr:eq(1) th\').each( function () {
                        if(!$(this).hasClass(\'no-searchable\')){
                            var title = $(this).text();
                            $(this).html( \'<input type="text" placeholder="Search \'+title+\'" class="column_search form-control"/>\' );
                        }else{
                            $(this).html(\'\');
                        }
                    });
                }
                
                multifilterSet();
                $(\'#table_' . $nomeDataset . ' thead tr:eq(1)\').toggle();

                var table=$(\'#table_' . $nomeDataset . '\').DataTable({
                        "language": {
                            "lengthMenu": "Mostra _MENU_ record per pagina",
                            "zeroRecords": "Nessun record trovato",
                            "info": "Mostra pagine _PAGE_ di _PAGES_",
                            "infoEmpty": "Nessun record disponibile",
                            "infoFiltered": "(filtrato da _MAX_ record totali)",
                            "processing": "<div class=\'spinner-border text-primary\'  role=\'status\'>AA</div>",
                            "buttons": {
                                "pageLength": {
                                    _: \'Mostra %d record\',
                                    \'-1\': \'Mostra tutto\'
                                }
                            },
                            "paginate": {
                                "previous": "Precedente",
                                "next": "Successivo"
                              }
                        },
                        "orderCellsTop": true,
                        "fixedHeader": true,
                        "dom": \'<"top"Bf>rt<"bottom"ip><"clear">\',
                        "lengthMenu": [
                            [ 10, 25, 50, 100, -1],
                            [ \'10\', \'25\', \'50\', \'100\', \'tutti\']
                        ],
                        "buttons": [
                            {
                                "extend": \'pageLength\',
                                "className": \'btn btn-primary\'
                            },
                            {   
                                text: \'Resetta\',
                                "className": \'btn btn-primary\',
                                action: function ( e, dt, node, config ) {
                                    table.search("").columns().search("");
                                    table.order([]);
                                    table.draw();
                                }
                            },
/* 20200825 commentato da AMF perchè non funzionano
                            {   
                                "text": \'Filtri di colonna\',
                                "className": \'btn btn-primary\',
                                "action": function ( e, dt, node, config ) {
                                    $(\'#table_' . $nomeDataset . ' thead tr:eq(1)\').toggle();
                                }
                            },
*/
                            {
                                "extend": \'copy\',
                                "title": \'Data export\',
                                text: \'<u>C</u>opia\',
                                "className": \'btn btn-info\',
                                "exportOptions": {
                                    "columns": \':visible\'
                                }
                            },
                            {
                                extend: \'excelHtml5\',
                                title: \'Data export\',
                                text: \'E<u>x</u>cel\',
                                className: \'btn btn-info\',
                                exportOptions: {
                                    columns: \':visible\'
                                }

                            },
                            {
                                extend: \'pdfHtml5\',
                                title: \'Data export\',
                                text: \'P<u>d</u>f\',
                                className: \'btn btn-info\',
                                exportOptions: {
                                    columns: \':visible\'
                                }
                            },
/* 20210324 commentato da AMF perchè non ha senso
                            {
                                extend: \'colvis\', className: \'btn btn-info\', text: \'Se<u>l</u>eziona colonne\'
                            }
*/                            
                        ],
                        "stateSave": true,
                        "processing": true,
                        "serverSide": true,
                        "order":[],
                        "columnDefs": [
                            {"targets": \'no-orderable\',  "orderable": false},
                            {"targets": \'no-searchable\',  "searchable": false}
                        ],
                        "ajax": {
                            "url": "' . $AjaxUrl . '",
                            "type": "POST"
                        },
                });


                // Apply the search
                $(\'#table_' . $nomeDataset . ' thead\').on(\'keyup\', ".column_search",function () {
                    table
                        .column( $(this).parent().index() )
                        .search(this.value)
                        .draw();
                });

            });
        ';
        $this->CI->add_scriptSource($script);
        $mytable = '
            <div class="table table-striped table-bordered">
                <table class="table table-bordered" id="table_' . $nomeDataset . '" width="100%" cellspacing="0">
                    <thead>
                        <tr>' . PHP_EOL;
        foreach ($this->CI->session->userdata('dataset')['columns'] as $column) {
            if (!$column['visible']) continue; //salta il ciclo nel caso non sia visibile la colonna
            $class = '';
            if (!$column['searchable'] || !$column['orderable']) {
                $class = ' class="';
                $class .= (!$column['searchable'] ? 'no-searchable ' : '');
                $class .= (!$column['orderable'] ? 'no-orderable ' : '');
                //$class .= (!$column['visible'] ? 'no-visible ' : '');
                $class .= '"';
            }
            $mytable .=     '<th' . $class . '>' . $column['label'] . '</th>' . PHP_EOL;
        }

        $mytable .= '</tr>
                </thead>
            </table>
        </div>' . PHP_EOL;

        return $mytable;
    }

    /**
     * Elabora le richiesta che arrivamo mediante post degli oggetti
     *
     * @param [type] $MyPost
     * @param string $object datatable searchbar
     * @return array
     */
    public function getLists($result, $object = 'datatable')
    {
        switch ($object) {
            case 'datatable':
                $this->CI->load->model('datatable_model', 'table');
                $this->CI->dataset = $this->CI->session->userdata('dataset');
                $this->CI->table->setDataset($this->CI->dataset);

                $data = $row = [];
                // Fetch member's records
                $memData = $this->CI->table->getRowsArray($result);

                $riga = $result['start'];
                foreach ($memData as $record) {
                    $myvalues = [];
                    foreach ($this->CI->dataset['columns'] as $key => $column) {
                        if (!$column['visible']) continue; //salta il ciclo nel caso non sia visibile la colonna

                        if (!is_null($column['data'])) {
                            array_push($myvalues, $record[$column['data']]);
                        } elseif (isset($column['actions'])) {
                            $azioni = [];
                            foreach ($column['actions'] as $azione) {
                                $field = get_string_between($azione, 'currentRecord[\'', '\']');
                                $azioni[] = str_replace('currentRecord[\'' . $field . '\']', $record[$field], $azione);
//                                if ($record['ANNOACCADEMICO']==='2020'){
//                                    $azioni[] = str_replace('currentRecord[\'' . $field . '\']', $record[$field], $azione);
//                                }else{
//                                    $azioni[] = '';
//                                }                                
                            }
                            array_push($myvalues, implode(' ', $azioni));
                        }
                    }
                    $data[] = $myvalues;
                }

                $output = array(
                    "draw" => $result['draw'],
                    "recordsTotal" => $this->CI->table->countAll(),
                    "recordsFiltered" => $this->CI->table->countFiltered($result),
                    "data" => $data,
                );
                break;
            case 'searchbar':
                $output = '';
                foreach ($result as $row) {
                    $myrow = array_values($row);
                    $output .= '<p id="' . $myrow[0] . '">' . $myrow[1] . '</p>';
                }
                break;
        }

        return $output;
    }
}
