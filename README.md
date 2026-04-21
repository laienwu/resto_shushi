# Wujin Sushi WordPress Theme

This repository now contains a usable WordPress theme plus a local Docker setup for running the site.

## What is included

- `wujin-sushi-theme/`: the actual WordPress theme
- `docker-compose.yml`: WordPress, MariaDB, and phpMyAdmin for local development
- `website_analysis.html`: saved reference snapshot of the original live site

## Local startup

1. Run `docker compose up -d`
2. Open `http://localhost:8088`
3. Complete the WordPress installer
4. Go to `Appearance > Themes` and activate `Wujin Sushi`

phpMyAdmin is available at `http://localhost:8089`

## What is editable from WordPress

- Homepage hero text, contact details, hours, CTA links: `Appearance > Customize > Restaurant Settings`
- Menu categories: `Menu Items > Menu Categories`
- Menu dishes and pricing: `Menu Items`
- Footer and primary navigation: `Appearance > Menus`
- Blog posts and regular pages: standard WordPress content types

## Suggested next steps after activation

1. Replace the default logo in `wujin-sushi-theme/assets/images/logo.png` or set a custom logo in the Customizer
2. Create real `Menu Item` entries with featured images, prices, badges, and categories
3. Point the reservation and ordering URLs to your real booking and checkout pages
4. Install WooCommerce if you want cart and checkout functionality

## Notes

- The theme works without WooCommerce, but if WooCommerce is installed it exposes a cart link in the header.
- The homepage uses a real custom post type for dishes instead of hardcoded mock cards.
