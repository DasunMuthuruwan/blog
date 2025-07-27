<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Contact Form Message</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
      background: #f5f5f5;
    }

    .email-container {
      max-width: 600px;
      margin: 0 auto;
      background: #ffffff;
      padding: 20px;
      border: 1px solid #e0e0e0;
    }

    .header {
      background-color: #007BFF;
      color: white;
      padding: 15px;
      text-align: center;
      font-size: 20px;
    }

    .content {
      padding: 20px;
    }

    .content p {
      margin: 10px 0;
    }

    .footer {
      text-align: center;
      font-size: 12px;
      color: #999999;
      padding: 15px;
    }

    @media screen and (max-width: 600px) {
      .email-container {
        width: 100% !important;
        padding: 10px !important;
      }

      .content {
        padding: 10px !important;
      }
    }
  </style>
</head>
<body>
  <div class="email-container">
    <div class="header">
      Contact Form Message
    </div>
    <div class="content">
      <p><strong>Name:</strong> {{ $data['name'] }}</p>
      <p><strong>Email:</strong> {{ $data['email'] }}</p>
      <p><strong>Subject:</strong> {{ $data['subject'] }}</p>
      <p><strong>Message:</strong></p>
      <p>{{ $data['message'] }}</p>
    </div>
    <div class="footer">
      This email was generate automatically. Please do not reply directly.
    </div>
  </div>
</body>
</html>
