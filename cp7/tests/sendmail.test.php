<?php

/**
 * INSTALLATION DE SENDMAIL : WINDOWS
 * Télécharger Sendmail à partir du site officiel : 
 * https://www.glob.com.au/sendmail/sendmail.zip
 * Extraire son contenu dans un dossier (Exemple : c:\xampp\sendmail)
 * Ouvrir sendmail.ini et définir les variables suivantes :
 * - smtp_server=smtp.gmail.com
 * - smtp_port=587
 * - auth_username=formation.greta@gmail.com
 * - auth_password=Secret_123
 * Fermer en sauvegardant
 * 
 * CONFIGURATION PHP : WINDOWS
 * Ouvrir php.ini et commenter les variables suivantes si elles sont présentes :
 * - ;SMTP = localhost
 * - ;smtp_port = 25
 * - ;auth_username =
 * - ;auth_password =
 * - ;sendmail_from = me@example.com -> Windows seulement
 * Puis définir la variable suivante :
 * - sendmail_path="c:\xampp\sendmail\sendmail.exe"
 * Fermer en sauvegardant
 * Redémarrer le serveur Apache
 * 
 * CONFIGURATION GMAIL
 * Cliquer sur le lien suivant pour autoriser les apps moins sécurisées : 
 * https://www.google.com/settings/security/lesssecureapps
 */

$recipients = 'info@baobab-ingenierie.fr';

$subject = 'Test envoi de mail via PHP';

$body = 'Bonjour, ceci est un test d\'envoi de mail en utilisant la fonctionnalité mail de PHP.';

$headers = "MIME-Version:1.0 \r\n"; // obligatoire
$headers .= "Content-type:text/html;charset=UTF-8 \r\n"; // obligatoire
$headers .= "From:manu.croncron@elysees.fr \r\n"; // obligatoire : De
$headers .= "Cc:jeannot.tetex@matignon.fr \r\n"; // optionnel : Cc
$headers .= "Bcc:valou.cresse@idf.fr \r\n"; // optionnel : Bcc
$headers .= "X-Priority:1 \r\n"; // optionnel : priorité
$headers .="Disposition-Notification-To:info@baobab-ingenierie.fr \r\n"; // optionnel : Accusé de réception

$status = mail($recipients, $subject, $body, $headers);
echo $status ? 'Mail envoyé' : 'Echec d\'envoi';
