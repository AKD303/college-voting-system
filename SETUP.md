# College Voting System - 50% Complete Setup Guide

## Prerequisites
- PHP 7.4 or higher
- Node.js 14 or higher
- MySQL 5.7 or higher
- Git
- A modern web browser

## Installation Steps

### 1. Clone the Repository
```bash
git clone https://github.com/AKD303/college-voting-system.git
cd college-voting-system
```

### 2. Database Setup

#### Using MySQL Command Line:
```bash
mysql -u root -p < backend/database/schema.sql
```

#### Or Using MySQL Workbench:
1. Open MySQL Workbench
2. Connect to your MySQL server
3. Go to File → Open SQL Script
4. Select `backend/database/schema.sql`
5. Click Execute

### 3. PHP Backend Setup

#### Configure Database Connection:
1. Open `backend/php/config.php`
2. Update the following variables:
```php
define('DB_HOST', 'localhost');        // Your MySQL host
define('DB_USER', 'root');             // Your MySQL username
define('DB_PASS', '');                 // Your MySQL password
define('DB_NAME', 'college_voting_system'); // Database name
```

#### Run PHP Server:
```bash
cd frontend
php -S localhost:8000
```

The frontend will be accessible at: `http://localhost:8000`

### 4. Node.js Backend Setup (Optional)

#### Install Dependencies:
```bash
cd backend/nodejs
npm install
```

#### Create .env file in nodejs directory:
```
DB_HOST=localhost
DB_USER=root
DB_PASS=
DB_NAME=college_voting_system
PORT=5000
JWT_SECRET=your_secret_key_change_in_production
```

#### Run Node.js Server:
```bash
npm start
```

The Node.js API will be available at: `http://localhost:5000`

### 5. Access the Application

#### Frontend URLs:
- **Login Page:** `http://localhost:8000/index.html`
- **Admin Dashboard:** `http://localhost:8000/admin-dashboard.html`
- **Student Dashboard:** `http://localhost:8000/student-dashboard.html`

#### Admin Credentials:
- **Username:** admin
- **Password:** admin123

#### Sample Student Credentials:
- **Username:** student
- **Password:** student123
- (Create more students through registration)

## File Structure Explanation

```
college-voting-system/
│
├── frontend/                          # Frontend files (HTML, CSS, JS)
│   ├── index.html                    # Login & Registration page
│   ├── admin-dashboard.html          # Admin dashboard
│   ├── student-dashboard.html        # Student voting interface
│   ├── css/
│   │   ├── style.css                 # Main styling
│   │   ├── responsive.css            # Mobile responsive styles
│   │   └── dashboard.css             # Dashboard specific styles
│   └── js/
│       ├── main.js                   # Main JavaScript functionality
│       ├── admin-dashboard.js        # Admin dashboard script
│       └── student-dashboard.js      # Student dashboard script
│
├── backend/
│   ├── php/                          # PHP Backend
│   │   ├── config.php                # Database connection & config
│   │   ├── login.php                 # Login API
│   │   ├── register.php              # Registration API
│   │   ├── logout.php                # Logout API
│   │   └── api/
│   │       ├── get_users.php         # Get users API
│   │       ├── update_user.php       # Update user API
│   │       └── get_candidates.php    # Get candidates API
│   │
│   ├── nodejs/                       # Node.js Backend
│   │   ├── server.js                 # Main Express server
│   │   ├── package.json              # Node dependencies
│   │   └── routes/
│   │       ├── auth.js               # Authentication routes
│   │       └── users.js              # User management routes
│   │
│   └── database/
│       └── schema.sql                # MySQL database schema
│
├── .env                              # Environment variables
├── .gitignore                        # Git ignore file
├── README.md                         # Project documentation
└── SETUP.md                          # This setup guide
```

## Database Schema Overview

### Tables Created:
1. **users** - Store user information (admin, student, candidate)
2. **candidates** - Store candidate information for voting positions
3. **votes** - Store voting records
4. **positions** - Store available voting positions
5. **sessions** - Store user session information

