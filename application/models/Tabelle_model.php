<?php

defined('BASEPATH') OR exit('No direct script access allowed');

Class Tabelle_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
//PARAMETRI PREISCRIZIONE
    public function tab_parametri_preiscrizione(){
        //$str_query="SELECT p.* FROM parametri_preiscrizione p";
        $str_query="
                    SELECT 
                        case
                            when NOW()>=p.INIZIOPREISCRIZIONI_SEM1 AND NOW()<=p.FINEPREISCRIZIONI_SEM1 then '1'
                            when NOW()>=p.INIZIOPREISCRIZIONI_SEM2 AND NOW()<=p.FINEPREISCRIZIONI_SEM2 then '2'
                            when NOW()>=p.INIZIOISCRIZIONI_SEM1 AND NOW()<=p.FINEISCRIZIONI_SEM1 then '1'
                            when NOW()>=p.INIZIOISCRIZIONI_SEM2 AND NOW()<=p.FINEISCRIZIONI_SEM2 then '2'
                        end AS SEMESTRE,
                        case
                            when NOW()>=p.INIZIOPREISCRIZIONI_SEM1 AND NOW()<=p.FINEPREISCRIZIONI_SEM1 then '0'
                            when NOW()>=p.INIZIOPREISCRIZIONI_SEM2 AND NOW()<=p.FINEPREISCRIZIONI_SEM2 then '0'
                            when NOW()>=p.INIZIOISCRIZIONI_SEM1 AND NOW()<=p.FINEISCRIZIONI_SEM1 then '1'
                            when NOW()>=p.INIZIOISCRIZIONI_SEM2 AND NOW()<=p.FINEISCRIZIONI_SEM2 then '1'
                        end AS PREISCRIZIONI_SCHEDA,
                        p.*
                    FROM parametri_preiscrizione p                
                ";
        
        
        $query=$this->db->query($str_query);
        $result = $query->row_array(); 
        return $result;          
    } 
    public function SalvaModificaParametriPreiscrizione($post){
        $str_query = "update parametri_preiscrizione set ";
        $str_query .= "ANNOACCA = ".$post['ANNOACCA'];
        $str_query .= ",EMAIL_SEGRETERIA='".str_replace("'","''",$post['EMAIL_SEGRETERIA'])."'";        
        $str_query .= ",INIZIOPREISCRIZIONI_SEM1='".str_replace("'","''",$post['INIZIOPREISCRIZIONI_SEM1'])."'";        
        $str_query .= ",FINEPREISCRIZIONI_SEM1='".str_replace("'","''",$post['FINEPREISCRIZIONI_SEM1'])."'";        
        $str_query .= ",INIZIOPREISCRIZIONI_SEM2='".str_replace("'","''",$post['INIZIOPREISCRIZIONI_SEM2'])."'";        
        $str_query .= ",FINEPREISCRIZIONI_SEM2='".str_replace("'","''",$post['FINEPREISCRIZIONI_SEM2'])."'";        
        $str_query .= ",INIZIOISCRIZIONI_SEM1='".str_replace("'","''",$post['INIZIOISCRIZIONI_SEM1'])."'";        
        $str_query .= ",FINEISCRIZIONI_SEM1='".str_replace("'","''",$post['FINEISCRIZIONI_SEM1'])."'";        
        $str_query .= ",INIZIOISCRIZIONI_SEM2='".str_replace("'","''",$post['INIZIOISCRIZIONI_SEM2'])."'";        
        $str_query .= ",FINEISCRIZIONI_SEM2='".str_replace("'","''",$post['FINEISCRIZIONI_SEM2'])."'";        
        $this->db->query($str_query); 
        return;        
    }
    public function tab_scadenze($anno){
        $str_query="SELECT s.* FROM scadenze s WHERE ANNOACCADEMICO like '".$anno."' order by ANNOACCADEMICO DESC";
        $query=$this->db->query($str_query);
        $result = $query->row_array(); 
        return $result;          
    } 
    
//PREISCRIZIONE
//PARAMETRI ISCRIZIONE CORSI
    public function tab_parametri_iscrizione_corsi(){
        $str_query="SELECT s.*,s.ANNOACCADEMICO AS ANNOACCA FROM scadenze s WHERE ATTIVO=1";
//        $str_query="SELECT p.* FROM parametri_iscrizione_corsi p";
        $query=$this->db->query($str_query);
        $result = $query->row_array(); 
        return $result;          
    } 
    public function SalvaModificaParametriIscrizioneCorsi($post){
        $ANNOACCA=$post['ANNOACCA'];
        $SEMESTRE=$post['SEMESTRE'];
        $DATAINIZIO=$post['DATAINIZIO'];
        $DATAFINE=$post['DATAFINE'];
        
        $str_query = "update parametri_iscrizione_corsi set ";
        $str_query .= "ANNOACCA = ".$ANNOACCA;
        $str_query .= ",SEMESTRE = ".$SEMESTRE;
        $str_query .= ",DATAINIZIO='".str_replace("'","''",$DATAINIZIO)."'";        
        $str_query .= ",DATAFINE='".str_replace("'","''",$DATAFINE)."'";        
        $this->db->query($str_query); 
        return;        
    }    
