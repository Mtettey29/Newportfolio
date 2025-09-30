# Contact Form Setup Guide

I've created multiple email solutions for your portfolio contact forms. Choose the one that works best for your hosting situation.

## 🚀 Option 1: SMTP with PHPMailer (Recommended)

### What you get:
- Professional HTML-formatted emails
- Works with Gmail, Outlook, Yahoo, or any email provider
- Reliable delivery and error handling
- Beautiful email templates with your branding

### Setup Steps:

#### 1. Download PHPMailer
```bash
# Option A: Using Composer (recommended)
composer require phpmailer/phpmailer

# Option B: Manual download
# Download from: https://github.com/PHPMailer/PHPMailer
# Extract to your website folder
```

#### 2. Configure Gmail App Password (for Gmail)
1. Go to Google Account settings
2. Security → 2-Step Verification (enable if not already)
3. App passwords → Generate app password
4. Choose "Mail" and your device
5. Copy the 16-character password

#### 3. Update SMTP Configuration
Edit `send-email-smtp.php` lines 14-20:
```php
$smtp_config = [
    'host' => 'smtp.gmail.com',
    'port' => 587,
    'username' => 'michaeltettey29@gmail.com', // Your Gmail
    'password' => 'your-16-char-app-password',  // App password from step 2
    'encryption' => PHPMailer::ENCRYPTION_STARTTLS
];
```

#### 4. Upload Files
Upload these files to your web hosting:
- `send-email-smtp.php`
- `vendor/` folder (if using Composer)
- Your portfolio files

#### 5. Test
Submit a form and check your Gmail inbox!

---

## 📧 Option 2: Resend API (Modern & Reliable)

### What you get:
- Modern API-based email delivery
- 3,000 free emails per month
- Built-in analytics and tracking
- 99.9% delivery rate

### Setup Steps:

#### 1. Sign up for Resend
1. Go to [resend.com](https://resend.com)
2. Create free account
3. Verify your domain (or use their test domain initially)

#### 2. Get API Key
1. Go to API Keys section
2. Create new API key
3. Copy the key (starts with `re_`)

#### 3. Update Configuration
Edit `send-email-resend.php` line 6:
```php
$resend_api_key = "re_YOUR_ACTUAL_API_KEY_HERE";
```

#### 4. Update Form Actions
Change form actions in HTML files:
```html
<form action="send-email-resend.php" method="POST">
```

#### 5. Upload and Test
Upload `send-email-resend.php` and test!

---

## 📮 Option 3: Simple PHP Mail (Basic)

If your hosting supports PHP mail() function, use `send-email.php` as-is.

### Setup:
1. Upload `send-email.php`
2. Change form actions to `send-email.php`
3. Test (note: some hosting providers block mail() function)

---

## 🌐 Option 4: Netlify Forms (No Backend Required)

If deploying to Netlify:
1. Keep current Netlify form setup
2. Deploy to Netlify
3. Configure notifications in Netlify dashboard

---

## 📋 Current Setup

Your forms are currently configured for **SMTP with PHPMailer**.

### Files Created:
- ✅ `send-email-smtp.php` - SMTP email handler
- ✅ `send-email-resend.php` - Resend API handler  
- ✅ `send-email.php` - Basic PHP mail handler
- ✅ `thank-you.html` - Success page
- ✅ Updated forms in `index.html` and `contact.html`

### Email Features:
- ✅ Professional HTML email templates
- ✅ Mobile-responsive email design
- ✅ Your brand colors (#2E6F40, #253D2C)
- ✅ Complete form data capture
- ✅ Timestamps and source identification
- ✅ Reply-to functionality
- ✅ Error handling and logging

### What Emails Look Like:
- Professional header with your branding
- Organized table with all contact details
- Highlighted message section
- Footer with submission timestamp
- Mobile-friendly design

## 🛠 Troubleshooting

### SMTP Issues:
1. **"Authentication failed"** → Check username/password
2. **"Connection timeout"** → Check host/port settings
3. **"SSL errors"** → Try port 465 with SSL instead of 587 with TLS

### Hosting Issues:
1. **"mail() function disabled"** → Use SMTP or Resend instead
2. **"PHPMailer not found"** → Install PHPMailer properly
3. **"Permission denied"** → Check file permissions (755 for folders, 644 for files)

### Testing:
1. Check error logs on your hosting
2. Test with a simple contact first
3. Verify spam folder in your Gmail

## 💡 Recommendations

1. **Best Overall**: SMTP with Gmail (most reliable)
2. **Easiest Setup**: Resend API (modern, simple)
3. **No Backend**: Netlify Forms (if using Netlify)
4. **Budget Option**: Basic PHP mail (limited reliability)

Choose the option that matches your hosting capabilities and preferences!