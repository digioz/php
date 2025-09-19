# DigiOz Guestbook

A feature-rich, customizable PHP guestbook application that allows visitors to leave messages on your website. Built with security, internationalization, and ease of use in mind.

## Features

### 🎨 **Multi-Theme Support**
- Default and Bootstrap themes included
- Responsive design for mobile and desktop
- Easy theme customization and switching

### 🌍 **Internationalization**
- Support for 10+ languages (English, German, Dutch, Czech, Greek, Hungarian, Persian, Slovak, Swedish, Norwegian)
- User-selectable language interface
- UTF-8 and ISO charset support

### 🔒 **Security Features**
- **Enhanced Security**: Protection against SQL injection, XSS, CSRF, and file upload attacks
- **Secure Data Storage**: JSON-based data storage instead of unsafe PHP serialization
- **Strong Password Hashing**: Uses PHP's `password_hash()` with secure defaults
- **Input Validation**: Comprehensive server-side validation for all user inputs
- **File Upload Security**: MIME type validation, secure filename generation, and upload restrictions
- **Session Security**: Secure session configuration with regeneration and proper cookie settings
- **Security Headers**: Comprehensive HTTP security headers to prevent common attacks
- IP-based spam filtering and banning
- Bad word filtering
- Flood protection  
- Stop Forum Spam integration
- Multiple CAPTCHA options (Built-in, reCAPTCHA v1.0, reCAPTCHA v2.0)

### 👥 **User Management**
- Optional user registration and login system
- User-specific post management
- Email privacy options
- Admin interface for content moderation

### 📝 **Content Management**
- Pagination support for large guestbooks
- Search functionality
- File attachment support (images, PDFs, text files)
- Admin moderation tools

## Requirements

- **PHP**: 8.1+ (with GD extension for built-in CAPTCHA)
- **Web Server**: Apache, Nginx, or similar  
- **Extensions**: cURL (for reCAPTCHA v2.0), JSON, OpenSSL
- **Security**: HTTPS recommended for production use

## Installation

1. **Clone the repository:**
   ```bash
   git clone https://github.com/digioz/php.git
   cd php/guestbook/2.0.6
   ```

2. **Set up file permissions:**
   ```bash
   chmod 755 data/
   chmod 755 cache/
   chmod 755 uploads/
   chmod 644 data/list.txt
   chmod 644 data/users.txt
   chmod 600 includes/config.php
   ```

3. **Configure the application:**
   - Edit `includes/config.php` to customize settings
   - Set your timezone in `$timezone_offset`
   - Configure email notifications if desired
   - Set up CAPTCHA keys if using reCAPTCHA
   - **Important**: Change default admin credentials immediately

4. **Upload to your web server:**
   - Upload all files to your web directory
   - Ensure the web server can read/write to `data/`, `cache/`, and `uploads/` directories
   - Verify `.htaccess` file is properly configured

5. **Access your guestbook:**
   - Visit `https://yourdomain.com/path-to-guestbook/` (HTTPS recommended)
   - The system will automatically redirect to the main guestbook view

## Configuration

### Basic Settings

Edit `includes/config.php` to customize:

```php
// Theme selection
$theme = "bootstrap"; // or "default"

// Timezone (hours offset from UTC)
$timezone_offset = -5;

// Records per page
$total_records_per_page = 10;

// Language settings
$default_language = array("English", "en", "language.php", "en_US", "UTF-8");
```

### Security Settings

```php
// Enable CAPTCHA (0=disabled, 1=built-in, 2=reCAPTCHA v1, 3=reCAPTCHA v2)
$image_verify = 1;

// Flood protection
$gbflood = 1;

// IP logging and banning
$gbIPLogKey = 1;
$banIPKey = 1;
```

### Email Notifications

```php
// Enable admin notifications
$notify_admin = 1;
$notify_admin_email = "admin@yourdomain.com";
$notify_subject = "New Guestbook Entry";
```

## Usage

### For Visitors
1. Navigate to the guestbook URL
2. Click "Add Entry" to leave a message
3. Fill out the required fields (name, email, message)
4. Complete CAPTCHA verification if enabled
5. Submit the entry

### For Administrators
1. Access the admin interface (credentials in config.php)
2. Moderate entries, ban IPs, or manage users
3. Configure spam filters and security settings
4. Monitor logs and user activity

## Themes

### Switching Themes
Change the `$theme` variable in `includes/config.php`:
- `"default"` - Clean, simple design
- `"bootstrap"` - Modern Bootstrap-based responsive design

### Creating Custom Themes
1. Create a new directory in `themes/`
2. Copy template files from an existing theme
3. Customize HTML, CSS, and JavaScript as needed
4. Update the `$theme` setting in config.php

## Language Support

### Adding New Languages
1. Create a new language file in the `language/` directory
2. Follow the format of existing language files
3. Add the language to the `$language_array` in config.php
4. Test the translation thoroughly

### Supported Languages
- English, Czech, Dutch, German, Greek, Hungarian, Persian, Slovak, Swedish, Norwegian

## File Structure

```
├── guestbook.php          # Main entry form
├── list.php               # Display guestbook entries
├── index.php              # Entry point (redirects to list)
├── login.php              # User login
├── register.php           # User registration
├── admin/                 # Admin interface
├── includes/              # Core PHP classes and functions
│   ├── config.php         # Main configuration
│   ├── gb.class.php       # Guestbook entry class
│   ├── functions.php      # Utility functions
│   └── rain.tpl.class.php # Template engine
├── themes/                # UI themes
│   ├── default/           # Default theme
│   └── bootstrap/         # Bootstrap theme
├── language/              # Translation files
├── data/                  # Data storage
└── cache/                 # Template cache
```

## Security Considerations

### Critical Security Updates in v2.0.6
- **Data Storage**: Migrated from unsafe PHP `serialize()` to secure JSON encoding
- **Password Security**: Replaced weak `crypt()` with secure `password_hash()`
- **Input Validation**: Added comprehensive server-side validation for all inputs
- **XSS Protection**: All user output is now properly sanitized
- **File Upload Security**: Enhanced MIME type validation and secure file handling
- **Session Security**: Implemented secure session configuration with proper regeneration

### Ongoing Security Practices
- Change default admin credentials immediately after installation
- Use HTTPS in production environments
- Regularly update banned IP lists and spam filters
- Monitor logs for suspicious activity (`data/message_post.log`, `data/message_spam.log`)
- Keep reCAPTCHA keys secure and rotate periodically
- Review and moderate user-submitted content regularly
- Backup your data directory frequently
- Keep PHP and web server software updated
- Consider implementing rate limiting for additional protection

### File Permissions
- `data/` directory: 755 (writable by web server)
- `includes/config.php`: 600 (readable only by owner)
- `uploads/` directory: 755 with PHP execution disabled
- Log files: 644 (web server readable/writable)

## Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Support

- **Issues**: Report bugs and feature requests on [GitHub Issues](https://github.com/digioz/php/issues)
- **Documentation**: Check the source code comments and configuration files
- **Community**: Visit the DigiOz website for updates and support

## Version

Current version: **2.0.6**

## Changelog

### v2.0.6
- Enhanced security features
- Improved theme system
- Better internationalization support
- Updated Bootstrap integration

### v2.0.4
- Enhanced security features
- Improved theme system
- Better internationalization support
- Updated Bootstrap integration

---

**DigiOz Guestbook** - Making web communication simple and secure.