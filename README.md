# PrestaShop JavaScript and CSS Versioning for 1.7

## Overview

This project adds versioning to JavaScript and CSS files in PrestaShop 1.7.6, allowing developers to automatically append a version parameter to these assets. This feature ensures that updated scripts and styles are always loaded by users, avoiding issues caused by browser caching of outdated files.

The solution extends `JavascriptManager.php` and `StylesheetManager.php` in PrestaShop to append a `?v=` parameter, generated dynamically from each file's last modified timestamp. This allows browsers to recognize file updates immediately, ensuring that any changes are always visible to end users.

## How It Works

1. **Version Parameter Addition**  
   The code retrieves each asset’s last modified date and time, appending it as a version parameter (e.g., `style.css?v=1617898765`).
   
2. **Automatic Cache Busting**  
   When a JavaScript or CSS file is modified, its timestamp changes, resulting in a new `?v=` value. This prompts the browser to download the updated file, clearing the cache automatically.

## Why This Isn’t in Core PrestaShop

PrestaShop 1.7 lacks built-in versioning for static assets, leaving developers to handle cache busting independently. While caching can improve performance, the need for a core versioning feature is essential for avoiding display issues and ensuring a smooth end-user experience when assets are updated.

## Installation & Usage

1. Clone or download the files in this repository. Or just download the two files and place them in `your_prestashop_directory/override/classes/assets`.
2. Replace or extend `JavascriptManager.php` and `StylesheetManager.php` in your PrestaShop 1.7 installation with the modified versions.
3. Clear PrestaShop cache to ensure the new versioning system is active. And enjoy automatic versioning on your CSS and JavaScript files, ensuring updates are always loaded without cache issues!

This solution is tested for up to PrestaShop 1.7.8.10 and improves the cache handling of JavaScript and CSS files with minimal impact on performance.
