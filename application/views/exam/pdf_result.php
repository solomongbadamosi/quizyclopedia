<table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="600" style="margin: auto;" class="email-container">
    <tr>
        <td style="background-color: #ffffff;">
            <h1 align="center"><u>QUIZYCLOPEDIA TEST</u></h1>
        </td>
    </tr>

    <tr>
        <td style="background-color: #ffffff;">
            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                <tr>
                    <td style="padding: 20px; font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555;">
                        <h3 style="margin: 0 0 10px; font-size: 25px; line-height: 30px; color: #333333; font-weight: normal;">Student Name: <strong><?php echo $name; ?></strong></h3>
                        <h3 style="margin: 0 0 10px; font-size: 25px; line-height: 30px; color: #333333; font-weight: normal;">School Name: <strong><?php echo $school; ?></strong></h3>
                        <h3 style="margin: 0 0 10px; font-size: 25px; line-height: 30px; color: #333333; font-weight: normal;">Examination: <strong><?php echo $examination; ?></strong></h3>
                        <h3 style="margin: 0 0 10px; font-size: 25px; line-height: 30px; color: #333333; font-weight: normal;">Examination Year: <strong><?php echo $year; ?></strong></h3>
                        <h3 style="margin: 0 0 10px; font-size: 25px; line-height: 30px; color: #333333; font-weight: normal;">Subject: <strong><?php echo $subject; ?></strong></h3>
                        <h3 style="margin: 0 0 10px; font-size: 25px; line-height: 30px; color: #333333; font-weight: normal;">Score: <strong><?php echo $this->session->userdata('score').'%'; ?></strong></h3>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 0 20px 20px;">
                        <!-- Button : BEGIN -->
                        <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" style="margin: auto;">
                            <tr>
                                <td class="button-td button-td-primary" style="border-radius: 4px; background: #222222;">
                                    <p style="background: #222222; font-family: sans-serif; font-size: 15px; line-height: 15px; padding: 13px 17px; color: #ffffff; display: block; border-radius: 4px;">Date: <?php echo date('l jS \of F Y h:i:s A'); ?></p>
                                    <p align="center" style="background: #222222; font-family: sans-serif; font-size: 15px; line-height: 15px; padding: 13px 17px; color: #ffffff; display: block; border-radius: 4px;">Copyright &copy; Quizyclopedia <?php echo date('Y'); ?></p>
                                </td>
                            </tr>
                        </table>
                        <!-- Button : END -->
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>