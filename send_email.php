<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Get the JSON data from the request body
$json = file_get_contents('php://input');
$data = json_decode($json, true);

if (isset($data['to_email'])) {
    $to = $data['to_email'];
    $subject = "Your Access Password";
    $password = "7103";
    $message = "Hello,\n\nYour access password is: " . $password . "\n\nRegards,\nSecurity System";
    
    // Email Headers
    $headers = "From: noreply@yourdomain.com\r\n" .
               "Reply-To: noreply@yourdomain.com\r\n" .
               "X-Mailer: PHP/" . phpversion();

    // Send email
    if (mail($to, $subject, $message, $headers)) {
        echo json_encode(['status' => 'success', 'message' => 'Email sent successfully']);
    } else {
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => 'Server failed to send email. Ensure mail() is configured on your server.']);
    }
} else {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Email address is missing.']);
}
?>
