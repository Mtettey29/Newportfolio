<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
    
    // Email configuration
    $to = "michaeltettey29@gmail.com";
    $email_subject = "New Contact Form Submission from " . $source;
    
    // Build email content
    $email_content = "Name: $name\n";
    $email_content .= "Email: $email\n";
    if (!empty($company)) {
        $email_content .= "Company: $company\n";
    }
    if (!empty($phone)) {
        $email_content .= "Phone: $phone\n";
    }
    $email_content .= "Subject: $subject\n";
    $email_content .= "Newsletter Signup: $newsletter\n";
    $email_content .= "Source: $source\n\n";
    $email_content .= "Message:\n$message\n";
    
    // Email headers
    $email_headers = "From: $name <$email>\r\n";
    $email_headers .= "Reply-To: $email\r\n";
    $email_headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    
    // Send email
    if (mail($to, $email_subject, $email_content, $email_headers)) {
        // Redirect to thank you page
        header("Location: thank-you.html");
        exit;
    } else {
        http_response_code(500);
        echo "Oops! Something went wrong and we couldn't send your message.";
    }
} else {
    http_response_code(403);
    echo "There was a problem with your submission, please try again.";
}
?>