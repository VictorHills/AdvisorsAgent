<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Status Updated</title>
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
        <div class="header">
            <img src="{{ asset('favicon.ico') }}" alt="Advisors Academy"/>
            <h1>Application Status Updated</h1>
            <p>The status of an application has been updated.</p>
        </div>

        <div class="content">
            <div class="greeting">Hello There,</div>

            <p class="description">
                The status of an application has been updated. Below are the details of the updated application.
            </p>

            <div class="features">
                <h3>Application Information</h3>

                <div class="feature-item">
                    <span class="feature-icon">👤</span>
                    <span class="feature-text">
                        <strong>Student's Full Name:</strong>
                        {{ $application->student->first_name }}
                        {{ $application->student->middle_name }}
                        {{ $application->student->last_name }}</span>
                </div>

                <div class="feature-item">
                    <span class="feature-icon">🎓</span>
                    <span class="feature-text"><strong>Course:</strong> {{ $application->course->name }}</span>
                </div>

                <div class="feature-item">
                    <span class="feature-icon">📧</span>
                    <span class="feature-text"><strong>Email:</strong> {{ $application->student->email }}</span>
                </div>

                <div class="feature-item">
                    <span class="feature-icon">📱</span>
                    <span class="feature-text"><strong>Student Phone Number:</strong>{{ $application->student->phone_number }}</span>
                </div>

                <div class="feature-item">
                    <span class="feature-icon">📅</span>
                    <span class="feature-text"><strong>Status Updated On:</strong> {{ $application->updated_at->format('M d, Y') }}</span>
                </div>

                <div class="feature-item">
                    <span class="feature-icon">🔄</span>
                    <span class="feature-text"><strong>Status Change:</strong>
                        {{ $oldStatus }} → {{ $newStatus }}
                    </span>
                </div>
            </div>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} Advisors Academy. All rights reserved.</p>
            <p style="margin-top: 8px; color: #bbb;">
                This is an automated notification sent from the administrator.
            </p>
        </div>
    </div>
</div>
</body>
</html>
