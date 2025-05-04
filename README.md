# GlowUp - Plateforme de Gestion des Réservations de Salon Esthétique

## 📌 Description

GlowUp est une application web de gestion des réservations pour salon esthétique, offrant des fonctionnalités complètes pour :
- **Clients** : Réserver des services, gérer leurs rendez-vous
- **Employés** : Suivre leur planning et disponibilités
- **Administrateurs** : Gérer l'ensemble du système (utilisateurs, services, réservations)

## ✨ Fonctionnalités

### 👨‍💼 Clients
- ✅ Création de compte et authentification
- 🔍 Consultation des services disponibles
- 🗓 Réservation de services (date/heure)
- 📋 Gestion des réservations (modification/annulation)
- 📚 Historique des rendez-vous

### 👩‍💼 Employés
- 📅 Visualisation du planning
- 🕒 Gestion des disponibilités
- ✔ Marquage des services effectués
- 🔄 Reprogrammation de rendez-vous

### 🛠 Administrateurs
- 👥 Gestion des utilisateurs (clients/employés)
- 💅 Gestion des services (ajout/modification/suppression)
- 📊 Tableau de bord des réservations
- ⚙ Configuration du système

## 🛠 Technologies

**Backend:**
- Laravel 10 (PHP)
- MySQL (Base de données)

**Frontend:**
- HTML5, CSS3, JavaScript
- Blade (Templating)
- Bootstrap 5 (Framework CSS)

**Sécurité:**
- Authentification Laravel
- Cryptage des mots de passe
- Protection CSRF

## 🚀 Installation

1. **Prérequis:**
   - PHP 8.1+
   - Composer
   - MySQL 5.7+
   - Node.js 16+

2. **Configuration:**
```bash
git clone https://github.com/Salma-007/GlowUp_salon.git
cd glowup
composer install
npm install
cp .env.example .env
php artisan key:generate
