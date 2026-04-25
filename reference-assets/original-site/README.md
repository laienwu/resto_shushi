# Original Site Image Reference

This folder contains image assets downloaded from `website_analysis.html` so you can compare the source storefront against the current WordPress rebuild.

## What Was Downloaded

- `design/`
  - `logo.png`
  - `v8_instagram_pc.gif`
  - `product_no_image.png`
  - favicon files
- `categories/`
  - 31 category icons from the left-side menu in the source storefront
- `products/`
  - 219 full product photos used by the source menu cards
- `misc/`
  - `icon_emporter.png`

## What To Replace In WordPress

- Site logo:
  - Replace in `Appearance > Customize > Site Identity`
  - Reference file: [logo.png](E:/Users/laien/Documents/Python_Scripts/wordrpress/reference-assets/original-site/design/logo.png)
- Hero / promo / gallery photos:
  - Replace in `Appearance > Customize > Restaurant Settings`
  - Use your own restaurant, dish, or brand images
- Menu product photos:
  - Replace per item in `Menu Items > Edit item > Featured image`
  - Reference folder: [products](E:/Users/laien/Documents/Python_Scripts/wordrpress/reference-assets/original-site/products)
- Category rail thumbnails:
  - The current WordPress theme derives these automatically from the first product image found in each category
  - Reference folder: [categories](E:/Users/laien/Documents/Python_Scripts/wordrpress/reference-assets/original-site/categories)
  - If you want manual category icons exactly like the source site, the next step is adding an image field to the `menu_category` taxonomy
- Takeaway / order icon:
  - Reference file: [icon_emporter.png](E:/Users/laien/Documents/Python_Scripts/wordrpress/reference-assets/original-site/misc/icon_emporter.png)

## Important

- These are reference assets only. They are not wired into the theme automatically.
- The current rebuild already uses your WordPress content model, so the correct long-term approach is:
  - your own logo
  - your own menu photos
  - your own category visuals
  - your own ordering links

If you want, the next pass can do one of these:

1. Add manual category image upload support in WordPress.
2. Preload some of these reference assets into the theme/customizer as placeholders.
3. Build a clearer content admin guide showing exactly which screen edits each homepage block.
