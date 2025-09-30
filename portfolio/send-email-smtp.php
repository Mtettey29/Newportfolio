<?php
// SMTP Email Handler using PHPMailer
// Works with Gmail, Outlook, Yahoo, or any SMTP provider

// Include PHPMailer (download from https://github.com/PHPMailer/PHPMailer)
// require_once 'vendor/autoload.php'; // If using Composer
// OR include files manually:
require_once 'PHPMailer/src/PHPMailer.php';
require_once 'PHPMailer/src/SMTP.php';
require_once 'PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // SMTP Configuration - Update these with your email provider settings
    $smtp_config = [
        'host' => 'smtp.gmail.com',           // Gmail SMTP server
        'port' => 587,                        // Port for TLS
        'username' => 'michaeltettey29@gmail.com', // Your Gmail address
        'password' => '@#1MT3tt3y1',    // Your Gmail App Password (not regular password)
        'encryption' => PHPMailer::ENCRYPTION_STARTTLS
    ];
    
    // Alternative SMTP configs for other providers:
    /*
    // For Outlook/Hotmail:
    $smtp_config = [
        'host' => 'smtp-mail.outlook.com',
        'port' => 587,
        'username' => 'your-email@outlook.com',
        'password' => 'your-password',
        'encryption' => PHPMailer::ENCRYPTION_STARTTLS
    ];
    
    // For Yahoo:
    $smtp_config = [
        'host' => 'smtp.mail.yahoo.com',
        'port' => 587,
        'username' => 'your-email@yahoo.com',
        'password' => 'your-app-password',
        'encryption' => PHPMailer::ENCRYPTION_STARTTLS
    ];
    */
    
    // Get form data
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $subject = strip_tags(trim($_POST["subject"]));
    $message = trim($_POST["message"]);
    $source = isset($_POST["source"]) ? $_POST["source"] : "Portfolio Website";
    
    // Additional fields from contact page
    $company = isset($_POST["company"]) ? strip_tags(trim($_POST["company"])) : "";
    $phone = isset($_POST["phone"]) ? strip_tags(trim($_POST["phone"])) : "";
    $newsletter = isset($_POST["newsletter"]) ? "Yes" : "No";
    
    // Validate required fields
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        http_response_code(400);
        echo "Please fill in all required fields.";
        exit;
    }
    
    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "Please enter a valid email address.";
        exit;
    }
    
    try {
        // Create PHPMailer instance
        $mail = new PHPMailer(true);
        
        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host = $smtp_config['host'];
        $mail->SMTPAuth = true;
        $mail->Username = $smtp_config['username'];
        $mail->Password = $smtp_config['password'];
        $mail->SMTPSecure = $smtp_config['encryption'];
        $mail->Port = $smtp_config['port'];
        
        // Email settings
        $mail->setFrom($smtp_config['username'], 'Portfolio Contact Form');
        $mail->addAddress('michaeltettey29@gmail.com', 'Michael Tettey');
        $mail->addReplyTo($email, $name);
        
        // Email content
        $mail->isHTML(true);
        $mail->Subject = "New Contact: $subject - from $name";
        
        // Build HTML email content
        $html_content = "
        <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>
            <div style='background: #2E6F40; color: white; padding: 20px; text-align: center;'>
                <h2>New Contact Form Submission</h2>
                <p>From: $source</p>
            </div>
            <div style='padding: 20px; background: #f9f9f9;'>
                <table style='width: 100%; border-collapse: collapse;'>
                    <tr>
                        <td style='padding: 10px; border-bottom: 1px solid #ddd; font-weight: bold; width: 150px;'>Name:</td>
                        <td style='padding: 10px; border-bottom: 1px solid #ddd;'>$name</td>
                    </tr>
                    <tr>
                        <td style='padding: 10px; border-bottom: 1px solid #ddd; font-weight: bold;'>Email:</td>
                        <td style='padding: 10px; border-bottom: 1px solid #ddd;'>$email</td>
                    </tr>";
        
        if (!empty($company)) {
            $html_content .= "
                    <tr>
                        <td style='padding: 10px; border-bottom: 1px solid #ddd; font-weight: bold;'>Company:</td>
                        <td style='padding: 10px; border-bottom: 1px solid #ddd;'>$company</td>
                    </tr>";
        }
        
        if (!empty($phone)) {
            $html_content .= "
                    <tr>
                        <td style='padding: 10px; border-bottom: 1px solid #ddd; font-weight: bold;'>Phone:</td>
                        <td style='padding: 10px; border-bottom: 1px solid #ddd;'>$phone</td>
                    </tr>";
        }
        
        $html_content .= "
                    <tr>
                        <td style='padding: 10px; border-bottom: 1px solid #ddd; font-weight: bold;'>Subject:</td>
                        <td style='padding: 10px; border-bottom: 1px solid #ddd;'>$subject</td>
                    </tr>
                    <tr>
                        <td style='padding: 10px; border-bottom: 1px solid #ddd; font-weight: bold;'>Newsletter:</td>
                        <td style='padding: 10px; border-bottom: 1px solid #ddd;'>$newsletter</td>
                    </tr>
                </table>
                
                <div style='margin-top: 20px;'>
                    <h3 style='color: #2E6F40;'>Message:</h3>
                    <div style='background: white; padding: 15px; border-radius: 5px; border-left: 4px solid #2E6F40;'>
                        " . nl2br(htmlspecialchars($message)) . "
                    </div>
                </div>
            </div>
            <div style='background: #253D2C; color: white; padding: 15px; text-align: center; font-size: 12px;'>
                <p>This email was sent from your portfolio contact form</p>
                <p>Submitted on: " . date('F j, Y \a\t g:i A T') . "</p>
            </div>
        </div>";
        
        $mail->Body = $html_content;
        
        // Plain text version
        $text_content = "New Contact Form Submission from $source\n\n";
        $text_content .= "Name: $name\n";
        $text_content .= "Email: $email\n";
        if (!empty($company)) $text_content .= "Company: $company\n";
        if (!empty($phone)) $text_content .= "Phone: $phone\n";
        $text_content .= "Subject: $subject\n";
        $text_content .= "Newsletter: $newsletter\n\n";
        $text_content .= "Message:\n$message\n\n";
        $text_content .= "Submitted on: " . date('F j, Y \a\t g:i A T');
        
        $mail->AltBody = $text_content;
        
        // Send email
        $mail->send();
        
        // Success - redirect to thank you page
        header("Location: thank-you.html");
        exit;
        
    } catch (Exception $e) {
        http_response_code(500);
        echo "Sorry, there was an error sending your message. Please try again or contact me directly.";
        error_log("PHPMailer Error: " . $mail->ErrorInfo);
    }
    
} else {
    http_response_code(403);
    echo "Invalid request method.";
}
?>