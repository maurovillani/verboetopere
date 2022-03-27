<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tiny_model extends CI_Model
{
    private $verboetopere;
    /**
     * Get some information
     *
     * @return array
     */
    public function getUserData()
    {

        // of course you can launch a query here ...

        $ud[0]['user_realname'] = 'John DOE';
        $ud[0]['user_photo'] = 'picture1.png';
        $ud[1]['user_realname'] = 'John DOE Junior';
        $ud[1]['user_photo'] = 'picture2.png';

        return $ud;
    }
    public function get_data($year = false)
    {
        if ($year === false || $year === 'all') {
            $this->db->select('year,purchase,sale,profit');
            $result = $this->db->get('account');
        } else {
            $this->db->select('year,purchase,sale,profit');
            $result = $this->db->get_where('account', array('year' => $year));
        }
        return $result;
    }

    /**
     * Iscrizione function
     *
     * @return void
     */
    public function iscrizione($matricola=123457, $anno=2018)
    {
        $sql = 'SELECT 
            i.MATRICOL,
            s.COGNOME,
            s.NOMESTUD AS NOME,
            Concat(i.ANNOACCA-1,\'-\',i.ANNOACCA) AS ANNO_ACCADEMICO,
            i.CATEGORIA,
            c.DECODIF AS CORSO_LAUREA,
            i.ANNOCORSO,
            l.DECODIFICA AS INDIRIZZO_LAUREA
        FROM iscrizionistudente i

        INNER JOIN corsidilaurea c ON i.CORSOLAUREA=c.CODICENU
        LEFT JOIN indirizzolaurea l ON i.INDIRIZZOLAUREA=l.CODICENU
        INNER JOIN studente s ON s.MATRICOL=i.MATRICOL
        WHERE i.deleted=0 and i.MATRICOL='.$matricola.' AND ANNOACCA='.$anno.';'
        ;

        //$this->verboetopere = $this->load->database('verboetopere', true);
        $query = $this->db->query($sql);
        return $query->row_array();
    }
    /**
     * Iscrizione Corsi function
     *
     * @return void
     */
    public function iscrizioneCorsi($tipo)
    {
        $sql='SELECT c.COGNOME,c.DESCRIZIONECORSI,c.sigla,pss.tipo
        FROM (
        SELECT CORSI,COGNOME,replace(DESCRIZIONECORSI,CHAR(34),\'\') AS DESCRIZIONECORSI,sigla
        FROM (
        SELECT c.CORSI,c.DESCRIZIONECORSI,c.sigla,pm.MATRICOL,p.COGNOME
        FROM corsi c
        LEFT JOIN professore_materia pm ON pm.CORSI=c.CORSI
        LEFT JOIN professore p ON p.MATRICOL=pm.MATRICOL
        WHERE c.annoinizio=2018 AND c.semestre=2 AND c.sigla Like \''.$tipo.'%\'
        ) corsi
        ) c
        LEFT JOIN pianistudiostudente pss ON c.CORSI=pss.CORSI AND pss.MATRICOL=123457 AND pss.CORSOLAU=240
        ORDER BY c.sigla,c.DESCRIZIONECORSI;'
        ;
        //$this->verboetopere = $this->load->database('verboetopere', true);
        $query = $this->db->query($sql);
        return $query->result_array();
    }
}
