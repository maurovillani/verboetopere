<html>
<body>
<div class="showAll">    
<font style="text-align:justify">
    <p style = "font-size:18px">
        Sembra che lei abbia richiesto il rinnovo della <i>password</i> di accesso alle aree riservate del sito web www.antonianum.eu: per completare la procedura è necessario fare clic sul seguente link
        <br/><?php echo sprintf(anchor('auth/reset_password/'. $forgotten_password_code ));?>
        <br/>ed effettuare una nuova 
        <br/>IMPOSTAZIONE DELLA PASSWORD PERSONALIZZATA.
        <br/><br/>
        Se invece non ha richiesto il rinnovo della <i>password</i>, trascuri quest’ultimo passaggio, ma informi comunque la Segreteria Generale dell’accaduto.
        <br/><br/>
        Attenzione: la procedura di impostazione consente di rinnovare la <i>password</i> di accesso alle aree riservate del sito web www.antonianum.eu <b>non ai PC disponibili nelle aule.</b> 
        <br/>Pertanto, la password di accesso ai PC disponibili nelle aule resterà quella comunicata dalla Segreteria Generale all’atto della registrazione nel sistema informatico della Pontificia Università Antonianum, ovvero <b><?php echo $pass_gest; ?></b>.

    </p>
</font>
</div>      
</body>
</html>