<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agreement Signing - Advisors Academy</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Helvetica Neue', sans-serif;
            background: linear-gradient(135deg, #f8f8f8 0%, #f0f0f0 100%);
            color: #1a1a1a;
            line-height: 1.6;
        }

        .container {
            max-width: 600px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            padding: 40px 30px;
            text-align: center;
            color: white;
            border-bottom: 2px solid #3d3d3d;
        }

        .header img {
            max-width: 150px;
            height: auto;
            margin-bottom: 20px;
            display: inline-block;
        }

        .header h1 {
            font-size: 28px;
            font-weight: 600;
            letter-spacing: -0.5px;
            margin: 0;
        }

        .header p {
            font-size: 14px;
            color: #b0b0b0;
            margin-top: 8px;
        }

        .content {
            padding: 45px 35px;
            text-align: center;
        }

        .greeting {
            font-size: 16px;
            color: #1a1a1a;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .description {
            color: #666;
            margin-bottom: 35px;
            font-size: 15px;
            line-height: 1.6;
        }

        .features {
            background: #f5f5f5;
            border-radius: 10px;
            padding: 25px;
            margin: 35px 0;
            text-align: left;
        }

        .features h3 {
            font-size: 16px;
            color: #1a1a1a;
            margin-bottom: 15px;
            font-weight: 600;
            text-align: center;
        }

        .feature-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 12px;
        }

        .feature-icon {
            display: inline-block;
            margin-right: 12px;
            font-size: 18px;
        }

        .feature-text {
            font-size: 14px;
            color: #666;
            line-height: 1.5;
        }

        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            color: white;
            text-decoration: none;
            padding: 14px 40px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 15px;
            margin: 25px 0;
            transition: all 0.3s ease;
        }

        .cta-button:hover {
            opacity: 0.9;
        }

        .support-note {
            background: #f5f5f5;
            padding: 15px;
            border-radius: 8px;
            margin-top: 25px;
            font-size: 13px;
            color: #666;
            line-height: 1.6;
        }

        .support-icon {
            display: inline-block;
            margin-right: 8px;
        }

        .footer {
            background: #f5f5f5;
            padding: 25px;
            text-align: center;
            font-size: 12px;
            color: #999;
            border-top: 1px solid #e5e5e5;
        }

        .footer p {
            margin: 4px 0;
        }

        .footer-links a {
            color: #1a1a1a;
            text-decoration: none;
            margin: 0 8px;
            font-size: 12px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="card">
        <!-- Header with Logo -->
        <div class="header">
            <img src="{{ asset('favicon.ico') }}" alt="Advisors Academy"/>
            <h1>Agreement Signing Required</h1>
            <p>Please review and sign your agreement</p>
        </div>

        <!-- Main Content -->
        <div class="content">
            <div class="greeting">Hello, {{ $user_full_name }}!</div>

            <p class="description">
                To continue your partnership with Advisors Academy, we require you to review and sign the
                agent agreement. This agreement outlines the terms and conditions of our collaboration.
            </p>

            <!-- Steps -->
            <div class="features">
                <h3>How It Works</h3>
                <div class="feature-item">
                    <span class="feature-icon">1️⃣</span>
                    <span class="feature-text">Click the button below to open the agreement document</span>
                </div>
                <div class="feature-item">
                    <span class="feature-icon">2️⃣</span>
                    <span class="feature-text">Review the terms and conditions carefully</span>
                </div>
                <div class="feature-item">
                    <span class="feature-icon">3️⃣</span>
                    <span class="feature-text">Sign the agreement electronically using JotForm Sign</span>
                </div>
                <div class="feature-item">
                    <span class="feature-icon">✅</span>
                    <span class="feature-text">Once signed, you'll receive a confirmation copy via email</span>
                </div>
            </div>

            <!-- CTA Button -->
            <a href="{{ $signing_url }}" class="cta-button">Sign Agreement</a>

            <p class="description">
                If you have any questions about the agreement or need clarification on any of the terms,
                please don't hesitate to reach out to our team before signing.
            </p>

            <!-- Support Note -->
            <div class="support-note">
                <span class="support-icon">💬</span>
                <strong>Need Help?</strong>
                If you experience any issues with the signing process, please contact our support team at
                support@advisorsacademy.com
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>&copy; {{ date('Y') }} Advisors Academy. All rights reserved.</p>
            <p style="margin-top: 8px; color: #bbb;">
                This is an automated message, please do not reply to this email.
            </p>
        </div>
    </div>
</div>
</body>
</html>
