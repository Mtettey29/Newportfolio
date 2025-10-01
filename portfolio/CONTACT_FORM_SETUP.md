# Contact Form Setup Guide

Your portfolio includes PHP contact forms that won't work on static hosting platforms like GitHub Pages, Netlify, or Vercel. Here are free alternatives:

## Option 1: Formspree (Recommended)

1. **Sign up at [Formspree](https://formspree.io)**
2. **Create a new form project**
3. **Update your contact.html form action:**

```html
<form action="https://formspree.io/f/YOUR_FORM_ID" method="POST">
```

Replace `YOUR_FORM_ID` with the ID provided by Formspree.

## Option 2: Netlify Forms (If using Netlify)

1. **Add to your form tag:**
```html
<form name="contact" method="POST" data-netlify="true">
    <input type="hidden" name="form-name" value="contact">
    <!-- rest of your form fields -->
</form>
```

## Option 3: EmailJS

1. **Sign up at [EmailJS](https://emailjs.com)**
2. **Add EmailJS SDK before closing `</body>` tag:**
```html
<script src="https://cdn.jsdelivr.net/npm/@emailjs/browser@3/dist/email.min.js"></script>
```

3. **Initialize and use EmailJS in your JavaScript**

## Option 4: Google Forms

1. **Create a Google Form**
2. **Embed it in your contact page**
3. **Style it to match your design**

## Recommended Solution

For your portfolio, I recommend **Formspree** because:
- ✅ Free tier includes 50 submissions/month
- ✅ Easy setup (just change form action)
- ✅ Spam protection included
- ✅ Email notifications
- ✅ Works with any static hosting

## Current Status

Your current contact forms are set up for PHP. Once you deploy to a static hosting platform, update the form action URLs to use one of the above services.