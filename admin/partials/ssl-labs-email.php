<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>SSL Labs Server Test Results</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            min-width: 100%!important;
        }

        .content {
            width: 100%;
            max-width: 700px;
        }

        a {
            text-decoration: underline;
            color: #333333;
        }

        a:hover {
            text-decoration: none;
        }

        @media (max-width: 568px) {
            .titleheader {
                padding: 10px 0;
            }

            table.data {
                font-size: 12px;
            }
        }

        /* Width fix for Apple Mail */
        /*@media only screen and (min-device-width: 701px) {
            .content {width: 700px !important;}
        }*/
    </style>
</head>
<body bgcolor="#f7f7f7" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<table bgcolor="#f7f7f7" width="100%" cellpadding="0" cellspacing="0" border="0">
    <!--
        <tr>
            <td height="20"></td>
        </tr>
    -->
    <tr>
        <td valign="top">
            <!-- Start main table -->
            <table class="content" width="700" bgcolor="#eeeeee" cellpadding="0" cellspacing="0" border="0" align="center">
                <tr>
                    <td bgcolor="#999999" height="60"></td>
                    <td class="titleheader" bgcolor="#999999"><font face="Arial" size="5" color="#fff">SSL Quality Test Results</font></td>
                    <td bgcolor="#999999"></td>
                </tr>

                <tr>
                    <td width="20" height="20"></td>
                    <td></td>
                    <td width="20"></td>
                </tr>
                <tr>
                    <td width="20"></td>
                    <td>
                        <!-- Start table to add spacing between the elements -->
                        <table width="100%">
                            <tr>
                                <td><font face="Arial" color="#333333">The quality of your SSL configuration is not of at your expected standard.  It is recommended to check the documentation at <a href="https://www.ssllabs.com/index.html"><font face="Arial" color="#333333">Qualys SSL Labs</font></a> to improve your rating.</font></td>
                            </tr>
                            <tr>
                                <td height="20"></td>
                            </tr>
                            <tr>
                                <td>
                                    <!-- Start first data table -->
                                    <table class="data" width="100%" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0">
                                        <tr>
                                            <td bgcolor="#e7e7e7" width="20" height="40"></td>
                                            <td bgcolor="#e7e7e7" valign="middle"><font face="Arial" color="#333333">TIME RUN:</font></td>
                                            <td width="20"></td>
                                            <td valign="middle"><font face="Arial" color="#333333"><?php echo date("d / m / Y @ H:i" , $response->startTime / 1000); ?></font></td>
                                        </tr>

                                        <tr>
                                            <td bgcolor="#cccccc" height="1"></td>
                                            <td bgcolor="#cccccc" height="1"></td>
                                            <td bgcolor="#cccccc" height="1"></td>
                                            <td bgcolor="#cccccc" height="1"></td>
                                        </tr>

                                        <tr>
                                            <td bgcolor="#e7e7e7" width="20" height="40"></td>
                                            <td bgcolor="#e7e7e7"><font face="Arial" color="#333333">ENDPOINTS:</font></td>
                                            <td width="20"></td>
                                            <td><font face="Arial" color="#333333"><?php echo count( $response->endpoints) ; ?></font></td>
                                        </tr>
                                    </table><!-- end first table -->
                                </td>
                            </tr>
                            <tr>
                                <td height="20"></td>
                            </tr>
                            <tr>
                                <td>
                                    <!-- Start grade table -->
                                    <table class="data" width="100%" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0">
                                        <tr>
                                            <td bgcolor="#e7e7e7" width="20" height="40"></td>
                                            <td bgcolor="#e7e7e7"><font face="Arial" color="#333333">GRADE</font></td>
                                            <td bgcolor="#e7e7e7" width="20"></td>
                                            <td bgcolor="#e7e7e7"><font face="Arial" color="#333333">IP ADDRESS</font></td>
                                            <td bgcolor="#e7e7e7" width="20"></td>
                                            <td bgcolor="#e7e7e7"></td>
                                        </tr>
                                        <?php foreach($response->endpoints as $endpoint): ?>
                                            <?php switch(strtoupper($endpoint->grade)){
                                                case 'A+':
                                                case 'A-':
                                                case 'A':
                                                    $color = '#00A500';
                                                    break;
                                                case 'B':
                                                    $color = '#68D035';
                                                    break;
                                                case 'C':
                                                    $color = '#F8CF00';
                                                    break;
                                                case 'D':
                                                    $color = '#FFA901';
                                                    break;
                                                case 'E':
                                                    $color = '#FF7701';
                                                    break;
                                                default:
                                                    $color = '#FF4D41';
                                                    break;
                                            } ?>
                                        <tr>
                                            <td width="20" height="40"></td>
                                            <td>
                                                <!-- Start grade -->
                                                <table width="72" cellpadding="0" cellspacing="0" border="0">
                                                    <tr>
                                                        <td height="20"></td>
                                                    </tr>
                                                    <tr>
                                                        <td height="72" valign="middle" align="center" bgcolor="<?php echo $color?>"><font face="Arial" size="7" color="#ffffff"><?php echo $endpoint->grade ?></font></td>
                                                    </tr>
                                                    <tr>
                                                        <td height="20"></td>
                                                    </tr>
                                                </table><!-- End grade -->
                                            </td>
                                            <td width="20"></td>
                                            <td><font face="Arial" color="#333333"><?php echo $endpoint->ipAddress ?></font></td>
                                            <td width="20"></td>
                                            <td><a href="https://www.ssllabs.com/ssltest/analyze.html?d=<?php echo str_replace("https://","",$site_url)?>&s=<?php echo $endpoint->ipAddress ?>"><font face="Arial" color="#333333">View detailed report on SSL Labs</font></a></td>
                                        </tr>

                                        <tr>
                                            <td bgcolor="#cccccc" height="1"></td>
                                            <td bgcolor="#cccccc" height="1"></td>
                                            <td bgcolor="#cccccc" height="1"></td>
                                            <td bgcolor="#cccccc" height="1"></td>
                                            <td bgcolor="#cccccc" height="1"></td>
                                            <td bgcolor="#cccccc" height="1"></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </table><!-- end grade table -->
                                </td>
                            </tr>
                            <tr>
                                <td height="20"></td>
                            </tr>
                            <tr>
                                <td><font face="Arial" color="#333333">Scan provided by <a href="https://www.ssllabs.com/index.html"><font face="Arial" color="#333333">Qualys SSL Labs</font></a> | Plugin by <a href="http://www.createful.com"><font face="Arial" color="#333333">Createful</font></a></font></td>
                            </tr>
                        </table><!-- end table to add spacing between the elements -->
                    </td>
                    <td width="20"></td>
                </tr>
                <tr>
                    <td width="20" height="20"></td>
                    <td></td>
                    <td width="20"></td>
                </tr>


            </table>
            <!-- End main table -->
        </td>
    </tr>
</table><!-- End of wrapper table -->
</body>
</html>