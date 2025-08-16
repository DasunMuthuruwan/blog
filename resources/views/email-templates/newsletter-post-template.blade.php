<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>New Blog Post</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
      background-color: #f9fafc;
      color: #333;
    }

    .email-wrapper {
      width: 100%;
      background-color: #f9fafc;
      padding: 30px 15px;
    }

    .email-content {
      max-width: 600px;
      margin: 0 auto;
      background-color: #ffffff;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }

    .email-header {
      background: linear-gradient(135deg, #007BFF, #00c6ff);
      color: #ffffff;
      padding: 25px 20px;
      text-align: center;
      font-size: 26px;
      font-weight: bold;
      letter-spacing: 0.5px;
    }

    .email-body {
      padding: 25px;
    }

    .post-image {
      width: 100%;
      max-height: 320px;
      object-fit: cover;
      border-radius: 8px;
    }

    .post-title {
      font-size: 24px;
      color: #111111;
      margin: 20px 0 12px;
      font-weight: 700;
      line-height: 1.3;
    }

    .divider {
      border-top: 1px solid #eeeeee;
      margin: 20px 0;
    }

    .post-description {
      font-size: 16px;
      color: #555555;
      line-height: 1.6;
    }

    .read-more {
      display: inline-block;
      margin-top: 25px;
      padding: 14px 28px;
      background: linear-gradient(135deg, #007BFF, #00c6ff);
      color: #ffffff !important;
      text-decoration: none;
      border-radius: 50px;
      font-weight: bold;
      font-size: 16px;
      transition: background 0.3s ease;
    }

    .read-more:hover {
      background: linear-gradient(135deg, #0056b3, #0090cc);
    }

    .email-footer {
      text-align: center;
      padding: 20px;
      font-size: 13px;
      color: #888888;
      background-color: #fafafa;
      border-top: 1px solid #eeeeee;
    }

    .email-footer a {
      color: #007BFF;
      text-decoration: none;
    }

    @media screen and (max-width: 600px) {
      .post-title {
        font-size: 20px;
      }
      .post-description {
        font-size: 15px;
      }
      .read-more {
        padding: 12px 22px;
        font-size: 15px;
      }
    }
  </style>
</head>
<body>
  <div class="email-wrapper">
    <div class="email-content">
      <div class="email-header">
        📰 New Blog Post Alert!
      </div>
      <div class="email-body">
        <img src='{{ url('storage/images/posts/' . $data['feature_image']) }}' alt="Post Image" class="post-image" />
        <h2 class="post-title">{{ $data['title'] }}</h2>
        <div class="divider"></div>
        <p class="post-description">
          {!! Str::ucfirst(words($data['content'], 43)) !!}
        </p>
        <a href="{{ route('read_post', $data['slug']) }}" class="read-more">👉 Read Full Article</a>
      </div>
      <div class="email-footer">
        You are receiving this email because you subscribed to our blog updates.<br/>
        <a href="{{ route('privacy_policy') }}">Privacy Policy</a><br/> 
        <a href="{{ route('about_us') }}">About Us</a><br/>
        &copy; {{ date('Y') }} {{config('app.name')}}. All rights reserved.
      </div>
    </div>
  </div>
</body>
</html>
