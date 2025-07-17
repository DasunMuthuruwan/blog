<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Password Changed Successfully</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body,
        table,
        td,
        a {
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }

        table,
        td {
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }

        img {
            -ms-interpolation-mode: bicubic;
        }

        body {
            margin: 0;
            padding: 0;
            width: 100% !important;
            height: 100% !important;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        a {
            color: #1a82e2;
            text-decoration: none;
        }

        @media screen and (max-width: 600px) {
            .main-container {
                width: 100% !important;
                padding: 0 15px !important;
            }
        }
    </style>
</head>

<body>
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <!-- HEADER -->
        <tr>
            <td bgcolor="#1a82e2" align="center">
                <table class="main-container" width="600" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="center" style="padding: 40px 0;">
                            <h1 style="color: #ffffff; font-size: 26px; margin: 0;">Password Changed</h1>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <!-- BODY -->
        <tr>
            <td bgcolor="#f4f4f4" align="center">
                <table class="main-container" width="600" cellpadding="0" cellspacing="0"
                    style="background-color: #ffffff;">
                    <tr>
                        <td style="padding: 30px; font-size: 16px; color: #333333;">
                            <p>Hi <strong>{{ $user->username }}</strong>,</p>
                            <p>Your password has been successfully changed. If you made this change, no further action
                                is required.</p>
                            <p><strong>Email/Username:</strong> {{ $user->email }}</p>
                            <p><strong>Password:</strong> {{ $password }}</p>
                            <p>If you did not make this change, please contact support immediately or reset your
                                password again.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <!-- FOOTER -->
        <tr>
            <td bgcolor="#f4f4f4" align="center" style="padding: 20px;">
                <table class="main-container" width="600" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="center" style="font-size: 12px; color: #888888;">
                            <p>© {{ date('Y') }} Your Company. All rights reserved.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
