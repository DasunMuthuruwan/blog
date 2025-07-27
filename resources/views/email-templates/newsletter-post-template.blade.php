<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>New Blog Post</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
      background-color: #f4f4f4;
    }

    .email-wrapper {
      width: 100%;
      background-color: #f4f4f4;
      padding: 20px 0;
    }

    .email-content {
      max-width: 600px;
      margin: 0 auto;
      background-color: #ffffff;
      border-radius: 6px;
      overflow: hidden;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .email-header {
      background-color: #007BFF;
      color: #ffffff;
      padding: 20px;
      text-align: center;
      font-size: 24px;
      font-weight: bold;
    }

    .email-body {
      padding: 20px;
    }

    .post-image {
      width: 100%;
      max-height: 300px;
      object-fit: cover;
      border-radius: 4px;
    }

    .post-title {
      font-size: 22px;
      color: #333333;
      margin: 20px 0 10px;
    }

    .post-description {
      font-size: 16px;
      color: #555555;
      line-height: 1.5;
    }

    .read-more {
      display: inline-block;
      margin-top: 20px;
      padding: 12px 20px;
      background-color: #007BFF;
      color: #ffffff;
      text-decoration: none;
      border-radius: 4px;
      font-weight: bold;
    }

    .email-footer {
      text-align: center;
      padding: 20px;
      font-size: 12px;
      color: #999999;
    }

    @media screen and (max-width: 600px) {
      .post-title {
        font-size: 20px;
      }

      .post-description {
        font-size: 15px;
      }

      .read-more {
        padding: 10px 16px;
        font-size: 14px;
      }
    }
  </style>
</head>
<body>
  <div class="email-wrapper">
    <div class="email-content">
      <div class="email-header">
        📰 New Blog Post Just Published!
      </div>
      <div class="email-body">
        <img src='{{ asset("storage/images/posts/{$data['feature_image']}") }}' alt="Post Image" class="post-image" />
        <h2 class="post-title">{{ $data['title'] }}</h2>
        <p class="post-description">
          {!! Str::ucfirst(words($data['content'], 43)) !!}
        </p>
        <a href="{{ route('read_post', $data['slug']) }}" class="read-more">Read Full Article</a>
      </div>
      <div class="email-footer">
        You are receiving this email because you subscribed to our blog updates.<br/>
        &copy; {{ date('Y') }} Your Company. All rights reserved.
      </div>
    </div>
  </div>
</body>
</html>
