# Panduan Instalasi Server - PPh 23 Calculator

Panduan ini menjelaskan cara men-deploy aplikasi **PPh 23 Calculator** di server produksi (VPS/Dedicated) menggunakan **Nginx** dan **PHP-FPM**.

## 📋 Prasyarat

Pastikan server Anda sudah terinstall:
- **PHP 8.0** atau lebih baru.
- **Nginx** Web Server.
- **Git** untuk clone repository.

## 🚀 Langkah Instalasi

### 1. Clone Repository
Masuk ke direktori web root Anda (contoh: `/home/nizen-apps/htdocs/apps.nizen.my.id`).

```bash
cd /home/nizen-apps/htdocs/apps.nizen.my.id
git clone https://github.com/mbahnizen/pph23-calculator.git
```

> **Catatan:** Jika folder `pph23-calculator` sudah ada, cukup masuk dan lakukan pull:
> ```bash
> cd pph23-calculator
> git pull origin main
> ```

### 2. Struktur Direktori
Pastikan struktur folder terlihat seperti ini:

```text
pph23-calculator/
├── public/           <-- Root web server mengarah ke sini
│   └── index.php
├── src/
│   └── TaxCalculator.php
├── templates/
│   └── main.php
└── INSTALL.md
```

### 3. Konfigurasi Nginx (Virtual Host)

Tambahkan blok konfigurasi berikut ke file Virtual Host Nginx Anda (misalnya di `/etc/nginx/sites-available/apps.nizen.my.id` atau `vhost.conf` Anda):

```nginx
# ==========================================
# KONFIGURASI PPH23 CALCULATOR (PHP)
# Port Proxy: 20004 (Contoh jika menggunakan reverse proxy)
# Atau akses langsung via sub-path
# ==========================================

location ^~ /pph23-calculator {
    # Sesuaikan root dengan lokasi fisik aplikasi di server
    root /home/nizen-apps/htdocs/apps.nizen.my.id;
    
    index index.html index.php;
    
    # Routing ke entry point di folder public
    try_files $uri $uri/ /pph23-calculator/public/index.php?$args;

    # Konfigurasi PHP Processing
    location ~ \.php$ {
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_intercept_errors off;
        fastcgi_index index.php;
        
        # Sesuaikan dengan upstream PHP-FPM Anda
        # Contoh via TCP Port (sesuai setup Anda sebelumnya di port 20004)
        fastcgi_pass 127.0.0.1:20004; 
        
        # Atau via Unix Socket (umumnya di Linux)
        # fastcgi_pass unix:/run/php/php8.1-fpm.sock;

        fastcgi_param HTTPS "on";
    }
}
```

### 4. Restart Nginx
Setelah menyimpan konfigurasi, tes validasi config dan restart Nginx:

```bash
sudo nginx -t
sudo systemctl reload nginx
```

## ✅ Verifikasi

Buka browser dan akses URL aplikasi Anda, misalnya:
`https://apps.nizen.my.id/pph23-calculator`

Jika muncul kalkulator PPh 23, berarti instalasi berhasil! 🎉
