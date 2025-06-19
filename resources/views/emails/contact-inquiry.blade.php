<!-- resources/views/emails/contact-inquiry.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Inquiry</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            background: #9333ea;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 10px 10px 0 0;
            margin: -20px -20px 20px -20px;
        }
        .content {
            padding: 20px 0;
        }
        .info-row {
            margin-bottom: 15px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        .label {
            font-weight: bold;
            color: #666;
            display: inline-block;
            width: 120px;
        }
        .message-box {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
        }
        .footer {
            text-align: center;
            padding-top: 20px;
            color: #666;
            font-size: 14px;
        }
        .button {
            display: inline-block;
            padding: 10px 30px;
            background: #9333ea;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>New Contact Inquiry</h1>
        </div>
        
        <div class="content">
            <p>You have received a new contact inquiry from your website.</p>
            
            <div class="info-row">
                <span class="label">Name:</span>
                <span>{{ $inquiry->name }}</span>
            </div>
            
            <div class="info-row">
                <span class="label">Email:</span>
                <span>{{ $inquiry->email }}</span>
            </div>
            
            @if($inquiry->phone)
            <div class="info-row">
                <span class="label">Phone:</span>
                <span>{{ $inquiry->phone }}</span>
            </div>
            @endif
            
            <div class="info-row">
                <span class="label">Service:</span>
                <span>{{ $serviceName }}</span>
            </div>
            
            <div class="info-row">
                <span class="label">Submitted:</span>
                <span>{{ $inquiry->created_at->format('F j, Y - g:i A') }}</span>
            </div>
            
            <div class="message-box">
                <h3>Message:</h3>
                <p>{{ $inquiry->message }}</p>
            </div>
            
            <center>
                <a href="{{ $adminUrl }}" class="button">View in Admin Panel</a>
            </center>
        </div>
        
        <div class="footer">
            <p>This email was sent from KL Mobile Events contact form.</p>
        </div>
    </div>
</body>
</html>