<?php
// Resend API Email Handler
// Sign up at https://resend.com and get your API key

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Your Resend API key (get this from https://resend.com/api-keys)
    $resend_api_key = "re_YOUR_API_KEY_HERE"; // Replace with your actual API key
    
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
    
    // Prepare email data for Resend API
    $email_data = [
        'from' => 'Portfolio <no-reply@yourdomain.com>', // Replace with your verified domain
        'to' => ['michaeltettey29@gmail.com'],
        'reply_to' => [$email],
        'subject' => "New Contact: $subject - from $name",
        'html' => $html_content
    ];
    
    // Send email via Resend API
    $curl = curl_init();
    
    curl_setopt_array($curl, [
        CURLOPT_URL => 'https://api.resend.com/emails',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode($email_data),
        CURLOPT_HTTPHEADER => [
            'Accept: application/json',
            'Authorization: Bearer ' . $resend_api_key,
            'Content-Type: application/json'
        ],
    ]);
    
    $response = curl_exec($curl);
    $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);
    
    if ($http_code == 200) {
        // Success - redirect to thank you page
        header("Location: thank-you.html");
        exit;
    } else {
        // Error
        http_response_code(500);
        $error_data = json_decode($response, true);
        echo "Sorry, there was an error sending your message. Please try again or contact me directly.";
        error_log("Resend API Error: " . $response);
    }
    
} else {
    http_response_code(403);
    echo "Invalid request method.";
}
?>