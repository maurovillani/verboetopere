<?php

defined('BASEPATH') OR exit('No direct script access allowed');

Class Studente_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function tab_numero_record($qry){
        $str_query="select COUNT(*) as rec FROM (".$qry.") a";
        $query=$this->db->query($str_query);
        $result = $query->row_array(); 
        return $result;   
    } 
    
    public function tab_studente_pos($id,$qry){
        $str_query="SELECT row FROM (
                            SELECT @rownum:=@rownum+1 row, a.MATRICOL FROM (
                                    SELECT * FROM (".$qry.") STUD , (SELECT @rownum:=0) r
                                    ORDER BY STUD.COGNOME, STUD.NOMESTUD
                            )a
                    ) studentsWithRow
                    WHERE studentsWithRow.MATRICOL=".$id;
        $query=$this->db->query($str_query);
        $result = $query->row_array(); 
        return $result;   
    } 

    public function tab_professore_pos($id,$qry){
        $str_query="SELECT row FROM (
                            SELECT @rownum:=@rownum+1 row, a.MATRICOL FROM (
                                    SELECT * FROM (".$qry.") PROF , (SELECT @rownum:=0) r
                                    ORDER BY PROF.COGNOME, PROF.NOME
                            )a
                    ) studentsWithRow
                    WHERE studentsWithRow.MATRICOL=".$id;
        $query=$this->db->query($str_query);
        $result = $query->row_array(); 
        return $result;   
    } 
    
    public function tab_pulsanti_scheda_studente($id,$qry){
        $str_query="SELECT 1 as pos,MATRICOL FROM (
                    SELECT * 
                    FROM (".$qry.") s
                    ORDER BY s.COGNOME,s.NOMESTUD
                    LIMIT 0,1) primo

                    UNION 
                    SELECT 2 as pos, MATRICOL FROM (
                    SELECT * 
                    FROM (".$qry.") s
                    ORDER BY s.COGNOME,s.NOMESTUD
                    LIMIT ".$id.", 3) precedente

                    union SELECT 5 as pos,MATRICOL FROM (
                    SELECT * 
                    FROM (".$qry.") s
                    ORDER BY s.COGNOME desc,s.NOMESTUD desc
                    LIMIT 0,1) ultimo";
        $query=$this->db->query($str_query);
        $result = $query->result_array(); 
        return $result;          
    }
    public function tab_pulsanti_scheda_professore($id,$qry){
        $str_query="SELECT 1 as pos,MATRICOL FROM (
                    SELECT * 
                    FROM (".$qry.") s
                    ORDER BY s.COGNOME,s.NOME
                    LIMIT 0,1) primo

                    UNION 
                    SELECT 2 as pos, MATRICOL FROM (
                    SELECT * 
                    FROM (".$qry.") s
                    ORDER BY s.COGNOME,s.NOME
                    LIMIT ".$id.", 3) precedente

                    union SELECT 5 as pos,MATRICOL FROM (
                    SELECT * 
                    FROM (".$qry.") s
                    ORDER BY s.COGNOME desc,s.NOME desc
                    LIMIT 0,1) ultimo";
        $query=$this->db->query($str_query);
        $result = $query->result_array(); 
        return $result;          
    }
    
    public function tab_max_matricola($table){
        $str_query="SELECT MAX(MATRICOL)+1 AS MAX_MATRICOL
                    FROM ".$table;
        $query=$this->db->query($str_query);
        $result = $query->row_array(); 
        return $result;          
    }


    public function tab_studente($id){
        $str_query="SELECT s.*,
                           n2.CITTADINANZA AS CITTADINANZA_ATTUALE,
                           a.descrizione AS CONTINENTE_ATTUALE
                    FROM studente s
                    LEFT JOIN nazione n2 ON s.CITTADI2=n2.CODICENU
                    LEFT JOIN area_cittadinanza a ON n2.ALFAUNO=a.cod_area
                    WHERE s.deleted=0 and s.MATRICOL=".$id;
        $query=$this->db->query($str_query);
        $result = $query->row_array(); 
        return $result;          
    }

    public function tab_studente_preiscrizione($id){
        $str_query="SELECT s.*,
                           n2.CITTADINANZA AS CITTADINANZA_ATTUALE,
                           a.descrizione AS CONTINENTE_ATTUALE
                    FROM studente_preiscrizione s
                    LEFT JOIN nazione n2 ON s.CITTADI2=n2.CODICENU
                    LEFT JOIN area_cittadinanza a ON n2.ALFAUNO=a.cod_area
                    WHERE s.deleted=0 and s.ID=".$id;
        $query=$this->db->query($str_query);
        $result = $query->row_array(); 
        return $result;          
    }    
    
    public function tab_professore($id){
        $str_query="SELECT p.*,
                           n2.CITTADINANZA AS CITTADINANZA_ATTUALE,
                           a.descrizione AS CONTINENTE_ATTUALE
                    FROM professore p
                    LEFT JOIN nazione n2 ON p.CITTADI2=n2.CODICENU
                    LEFT JOIN area_cittadinanza a ON n2.ALFAUNO=a.cod_area
                    WHERE p.deleted=0 and p.MATRICOL=".$id;
        $query=$this->db->query($str_query);
        $result = $query->row_array(); 
        return $result;          
    }    
    
    public function tab_dati_provincia($id = NULL){
        if ($id===NULL) {
            $result['PROVINCIA']='';        
        }else{
            $str_query="SELECT p.DECODIF AS PROVINCIA
                        FROM provincia p 
                        WHERE p.CODICENU=".$id;
            $query=$this->db->query($str_query);
            $result = $query->row_array(); 
        }
        return $result['PROVINCIA'];          
    }         
    
    public function tab_dati_nazione($id = NULL){
        if ($id===NULL) $id='999';
        $str_query="SELECT n.CODICENU,
                           n.DECODIF AS NAZIONE,
                           n.CITTADINANZA,
                           if(n.CODICENU=999,'NON DEFINITO',a.descrizione) AS CONTINENTE
                    FROM nazione n 
                    INNER JOIN area_cittadinanza a ON n.ALFAUNO=a.cod_area
                    WHERE n.CODICENU=".$id;
        $query=$this->db->query($str_query);
        $result = $query->row_array(); 
        return $result;          
    }        
    
    
    //da eliminare
    public function tab_studente_dati_comune($id = NULL){
        //if ($id===NULL) $id='0';
        if ($id===NULL) {
            $result['CODICECOMUNE']='0';
            $result['COMUNE']='--';        
            $result['PROVINCIA']='--';        
            $result['NAZIONE']='--';        
            $result['CITTADINANZA']='--';        
            $result['CONTINENTE']='--';        
        }else{
            $str_query="SELECT c.CODICECOMUNE,
                               c.DECODIF AS COMUNE,
                               p.DECODIF AS PROVINCIA,
                               n.DECODIF AS NAZIONE,
                               n.CITTADINANZA,
                               a.descrizione AS CONTINENTE
                        FROM provincia p 
                        INNER JOIN comune c ON c.PROVINCIA=p.CODICENU 
                        INNER JOIN nazione n ON c.NAZIONE=n.CODICENU
                        INNER JOIN area_cittadinanza a ON n.ALFAUNO=a.cod_area
                        WHERE c.CODICECOMUNE=".$id;
            $query=$this->db->query($str_query);
            $result = $query->row_array(); 
        }
        return $result;          
    }        
    public function tab_note_anagrafiche($id = NULL){
        $str_query="SELECT *  
                    from noteanagrafiche
                    WHERE MATRICOLA=".$id;
        $query=$this->db->query($str_query);
        $result = $query->row_array(); 
        if(!isset($result)){
                $result['IDNOTA']='0';
                $result['MATRICOLA']='0';        
                $result['NOTA']='';        
        }
        return $result;          
    }
    public function tab_studente_indirizzi_permanenti($id = NULL){
        if (empty($id)) $id='0';
        $str_query="SELECT *  
                    from studente_indirizzi_permanenti
                    WHERE MATRICOLA=".$id;
        $query=$this->db->query($str_query);
        $result = $query->row_array(); 
        if(!isset($result)){
            $str_query="SELECT *  
                        from studente_indirizzi_permanenti
                        WHERE MATRICOLA='0'";
            $query=$this->db->query($str_query);
            $result = $query->row_array(); 
        }
        return $result;          
    }
    public function tab_statodocumenti($id = NULL){
        if ($id===NULL) $id='0'; //NON DOVREBBE ESSERE MAI NULL DA VERIFICARE
        $str_query="SELECT *  
                    from statodocumenti
                    WHERE MATRICOL=".$id;
        $query=$this->db->query($str_query);
        $result = $query->row_array(); 
        return $result;          
    }

    public function tab_corsi($id = NULL){
        if ($id===NULL) $id='0';
        $str_query="SELECT ps.CORSI,
                           c.sigla, 
                           ps.MATRICOL,
                           -- CONCAT(e.ANNOACCADEMICO-1,'-',e.ANNOACCADEMICO) AS ANNO_ACCADEMICO,
                           CONCAT(c.annoinizio,'-',c.annofine) AS ANNO_ACCADEMICO,
                           e.VOTOESAME,
                           e.CICLO,ps.ANNOCORS AS ANNODICORSO,
                           ps.tipo AS TIPO,
                           p.COGNOME AS PROFESSORE
                   FROM pianistudiostudente ps
                   INNER JOIN corsi c ON c.CORSI=ps.CORSI
                   LEFT JOIN esamistudente e ON e.MATRICOLA=ps.MATRICOL AND e.CORSO=c.CORSI
                   LEFT JOIN professore_materia pm ON pm.CORSI=c.CORSI AND pm.ANNOACCA=c.annofine -- e.ANNOACCADEMICO
                   LEFT JOIN professore p ON p.MATRICOL=pm.MATRICOL 
                   WHERE ps.deleted=0 AND ps.MATRICOL=".$id
                   ." ORDER BY e.ANNOACCADEMICO,c.sigla";
        $query=$this->db->query($str_query);
        $result = $query->result_array(); 
        return $result;          
    }

    public function tab_tasse($id = NULL){
        if ($id===NULL) $id='0';
        $str_query = "
            SELECT -- i.POSISCRIZIONE,
                tasse.* FROM (
                SELECT 
                   'T' AS tipo,
                   t.CODICETASSAPAGATA,
                   ct.DECODIFICA AS CAUSALE_TASSA,
                   cl.DECODIF AS CORSO_LAUREA, 
                   Concat(t.ANNOACCADEMICO-1,'-',t.ANNOACCADEMICO) AS ANNO_ACCADEMICO,
                   t.MATRICOL,
                   t.CORSODILAUREA,
                   t.ANNOACCADEMICO,
                   t.ANNOCORSO,
                   t.MODALITA,
                   t.IMPPAGATO,
                   t.DATAPAGAMENTO,
                   t.NOTA
                FROM tassestudente t
                LEFT JOIN causaletassa ct ON ct.CODICECAUSALE=t.CAUSALETASSE
                LEFT JOIN corsidilaurea cl ON cl.CODICENU=t.CORSODILAUREA
                WHERE t.deleted=0 AND t.MATRICOL=".$id
                ." UNION
                SELECT 
                   'E' AS tipo,
                   Concat(t.MATRICOL,'_',t.ANNOACCA,'_',t.CORSOLAUREA,'_',t.ANNOCORSO) AS CODICETASSAPAGATA,
                   m.DECODIF AS CAUSALE_TASSA,
                   cl.DECODIF AS CORSO_LAUREA, 
                   Concat(t.ANNOACCA-1,'-',t.ANNOACCA) AS ANNO_ACCADEMICO,
                   t.MATRICOL,
                   t.CORSOLAUREA AS CORSODILAUREA,
                   t.ANNOACCA,
                   t.ANNOCORSO,
                   NULL as MODALITA,
                   -t.IMPORTOESONERO AS IMPPAGATO,
                   t.DATAESONERO AS DATAPAGAMENTO,
                        t.NOTE
                FROM esonerotasse t
                LEFT JOIN corsidilaurea cl ON cl.CODICENU=t.CORSOLAUREA
                LEFT JOIN motesonerotasse m ON m.CODICENU=t.MOTIVOESONERO
                WHERE t.deleted=0 AND t.MATRICOL=".$id
                .") tasse 
--                INNER JOIN iscrizionistudente i ON i.MATRICOL=tasse.MATRICOL 
--                                                AND i.CORSOLAUREA=tasse.CORSODILAUREA
--						AND i.ANNOACCA=tasse.ANNOACCADEMICO
--						-- AND i.ANNOCORSO=tasse.ANNOCORSO                
                ORDER BY ANNO_ACCADEMICO DESC, CODICETASSAPAGATA DESC, DATAPAGAMENTO
                ";
        
        $query=$this->db->query($str_query);
        $result = $query->result_array(); 
        return $result;          
    }    
    
    public function tab_tasse_old($id = NULL){
        if ($id===NULL) $id='0';
//        $str_query="SELECT 
//                        ct.DECODIFICA AS CAUSALE_TASSA,
//                        cl.DECODIF AS CORSO_LAUREA, 
//                        Concat(t.ANNOACCADEMICO-1,'-',t.ANNOACCADEMICO) AS ANNO_ACCADEMICO,
//                        t.*
//                        FROM tassestudente t
//                        LEFT JOIN causaletassa ct ON ct.CODICECAUSALE=t.CAUSALETASSE
//                        LEFT JOIN corsidilaurea cl ON cl.CODICENU=t.CORSODILAUREA
//                        WHERE t.deleted=0 AND t.MATRICOL=".$id
//                        ." ORDER BY t.DATAPAGAMENTO";
        
        $str_query = "
            SELECT * FROM (
                SELECT 
                   'T' AS tipo,
                   t.CODICETASSAPAGATA,
                   ct.DECODIFICA AS CAUSALE_TASSA,
                   cl.DECODIF AS CORSO_LAUREA, 
                   Concat(t.ANNOACCADEMICO-1,'-',t.ANNOACCADEMICO) AS ANNO_ACCADEMICO,
                   t.MATRICOL,
                   t.CORSODILAUREA,
                   t.ANNOACCADEMICO,
                   t.ANNOCORSO,
                   t.MODALITA,
                   t.IMPPAGATO,
                   t.DATAPAGAMENTO,
                   t.NOTA
                FROM tassestudente t
                LEFT JOIN causaletassa ct ON ct.CODICECAUSALE=t.CAUSALETASSE
                LEFT JOIN corsidilaurea cl ON cl.CODICENU=t.CORSODILAUREA
                WHERE t.deleted=0 AND t.MATRICOL=".$id
                ." UNION
                SELECT 
                   'E' AS tipo,
                   Concat(t.MATRICOL,'_',t.ANNOACCA,'_',t.CORSOLAUREA,'_',t.ANNOCORSO) AS CODICETASSAPAGATA,
                   m.DECODIF AS CAUSALE_TASSA,
                   cl.DECODIF AS CORSO_LAUREA, 
                   Concat(t.ANNOACCA-1,'-',t.ANNOACCA) AS ANNO_ACCADEMICO,
                   t.MATRICOL,
                   t.CORSOLAUREA AS CORSODILAUREA,
                   t.ANNOACCA,
                   t.ANNOCORSO,
                   NULL as MODALITA,
                   -t.IMPORTOESONERO AS IMPPAGATO,
                   t.DATAESONERO AS DATAPAGAMENTO,
                        t.NOTE
                FROM esonerotasse t
                LEFT JOIN corsidilaurea cl ON cl.CODICENU=t.CORSOLAUREA
                LEFT JOIN motesonerotasse m ON m.CODICENU=t.MOTIVOESONERO
                WHERE t.deleted=0 AND t.MATRICOL=".$id
                .") tasse "
                ."ORDER BY CODICETASSAPAGATA DESC, ANNO_ACCADEMICO DESC, DATAPAGAMENTO
                ";
        
        $query=$this->db->query($str_query);
        $result = $query->result_array(); 
        return $result;          
    }

    public function tab_tassa_attiva($id = NULL){
        if ($id===NULL) $id='0';
        $str_query="SELECT t.CODICETASSAPAGATA,t.CORSODILAUREA,t.ANNOACCADEMICO,t.ANNOCORSO,
                            DATE_FORMAT(p.PAGANTICIPATO, '%d/%m/%Y') AS PAGANTICIPATO,
                            DATE_FORMAT(p.PAGAMENTO, '%d/%m/%Y') AS PAGAMENTO,
                            p.PENALE,p.SCONTO
                    FROM tassestudente t
                    INNER JOIN iscrizionistudente i ON i.MATRICOL=".$id." -- AND i.POSISCRIZIONE=7
                    INNER JOIN parametri_preiscrizione p ON p.ANNOACCA=t.ANNOACCADEMICO
                    WHERE t.deleted=0 AND isnull(t.DATABOLLETTINO) AND t.MATRICOL=".$id;
        $query=$this->db->query($str_query);
        $result = $query->row_array(); 
        return $result;          
    }    
    
    public function tab_corsidilaurea_da_fare($id = NULL){
        if ($id===NULL) $id='0'; //NON DOVREBBE ESSERE MAI NULL DA VERIFICARE
        $str_query="SELECT CODICENU,DECODIF 
                    FROM corsidilaurea
                    WHERE CODICENU NOT IN( 
                            SELECT DISTINCT i.CORSOLAUREA
                            FROM iscrizionistudente i
                            WHERE i.deleted=0 AND i.CORSOLAUREA<8888 AND i.MATRICOL=".$id.")";
        $query=$this->db->query($str_query);
        $result = $query->result_array(); 
        return $result;          
    }
    
    
    public function tab_iscrizioni($id = NULL){
        if ($id===NULL) $id='0'; //NON DOVREBBE ESSERE MAI NULL DA VERIFICARE
        $str_query="SELECT i.id_iscrizione,
                           i.MATRICOL,
                           i.ANNOACCA,
                           i.CORSOLAUREA,
                           c.CODICENU AS CODICE_LAUREA,
                           i.INDIRIZZOLAUREA,
                           Concat(i.ANNOACCA-1,'-',i.ANNOACCA) AS ANNO_ACCADEMICO,
                           c.DECODIF AS CORSO_LAUREA,
                           i.SEMESTRECORSO,
                           i.CORSOCONFERMA,
                           i.SEMESTREACCA,                           
                           l.DECODIFICA AS INDIRIZZO_LAUREA,
                           i.NOTA,
                           e.NESAMI,
                           if(isnull(el.MATRICOL),0,1) AS TERMINATO
                    FROM iscrizionistudente i
                    INNER JOIN corsidilaurea c ON i.CORSOLAUREA=c.CODICENU 
                    LEFT JOIN indirizzolaurea l ON i.INDIRIZZOLAUREA=l.CODICENU 
                    LEFT JOIN (
                    SELECT
                        COUNT(c.CORSI) AS NESAMI,
                        c.SEMESTRE, 
                        e.MATRICOLA,
                        e.ANNOACCADEMICO
                    FROM esamistudente e 
                    INNER JOIN corsi c ON c.CORSI=e.CORSO
                    WHERE c.TIPOMEDIA='C' AND e.MATRICOLA=".$id."
                    GROUP BY 
                        c.SEMESTRE,
                        e.MATRICOLA,
                        e.ANNOACCADEMICO) e ON e.MATRICOLA=i.MATRICOL AND e.ANNOACCADEMICO=i.ANNOACCA AND e.semestre=i.SEMESTREACCA
                    LEFT JOIN esamidilaurea el ON  el.MATRICOL=i.MATRICOL AND el.CORSOLAU=i.CORSOLAUREA AND NOT ISNULL(el.QUALIFICA)
                    WHERE i.deleted=0 and i.MATRICOL=".$id
                    ." ORDER BY i.ANNOACCA desc, i.SEMESTREACCA desc, i.CORSOLAUREA desc";
        $query=$this->db->query($str_query);
        $result = $query->result_array(); 
        return $result;          
    }

    public function tab_indirizzolicenza($id = NULL){
        if ($id===NULL) $id='0'; //NON DOVREBBE ESSERE MAI NULL DA VERIFICARE
        $str_query="SELECT 
                        i.MATRICOL,
                        MAX(i.ANNOACCA) AS ANNOACCA,
                        MAX(i.SEMESTRECORSO) AS SEMESTRECORSO,
                        l.DECODIFICA AS INDIRIZZO_LAUREA,
                        l.CODICENU
                    FROM iscrizionistudente i
                    LEFT JOIN indirizzolaurea l ON i.INDIRIZZOLAUREA=l.CODICENU 
                    WHERE i.deleted=0 and i.CORSOLAUREA=210 AND i.MATRICOL=".$id."
                    GROUP BY i.MATRICOL";
        $query=$this->db->query($str_query);
        $result = $query->row_array(); 
        return $result;          
    }
    public function tab_qualifica($id,$CORSOLAU){
        if ($id===NULL) $id='0'; //NON DOVREBBE ESSERE MAI NULL DA VERIFICARE
        $str_query="SELECT 
                        e.MATRICOL,
                        e.QUALIFICA
                    FROM esamidilaurea e
                    WHERE e.CORSOLAU=".$CORSOLAU." AND e.MATRICOL=".$id;
        $query=$this->db->query($str_query);
        $result = $query->row_array(); 
        return $result;          
    }
    
    
    public function tab_preiscrizioni($id = NULL){
        if ($id===NULL) $id='0'; //NON DOVREBBE ESSERE MAI NULL DA VERIFICARE
        $str_query="SELECT i.ID,
                           i.ANNOACCA,
                           i.CORSOLAUREA,
                           c.CODICENU AS CODICE_LAUREA,
                           i.INDIRIZZOLAUREA,
                           Concat(i.ANNOACCA-1,'-',i.ANNOACCA) AS ANNO_ACCADEMICO,
                           i.CATEGORIA,
                           c.DECODIF AS CORSO_LAUREA,
                           i.ANNOCORSO,
                           l.DECODIFICA AS INDIRIZZO_LAUREA,
                           i.PAGAMENTOMOD,
                           i.PAGAMENTODATA,
                           i.NOME_PAGANTE,
                           i.EMAIL_PAGANTE
                    FROM studente_preiscrizione i
                    LEFT JOIN corsidilaurea c ON i.CORSOLAUREA=c.CODICENU 
                    LEFT JOIN indirizzolaurea l ON i.INDIRIZZOLAUREA=l.CODICENU 
                    WHERE i.deleted=0 and i.ID=".$id
                    ." ORDER BY i.ANNOACCA";
        $query=$this->db->query($str_query);
        $result = $query->result_array(); 
        return $result;          
    }
    
    public function tab_iscrizione($id,$annoaccademico){
        $str_query="SELECT i.MATRICOL,
                           i.ANNOACCA,
                           i.CORSOLAUREA,
                           i.INDIRIZZOLAUREA,
                           Concat(i.ANNOACCA-1,'-',i.ANNOACCA) AS ANNO_ACCADEMICO,
                           i.CATEGORIA,
                           c.DECODIF AS CORSO_LAUREA,
                           i.ANNOCORSO,
                           l.DECODIFICA AS INDIRIZZO_LAUREA
                    FROM iscrizionistudente i
                    INNER JOIN corsidilaurea c ON i.CORSOLAUREA=c.CODICENU 
                    LEFT JOIN indirizzolaurea l ON i.INDIRIZZOLAUREA=l.CODICENU 
                    WHERE i.MATRICOL=".$id." AND ANNOACCA=".$annoaccademico;
        $query=$this->db->query($str_query);
        $result = $query->row_array(); 
        return $result;          
    }

    
    public function tab_titoli_accademici($id = NULL){
        if ($id===NULL) $id='0'; //NON DOVREBBE ESSERE MAI NULL DA VERIFICARE
        $str_query="SELECT t.MATRICOL,
                           t.TIPTITST,
                           tts.DECODIF AS TITOLO_STUDIO,
                           t.ANNOACCA,
                           CONCAT(t.ANNOACCA-1,'-',t.ANNOACCA) AS ANNO_CONSEGUIMENTO, 
                           t.VOTAZIONE,
                           t.QUALIFICA,
                           t.ISTISUPE,
                           ut.DECODIF AS UNIVERSITA,
                           t.TIPDOCAL,
                           td.DECODIF AS DOCUMENTO,
                           t.DATA_SANATIO,
                           t.NOTA
                    FROM titolistudente t
                    LEFT JOIN tipotitolosup tts ON t.TIPTITST=tts.CODICENU 
                    LEFT JOIN universitatrasf ut ON t.ISTISUPE=ut.CODICENU 
                    LEFT JOIN tipodocumentazione td ON t.TIPDOCAL=td.CODICENU 
                    WHERE t.deleted=0 and t.MATRICOL=".$id
                    ." ORDER BY t.ANNOACCA";
        $query=$this->db->query($str_query);
        $result = $query->result_array(); 
        return $result;          
    }    

    public function tab_titoli_accademici_preiscrizione($id = NULL){
        if ($id===NULL) $id='0'; //NON DOVREBBE ESSERE MAI NULL DA VERIFICARE
        $str_query="SELECT t.ID,
                           t.TIPTITST,
                           tts.DECODIF AS TITOLO_STUDIO,
                           t.ANNOACCA,
                           CONCAT(t.ANNOACCA-1,'-',t.ANNOACCA) AS ANNO_CONSEGUIMENTO, 
                           t.VOTAZIONE,
                           t.QUALIFICA,
                           t.ISTISUPE,
                           ut.DECODIF AS UNIVERSITA,
                           t.TIPDOCAL,
                           td.DECODIF AS DOCUMENTO,
                           t.DATA_SANATIO,
                           t.NOTA
                    FROM titolistudente_preiscrizione t
                    LEFT JOIN tipotitolosup tts ON t.TIPTITST=tts.CODICENU 
                    LEFT JOIN universitatrasf ut ON t.ISTISUPE=ut.CODICENU 
                    LEFT JOIN tipodocumentazione td ON t.TIPDOCAL=td.CODICENU 
                    WHERE t.deleted=0 and t.ID=".$id;
        $query=$this->db->query($str_query);
        $result = $query->result_array(); 
        return $result;          
    }    
    
    public function tab_anno_accademico(){
//        $str_query="SELECT DISTINCT ANNOACCA,CONCAT(ANNOACCA-1,'/',ANNOACCA) AS ANNOACCADEMICO 
//                    from iscrizionistudente 
//                    ORDER BY ANNOACCA DESC";
        $str_query="SELECT * FROM anni_accademici ORDER BY ANNOACCA DESC";
        $query=$this->db->query($str_query);
        $result = $query->result_array(); 
        return $result;          
    }    

    public function tab_corsidilaurea(){
        $str_query="SELECT CODICENU,DECODIF 
                    from corsidilaurea 
                    ORDER BY CODICENU";
        $query=$this->db->query($str_query);
        $result = $query->result_array(); 
        return $result;          
    } 
    
    public function tab_titolistudio(){
        $str_query="SELECT CODICENU,DECODIF 
                    from titolistudio 
                    ORDER BY CODICENU";
        $query=$this->db->query($str_query);
        $result = $query->result_array(); 
        return $result;          
    }     

    public function corsodilaurea($id){
        $str_query="SELECT DECODIF 
                    from corsidilaurea 
                    WHERE CODICENU=".$id;
        $query=$this->db->query($str_query);
        $result = $query->row_array(); 
        return $result;          
    }   
    public function statocivile($id){
        $str_query="SELECT DECODIF 
                    from statocivile 
                    WHERE CODICENU=".$id;
        $query=$this->db->query($str_query);
        $result = $query->row_array(); 
        return $result;          
    }       
    
    public function tab_statocivile(){
        $str_query="select CODICENU,DECODIF from statocivile "
                . "order by DECODIF";
        $query=$this->db->query($str_query);
        $result = $query->result_array(); 
        return $result;          
    }        

    public function tab_indirizzolaurea(){
        $str_query="select CODICENU,DECODIFICA from indirizzolaurea "
                . "order by DECODIFICA";
        $query=$this->db->query($str_query);
        $result = $query->result_array(); 
        return $result;          
    }      
    public function tab_causaletassa(){
        $str_query="select CODICECAUSALE,DECODIFICA from causaletassa "
                . "order by DECODIFICA";
        $query=$this->db->query($str_query);
        $result = $query->result_array(); 
        return $result;          
    }      
    public function tab_posizioneiscrizione(){
        $str_query="select CODICENU,DECODIF from posizioneiscrizione "
                . "order by CODICENU";
        $query=$this->db->query($str_query);
        $result = $query->result_array(); 
        return $result;          
    }   
    public function tab_tipotitolosup(){
        $str_query="SELECT CODICENU,DECODIF 
                    from tipotitolosup 
                    ORDER BY DECODIF";
        $query=$this->db->query($str_query);
        $result = $query->result_array(); 
        return $result;          
    }       
    
    public function tab_universitatrasf(){
        $str_query="SELECT CODICENU,DECODIF 
                    from universitatrasf 
                    ORDER BY DECODIF";
        $query=$this->db->query($str_query);
        $result = $query->result_array(); 
        return $result;          
    }      
    
    public function tab_tipodocumentazione(){
        $str_query="SELECT CODICENU,DECODIF 
                    from tipodocumentazione 
                    ORDER BY DECODIF";
        $query=$this->db->query($str_query);
        $result = $query->result_array(); 
        return $result;          
    }      

    public function tab_lingue_moderne(){
        $str_query="select CODICENU,DESCRIZIONE AS CITTADINANZA from lingue"; 
        $query=$this->db->query($str_query);
        $result = $query->result_array(); 
        return $result;          
    }        
    
    public function tab_diocesi($id = NULL){
        if ($id===NULL) {
            $result['CODICE']='0';
            $result['DIOCESI']='';        
        }else{
            $str_query="select CODICE,DIOCESI from diocesi "
                    . "where CODICE=".$id;
            $query=$this->db->query($str_query);
            $result = $query->row_array(); 
        }
        return $result;          
    }         
    
    public function tab_ordine($id = NULL){
        if ($id===NULL) {
            $result['CODICE']='0';
            $result['DECODIF']='';        
        }else{
            $str_query="select CODICENU,DECODIF from ordine "
                    . "where CODICENU=".$id;
            $query=$this->db->query($str_query);
            $result = $query->row_array(); 
        }
        return $result;          
    }          
    public function tab_collegio($id = NULL){
		if (empty($id)) $id=0;

       $str_query="select collegi.*,comune.DECODIF as COMUNE, provincia.DECODIF AS PROV "
                . " from collegi "
                . " left join comune on collegi.CITTA=comune.CODICECOMUNE"
                . " left join provincia on collegi.PROVINCIA=provincia.CODICENU"
                . " where collegi.deleted=0 and CODICE=".$id;
        $query=$this->db->query($str_query);
        $result = $query->row_array(); 
		
		
        return $result;          
    }              
    public function SalvaNuovoStudente($post){
	$MATRICOL = $post['MATRICOL'];
	$COGNOME = $post['COGNOME'];
	$NOMESTUD = $post['NOMESTUD'];
	$SESSO = $post['SESSO'];
        $str_query = "insert into studente( 
                        MATRICOL,COGNOME,NOMESTUD,SESSO)
                        values(
                        '".str_replace("'","''",$MATRICOL)."',
                        '".str_replace("'","''",$COGNOME)."',
                        '".str_replace("'","''",$NOMESTUD)."',
                        '".$SESSO."'
                        )";
        $this->db->query($str_query); 
        return;                
    }
    public function SalvaModificaStudente($id,$post){
	$MATRICOL = $post['MATRICOL'];
//	$UNIVERSITA = $post[''];
	$COGNOME = $post['COGNOME'];
	$NOMESTUD = $post['NOMESTUD'];
	$NASCDATA = $post['NASCDATA'];
//	$NASCCOMU = $post[''];
	$NASCCOMUNE = $post['NASCCOMUNE'];
	$NASCPROV = $post['ID_provincia'];
	$NASCNAZI = $post['ID_nazione'];
	$RESINDS = $post['RESINDS'];
//	$RESCOMU = $post[''];
	$RESCOMUNE = $post['RESCOMUNE'];
	$RESPROV = $post['ID_provinciaresidenza'];
	$RESNAZI = $post['ID_nazioneresidenza'];
	$RESCAP = $post['RESCAP'];
	$RESTELE = $post['RESTELE'];
	$RECPRES = $post['RECPRES'];
	$RECINDS = $post['RECINDS'];
//	$RECCOMU = $post[''];
	$RECCOMUNE = $post['RECCOMUNE'];
	$RECPROV = $post['ID_provinciarecapito'];
//	$RECNAZI = $post['ID_nazionerecapito'];
	$RECCAP = $post['RECCAP'];
	$RECTELE = $post['RECTELE'];
	$CITTADI1 = $post['CITTADINANZA_NASCITA'];
	$CITTADI2 = $post['ID_cittadinanza'];
	$SESSO = $post['SESSO'];
//	$POSMILIT = $post[''];
	$STATOCIV = $post['STATOCIV'];
	$CODFISCA = $post['CODFISCA'];
//	$ANNMATRI = $post[''];
//	$NUMMATRI = $post[''];
//	$FCESSATO = $post[''];
//	$CAUSCESS = $post[''];
//	$DATACESS = $post[''];
	$FSOSPES = $post['FSOSPES'];
//	$FNOTASI = $post[''];
//	$NSTLIBR = $post[''];
//	$NSTCERT = $post[''];
//	$DATSTLIB = $post[''];
//	$DATSTCER = $post[''];
	$DATAIMMI = $post['DATAIMMI'];
//	$FABBRE = $post[''];
//	$FACOLTA = $post[''];
	$COLLEGIO = $post['ID_collegio'];
	$ORDINE = $post['ID_ordine'];
	$DIOCESI = $post['ID_diocesi'];
//	$PASSWORD = $post[''];
	$email = $post['email'];
	$cellulare = $post['cellulare'];
//	$note = $post['note'];
//	$privacy = $post[''];
//	$nomereligioso = $post[''];
//	$matricola_teresianum = $post[''];
//	$religione = $post[''];
//	$ex_allievo = $post[''];
//	$agenziaentrate = $post[''];        
        
        $str_query = "update studente set ";
        $str_query .= "MATRICOL = '".str_replace("'","''",$MATRICOL)."'";
        $str_query .= ",COGNOME = '".str_replace("'","''",$COGNOME)."'";
        $str_query .= ",NOMESTUD = '".str_replace("'","''",$NOMESTUD)."'";
        $str_query .= ",NASCDATA = '".str_replace("'","''",$NASCDATA)."'";
        $str_query .= ",NASCCOMUNE = '".str_replace("'","''",$NASCCOMUNE)."'";
        if (intval($NASCPROV)>0) {
            $str_query .= ",NASCPROV=".$NASCPROV;
        }else{
            $str_query .= ",NASCPROV=null";
        }
        if (intval($NASCNAZI)>0) {
            $str_query .= ",NASCNAZI=".$NASCNAZI;
        }else{
            $str_query .= ",NASCNAZI=null";
        }
        $str_query .= ",RESINDS = '".str_replace("'","''",$RESINDS)."'";
        $str_query .= ",RESCOMUNE = '".str_replace("'","''",$RESCOMUNE)."'";
        if (intval($RESPROV)>0) {
            $str_query .= ",RESPROV=".$RESPROV;
        }else{
            $str_query .= ",RESPROV=null";
        }
        if (intval($RESNAZI)>0) {
            $str_query .= ",RESNAZI=".$RESNAZI;
        }else{
            $str_query .= ",RESNAZI=null";
        }        
        $str_query .= ",RESCAP = '".str_replace("'","''",$RESCAP)."'";
        $str_query .= ",RESTELE = '".str_replace("'","''",$RESTELE)."'";
        $str_query .= ",RECPRES = '".str_replace("'","''",$RECPRES)."'";
        $str_query .= ",RECINDS = '".str_replace("'","''",$RECINDS)."'";
        $str_query .= ",RECCOMUNE = '".str_replace("'","''",$RECCOMUNE)."'";
        if (intval($RECPROV)>0) {
            $str_query .= ",RECPROV=".$RECPROV;
        }else{
            $str_query .= ",RECPROV=null";
        }
//        if (intval($RESNAZI)>0) {
//            $str_query .= ",RECNAZI=".$RECNAZI;
//        }else{
//            $str_query .= ",RECNAZI=null";
//        }                
        $str_query .= ",RECCAP = '".str_replace("'","''",$RECCAP)."'";
        $str_query .= ",RECTELE = '".str_replace("'","''",$RECTELE)."'";
        if (intval($CITTADI1)>0) {
            $str_query .= ",CITTADI1=".$CITTADI1;
        }else{
            $str_query .= ",CITTADI1=null";
        }        
        if (intval($CITTADI2)>0) {
            $str_query .= ",CITTADI2=".$CITTADI2;
        }else{
            $str_query .= ",CITTADI2=null";
        }        
        $str_query .= ",SESSO = '".str_replace("'","''",$SESSO)."'";
        if (intval($STATOCIV)>0) {
            $str_query .= ",STATOCIV=".$STATOCIV;
        }else{
            $str_query .= ",STATOCIV=null";
        }        
        $str_query .= ",CODFISCA = '".str_replace("'","''",$CODFISCA)."'";
        if (intval($DATAIMMI)>0) {
            $str_query .= ",DATAIMMI='".$DATAIMMI."'";
        }else{
            $str_query .= ",DATAIMMI=null";
        }
        $str_query .= ",FSOSPES = '".str_replace("'","''",$FSOSPES)."'";
        if (intval($COLLEGIO)>0) {
            $str_query .= ",COLLEGIO=".$COLLEGIO;
        }else{
            $str_query .= ",COLLEGIO=null";
        }        
        if (intval($ORDINE)>0) {
            $str_query .= ",ORDINE=".$ORDINE;
        }else{
            $str_query .= ",ORDINE=null";
        }        
        if (intval($DIOCESI)>0) {
            $str_query .= ",DIOCESI=".$DIOCESI;
        }else{
            $str_query .= ",DIOCESI=null";
        }        
        $str_query .= ",email = '".str_replace("'","''",$email)."'";
        $str_query .= ",cellulare = '".str_replace("'","''",$cellulare)."'";

        $str_query .= " where MATRICOL=".$id;        
        $this->db->query($str_query); 
        return;        
    }
    public function SalvaNoteAnagrafiche($id,$post){
	$MATRICOLA = $post['MATRICOL'];
	$NOTA = $post['NOTA_ANAGRAFICA'];
        $new = $this->db->where("MATRICOLA",$id)->get("noteanagrafiche")->row_array();
        if(isset($new)){
            $str_query = "update noteanagrafiche set 
                            MATRICOLA = ".$MATRICOLA.",
                            NOTA = '".str_replace("'","''",$NOTA)."'
                          where MATRICOLA=".$id;        
        }else{
            $str_query = "insert into noteanagrafiche( 
                            IDNOTA,MATRICOLA,NOTA)
                            values(1,
                            ".$MATRICOLA.",
                            '".str_replace("'","''",$NOTA)."')";
        }
        $this->db->query($str_query); 
        return;        
    }    
    public function SalvaModificaStudenteIndirizziPermanenti($id,$post){
	$MATRICOLA = $post['MATRICOL'];
	$SUPERIORE = $post['SUPERIORE'];
	$IND_SUP1 = $post['IND_SUP1'];
	$IND_SUP2 = $post['IND_SUP2'];
	$SUP_CITY = $post['SUP_CITY'];
	$SUP_STATE = $post['UP_STATE'];
	$S_COUNTRY = $post['S_COUNTRY'];
	$SZIPEUR = $post['SZIPEUR'];
	$SPHONE = $post['SPHONE'];
	$SFAX = $post['SFAX'];
	$SUPMOVILE = $post['SUPMOVILE'];
	$SEMAIL = $post['SEMAIL'];       
        $new = $this->db->where("MATRICOLA",$id)->get("studente_indirizzi_permanenti")->row_array();
        if(isset($new)){
            $str_query = "update studente_indirizzi_permanenti set 
                            MATRICOLA = '".str_replace("'","''",$MATRICOLA)."',
                            SUPERIORE = '".str_replace("'","''",$SUPERIORE)."',
                            IND_SUP1 = '".str_replace("'","''",$IND_SUP1)."',
                            IND_SUP2 = '".str_replace("'","''",$IND_SUP2)."',
                            SUP_CITY = '".str_replace("'","''",$SUP_CITY)."',
                            SUP_STATE = '".str_replace("'","''",$SUP_STATE)."',
                            S_COUNTRY = '".str_replace("'","''",$S_COUNTRY)."',
                            SZIPEUR = '".str_replace("'","''",$SZIPEUR)."',
                            SPHONE = '".str_replace("'","''",$SPHONE)."',
                            SFAX = '".str_replace("'","''",$SFAX)."',
                            SUPMOVILE = '".str_replace("'","''",$SUPMOVILE)."',
                            SEMAIL = '".str_replace("'","''",$SEMAIL)."'       
                          where MATRICOLA=".$id;        
        }else{
            $str_query = "insert into studente_indirizzi_permanenti( 
                            MATRICOLA,SUPERIORE,IND_SUP1,IND_SUP2,SUP_CITY,SUP_STATE,
                            S_COUNTRY,SZIPEUR,SPHONE,SFAX,SUPMOVILE,SEMAIL)
                            values(
                            '".str_replace("'","''",$MATRICOLA)."',
                            '".str_replace("'","''",$SUPERIORE)."',
                            '".str_replace("'","''",$IND_SUP1)."',
                            '".str_replace("'","''",$IND_SUP2)."',
                            '".str_replace("'","''",$SUP_CITY)."',
                            '".str_replace("'","''",$SUP_STATE)."',
                            '".str_replace("'","''",$S_COUNTRY)."',
                            '".str_replace("'","''",$SZIPEUR)."',
                            '".str_replace("'","''",$SPHONE)."',
                            '".str_replace("'","''",$SFAX)."',
                            '".str_replace("'","''",$SUPMOVILE)."',
                            '".str_replace("'","''",$SEMAIL)."'
                            )";
        }
        $this->db->query($str_query); 
        return;        
    }
    public function SalvaModificaStatoDocumenti($id,$post){
	$MATRICOL = $post['MATRICOL'];
	$CERTNASC = $post['CERTNASC'];
	$FOTOGRAF = $post['FOTOGRAF'];
	$LATINO = $post['LATINO'];
	$GRECO = $post['GRECO'];
	$AUTSUP = $post['AUTSUP'];
        $PRESAINCARICO = $post['PRESAINCARICO'];
	$ITASTRANIERI = $post['ITASTRANIERI'];
	$NOTA = $post['STATODOC_NOTA'];
	$permessosogg = $post['permessosogg'];
	$esame_ital = $post['esame_ital'];
	$celebret = $post['celebret'];       
	$DATAAGGIORN = $post['DATAAGGIORN'];
	$PRIVACY = $post['PRIVACY'];
	$datascad_permessosogg = $post['datascad_permessosogg'];
	$datascad_extracollegio = $post['datascad_extracollegio'];
	$PRIMALINGUA = $post['PRIMALINGUA'];
	$SECLINGUA = $post['SECLINGUA'];
	$TERLINGUA = $post['TERLINGUA'];
	$QUALINGUA = $post['QUALINGUA'];
        
        $new = $this->db->where("MATRICOL",$id)->get("statodocumenti")->row_array();
        if(isset($new)){
            $str_query = "update statodocumenti set ";
            $str_query .= "MATRICOL = '".str_replace("'","''",$MATRICOL)."',";
            $str_query .= "CERTNASC = '".str_replace("'","''",$CERTNASC)."',";
            $str_query .= "FOTOGRAF = '".str_replace("'","''",$FOTOGRAF)."',";
            $str_query .= "LATINO = '".str_replace("'","''",$LATINO)."',";
            $str_query .= "GRECO = '".str_replace("'","''",$GRECO)."',";
            $str_query .= "AUTSUP = '".str_replace("'","''",$AUTSUP)."',";
            $str_query .= "PRESAINCARICO = '".str_replace("'","''",$PRESAINCARICO)."',";
            $str_query .= "ITASTRANIERI = '".str_replace("'","''",$ITASTRANIERI)."',";
            $str_query .= "NOTA = '".str_replace("'","''",$NOTA)."',";
            $str_query .= "permessosogg = '".str_replace("'","''",$permessosogg)."',";
            $str_query .= "esame_ital = '".str_replace("'","''",$esame_ital)."',";
            $str_query .= "celebret = '".str_replace("'","''",$celebret)."'"; 
            if (intval($DATAAGGIORN)>0) {
                $str_query .= ",DATAAGGIORN='".$DATAAGGIORN."'";
            }else{
                $str_query .= ",DATAAGGIORN=null";
            }        
            if (intval($PRIVACY)>0) {
                $str_query .= ",PRIVACY='".$PRIVACY."'";
            }else{
                $str_query .= ",PRIVACY=null";
            }        
            if (intval($datascad_permessosogg)>0) {
                $str_query .= ",datascad_permessosogg='".$datascad_permessosogg."'";
            }else{
                $str_query .= ",datascad_permessosogg=null";
            }        
            if (intval($datascad_extracollegio)>0) {
                $str_query .= ",datascad_extracollegio='".$datascad_extracollegio."'";
            }else{
                $str_query .= ",datascad_extracollegio=null";
            }        
            if (intval($PRIMALINGUA)>0) {
                $str_query .= ",PRIMALINGUA=".$PRIMALINGUA;
            }else{
                $str_query .= ",PRIMALINGUA=null";
            }        
            if (intval($SECLINGUA)>0) {
                $str_query .= ",SECLINGUA=".$SECLINGUA;
            }else{
                $str_query .= ",SECLINGUA=null";
            }        
            if (intval($TERLINGUA)>0) {
                $str_query .= ",TERLINGUA=".$TERLINGUA;
            }else{
                $str_query .= ",TERLINGUA=null";
            }        
            if (intval($QUALINGUA)>0) {
                $str_query .= ",QUALINGUA=".$QUALINGUA;
            }else{
                $str_query .= ",QUALINGUA=null";
            }        
            $str_query .= " where MATRICOL=".$id;        
        }else{
            $str_query = "insert into statodocumenti( 
                            MATRICOL,CERTNASC,FOTOGRAF,LATINO,GRECO,ITASTRANIERI,
                            NOTA,permessosogg,esame_ital,celebret"; 
            if (intval($DATAAGGIORN)>0) {
                $str_query .= ",DATAAGGIORN";
            }                                
            if (intval($PRIVACY)>0) {
                $str_query .= ",PRIVACY";
            }                                
            if (intval($datascad_permessosogg)>0) {
                $str_query .= ",datascad_permessosogg";
            }                                
            if (intval($datascad_extracollegio)>0) {
                $str_query .= ",datascad_extracollegio";
            }                                
            if (intval($PRIMALINGUA)>0) {
                $str_query .= ",PRIMALINGUA";
            }                                
            if (intval($SECLINGUA)>0) {
                $str_query .= ",SECLINGUA";
            }                                
            if (intval($TERLINGUA)>0) {
                $str_query .= ",TERLINGUA";
            }                                
            if (intval($QUALINGUA)>0) {
                $str_query .= ",QUALINGUA";
            }                                
            $str_query .= ")
                            values(
                            '".str_replace("'","''",$MATRICOL)."',
                            '".str_replace("'","''",$CERTNASC)."',
                            '".str_replace("'","''",$FOTOGRAF)."',
                            '".str_replace("'","''",$LATINO)."',
                            '".str_replace("'","''",$GRECO)."',
                            '".str_replace("'","''",$ITASTRANIERI)."',
                            '".str_replace("'","''",$NOTA)."',
                            '".str_replace("'","''",$permessosogg)."',
                            '".str_replace("'","''",$esame_ital)."',
                            '".str_replace("'","''",$celebret)."'";
            if (intval($DATAAGGIORN)>0) {
                $str_query .= ",'".$DATAAGGIORN."'";
            }                                
            if (intval($PRIVACY)>0) {
                $str_query .= ",'".$PRIVACY."'";
            }                                
            if (intval($datascad_permessosogg)>0) {
                $str_query .= ",'".$datascad_permessosogg."'";
            }                                
            if (intval($datascad_extracollegio)>0) {
                $str_query .= ",'".$datascad_extracollegio."'";
            }                                
            if (intval($PRIMALINGUA)>0) {
                $str_query .= ",".$PRIMALINGUA;
            }
            if (intval($SECLINGUA)>0) {
                $str_query .= ",".$SECLINGUA;
            }
            if (intval($TERLINGUA)>0) {
                $str_query .= ",".$TERLINGUA;
            }
            if (intval($QUALINGUA)>0) {
                $str_query .= ",".$QUALINGUA;
            }
            $str_query .= ")";
        }
        $this->db->query($str_query); 
        return;        
    }    

    public function SalvaModificaCorsoStudente($id,$post){
	$sigla = $post['sigla'];
	$VOTOESAME = $post['VOTOESAME'];
        
        $str_query = "update esamistudente set ";
        $str_query .= "VOTOESAME = ".$VOTOESAME;
        $str_query .= " where MATRICOLA=".$id;        
        $str_query .= " AND sigla='".$post['sigla']."'";        
        $this->db->query($str_query); 
        return;        
    }   
 
    public function SalvaNuovoCorsoStudente($post){
	$sigla = $post['sigla'];
	$VOTOESAME = $post['VOTOESAME'];
        $id=$post['MATRICOL'];
        $str_query = "INSERT INTO esamistudente(MATRICOLA,UNIVERSITA,FACOLTA,CORSODILAUREA,
                        ANNOACCADEMICO,CORSO,PROGRESSIVO,ANNODICORSO,VOTOESAME)
                        SELECT pss.MATRICOL,pss.UNIVERSI,pss.FACOLTA,pss.CORSOLAU,
                        c.annoinizio,pss.CORSI,0,ANNOCORS,"
                        .$VOTOESAME
                        ." FROM pianistudiostudente pss
                        INNER JOIN corsi c ON c.CORSI=pss.CORSI
                        WHERE pss.MATRICOL=".$id." AND c.sigla='".$sigla."'";
        $this->db->query($str_query); 
        return;        
    }       
    public function SalvaModificaStudentePreiscrizioneCorsoLaurea($id){
        $str_query = "UPDATE studente_preiscrizione SET
                        PAGAMENTOMOD=NULL,
                        PAGAMENTODATA=NULL,
                        CORSOLAUREA=NULL,
                        INDIRIZZOLAUREA=NULL,
                        ISTITUTO_PROVENIENZA=NULL,
                        ISTITUTO_PROVENIENZA_ALTRO=NULL,
                        CICLO_ALTRA_UNIV=NULL,
                        CRUIPRO=NULL,
                        Accordo_mobil=NULL,
                        AccordoPrivacy=NULL,
                        AUT_UNIV=NULL,
                        CERT_ISCR_ALTRA_UNIV=NULL,
                        TESI_LICENZA=NULL,
                        DICHIARAZIONE_PERMANENZA_ROMA=NULL,
                        TAB=3
                        WHERE ID=".$id;        
        $this->db->query($str_query); 
        $_SESSION['tab_attivo_studente'] = 'tab3';
        return;        
    }
    public function SalvaModificaInvioEmailSegreteriaRichiestaCertificatoPreiscrizione($id){
        $str_query = "UPDATE studente_preiscrizione SET
                        EMAIL_CERTIFICATO='S'
                        WHERE ID=".$id;        
        $this->db->query($str_query); 
        return;        
    }    
    public function SalvaModificaTasseStudente($id,$post){
	$CODICETASSAPAGATA = $id;
	$ANNOACCA = $post['ANNOACCA'];
	$CORSOLAUREA = $post['CORSOLAUREA'];
	$ANNOCORSO = '0'; //$post['ANNOCORSO'];
	$CAUSALETASSE = $post['CAUSALETASSE'];
	$DATAPAGAMENTO = $post['DATAPAGAMENTO'];
	$IMPPAGATO = $post['IMPPAGATO'];
        
        $str_query = "update tassestudente set ";
        $str_query .= "ANNOACCADEMICO = ".$ANNOACCA.",";
        $str_query .= "CORSODILAUREA = ".$CORSOLAUREA.",";
        $str_query .= "ANNOCORSO = ".$ANNOCORSO.",";
        $str_query .= "DATAPAGAMENTO = '".$DATAPAGAMENTO."',";
        $str_query .= "CAUSALETASSE = '".$CAUSALETASSE."',";
        $str_query .= "IMPPAGATO = ".$IMPPAGATO;
        $str_query .= " where CODICETASSAPAGATA=".$id;        
        $this->db->query($str_query); 
        return;        
    }   

    public function SalvaNuovaTassaStudente($post){
	$MATRICOL = $post['MATRICOL'];
	$ANNOACCA = $post['ANNOACCA'];
	$CORSOLAUREA = $post['CORSOLAUREA'];
	$ANNOCORSO = '0'; //$post['ANNOCORSO'];
	$CAUSALETASSE = $post['CAUSALETASSE'];
	$DATAPAGAMENTO = $post['DATAPAGAMENTO'];
	$IMPPAGATO = $post['IMPPAGATO'];
        
        $str_query = "insert into tassestudente(UNIVERSITA,FACOLTA,DATASCADENZA,
                     MATRICOL,ANNOACCADEMICO,
                     CORSODILAUREA,ANNOCORSO,CAUSALETASSE,DATAPAGAMENTO,IMPPAGATO) 
                     values(1,1,'2019-12-31',";
        $str_query .= $MATRICOL.",";
        $str_query .= $ANNOACCA.",";
        if (intval($CORSOLAUREA)>0) {
            $str_query .= $CORSOLAUREA.',';
        }else{
            $str_query .= "null,";
        }        
        $str_query .= $ANNOCORSO.",";
        $str_query .= "'".$CAUSALETASSE."',";
        $str_query .= "'".$DATAPAGAMENTO."',";
        $str_query .= $IMPPAGATO;
        $str_query .= ")";        
        $this->db->query($str_query); 
        return;        
    }            
    public function SalvaNuovaTassaSelfStudente($post){
        $MATRICOL = $post['MATRICOL'];
	$ANNOACCADEMICO = $post['ANNOACCADEMICO'];
	$CORSODILAUREA = $post['CORSODILAUREA'];
	$ANNOCORSO = $post['ANNOCORSO'];
	//$CAUSALETASSE = $post['CAUSALETASSE'];
	$DATAPAGAMENTO = $post['DATAPAGAMENTO'];
        if ( $post['CAUSALETASSE']=='1'){
            $CAUSALETASSE='RU';
        }else{
            $CAUSALETASSE='%R';
        }
	$CODICETASSAPAGATA = $post['CODICETASSAPAGATA'];
        
        $query=$this->db->query("SELECT SCONTO,PAGANTICIPATO,PAGAMENTO,DATE_ADD(PAGAMENTO, INTERVAL 90 DAY) AS PAGAMENTO2 FROM parametri_preiscrizione");
        $row = $query->row();
        $DATASCADENZA = $row->PAGAMENTO;  
        $DATASCADENZA2 = $row->PAGAMENTO2;  
        $PAGANTICIPATO = $row->PAGANTICIPATO;  
        $SCONTO = $row->SCONTO;  
        
        $this->db->query("DELETE FROM tassestudente WHERE CODICETASSAPAGATA=".$CODICETASSAPAGATA); 
        
        $str_query = "insert into tassestudente(
                        MATRICOL,UNIVERSITA,FACOLTA,CORSODILAUREA,ANNOACCADEMICO,ANNOCORSO,
                        CAUSALETASSE,IMPPAGATO,DATASCADENZA)
                        SELECT ".$MATRICOL.",1,1,t.CORSODILAUREA,t.ANNOACCADEMICO,t.ANNODICORSO,
                                t.CAUSALETASSA,t.IMPORTOTASSA,
                                if(t.CAUSALETASSA='2R','".$DATASCADENZA2."','".$DATASCADENZA."')
                        FROM importitasse t 
                        WHERE t.ANNOACCADEMICO=".$ANNOACCADEMICO." 
                              AND t.ANNODICORSO=".$ANNOCORSO."
                              AND t.CORSODILAUREA=".$CORSODILAUREA."    
                              AND t.CAUSALETASSA LIKE '".$CAUSALETASSE."'"
                        ." ORDER BY t.CAUSALETASSA desc"; 
        $this->db->query($str_query); 

        $POSISCRIZIONE='2'; //DEVO FARE UN RAGIONAMENTO SU COSA SCEGLIERE IN BASE ALL'ANNO DI ISCRIZIONE
        $str_query = "update iscrizionistudente i SET 
                        i.POSISCRIZIONE=".$POSISCRIZIONE
                        .",i.tstatu1=".$POSISCRIZIONE
                        ." WHERE i.POSISCRIZIONE=7 AND i.MATRICOL=".$MATRICOL ;
        $this->db->query($str_query);
        
        if ($CAUSALETASSE=='RU' && $DATAPAGAMENTO<=$PAGANTICIPATO){
        $str_query = "insert into tassestudente(
                        MATRICOL,UNIVERSITA,FACOLTA,CORSODILAUREA,ANNOACCADEMICO,ANNOCORSO,
                        CAUSALETASSE,IMPPAGATO,DATASCADENZA)
                        SELECT ".$MATRICOL.",1,1,t.CORSODILAUREA,t.ANNOACCADEMICO,t.ANNODICORSO,
                                'SC',-".$SCONTO.",
                                '".$PAGANTICIPATO."'
                        FROM importitasse t 
                        WHERE t.ANNOACCADEMICO=".$ANNOACCADEMICO." 
                              AND t.ANNODICORSO=".$ANNOCORSO."
                              AND t.CORSODILAUREA=".$CORSODILAUREA."    
                              AND t.CAUSALETASSA ='RU'"; 
        $this->db->query($str_query); 
        }
        
        return;        
    }            
    
    
    public function SalvaModificaIscrizioniStudente($id,$post){
        $MATRICOL = $post['MATRICOL'];
	$ANNOACCA = $post['ANNOACCA'];
	$CORSOLAUREA = $post['CORSOLAUREA'];
	$SEMESTRECORSO = $post['SEMESTRECORSO'];
	$CORSOCONFERMA = $post['CORSOCONFERMA'];
	$SEMESTREACCA = $post['SEMESTREACCA'];
        $NOTA = str_replace("'","''",$post['NOTA']);
//	$INDIRIZZOLAUREA = $post['INDIRIZZOLAUREA'];
        
        if (intval($CORSOLAUREA)==210 && intval($post['INDIRIZZOLAUREA'])>0) {
            $INDIRIZZOLAUREA = $post['INDIRIZZOLAUREA'];
        }else{
            $INDIRIZZOLAUREA='null';
        }         
        
        
        $str_query = "update iscrizionistudente set ";
        $str_query .= "ANNOACCA = ".$ANNOACCA.",";
        $str_query .= "SEMESTREACCA = ".$SEMESTREACCA.",";
        $str_query .= "SEMESTRECORSO = ".$SEMESTRECORSO.",";
        $str_query .= "CORSOCONFERMA = ".$CORSOCONFERMA.",";
        $str_query .= "NOTA = '".$NOTA."',";
        $str_query .= "CORSOLAUREA = ".$CORSOLAUREA.",";
        $str_query .= "INDIRIZZOLAUREA = ".$INDIRIZZOLAUREA;
        $str_query .= " where id_iscrizione=".$id;        
        $this->db->query($str_query); 
        return;        
    }   

    public function SalvaNuovaIscrizioniSemestre($post){
        $id_iscrizione=$post['id_iscrizione'];
	$CORSOLAUREA = $post['CORSOLAUREA'];
        if ($CORSOLAUREA!='210'){
            $INDIRIZZOLAUREA = 'null';
        }elseif ($post['INDIRIZZOLAUREA']==''){
            $INDIRIZZOLAUREA = 'null';
        }else{
            $INDIRIZZOLAUREA = $post['INDIRIZZOLAUREA'];
        }
        $ANNOACCA = $post['ANNOACCA'];
        $SEMESTREACCA = $post['SEMESTREACCA'];
        $SEMESTRECORSO = $post['SEMESTRECORSO'];
	$CORSOCONFERMA = $post['CORSOCONFERMA'];
        $NOTA = str_replace("'","''",$post['NOTA']);
        $n_record=$post['n_record'];

        $str_query = "insert into iscrizionistudente(MATRICOL,ANNOACCA,CORSOLAUREA,indirizzolaurea,SEMESTREACCA,SEMESTRECORSO,CORSOCONFERMA,NOTA)
                        SELECT MATRICOL,".$ANNOACCA.",CORSOLAUREA,".$INDIRIZZOLAUREA.",".$SEMESTREACCA.","
                        .$SEMESTRECORSO.",".$CORSOCONFERMA.",'".$NOTA."'
                        FROM iscrizionistudente
                        WHERE id_iscrizione=".$id_iscrizione;
        $this->db->query($str_query);
/*        
        if ($n_record=='1'){
            $query=$this->db->query("SELECT * FROM scadenze WHERE ANNOACCADEMICO=".$ANNOACCA);
            $row = $query->row();
            $SCONTO='50';
            $DATAPAGAMENTO=date('d/m/Y H:i:s', TIME());
            if ($SEMESTREACCA=='1'){
                $DATASCADENZA = $row->FINEISCRIZIONI_SEM1;  
                $DATASCONTO = $row->SCONTOISCRIZIONE_SEM1;
            }else{
                $DATASCADENZA = $row->FINEISCRIZIONI_SEM2;  
                $DATASCONTO = $row->SCONTOISCRIZIONE_SEM2;  
            }
            
            if (intval($CORSOLAUREA)<888){
                if ($SEMESTRECORSO=='1' || $SEMESTRECORSO=='2'){
                    $ANNOCORSO='1';
                    $CAUSALETASSA='RU';
                    $str_where="t.ANNODICORSO=1 AND t.CAUSALETASSA='RU'";
                }elseif ($SEMESTRECORSO=='3' || $SEMESTRECORSO=='4'){
                    $ANNOCORSO='1';
                    $CAUSALETASSA='RU';
                    $str_where="t.ANNODICORSO=2 AND t.CAUSALETASSA='RU'";
                }elseif ($SEMESTRECORSO>'4'){
                    $ANNOCORSO='99';
                    $CAUSALETASSA='F';
                    $str_where="t.CAUSALETASSA='".$SEMESTREACCA."F'";
                }
            }
            
            $str_query = "insert into tassestudente(
                            MATRICOL,UNIVERSITA,FACOLTA,CORSODILAUREA,ANNOACCADEMICO,ANNOCORSO,
                            CAUSALETASSE,IMPPAGATO,DATASCADENZA)
                            SELECT DISTINCT ".$post['MATRICOL'].",1,1,t.CORSODILAUREA,t.ANNOACCADEMICO,".$ANNOCORSO.",
                                    t.CAUSALETASSA,t.IMPORTOTASSA,'".$DATASCADENZA."'
                            FROM iscrizionistudente s
                            INNER JOIN importitasse t ON s.CORSOLAUREA=t.CORSODILAUREA 
                                                    AND s.ANNOACCA=t.ANNOACCADEMICO 
                                                    AND ".$str_where."
                            WHERE s.MATRICOL=".$post['MATRICOL'];        
            $this->db->query($str_query);             
            
            if ($CAUSALETASSE=='RU' && $DATAPAGAMENTO<=$DATASCONTO){
                $str_query = "insert into tassestudente(
                                MATRICOL,UNIVERSITA,FACOLTA,CORSODILAUREA,ANNOACCADEMICO,ANNOCORSO,
                                CAUSALETASSE,IMPPAGATO,DATASCADENZA)
                                SELECT DISTINCT ".$post['MATRICOL'].",1,1,t.CORSODILAUREA,t.ANNOACCADEMICO,".$ANNOCORSO.",
                                        t.CAUSALETASSA,t.IMPORTOTASSA,'".$DATASCADENZA."'
                                FROM iscrizionistudente s
                                INNER JOIN importitasse t ON s.CORSOLAUREA=t.CORSODILAUREA 
                                                        AND s.ANNOACCA=t.ANNOACCADEMICO 
                                                        AND t.CAUSALETASSA='SC'
                                WHERE s.MATRICOL=".$post['MATRICOL'];        
                $this->db->query($str_query);             
            }
            
        }
*/        
        if ($n_record=='1' AND $CORSOLAUREA=='210' AND (intval($SEMESTRECORSO)==1 OR intval($SEMESTRECORSO)==3)){
            $SEMESTRECORSO=strval(intval($SEMESTRECORSO)+1);
            if ($SEMESTREACCA=='2'){
                $ANNOACCA=strval(intval($ANNOACCA)+1);
                $SEMESTREACCA='1';
            }else{
                $SEMESTREACCA='2';
            }
            $str_query = "insert into iscrizionistudente(MATRICOL,ANNOACCA,CORSOLAUREA,indirizzolaurea,SEMESTREACCA,SEMESTRECORSO,CORSOCONFERMA,NOTA)
                            SELECT MATRICOL,".$ANNOACCA.",CORSOLAUREA,".$INDIRIZZOLAUREA.",".$SEMESTREACCA.","
                            .$SEMESTRECORSO.",".$CORSOCONFERMA.",'".$NOTA."'
                            FROM iscrizionistudente
                            WHERE id_iscrizione=".$id_iscrizione;
            $this->db->query($str_query);
        }
        return;        
    }                
    
    public function SalvaNuovaIscrizioniStudente($post){
	$MATRICOL = $post['MATRICOL'];
	$CORSOLAUREA = $post['CORSOLAUREA'];
	$ANNOACCA = $post['ANNOACCA'];
	$SEMESTREACCA = $post['SEMESTREACCA'];
        $NOTA = str_replace("'","''",$post['NOTA']);
	$INDIRIZZOLAUREA = $post['INDIRIZZOLAUREA'];
        
        $str_query ="SELECT i.id_iscrizione,
                            i.MATRICOL,
                            i.ANNOACCA,
                            i.CORSOLAUREA,
                            i.SEMESTRECORSO,
                            i.SEMESTREACCA,                           
                            e.NESAMI
                      FROM iscrizionistudente i
                      LEFT JOIN (
                      SELECT
                         COUNT(c.CORSI) AS NESAMI,
                         c.SEMESTRE, 
                         e.MATRICOLA,
                         e.ANNOACCADEMICO
                      FROM esamistudente e 
                      INNER JOIN corsi c ON c.CORSI=e.CORSO
                      WHERE c.TIPOMEDIA='C' AND e.MATRICOLA=".$MATRICOL."
                      GROUP BY 
                         c.SEMESTRE, 
                         e.MATRICOLA,
                         e.ANNOACCADEMICO) e ON e.MATRICOLA=i.MATRICOL AND e.ANNOACCADEMICO=i.ANNOACCA AND e.semestre=i.SEMESTREACCA
                      LEFT JOIN esamidilaurea el ON  el.MATRICOL=i.MATRICOL AND el.CORSOLAU=i.CORSOLAUREA
                      WHERE i.deleted=0 AND i.CORSOLAUREA=".$CORSOLAUREA." AND i.MATRICOL=".$MATRICOL."
                      ORDER BY i.ANNOACCA desc, i.SEMESTREACCA desc
                      LIMIT 1";
        $query=$this->db->query($str_query);
        $row = $query->row_array(); 
        
        $str_query = "insert ignore into iscrizionistudente(
                     MATRICOL,CORSOLAUREA,INDIRIZZOLAUREA,NOTA,ANNOACCA,SEMESTREACCA,SEMESTRECORSO) 
                     values(";
        $str_query .= $MATRICOL.",";
        $str_query .= $CORSOLAUREA.",";
        if (intval($INDIRIZZOLAUREA)>0 AND $CORSOLAUREA=='210') {
            $str_query .= $INDIRIZZOLAUREA.",";
        }else{
            $str_query .= "null,";
        }        
        $str_query .= "'".$NOTA."',";        
        
        switch($CORSOLAUREA){
            case '210': //LICENZA
                $ANNOACCA1 = $ANNOACCA;
                $SEMESTREACCA1 = $SEMESTREACCA;
                if (count($row)==0){
                    $SEMESTRECORSO1 = '1';
                    $SEMESTRECORSO2 = '2';
                }else{
                    $SEMESTRECORSO1 = strval(intval($row['SEMESTRECORSO']) + 1 );
                    $SEMESTRECORSO2 = strval(intval($row['SEMESTRECORSO']) + 2 );
                }
                if ($SEMESTREACCA=='1'){
                    $ANNOACCA2 = $post['ANNOACCA'];
                    $SEMESTREACCA2 = '2';
                }else{
                    $ANNOACCA2=strval(intval($ANNOACCA) + 1 );
                    $SEMESTREACCA2 = '1';
                }
                $str_query1 = $str_query.$ANNOACCA1.",";
                $str_query1 .= $SEMESTREACCA1.",";
                $str_query1 .= $SEMESTRECORSO1.")";
                $this->db->query($str_query1); 
                $str_query2 = $str_query.$ANNOACCA2.",";
                $str_query2 .= $SEMESTREACCA2.",";
                $str_query2 .= $SEMESTRECORSO2.")";
                $this->db->query($str_query2); 
                break;
            case '230': //DOTTORATO
                $ANNOACCA1 = $ANNOACCA;
                $SEMESTREACCA1 = $SEMESTREACCA;
                if (count($row)==0){
                    $SEMESTRECORSO1 = '1';
                    $SEMESTRECORSO2 = '2';
                    $SEMESTRECORSO3 = '3';
                    $SEMESTRECORSO4 = '4';
                }else{
                    $SEMESTRECORSO1 = strval(intval($row['SEMESTRECORSO']) + 1 );
                    $SEMESTRECORSO2 = strval(intval($row['SEMESTRECORSO']) + 2 );
                    $SEMESTRECORSO3 = strval(intval($row['SEMESTRECORSO']) + 3 );
                    $SEMESTRECORSO4 = strval(intval($row['SEMESTRECORSO']) + 4 );
                }
                if ($SEMESTREACCA=='1'){
                    $ANNOACCA2 = $ANNOACCA1;
                    $SEMESTREACCA2 = '2';
                    $ANNOACCA3 = strval(intval($ANNOACCA1) + 1 );
                    $SEMESTREACCA3 = '1';
                    $ANNOACCA4 = $ANNOACCA3;
                    $SEMESTREACCA4 = '2';
                }else{
                    $ANNOACCA2=strval(intval($ANNOACCA1) + 1 );
                    $SEMESTREACCA2 = '1';
                    $ANNOACCA3=$ANNOACCA2;
                    $SEMESTREACCA3 = '2';
                    $ANNOACCA4=strval(intval($ANNOACCA2) + 1 );
                    $SEMESTREACCA4 = '1';
                }
                $str_query1 = $str_query.$ANNOACCA1.",";
                $str_query1 .= $SEMESTREACCA1.",";
                $str_query1 .= $SEMESTRECORSO1.")";
                $this->db->query($str_query1); 
                $str_query2 = $str_query.$ANNOACCA2.",";
                $str_query2 .= $SEMESTREACCA2.",";
                $str_query2 .= $SEMESTRECORSO2.")";
                $this->db->query($str_query2); 
                $str_query3 = $str_query.$ANNOACCA3.",";
                $str_query3 .= $SEMESTREACCA3.",";
                $str_query3 .= $SEMESTRECORSO3.")";
                $this->db->query($str_query3); 
                $str_query4 = $str_query.$ANNOACCA4.",";
                $str_query4 .= $SEMESTREACCA4.",";
                $str_query4 .= $SEMESTRECORSO4.")";
                $this->db->query($str_query4); 
                break;
            case '888': //STRAORDINARIO
            case '999': //OSPITE
                $ANNOACCA = $ANNOACCA;
                $SEMESTREACCA = $SEMESTREACCA;
                $str_query1 = $str_query.$ANNOACCA.",";
                $str_query1 .= $SEMESTREACCA.",";
                $str_query1 .= "null)";
                $this->db->query($str_query1); 
                break;
        }
        return;
    }            

    public function SalvaNuovaTassaSelfStudenteAutomatica($post){
        $query=$this->db->query("SELECT PAGAMENTO,DATE_ADD(PAGAMENTO, INTERVAL 90 DAY) AS PAGAMENTO2 FROM parametri_preiscrizione");
        $row = $query->row();
        $DATASCADENZA = $row->PAGAMENTO;  

        $str_query = "insert into tassestudente(
                        MATRICOL,UNIVERSITA,FACOLTA,CORSODILAUREA,ANNOACCADEMICO,ANNOCORSO,
                        CAUSALETASSE,IMPPAGATO,DATASCADENZA)
                        SELECT ".$post['MATRICOL'].",1,1,t.CORSODILAUREA,t.ANNOACCADEMICO,t.ANNODICORSO,
                                t.CAUSALETASSA,t.IMPORTOTASSA,'".$DATASCADENZA."'
                        FROM iscrizionistudente s
                        INNER JOIN importitasse t ON s.CORSOLAUREA=t.CORSODILAUREA 
                                                AND s.ANNOACCA=t.ANNOACCADEMICO 
                                                AND s.ANNOCORSO=t.ANNODICORSO
                                                AND t.CAUSALETASSA='RU'
                        WHERE s.MATRICOL=".$post['MATRICOL'];        
        $this->db->query($str_query); 
        return;
    }    
    public function SalvaModificaTitoliStudente($id,$post){
	$MATRICOL = $id;
	$ANNOACCA = $post['ANNOACCA'];
	$TIPTITST = $post['TIPTITST'];
	$VOTAZIONE = $post['VOTAZIONE'];
	$QUALIFICA = $post['QUALIFICA'];
	$ISTISUPE = $post['ISTISUPE'];
	$TIPDOCAL = $post['TIPDOCAL'];
	$DATA_SANATIO = $post['DATA_SANATIO'];
	$NOTA = $post['NOTA'];

        $str_query = "update titolistudente set ";
        $str_query .= "MATRICOL = ".$MATRICOL.",";
        $str_query .= "ANNOACCA = ".$ANNOACCA.",";
        $str_query .= "TIPTITST = '".$TIPTITST."',";
        $str_query .= "VOTAZIONE = '".$VOTAZIONE."',";
        $str_query .= "QUALIFICA = '".$QUALIFICA."',";
        $str_query .= "ISTISUPE = ".$ISTISUPE.",";
        $str_query .= "TIPDOCAL = ".$TIPDOCAL.",";
        $str_query .= "DATA_SANATIO = '".$DATA_SANATIO."',";
        $str_query .= "NOTA = '".$NOTA."'";
        $str_query .= " where MATRICOL=".$id." and TIPTITST=".$TIPTITST;        
        $this->db->query($str_query); 
        return;        
    }                
    
        public function SalvaNuovoTitoloStudente($post){
	$MATRICOL = $post['MATRICOL'];
	$ANNOACCA = $post['ANNOACCA'];
	$TIPTITST = $post['TIPTITST'];
	$VOTAZIONE = $post['VOTAZIONE'];
	$QUALIFICA = $post['QUALIFICA'];
	$ISTISUPE = $post['ISTISUPE'];
	$TIPDOCAL = $post['TIPDOCAL'];
	$DATA_SANATIO = $post['DATA_SANATIO'];
	$NOTA = $post['NOTA'];
        
        $str_query = "insert into titolistudente(
                     MATRICOL,ANNOACCA,TIPTITST,VOTAZIONE,QUALIFICA,ISTISUPE,TIPDOCAL,DATA_SANATIO,NOTA) 
                     values(";
        $str_query .= $MATRICOL.",";
        $str_query .= $ANNOACCA.",";
        $str_query .= $TIPTITST.",";
        if (intval($VOTAZIONE)>0) {
            $str_query .= str_replace(",",".",$VOTAZIONE).',';
        }else{
            $str_query .= "null,";
        } 
        $str_query .= "'".str_replace("'","''",$QUALIFICA)."',";
        if (intval(ISTISUPE)>0) {
            $str_query .= ISTISUPE.',';
        }else{
            $str_query .= "null,";
        }        
        if (intval($TIPDOCAL)>0) {
            $str_query .= $TIPDOCAL.',';
        }else{
            $str_query .= "null,";
        }        
        if (intval($DATA_SANATIO)>0) {
            $str_query .= "'".$DATA_SANATIO."',";
        }else{
            $str_query .= "null,";
        }        
        $str_query .= "'".str_replace("'","''",$NOTA)."'";
        $str_query .= ")";        
        $this->db->query($str_query); 
        return;        
    }            
    
    public function SalvaModificaProfessore($id,$post){
	$MATRICOL = $post['MATRICOL'];
	$COGNOME = $post['COGNOME'];
	$NOME = $post['NOME'];
	$NASCDATA = $post['NASCDATA'];
	$NASCCOMUNE = $post['NASCCOMUNE'];
	$NASCPROV = $post['ID_provincia'];
	$NASCNAZI = $post['ID_nazione'];
	$RESINDS = $post['RESINDS'];
	$RESCOMUNE = $post['RESCOMUNE'];
	$RESPROV = $post['ID_provinciaresidenza'];
	$RESNAZI = $post['ID_nazioneresidenza'];
	$RESCAP = $post['RESCAP'];
	$TELEFONO1 = $post['TELEFONO1'];
	$TELEFONO2 = $post['TELEFONO2'];
	$TELEFONO3 = $post['TELEFONO3'];
	$EMAIL = $post['EMAIL'];
	$RECPRES = $post['RECPRES'];
	$RECINDS = $post['RECINDS'];
	$RECCOMUNE = $post['RECCOMUNE'];
	$RECPROV = $post['ID_provinciarecapito'];
	$RECNAZI = $post['ID_nazionerecapito'];
	$RECCAP = $post['RECCAP'];
	$RECTELE = $post['RECTELE'];
	$CITTADI1 = $post['CITTADINANZA_NASCITA'];
	$CITTADI2 = $post['ID_cittadinanza'];
	$SESSO = $post['SESSO'];
	$STATOCIV = $post['STATOCIV'];
	$CODFISCA = $post['CODFISCA'];
	$ORDIPROF = $post['ID_ordine'];
	$DIOCESI = $post['ID_diocesi'];
	$NOTA = $post['NOTA_ANAGRAFICA'];
        
        $str_query = "update professore set ";
        $str_query .= "MATRICOL = '".str_replace("'","''",$MATRICOL)."'";
        $str_query .= ",COGNOME = '".str_replace("'","''",$COGNOME)."'";
        $str_query .= ",NOME = '".str_replace("'","''",$NOME)."'";
        $str_query .= ",NASCDATA = '".str_replace("'","''",$NASCDATA)."'";
        $str_query .= ",NASCCOMUNE = '".str_replace("'","''",$NASCCOMUNE)."'";
        if (intval($NASCPROV)>0) {
            $str_query .= ",NASCPROV=".$NASCPROV;
        }else{
            $str_query .= ",NASCPROV=null";
        }
        if (intval($NASCNAZI)>0) {
            $str_query .= ",NASCNAZI=".$NASCNAZI;
        }else{
            $str_query .= ",NASCNAZI=null";
        }
        $str_query .= ",RESINDS = '".str_replace("'","''",$RESINDS)."'";
        $str_query .= ",RESCOMUNE = '".str_replace("'","''",$RESCOMUNE)."'";
        if (intval($RESPROV)>0) {
            $str_query .= ",RESPROV=".$RESPROV;
        }else{
            $str_query .= ",RESPROV=null";
        }
        if (intval($RESNAZI)>0) {
            $str_query .= ",RESNAZI=".$RESNAZI;
        }else{
            $str_query .= ",RESNAZI=null";
        }        
        $str_query .= ",RESCAP = '".str_replace("'","''",$RESCAP)."'";
        $str_query .= ",TELEFONO1 = '".str_replace("'","''",$TELEFONO1)."'";
        $str_query .= ",TELEFONO2 = '".str_replace("'","''",$TELEFONO2)."'";
        $str_query .= ",TELEFONO3 = '".str_replace("'","''",$TELEFONO3)."'";
        $str_query .= ",EMAIL = '".str_replace("'","''",$EMAIL)."'";
        $str_query .= ",RECPRES = '".str_replace("'","''",$RECPRES)."'";
        $str_query .= ",RECINDS = '".str_replace("'","''",$RECINDS)."'";
        $str_query .= ",RECCOMUNE = '".str_replace("'","''",$RECCOMUNE)."'";
        if (intval($RECPROV)>0) {
            $str_query .= ",RECPROV=".$RECPROV;
        }else{
            $str_query .= ",RECPROV=null";
        }
        if (intval($RESNAZI)>0) {
            $str_query .= ",RECNAZI=".$RECNAZI;
        }else{
            $str_query .= ",RECNAZI=null";
        }                
        $str_query .= ",RECCAP = '".str_replace("'","''",$RECCAP)."'";
        if (intval($CITTADI1)>0) {
            $str_query .= ",CITTADI1=".$CITTADI1;
        }else{
            $str_query .= ",CITTADI1=null";
        }        
        if (intval($CITTADI2)>0) {
            $str_query .= ",CITTADI2=".$CITTADI2;
        }else{
            $str_query .= ",CITTADI2=null";
        }        
        $str_query .= ",SESSO = '".str_replace("'","''",$SESSO)."'";
        if (intval($STATOCIV)>0) {
            $str_query .= ",STATOCIV=".$STATOCIV;
        }else{
            $str_query .= ",STATOCIV=null";
        }        
        $str_query .= ",CODFISCA = '".str_replace("'","''",$CODFISCA)."'";
        if (intval($ORDIPROF)>0) {
            $str_query .= ",ORDIPROF=".$ORDIPROF;
        }else{
            $str_query .= ",ORDIPROF=null";
        }        
        if (intval($DIOCESI)>0) {
            $str_query .= ",DIOCESI=".$DIOCESI;
        }else{
            $str_query .= ",DIOCESI=null";
        }        

        $str_query .= " where MATRICOL=".$id;        
        $this->db->query($str_query); 
        return;        
    }

    public function SalvaNuovoProfessore($post){
	$MATRICOL = $post['MATRICOL'];
	$COGNOME = $post['COGNOME'];
	$NOME = $post['NOME'];
        $SESSO=$post['SESSO'];
        $str_query = "insert into professore( 
                        MATRICOL,COGNOME,NOME,SESSO)
                        values(
                        '".str_replace("'","''",$MATRICOL)."',
                        '".str_replace("'","''",$COGNOME)."',
                        '".str_replace("'","''",$NOME)."',
                        '".$SESSO."'
                        )";
        $this->db->query($str_query); 
        return;                
    }
    
    public function EliminaUsers($id){
        $str_query = "delete from studente_preiscrizione where ID=".$id;
        $this->db->query($str_query); 
        $str_query = "delete from titolistudente_preiscrizione where ID=".$id;
        $this->db->query($str_query); 
        $str_query = "delete from users where id=".$id;
        $this->db->query($str_query); 
        $str_query = "delete from users_groups where user_id=".$id;
        $this->db->query($str_query); 
        return;        
    }       

    public function EliminaStudente($id){
        $str_query = "update studente set deleted=1 where MATRICOL=".$id;
        $this->db->query($str_query); 
        return;        
    }       

    public function EliminaTassaStudente($id,$post){
        $str_query = "update tassestudente set deleted=1 where CODICETASSAPAGATA=".$post['CODICETASSAPAGATA'];
        $this->db->query($str_query); 
        return;        
    }         

    public function EliminaCorsoStudente($id,$post){
        $str_query = "update pianistudiostudente set deleted=1 where CODICETASSAPAGATA=".$post['CODICETASSAPAGATA'];
        $this->db->query($str_query); 
        return;        
    }        
    
    public function EliminaIscrizioniStudente($id,$post){
//        $str_query = "update iscrizionistudente set deleted=1 where MATRICOL=".$id." and ANNOACCA=".$post['ANNOACCA'];
        $str_query = "delete from iscrizionistudente where id_iscrizione=".$post['id_iscrizione'];
        $this->db->query($str_query); 
        return;        
    }         

    public function EliminaTitoloStudente($id,$post){
        $str_query = "update titolistudente set deleted=1 where MATRICOL=".$id." and TIPTITST=".$post['TIPTITST'];
        $this->db->query($str_query); 
        return;        
    }       

    public function EliminaTitoloStudentePreiscrizione($id,$post){
        $str_query = "update titolistudente_preiscrizione set deleted=1 where ID=". $id." and TIPTITST=".$post['TIPTITST'];
        $this->db->query($str_query); 
        return;        
    }       
    
    public function EliminaProfessore($id){
        $str_query = "update professore set deleted=1 where MATRICOL=".$id;
        $this->db->query($str_query); 
        return;        
    }       

    public function tab_continenti(){
        $str_query="SELECT * 
                    from area_cittadinanza 
                    ORDER BY descrizione";
        $query=$this->db->query($str_query);
        $result = $query->result_array(); 
        return $result;          
    }      
    
    public function tab_test(){
        $str_query="SELECT c.CORSI,c.DESCRIZIONECORSI, ps.MATRICOL FROM corsi c
                    LEFT JOIN pianistudiostudente ps ON c.CORSI=ps.CORSI AND ps.MATRICOL=1234567
                    WHERE c.annoinizio=2016
                    ORDER BY c.DESCRIZIONECORSI";
        $query=$this->db->query($str_query);
        $result = $query->result_array(); 
        return $result;          
        
    }
            
    public function filtro_ricerca_conta($qry){
        $str_query="SELECT count(*) as nrec,MATRICOL from (".$qry.") x"; 
        $query=$this->db->query($str_query);
        $result = $query->row_array(); 
        return $result;   
    }
    
    public function listacorsi($sigla = NULL){
        if ($sigla===NULL) $sigla='%';
        $str_query="SELECT CORSI,replace(DESCRIZIONECORSI,CHAR(34),'') AS DESCRIZIONECORSI,sigla,tipocorso,COGNOME FROM (
                    SELECT c.CORSI,c.DESCRIZIONECORSI,c.sigla,pm.MATRICOL,p.COGNOME,
                    CASE
                            WHEN sigla LIKE 'M6%' THEN 'Metodologia'
                            WHEN sigla LIKE 'M11%' or sigla LIKE 'M15%'THEN 'Antico Testamento'
                            WHEN sigla LIKE 'M16%' or sigla LIKE 'M17%'THEN 'Nuovo Testamento'
                            WHEN sigla LIKE 'M22%' or sigla LIKE 'M23%'THEN 'Patristica'
                            WHEN sigla LIKE 'M25%' or sigla LIKE 'M27%'THEN 'Storia'
                            WHEN sigla LIKE 'M3%' THEN 'Sistematica fondamentale'
                            WHEN sigla LIKE 'M4%' THEN 'Sistematica speciale'
                            WHEN sigla LIKE 'M50%' or sigla LIKE 'M51%' or sigla LIKE 'M52%' or sigla LIKE 'M53%' or sigla LIKE 'M54%' or sigla LIKE 'M55%' or sigla LIKE 'M56%' THEN 'Antropologia sistematica'
                            WHEN sigla LIKE 'M56%' or sigla LIKE 'M57%' THEN 'Antropologia empirica'
                            ELSE 'Libera scelta'
                    END AS tipocorso
                    FROM corsi c
                    LEFT JOIN professore_materia pm ON pm.CORSI=c.CORSI 
                    LEFT JOIN professore p ON p.MATRICOL=pm.MATRICOL
                    WHERE c.annoinizio=2018
                    ) corsi 
                    WHERE tipocorso Like '".$sigla."'
                    ORDER BY DESCRIZIONECORSI";
        $query=$this->db->query($str_query);
        $result = $query->result_array(); 
        return $result;          
    }    
 
    public function verifica_pianostudi_studente($id,$corsolaurea,$sigla){
        $str_query="SELECT ps.*  
                    FROM pianistudiostudente ps
                    INNER JOIN corsi c ON c.CORSI=ps.CORSI
                    WHERE ps.MATRICOL=".$id
                    ." AND c.sigla='".$sigla."'";
        $query=$this->db->query($str_query);
        $result = $query->row_array(); 
        return $result;          
    }

    public function tab_pianistudiostudente($id,$corsolaurea){
        $str_query=@"SELECT pss.MATRICOL,pss.riga,pss.tipocorso,pst.codice_tipocorso,c.sigla,
                        c.DESCRIZIONECORSI,p.COGNOME AS professore,
                        if(isnull(e.VOTOESAME),0,1) AS voto
                    FROM pianistudiostudente pss
                    INNER JOIN corsi c ON c.CORSI=pss.CORSI
                    INNER JOIN pianostudi_tipocorso pst ON pst.tipocorso=pss.tipocorso
                    LEFT JOIN professore_materia pm ON pm.CORSI=c.CORSI 
                    LEFT JOIN professore p ON p.MATRICOL=pm.MATRICOL
                    LEFT JOIN esamistudente e ON e.MATRICOLA=pss.MATRICOL AND e.CORSODILAUREA=pss.CORSOLAU AND e.CORSO=pss.CORSI
                    WHERE pss.MATRICOL=".$id." AND pss.CORSOLAU=".$corsolaurea."
                    ORDER BY pss.riga";
//                    ORDER BY pss.riga pst.codice_tipocorso,c.sigla";
        $query=$this->db->query($str_query);
        $result = $query->result_array(); 
        return $result;          
    }    

    public function EliminaEsamePianoStudiStudente_old($id,$corsolaurea,$sigla){
        $str_query = "DELETE pss.* 
                      FROM pianistudiostudente pss
                      INNER JOIN corsi c ON c.CORSI=pss.CORSI
                      WHERE c.sigla='".$sigla."' AND pss.MATRICOL=".$id." AND pss.CORSOLAU=".$corsolaurea;
        $this->db->query($str_query); 
        return;        
    } 
    public function InserisciEsamePianoStudiStudente_old($id,$corsolaurea,$sigla,$tipocorso,$riga){
        $str_query = "INSERT INTO pianistudiostudente(
                        MATRICOL,UNIVERSI,FACOLTA,CORSOLAU,ANNOCORS,CORSI,CREDITI,tipocorso,riga)
                        SELECT ".$id.",UNIVERSITA,FACOLTA,".$corsolaurea.",1,CORSI,CREDITI,'".$tipocorso."',".$riga." 
                      FROM corsi 
                      WHERE sigla='".$sigla."'";
        $this->db->query($str_query); 
        return;        
    }        
    
    public function tab_pianostudi_schema(){
        $str_query=@"SELECT * FROM pianostudi_tipocorso";
        $query=$this->db->query($str_query);
        $result = $query->result_array(); 
        return $result;          
    }        
    
    public function trova_nome_studente_da_matricola($id){
        $str_query="SELECT Concat(COGNOME,' ',NOMESTUD) AS valore
                    FROM studente
                    WHERE MATRICOL=".$id;
        $query=$this->db->query($str_query);
//        $result = $query->row_array(); 
//        return $result;          
        $row = $query->row();
        return $result = $row->valore;   
        
    }   
    public function trova_email_da_id($id){
        $str_query="SELECT email AS valore
                    FROM users
                    WHERE id=".$id;
        $query=$this->db->query($str_query);
//        $result = $query->row_array(); 
//        return $result;          
        $row = $query->row();
        return $result = $row->valore;   
        
    }   
    
    public function trova_cognome_da_id($id){
        $str_query="SELECT last_name AS valore
                    FROM users
                    WHERE id=".$id;
        $query=$this->db->query($str_query);
//        $result = $query->row_array(); 
//        return $result;          
        $row = $query->row();
        return $result = $row->valore;   
        
    }       
    
    public function IsSegreteria($id){
        $str_query="SELECT group_id AS valore
                    FROM users_groups
                    WHERE group_id in(2,6) and user_id=".$id
                    ." ORDER BY group_id desc"
                    ." LIMIT 1";
        $query=$this->db->query($str_query);
        $row = $query->row();
        return $result = $row->valore;   
        
    }    
    public function IsAmministrazione($id){
        $str_query="SELECT group_id AS valore
                    FROM users_groups
                    WHERE group_id in(2,9) and user_id=".$id
                    ." ORDER BY group_id desc"
                    ." LIMIT 1";
        $query=$this->db->query($str_query);
        $row = $query->row();
        return $result = $row->valore;   
        
    }    
    public function IsPreside($id){
        $str_query="SELECT group_id AS valore
                    FROM users_groups
                    WHERE group_id in(2,10) and user_id=".$id
                    ." ORDER BY group_id desc"
                    ." LIMIT 1";
        $query=$this->db->query($str_query);
        $row = $query->row();
        return $result = $row->valore;   
        
    }    
    public function IsPreiscrizione($id){
        $str_query="SELECT group_id AS valore
                    FROM users_groups
                    WHERE group_id in(2,7) and user_id=".$id
                    ." ORDER BY group_id desc"
                    ." LIMIT 1";
        $query=$this->db->query($str_query);
        $row = $query->row();
        return $result = $row->valore;   
        
    }   
    public function IsStudente($id){
        $str_query="SELECT group_id AS valore
                    FROM users_groups
                    WHERE group_id in(2,8) and user_id=".$id
                    ." ORDER BY group_id desc"
                    ." LIMIT 1";
        $query=$this->db->query($str_query);
        $row = $query->row();
        return $result = $row->valore;   
    }  
    public function IsProfessore($id){
        $str_query="SELECT group_id AS valore
                    FROM users_groups
                    WHERE group_id in(2,3) and user_id=".$id
                    ." ORDER BY group_id desc"
                    ." LIMIT 1";
        $query=$this->db->query($str_query);
        $row = $query->row();
        return $result = $row->valore;   
    }      

    public function MatricolaUsers($id,$tabella){
        $str_query="SELECT MATRICOL AS valore
                    FROM ".$tabella." t
                    INNER JOIN users ON users.email=t.email 
                    WHERE users.id=".$id;
        $query=$this->db->query($str_query);
        $row = $query->row();
        return $result = $row->valore;   
    }  
    
    public function SalvaUploadStudentePreiscrizione($id,$campo,$valore){   
        $str_query = "update studente_preiscrizione set "
                    . $campo."='".$valore."'"
                    . " where ID=".$id;
        $this->db->query($str_query); 
        return;        
        
    } 

    public function SalvaResponsabilePresaInCarico($id,$valore){   
        $str_query = "update studente_preiscrizione set 
                     PRESAINCARICO_RESP='".str_replace("'","''",$valore)."'"
                    . " where ID=".$id;
        $this->db->query($str_query); 
        return;        
    } 
    
    public function SalvaUploadStudente($id,$campo,$valore){   
        $str_query = "update statodocumenti set "
                    . $campo."='".$valore."'"
                    . " where MATRICOL=".$id;
        $this->db->query($str_query); 
        return;        
        
    }     

    public function SalvaModificaStudentePreiscrizionePrima($id,$post){
        $TAB=$post['TAB'];
	$COGNOME = $post['COGNOME'];
	$NOMESTUD = $post['NOMESTUD'];
	$NASCDATA = $post['NASCDATA'];
	$NASCCOMUNE = $post['NASCCOMUNE'];
	$NASCPROV = $post['ID_provincia'];
        $NASCPROV_ESTERA = $post['NASCPROV_ESTERA'];
	$NASCNAZI = $post['ID_nazione'];
	$CITTADI2 = $post['ID_cittadinanza'];
	$SESSO = $post['SESSO'];
	$STATOCIV = $post['STATOCIV'];
	$email = $post['email'];
	$CERTIFICATOPREISCRIZIONE = $post['CERTIFICATOPREISCRIZIONE'];
	$TITOLOSTUDIO = $post['TITOLOSTUDIO'];
        if($TITOLOSTUDIO=='0'){
            $TITOLOSTUDIO_ALTRO = $post['TITOLOSTUDIO_ALTRO'];
        }else{
            $TITOLOSTUDIO_ALTRO = '';
        }
        $SUPERIORE = $post['SUPERIORE'];
        $SEMAIL = $post['SEMAIL'];  
        $NOTA = $post['NOTA_ANAGRAFICA'];
        $CORSOLAUREA = $post['CORSOLAUREA'];

        
        $str_query = "update studente_preiscrizione set ";
        $str_query .= "COGNOME = '".str_replace("'","''",$COGNOME)."'";
        $str_query .= ",NOMESTUD = '".str_replace("'","''",$NOMESTUD)."'";
        $str_query .= ",NASCDATA = '".str_replace("'","''",$NASCDATA)."'";
        $str_query .= ",NASCCOMUNE = '".str_replace("'","''",$NASCCOMUNE)."'";
        if (intval($NASCPROV)>0) {
            $str_query .= ",NASCPROV=".$NASCPROV;
        }else{
            $str_query .= ",NASCPROV=null";
        }
        $str_query .= ",NASCPROV_ESTERA = '".str_replace("'","''",$NASCPROV_ESTERA)."'";
        if (intval($NASCNAZI)>0) {
            $str_query .= ",NASCNAZI=".$NASCNAZI;
        }else{
            $str_query .= ",NASCNAZI=null";
        }        
        if (intval($CITTADI2)>0) {
            $str_query .= ",CITTADI2=".$CITTADI2;
        }else{
            $str_query .= ",CITTADI2=null";
        }        
        $str_query .= ",SESSO = '".str_replace("'","''",$SESSO)."'";
        if (intval($STATOCIV)>0) {
            $str_query .= ",STATOCIV=".$STATOCIV;
        }else{
            $str_query .= ",STATOCIV=null";
        }        
        $str_query .= ",SUPERIORE = '".str_replace("'","''",$SUPERIORE)."'";
        $str_query .= ",SEMAIL = '".str_replace("'","''",$SEMAIL)."'";               
        $str_query .= ",email = '".str_replace("'","''",$email)."'";
        $str_query .= ",CORSOLAUREA = ".$CORSOLAUREA;
        $str_query .= ",TITOLOSTUDIO = ".$TITOLOSTUDIO;
        $str_query .= ",TITOLOSTUDIO_ALTRO = '".str_replace("'","''",$TITOLOSTUDIO_ALTRO)."'";
        $str_query .= ",NOTA = '".str_replace("'","''",$NOTA)."'";
        $str_query .= ",CERTIFICATOPREISCRIZIONE = '".$CERTIFICATOPREISCRIZIONE."'";
        
        if ($CERTIFICATOPREISCRIZIONE=='S' && $TAB=='6'){ 
            $PRESAINCARICO_RESP = $post['PRESAINCARICO_RESP'];
            $str_query .= ",PRESAINCARICO_RESP = '".str_replace("'","''",$PRESAINCARICO_RESP)."'";
            if($post['COLLEGIO']=='0'){
                $COLLEGIO = $post['COLLEGIO'];
                $RECPRES = $post['RECPRES'];
                $RECINDS = $post['RECINDS'];
                $RECCOMUNE = $post['RECCOMUNE'];
                $RECCAP = $post['RECCAP'];
                $RECTELE = $post['RECTELE'];
            }else{
                $COLLEGIO = $post['ID_collegio'];
                $RECPRES = '';
                $RECINDS = '';
                $RECCOMUNE = '';
                $RECCAP = '';
                $RECTELE = '';
            }
            if (isset($COLLEGIO)){
                $str_query .= ",COLLEGIO = ".$COLLEGIO;
            }
            $str_query .= ",RECPRES = '".str_replace("'","''",$RECPRES)."'";
            $str_query .= ",RECINDS = '".str_replace("'","''",$RECINDS)."'";
            $str_query .= ",RECCOMUNE = '".str_replace("'","''",$RECCOMUNE)."'";
            $str_query .= ",RECCAP = '".str_replace("'","''",$RECCAP)."'";
            $str_query .= ",RECTELE = '".str_replace("'","''",$RECTELE)."'";

            $CERTNASC = $post['CERTNASC'];
            $CERTNASC_TIPO = $post['CERTNASC_TIPO'];
            if($CERTNASC_TIPO=='ALTRO'){
                $CERTNASC_TIPO_ALTRO = $post['CERTNASC_TIPO_ALTRO'];
            }else{
                $CERTNASC_TIPO_ALTRO = '';
            }
            $CERTNASC_NUMERO = $post['CERTNASC_NUMERO'];
            $CERTNASC_DATARILASCIO = $post['CERTNASC_DATARILASCIO'];
            $CERTNASC_DATASCADENZA = $post['CERTNASC_DATASCADENZA'];
            $AUTSUP = $post['AUTSUP'];
            $PRESAINCARICO = $post['PRESAINCARICO'];
            $TITOLOSTUDIO_PDF = $post['TITOLOSTUDIO_PDF'];
            $DATAAGGIORN = date("Y-m-d"); //$post['DATAAGGIORN'];

            $str_query .= ",AUTSUP = '".str_replace("'","''",$AUTSUP)."'";
            $str_query .= ",PRESAINCARICO = '".str_replace("'","''",$PRESAINCARICO)."'";
            $str_query .= ",TITOLOSTUDIO_PDF = '".str_replace("'","''",$TITOLOSTUDIO_PDF)."'";
            $str_query .= ",NOTA = '".str_replace("'","''",$NOTA)."'";
            $str_query .= ",DATAAGGIORN='".$DATAAGGIORN."'";
            $str_query .= ",CERTNASC = '".str_replace("'","''",$CERTNASC)."'";
            $str_query .= ",CERTNASC_TIPO = '".str_replace("'","''",$CERTNASC_TIPO)."'";
            $str_query .= ",CERTNASC_TIPO_ALTRO = '".str_replace("'","''",$CERTNASC_TIPO_ALTRO)."'";
            $str_query .= ",CERTNASC_NUMERO = '".str_replace("'","''",$CERTNASC_NUMERO)."'";
            if (isset($CERTNASC_DATARILASCIO)){
                $str_query .= ",CERTNASC_DATARILASCIO='".$CERTNASC_DATARILASCIO."'";
            }
            if (isset($CERTNASC_DATASCADENZA)){
                $str_query .= ",CERTNASC_DATASCADENZA='".$CERTNASC_DATASCADENZA."'";
            }
        }
        switch (intval($TAB)) {
            case 1:
                if($CERTIFICATOPREISCRIZIONE=='S'){
                    $str_query .= ",TAB=6";
                    $str_query .= ",PREISCRIZIONE_TERMINATA=0";
                    $_SESSION['tab_attivo_studente'] = 'tab6';                
                }else{
                    $str_query .= ",TAB=1";
                    $str_query .= ",PREISCRIZIONE_TERMINATA=1";
                    $_SESSION['tab_attivo_studente'] = 'tab1';                
                }
                break;
            case 6: 
                if($CERTIFICATOPREISCRIZIONE=='S' && isset($COLLEGIO)){
                    $str_query .= ",TAB=6";
                    $str_query .= ",PREISCRIZIONE_TERMINATA=1";
                    $_SESSION['tab_attivo_studente'] = 'tab6';
                }elseif($CERTIFICATOPREISCRIZIONE=='N'){
                    $str_query .= ",TAB=1";
                    $str_query .= ",PREISCRIZIONE_TERMINATA=1";
                    $_SESSION['tab_attivo_studente'] = 'tab1';
                }else{
                    $str_query .= ",TAB=6";
                    $str_query .= ",PREISCRIZIONE_TERMINATA=0";
                    $_SESSION['tab_attivo_studente'] = 'tab6';                
                }
                break;
        }        
        $str_query .= " where ID=".$id;        
        $this->db->query($str_query); 
        return;        
    }

    public function SalvaModificaStudentePreiscrizione($id,$post){
//        return;
        $TAB = $post['TAB'];
        if($TAB>=1){ //Dati generali
            $COGNOME = $post['COGNOME'];
            $NOMESTUD = $post['NOMESTUD'];
            $NASCDATA = $post['NASCDATA'];
            $NASCCOMUNE = $post['NASCCOMUNE'];
            $NASCPROV = $post['ID_provincia'];
            $NASCPROV_ESTERA = $post['NASCPROV_ESTERA'];
            $NASCNAZI = $post['ID_nazione'];
            //$CITTADI1 = $post['CITTADINANZA_NASCITA'];
            $CITTADI2 = $post['ID_cittadinanza'];
            $cellulare = $post['cellulare'];
            $CODFISCA = $post['CODFISCA'];
            $SESSO = $post['SESSO'];
            $STATOCIV = $post['STATOCIV'];
            $ORDINE = $post['ID_ordine'];
            $DIOCESI = $post['ID_diocesi'];
            $CERTIFICATOPREISCRIZIONE = $post['CERTIFICATOPREISCRIZIONE'];
            $ISCRIZIONE_INIZIO = $post['ISCRIZIONE_INIZIO'];
            
        }
        if($TAB>=2){ //Indirizzi
//            $RESINDS = $post['RESINDS'];
//            $RESCOMUNE = $post['RESCOMUNE'];
//            $RESCAP = $post['RESCAP'];
//            $RESPROV = $post['ID_provinciaresidenza'];
//            $RESNAZI = $post['ID_nazioneresidenza'];
//            $RESTELE = $post['RESTELE'];
//            $cellulare = $post['cellulare'];
            if ($post['COLLEGIO']=='0') {
                $COLLEGIO='0';
                $RECPRES = $post['RECPRES'];
                $RECINDS = $post['RECINDS'];
                $RECCOMUNE = $post['RECCOMUNE'];
        //        $RECPROV = $post['ID_provinciarecapito'];
                $RECCAP = $post['RECCAP'];
                $RECTELE = $post['RECTELE'];
            }                
            if ($post['COLLEGIO']=='-1') {
                $COLLEGIO = $post['ID_collegio'];
                $RECPRES = '';
                $RECINDS = '';
                $RECCOMUNE = '';
        //        $RECPROV = '';
                $RECCAP = '';
                $RECTELE = '';
            }
        }
        if($TAB>=3){ //Dati iscrizione
            $CORSOLAUREA = $post['CORSOLAUREA'];
            $INDIRIZZOLAUREA = $post['INDIRIZZOLAUREA'];
            $ISTITUTO_PROVENIENZA = $post['ID_istituzioneprovenienza'];
            $ISTITUTO_PROVENIENZA_ALTRO = $post['ISTITUTO_PROVENIENZA_ALTRO'];
            $CICLO_ALTRA_UNIV = $post['CICLO_ALTRA_UNIV'];
            $TITOLOSTUDIO = $post['TITOLOSTUDIO'];
            $TITOLOSTUDIO_ALTRO = $post['TITOLOSTUDIO_ALTRO'];
            $CRUIPRO = $post['CRUIPRO'];
            $Accordo_mobil = $post['Accordo_mobil'];
            if ($ISTITUTO_PROVENIENZA_ALTRO!=''){
                $CRUIPRO = '9';
                $Accordo_mobil = '9';
            }
        }
        if($TAB>=4){
            $PAGAMENTOMOD=$post['PAGAMENTOMOD'];
            $PAGAMENTODATA=$post['PAGAMENTODATA'];
            $NOME_PAGANTE=$post['NOME_PAGANTE'];
            $EMAIL_PAGANTE=$post['EMAIL_PAGANTE'];
            $DETRAZIONE_FISCALE=$post['DETRAZIONE_FISCALE'];
        }
        
        if($TAB>=5){ //Ordinario religioso
            $SUPERIORE = $post['SUPERIORE'];
            $IND_SUP1 = $post['IND_SUP1'];
            $IND_SUP2 = $post['IND_SUP2'];
            $SUP_CITY = $post['SUP_CITY'];
            $SUP_STATE = $post['SUP_STATE'];
            $S_COUNTRY = $post['S_COUNTRY'];
            $SZIPEUR = $post['SZIPEUR'];
            $SPHONE = $post['SPHONE'];
            $SFAX = $post['SFAX'];
            $SUPMOVILE = $post['SUPMOVILE'];
            $SEMAIL = $post['SEMAIL'];          
        }
        if($TAB>=6 && $post['CERTNASC']=='S'){ //documenti requisiti 
            if(!isset($post['CERTNASC_TIPO'])) $CERTNASC_TIPO='';
            else $CERTNASC_TIPO = $post['CERTNASC_TIPO'];
            if(!isset($post['CERTNASC_TIPO_ALTRO'])) $CERTNASC_TIPO_ALTRO='';
            else $CERTNASC_TIPO_ALTRO = $post['CERTNASC_TIPO_ALTRO'];
            if(!isset($post['CERTNASC_NUMERO'])) $CERTNASC_NUMERO='';
            else $CERTNASC_NUMERO = $post['CERTNASC_NUMERO'];
            if(!isset($post['CERTNASC_DATARILASCIO'])) $CERTNASC_DATARILASCIO='';
            else $CERTNASC_DATARILASCIO = $post['CERTNASC_DATARILASCIO'];
            if(!isset($post['CERTNASC_DATASCADENZA'])) $CERTNASC_DATASCADENZA='';
            else $CERTNASC_DATASCADENZA = $post['CERTNASC_DATASCADENZA'];
            if(!isset($post['PRIMALINGUA'])) $PRIMALINGUA='0';
            else $PRIMALINGUA = $post['PRIMALINGUA'];
            if(!isset($post['SECLINGUA'])) $SECLINGUA='0';
            else $SECLINGUA = $post['SECLINGUA'];
            if(!isset($post['TERLINGUA'])) $TERLINGUA='0';
            else $TERLINGUA = $post['TERLINGUA'];
            if(!isset($post['QUALINGUA'])) $QUALINGUA='0';
            else $QUALINGUA = $post['QUALINGUA'];
            //$AUTSUP = $post['AUTSUP'];
            
            if(!isset($post['ITASTRANIERI_ESONERO'])) $ITASTRANIERI_ESONERO='';
            else $ITASTRANIERI_ESONERO = $post['ITASTRANIERI_ESONERO'];

            if(!isset($post['PRESAINCARICO_RESP'])) $PRESAINCARICO_RESP='';
            else $PRESAINCARICO_RESP = $post['PRESAINCARICO_RESP'];

            if(!isset($post['datascad_permessosogg'])) $datascad_permessosogg='';
            else $datascad_permessosogg = $post['datascad_permessosogg'];
            
            if(isset($post['esame_ital'])) $esame_ital=$post['esame_ital'];
            if(isset($post['AccordoPrivacy'])) $AccordoPrivacy=$post['AccordoPrivacy'];
            
            if ($post['CODFISCA']=="" && $post['DETRAZIONE_FISCALE']=='1'
                || ($post['STATOCIV']=="1" && $post['ID_ordine'] == "")    
                || ($post['STATOCIV']=="3" && $post['ID_ordine'] == "")    
                || ($post['STATOCIV']=="4" && $post['ID_ordine'] == "")    
                || ($post['STATOCIV']=="2" && $post['ID_diocesi'] == "")    
                || ($post['STATOCIV']>="5" && $post['ID_diocesi'] == "")    
                || ($post['STATOCIV']!="5" && $post['STATOCIV']!="6" && $post['SEMAIL']=="")    
                || $post['PRIMALINGUA']=='0'
                || ($post['CORSOLAUREA']!="999" && $post['SECLINGUA']=='0')
                || ($post['CORSOLAUREA']=="999" && $post['CRUIPRO_verifica']=='1' && $post['SECLINGUA']=='0')
                || ($post['CORSOLAUREA']<="250" && $post['TERLINGUA']=='0')
                || ($post['CITTADI2']!="1" && $post['ITASTRANIERI']!="S")
                || $post['TITOLOSTUDIO_PDF'] != "S" 
                || $post['AUTSUP'] != "S" 
                || $post['PRESAINCARICO'] != "S"
                || ($post['CORSOLAUREA']<="250" && $post['LATINO'] != "S")
                || ($post['CORSOLAUREA']<="250" && $post['GRECO'] != "S")
                || ($post['CORSOLAUREA']=="888" && $post['CRUIPRO_verifica']=='0' && $post['LATINO'] != "S")
                || ($post['CORSOLAUREA']=="888" && $post['CRUIPRO_verifica']=='0' && $post['GRECO'] != "S")
                || ($post['CITTADI2']!="1" && $post['permessosogg']!="S")
                || ($post['CORSOLAUREA']=="230" && $post['TESI_LICENZA'] != "S")
                || ($post['CORSOLAUREA']=="230" && $post['DICHIARAZIONE_PERMANENZA_ROMA'] != "S")
                || ($post['CORSOLAUREA']>"230" && $post['CRUIPRO_verifica']=='1' && $post['AUT_UNIV'] != "S")
                || ($post['CORSOLAUREA']>"230" && $post['CRUIPRO_verifica']=='1' && $post['CERT_ISCR_ALTRA_UNIV'] != "S")
                ){
                $ISCRIZIONE_TERMINATA = '0';
            }else{
                $ISCRIZIONE_TERMINATA = '1';
            }
        }
        
        $str_query = "update studente_preiscrizione set ";
        if ($COGNOME!='') $str_query .= "COGNOME = '".str_replace("'","''",$COGNOME)."'";
        if ($NOMESTUD!='') $str_query .= ",NOMESTUD = '".str_replace("'","''",$NOMESTUD)."'";
        if ($NASCDATA!='') $str_query .= ",NASCDATA = '".str_replace("'","''",$NASCDATA)."'";
        if ($NASCCOMUNE!='') $str_query .= ",NASCCOMUNE = '".str_replace("'","''",$NASCCOMUNE)."'";
        if ($NASCNAZI!='') $str_query .= ",NASCNAZI = ".$NASCNAZI;
        if ($NASCNAZI==1 && $NASCPROV>='500') $str_query .= ",NASCPROV = null";
        elseif ($NASCNAZI>1) $str_query .= ",NASCPROV = '500'";
        elseif ($NASCPROV!='') $str_query .= ",NASCPROV = ".$NASCPROV;
        if ($NASCPROV_ESTERA!='') $str_query .= ",NASCPROV_ESTERA = '".str_replace("'","''",$NASCPROV_ESTERA)."'";
//        if (intval($CITTADI1)>0) {
//            $str_query .= ",CITTADI1=".$CITTADI1;
//        }else{
//            $str_query .= ",CITTADI1=null";
//        }        
        if ($CITTADI2!='') $str_query .= ",CITTADI2 = ".$CITTADI2;
        if ($cellulare!='') $str_query .= ",cellulare = '".str_replace("'","''",$cellulare)."'";
        if ($CODFISCA!='') $str_query .= ",CODFISCA = '".str_replace("'","''",$CODFISCA)."'";
        if ($SESSO!='') $str_query .= ",SESSO = '".str_replace("'","''",$SESSO)."'";
        if ($STATOCIV!='') $str_query .= ",STATOCIV = ".$STATOCIV;
        if ($STATOCIV<=4 && $ORDINE!='') {
            $str_query .= ",ORDINE=".$ORDINE;
        }else{
            $str_query .= ",ORDINE=null";
        }
        if ($STATOCIV>=5  && $DIOCESI!='') {
            $str_query .= ",DIOCESI=".$DIOCESI;
        }else{
            $str_query .= ",DIOCESI=null";
        }
        if (isset($CERTIFICATOPREISCRIZIONE)) $str_query .= ",CERTIFICATOPREISCRIZIONE = '".$CERTIFICATOPREISCRIZIONE."'";
        $str_query .= ",ISCRIZIONE_INIZIO=".$ISCRIZIONE_INIZIO;
        if($TAB>=2){
//            if ($RESINDS!='') $str_query .= ",RESINDS = '".str_replace("'","''",$RESINDS)."'";
//            if ($RESCOMUNE!='') $str_query .= ",RESCOMUNE = '".str_replace("'","''",$RESCOMUNE)."'";
//            if ($RESCAP!='') $str_query .= ",RESCAP = '".str_replace("'","''",$RESCAP)."'";
//            if ($RESNAZI!='') $str_query .= ",RESNAZI = ".$RESNAZI;
//            if ($RESNAZI==1 && $RESPROV>='500') $str_query .= ",RESPROV = null";
//            elseif ($RESNAZI>1) $str_query .= ",RESPROV = '500'";
//            elseif ($RESPROV!='') $str_query .= ",RESPROV = ".$RESPROV;
//            if ($RESTELE!='') $str_query .= ",RESTELE = '".str_replace("'","''",$RESTELE)."'";
//            if ($cellulare!='') $str_query .= ",cellulare = '".str_replace("'","''",$cellulare)."'";
            if ($COLLEGIO!='') $str_query .= ",COLLEGIO = ".$COLLEGIO;
            if ($RECPRES!='') $str_query .= ",RECPRES = '".str_replace("'","''",$RECPRES)."'";
            if ($RECINDS!='') $str_query .= ",RECINDS = '".str_replace("'","''",$RECINDS)."'";
            if ($RECCOMUNE!='') $str_query .= ",RECCOMUNE = '".str_replace("'","''",$RECCOMUNE)."'";
            if ($RECCAP!='') $str_query .= ",RECCAP = '".str_replace("'","''",$RECCAP)."'";
            if ($RECTELE!='') $str_query .= ",RECTELE = '".str_replace("'","''",$RECTELE)."'";
        }
        if($TAB>=3){
            if ($CORSOLAUREA!='') $str_query .= ",CORSOLAUREA = ".$CORSOLAUREA;
            if ($INDIRIZZOLAUREA!='') $str_query .= ",INDIRIZZOLAUREA = ".$INDIRIZZOLAUREA;
            if ($ISTITUTO_PROVENIENZA!='') $str_query .= ",ISTITUTO_PROVENIENZA = ".$ISTITUTO_PROVENIENZA;
            if ($ISTITUTO_PROVENIENZA_ALTRO!='') $str_query .= ",ISTITUTO_PROVENIENZA_ALTRO = '".str_replace("'","''",$ISTITUTO_PROVENIENZA_ALTRO)."'";
            if ($CICLO_ALTRA_UNIV!='') $str_query .= ",CICLO_ALTRA_UNIV = '".str_replace("'","''",$CICLO_ALTRA_UNIV)."'";
            if ($TITOLOSTUDIO!='') $str_query .= ",TITOLOSTUDIO = ".$TITOLOSTUDIO;
            if ($TITOLOSTUDIO_ALTRO!='') $str_query .= ",TITOLOSTUDIO_ALTRO = '".str_replace("'","''",$TITOLOSTUDIO_ALTRO)."'";
            if ($CRUIPRO!='') $str_query .= ",CRUIPRO = ".$CRUIPRO;
            if ($Accordo_mobil!='') $str_query .= ",Accordo_mobil = ".$Accordo_mobil;
        }
        if($TAB>=4){
            if ($PAGAMENTOMOD!='') $str_query .= ",PAGAMENTOMOD = ".$PAGAMENTOMOD;
            if ($PAGAMENTODATA!='') $str_query .= ",PAGAMENTODATA = '".$PAGAMENTODATA."'";
            if ($NOME_PAGANTE!='') $str_query .= ",NOME_PAGANTE = '".str_replace("'","''",$NOME_PAGANTE)."'";
            if ($EMAIL_PAGANTE!='') $str_query .= ",EMAIL_PAGANTE = '".str_replace("'","''",$EMAIL_PAGANTE)."'";
            if ($DETRAZIONE_FISCALE!='') $str_query .= ",DETRAZIONE_FISCALE = ".$DETRAZIONE_FISCALE;
        }
        
        if($TAB>=5){
            $str_query .= ",SUPERIORE = '".str_replace("'","''",$SUPERIORE)."'";
            $str_query .= ",IND_SUP1 = '".str_replace("'","''",$IND_SUP1)."'";
            $str_query .= ",IND_SUP2 = '".str_replace("'","''",$IND_SUP2)."'";
            $str_query .= ",SUP_CITY = '".str_replace("'","''",$SUP_CITY)."'";
            $str_query .= ",SUP_STATE = '".str_replace("'","''",$SUP_STATE)."'";
            $str_query .= ",S_COUNTRY = '".str_replace("'","''",$S_COUNTRY)."'";
            $str_query .= ",SZIPEUR = '".str_replace("'","''",$SZIPEUR)."'";
            $str_query .= ",SPHONE = '".str_replace("'","''",$SPHONE)."'";
            $str_query .= ",SFAX = '".str_replace("'","''",$SFAX)."'";
            $str_query .= ",SUPMOVILE = '".str_replace("'","''",$SUPMOVILE)."'";
            $str_query .= ",SEMAIL = '".str_replace("'","''",$SEMAIL)."'";               
        }        
        if($TAB>=6 && $post['CERTNASC']=='S'){ //documenti requisiti 
            if ($CERTNASC_TIPO!='') $str_query .= ",CERTNASC_TIPO = '".str_replace("'","''",$CERTNASC_TIPO)."'";
            if ($CERTNASC_TIPO_ALTRO!='') $str_query .= ",CERTNASC_TIPO_ALTRO = '".str_replace("'","''",$CERTNASC_TIPO_ALTRO)."'";
            if ($CERTNASC_NUMERO!='') $str_query .= ",CERTNASC_NUMERO = '".str_replace("'","''",$CERTNASC_NUMERO)."'";
            if ($CERTNASC_DATARILASCIO!='') $str_query .= ",CERTNASC_DATARILASCIO='".$CERTNASC_DATARILASCIO."'";
            if ($CERTNASC_DATASCADENZA!='') $str_query .= ",CERTNASC_DATASCADENZA='".$CERTNASC_DATASCADENZA."'";
            $str_query .= ",PRIMALINGUA = '".str_replace("'","''",$PRIMALINGUA)."'";
            $str_query .= ",SECLINGUA = ".$SECLINGUA;
            $str_query .= ",TERLINGUA = ".$TERLINGUA;
            $str_query .= ",QUALINGUA = ".$QUALINGUA;
//            $str_query .= ",DATAAGGIORN='".$DATAAGGIORN."'";
            $str_query .= ",PRESAINCARICO_RESP = '".str_replace("'","''",$PRESAINCARICO_RESP)."'";
            $str_query .= ",ITASTRANIERI_ESONERO = '".str_replace("'","''",$ITASTRANIERI_ESONERO)."'";
            if ($datascad_permessosogg!='') $str_query .= ",datascad_permessosogg = '".str_replace("'","''",$datascad_permessosogg)."'";
            if(isset($esame_ital)) $str_query .= ",esame_ital = '".$esame_ital."'";
            if(isset($AccordoPrivacy)) $str_query .= ",AccordoPrivacy = '".$AccordoPrivacy."'";

            $str_query .= ",ISCRIZIONE_TERMINATA = ".$ISCRIZIONE_TERMINATA;
        }
        switch (intval($TAB)) {
            case 1: //dati_personali
                $str_query .= ",TAB = 2";
                $_SESSION['tab_attivo_studente'] = 'tab2';                
                break;
            case 2: //indirizzi
                $str_query .= ",TAB = 3";
                $_SESSION['tab_attivo_studente'] = 'tab3';                
                break;
            case 3: //tipo iscrizione
                $str_query .= ",TAB = 4";
                $_SESSION['tab_attivo_studente'] = 'tab4';  
                if ($CORSOLAUREA>800 && $post['CRUIPRO']=='1'){
                    $str_query .= ",TAB = 5";
                    $_SESSION['tab_attivo_studente'] = 'tab5';  
                }
                break;
            case 4: //tipo pagamento
                $str_query .= ",TAB = 5";
                $_SESSION['tab_attivo_studente'] = 'tab5';                
                break;
            case 5: //ordinario religioso
                $str_query .= ",TAB = 6";
                $_SESSION['tab_attivo_studente'] = 'tab6';                
                break;
        }                
        if ($TAB>=6 && $TAB!=$post['TAB_ATTIVO']){
            $_SESSION['tab_attivo_studente'] = $post['TAB_ATTIVO'];                
        }
        $str_query .= " where ID=".$id;        
        $this->db->query($str_query); 
        return;        
    }
    
    
    public function SalvaModificaStudentePreiscrizione_20210531($id,$post){
        $TAB =$post['TAB'];
	$COGNOME = $post['COGNOME'];
	$NOMESTUD = $post['NOMESTUD'];
	$NASCDATA = $post['NASCDATA'];
	$NASCCOMUNE = $post['NASCCOMUNE'];
	$NASCPROV = $post['ID_provincia'];
	$NASCNAZI = $post['ID_nazione'];
	$CITTADI1 = $post['CITTADINANZA_NASCITA'];
	$CITTADI2 = $post['ID_cittadinanza'];
	$SESSO = $post['SESSO'];
	$STATOCIV = $post['STATOCIV'];
	$CODFISCA = $post['CODFISCA'];
	$ORDINE = $post['ID_ordine'];
	$DIOCESI = $post['ID_diocesi'];
	$email = $post['email'];
	$cellulare = $post['cellulare'];
	$CERTIFICATOPREISCRIZIONE = $post['CERTIFICATOPREISCRIZIONE'];
        
        $str_query = "update studente_preiscrizione set ";
        $str_query .= "COGNOME = '".str_replace("'","''",$COGNOME)."'";
        $str_query .= ",NOMESTUD = '".str_replace("'","''",$NOMESTUD)."'";
        $str_query .= ",NASCDATA = '".str_replace("'","''",$NASCDATA)."'";
        $str_query .= ",NASCCOMUNE = '".str_replace("'","''",$NASCCOMUNE)."'";
        if (intval($NASCPROV)>0) {
            $str_query .= ",NASCPROV=".$NASCPROV;
        }else{
            $str_query .= ",NASCPROV=null";
        }
        if (intval($NASCNAZI)>0) {
            $str_query .= ",NASCNAZI=".$NASCNAZI;
        }else{
            $str_query .= ",NASCNAZI=null";
        }        
        if (intval($CITTADI1)>0) {
            $str_query .= ",CITTADI1=".$CITTADI1;
        }else{
            $str_query .= ",CITTADI1=null";
        }        
        if (intval($CITTADI2)>0) {
            $str_query .= ",CITTADI2=".$CITTADI2;
        }else{
            $str_query .= ",CITTADI2=null";
        }    
        $str_query .= ",CERTIFICATOPREISCRIZIONE = '".$CERTIFICATOPREISCRIZIONE."'";
        $str_query .= ",SESSO = '".str_replace("'","''",$SESSO)."'";
        if (intval($STATOCIV)>0) {
            $str_query .= ",STATOCIV=".$STATOCIV;
        }else{
            $str_query .= ",STATOCIV=null";
        }        
        $str_query .= ",CODFISCA = '".str_replace("'","''",$CODFISCA)."'";
        if (intval($ORDINE)>0) {
            $str_query .= ",ORDINE=".$ORDINE;
        }else{
            $str_query .= ",ORDINE=null";
        }        
        if (intval($DIOCESI)>0) {
            $str_query .= ",DIOCESI=".$DIOCESI;
        }else{
            $str_query .= ",DIOCESI=null";
        }        
        $str_query .= ",email = '".str_replace("'","''",$email)."'";
        $str_query .= ",cellulare = '".str_replace("'","''",$cellulare)."'";

        
        if (intval($TAB)>=2){ //ordinario religioso
            $SUPERIORE = $post['SUPERIORE'];
            $IND_SUP1 = $post['IND_SUP1'];
            $IND_SUP2 = $post['IND_SUP2'];
            $SUP_CITY = $post['SUP_CITY'];
            $SUP_STATE = $post['SUP_STATE'];
            $S_COUNTRY = $post['S_COUNTRY'];
            $SZIPEUR = $post['SZIPEUR'];
            $SPHONE = $post['SPHONE'];
            $SFAX = $post['SFAX'];
            $SUPMOVILE = $post['SUPMOVILE'];
            $SEMAIL = $post['SEMAIL'];          

            $str_query .= ",SUPERIORE = '".str_replace("'","''",$SUPERIORE)."'";
            $str_query .= ",IND_SUP1 = '".str_replace("'","''",$IND_SUP1)."'";
            $str_query .= ",IND_SUP2 = '".str_replace("'","''",$IND_SUP2)."'";
            $str_query .= ",SUP_CITY = '".str_replace("'","''",$SUP_CITY)."'";
            $str_query .= ",SUP_STATE = '".str_replace("'","''",$SUP_STATE)."'";
            $str_query .= ",S_COUNTRY = '".str_replace("'","''",$S_COUNTRY)."'";
            $str_query .= ",SZIPEUR = '".str_replace("'","''",$SZIPEUR)."'";
            $str_query .= ",SPHONE = '".str_replace("'","''",$SPHONE)."'";
            $str_query .= ",SFAX = '".str_replace("'","''",$SFAX)."'";
            $str_query .= ",SUPMOVILE = '".str_replace("'","''",$SUPMOVILE)."'";
            $str_query .= ",SEMAIL = '".str_replace("'","''",$SEMAIL)."'";               
        }
        if (intval($TAB)>=3){ //collegio
            $COLLEGIO = $post['ID_collegio'];
        }
        if (intval($TAB)>=4){ //indirizzi
            $RESINDS = $post['RESINDS'];
            $RESCOMUNE = $post['RESCOMUNE'];
            $RESPROV = $post['ID_provinciaresidenza'];
            $RESNAZI = $post['ID_nazioneresidenza'];
            $RESCAP = $post['RESCAP'];
            $RESTELE = $post['RESTELE'];
            $RECPRES = $post['RECPRES'];
            $RECINDS = $post['RECINDS'];
            $RECCOMUNE = $post['RECCOMUNE'];
            $RECPROV = $post['ID_provinciarecapito'];
            $RECCAP = $post['RECCAP'];
            $RECTELE = $post['RECTELE'];

            $str_query .= ",RESINDS = '".str_replace("'","''",$RESINDS)."'";
            $str_query .= ",RESCOMUNE = '".str_replace("'","''",$RESCOMUNE)."'";
            if (intval($RESPROV)>0) {
                $str_query .= ",RESPROV=".$RESPROV;
            }else{
                $str_query .= ",RESPROV=null";
            }
            if (intval($RESNAZI)>0) {
                $str_query .= ",RESNAZI=".$RESNAZI;
            }else{
                $str_query .= ",RESNAZI=null";
            }        
            $str_query .= ",RESCAP = '".str_replace("'","''",$RESCAP)."'";
            $str_query .= ",RESTELE = '".str_replace("'","''",$RESTELE)."'";
            $str_query .= ",RECPRES = '".str_replace("'","''",$RECPRES)."'";
            $str_query .= ",RECINDS = '".str_replace("'","''",$RECINDS)."'";
            $str_query .= ",RECCOMUNE = '".str_replace("'","''",$RECCOMUNE)."'";
            if (intval($RECPROV)>0) {
                $str_query .= ",RECPROV=".$RECPROV;
            }else{
                $str_query .= ",RECPROV=null";
            }
            $str_query .= ",RECCAP = '".str_replace("'","''",$RECCAP)."'";
            $str_query .= ",RECTELE = '".str_replace("'","''",$RECTELE)."'";
        }
        if (intval($TAB)>=5){ //titoli_accademici 
            $CERTNASC = $post['CERTNASC'];
            $CERTNASC_TIPO = $post['CERTNASC_TIPO'];
            if($CERTNASC_TIPO=='ALTRO'){
                $CERTNASC_TIPO_ALTRO = $post['CERTNASC_TIPO_ALTRO'];
            }else{
                $CERTNASC_TIPO_ALTRO = '';
            }
            $CERTNASC_NUMERO = $post['CERTNASC_NUMERO'];
            $CERTNASC_DATARILASCIO = $post['CERTNASC_DATARILASCIO'];
            $CERTNASC_DATASCADENZA = $post['CERTNASC_DATASCADENZA'];
//            $FOTOGRAF = $post['FOTOGRAF'];
            $LATINO = $post['LATINO'];
            $GRECO = $post['GRECO'];
            $AUTSUP = $post['AUTSUP'];
            $PRESAINCARICO = $post['PRESAINCARICO'];
            $PRESAINCARICO_RESP = $post['PRESAINCARICO_RESP'];
            $TITOLOSTUDIO_PDF = $post['TITOLOSTUDIO_PDF'];
            $ITASTRANIERI = $post['ITASTRANIERI'];
            $NOTA = $post['STATODOC_NOTA'];
            $permessosogg = $post['permessosogg'];
            $esame_ital = $post['esame_ital'];
            $celebret = $post['celebret'];       
            $DATAAGGIORN = date("Y-m-d"); //$post['DATAAGGIORN'];
            $PRIVACY = $post['PRIVACY'];
            $datascad_permessosogg = $post['datascad_permessosogg'];
            $datascad_extracollegio = $post['datascad_extracollegio'];
            $PRIMALINGUA = $post['PRIMALINGUA'];
            $SECLINGUA = $post['SECLINGUA'];
            $TERLINGUA = $post['TERLINGUA'];
            $QUALINGUA = $post['QUALINGUA'];

            $str_query .= ",CERTNASC = '".str_replace("'","''",$CERTNASC)."'";
            $str_query .= ",CERTNASC_TIPO = '".str_replace("'","''",$CERTNASC_TIPO)."'";
            $str_query .= ",CERTNASC_TIPO_ALTRO = '".str_replace("'","''",$CERTNASC_TIPO_ALTRO)."'";
            $str_query .= ",CERTNASC_NUMERO = '".str_replace("'","''",$CERTNASC_NUMERO)."'";
            if (isset($CERTNASC_DATARILASCIO)){
                $str_query .= ",CERTNASC_DATARILASCIO='".$CERTNASC_DATARILASCIO."'";
            }
            if (isset($CERTNASC_DATASCADENZA)){
                $str_query .= ",CERTNASC_DATASCADENZA='".$CERTNASC_DATASCADENZA."'";
            }
//            $str_query .= ",FOTOGRAF = '".str_replace("'","''",$FOTOGRAF)."'";
            $str_query .= ",LATINO = '".str_replace("'","''",$LATINO)."'";
            $str_query .= ",GRECO = '".str_replace("'","''",$GRECO)."'";
            $str_query .= ",AUTSUP = '".str_replace("'","''",$AUTSUP)."'";
            $str_query .= ",PRESAINCARICO = '".str_replace("'","''",$PRESAINCARICO)."'";
            $str_query .= ",PRESAINCARICO_RESP = '".str_replace("'","''",$PRESAINCARICO_RESP)."'";
            $str_query .= ",TITOLOSTUDIO_PDF = '".str_replace("'","''",$TITOLOSTUDIO_PDF)."'";
            $str_query .= ",ITASTRANIERI = '".str_replace("'","''",$ITASTRANIERI)."'";
            $str_query .= ",NOTA = '".str_replace("'","''",$NOTA)."'";
            $str_query .= ",permessosogg = '".str_replace("'","''",$permessosogg)."'";
            $str_query .= ",esame_ital = '".str_replace("'","''",$esame_ital)."'";
            $str_query .= ",celebret = '".str_replace("'","''",$celebret)."'"; 
            if (intval($DATAAGGIORN)>0) {
                $str_query .= ",DATAAGGIORN='".$DATAAGGIORN."'";
            }else{
                $str_query .= ",DATAAGGIORN=null";
            }        
            if (intval($PRIVACY)>0) {
                $str_query .= ",PRIVACY='".$PRIVACY."'";
            }else{
                $str_query .= ",PRIVACY=null";
            }        
            if (intval($datascad_permessosogg)>0) {
                $str_query .= ",datascad_permessosogg='".$datascad_permessosogg."'";
            }else{
                $str_query .= ",datascad_permessosogg=null";
            }        
            if (intval($datascad_extracollegio)>0) {
                $str_query .= ",datascad_extracollegio='".$datascad_extracollegio."'";
            }else{
                $str_query .= ",datascad_extracollegio=null";
            }        
            if (intval($PRIMALINGUA)>0) {
                $str_query .= ",PRIMALINGUA=".$PRIMALINGUA;
            }else{
                $str_query .= ",PRIMALINGUA=null";
            }        
            if (intval($SECLINGUA)>0) {
                $str_query .= ",SECLINGUA=".$SECLINGUA;
            }else{
                $str_query .= ",SECLINGUA=null";
            }        
            if (intval($TERLINGUA)>0) {
                $str_query .= ",TERLINGUA=".$TERLINGUA;
            }else{
                $str_query .= ",TERLINGUA=null";
            }        
            if (intval($QUALINGUA)>0) {
                $str_query .= ",QUALINGUA=".$QUALINGUA;
            }else{
                $str_query .= ",QUALINGUA=null";
            }                
        }
        if (intval($TAB)>=7){ //iscrizione
            $query=$this->db->query("SELECT ANNOACCADEMICO FROM scadenze where ATTIVO=1");
            $row = $query->row();
            $ANNOACCA = $row->ANNOACCADEMICO;  
//            $CATEGORIA = $post['CATEGORIA'];
            $str_query .= ",ANNOACCA = ".$ANNOACCA;
//            $str_query .= ",CATEGORIA = '".$CATEGORIA."'";

            if(isset($post['CORSOLAUREA'])){
                $CORSOLAUREA = $post['CORSOLAUREA'];
//                $STR_OSP = $post['STR_OSP'];
                $ANNOCORSO = '1'; //$post['ANNOCORSO'];
                $str_query .= ",CORSOLAUREA = ".$CORSOLAUREA;
//                $str_query .= ",STR_OSP = '".$STR_OSP."'";
                $str_query .= ",ANNOCORSO = ".$ANNOCORSO;
                if ($post['CORSOLAUREA']=='210' && intval($post['INDIRIZZOLAUREA'])>0) {
                    $INDIRIZZOLAUREA = $post['INDIRIZZOLAUREA'];
                    $str_query .= ",INDIRIZZOLAUREA=".$INDIRIZZOLAUREA;
                }else{
                    $str_query .= ",INDIRIZZOLAUREA=null";
                } 
            }
            if(isset($post['PAGAMENTOMOD'])){
                $PAGAMENTOMOD=$post['PAGAMENTOMOD'];
                $PAGAMENTODATA=$post['PAGAMENTODATA'];
                $str_query .= ",PAGAMENTOMOD = ".$PAGAMENTOMOD;
                $str_query .= ",PAGAMENTODATA = '".$PAGAMENTODATA."'";
            }
        }
        switch (intval($TAB)) {
            case 1: //dati_personali
                $str_query .= ",TAB = 2";
                $_SESSION['tab_attivo_studente'] = 'tab2';                
                break;
            case 2: //ordinario_religioso
                $str_query .= ",TAB = 3";
                $_SESSION['tab_attivo_studente'] = 'tab3';                
                break;
            case 3: //collegio
                $str_query .= ",TAB = 4";
                $_SESSION['tab_attivo_studente'] = 'tab4';                
                break;
            case 4: //indirizzi
                $str_query .= ",TAB = 5";
                $_SESSION['tab_attivo_studente'] = 'tab6';                
                break;
            case 5: //titoli_accademici 
                $str_query .= ",TAB = 7";
                $_SESSION['tab_attivo_studente'] = 'tab7';                
                break;
            case 7: //iscrizione
                if(isset($post['PAGAMENTOMOD'])){
                    $_SESSION['tab_attivo_studente'] = 'tab1';
                }else{
                    $_SESSION['tab_attivo_studente'] = 'tab7';
                }
                break;
        }        
        $str_query .= " where ID=".$id;        
        $this->db->query($str_query); 
        return;        
    }
    
    public function SalvaModificaStudentePreiscrizione_intera($id,$post){
	$COGNOME = $post['COGNOME'];
	$NOMESTUD = $post['NOMESTUD'];
	$NASCDATA = $post['NASCDATA'];
	$NASCCOMUNE = $post['NASCCOMUNE'];
	$NASCPROV = $post['ID_provincia'];
	$NASCNAZI = $post['ID_nazione'];
	$RESINDS = $post['RESINDS'];
	$RESCOMUNE = $post['RESCOMUNE'];
	$RESPROV = $post['ID_provinciaresidenza'];
	$RESNAZI = $post['ID_nazioneresidenza'];
	$RESCAP = $post['RESCAP'];
	$RESTELE = $post['RESTELE'];
	$RECPRES = $post['RECPRES'];
	$RECINDS = $post['RECINDS'];
	$RECCOMUNE = $post['RECCOMUNE'];
	$RECPROV = $post['ID_provinciarecapito'];
	$RECCAP = $post['RECCAP'];
	$RECTELE = $post['RECTELE'];
	$CITTADI1 = $post['CITTADINANZA_NASCITA'];
	$CITTADI2 = $post['ID_cittadinanza'];
	$SESSO = $post['SESSO'];
	$STATOCIV = $post['STATOCIV'];
	$CODFISCA = $post['CODFISCA'];
//	$DATAIMMI = $post['DATAIMMI'];
	$COLLEGIO = $post['ID_collegio'];
	$ORDINE = $post['ID_ordine'];
	$DIOCESI = $post['ID_diocesi'];
	$email = $post['email'];
	$cellulare = $post['cellulare'];
        
        $str_query = "update studente_preiscrizione set ";
        $str_query .= "COGNOME = '".str_replace("'","''",$COGNOME)."'";
        $str_query .= ",NOMESTUD = '".str_replace("'","''",$NOMESTUD)."'";
        $str_query .= ",NASCDATA = '".str_replace("'","''",$NASCDATA)."'";
        $str_query .= ",NASCCOMUNE = '".str_replace("'","''",$NASCCOMUNE)."'";
        if (intval($NASCPROV)>0) {
            $str_query .= ",NASCPROV=".$NASCPROV;
        }else{
            $str_query .= ",NASCPROV=null";
        }
        if (intval($NASCNAZI)>0) {
            $str_query .= ",NASCNAZI=".$NASCNAZI;
        }else{
            $str_query .= ",NASCNAZI=null";
        }
        $str_query .= ",RESINDS = '".str_replace("'","''",$RESINDS)."'";
        $str_query .= ",RESCOMUNE = '".str_replace("'","''",$RESCOMUNE)."'";
        if (intval($RESPROV)>0) {
            $str_query .= ",RESPROV=".$RESPROV;
        }else{
            $str_query .= ",RESPROV=null";
        }
        if (intval($RESNAZI)>0) {
            $str_query .= ",RESNAZI=".$RESNAZI;
        }else{
            $str_query .= ",RESNAZI=null";
        }        
        $str_query .= ",RESCAP = '".str_replace("'","''",$RESCAP)."'";
        $str_query .= ",RESTELE = '".str_replace("'","''",$RESTELE)."'";
        $str_query .= ",RECPRES = '".str_replace("'","''",$RECPRES)."'";
        $str_query .= ",RECINDS = '".str_replace("'","''",$RECINDS)."'";
        $str_query .= ",RECCOMUNE = '".str_replace("'","''",$RECCOMUNE)."'";
        if (intval($RECPROV)>0) {
            $str_query .= ",RECPROV=".$RECPROV;
        }else{
            $str_query .= ",RECPROV=null";
        }
        $str_query .= ",RECCAP = '".str_replace("'","''",$RECCAP)."'";
        $str_query .= ",RECTELE = '".str_replace("'","''",$RECTELE)."'";
        if (intval($CITTADI1)>0) {
            $str_query .= ",CITTADI1=".$CITTADI1;
        }else{
            $str_query .= ",CITTADI1=null";
        }        
        if (intval($CITTADI2)>0) {
            $str_query .= ",CITTADI2=".$CITTADI2;
        }else{
            $str_query .= ",CITTADI2=null";
        }        
        $str_query .= ",SESSO = '".str_replace("'","''",$SESSO)."'";
        if (intval($STATOCIV)>0) {
            $str_query .= ",STATOCIV=".$STATOCIV;
        }else{
            $str_query .= ",STATOCIV=null";
        }        
        $str_query .= ",CODFISCA = '".str_replace("'","''",$CODFISCA)."'";
//        if (intval($DATAIMMI)>0) {
//            $str_query .= ",DATAIMMI=".$DATAIMMI;
//        }else{
//            $str_query .= ",DATAIMMI=null";
//        }
        if (intval($COLLEGIO)>0) {
            $str_query .= ",COLLEGIO=".$COLLEGIO;
        }else{
            $str_query .= ",COLLEGIO=null";
        }        
        if (intval($ORDINE)>0) {
            $str_query .= ",ORDINE=".$ORDINE;
        }else{
            $str_query .= ",ORDINE=null";
        }        
        if (intval($DIOCESI)>0) {
            $str_query .= ",DIOCESI=".$DIOCESI;
        }else{
            $str_query .= ",DIOCESI=null";
        }        
        $str_query .= ",email = '".str_replace("'","''",$email)."'";
        $str_query .= ",cellulare = '".str_replace("'","''",$cellulare)."'";

        // indirizzi permanenti
	$SUPERIORE = $post['SUPERIORE'];
	$IND_SUP1 = $post['IND_SUP1'];
	$IND_SUP2 = $post['IND_SUP2'];
	$SUP_CITY = $post['SUP_CITY'];
	$SUP_STATE = $post['UP_STATE'];
	$S_COUNTRY = $post['S_COUNTRY'];
	$SZIPEUR = $post['SZIPEUR'];
	$SPHONE = $post['SPHONE'];
	$SFAX = $post['SFAX'];
	$SUPMOVILE = $post['SUPMOVILE'];
	$SEMAIL = $post['SEMAIL'];          
        
        $str_query .= ",SUPERIORE = '".str_replace("'","''",$SUPERIORE)."'";
        $str_query .= ",IND_SUP1 = '".str_replace("'","''",$IND_SUP1)."'";
        $str_query .= ",IND_SUP2 = '".str_replace("'","''",$IND_SUP2)."'";
        $str_query .= ",SUP_CITY = '".str_replace("'","''",$SUP_CITY)."'";
        $str_query .= ",SUP_STATE = '".str_replace("'","''",$SUP_STATE)."'";
        $str_query .= ",S_COUNTRY = '".str_replace("'","''",$S_COUNTRY)."'";
        $str_query .= ",SZIPEUR = '".str_replace("'","''",$SZIPEUR)."'";
        $str_query .= ",SPHONE = '".str_replace("'","''",$SPHONE)."'";
        $str_query .= ",SFAX = '".str_replace("'","''",$SFAX)."'";
        $str_query .= ",SUPMOVILE = '".str_replace("'","''",$SUPMOVILE)."'";
        $str_query .= ",SEMAIL = '".str_replace("'","''",$SEMAIL)."'";               
        
        //stato documenti
	$CERTNASC = $post['CERTNASC'];
	$FOTOGRAF = $post['FOTOGRAF'];
	$LATINO = $post['LATINO'];
	$GRECO = $post['GRECO'];
	$ITASTRANIERI = $post['ITASTRANIERI'];
	$NOTA = $post['STATODOC_NOTA'];
	$permessosogg = $post['permessosogg'];
	$esame_ital = $post['esame_ital'];
	$celebret = $post['celebret'];       
	$DATAAGGIORN = $post['DATAAGGIORN'];
	$PRIVACY = $post['PRIVACY'];
	$datascad_permessosogg = $post['datascad_permessosogg'];
	$datascad_extracollegio = $post['datascad_extracollegio'];
	$PRIMALINGUA = $post['PRIMALINGUA'];
	$SECLINGUA = $post['SECLINGUA'];
	$TERLINGUA = $post['TERLINGUA'];
	$QUALINGUA = $post['QUALINGUA'];

        $str_query .= ",CERTNASC = '".str_replace("'","''",$CERTNASC)."'";
        $str_query .= ",FOTOGRAF = '".str_replace("'","''",$FOTOGRAF)."'";
        $str_query .= ",LATINO = '".str_replace("'","''",$LATINO)."'";
        $str_query .= ",GRECO = '".str_replace("'","''",$GRECO)."'";
        $str_query .= ",ITASTRANIERI = '".str_replace("'","''",$ITASTRANIERI)."'";
        $str_query .= ",NOTA = '".str_replace("'","''",$NOTA)."'";
        $str_query .= ",permessosogg = '".str_replace("'","''",$permessosogg)."'";
        $str_query .= ",esame_ital = '".str_replace("'","''",$esame_ital)."'";
        $str_query .= ",celebret = '".str_replace("'","''",$celebret)."'"; 
        if (intval($DATAAGGIORN)>0) {
            $str_query .= ",DATAAGGIORN='".$DATAAGGIORN."'";
        }else{
            $str_query .= ",DATAAGGIORN=null";
        }        
        if (intval($PRIVACY)>0) {
            $str_query .= ",PRIVACY='".$PRIVACY."'";
        }else{
            $str_query .= ",PRIVACY=null";
        }        
        if (intval($datascad_permessosogg)>0) {
            $str_query .= ",datascad_permessosogg='".$datascad_permessosogg."'";
        }else{
            $str_query .= ",datascad_permessosogg=null";
        }        
        if (intval($datascad_extracollegio)>0) {
            $str_query .= ",datascad_extracollegio='".$datascad_extracollegio."'";
        }else{
            $str_query .= ",datascad_extracollegio=null";
        }        
        if (intval($PRIMALINGUA)>0) {
            $str_query .= ",PRIMALINGUA=".$PRIMALINGUA;
        }else{
            $str_query .= ",PRIMALINGUA=null";
        }        
        if (intval($SECLINGUA)>0) {
            $str_query .= ",SECLINGUA=".$SECLINGUA;
        }else{
            $str_query .= ",SECLINGUA=null";
        }        
        if (intval($TERLINGUA)>0) {
            $str_query .= ",TERLINGUA=".$TERLINGUA;
        }else{
            $str_query .= ",TERLINGUA=null";
        }        
        if (intval($QUALINGUA)>0) {
            $str_query .= ",QUALINGUA=".$QUALINGUA;
        }else{
            $str_query .= ",QUALINGUA=null";
        }                
        // iscrizione studente
	$ANNOACCA = '2020'; //$post['ANNOACCA'];
	$CATEGORIA = $post['CATEGORIA'];
	$CORSOLAUREA = $post['CORSOLAUREA'];
	$ANNOCORSO = '1'; //$post['ANNOCORSO'];
	$INDIRIZZOLAUREA = $post['INDIRIZZOLAUREA'];
        
        $str_query .= ",ANNOACCA = ".$ANNOACCA;
        $str_query .= ",CATEGORIA = '".$CATEGORIA."'";
        $str_query .= ",CORSOLAUREA = ".$CORSOLAUREA;
        $str_query .= ",ANNOCORSO = ".$ANNOCORSO;
        if (intval($INDIRIZZOLAUREA)>0) {
            $str_query .= ",INDIRIZZOLAUREA=".$INDIRIZZOLAUREA;
        }else{
            $str_query .= ",INDIRIZZOLAUREA=null";
        }         
        
        $str_query .= " where ID=".$id;        
        $this->db->query($str_query); 
        return;        
    }

    public function SalvaModificaTitoliStudentePreiscrizione($id,$post){
	$ANNOACCA = $post['ANNOACCA'];
	$TIPTITST = $post['TIPTITST'];
	$VOTAZIONE = $post['VOTAZIONE'];
	$QUALIFICA = $post['QUALIFICA'];
	$ISTISUPE = $post['ISTISUPE'];
	$TIPDOCAL = $post['TIPDOCAL'];
	$NOTA = $post['NOTA'];

        $str_query = "update titolistudente_preiscrizione set ";
        $str_query .= "ANNOACCA = ".$ANNOACCA.",";
        $str_query .= "TIPTITST = '".$TIPTITST."',";
        $str_query .= "VOTAZIONE = '".$VOTAZIONE."',";
        $str_query .= "QUALIFICA = '".$QUALIFICA."',";
        $str_query .= "ISTISUPE = ".$ISTISUPE.",";
        $str_query .= "TIPDOCAL = ".$TIPDOCAL.",";
        $str_query .= "NOTA = '".$NOTA."'";
        $str_query .= " where ID=".$id." and TIPTITST=".$TIPTITST;        
        $this->db->query($str_query); 
        return;        
    }                
    
    public function SalvaNuovoTitoloStudentePreiscrizione($post){
	$ID = $post['ID'];
	$ANNOACCA = $post['ANNOACCA'];
	$TIPTITST = $post['TIPTITST'];
	$VOTAZIONE = $post['VOTAZIONE'];
	$QUALIFICA = $post['QUALIFICA'];
	$ISTISUPE = $post['ISTISUPE'];
	$TIPDOCAL = $post['TIPDOCAL'];
	$NOTA = $post['NOTA'];
        
        $str_query = "insert into titolistudente_preiscrizione(
                     ID,ANNOACCA,TIPTITST,VOTAZIONE,QUALIFICA,ISTISUPE,TIPDOCAL,NOTA) 
                     values(";
        $str_query .= $ID.",";
        $str_query .= $ANNOACCA.",";
        $str_query .= $TIPTITST.",";
        if (intval($VOTAZIONE)>0) {
            $str_query .= str_replace(",",".",$VOTAZIONE).',';
        }else{
            $str_query .= "null,";
        } 
        $str_query .= "'".str_replace("'","''",$QUALIFICA)."',";
        if (intval(ISTISUPE)>0) {
            $str_query .= ISTISUPE.',';
        }else{
            $str_query .= "null,";
        }        
        if (intval($TIPDOCAL)>0) {
            $str_query .= $TIPDOCAL.',';
        }else{
            $str_query .= "null,";
        }        
        $str_query .= "'".str_replace("'","''",$NOTA)."'";
        $str_query .= ")";        
        $this->db->query($str_query); 
        return;        
    }            

    public function tab_sceltacorsistudente($id,$corsolaurea,$semestre,$annoinizio,$tipo){
//        $str_query=@"SELECT CORSI,COGNOME,replace(DESCRIZIONECORSI,CHAR(34),'') AS DESCRIZIONECORSI,sigla
//                    FROM (
//                         SELECT c.CORSI,c.DESCRIZIONECORSI,c.sigla,pm.MATRICOL,p.COGNOME
//                         FROM corsi c
//                         LEFT JOIN professore_materia pm ON pm.CORSI=c.CORSI 
//                         LEFT JOIN professore p ON p.MATRICOL=pm.MATRICOL
//                         WHERE c.annoinizio=".$annoinizio." AND c.semestre=".$semestre."
//                    ) corsi 
//                    ORDER BY sigla,DESCRIZIONECORSI
//                    ";
        $str_query=@"SELECT c.CORSI,GROUP_CONCAT(c.COGNOME  SEPARATOR ' - ') AS COGNOME,
                            c.DESCRIZIONECORSI,c.sigla,pss.MATRICOL,
                            if(NOT ISNULL(pss.MATRICOL) AND ISNULL(pss.tipo),'X',pss.tipo) AS tipo 
                    FROM (
                            SELECT CORSI,COGNOME,replace(DESCRIZIONECORSI,CHAR(34),'') AS DESCRIZIONECORSI,sigla
                       FROM (
                           SELECT c.CORSI,c.DESCRIZIONECORSI,c.sigla,pm.MATRICOL,p.COGNOME
                           FROM corsi c
                           LEFT JOIN professore_materia pm ON pm.CORSI=c.CORSI 
                           LEFT JOIN professore p ON p.MATRICOL=pm.MATRICOL
                           WHERE c.annofine=".$annoinizio." AND c.semestre=".$semestre." AND c.sigla Like '".$tipo."%'
                       ) corsi
                    ) c 
                    LEFT JOIN pianistudiostudente pss ON c.CORSI=pss.CORSI AND pss.MATRICOL=".$id." AND pss.CORSOLAU=".$corsolaurea."
                    GROUP BY c.CORSI
                    ORDER BY c.sigla,c.DESCRIZIONECORSI";
        $query=$this->db->query($str_query);
        $result = $query->result_array(); 
        return $result;          
    }    
    public function EliminaEsamePianoStudiStudente($id,$corsolaurea,$CORSI){
        $str_query = "DELETE pss.* 
                      FROM pianistudiostudente pss
                      INNER JOIN corsi c ON c.CORSI=pss.CORSI
                      WHERE c.CORSI='".$CORSI."' AND pss.MATRICOL=".$id." AND pss.CORSOLAU=".$corsolaurea;
        $this->db->query($str_query); 
        return;        
    }     
    public function InserisciEsamePianoStudiStudente($id,$corsolaurea,$sigla,$CORSI,$tipo){
        $str_query = "INSERT INTO pianistudiostudente(
                        MATRICOL,UNIVERSI,FACOLTA,CORSOLAU,ANNOCORS,CORSI,CREDITI,tipo)
                        SELECT ".$id.",UNIVERSITA,FACOLTA,".$corsolaurea.",1,".$CORSI.",CREDITI,'".$tipo."' 
                      FROM corsi 
                      WHERE sigla='".$sigla."'"; 
        $this->db->query($str_query); 
        return;        
    }
    
    public function SalvaNuovoStudentePreiscrizione($id_new,$id){
        $DATAIMMI=date('Y-m-d');
        $str_query = "insert into studente( 
                        MATRICOL,UNIVERSITA,COGNOME,NOMESTUD,SESSO,DATAIMMI,
                        NASCDATA,NASCCOMUNE,NASCPROV,NASCNAZI,
                        RESINDS,RESCOMUNE,RESPROV,RESNAZI,RESCAP,RESTELE,
                        RECPRES,RECINDS,RECCOMUNE,RECPROV,RECCAP,RECTELE,
                        CITTADI1,CITTADI2,STATOCIV,CODFISCA,
                        COLLEGIO,ORDINE,DIOCESI,email,cellulare)
                        SELECT ".$id_new.",1,COGNOME,NOMESTUD,SESSO,'".$DATAIMMI."',
                            NASCDATA,NASCCOMUNE,NASCPROV,NASCNAZI,
                            RESINDS,RESCOMUNE,RESPROV,RESNAZI,RESCAP,RESTELE,
                            RECPRES,RECINDS,RECCOMUNE,RECPROV,RECCAP,RECTELE,
                            CITTADI1,CITTADI2,STATOCIV,CODFISCA,
                            COLLEGIO,ORDINE,DIOCESI,email,cellulare
                        FROM studente_preiscrizione
                        WHERE ID=".$id;
        $this->db->query($str_query); 
        
        $str_query = "insert into studente_indirizzi_permanenti( 
                        MATRICOLA,SUPERIORE,IND_SUP1,IND_SUP2,SUP_CITY,SUP_STATE,
                        S_COUNTRY,SZIPEUR,SPHONE,SFAX,SUPMOVILE,SEMAIL)
                        SELECT ".$id_new.",SUPERIORE,IND_SUP1,IND_SUP2,SUP_CITY,SUP_STATE,
                            S_COUNTRY,SZIPEUR,SPHONE,SFAX,SUPMOVILE,SEMAIL
                        FROM studente_preiscrizione
                        WHERE ID=".$id;
        $this->db->query($str_query); 
        
        $str_query = "insert into statodocumenti( 
                        MATRICOL,CERTNASC,FOTOGRAF,LATINO,GRECO,AUTSUP,ITASTRANIERI,
                        NOTA,permessosogg,esame_ital,celebret,DATAAGGIORN,
                        PRIVACY,datascad_permessosogg,datascad_extracollegio,
                        PRIMALINGUA,SECLINGUA,TERLINGUA,QUALINGUA)
                        SELECT ".$id_new.",CERTNASC,FOTOGRAF,LATINO,GRECO,AUTSUP,ITASTRANIERI,
                            NOTA,permessosogg,esame_ital,celebret,DATAAGGIORN,
                            PRIVACY,datascad_permessosogg,datascad_extracollegio,
                            PRIMALINGUA,SECLINGUA,TERLINGUA,QUALINGUA
                        FROM studente_preiscrizione
                        WHERE ID=".$id;
        $this->db->query($str_query); 
        
        $query=$this->db->query("SELECT SEMESTRE FROM parametri_preiscrizione");
        $row = $query->row();
        $tisc2se = $row->SEMESTRE;  
        if ($tisc2se=='1'){
            $tisc2se='N';
        }else{
            $tisc2se='S';
        }
        
        $str_query = "insert into iscrizionistudente(
                        UNIVERSI,POSISCRIZIONE,FACOLTA,tisc2se,tstatu1,tann1se,
                        MATRICOL,ANNOACCA,CATEGORIA,CORSOLAUREA,ANNOCORSO,INDIRIZZOLAUREA) 
                        SELECT 1,1,1,'".$tisc2se."',1,1,".$id_new.",ANNOACCA,CATEGORIA,CORSOLAUREA,
                            ANNOCORSO,INDIRIZZOLAUREA        
                        FROM studente_preiscrizione
                        WHERE ID=".$id;        
        $this->db->query($str_query); 
