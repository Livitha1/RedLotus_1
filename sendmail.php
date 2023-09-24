<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $to = "receiver@example.com";
    $subject = "Contact Form Submission";
    $message = $_POST["message"];
    $headers = "From: " . $_POST["email"];

    // Create a stream context with options to enable TLS
    $options = [
        "ssl" => [
            "verify_peer" => false,
            "verify_peer_name" => false,
        ],
    ];
    $context = stream_context_create($options);

    // Open a secure TLS connection to the SMTP server
    $smtpServer = "tls://your-smtp-server.com:587"; // Use the correct hostname and port
    $smtpConnection = stream_socket_client($smtpServer, $errorNumber, $errorMessage, 30, STREAM_CLIENT_CONNECT, $context);

    if ($smtpConnection) {
        // Send STARTTLS command to initiate TLS handshake
        fwrite($smtpConnection, "STARTTLS\r\n");
        $response = fgets($smtpConnection);

        if (strpos($response, "220") === 0) {
            // Successfully initiated TLS, proceed with sending the email
            if (mail($to, $subject, $message, $headers)) {
                echo "Email sent successfully";
            } else {
                echo "Failed to send email";
            }
        } else {
            echo "Failed to initiate TLS";
        }

        fclose($smtpConnection);
    } else {
        echo "Failed to connect to SMTP server";
    }
}
// Create a stream context with options to enable TLS
$options = [
    "ssl" => [
        "verify_peer" => false,
        "verify_peer_name" => false,
    ],
];
$context = stream_context_create($options);

// Open a secure TLS connection to the SMTP server
$smtpServer = "tls://smtp.gmail.com:587"; // Use the correct hostname and port
$smtpConnection = stream_socket_client($smtpServer, $errorNumber, $errorMessage, 30, STREAM_CLIENT_CONNECT, $context);
if ($smtpConnection) {
    // ... (ตราบใดที่ต้องส่ง STARTTLS ก่อน)
    if (mail($to, $subject, $message, $headers)) {
        echo "Email sent successfully";
    } else {
        echo "Failed to send email";
    }
}
fclose($smtpConnection);

?>
