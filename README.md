# News Portal - PHP & MySQL Project

A responsive news website built with PHP, MySQL, HTML, CSS, and Bootstrap 5. Features user authentication, role-based access, and a complete admin panel for content management.

## Features

### User Features
- **User Registration & Login** - Secure authentication with password hashing
- **Responsive Design** - Bootstrap 5 for mobile-friendly interface
- **News Reading** - Browse and read full articles (login required)
- **Category Filtering** - News organized by categories
- **Modern UI** - Clean, professional design with Font Awesome icons

### Admin Features
- **Admin Dashboard** - Statistics and quick actions
- **Content Management** - Full CRUD operations for news articles
- **User Management** - View registered users
- **Role-based Access** - Separate admin and user interfaces

## Installation

### Prerequisites
- XAMPP (Apache + MySQL + PHP)
- Web browser
- Text editor (optional)

### Setup Instructions

1. **Start XAMPP Services**
   - Start Apache and MySQL from XAMPP Control Panel

2. **Create Database**
   - Open phpMyAdmin (http://localhost/phpmyadmin)
   - Import the `setup_database.sql` file or run the SQL commands manually

3. **Deploy Files**
   - Copy all project files to `htdocs/news_portal/` directory
   - Ensure proper file permissions

4. **Access the Website**
   - Homepage: http://localhost/news_portal/
   - Admin Panel: http://localhost/news_portal/admin/dashboard.php

## Default Login Credentials

**Admin Account:**
- Email: admin@example.com
- Password: admin123

## File Structure

```
news_portal/
├── db_connect.php          # Database connection
├── setup_database.sql      # Database setup script
├── header.php             # Common header component
├── footer.php             # Common footer component
├── index.php              # Homepage with news grid
├── login.php              # User login page
├── register.php           # User registration page
├── logout.php             # Logout handler
├── news.php               # Single news article page
├── admin/                 # Admin panel directory
│   ├── dashboard.php      # Admin dashboard
│   ├── add_news.php       # Add new article
│   ├── edit_news.php      # Edit existing article
│   └── delete_news.php    # Delete article handler
└── README.md              # This file
```

## Database Schema

### Users Table
- `id` - Primary key (AUTO_INCREMENT)
- `username` - Unique username
- `email` - Unique email address
- `password` - Hashed password (bcrypt)
- `role` - User role (admin/user)
- `created_at` - Registration timestamp

### News Table
- `id` - Primary key (AUTO_INCREMENT)
- `title` - Article title
- `content` - Article content (TEXT)
- `category` - News category
- `author` - Author name
- `created_at` - Publication timestamp

## Technologies Used

- **Backend:** PHP 7.4+
- **Database:** MySQL
- **Frontend:** HTML5, CSS3, Bootstrap 5
- **Icons:** Font Awesome 6
- **Server:** Apache (XAMPP)

## Security Features

- Password hashing with PHP's `password_hash()`
- SQL injection prevention with prepared statements
- Session-based authentication
- Role-based access control
- Input validation and sanitization

## Usage

### For Regular Users
1. Register for a new account or login
2. Browse news articles on the homepage
3. Click "Read More" to view full articles
4. Logout when finished

### For Administrators
1. Login with admin credentials
2. Access the admin dashboard
3. Add, edit, or delete news articles
4. View user statistics
5. Manage content categories

## Customization

### Adding New Categories
Edit the category options in:
- `admin/add_news.php`
- `admin/edit_news.php`

### Styling Changes
Modify the CSS in `header.php` or add external stylesheets.

### Database Configuration
Update connection settings in `db_connect.php` if needed.

## Troubleshooting

### Common Issues

1. **Database Connection Error**
   - Ensure MySQL is running in XAMPP
   - Check database credentials in `db_connect.php`
   - Verify database exists

2. **Login Issues**
   - Clear browser cache and cookies
   - Check if sessions are enabled in PHP
   - Verify user exists in database

3. **Permission Errors**
   - Ensure proper file permissions
   - Check Apache configuration

### Error Logs
Check XAMPP error logs for detailed error information.

## License

This project is open source and available under the MIT License.

## Support

For issues or questions, please check the troubleshooting section or review the code comments for guidance.
