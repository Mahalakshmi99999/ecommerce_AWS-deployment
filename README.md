# ecommerce_AWS-deployment

E-Commerce Website Deployment on AWS EC2

This project demonstrates deploying a fully functional PHP & MySQL-based E-Commerce Application on Amazon Web Services (AWS).
The deployment includes configuring an EC2 instance, setting up a web server, database, permissions, and hosting a live production-ready web application.


---

Features of the Application

User Registration & Login

Add to Cart

Product Browsing

Order Placement

Payment Simulation Page

Admin Panel to Add, Edit, Delete Products



---

Deployment Architecture

Component	Technology Used

Server	AWS EC2 (Ubuntu)
Web Server	Apache2
Backend	PHP
Database	MySQL (phpMyAdmin export)
Security	Key-based SSH Login
Permissions	Linux File Ownership & chmod



---

Steps Performed in Deployment

1. Created EC2 Instance (t2.micro, Ubuntu)


2. Connected via SSH using PEM Key


3. Installed Apache, PHP & MySQL


4. Cloned Project Files to /var/www/html


5. Configured Database & Imported SQL File


6. Updated db.php with new EC2 credentials


7. Applied file permissions & restarted Apache


8. Tested site using EC2 public IP




---

Commands Used (Summary)

sudo apt update && sudo apt upgrade -y
sudo apt install apache2 php mysql-server php-mysql -y
sudo git clone <https://github.com/Mahalakshmi99999/ecommerce_AWS-deployment> /var/www/html
sudo mysql_secure_installation
sudo mysql ecommerce_db < ecommerce.sql
sudo systemctl restart apache2


---

Project Structure

📁 ecommerce_AWS_deployment
 ├── admin/
 ├── pages/
 ├── includes/
 ├── images/
 ├── style.css
 ├── index.php
 ├── ecommerce.sql
 └── README.md


---

How to Run Locally (Optional)

1. Install XAMPP


2. Copy project folder to htdocs


3. Import ecommerce.sql into phpMyAdmin


4. Update db.php credentials


5. Run:



http://localhost/ecommerce


---

Live Deployment Status

✔ Successfully deployed on AWS
✔ SQL imported
✔ Apache server running


---

Author

Mahalakshmi Pasumarthi