<html>
<body>
<div class="showAll">    
<font style="text-align:justify">
    <p style = "font-size:18px">
        <b>Abilitazione Utente</b>
        <br/>
        <a href='#English'>(English text below)</a><br/>
    </p>
    <p style = "font-size:18px">
        La sua e-mail è stata usata per registrare un nuovo utente nel sistema informatico dell'Accademia Alfonsiana.
        <br/>Lo username assegnato corrisponde alla sua e-mail <b><?php echo $identity; ?></b>
        <br/>
        <br/>Per procedere all’attivazione dell’account è indispensabile, <b>dopo aver letto attentamente tutta questa mail</b>, fare clic sul link in fondo pagina.
        <br/>
        <br/>Dopo di che sarà possibile inserire lo username e la sua password, per accedere al suo account e completare i suoi dati.
        <br/>
        <br/><b>Se ha bisogno di un certificato di preiscrizione</b> (per l’ingresso in Italia o altri motivi), prima di accedere al suo account, deve essere pronto a caricare i seguenti documenti, <b>in formato PDF:</b>
        <br/>
        <br/>1- certificato del titolo di studio conseguito o almeno degli esami già sostenuti;
        <br/>
        <br/>2- documento d’identità (di preferenza passaporto, o altro documento); 
        <br/>
        <br/>3- lettera di autorizzazione del Superiore/Vescovo, o per i laici, se è il caso, lettera di presentazione di un ecclesiastico (per esempio il parroco);
        <br/>
        <br/>4- lettera di presa in carico, da parte del responsabile della copertura delle spese per viaggio, alloggio, soggiorno, studi, eventuali cure mediche e qualunque altra necessità, per tutta la durata degli studi.
        <br/>
        <br/>Questa preiscrizione è la prima delle 4 tappe dell’iscrizione all’Accademia Alfonsiana. Dopo la presente preiscrizione, le tappe seguenti saranno:
        <br/>
        <br/>- L’iscrizione (anch’essa online), che sarà aperta tra il 1° settembre e il 18 ottobre 2021. In questa tappa si comunicano tutti i dati necessari per completare l’iscrizione.
        <br/>
        <br/>- Il perfezionamento dell’iscrizione, in presenza nella Segreteria generale, durante lo stesso periodo, una volta fatta l’iscrizione online. Si raccomanda comunque di completare questa tappa prima dell’inizio delle lezioni (il 5 ottobre 2021). In questa tappa si fa l’immatricolazione e si consegna allo studente la carta d’identità magnetica che serve per l’ingresso in biblioteca.
        <br/>
        <br/>- Il pagamento della tassa accademica tramite bonifico bancario, entro il 18 ottobre 2021.
        <br/>
        <br/>Benvenuto all’Accademia Alfonsiana!
        <br/>
        <br/>La Segretaria generale
        <br/>
        <br/>
        <?php echo sprintf(anchor('activatebyemail/'. $id .'/'. $activation));?>
        <br/>
    </p>
        <br/>
        <br/>
        <br/>
        <br/>
    <p style = "font-size:18px">
        <a name="English"></a>
        <b>User Activation</b>
        <br/>
        <br/>Your email has been used to register a new user in the computer system of the Accademia Alfonsiana.
        <br/>
        <br/>The username assigned corresponds to your email <b><?php echo $identity; ?></b>
        <br/>
        <br/>In order to proceed with the activation of the account it is necessary, <b>after having read the whole text of this mail</b>, to click on the link at the bottom of this page
        <br/>
        <br/>After that, you will be able to enter your username and password, to access your account and complete your data.
        <br/>
        <br/><b>If you need a pre-enrollment certificate </b> (for entry in Italy or other reasons), before accessing your account, you must be ready to upload the following documents, <b>in PDF format:</b>
        <br/>
        <br/>1- a certificate of the qualification obtained or at least of the exams already taken;
        <br/>
        <br/>2- an identity document (preferably passport, or another document);
        <br/>
        <br/>3- a letter of authorization from the Superior/Bishop, or for lay people, if it is the case, a letter of presentation from a clergyman (for example the parish priest);
        <br/>
        <br/>4- a letter from the person or institution responsible for covering expenses for travel, lodging, residence permit (soggiorno), studies, possible medical care, and any other needs, for the duration of the studies.
        <br/>
        <br/>This is the first of the 4 stages of enrollment in the Alphonsian Academy. After this pre-enrollment, the following steps will be:
        <br/>
        <br/>- The enrollment (also online), that will be open between September 1 and October 18, 2021. In this step you will provide all the necessary data to complete the registration.
        <br/>
        <br/>- The completion of the registration, in the presence of the General Secretariat, during the same period, once the online registration is completed. However, it is recommended to complete this step before the beginning of classes (October 5, 2021). At this stage, the registration is done, and the student is given a magnetic ID card, which is needed to enter the library.
        <br/>
        <br/>- Payment of the academic fee by bank transfer, by October 18, 2021.
        <br/>
        <br/>Welcome to the Accademia Alfonsiana!
        <br/>
        <br/>The Secretary General
        <br/>
        <br/>
        <?php echo sprintf(anchor('activatebyemail/'. $id .'/'. $activation));?>
        <br/>
        
    </p>    
</font>

 
</div> 


    
</body>
</html>
