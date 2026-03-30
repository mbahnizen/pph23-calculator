# 📦 Panduan Instalasi — PPh 23 Calculator

Panduan ini menjelaskan cara men-deploy aplikasi **PPh 23 Calculator** di berbagai lingkungan server.

---

## 📋 Prasyarat

| Kebutuhan | Keterangan |
| --- | --- |
| **PHP 8.0+** | Dengan ekstensi default (tidak butuh ekstensi tambahan) |
| **Composer** | Untuk autoload & dependency management |
| **Node.js / npx** | Untuk build Tailwind CSS (hanya sekali saat deploy) |
| **Git** | Untuk clone repository |

---

## 🚀 Langkah Instalasi

### 1. Clone & Install

```bash
# Clone repository
git clone https://github.com/mbahnizen/pph23-calculator.git
cd pph23-calculator

# Install PHP dependencies (tanpa dev dependencies)
composer install --no-dev --optimize-autoloader

# Build CSS
npx tailwindcss -i ./input.css -o ./public/assets/css/style.css --minify
```

### 2. Pastikan Struktur Direktori

```text
pph23-calculator/
├── public/                ← Web root mengarah ke sini
│   ├── index.php          ← Entry point utama
│   └── assets/css/style.css
├── app/
│   ├── Services/TaxCalculator.php
│   └── Helpers/NumberParser.php
├── views/
│   └── calculator.php
├── vendor/                ← Di-generate oleh Composer
└── ...
```

> [!IMPORTANT]
> **Web root harus mengarah ke folder `public/`**, bukan ke root project. Ini mencegah file seperti `composer.json` dan `vendor/` bisa diakses dari browser.

### 3. Atur Permission (Linux/Mac)

```bash
# Folder: 755, File: 644
find . -type d -exec chmod 755 {} \;
find . -type f -exec chmod 644 {} \;

# Sesuaikan owner dengan user web server
# Contoh: www-data (Ubuntu/Debian), nginx (CentOS/RHEL), dll.
chown -R www-data:www-data .
```

---

## 🌐 Konfigurasi Web Server

<details>
<summary><strong>🟢 Nginx + PHP-FPM (Recommended)</strong></summary>

### Opsi A: Standalone (domain/subdomain sendiri)

Cocok jika project diakses langsung lewat domain, misal `https://calc.example.com`.

```nginx
server {
    listen 80;
    server_name calc.example.com;  # Ganti dengan domain Anda

    root /var/www/pph23-calculator/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$args;
    }

    location ~ \.php$ {
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_pass unix:/run/php/php8.1-fpm.sock;  # Sesuaikan versi PHP
        fastcgi_index index.php;
    }

    location ~* \.(css|js|png|jpg|ico|svg|woff2?)$ {
        expires 30d;
        access_log off;
    }
}
```

### Opsi B: Subfolder (di bawah domain yang sudah ada)

Cocok jika project diakses lewat path, misal `https://example.com/pph23-calculator`.

```nginx
# Tambahkan di dalam blok server {} yang sudah ada

location ^~ /pph23-calculator {
    alias /var/www/pph23-calculator;  # Path ke root project
    index index.php;

    # Route semua request ke public/index.php
    try_files $uri $uri/ /pph23-calculator/public/index.php?$args;

    location ~ \.php$ {
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $request_filename;
        fastcgi_pass unix:/run/php/php8.1-fpm.sock;  # Sesuaikan versi PHP
        fastcgi_index index.php;
    }
}
```

Setelah konfigurasi, test & reload:

```bash
sudo nginx -t
sudo systemctl reload nginx
```

</details>

<details>
<summary><strong>🟠 Apache + mod_php / PHP-FPM</strong></summary>

### Opsi A: Virtual Host (domain sendiri)

```apache
<VirtualHost *:80>
    ServerName calc.example.com
    DocumentRoot /var/www/pph23-calculator/public

    <Directory /var/www/pph23-calculator/public>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

Pastikan `mod_rewrite` aktif dan buat file `public/.htaccess`:

```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^ index.php [L]
```

### Opsi B: Subfolder (symlink)

```bash
# Buat symlink dari folder public ke web root Apache
ln -s /var/www/pph23-calculator/public /var/www/html/pph23-calculator
```

Setelah konfigurasi:

```bash
sudo a2enmod rewrite
sudo systemctl reload apache2
```

</details>

<details>
<summary><strong>🔵 Laragon (Windows — Development)</strong></summary>

Laragon otomatis membuat virtual host. Cukup:

1. Clone/copy project ke `C:\laragon\www\pph23-calculator`
2. Pastikan Laragon sudah aktif (Start All)
3. Akses di browser: `http://pph23-calculator.test/public/`

Atau buat **pretty URL** dengan mengedit Laragon auto virtual host agar root mengarah ke `public/`.

</details>

<details>
<summary><strong>⚫ PHP Built-in Server (Development)</strong></summary>

Tanpa web server — cocok untuk testing cepat:

```bash
php -S localhost:8000 -t public/
```

Buka [http://localhost:8000](http://localhost:8000).

> [!WARNING]
> **Jangan gunakan di production.** PHP built-in server tidak dirancang untuk menangani traffic nyata.

</details>

---

## ✅ Verifikasi

Setelah selesai, buka URL yang sudah dikonfigurasi di browser. Jika kalkulator muncul dengan benar, instalasi berhasil! 🎉

Checklist cepat:

- [ ] Halaman kalkulator tampil tanpa error
- [ ] CSS ter-load (tampilan tidak polos/broken)
- [ ] Input angka bisa diisi dan hasil muncul otomatis

---

## 🔄 Update ke Versi Terbaru

```bash
cd /path/ke/pph23-calculator

git pull origin main
composer install --no-dev --optimize-autoloader
npx tailwindcss -i ./input.css -o ./public/assets/css/style.css --minify
```

> [!TIP]
> Tidak perlu restart web server setelah update — cukup pull, install, dan rebuild CSS.

---

## ❓ Troubleshooting

| Gejala | Kemungkinan Penyebab | Solusi |
| --- | --- | --- |
| Halaman blank / 500 Error | PHP error tersembunyi | Cek log: `tail -f /var/log/php*-fpm.log` |
| CSS tidak muncul | Build CSS belum dilakukan | Jalankan `npx tailwindcss -i ./input.css -o ./public/assets/css/style.css --minify` |
| 404 Not Found | Web root salah | Pastikan root mengarah ke folder `public/` |
| "Class not found" | Autoload belum di-generate | Jalankan `composer dump-autoload` |
