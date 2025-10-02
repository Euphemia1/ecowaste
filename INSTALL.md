# EcoWaste Installation Guide

## Prerequisites

- **Web Server**: Apache 2.4+ or Nginx 1.18+
- **PHP**: Version 8.0 or higher
- **Database**: MySQL 8.0+ or MariaDB 10.4+
- **Extensions**: PDO, PDO_MySQL, OpenSSL, mbstring, JSON

## Installation Steps

### 1. Download and Setup

1. Clone or download the EcoWaste application to your web server directory
2. Ensure the `public` folder is set as your document root
3. Set proper permissions:
   ```bash
   chmod -R 755 /path/to/ecowaste
   chmod -R 777 /path/to/ecowaste/uploads (if uploads folder exists)
   ```

### 2. Database Setup

1. Create a MySQL database:
   ```sql
   CREATE DATABASE ecowaste_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

2. Create a database user:
   ```sql
   CREATE USER 'ecowaste_user'@'localhost' IDENTIFIED BY 'your_secure_password';
   GRANT ALL PRIVILEGES ON ecowaste_db.* TO 'ecowaste_user'@'localhost';
   FLUSH PRIVILEGES;
   ```

3. Import the database schema:
   ```bash
   mysql -u ecowaste_user -p ecowaste_db < database/schema.sql
   ```

### 3. Configuration

1. Update database credentials in `config/database.php`:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_NAME', 'ecowaste_db');
   define('DB_USER', 'ecowaste_user');
   define('DB_PASS', 'your_secure_password');
   ```

2. Configure application settings in `config/config.php`:
   - Set `APP_URL` to your domain
   - Configure email settings for notifications
   - Set environment to 'production' for live sites

### 4. Web Server Configuration

#### Apache
- The `.htaccess` file is already included in the `public` folder
- Ensure `mod_rewrite` is enabled
- Set document root to `/path/to/ecowaste/public`

#### Nginx
Add this configuration to your server block:
```nginx
location / {
    try_files $uri $uri/ /index.php?$query_string;
}

location ~ \.php$ {
    fastcgi_pass unix:/var/run/php/php8.0-fpm.sock;
    fastcgi_index index.php;
    fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
    include fastcgi_params;
}
```

### 5. Security Setup

1. **File Permissions**: Ensure config files are not web-accessible
2. **SSL Certificate**: Enable HTTPS for production
3. **Database Security**: Use strong passwords and limit database user permissions
4. **Session Security**: Configure secure session settings in php.ini

### 6. Email Configuration

Configure SMTP settings in `config/config.php` for:
- User registration confirmations
- Password reset emails
- Pickup confirmations

### 7. Testing

1. Access your site at `https://yourdomain.com`
2. Create a test account
3. Test core functionality:
   - User registration and login
   - Pickup scheduling
   - Dashboard statistics
   - Recycling guide access

## Post-Installation

### Admin Account Setup

1. Manually create an admin user in the database:
   ```sql
   INSERT INTO admin_users (username, email, password_hash, full_name, role) 
   VALUES ('admin', 'admin@yourdomain.com', 'hashed_password', 'Administrator', 'super_admin');
   ```

### Maintenance

1. **Regular Backups**: Set up automated database backups
2. **Log Monitoring**: Check error logs regularly
3. **Updates**: Keep PHP and database software updated
4. **Security Scans**: Regular security audits

### Customization

- **Branding**: Update colors and logos in CSS files
- **Email Templates**: Customize email templates (implement email service)
- **Additional Features**: Add new controllers and views as needed

## Troubleshooting

### Common Issues

1. **500 Internal Server Error**
   - Check file permissions
   - Verify PHP extensions are installed
   - Check error logs

2. **Database Connection Error**
   - Verify database credentials
   - Ensure database server is running
   - Check firewall settings

3. **CSS/JS Not Loading**
   - Check file paths in layouts
   - Verify web server configuration
   - Clear browser cache

### Support

- Check error logs in `/var/log/apache2/` or `/var/log/nginx/`
- Enable PHP error reporting during development
- Verify all configuration settings

## Performance Optimization

1. **Enable Caching**: Configure opcache for PHP
2. **CDN**: Use CDN for static assets
3. **Database Optimization**: Add indexes for frequently queried columns
4. **Compression**: Enable gzip compression

---

For additional help or customization needs, refer to the source code documentation or contact the development team.