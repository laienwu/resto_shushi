# Wujin Sushi WordPress Website Implementation Guide

Current note: the repository now contains a runnable Docker setup and a bootable WordPress theme. Treat `README.md` and `docker-compose.yml` as the current quickstart; this guide remains useful for migration and content-planning details.

## Overview
This guide provides comprehensive instructions for implementing the Wujin Sushi restaurant website using WordPress, based on the analysis of the original website at https://wujinsushi.fr/

## Table of Contents
1. [Prerequisites](#prerequisites)
2. [Setup Instructions](#setup-instructions)
3. [Theme Installation](#theme-installation)
4. [Plugin Installation & Configuration](#plugin-installation--configuration)
5. [Content Setup](#content-setup)
6. [Menu Configuration](#menu-configuration)
7. [Reservation System](#reservation-system)
8. [Online Ordering](#online-ordering)
9. [Styling & Customization](#styling--customization)
10. [Testing & Launch](#testing--launch)

## Prerequisites

### System Requirements
- Web server (Apache, Nginx, or IIS)
- PHP 7.4 or higher
- MySQL 5.7 or higher (or MariaDB 10.2 or higher)
- WordPress 6.0 or higher

### Development Tools (Optional)
- Local development environment (XAMPP, WAMP, MAMP, or Docker)
- Code editor (VS Code, PHPStorm, etc.)
- Git for version control

## Setup Instructions

### Option 1: Local Development with XAMPP/WAMP

1. **Install XAMPP/WAMP**: Download and install from official websites
2. **Start services**: Launch Apache and MySQL
3. **Create database**: 
   - Access phpMyAdmin at `http://localhost/phpmyadmin`
   - Create a new database named `wujin_sushi`
4. **Download WordPress**: Get latest version from https://wordpress.org
5. **Install WordPress**:
   - Extract WordPress files to `htdocs/wujin-sushi`
   - Run installation at `http://localhost/wujin-sushi`
   - Follow the famous 5-minute installation

### Option 2: Docker Development Environment

1. **Install Docker**: Download Docker Desktop from https://www.docker.com
2. **Create `docker-compose.yml`**:

```yaml
version: '3.8'

services:
  wordpress:
    image: wordpress:latest
    ports:
      - "8000:80"
    environment:
      WORDPRESS_DB_HOST: db
      WORDPRESS_DB_USER: wordpress
      WORDPRESS_DB_PASSWORD: wordpress
      WORDPRESS_DB_NAME: wujin_sushi
    volumes:
      - ./wordpress:/var/www/html
      - ./wujin-sushi-theme:/var/www/html/wp-content/themes/wujin-sushi-theme
    depends_on:
      - db

  db:
    image: mysql:5.7
    environment:
      MYSQL_DATABASE: wujin_sushi
      MYSQL_USER: wordpress
      MYSQL_PASSWORD: wordpress
      MYSQL_ROOT_PASSWORD: rootpassword
    volumes:
      - ./mysql:/var/lib/mysql

  phpmyadmin:
    image: phpmyadmin/phpmyadmin
    ports:
      - "8080:80"
    environment:
      PMA_HOST: db
      MYSQL_ROOT_PASSWORD: rootpassword
    depends_on:
      - db
```

3. **Run containers**: `docker-compose up -d`
4. **Access WordPress**: `http://localhost:8000`
5. **Access phpMyAdmin**: `http://localhost:8080`

## Theme Installation

### Install the Wujin Sushi Theme

1. **Copy theme files**: Place the `wujin-sushi-theme` folder in `wp-content/themes/`
2. **Activate theme**:
   - Go to WordPress Admin → Appearance → Themes
   - Find "Wujin Sushi" and click "Activate"

### Theme Structure

The theme includes the following key files:

- `style.css` - Main stylesheet with theme metadata
- `index.php` - Main template file
- `header.php` - Header template
- `footer.php` - Footer template
- `functions.php` - Theme functionality
- `inc/` - Theme includes and modules
- `assets/images/` - Theme images and logo
- `js/theme.js` - Custom JavaScript
- `css/admin-style.css` - Admin area styling

### Theme Features

- **Responsive Design**: Mobile-friendly layout
- **Custom Color Scheme**: Blue (#001973) and Yellow (#ffc859)
- **Menu Categories Grid**: Interactive menu navigation
- **Shopping Cart Modal**: For online orders
- **Reservation System**: Table booking integration
- **User Accounts**: Customer registration and login
- **Custom Post Types**: For menu items

## Plugin Installation & Configuration

### Essential Plugins

1. **WooCommerce** - For online ordering and menu management
   - Install and activate
   - Configure basic settings (currency, location, etc.)
   - Set up product categories matching the menu structure

2. **Elementor** - Page builder for easy layout design
   - Install and activate
   - Use for creating custom page layouts

3. **Restaurant Reservations** - For table booking system
   - Install "Restaurant Reservations" plugin
   - Configure reservation settings
   - Set up available times and party sizes

4. **Contact Form 7** - For customer inquiries
   - Install and activate
   - Create contact form for the "À propos" page

5. **WPForms** - Alternative form builder
   - Install and activate
   - Create reservation and contact forms

6. **Yoast SEO** - For search engine optimization
   - Install and activate
   - Configure SEO settings
   - Add meta descriptions and titles

### Recommended Plugins

- **WPML** - For multilingual support (French/English)
- **Smush** - Image optimization
- **W3 Total Cache** - Performance optimization
- **Wordfence Security** - Website security
- **UpdraftPlus** - Backup solution

## Content Setup

### Basic Pages

1. **Home Page** (already structured in theme)
   - Hero section with restaurant info
   - Menu categories grid
   - Featured products

2. **À propos** (About Us)
   - Restaurant history and story
   - Chef information
   - Location and contact details
   - Contact form

3. **Réservation** (Reservation)
   - Reservation form
   - Opening hours
   - Special events information

4. **Menu** (Menu)
   - Complete menu listing
   - Menu categories
   - Pricing information

5. **Blog** (News)
   - Restaurant news
   - Special offers
   - Events

### Menu Structure

Create the following menu structure in WordPress:

- **Primary Menu**:
  - Accueil (Home)
  - À propos (About)
  - Réservation (Reservation)
  - Menu
  - Blog
  - Contact

### Widget Areas

Configure widgets in Appearance → Widgets:

- **Sidebar**: Add useful widgets like search, recent posts, categories
- **Footer**: Add contact information, opening hours, social media links

## Menu Configuration

### Using WooCommerce for Menu

1. **Create Product Categories**:
   - Consultés par nos chefs
   - Menu Midi
   - Menu Mixte
   - Menus Tibetan
   - Menus brochettes
   - Menu A
   - Menu J
   - Menus Chirashi
   - Menu Bateau
   - Menu Speciaux
   - Poke Bowl
   - Spécial Roll
   - Nos Burgers
   - Hors D'oeuvre
   - Nos Maki
   - Yakitori
   - Nos Sushi
   - Saumon Roll

2. **Add Menu Items**:
   - For each category, add products with:
     - Title (dish name)
     - Description (ingredients)
     - Price
     - Featured image
     - Category assignment

3. **Configure Product Display**:
   - Use WooCommerce shortcodes in pages
   - Example: `[products category="sushi" limit="12" columns="4"]`

### Custom Menu Items (Alternative)

If not using WooCommerce:

1. **Use Custom Post Type**:
   - The theme includes a "Menu Items" custom post type
   - Add menu items with featured images and descriptions

2. **Create Menu Categories**:
   - Use WordPress categories to organize menu items

## Reservation System

### Setup Restaurant Reservations Plugin

1. **Install Plugin**: Restaurant Reservations by Five Star Plugins
2. **Configure Settings**:
   - Go to Reservations → Settings
   - Set restaurant name, email, phone
   - Configure available times and party sizes
   - Set reservation rules (advance notice, etc.)

3. **Add Reservation Form**:
   - Use shortcode `[restaurant-reservations]` on reservation page
   - Or use the reservation form widget

### Custom Reservation Form

Alternatively, create a custom form with WPForms:

1. **Create New Form**:
   - Name, Email, Phone
   - Date, Time, Number of guests
   - Special requests

2. **Add to Page**:
   - Use WPForms shortcode on reservation page

## Online Ordering

### WooCommerce Setup

1. **Configure WooCommerce**:
   - Go to WooCommerce → Settings
   - Set up payment methods (credit card, PayPal, etc.)
   - Configure shipping methods (pickup, delivery)
   - Set tax rates if applicable

2. **Create Menu Products**:
   - Add all menu items as products
   - Set prices and categories
   - Add product images

3. **Configure Checkout**:
   - Set up checkout fields
   - Configure order confirmation emails
   - Set up thank you page

### Takeaway/Delivery Options

1. **Create Product Attributes**:
   - Add "Delivery Method" attribute
   - Options: Takeaway, Delivery

2. **Set Up Shipping Zones**:
   - Configure delivery areas and costs
   - Set minimum order amounts

## Styling & Customization

### Customize Theme Colors

Edit the CSS variables in `style.css`:

```css
:root{
    --v8-base-color: #001973;
    --v8-primary-color: #ffc859;
    --v8-text-active-color: #cf0018;
    --v8-background-color: #ffffff;
    --v8-form-color: #FFFFFF;
    --v8-text-color: #001973;
    --v8-button-text-color: #001973;
    --v8-error-color: #FF3F62;
}
```

### Customize Logo

1. **Replace Logo**:
   - Replace `assets/images/logo.png` with your restaurant logo
   - Recommended size: 200x200 pixels

2. **Update Favicon**:
   - Add favicon.ico to theme root directory
   - Or use a plugin like "Favicon by RealFaviconGenerator"

### Customize Fonts

Edit the Google Fonts import in `header.php`:

```html
<link href="https://fonts.googleapis.com/css2?family=Potta+One&family=Fira+Code:wght@300;600&display=swap" rel="stylesheet">
```

### Customize Menu Icons

The theme uses SVG icons for menu categories. Customize them by:

1. **Edit SVG paths** in the template files
2. **Replace with custom icons** by modifying the SVG code

## Testing & Launch

### Pre-Launch Checklist

1. **Functionality Testing**:
   - Test all links and navigation
   - Test contact forms
   - Test reservation system
   - Test online ordering process
   - Test user registration and login

2. **Responsive Testing**:
   - Test on desktop, tablet, and mobile devices
   - Check all breakpoints
   - Test touch interactions on mobile

3. **Performance Testing**:
   - Run Google PageSpeed Insights
   - Optimize images
   - Enable caching
   - Minify CSS and JavaScript

4. **SEO Testing**:
   - Check meta titles and descriptions
   - Test XML sitemap
   - Verify robots.txt
   - Check schema markup

### Launch Procedure

1. **Backup**: Create full backup of website and database
2. **Maintenance Mode**: Enable maintenance mode during launch
3. **DNS Configuration**: Point domain to hosting server
4. **SSL Certificate**: Install and configure HTTPS
5. **Final Testing**: Test everything on live server
6. **Go Live**: Disable maintenance mode
7. **Monitor**: Watch for errors and performance issues

## Maintenance & Updates

### Regular Maintenance Tasks

1. **WordPress Updates**: Keep core, themes, and plugins updated
2. **Backup Schedule**: Regular automated backups
3. **Security Monitoring**: Check for vulnerabilities
4. **Performance Optimization**: Regular speed tests
5. **Content Updates**: Keep menu and information current

### Update Procedure

1. **Backup**: Always backup before updates
2. **Test Updates**: Test on staging environment first
3. **Update Plugins**: Update one at a time
4. **Test Functionality**: Verify everything works after updates
5. **Rollback Plan**: Be prepared to revert if issues occur

## Troubleshooting

### Common Issues

1. **White Screen of Death**:
   - Check PHP error logs
   - Disable plugins one by one
   - Switch to default theme

2. **Menu Not Displaying**:
   - Verify menu is assigned in Appearance → Menus
   - Check theme location settings

3. **Reservation Form Not Working**:
   - Check plugin settings
   - Verify email configuration
   - Test SMTP settings

4. **Online Ordering Issues**:
   - Check WooCommerce settings
   - Verify payment gateway configuration
   - Test checkout process

### Debugging Tools

- **WordPress Debug**: Enable `WP_DEBUG` in wp-config.php
- **Query Monitor**: Plugin for debugging database queries
- **Health Check**: Built-in WordPress site health tool
- **Browser Developer Tools**: For frontend debugging

## Additional Resources

- **WordPress Codex**: https://codex.wordpress.org/
- **WooCommerce Docs**: https://docs.woocommerce.com/
- **Elementor Docs**: https://elementor.com/help/
- **Restaurant Reservations Docs**: https://www.fivestarplugins.com/

## Support

For issues with this theme implementation:

1. Check the WordPress support forums
2. Consult plugin documentation
3. Review theme code and comments
4. Contact the original developer if available

## Conclusion

This guide provides a comprehensive approach to implementing the Wujin Sushi website using WordPress. The theme is designed to closely match the original website's functionality and design while leveraging WordPress's powerful content management capabilities.

By following this guide, you should be able to create a fully functional restaurant website with online ordering, reservations, and all the features needed to run a successful restaurant business online.