////// aggiungere record tasse
        $query=$this->db->query("SELECT PAGANTICIPATO,SCONTO,PAGAMENTO,DATE_ADD(PAGAMENTO, INTERVAL 90 DAY) AS PAGAMENTO2 FROM parametri_preiscrizione");
        $row = $query->row();
        $DATASCADENZA = $row->PAGAMENTO;  
        $DATASCADENZA2 = $row->PAGAMENTO2;  
        $PAGANTICIPATO = $row->PAGANTICIPATO;  
        $SCONTO = $row->SCONTO;  

        $str_query = "insert into tassestudente(
                        MATRICOL,UNIVERSITA,FACOLTA,CORSODILAUREA,ANNOACCADEMICO,ANNOCORSO,
                        CAUSALETASSE,IMPPAGATO,DATASCADENZA)
                        SELECT ".$id_new.",1,1,t.CORSODILAUREA,t.ANNOACCADEMICO,t.ANNODICORSO,
                                t.CAUSALETASSA,t.IMPORTOTASSA,
                                if(t.CAUSALETASSA='2R','".$DATASCADENZA2."','".$DATASCADENZA."')
                        FROM studente_preiscrizione s
                        INNER JOIN importitasse t ON s.CORSOLAUREA=t.CORSODILAUREA 
                                                AND s.ANNOACCA=t.ANNOACCADEMICO 
                                                AND s.ANNOCORSO=t.ANNODICORSO
                                                AND if(s.PAGAMENTOMOD=1, t.CAUSALETASSA='RU',t.CAUSALETASSA IN('1R','2R'))
                        WHERE s.ID=".$id
                        ." ORDER BY t.CAUSALETASSA desc";        
        $this->db->query($str_query); 
        
