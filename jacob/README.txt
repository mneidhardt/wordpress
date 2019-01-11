Jacobs Wordpress theme og plugin.

Installation:

1. Installer Wordpress.

2. I Settings/permalinks sættes "Post name" til det aktive.

3. Aktiver Jactheme.

4. Aktiver Jacplugin.

5. I Settings/Jac Config trykkes på knappen "Create default pages".

6. Læg .htaccess i roden, dvs. der hvor wp-config.php findes.
Indhold i .htaccess er her:
# ---------------------

# BEGIN WordPress
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteBase /
RewriteRule ^index\.php$ - [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /index.php [L]
</IfModule>
# ---------------------
