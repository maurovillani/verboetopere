<?php

defined('BASEPATH') or exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$config['ci_bootstrap'] = [
    /*
      | -------------------------------------------------------------------------
      | Common configuration
      | -------------------------------------------------------------------------
      | For both Frontend Website, Admin Panel and API Site
     */

    // Site name
    'site_name' => 'Accademia Alfonsiana',
    // Default page title prefix
    'page_title_prefix' => 'Accademia Alfonsiana',
    // Default page title
    // (set empty then MY_Controller will automatically generate one based on controller / action)
    'page_title' => 'Back-Office',
    // Default CSS class for <body> tag
    'body_class' => 'bg-gradient-primary',
    'author' => 'Paolo Minervino',
    'site_description' => 'Campus Management',
    'site_company' => 'Accademia Alfonsiana',
    'customer' => 'Alfonsiana',
    'version' => 'alpha 1.1 02/04/2020',
    // Default meta data
    // (name => content)
    'meta_data' => [
        'viewport' => 'width=device-width, initial-scale=1, shrink-to-fit=no',
        'author' => 'Paolo Minervino ',
        'description' => 'Campus Platform',
        'keywords' => 'Accademia Alfonsiana,verbo et opere'
    ],
    // Default vars Js to embed at page head or end
    // (position => script array)
    'varsJs' => [
        'head' => [],
        'foot' => [],
    ],
    // Default scripts source to embed at page head or end
    // (position => script array)
    'ScriptsSource' => [
        'head' => [],
        'foot' => [],
    ],
    // Default scripts to embed at page head or end
    // (position => script array)
    'scripts' => [
        'head' => [],
        'foot' => [
            'vendor/jquery/jquery.min.js',
            'vendor/bootstrap/js/bootstrap.bundle.min.js',
            'vendor/jquery-easing/jquery.easing.min.js',
            'vendor/sb-admin2/js/sb-admin-2.min.js',
            'assets/js/paolino.js'
        ],
    ],
    // Default stylesheets to embed at page head
    // (media => stylesheet array)
    'stylesheets' => [
        'screen' =>
        [
            'vendor/fontawesome-free/css/all.min.css',
            'vendor/sb-admin2/css/sb-admin-2.min.css',
            'assets/css/verboetopere.css',
            //'https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i',
        ],
        'print' => [
            // for print media
        ]
    ],
    'controller' => [
        'backend' => [
            'exceptions' => [
                'backend/datatable/studenti',
                'backend/datatable/professori',
                //'backend/datatable/importitasse/*',
                'backend/edit_record/*',
                'backend/new_record/*',
                'backend/delete_record/*',
                'backend/getLists/*',
                'backend/studente_preiscrizione/*',
                'backend/studente/*',
                'backend/self_studente/*',
                'backend/self_professore/*',

                'backend/preiscrizione_cartella/*',
                'backend/preiscrizione_ricerca/*',
                'backend/preiscrizione_ricerca_azzera',
                'backend/datatable/preiscrizione',

                'backend/studenti_cartella/*',
                'backend/studenti_ricerca/*',
                'backend/studenti_ricerca_azzera',
                'backend/professore/*',
                'backend/professori_cartella',
                'backend/professori_ricerca/*',
                'backend/professori_ricerca_azzera',
                'backend/pianostudi',
                'backend/scelta_corsi_studente/*',
                'backend/scelta_corsi_studente_salva/*',
                'backend/pianostudi_studente/*',
                'backend/pianostudi_studente_salva',
                'backend/collegio/*',
                'backend/scadenza/*',
                'backend/do_upload/*',
                'backend/do_upload_multipla/*',
                'backend/modulo_iscrizione_corsi/*',
                'backend/modulo_certificato_preiscrizione/*',
                'backend/diocesi/*',
                'backend/test', //test purposes paolo minervino
                'backend/test_send', //test purposes paolo minervino
                'backend/getTestData' //test purposes paolo minervino
            ]
        ]
    ]
];