//      aggiunta record sconto tassa 
        $str_query = "insert into tassestudente(
                        MATRICOL,UNIVERSITA,FACOLTA,CORSODILAUREA,ANNOACCADEMICO,ANNOCORSO,
                        CAUSALETASSE,IMPPAGATO,DATASCADENZA)
                        SELECT ".$id_new.",1,1,t.CORSODILAUREA,t.ANNOACCADEMICO,t.ANNODICORSO,
                                'SC',-".$SCONTO.",
                                '".$PAGANTICIPATO."'
                        FROM studente_preiscrizione s
                        INNER JOIN importitasse t ON s.CORSOLAUREA=t.CORSODILAUREA 
                                                  AND s.ANNOACCA=t.ANNOACCADEMICO 
                                                  AND s.ANNOCORSO=t.ANNODICORSO
                                                  AND t.CAUSALETASSA ='RU'
                                                  AND s.PAGAMENTOMOD=1
                                                  AND s.PAGAMENTODATA<='".$PAGANTICIPATO."'";                                                  
        $this->db->query($str_query);   
///////////////////////////////        
        $str_query = "insert into titolistudente(
                        MATRICOL,ANNOACCA,TIPTITST,VOTAZIONE,QUALIFICA,ISTISUPE,TIPDOCAL,DATA_SANATIO,NOTA) 
                        SELECT ".$id_new.",ANNOACCA,TIPTITST,VOTAZIONE,QUALIFICA,
                            ISTISUPE,TIPDOCAL,DATA_SANATIO,NOTA
                        FROM titolistudente_preiscrizione
                        WHERE ID=".$id;
        $this->db->query($str_query); 
        
        $str_query = "delete FROM studente_preiscrizione
                        WHERE ID=".$id;
        $this->db->query($str_query); 
        
        $str_query = "delete FROM titolistudente_preiscrizione
                        WHERE ID=".$id;
        $this->db->query($str_query); 
        
        $str_query = "update users_groups
                        SET group_id=8
                        WHERE user_id=".$id." AND group_id=7";
        $this->db->query($str_query); 
        return;                
    }    
    
    public function ModuloIscrizioneCorsi($matricola, $anno,$semestrecorso)
    {
        $sql = 'SELECT 
            i.MATRICOL,
            s.COGNOME,
            s.NOMESTUD AS NOME,
            Concat(i.ANNOACCA-1,\'-\',i.ANNOACCA) AS ANNO_ACCADEMICO,
            -- i.CATEGORIA,
            c.DECODIF AS CORSO_LAUREA,
            -- i.ANNOCORSO,
            i.SEMESTREACCA,
            i.SEMESTRECORSO,
            l.DECODIFICA AS INDIRIZZO_LAUREA
        FROM iscrizionistudente i
        INNER JOIN corsidilaurea c ON i.CORSOLAUREA=c.CODICENU
        LEFT JOIN indirizzolaurea l ON i.INDIRIZZOLAUREA=l.CODICENU
        INNER JOIN studente s ON s.MATRICOL=i.MATRICOL
        WHERE i.deleted=0 and i.MATRICOL='.$matricola.' AND SEMESTRECORSO='.$semestrecorso.' AND ANNOACCA='.$anno.';'
        ;
        $query = $this->db->query($sql);
        return $query->row_array();
    }    

    public function ModuloCertificatoPreiscrizione($id)
    {
        $sql = "SELECT 
                    UCASE(s.COGNOME) as COGNOME,
                    s.NOMESTUD,
                    DATE_FORMAT(s.NASCDATA, '%d/%m/%Y') AS NASCDATA,
                    s.NASCCOMUNE,
                    n.DECODIF AS STATO,
                    if(s.NASCNAZI>1,NASCPROV_ESTERA,p.DECODIF) AS PROVINCIA, 
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
                    if(s.COLLEGIO=0,s.RECPROV,pc.DECODIF) AS PROV,
                    if(s.COLLEGIO=0,s.RECCAP,cl.CAP) AS CAP,
                    if(s.COLLEGIO=0,s.RECTELE,cl.TELEFONO) AS TELEFONO,
                    s.PRESAINCARICO_RESP
                FROM studente_preiscrizione s
                LEFT JOIN nazione n ON n.CODICENU=s.NASCNAZI
                LEFT JOIN provincia p ON p.CODICENU=s.NASCPROV
                LEFT JOIN nazione c ON c.CODICENU=s.CITTADI2
                INNER JOIN corsidilaurea l ON l.CODICENU=s.CORSOLAUREA
                INNER JOIN scadenze sc ON sc.ANNOACCADEMICO=s.ANNOACCA
                LEFT JOIN collegi cl ON cl.CODICE=s.COLLEGIO
                LEFT JOIN provincia pc ON pc.CODICENU=cl.PROVINCIA
                WHERE s.ID=".$id;
        $query = $this->db->query($sql);
        return $query->row_array();
    }    


    public function NuovoUtentePreiscrizione($id,$ANNOACCA,$SEMESTREACCA){
        $str_query="insert into studente_preiscrizione(ID,COGNOME,NOMESTUD,email,cellulare,ANNOACCA,SEMESTREACCA) 
                    SELECT id,last_name,first_name,email,phone,".$ANNOACCA.",".$SEMESTREACCA."
                    FROM users
                    WHERE id=".$id;
        $this->db->query($str_query); 
        return;        
    }
    public function InserisciGruppo($user_id,$group_id){
        $str_query="insert into users_groups(user_id,group_id) 
                    Values(".$user_id.",".$group_id.")";
        $this->db->query($str_query); 
        return;        
    }
    public function EliminaUserNonAttivato($email){
        $str_query="delete from users where active=0 and email='".$email."'";
        $this->db->query($str_query); 
        $str_query="delete from studente_preiscrizione where email='".$email."'";
        $this->db->query($str_query); 
        return;        
    }

    public function VerificaPassaggioSemestreCorso($ANNOACCA,$SEMESTRE,$MATRICOLA){
        $str_query ="SELECT DISTINCT i.MATRICOL 
                    FROM iscrizionistudente i
                    LEFT JOIN (
                    SELECT
                       COUNT(c.CORSI) AS NESAMI,
                       c.SEMESTRE, 
                       e.MATRICOLA,
                       e.ANNOACCADEMICO
                    FROM esamistudente e 
                    INNER JOIN corsi c ON c.CORSI=e.CORSO
                    WHERE c.TIPOMEDIA='C'
                    GROUP BY 
                       c.SEMESTRE, 
                       e.MATRICOLA,
                       e.ANNOACCADEMICO) e ON e.MATRICOLA=i.MATRICOL AND e.ANNOACCADEMICO=i.ANNOACCA AND e.semestre=i.SEMESTREACCA
                    LEFT JOIN esamidilaurea el ON  el.MATRICOL=i.MATRICOL AND el.CORSOLAU=i.CORSOLAUREA
                    WHERE -- i.MATRICOL=3966 AND 
                        i.deleted=0 AND i.CORSOLAUREA=210 AND not isnull(i.SEMESTRECORSO) AND ISNULL(el.QUALIFICA)";
        if ($MATRICOLA!='0'){
            $str_query.=" AND i.MATRICOL=".$MATRICOLA;
        }
        $query=$this->db->query($str_query);
        $lista_matricole = $query->result_array(); 

        foreach ($lista_matricole as $lista){
            $str_query1 ="SELECT 
                            i.id_iscrizione,
                            i.MATRICOL,
                            i.ANNOACCA,
                            i.CORSOLAUREA,
                            i.SEMESTRECORSO,
                            i.CORSOCONFERMA,
                            i.SEMESTREACCA,                           
                            e.NESAMI
                      FROM iscrizionistudente i
                      LEFT JOIN (
                      SELECT
                         COUNT(c.CORSI) AS NESAMI,
                         c.SEMESTRE, 
                         e.MATRICOLA,
                         e.ANNOACCADEMICO
                      FROM esamistudente e 
                      INNER JOIN corsi c ON c.CORSI=e.CORSO
                      WHERE c.TIPOMEDIA='C' AND e.MATRICOLA=".$lista['MATRICOL']."  
                      GROUP BY 
                         c.SEMESTRE, 
                         e.MATRICOLA,
                         e.ANNOACCADEMICO) e ON e.MATRICOLA=i.MATRICOL AND e.ANNOACCADEMICO=i.ANNOACCA AND e.semestre=i.SEMESTREACCA
                      LEFT JOIN esamidilaurea el ON  el.MATRICOL=i.MATRICOL AND el.CORSOLAU=i.CORSOLAUREA
                      WHERE i.deleted=0 AND i.CORSOLAUREA=210 AND not isnull(i.SEMESTRECORSO) 
                            AND ISNULL(el.QUALIFICA) AND i.MATRICOL=".$lista['MATRICOL'];
            $str_query2=$str_query1." AND CAST(CONCAT(i.ANNOACCA,i.SEMESTREACCA) AS INT)<CAST(CONCAT('".$ANNOACCA."','".$SEMESTRE."') AS INT)
                      ORDER BY i.MATRICOL,i.ANNOACCA, i.SEMESTREACCA";
            $query=$this->db->query($str_query2);
            $row = $query->result_array(); 
            $n=0;
            $max_sc=0;
            foreach ($row as $rec){
                if ($rec['CORSOCONFERMA']=='1'){
                    $n=$rec['SEMESTRECORSO'];
                    $max_sc=$rec['SEMESTRECORSO'];
                }elseif ($rec['CORSOCONFERMA']=='0' AND $n>=4){
                    $n=$n+1;
                    $str_query="UPDATE iscrizionistudente SET CORSOCONFERMA=1,SEMESTRECORSO=".$n
                            ." WHERE id_iscrizione=".$rec['id_iscrizione'];
                    $this->db->query($str_query); 
                    $max_sc=$n;
                }elseif ($rec['CORSOCONFERMA']=='0' AND intval($rec['NESAMI'])<2){
                    $n=$rec['SEMESTRECORSO']-1;
                    $str_query="UPDATE iscrizionistudente SET CORSOCONFERMA=1,SEMESTRECORSO=0"
                            ." WHERE id_iscrizione=".$rec['id_iscrizione'];
                    $this->db->query($str_query); 
                }elseif ($rec['CORSOCONFERMA']=='0' AND intval($rec['NESAMI'])>1){
                    $n=$n+1;
                    $str_query="UPDATE iscrizionistudente SET CORSOCONFERMA=1,SEMESTRECORSO=".$n
                            ." WHERE id_iscrizione=".$rec['id_iscrizione'];
                    $this->db->query($str_query); 
                    $max_sc=$n;
                }
            }
//            $str_query2=$str_query1." AND CAST(CONCAT(i.ANNOACCA,i.SEMESTREACCA) AS INT)>=CAST(CONCAT('".$ANNOACCA."','".$SEMESTRE."') AS INT)";
//            $query=$this->db->query($str_query2);
//            $row2 = $query->row_array(); 
//            if (count($row2)>0){
//                $str_query="UPDATE iscrizionistudente SET CORSOCONFERMA=0,SEMESTRECORSO=".$max_sc
//                        ." WHERE id_iscrizione=".$row2['id_iscrizione'];
//                $this->db->query($str_query); 
//            }
            
            $str_query2=$str_query1." AND CAST(CONCAT(i.ANNOACCA,i.SEMESTREACCA) AS INT)>=CAST(CONCAT('".$ANNOACCA."','".$SEMESTRE."') AS INT)";
            $query=$this->db->query($str_query2);
            $row2 = $query->result_array(); 
            $max_sc=$max_sc+1;
            if (isset($row2[0]['id_iscrizione'])){
                $str_query="UPDATE iscrizionistudente SET CORSOCONFERMA=0, SEMESTRECORSO=".$max_sc
                        ." WHERE id_iscrizione=".$row2[0]['id_iscrizione'];
                $this->db->query($str_query); 
            }            
            $max_sc=$max_sc+1;
            if (isset($row2[1]['id_iscrizione'])){
                $str_query="UPDATE iscrizionistudente SET CORSOCONFERMA=0, SEMESTRECORSO=".$max_sc
                        ." WHERE id_iscrizione=".$row2[1]['id_iscrizione'];
                $this->db->query($str_query); 
            }            
        }
        return;
    }            
    public function tab_esamidilaurea($matricola){
//        $str_query="SELECT e.*,c.DECODIF AS CORSO_LAUREA,i.DECODIFICA AS INDIRIZZO_LAUREA
//                    FROM esamidilaurea e
//                    INNER JOIN corsidilaurea c ON e.CORSOLAU=c.CODICENU
//                    LEFT JOIN indirizzolaurea i ON i.CODICENU=e.CORSOLAU
//                    WHERE e.MATRICOL=".$matricola;
        
        $str_query="SELECT 
                        s.MATRICOL,
                        s.CORSOLAUREA,
                        e.CORSOLAU,
                        c.DECODIF AS CORSO_LAUREA,
                        e.ANNOACCA,
                        e.SESSIONE,
                        e.DATAESAME,
                        e.VOTOESAME,
                        e.vototesi,
                        e.votodifesa,
                        e.QUALIFICA,
                        e.NOTE
                    FROM (SELECT DISTINCT MATRICOL,CORSOLAUREA FROM iscrizionistudente WHERE MATRICOL=".$matricola.") s 
                    LEFT JOIN esamidilaurea e ON e.MATRICOL=s.MATRICOL
                    LEFT JOIN corsidilaurea c ON s.CORSOLAUREA=c.CODICENU";
        $query=$this->db->query($str_query);
        $result = $query->result_array(); 
        return $result;          
    }
    public function SalvaModificaEsameLaurea($id,$post){
        $azione = $post['AZIONE'];
        if($post['DATAESAME'] == NULL){
            $DATAESAME='null';
        }else{
            $DATAESAME="'".$post['DATAESAME']."'";
        }
        if($post['VOTOESAME'] == NULL){
            $VOTOESAME='null';
        }else{
            $VOTOESAME="'".$post['VOTOESAME']."'";
        }
        if($post['votodifesa'] == NULL){
            $votodifesa='null';
        }else{
            $votodifesa="'".$post['votodifesa']."'";
        }
        if($post['vototesi'] == NULL){
            $vototesi='null';
        }else{
            $vototesi="'".$post['vototesi']."'";
        }
           
        if ($post['AZIONE']=='edit'){
            $str_query = "update esamidilaurea set ";
            $str_query .= "ANNOACCA = ".$post['ANNOACCA'];
            $str_query .= ",SESSIONE = ".$post['SESSIONE'];
            $str_query .= ",DATAESAME = ".$DATAESAME;
            $str_query .= ",VOTOESAME = ".$VOTOESAME;
            $str_query .= ",vototesi = ".$vototesi;
            $str_query .= ",votodifesa = ".$votodifesa;
            $str_query .= ",QUALIFICA = '".$post['QUALIFICA']."'";
            $str_query .= ",NOTE = '".str_replace("'","''",$post['NOTE'])."'";
            $str_query .= " where MATRICOL=".$id;        
            $str_query .= " AND CORSOLAU=".$post['CORSOLAU'];        
        }else{
            $str_query = "insert into esamidilaurea(MATRICOL,UNIVERSITA,FACOLTA,CORSOLAU,ANNOACCA,SESSIONE,DATAESAME,"
                    . "VOTOESAME,vototesi,votodifesa,QUALIFICA,NOTE) VALUES(";
            $str_query .= $post['MATRICOL'].",1,1,";
            $str_query .= $post['CORSOLAU'].",";
            $str_query .= $post['ANNOACCA'].",";
            $str_query .= $post['SESSIONE'].",";
            $str_query .= $DATAESAME.",";
            $str_query .= $VOTOESAME.",";
            $str_query .= $vototesi.",";
            $str_query .= $votodifesa.",";
            $str_query .= "'".$post['QUALIFICA']."',";
            $str_query .= "'".str_replace("'","''",$post['NOTE'])."')";
        }
        $this->db->query($str_query); 
        return;        
    }   
    
    public function tab_istituzione_provenienza(){
        $str_query="SELECT * 
                    from istituzione_provenienza 
                    ORDER BY Nome_Istituzione";
        $query=$this->db->query($str_query);
        $result = $query->result_array(); 
        return $result;          
    }      

    public function tab_dati_istituzione_provenienza($id = NULL){
        if ($id===NULL) $id='999';
        $str_query="SELECT Codice,
                           Nome_istituzione AS ISTITUTO_PROVENIENZA,
                           CRUIPRO,
                           Accordo_mobil
                    FROM istituzione_provenienza
                    WHERE Codice=".$id;
        $query=$this->db->query($str_query);
        $result = $query->row_array(); 
        return $result;          
    }    
    
}