## Features Included (50% Completion)

### ✅ Authentication & Security
- [x] Admin login system
- [x] Student registration & login
- [x] Password hashing with bcrypt
- [x] Session management
- [x] Role-based access control
- [x] Input validation
- [x] SQL injection prevention

### ✅ Frontend
- [x] Login page with tabs
- [x] Registration form
- [x] Admin dashboard
- [x] Student dashboard
- [x] Responsive design (Mobile, Tablet, Desktop)
- [x] Bootstrap integration
- [x] Modern CSS styling

### ✅ Backend
- [x] PHP login API
- [x] PHP registration API
- [x] Database connection
- [x] Node.js server setup
- [x] Express API endpoints
- [x] CORS support

### ✅ Database
- [x] MySQL schema
- [x] User management tables
- [x] Candidate tables
- [x] Vote tracking tables
- [x] Session management tables

## Troubleshooting

### Issue: "Connection refused" when connecting to MySQL
**Solution:**
1. Ensure MySQL is running
2. Check MySQL credentials in `backend/php/config.php`
3. Verify MySQL port (default: 3306)

### Issue: PHP module not found
**Solution:**
```bash
# Install PHP if not installed
# Ubuntu/Debian:
sudo apt-get install php php-mysql

# macOS:
brew install php

# Windows: Download from php.net
```

### Issue: Port 8000 already in use
**Solution:**
```bash
# Use different port
php -S localhost:8080
```

### Issue: Database schema not imported
**Solution:**
1. Check MySQL connection
2. Ensure schema.sql file exists
3. Try importing via MySQL Workbench instead of command line

### Issue: Cannot login with admin credentials
**Solution:**
1. Verify database was imported successfully
2. Check `backend/php/config.php` for correct credentials
3. Clear browser cache and try again

## Testing the Application

### Test Login:
1. Open `http://localhost:8000/index.html`
2. Click on Login tab
3. Enter credentials:
   - Username: `admin`
   - Password: `admin123`
4. Click Login

### Test Registration:
1. Click on Register tab
2. Fill in all fields:
   - Full Name: Test User
   - Username: testuser
   - Email: test@college.com
   - Enrollment: 2024001
   - Department: CSE
   - Password: Test@1234
   - Confirm Password: Test@1234
3. Click Register
4. Login with new credentials

## Performance Optimization Tips

1. **Database**: Add indexes to frequently searched columns
2. **Frontend**: Minify CSS and JavaScript files
3. **Backend**: Use prepared statements (already implemented)
4. **Caching**: Implement Redis for session caching
5. **Images**: Optimize image sizes

## Security Best Practices

1. Change default admin password immediately
2. Update JWT secret in .env
3. Use HTTPS in production
4. Set proper database permissions
5. Regular security audits
6. Keep dependencies updated
7. Implement rate limiting
8. Enable CSRF protection

## Deployment Guide

### For Production:
1. Use a production-grade server (Apache/Nginx)
2. Enable HTTPS/SSL
3. Set strong database passwords
4. Use environment variables for sensitive data
5. Implement proper logging
6. Regular backups
7. Monitor performance

## Support & Documentation

For more information:
- Check individual file comments
- Review database schema in `backend/database/schema.sql`
- Refer to Bootstrap documentation: https://getbootstrap.com
- PHP documentation: https://www.php.net
- Node.js documentation: https://nodejs.org

## Next Steps for 100% Completion

1. **Voting System**
   - Implement voting logic
   - Add vote validation
   - Prevent duplicate votes

2. **Results Dashboard**
   - Display voting results
   - Create charts and graphs
   - Show candidate rankings

3. **Notifications**
   - Email notifications
   - OTP verification
   - SMS alerts

4. **Admin Features**
   - Advanced reports
   - Analytics dashboard
   - Candidate management

5. **Security Enhancements**
   - Two-factor authentication
   - Encryption at rest
   - API rate limiting

## Contact
For issues or questions, please create an issue in the GitHub repository.

## License
MIT License - Feel free to use this project for educational purposes.
