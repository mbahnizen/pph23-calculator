# PPh 23 Calculator - Modern Finance Tool

A lightweight, modern web utility to calculate **PPh 23 (Income Tax)** and **PPN (VAT)** in real-time. Built with a robust **PHP** backend and a reactive **Alpine.js** frontend.

## 🚀 Features

- **Real-time Calculation**: Instant results as you type.
- **Math Input Support**: Type expressions like `1.000.000 + 500.000` directly.
- **Smart Parsing**: Handles typical Indonesian number formats (dots for thousands, commas for decimals).
- **Copy & Delight**: One-click copy with confetti effects.
- **Print Friendly**: Optimized CSS for generating clean PDF reports via Print command.
- **Robust Fallback**: Core logic runs on PHP, ensuring usage even without JavaScript.

## 🛠️ Technology Stack

- **Backend**: PHP 8.x
- **Frontend**: HTML5, Alpine.js
- **Styling**: Tailwind CSS (CDN)
- **Design System**: Glassmorphism with modern typography (Inter & Outfit).

## 📦 Installation / Usage

1. Clone this repository to your web server (e.g., Laragon/XAMPP `www` folder).
   ```bash
   git clone https://github.com/your-username/pph23-calculator.git
   ```
2. Navigate to the `public` folder.
3. Serve using your preferred web server or PHP's built-in server:
   ```bash
   cd pph23-calculator/public
   php -S localhost:8000
   ```
4. Open `http://localhost:8000` in your browser.

## 📝 License

&copy; 2024 @mbahnizen. All rights reserved.
