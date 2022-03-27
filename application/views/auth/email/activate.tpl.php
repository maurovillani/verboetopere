<html>
<body>
<div class="showAll">    
<font style="text-align:justify">
    <p style = "font-size:18px">
        La sua email è stata usata per registrare un nuovo utente nel sistema informatico dell'Accademia Alfonsiana
        <br/>Lo username assegnato corrisponde alla sua email <b><?php echo $identity; ?></b>

        <br/>PER PROCEDERE ALL’IMPOSTAZIONE DELLA PASSWORD PERSONALIZZATA È INDISPENSABILE FARE CLIC SUL SEGUENTE LINK.
        <br/><?php echo sprintf(lang('email_forgot_password_subheading'), anchor('imposta_nuova_password/'. $forgotten_password_code, lang('email_forgot_password_link')));?>
        <br/>
        <br/>
    </p>
</font>
</div>      
</body>
</html>