//ISCRIZIONE CORSI    
    public function tab_preiscrizione(){
        $str_query="SELECT p.* FROM studente_preiscrizione p
                    WHERE p.deleted=0";
        $query=$this->db->query($str_query);
        $result = $query->result_array(); 
        return $result;          
    }       
//PROVINCE
    public function tab_province(){
        $str_query="SELECT p.* FROM provincia p
                    WHERE p.deleted=0";
        $query=$this->db->query($str_query);
        $result = $query->result_array(); 
        return $result;          
    }        
    
//    public function tab_provincia($id){
//        $str_query="SELECT * FROM provincia p
//                    WHERE p.CODICENU=".$id;
//        $query=$this->db->query($str_query);
//        $result = $query->row_array(); 
//        return $result;          
//    }        
    public function SalvaModificaProvincia($id,$post){
        $DECODIF=$post['DECODIF'];
        $ALFAUNO=$post['ALFAUNO'];
        $str_query = "update provincia set
                            DECODIF= '".str_replace("'","''",$DECODIF)."',
                            ALFAUNO = '".$ALFAUNO."'
                      where CODICENU=".$id;
        $this->db->query($str_query); 
        return;        
    }
    public function EliminaProvincia($id){
        $str_query = "update provincia set deleted=1 where CODICENU=".$id;
        $this->db->query($str_query); 
        return;        
    }  
      
//NAZIONI
    public function tab_nazioni(){
        $str_query="SELECT n.* FROM nazione n
                    WHERE n.deleted=0";
        $query=$this->db->query($str_query);
        $result = $query->result_array(); 
        return $result;          
    }        
    
    public function tab_nazione($id){
        $str_query="SELECT * FROM nazione n
                    WHERE n.CODICENU=".$id;
        $query=$this->db->query($str_query);
        $result = $query->row_array(); 
        return $result;          
    }        
    public function SalvaModificaNazione($id,$post){
        $DECODIF=$post['DECODIF'];
        $ALFAUNO=$post['ALFAUNO'];
        $CITTADINANZA=$post['CITTADINANZA'];
        $FLAG_LINGUA_MODERNA=$post['FLAG_LINGUA_MODERNA'];
        $str_query = "update nazione set
                            DECODIF= '".str_replace("'","''",$DECODIF)."',
                            ALFAUNO = '".$ALFAUNO."',
                            CITTADINANZA= '".str_replace("'","''",$CITTADINANZA)."',
                            FLAG_LINGUA_MODERNA = '".$FLAG_LINGUA_MODERNA."'
                      where CODICENU=".$id;
        $this->db->query($str_query); 
        return;        
    }
    public function EliminaNazione($id){
        $str_query = "update nazione set deleted=1 where CODICENU=".$id;
        $this->db->query($str_query); 
        return;        
    }       
    
