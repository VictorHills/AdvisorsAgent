<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your OTP Code - Advisors Academy</title>
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

        .otp-box {
            background: linear-gradient(135deg, #f8f8f8 0%, #f5f5f5 100%);
            border: 2px solid #e5e5e5;
            border-radius: 10px;
            padding: 30px 20px;
            margin: 35px 0;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.03);
        }

        .otp-label {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #999;
            margin-bottom: 12px;
            font-weight: 600;
        }

        .otp-code {
            font-size: 52px;
            font-weight: 700;
            letter-spacing: 6px;
            color: #1a1a1a;
            font-family: 'Monaco', 'Courier New', monospace;
            word-break: break-all;
            line-height: 1.4;
        }

        .instructions {
            color: #1a1a1a;
            font-size: 14px;
            margin-top: 25px;
            font-weight: 500;
        }

        .expiry-warning {
            background: linear-gradient(135deg, #fffbf0 0%, #fff5e6 100%);
            border-left: 4px solid #ff9800;
            padding: 16px 18px;
            margin-top: 30px;
            border-radius: 6px;
            color: #e65100;
            font-size: 13px;
            line-height: 1.6;
        }

        .expiry-warning strong {
            display: block;
            margin-bottom: 4px;
            font-weight: 600;
        }

        .divider {
            height: 1px;
            background: #e5e5e5;
            margin: 30px 0;
        }

        .security-note {
            background: #f5f5f5;
            padding: 15px;
            border-radius: 8px;
            margin-top: 25px;
            font-size: 13px;
            color: #666;
            line-height: 1.6;
        }

        .security-icon {
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
            <!-- Added logo to the email header -->
            <img src="{{ config('app.logo_url') ?? 'https://your-domain.com/logo.png' }}" alt="Advisors Academy" />
            <h1>Verify Your Account</h1>
            <p>Your One-Time Password (OTP)</p>
        </div>

        <!-- Main Content -->
        <div class="content">
            <div class="greeting">Hello, {{ $user_full_name }}</div>

            <p class="description">
                You've requested to verify your account with Advisors Academy.
                Use the code below to complete your verification:
            </p>

            <!-- OTP Display Box -->
            <div class="otp-box">
                <div class="otp-label">Your OTP Code</div>
                <div class="otp-code">{{ $otp }}</div>
            </div>

            <p class="instructions">
                Enter this code in the verification field to confirm your identity.
            </p>

            <!-- Expiry Warning -->
            <div class="expiry-warning">
                <strong>⏱️ Valid for 10 minutes</strong>
                This code will expire in 10 minutes. Do not share this code with anyone.
            </div>

            <!-- Security Note -->
            <div class="security-note">
                <span class="security-icon">🔒</span>
                <strong>Security Note:</strong> Advisors Academy will never ask for this code via email or phone.
                If you didn't request this code, please ignore this email.
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>&copy; {{ date('Y') }} Advisors Academy. All rights reserved.</p>
            <p style="margin-top: 8px; color: #bbb;">This is an automated message, please do not reply to this email.</p>
        </div>
    </div>
</div>
</body>
</html>
