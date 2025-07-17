<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Reset Your Password</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <style>
    body, table, td, a {
      -webkit-text-size-adjust: 100%;
      -ms-text-size-adjust: 100%;
    }
    table, td {
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
      .btn {
        width: 100% !important;
        display: block !important;
      }
    }
  </style>
</head>
<body>
  <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <!-- HEADER -->
    <tr>
      <td bgcolor="#1a82e2" align="center">
        <table class="main-container" width="600" cellpadding="0" cellspacing="0" border="0">
          <tr>
            <td align="center" style="padding: 40px 0;">
              <h1 style="color: #ffffff; font-size: 28px; margin: 0;">Reset Your Password</h1>
            </td>
          </tr>
        </table>
      </td>
    </tr>

    <!-- BODY -->
    <tr>
      <td bgcolor="#f4f4f4" align="center">
        <table class="main-container" width="600" cellpadding="0" cellspacing="0" border="0" style="background-color: #ffffff;">
          <tr>
            <td style="padding: 30px 30px 10px 30px; font-size: 16px; line-height: 24px; color: #333333;">
              <p>Hello {{$user->name}},</p>
              <p>You recently requested to reset your password. Click the button below to proceed. If you didn’t make this request, you can safely ignore this email.</p>
            </td>
          </tr>
          <tr>
            <td align="center" style="padding: 20px 30px;">
              <a href="{{$actionLink}}" target="_blank" style="background-color: #1a82e2; color: #ffffff; padding: 14px 28px; font-size: 16px; border-radius: 5px; display: inline-block;" class="btn">Reset Password</a>
            </td>
          </tr>
          <tr>
            <td style="padding: 10px 30px 30px 30px; font-size: 14px; color: #666666;">
              <p>If that button doesn't work, copy and paste this link into your browser:</p>
              <p style="word-break: break-all;"><a href="{{$actionLink}}" target="_blank">Reset Password</a></p>
              <p>This link will expire in 60 minutes for your security.</p>
            </td>
          </tr>
        </table>
      </td>
    </tr>

    <!-- FOOTER -->
    <tr>
      <td bgcolor="#f4f4f4" align="center" style="padding: 30px 10px;">
        <table class="main-container" width="600" cellpadding="0" cellspacing="0" border="0">
          <tr>
            <td align="center" style="font-size: 12px; color: #999999;">
              <p style="margin: 0;">If you didn’t request a password reset, you can ignore this email or let us know.</p>
              <p style="margin: 5px 0 0;">© {{date('Y')}} Your Company. All rights reserved.</p>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>
