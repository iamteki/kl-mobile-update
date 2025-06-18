<!-- resources/views/emails/contact-confirmation.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank you for contacting us</title>
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
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
            margin: -20px -20px 30px -20px;
        }
        .content {
            padding: 20px 0;
        }
        .message-summary {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            padding-top: 30px;
            color: #666;
            font-size: 14px;
            border-top: 1px solid #eee;
        }
        .social-links {
            margin-top: 20px;
        }
        .social-links a {
            margin: 0 10px;
            color: #9333ea;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Thank You for Contacting Us!</h1>
        </div>
        
        <div class="content">
            <p>Dear {{ $inquiry->name }},</p>
            
            <p>Thank you for reaching out to KL Mobile Events. We have received your inquiry and appreciate your interest in our services.</p>
            
            <p>Our team will review your message and get back to you within 24-48 hours.</p>
            
            <div class="message-summary">
                <h3>Your Inquiry Summary:</h3>
                <p><strong>Service Interested In:</strong> {{ $serviceName }}</p>
                <p><strong>Your Message:</strong><br>{{ $inquiry->message }}</p>
            </div>
            
            <p>In the meantime, feel free to:</p>
            <ul>
                <li>Browse our website for more information about our services</li>
                <li>Check out our portfolio of past events</li>
                <li>Follow us on social media for the latest updates</li>
            </ul>
            
            <p>If you have any urgent questions, please don't hesitate to call us.</p>
            
            <p>Best regards,<br>
            The KL Mobile Events Team</p>
        </div>
        
        <div class="footer">
            <p>KL Mobile Events - Creating Unforgettable Experiences</p>
            <div class="social-links">
                <a href="#">Facebook</a> |
                <a href="#">Instagram</a> |
                <a href="#">LinkedIn</a>
            </div>
            <p style="font-size: 12px; margin-top: 20px;">
                This is an automated confirmation email. Please do not reply to this message.
            </p>
        </div>
    </div>
</body>
</html>