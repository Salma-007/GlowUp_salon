<!DOCTYPE html>
<html>
<head>
    <title>Votre compte a été créé</title>
</head>
<body>
    <h1>Bonjour {{ $name }},</h1>
    <p>Votre compte a été créé avec succès.</p>
    <p>Voici vos informations de connexion :</p>
    <ul>
        <li><strong>Email :</strong> {{ $email }}</li>
        <li><strong>Mot de passe :</strong> {{ $password }}</li>
    </ul>
    <p>Nous vous recommandons de changer votre mot de passe après votre première connexion.</p>
    <p>Cordialement,</p>
    <p>L'équipe de GlowUp</p>
</body>
</html>