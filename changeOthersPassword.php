<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=MacRoman">
        <title>Change Others Password</title>

        <?php
        include 'functions/utilities_functions.php';
        include './functions/MySqlFunctionsClass.php';

        $mySqlFunctions = new MySqlFunctionsClass();
        ?>

        <?php
        setTitle('Cambia Password utenti');
        include 'frames/logoTitleFrame.php';
        ?>

        <link href="css/PhpRegistroWeb.css" rel="stylesheet">
        <script>
            $(function () {
                pwd = 'newPassword';
                pwd_repeat = 'repeatPassword';
            });
        </script>

    </head>
    <body>
        <?php
        $listaUtentiToChangePassword = $mySqlFunctions->listaUtentiToChangePassword();
        if (mysql_num_rows($listaUtentiToChangePassword) == 0) {
            echo '<h1> Non vi sono richieste  di cambiamento password!</h1>';
            die();
        }
        ?>

        <form method="post" id="changeOthersPasswordForm"
              action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <table border="0" id="userMenuTable" >
                <tr align="center">
                    <td colspan="6"><img src="images/LogoPhpRegistroWeb.png"
                                         width="283" height="100" />
                    </td>
                </tr>
                <tr>
                    <td align="right"><strong>Richieste:</strong></td>
                    <td colspan="4"><?php
                        setFrameContainer(1);
                        include 'frames/utentiSelectFrame.php';
                        ?>
                    </td>
                    <td><input type="hidden" name="user_email"
                               value="<?php echo $mySqlFunctions->getUserEmail($_COOKIE['selectedRecipient']) ?>">
                    </td>
                </tr>
                <tr>
                    <td align="right"><strong>Old Password:</strong></td>
                    <td colspan="4"><input name="oldpassword" type="text" id="oldpasswordId" size="40"
                                           value="<?php echo $mySqlFunctions->retrievePassword($_COOKIE['selectedRecipient']) ?>"/>
                    </td>
                    <td colspan="2"><span class="error"> <?php
                            $oldpasswordErr = isset($_COOKIE['oldpasswordErr']) ? $_COOKIE['oldpasswordErr'] : '*';
                            echo $oldpasswordErr;
                            ?> </span>
                    </td>
                </tr>
                <tr>
                    <td align="right"><strong>New Password:</strong></td>
                    <td colspan="4"><input name="password" type="text" id="newPassword" size="40"/></td>
                    <td colspan="2"><span class="error"> <?php
                            $passwordErr = isset($_COOKIE['newpasswordErr']) ? $_COOKIE['newpasswordErr'] : '*';
                            echo $passwordErr;
                            ?> </span>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <div id="passwordStrengthOther"></div> 
                        <script language="javascript"
                                type="text/javascript">
                                    jQuery(function () {
                                        jQuery("#newPassword").passwordStrength({
                                            targetDiv: 'passwordStrengthOther',
                                            text: {
                                                year: 'year|years'
                                            }
                                        });
                                    });
                        </script>
                    </td>
                </tr>			
                <tr>
                    <td align="right"><strong>Repeat New Password:</strong></td>
                    <td colspan="4"><input name="password_one" type="text" id="repeatPassword" size="40"/></td>
                    <td colspan="2"><span class="error"> <?php
                            $repeatPasswordErr = isset($_COOKIE['repeatPasswordErr']) ? $_COOKIE['repeatPasswordErr'] : '*';
                            echo $repeatPasswordErr;
                            ?> </span>
                    </td>
                </tr>
                <tr>
                    <td colspan="5" align="right"><img name="actionChangeOtherPassword"
                                                       src="images/key_green.png" width="64" height="64"
                                                       title="Cambia Password" id="actionChangeOthersPasswordId" />
                        <input type="hidden" name="countRowPending" value="<?php echo $mySqlFunctions->countPasswordToChangePending(1, 1); ?>">
                    </td>
                </tr>
                <tr>
                    <td colspan="4"><img src="images/Help.png" width="32" height="32"
                                         id="passwordInfo" title="Formato Password">Genera Passwords</td>
                </tr>
            </table>
        </form>
        <?php
        if (isset($_COOKIE['message'])) {
            ?>
            <div id="dialogEmail" title="Change Password">
                <p><h2>
                    <?php echo $_COOKIE['message'] ?>
                    <?php
                    if (isset($_COOKIE['status'])) {
                        ?>
                        <?php echo $_COOKIE['status'] ?>
                        <?php
                    }
                    ?>
                </h2>
            </div>
            <?php
        }
        ?>
    </body>
</html>
