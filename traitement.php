<?php
// Inclusion manuelle des fichiers PHPMailer
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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
            $mail->Username   = 'tonemail@gmail.com';       // remplace par ton adresse Gmail
            $mail->Password   = 'mot-de-passe-app';         // mot de passe d'application Gmail
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;

            // Expéditeur et destinataire
            $mail->setFrom($email, $nom);
            $mail->addAddress('anaiszaytoun09@gmail.com');  // destinataire

            // Contenu de l'e-mail
            $mail->isHTML(false);
            $mail->Subject = "Message depuis le formulaire";
            $mail->Body    = "Nom: $nom\nEmail: $email\nMessage:\n$message";

            // Envoi
            $mail->send();

            // Redirection après envoi
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
