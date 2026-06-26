# College Voting System - 50% Completion

## Project Overview
A comprehensive college voting system built with HTML, CSS, JavaScript, PHP, Node.js, and MySQL.

## Features Included (50% Completion)

### ✅ Meeting 1: Admin Module & Security
- Admin login system
- Password hashing (bcrypt)
- Session management
- User authentication

### ✅ Meeting 2: CSS Design & Responsiveness
- Responsive layout (Mobile, Tablet, Desktop)
- Modern CSS design
- Bootstrap integration
- Dark/Light theme support

### ✅ Meeting 3: Dashboard & User Security
- Admin dashboard
- Student dashboard
- User management
- Password security implementation

## Project Structure
```
college-voting-system/
├── frontend/
│   ├── index.html
│   ├── admin-dashboard.html
│   ├── student-dashboard.html
│   ├── login.html
│   ├── register.html
│   ├── css/
│   │   ├── style.css
│   │   ├── responsive.css
│   │   └── dashboard.css
│   └── js/
│       ├── main.js
│       ├── admin-dashboard.js
│       └── student-dashboard.js
├── backend/
│   ├── php/
│   │   ├── config.php
│   │   ├── login.php
│   │   ├── register.php
│   │   ├── logout.php
│   │   └── api/
│   │       ├── get_users.php
│   │       ├── update_user.php
│   │       └── get_candidates.php
│   ├── nodejs/
│   │   ├── server.js
│   │   ├── package.json
│   │   └── routes/
│   │       ├── auth.js
│   │       └── users.js
│   └── database/
│       └── schema.sql
├── .env
├── .gitignore
└── SETUP.md
```

## Installation & Setup
See SETUP.md for detailed instructions

## Technologies Used
- **Frontend:** HTML5, CSS3, Bootstrap, JavaScript
- **Backend:** PHP 7.4+, Node.js 14+
- **Database:** MySQL 5.7+
- **Security:** bcrypt, JWT, Prepared Statements

## Midterm Defense Ready ✅
This 50% completion includes all core functionality for demonstration.

## Quick Start
1. Clone the repository
2. Import database schema from `backend/database/schema.sql`
3. Configure database in `backend/php/config.php`
4. Run PHP backend: `php -S localhost:8000`
5. Run Node.js backend: `cd backend/nodejs && npm install && npm start`
6. Access frontend at `http://localhost:8000/frontend/index.html`

## Default Admin Credentials
- **Username:** admin
- **Password:** admin123

## Features Implemented
✅ User Authentication
✅ Role-based Access Control (Admin/Student/Candidate)
✅ Password Security with bcrypt
✅ Responsive Design
✅ Dashboard Interface
✅ User Management
✅ Database Schema
✅ API Endpoints
✅ Session Management
✅ CORS Support

## Next Steps for 100% Completion
- [ ] Complete Voting functionality
- [ ] Results dashboard with charts
- [ ] Email notifications
- [ ] OTP verification
- [ ] Advanced analytics
- [ ] Admin reports
- [ ] Mobile app support
- [ ] Payment integration (if applicable)

## Security Features
- Password hashing with bcrypt
- Prepared statements for SQL injection prevention
- Session timeout (30 minutes)
- CORS protection
- Input validation
- Security headers

## Author
AKD303

## License
MIT
