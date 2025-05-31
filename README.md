# PHP Contact Form with Email Notification

A simple contact form built using HTML, CSS, and PHP with PHPMailer for sending email notifications. This project is suitable for beginner to intermediate developers and demonstrates how to integrate a working email feature with SMTP support.

---

## 🔗 Live Demo

👉 [https://contact-form.free.nf](https://contact-form.free.nf)

---

## 📦 Tech Stack

- HTML5
- CSS3
- PHP 8+
- PHPMailer (via Composer)
- Google SMTP (configured for transactional email)

---

## ✉️ Features

- Contact form with Name, Email, and Message fields
- Sends email to site owner using PHPMailer + SMTP
- Sends confirmation email to the visitor
- Uses Composer to manage dependencies
- `.gitignore` prevents credentials from being committed
- Fully deployed on a free host (InfinityFree)

---

## 🔐 Security Notes

- SMTP credentials and API keys are stored in a separate `config.php` file
- `config.php` is **excluded from Git** via `.gitignore`
- Always keep secret credentials out of public repositories

---

## 🚀 Deployment

This project is live at [https://contact-form.free.nf](https://contact-form.free.nf) and was deployed using:
- InfinityFree for free PHP hosting
- FileZilla / Web File Manager for uploading files
- Composer for managing the `vendor/` folder

---

## 📁 Folder Structure



## 🧪 How to Run Locally
1. Clone the repo:
   ```bash
   git clone https://github.com/ammarumer/contact-form.git
2. Run a PHP server:
   ```bash
   php -S localhost:8000
3. Visit http://localhost:8000 in your browser   

🧩 Improvements Planned

    Store form data in a database

📄 License

MIT