//COLLEGIO    
    public function tab_max_codice_collegio(){
        $str_query="SELECT MAX(CODICE)+1 AS MAX
                    FROM collegi";
        $query=$this->db->query($str_query);
        $result = $query->row_array(); 
        return $result;          
    }    
    public function tab_collegio($id){
        $str_query="SELECT c.*,p.DECODIF AS PROVINCIA_ESTESA FROM collegi c
                    LEFT JOIN provincia p ON c.PROVINCIA=p.CODICENU
                    WHERE c.CODICE=".$id;
        $query=$this->db->query($str_query);
        $result = $query->row_array(); 
        return $result;          
    }        
    public function tab_collegi(){
        $str_query="select CODICE,
                   Concat(IF(CODICE=0,' ',''),COLLEGIO,IF(NOT ISNULL(INDIRIZZO),' | ',''),IF(NOT ISNULL(INDIRIZZO),INDIRIZZO,'')) as COLLEGIO 
                   from collegi where NOT ISNULL(COLLEGIO)
                   ORDER BY COLLEGIO";
        $query=$this->db->query($str_query);
        $result = $query->result_array(); 
        return $result;          
    }        
    
    
    public function SalvaModificaCollegio($id,$post){
//	$CODICE=$post[''];
	$COLLEGIO=$post['COLLEGIO'];
	$INDIRIZZO=$post['INDIRIZZO'];
	$CAP=$post['CAP'];
//	$CITTA=$post[''];
	$COMUNE=$post['COMUNE'];
	$TELEFONO=$post['TELEFONO'];
	$FAX=$post['FAX'];
        $PROVINCIA=$post['ID_provincia'];
//	$categoria=$post[''];
	$rettore=$post['rettore'];
	$delegato=$post['delegato'];
	$direttore_studi=$post['direttore_studi'];
	$note=$post['note'];
	$email=$post['email'];
	$codice_pug=$post['codice_pug'];
//	$data_immissione=$post[''];
//	$password=$post[''];
	$email_rettore=$post['email_rettore'];
	$email_dirstudi=$post['email_dirstudi'];
	$email_delegato=$post['email_delegato'];
	$tel_rettore=$post['tel_rettore'];
	$tel_dirstudi=$post['tel_dirstudi'];
	$tel_delegato=$post['tel_delegato'];
	$descrizione_pubblicazioni=$post['descrizione_pubblicazioni'];
//	$datafine=$post[''];
	$sito_web=$post['sito_web'];
	$titolo_rettore=$post['titolo_rettore'];
	$titolo_vicerettore=$post['titolo_vicerettore'];  
        
        $str_query = "update collegi set
                        COLLEGIO = '".str_replace("'","''",$COLLEGIO)."',
                        INDIRIZZO = '".str_replace("'","''",$INDIRIZZO)."',
                        CAP = '".str_replace("'","''",$CAP)."',
                        COMUNE = '".str_replace("'","''",$COMUNE)."',
                        TELEFONO = '".str_replace("'","''",$TELEFONO)."',
                        FAX = '".str_replace("'","''",$FAX)."',
                        rettore = '".str_replace("'","''",$rettore)."',
                        delegato = '".str_replace("'","''",$delegato)."',
                        direttore_studi = '".str_replace("'","''",$direttore_studi)."',
                        note = '".str_replace("'","''",$note)."',
                        email = '".str_replace("'","''",$email)."',
                        codice_pug = '".str_replace("'","''",$codice_pug)."',
                        email_rettore = '".str_replace("'","''",$email_rettore)."',
                        email_dirstudi = '".str_replace("'","''",$email_dirstudi)."',
                        email_delegato = '".str_replace("'","''",$email_delegato)."',
                        tel_rettore = '".str_replace("'","''",$tel_rettore)."',
                        tel_dirstudi = '".str_replace("'","''",$tel_dirstudi)."',
                        tel_delegato = '".str_replace("'","''",$tel_delegato)."',
                        descrizione_pubblicazioni = '".str_replace("'","''",$descrizione_pubblicazioni)."',
                        sito_web = '".str_replace("'","''",$sito_web)."',
                        titolo_rettore = '".str_replace("'","''",$titolo_rettore)."',
                        titolo_vicerettore = '".str_replace("'","''",$titolo_vicerettore)."'";
        if (intval($PROVINCIA)>0) {
            $str_query .= ",PROVINCIA=".$PROVINCIA;
        }else{
            $str_query .= ",PROVINCIA=null";
        }
        $str_query .= " where CODICE=".$id;
        
        $this->db->query($str_query); 
        return;        
    }
    public function EliminaCollegio($id){
        $str_query = "update collegi set deleted=1 where CODICE=".$id;
        $this->db->query($str_query); 
        return;        
    }            
    public function SalvaNuovoCollegio($post){
        $CODICE=$post['CODICE'];
	$COLLEGIO = $post['COLLEGIO'];
	$codice_pug = $post['codice_pug'];
        $str_query = "insert into collegi( 
                            CODICE,COLLEGIO,codice_pug)
                            values(".$CODICE.",
                            '".str_replace("'","''",$COLLEGIO)."',
                            '".str_replace("'","''",$codice_pug)."')";
        $this->db->query($str_query); 
        return;        
    }            
//DIOCESI    
    public function tab_max_codice_diocesi(){
        $str_query="SELECT MAX(CODICE)+1 AS MAX
                    FROM diocesi";
        $query=$this->db->query($str_query);
        $result = $query->row_array(); 
        return $result;          
    }        
    public function tab_diocesi(){
        $str_query="SELECT * FROM diocesi
                    WHERE deleted=0";
        $query=$this->db->query($str_query);
        $result = $query->result_array(); 
        return $result;          
    }        
    public function SalvaModificaDiocesi($id,$post){
        $DIOCESI=$post['DIOCESI'];
        $str_query = "update diocesi set
                            DIOCESI= '".str_replace("'","''",$DIOCESI)."'
                      where CODICE=".$id;
        $this->db->query($str_query); 
        return;        
    }
    public function SalvaNuovaDiocesi($post){
        $CODICENU=$post['CODICE'];
	$DECODIF = $post['DIOCESI'];
        $str_query = "insert into diocesi( 
                            CODICE,DIOCESI)
                            values(".$CODICENU.",
                            '".str_replace("'","''",$DIOCESI)."')";
        $this->db->query($str_query); 
        return;        
    }                    
    
    public function EliminaDiocesi($id){
        $str_query = "update diocesi set deleted=1 where CODICE=".$id;
        $this->db->query($str_query); 
        return;        
    }   
