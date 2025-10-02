# 🌱 EcoWaste - Sustainable Waste Management Platform

EcoWaste is a comprehensive web application designed to promote sustainable waste management practices and environmental consciousness. Built with PHP and MySQL, it provides users with tools to track their environmental impact, schedule eco-friendly waste pickups, and learn proper recycling techniques.

## ✨ Features

### 🏠 User Dashboard
- **Account Creation & Authentication**: Secure user registration with individual and business account types
- **User-friendly Interface**: Clean, modern design with responsive layout for all devices

### 📊 Impact Dashboard
- **Environmental Impact Tracking**: Monitor your recycling rate, carbon footprint reduction, and resource savings
- **Interactive Charts**: Visualize your monthly recycling progress and waste composition
- **Real-time Metrics**: Track trees saved, CO₂ reduction, and water conservation
- **Performance Analytics**: Compare your environmental impact over time with detailed breakdowns

### 📅 Schedule Pickup Service
- **Multi-step Pickup Scheduling**: Easy-to-use wizard for scheduling waste collection
- **Waste Type Classification**: Support for recyclables, electronics, organic waste, hazardous materials, and bulky items
- **Location Management**: Address verification and pickup location details
- **Flexible Scheduling**: Choose from morning, afternoon, or evening pickup slots
- **Confirmation System**: Email confirmations with detailed pickup information

### 📚 Recycling Guide
- **Comprehensive Material Guidelines**: Detailed instructions for paper, cardboard, plastics, electronics, and organic waste
- **Recycling Codes**: Clear explanations of plastic recycling numbers and their meanings
- **Best Practices**: Pro tips for proper waste preparation and sorting
- **Educational Content**: Learn about environmental impact and proper disposal methods

### 🔐 User Authentication
- **Secure Login System**: Protected user accounts with email verification
- **Password Management**: Secure password handling with visibility toggles
- **Account Types**: Support for both individual and business accounts

## 🛠️ Technology Stack

- **Backend**: PHP 8.0+
- **Database**: MySQL 8.0+
- **Frontend**: HTML5, CSS3, JavaScript
- **Framework**: Custom MVC Architecture
- **Security**: PDO prepared statements, password hashing, CSRF protection

## 📁 Project Structure

```
ecowaste/
├── config/           # Configuration files
├── controllers/      # Application controllers
├── models/          # Data models
├── views/           # View templates
├── assets/          # CSS, JS, images
├── includes/        # Common includes
├── database/        # Database schema and migrations
└── public/          # Public entry point
```

## 🚀 Installation

1. Clone the repository
2. Import the database schema from `database/schema.sql`
3. Configure database connection in `config/database.php`
4. Set up your web server to point to the `public/` directory
5. Ensure PHP sessions and file uploads are enabled

## 📧 Contact

For questions or support, please contact the EcoWaste team.

---

🌍 **Together, let's make waste management more sustainable!**