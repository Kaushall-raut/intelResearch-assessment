
# Candidate Recruitment Management System

A web-based **Candidate Recruitment Management System** built using **PHP 8.2, CodeIgniter 4, MySQL, and Bootstrap**. The application allows candidates to register, manage their profiles, and upload resumes, while HR users can review candidate details, verify profiles, and send interview invitations through email.

## Features

### Candidate
- User registration and secure login
- Candidate dashboard
- Profile creation and management
- Update personal details, skills, experience, and summary
- Upload resumes in PDF, DOC, and DOCX formats
- Secure resume access
- Session-based authentication

### HR
- HR dashboard to view registered candidates
- View candidate profiles and resumes
- Verify candidate profiles
- Send interview invitations through email
- Role-based access control

### Security
- Password hashing using PHP `password_hash()`
- Password verification using `password_verify()`
- Session-based authentication
- Role-based access control
- Server-side form validation
- CSRF protection for supported forms
- Unique filenames for uploaded resumes
- Authorization checks for protected pages and resume access

## Tech Stack

| Technology | Purpose |
|---|---|
| PHP 8.2+ | Backend development |
| CodeIgniter 4.7.4 | PHP MVC framework |
| MySQL | Database |
| Bootstrap | Responsive user interface |
| HTML5 | Page structure |
| CSS3 | Styling |
| JavaScript | Client-side interactions |
| XAMPP | Local development environment |
| Composer | Dependency management |
| SMTP | Email notifications |

## Project Structure

```text
recruitment_portal/
│
├── app/
│   ├── Config/
│   │   ├── Routes.php
│   │   └── Email.php
│   │
│   ├── Controllers/
│   │   ├── Auth.php
│   │   ├── BaseController.php
│   │   ├── Candidate.php
│   │   ├── Dashboard.php
│   │   ├── Home.php
│   │   └── HR.php
│   │
│   ├── Models/
│   │   ├── CandidateProfileModel.php
│   │   └── UserModel.php
│   │
│   └── Views/
│       ├── auth/
│       │   ├── login.php
│       │   └── register.php
│       ├── candidate/
│       │   ├── dashboard.php
│       │   └── profile.php
│       ├── hr/
│       │   ├── index.php
│       │   └── view.php
│       ├── home.php
│       └── layout.php
│
├── public/
│   └── index.php
│
├── writable/
│   └── uploads/
│       └── resumes/
│
├── vendor/
├── .env
├── composer.json
├── spark
└── README.md
```

## Installation and Setup

### 1. Prerequisites

Ensure the following are installed:

- PHP 8.2 or later
- Composer
- MySQL
- XAMPP
- Git (optional)

### 2. Clone the Repository

```bash
git clone <repository-url>
cd recruitment_portal
```

If you have already downloaded the project, open its directory in the terminal.

### 3. Install Dependencies

```bash
composer install
```

To regenerate the Composer autoloader if required:

```bash
composer dump-autoload
```

### 4. Configure Environment Variables

Rename the `env` file to `.env` if one does not already exist.

Configure the application and database settings:

```ini
CI_ENVIRONMENT = development

app.baseURL = 'http://localhost:8080/'

database.default.hostname = localhost
database.default.database = recruitment_portal
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi
database.default.port = 3307
```

Update the database credentials and port according to your local MySQL configuration.

### 5. Create the Database

1. Start MySQL using the XAMPP Control Panel.
2. Open phpMyAdmin or another MySQL management tool.
3. Create a database named `recruitment_portal`.
4. Import the project's SQL schema if provided, or create the required tables according to the application models.

Ensure the database schema matches the fields used in the application, including `password_hash` and `status` in the `users` table.

### 6. Configure SMTP

To enable interview invitation emails, configure SMTP in `.env`.

Example configuration for Gmail:

```ini
email.fromEmail = your-email@gmail.com
email.fromName = "Recruitment Portal"
email.protocol = smtp
email.SMTPHost = smtp.gmail.com
email.SMTPUser = your-email@gmail.com
email.SMTPPass = your-gmail-app-password
email.SMTPPort = 587
email.SMTPCrypto = tls
email.mailType = html
email.charset = UTF-8
email.wordWrap = true
```