//ORDINE    
    public function tab_max_codice_ordine(){
        $str_query="SELECT MAX(CODICENU)+1 AS MAX
                    FROM ordine";
        $query=$this->db->query($str_query);
        $result = $query->row_array(); 
        return $result;          
    }        
    public function tab_ordine(){
        $str_query="SELECT * FROM ordine
                    WHERE deleted=0";
        $query=$this->db->query($str_query);
        $result = $query->result_array(); 
        return $result;          
    }        
    public function SalvaModificaOrdine($id,$post){
        $DECODIF=$post['DECODIF'];
        $DECODIFBREVE=$post['DECODIFBREVE'];
        $str_query = "update ordine set
                            DECODIF= '".str_replace("'","''",$DECODIF)."',
                            DECODIFBREVE= '".str_replace("'","''",$DECODIFBREVE)."'
                      where CODICENU=".$id;
        $this->db->query($str_query); 
        return;        
    }
    public function SalvaNuovoOrdine($post){
        $CODICENU=$post['CODICENU'];
	$DECODIF = $post['DECODIF'];
	$DECODIFBREVE = $post['DECODIFBREVE'];
        $str_query = "insert into ordine( 
                            CODICENU,DECODIF,DECODIFBREVE)
                            values(".$CODICENU.",
                            '".str_replace("'","''",$DECODIF)."',
                            '".str_replace("'","''",$DECODIFBREVE)."')";
        $this->db->query($str_query); 
        return;        
    }                
    public function EliminaOrdine($id){
        $str_query = "update ordine set deleted=1 where CODICENU=".$id;
        $this->db->query($str_query); 
        return;        
    }   
