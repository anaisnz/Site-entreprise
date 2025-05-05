<?php
// Inclusion manuelle
require 'PHPMailer/traitement.php';

use PHPMailer\PHPMailer\PHPMailer;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom = htmlspecialchars(trim($_POST["nom"]));
    $email = filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL);
    $message = htmlspecialchars(trim($_POST["message"]));

    if ($nom && $email && $message) {
        $mail = new PHPMailer(true);

        try {
            // Configuration SMTP Gmail
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'tonemail@gmail.com';        // Ton adresse Gmail
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;

            // Destinataires
            $mail->setFrom($email, $nom);
            $mail->addAddress('anaiszaytoun09@gmail.com');         // Le tien

            // Contenu du mail
            $mail->isHTML(false);
            $mail->Subject = "Message depuis le formulaire";
            $mail->Body    = "Nom: $nom\nEmail: $email\nMessage:\n$message";

            // Envoi
            $mail->send();

            // Redirection vers la page de confirmation
            header("Location: confirmation.html");
            exit();

        } catch (Exception $e) {
            echo "Erreur lors de l'envoi : {$mail->ErrorInfo}";
        }
    } else {
        echo "Tous les champs doivent être remplis correctement.";
    }
} else {
    echo "Requête non valide.";
}
?>
