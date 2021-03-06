<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=MacRoman">
        <title>Email to User</title>
        <?php
        include 'functions/utilities_functions.php';
        include './functions/MySqlFunctionsClass.php';

        $mySqlFunctions = new MySqlFunctionsClass();
        ?>
        <?php
        setTitle('Email from: [' . $_COOKIE['email_user'] . ']');
        setLogo('https://github.com/PHPMailer/PHPMailer', 'images/PhpMailer.png', 'https://github.com/PHPMailer/PHPMailer');


        include 'frames/logoTitleFrame.php';
        ?>
        <link href="css/PhpRegistroWeb.css" rel="stylesheet">


    </head>
    <body>
        <?php
        if (!isset($_COOKIE['emailId'])) {
            $result = $mySqlFunctions->getNewEmailId($_COOKIE['id_utente']);
            $row = mysql_fetch_assoc($result);
            setcookie('emailId', $row['id_email']);
        }
        ?>

        <?php
        if (!isset($_COOKIE['email_user'])) {
            header("Location: http://" . $_SERVER['SERVER_NAME'] . "/PhpRegistroScuolaNetBeans/errorPage.php");
        }
        ?>
        <form method="post" id="mailUserForm"
              action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <table id="mailUserTable">
                <tr>
                    <th>Invia Email</th>
                    <th>Agenda indirizzi Email</th>
                    <th>Crea Pdf</th>
                </tr>
                <tr>
                    <td valign="top"><img id="sendPHPMailerEmail"
                                          src="images/send_email_user_letter.png" title="Invia Email"
                                          width="48" height="48" /><br> <select name="selectUserEmailId"
                                          id="selectUserEmailId">
                                              <?php
                                              $result = $mySqlFunctions->getNewEmailId($_COOKIE['id_utente']);
                                              while ($row = mysql_fetch_assoc($result)) {
                                                  ?>
                                <option>
                                    <?php echo $mySqlFunctions->getInfoEmail($_COOKIE['emailId']) ?>
                                </option>
                            <?php }
                            ?>

                        </select>
                    </td>
                    <td><?php include 'frames/agendaUtentiEMailFrame.php'; ?>
                    </td>
                    <td valign="top"><IMG name="actionCreatePdf" id="createPdf"
                                          src="images/Adobe_PDF_icon64.png" title="Crea Pdf" width="48"
                                          height="48" />
                    </td>
                </tr>
                <tr>
                    <td align="center" colspan="3">
                        <table id="logoTitleFrameTable">

                            <tr>
                                <td id="emailTd" valign="top" colspan="2" align="right"><strong>To:</strong>
                                </td>
                                <?php $to = 'Gli indirizzi email dei destinatari visibili qui!'; ?>
                                <td colspan="2"><strong><textarea rows="4" cols="50" id="textareaTo"
                                                                  title="<?php echo $to ?>" name="to">
                                                                      <?php echo $mySqlFunctions->getToRecipients($_COOKIE['emailId']) ?>
                                        </textarea></strong>
                                </td>
                            </tr>
                            <tr>
                                <td id="emailTd" valign="top" colspan="2" align="right"><strong>Cc:</strong>
                                </td>
                                <?php $cc = 'Gli indirizzi email dei destinatari cui inviare la email in copia, qui!'; ?>
                                <td colspan="2"><textarea rows="4" cols="50" id="textareaCc"
                                                          title="<?php echo $cc ?>" name="cc">
                                                              <?php echo $mySqlFunctions->getCcRecipients($_COOKIE['emailId']) ?>
                                    </textarea>
                                </td>
                            </tr>
                            <tr>

                                <td id="emailTd" valign="top" colspan="2" align="right"><strong>Bcc:</strong>
                                </td>
                                <?php $bcc = 'Gli indirizzi email dei destinatari nascosti, qui!'; ?>
                                <td colspan="2"><textarea rows="4" cols="50" id="textareaBcc"
                                                          title="<?php echo $bcc ?>" name="bcc">
                                                              <?php echo $mySqlFunctions->getBccRecipients($_COOKIE['emailId']) ?>
                                    </textarea>
                                </td>
                            </tr>
                            <tr>
                                <td id="emailTd" valign="top" colspan="2" align="right"><strong>Subject:</strong>
                                </td>
                                <?php $subject = 'L\'oggetto dell\'email, qui!' ?>
                                <td colspan="2"><textarea id="subjectArea" 
                                                          class="editor"
                                                          title="<?php echo $subject ?>" name="subject">
                                                              <?php echo $mySqlFunctions->getEmailSubject($_COOKIE['emailId']) ?>
                                    </textarea>
                                </td>
                            </tr>
                            <tr>
                                <td id="emailTd" valign="top" colspan="2" align="right"><strong>Body:</strong>
                                </td>
                                <?php $body = 'Il tuo messaggio, qui!'; ?>
                                <td colspan="2"><textarea id="bodyArea"
                                                          title="<?php echo $body ?>" name="body">
                                                              <?php echo $mySqlFunctions->getEmailBody($_COOKIE['emailId']) ?>
                                    </textarea>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </form>
        <?php
        if (isset($_COOKIE['actionEmail'])) {
            //setcookie('actionEmail',"",time()-3600);
            if (isset($_COOKIE['status'])) {
                ?>
                <div id="dialogEmail" title="Email Message">
                    <p>
                        <?php echo $_COOKIE['status'] ?>
                    </p>
                </div>
                <?php
            }
        }
        ?>

    </body>
</html>