//STATO CIVILE    
    public function tab_max_codice_statocivile(){
        $str_query="SELECT MAX(CODICENU)+1 AS MAX
                    FROM statocivile
                    WHERE CODICENU<999";
        $query=$this->db->query($str_query);
        $result = $query->row_array(); 
        return $result;          
    }        
    public function tab_statocivile(){
        $str_query="SELECT * FROM statocivile
                    WHERE deleted=0";
        $query=$this->db->query($str_query);
        $result = $query->result_array(); 
        return $result;          
    }        
    public function tab_corsidilaurea(){
        $str_query="SELECT * FROM corsidilaurea WHERE CODICENU<>999";
        $query=$this->db->query($str_query);
        $result = $query->result_array(); 
        return $result;          
    }  
    public function tab_importitasse(){
        $str_query="SELECT * FROM importitasse 
                    WHERE ANNOACCADEMICO>=2019";
        $query=$this->db->query($str_query);
        $result = $query->result_array(); 
        return $result;          
    }      
    public function SalvaModificaImportiTasse($id,$post){
        $ANNOACCADEMICO=$post['ANNOACCADEMICO'];
        $CORSODILAUREA=$post['CORSODILAUREA'];
        $ANNODICORSO=$post['ANNODICORSO'];
        $CAUSALETASSA=$post['CAUSALETASSA'];
        $IMPORTOTASSA=$post['IMPORTOTASSA'];
        
        $str_query = "update importitasse set
                            ANNOACCADEMICO= ".$ANNOACCADEMICO."
                            ,CORSODILAUREA= ".$CORSODILAUREA."
                            ,ANNODICORSO= ".$ANNODICORSO."
                            ,CAUSALETASSA= '".$CAUSALETASSA."'
                            ,IMPORTOTASSA= ".$IMPORTOTASSA."
                      where ID=".$id;
        $this->db->query($str_query); 
        return;        
    }
    public function SalvaNuovoImportoTasse($post){
        $ANNOACCADEMICO=$post['ANNOACCADEMICO'];
        $CORSODILAUREA=$post['CORSODILAUREA'];
        if($CORSODILAUREA=='') $CORSODILAUREA='999';
        $ANNODICORSO=$post['ANNODICORSO'];
        $CAUSALETASSA=$post['CAUSALETASSA'];
        $IMPORTOTASSA=$post['IMPORTOTASSA'];
        $str_query = "insert into importitasse( 
                            ANNOACCADEMICO,CORSODILAUREA,ANNODICORSO,CAUSALETASSA,IMPORTOTASSA,ANNIFUORICORSO,DATADECORRENZA,DATAIMMISSIONE)
                            values(".$ANNOACCADEMICO."
                            ,".$CORSODILAUREA."
                            ,".$ANNODICORSO."
                            ,'".$CAUSALETASSA."'
                            ,".str_replace(",",".",$IMPORTOTASSA).",0,'0000-00-00',now())";
        $this->db->query($str_query); 
        return;        
    }     
    public function DuplicaImportiTasse($post){
        $ANNOACCADEMICO_OLD=$post['ANNOACCADEMICO_OLD'];
        $ANNOACCADEMICO_NEW=$post['ANNOACCADEMICO_NEW'];
        $str_query = "insert into importitasse( 
                            ANNOACCADEMICO,CORSODILAUREA,ANNODICORSO,CAUSALETASSA,IMPORTOTASSA,ANNIFUORICORSO,DATADECORRENZA,DATAIMMISSIONE)
                            select ".$ANNOACCADEMICO_NEW.",CORSODILAUREA,ANNODICORSO,CAUSALETASSA,IMPORTOTASSA,ANNIFUORICORSO,DATADECORRENZA,now()
                            FROM importitasse
                            where ANNOACCADEMICO=".$ANNOACCADEMICO_OLD;
        $this->db->query($str_query); 
        return;        
    }              
    public function EliminaImportoTasse($id){
        $str_query = "delete from importitasse where ID=".$id;
        $this->db->query($str_query); 
        return;        
    }           
    
    public function SalvaModificaStatoCivile($id,$post){
        $DECODIF=$post['DECODIF'];
        $str_query = "update statocivile set
                            DECODIF= '".str_replace("'","''",$DECODIF)."'
                      where CODICENU=".$id;
        $this->db->query($str_query); 
        return;        
    }
    public function SalvaNuovoStatoCivile($post){
        $CODICENU=$post['CODICENU'];
	$DECODIF = $post['DECODIF'];
        $str_query = "insert into statocivile( 
                            CODICENU,DECODIF,
                            DECODIF_ITA,DECODIF_ING,DECODIF_SPA,ASTER)
                            values(".$CODICENU.",
                            '".str_replace("'","''",$DECODIF)."','','','','')";
        $this->db->query($str_query); 
        return;        
    }                
    public function EliminaStatoCivile($id){
        $str_query = "update statocivile set deleted=1 where CODICENU=".$id;
        $this->db->query($str_query); 
        return;        
    }       

    public function SalvaModificaScadenze($id,$post){
        $ANNOACCADEMICO=$post['ANNOACCADEMICO'];
        $ATTIVO=$post['ATTIVO'];
        $SEMESTRE=$post['SEMESTRE'];
////////////////
        $INIZIOISCRIZIONI_SEM1='null';
        $FINEISCRIZIONI_SEM1='null';
        $SCONTOISCRIZIONE_SEM1='null';
        $INIZIOISCRCORSISEM_SEM1='null';
        $FINEISCRIZIONISEMINARI_SEM1='null';
        $FINEISCRIZIONICORSI_SEM1='null';
        $INIZIOLEZIONI_SEM1='null';
        $INIZIOPRENOTESAMI_SEM1='null';
        $FINEPRENOTESAMI_SEM1='null';
        $INIZIOPRENOTRECENSIONE='null';
        $FINEPRENOTRECENSIONE='null';
        $FINELEZIONI_SEM1='null';
        $INIZIOESAMI_SEM1='null';
        $FINEESAMI_SEM1='null';
        $INIZIOISCRIZIONI_SEM2='null';
        $FINEISCRIZIONI_SEM2='null';
        $SCONTOISCRIZIONE_SEM2='null';
        $INIZIOISCRCORSISEM_SEM2='null';
        $FINEISCRIZIONISEMINARI_SEM2='null';
        $FINEISCRIZIONICORSI_SEM2='null';
        $INIZIOLEZIONI_SEM2='null';
        $INIZIOPRENOTESAMI_SEM2='null';
        $FINEPRENOTESAMI_SEM2='null';
        $FINELEZIONI_SEM2='null';
        $INIZIOESAMI_SEM2='null';
        $FINEESAMI_SEM2='null';
//////////////////
        if ($post['INIZIOISCRIZIONI_SEM1']!=''){
            $INIZIOISCRIZIONI_SEM1=$post['INIZIOISCRIZIONI_SEM1'];
        }
        if ($post['FINEISCRIZIONI_SEM1']!=''){
            $FINEISCRIZIONI_SEM1=$post['FINEISCRIZIONI_SEM1'];
        }
        if ($post['SCONTOISCRIZIONE_SEM1']!=''){
            $SCONTOISCRIZIONE_SEM1=$post['SCONTOISCRIZIONE_SEM1'];
        }
        if ($post['INIZIOISCRCORSISEM_SEM1']!=''){
            $INIZIOISCRCORSISEM_SEM1=$post['INIZIOISCRCORSISEM_SEM1'];
        }
        if ($post['FINEISCRIZIONISEMINARI_SEM1']!=''){
            $FINEISCRIZIONISEMINARI_SEM1=$post['FINEISCRIZIONISEMINARI_SEM1'];
        }
        if ($post['FINEISCRIZIONICORSI_SEM1']!=''){
            $FINEISCRIZIONICORSI_SEM1=$post['FINEISCRIZIONICORSI_SEM1'];
        }
        if ($post['INIZIOLEZIONI_SEM1']!=''){
            $INIZIOLEZIONI_SEM1=$post['INIZIOLEZIONI_SEM1'];
        }
        if ($post['INIZIOPRENOTESAMI_SEM1']!=''){
            $INIZIOPRENOTESAMI_SEM1=$post['INIZIOPRENOTESAMI_SEM1'];
        }
        if ($post['FINEPRENOTESAMI_SEM1']!=''){
            $FINEPRENOTESAMI_SEM1=$post['FINEPRENOTESAMI_SEM1'];
        }
        if ($post['INIZIOPRENOTRECENSIONE']!=''){
            $INIZIOPRENOTRECENSIONE=$post['INIZIOPRENOTRECENSIONE'];
        }
        if ($post['FINEPRENOTRECENSIONE']!=''){
            $FINEPRENOTRECENSIONE=$post['FINEPRENOTRECENSIONE'];
        }
        if ($post['FINELEZIONI_SEM1']!=''){
            $FINELEZIONI_SEM1=$post['FINELEZIONI_SEM1'];
        }
        if ($post['INIZIOESAMI_SEM1']!=''){
            $INIZIOESAMI_SEM1=$post['INIZIOESAMI_SEM1'];
        }
        if ($post['FINEESAMI_SEM1']!=''){
            $FINEESAMI_SEM1=$post['FINEESAMI_SEM1'];
        }
        if ($post['INIZIOISCRIZIONI_SEM2']!=''){
            $INIZIOISCRIZIONI_SEM2=$post['INIZIOISCRIZIONI_SEM2'];
        }
        if ($post['FINEISCRIZIONI_SEM2']!=''){
            $FINEISCRIZIONI_SEM2=$post['FINEISCRIZIONI_SEM2'];
        }
        if ($post['SCONTOISCRIZIONE_SEM2']!=''){
            $SCONTOISCRIZIONE_SEM2=$post['SCONTOISCRIZIONE_SEM2'];
        }
        if ($post['INIZIOISCRCORSISEM_SEM2']!=''){
            $INIZIOISCRCORSISEM_SEM2=$post['INIZIOISCRCORSISEM_SEM2'];
        }
        if ($post['FINEISCRIZIONISEMINARI_SEM2']!=''){
            $FINEISCRIZIONISEMINARI_SEM2=$post['FINEISCRIZIONISEMINARI_SEM2'];
        }
        if ($post['FINEISCRIZIONICORSI_SEM2']!=''){
            $FINEISCRIZIONICORSI_SEM2=$post['FINEISCRIZIONICORSI_SEM2'];
        }
        if ($post['INIZIOLEZIONI_SEM2']!=''){
            $INIZIOLEZIONI_SEM2=$post['INIZIOLEZIONI_SEM2'];
        }
        if ($post['INIZIOPRENOTESAMI_SEM2']!=''){
            $INIZIOPRENOTESAMI_SEM2=$post['INIZIOPRENOTESAMI_SEM2'];
        }
        if ($post['FINEPRENOTESAMI_SEM2']!=''){
            $FINEPRENOTESAMI_SEM2=$post['FINEPRENOTESAMI_SEM2'];
        }
        if ($post['FINELEZIONI_SEM2']!=''){
            $FINELEZIONI_SEM2=$post['FINELEZIONI_SEM2'];
        }
        if ($post['INIZIOESAMI_SEM2']!=''){
            $INIZIOESAMI_SEM2=$post['INIZIOESAMI_SEM2'];
        }
        if ($post['FINEESAMI_SEM2']!=''){
            $FINEESAMI_SEM2=$post['FINEESAMI_SEM2'];
        }
        
        $str_query = "update scadenze set
                            ANNOACCADEMICO= ".$ANNOACCADEMICO."
                            ,ATTIVO= ".$ATTIVO."
                            ,SEMESTRE= ".$SEMESTRE."
                            ,INIZIOISCRIZIONI_SEM1='".$INIZIOISCRIZIONI_SEM1."'
                            ,FINEISCRIZIONI_SEM1='".$FINEISCRIZIONI_SEM1."'
                            ,SCONTOISCRIZIONE_SEM1='".$SCONTOISCRIZIONE_SEM1."'
                            ,INIZIOISCRCORSISEM_SEM1='".$INIZIOISCRCORSISEM_SEM1."'
                            ,FINEISCRIZIONISEMINARI_SEM1='".$FINEISCRIZIONISEMINARI_SEM1."'
                            ,FINEISCRIZIONICORSI_SEM1='".$FINEISCRIZIONICORSI_SEM1."'
                            ,INIZIOLEZIONI_SEM1='".$INIZIOLEZIONI_SEM1."'
                            ,INIZIOPRENOTESAMI_SEM1='".$INIZIOPRENOTESAMI_SEM1."'
                            ,FINEPRENOTESAMI_SEM1='".$FINEPRENOTESAMI_SEM1."'
                            ,INIZIOPRENOTRECENSIONE='".$INIZIOPRENOTRECENSIONE."'
                            ,FINEPRENOTRECENSIONE='".$FINEPRENOTRECENSIONE."'
                            ,FINELEZIONI_SEM1='".$FINELEZIONI_SEM1."'
                            ,INIZIOESAMI_SEM1='".$INIZIOESAMI_SEM1."'
                            ,FINEESAMI_SEM1='".$FINEESAMI_SEM1."'
                            ,INIZIOISCRIZIONI_SEM2='".$INIZIOISCRIZIONI_SEM2."'
                            ,FINEISCRIZIONI_SEM2='".$FINEISCRIZIONI_SEM2."'
                            ,SCONTOISCRIZIONE_SEM2='".$SCONTOISCRIZIONE_SEM2."'
                            ,INIZIOISCRCORSISEM_SEM2='".$INIZIOISCRCORSISEM_SEM2."'
                            ,FINEISCRIZIONISEMINARI_SEM2='".$FINEISCRIZIONISEMINARI_SEM2."'
                            ,FINEISCRIZIONICORSI_SEM2='".$FINEISCRIZIONICORSI_SEM2."'
                            ,INIZIOLEZIONI_SEM2='".$INIZIOLEZIONI_SEM2."'
                            ,INIZIOPRENOTESAMI_SEM2='".$INIZIOPRENOTESAMI_SEM2."'
                            ,FINEPRENOTESAMI_SEM2='".$FINEPRENOTESAMI_SEM2."'
                            ,FINELEZIONI_SEM2='".$FINELEZIONI_SEM2."'
                            ,INIZIOESAMI_SEM2='".$INIZIOESAMI_SEM2."'
                            ,FINEESAMI_SEM2='".$FINEESAMI_SEM2."'
                      where ANNOACCADEMICO=".$ANNOACCADEMICO;
        $str_query=str_replace("'null'","null",$str_query);
        $this->db->query($str_query); 
        
        if ($ATTIVO=='1'){
            $this->db->query("update scadenze set ATTIVO=0 where ANNOACCADEMICO<>".$ANNOACCADEMICO); 
        }
        return;        
    }    
    public function SalvaNuovaScadenza($post){
        $ANNOACCADEMICO=$post['ANNOACCADEMICO'];
        $str_query = "insert into scadenze(ANNOACCADEMICO)
                            values(".$ANNOACCADEMICO.")";
        $this->db->query($str_query); 
        return;        
    }     
    public function DuplicaScadenze($post){
        $ANNOACCADEMICO_OLD=$post['ANNOACCADEMICO_OLD'];
        $ANNOACCADEMICO_NEW=$post['ANNOACCADEMICO_NEW'];
        $str_query = "delete from scadenze where ANNOACCADEMICO=".$ANNOACCADEMICO_NEW;
        $this->db->query($str_query); 

        $str_query = "INSERT INTO scadenze (ANNOACCADEMICO,INIZIOISCRIZIONI_SEM1,SCONTOISCRIZIONE_SEM1,FINEISCRIZIONI_SEM1,INIZIOISCRCORSISEM_SEM1,
                        FINEISCRIZIONISEMINARI_SEM1,FINEISCRIZIONICORSI_SEM1,INIZIOLEZIONI_SEM1,INIZIOPRENOTESAMI_SEM1,FINEPRENOTESAMI_SEM1,
                        INIZIOPRENOTRECENSIONE,FINEPRENOTRECENSIONE,FINELEZIONI_SEM1,INIZIOESAMI_SEM1,FINEESAMI_SEM1,
                        INIZIOISCRIZIONI_SEM2,SCONTOISCRIZIONE_SEM2,FINEISCRIZIONI_SEM2,INIZIOISCRCORSISEM_SEM2,FINEISCRIZIONISEMINARI_SEM2,
                        FINEISCRIZIONICORSI_SEM2,INIZIOLEZIONI_SEM2,INIZIOPRENOTESAMI_SEM2,FINEPRENOTESAMI_SEM2,FINELEZIONI_SEM2,
                        INIZIOESAMI_SEM2,FINEESAMI_SEM2,SEMESTRE)
                        SELECT 
                        ".$ANNOACCADEMICO_NEW.",DATE_SUB(INIZIOISCRIZIONI_SEM1, INTERVAL -365 DAY),
                        DATE_SUB(SCONTOISCRIZIONE_SEM1, INTERVAL -365 DAY),
                        DATE_SUB(FINEISCRIZIONI_SEM1, INTERVAL -365 DAY),
                        DATE_SUB(INIZIOISCRCORSISEM_SEM1, INTERVAL -365 DAY),
                        DATE_SUB(FINEISCRIZIONISEMINARI_SEM1, INTERVAL -365 DAY),
                        DATE_SUB(FINEISCRIZIONICORSI_SEM1, INTERVAL -365 DAY),
                        DATE_SUB(INIZIOLEZIONI_SEM1, INTERVAL -365 DAY),
                        DATE_SUB(INIZIOPRENOTESAMI_SEM1, INTERVAL -365 DAY),
                        DATE_SUB(FINEPRENOTESAMI_SEM1, INTERVAL -365 DAY),
                        DATE_SUB(INIZIOPRENOTRECENSIONE, INTERVAL -365 DAY),
                        DATE_SUB(FINEPRENOTRECENSIONE, INTERVAL -365 DAY),
                        DATE_SUB(FINELEZIONI_SEM1, INTERVAL -365 DAY),
                        DATE_SUB(INIZIOESAMI_SEM1, INTERVAL -365 DAY),
                        DATE_SUB(FINEESAMI_SEM1, INTERVAL -365 DAY),
                        DATE_SUB(INIZIOISCRIZIONI_SEM2, INTERVAL -365 DAY),
                        DATE_SUB(SCONTOISCRIZIONE_SEM2, INTERVAL -365 DAY),
                        DATE_SUB(FINEISCRIZIONI_SEM2, INTERVAL -365 DAY),
                        DATE_SUB(INIZIOISCRCORSISEM_SEM2, INTERVAL -365 DAY),
                        DATE_SUB(FINEISCRIZIONISEMINARI_SEM2, INTERVAL -365 DAY),
                        DATE_SUB(FINEISCRIZIONICORSI_SEM2, INTERVAL -365 DAY),
                        DATE_SUB(INIZIOLEZIONI_SEM2, INTERVAL -365 DAY),
                        DATE_SUB(INIZIOPRENOTESAMI_SEM2, INTERVAL -365 DAY),
                        DATE_SUB(FINEPRENOTESAMI_SEM2, INTERVAL -365 DAY),
                        DATE_SUB(FINELEZIONI_SEM2, INTERVAL -365 DAY),
                        DATE_SUB(INIZIOESAMI_SEM2, INTERVAL -365 DAY),
                        DATE_SUB(FINEESAMI_SEM2, INTERVAL -365 DAY),
                        1
                        FROM scadenze 
                        WHERE ANNOACCADEMICO=".$ANNOACCADEMICO_OLD;
        $this->db->query($str_query); 
        return;        
    }              
    
    public function trova_importo_tassa($causale,$anno_accademico,$corso_laurea,$anno_corso){
        $str_query="SELECT IMPORTOTASSA as valore
                    FROM importitasse 
                    WHERE CAUSALETASSA='".$causale."'" 
                    ." AND CORSODILAUREA=".$corso_laurea
                    ." AND ANNOACCADEMICO=".$anno_accademico;
        if ($anno_corso!=''){
            $str_query.=" AND ANNODICORSO=".$anno_corso;        
        }
        $query=$this->db->query($str_query);
        $row = $query->row();
        return $result = $row->valore;   
    }       

    public function ultimo_anno_accademico_importitasse(){
        $str_query="SELECT ANNOACCADEMICO as valore
                    FROM importitasse 
                    ORDER BY ANNOACCADEMICO DESC
                    LIMIT 1";        
        $query=$this->db->query($str_query);
        $row = $query->row();
        return $result = $row->valore;   
    }       
    
    
    
    public function trova_data_scadenza($data){
        $str_query="SELECT 
                    DATE_FORMAT(".$data.", '%d/%m/%Y') AS valore  
                    FROM scadenze 
                    WHERE ATTIVO=1"; 
        $query=$this->db->query($str_query);
        $row = $query->row();
        return $result = $row->valore;   
    }         

    
}
