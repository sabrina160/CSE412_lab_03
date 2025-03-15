# Overview
This project is a multi-page dynamic portfolio generation system with user authentication. Users can input personal and professional details, which are stored in a MySQL database and used to generate a PDF portfolio. The system is built using PHP, MySQL, HTML, CSS, and JavaScript.
# Features
- User Authentication (Login, Register, Forgot Password, Update Password)
- Portfolio Form with multiple sections:
  - Personal Information
  - Skills
  - Work Experience
  - Projects & Publications (Optional)
  - Academic Background (Optional)
- Data Management (Add, Edit, Delete Entries)
- Generate PDF Portfolio
- Navigation Menu for Easy Access
# Technologies Used
- Frontend: HTML, CSS, JavaScript
- Backend: PHP
- Database: MySQL
- PDF Generation: TCPDF
# Installation Process
# Prerequisites
Ensure you have the following installed:
- XAMPP (or any Apache, PHP, MySQL server)
# Steps
1. Clone the repository:
   ```bash
     git clone https://github.com/sabrina160/Dynamic_Portfolio_Form_412.git
     cd .\Dynamic_Portfolio_Form_412\
2. Move the project folder to your local server directory (e.g., htdocs in XAMPP).
3. Import the database:
- Open phpMyAdmin.
- Create new database in MySQL
    - portfolio_form--> table: form_portfolio
    - login_form_portfolio--> table: login_form
    - reg_form_portfolio--> table: reg
- Start local server (Apache & MySQL in XAMPP).
- Open the browser and go to:
  ```bash
     http://localhost/Dynamic_Portfolio_Form_412/
# Usage
- Register/Login to create an account.
- Fill in your portfolio details in the provided forms.
- Click Generate PDF to download the formatted portfolio.
- Manage (edit/update) records as needed.

# Troubleshooting
- TCPDF Error (PNG Alpha Channel Issue):
  - Ensure GD or Imagick PHP extension is enabled.
  - Edit php.ini and uncomment extension=gd or extension=imagick.
- Database Connection Error:
  - Verify database credentials in connectP2.php.
  - Check if MySQL is running.