Use a Gmail App Password if using Gmail with two-step verification. Confirm that `app/Config/Email.php` loads these environment settings correctly.

**Important:** Do not commit real SMTP credentials or database passwords to a public repository. Keep `.env` private.

### 7. Configure Resume Uploads

Ensure the resume upload directory exists and is writable by PHP.

```text
writable/uploads/resumes/
```

Uploaded resumes should be accessed through authorized application routes rather than exposed directly through a public directory.

### 8. Run the Application

Start the CodeIgniter development server from the project root:

```bash
php spark serve
```

Open the application in your browser:

```text
http://localhost:8080/
```

## Application Routes

| Method | Route | Description |
|---|---|---|
| GET | `/` | Home page |
| GET, POST | `/register` | Candidate registration |
| GET, POST | `/login` | User login |
| GET | `/logout` | Log out |
| GET | `/dashboard` | Candidate dashboard |
| GET, POST | `/profile` | View and update candidate profile |
| POST | `/profile/resume` | Upload a resume |
| GET | `/resume/{id}` | Access a resume with authorization |
| GET | `/hr` | HR dashboard |
| GET | `/hr/candidate/{id}` | View candidate details |
| POST | `/hr/candidate/{id}/verify` | Update verification status |
| POST | `/hr/candidate/{id}/interview` | Send an interview invitation |

Routes may differ depending on the current `app/Config/Routes.php` configuration.

## User Roles

| Role | Permissions |
|---|---|
| Candidate | Register, log in, manage profile, upload resume, and access permitted candidate pages |
| HR | Review candidates, view permitted resumes, verify profiles, and send interview invitations |

HR accounts should be created or assigned securely. Public registration should not allow users to assign themselves the HR role.

## How It Works

1. A candidate registers and creates an account.
2. The candidate logs in and completes their profile.
3. The candidate adds skills, experience, and a summary, then uploads a resume.
4. HR logs in to review candidate profiles and submitted resumes.
5. HR can update the candidate's verification status.
6. HR can send interview invitations through email.

## Useful Commands

```bash
# Start the development server
php spark serve

# Display registered routes
php spark routes

# Clear application cache
php spark cache:clear

# Install project dependencies
composer install

# Regenerate Composer autoload files
composer dump-autoload
```

Run these commands from the project root directory.

## Security Considerations

- Validate all user-submitted data on the server.
- Protect restricted routes with authentication and role checks.
- Allow candidates to access only their own resumes and HR to access resumes according to permissions.
- Validate uploaded file types, sizes, and filenames.
- Store passwords as secure hashes, never as plain text.
- Use CSRF protection for state-changing forms.
- Keep credentials and secrets outside version control.
- Use server-side authorization to protect sensitive data.

Disabling right-click, copying, screenshots, or viewing page source cannot guarantee that information will not be captured. Sensitive content must be protected through server-side access controls.

## Troubleshooting

### CodeIgniter Class Not Found

If you encounter a framework class loading error, try:

```bash
composer install
composer dump-autoload
php spark serve
```

If the issue persists, check that the CodeIgniter framework installation is complete and consistent.

### Database Connection Error

- Ensure MySQL is running in XAMPP.
- Verify the database name, username, password, and port in `.env`.
- Confirm that the required tables and columns exist.

### Email Not Sending

- Verify SMTP host, port, encryption, username, and app password.
- Check that `app/Config/Email.php` reads the environment configuration.
- Review the application logs for errors.
- Do not expose SMTP credentials in logs or screenshots.

### Resume Upload Error

- Ensure the upload directory exists and is writable.
- Check the allowed file types and maximum file size.
- Confirm that the configured upload path is correct.

## Future Enhancements

- Candidate search and filtering
- Interview scheduling and status tracking
- Email notifications for verification updates
- Pagination for candidate listings
- Password reset functionality
- HR activity and audit logs
- Automated testing
- Production deployment and hardening

## Project Status

This project was developed as a recruitment management assessment and local development application. Features should be tested in the target environment, and security should be reviewed before production use.

## Author

**Kaushal Raut**

Developed using PHP, CodeIgniter 4, MySQL, and Bootstrap.

## License

This project was created for assessment and educational purposes. Add an appropriate open-source license if you plan to distribute or reuse it publicly.
