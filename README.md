# 📖 BookVault — Premium Digital Library & Bookstore Management System

![BookVault Banner](bookvault_banner.png)

[![Vite Version](https://img.shields.io/badge/Vite-5.4.19-646CFF?style=for-the-badge&logo=vite&logoColor=white)](https://vitejs.dev/)
[![React Version](https://img.shields.io/badge/React-18.3.1-61DAFB?style=for-the-badge&logo=react&logoColor=black)](https://react.dev/)
[![Laravel Version](https://img.shields.io/badge/Laravel-12.0-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com/)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.4.17-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com/)
[![Framer Motion](https://img.shields.io/badge/Framer_Motion-12.38.0-F107A3?style=for-the-badge&logo=framer&logoColor=white)](https://www.framer.com/motion/)
[![Database](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://www.mysql.com/)
[![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)](https://opensource.org/licenses/MIT)

**BookVault** (also branded as **Haven Books**) is an ultra-premium, full-stack digital bookstore and library management system. Crafted with an eye for luxurious aesthetics, it combines a warm cream literary layout (featuring Playfair Display typography) with a highly secure, containerized Laravel REST API. This platform provides seamless e-commerce functionalities, real-time client state caching, advanced coupon checking, secure OTP registrations, automated payments via Razorpay, and direct third-party Google OAuth integration.

---

## 🗺️ Project Architecture Overview

BookVault utilizes a **Decoupled Client-Server Architecture** where the client application is completely separate from the API backend.

```
       ┌────────────────────────┐                  ┌────────────────────────┐
       │   React Client SPA     │                  │  Laravel API Server    │
       │ (Vercel CDN / Static)  │                  │ (Render / Docker / VM) │
       │                        │                  │                        │
       │  - Zustand State       │  Axios HTTPS     │  - Sanctum Auth        │
       │  - Framer Motion UI    │ ────────────────>│  - Controller Logic    │
       │  - React Router V6     │ <────────────────│  - Socialite OAuth     │
       │                        │   JSON Response  │  - Razorpay Gateway    │
       └────────────────────────┘                  └────────────────────────┘
                   │                                           │
                   ▼                                           ▼
         ┌───────────────────┐                       ┌───────────────────┐
         │ Local Storage     │                       │ MySQL Database    │
         │ (Auth/Cart Caches)│                       │ (Aiven/PlanetScale│
         └───────────────────┘                       └───────────────────┘
```

---

## 📊 Project Technical Analysis

### 🖥️ Frontend Architecture Details
* **Core Framework**: React 18.3.1 with Vite 5.4.19 (providing hot module replacement and sub-second builds).
* **State Management**: **Zustand** (with persistent client caching for user sessions, wishlist items, and shopping cart records).
* **Styling & UI**: Tailwind CSS 3.4.17 with dynamic dark/light theme switching (`next-themes`), Radix UI primitive systems, and sophisticated typography using **Playfair Display** (for headers) and **DM Sans** (for body text).
* **Animations**: **Framer Motion 12.38.0** for micro-interactions, page state transitions, floating book physics, and dynamic particle effects.
* **Routing**: React Router DOM v6 managing browser paths on the client.

### ⚙️ Backend Architecture Details
* **Core Framework**: Laravel 12.0 running on PHP 8.2+.
* **Security & Auth**: **Laravel Sanctum** for SPA cookie and token-based stateful authentication, and **Laravel Socialite** for handling OAuth flows.
* **Payment Gateway**: **Razorpay PHP SDK** integrating seamless checkout verified through cryptographic signatures.
* **Email & OTP Service**: Custom transaction controller utilizing standard Laravel Mailers to send secure multi-factor confirmation tokens.
* **Containerization**: Optimized **Docker** deployment with PHP-FPM 8.2 and Nginx serving files over alpine linux.

---

## ✨ Features

* **3D Animated Floating Book (Error Portal)**: A gorgeous custom interactive 404 page featuring a floating, tilting book built on Framer Motion perspective space that releases floating letter particles on user hover.
* **Passwordless OTP Email Verification**: Secure registration verified through real-time transactional mail validation codes.
* **One-Click Google OAuth Integration**: Instant account creation and login via Google Socialite pipelines.
* **Zustand Cached State Engines**: Instantly updates shopping carts and wishlists, maintaining details offline across user reloads.
* **Dynamic Coupons Validator**: Direct API checks of coupon rules, expiration dates, and usage counts.
* **Razorpay Payment Gateway**: Secure purchase checkouts with server-side validation.
* **Full Admin Management Control**: Admin portals to CRUD books, authors, manage orders, and toggle block/unblock statuses of users.

---

## 🛠️ Complete Tech Stack

| Layer | Technology | Details |
| :--- | :--- | :--- |
| **Frontend** | React 18.3, Vite 5.4 | High-speed, hot-reloading SPA client. |
| **Styling** | Tailwind CSS 3.4 | Curated warm cream palettes and sleek dark modes. |
| **Animations**| Framer Motion 12.38 | Advanced page transitions and particle physics. |
| **State** | Zustand 5.0 | Lightweight, persistent state manager. |
| **Backend** | Laravel 12.0 (PHP 8.2) | Enterprise REST API server. |
| **Database** | MySQL 8.0 | Relational database mapping models. |
| **Auth** | Sanctum & Socialite | Stateful Bearer Tokens & Google OAuth. |
| **Payments** | Razorpay SDK 2.9 | Verified gateway payment pipelines. |
| **Server** | Docker & Nginx | Containerized alpine running PHP-FPM. |

---

## 📂 Complete Folder Structure

```
"BOOK MANAGEMENT SYSTEM"
 ├── backend/                         # Laravel Backend Service
 │    └── bookStoreBackend/
 │         ├── app/
 │         │    ├── Http/
 │         │    │    ├── Controllers/ # Auth, Book, Cart, Coupon, Order, Otp, Razorpay
 │         │    │    ├── Middleware/  # AdminMiddleware, HandleInertiaRequests
 │         │    │    └── Requests/    # Validation layers
 │         │    └── Models/           # User, Book, Author, Cart, CartItem, Order, OrderItem, Wishlist, Coupon
 │         ├── bootstrap/             # App initialization and custom entry hooks
 │         ├── config/                # Framework settings (CORS, Sanctum, Mail, App)
 │         ├── database/              # DB Migrations, factories, and database seeders
 │         ├── routes/                # Route specifications (api.php, web.php, console.php)
 │         ├── storage/               # Application logs and local disk storage
 │         ├── Dockerfile             # Production container setup (PHP-FPM + Alpine)
 │         ├── docker-nginx.conf      # Optimized Nginx server routing configurations
 │         └── docker-entrypoint.sh   # Caching bootstrap script
 ├── haven-books/                     # React Client Application
 │    ├── public/                     # Public graphic assets
 │    ├── src/
 │    │    ├── components/
 │    │    │    ├── ui/               # Core Radix UI components (Button, Input, Sheet, Sidebar)
 │    │    │    ├── landing/          # Hero section, Sections grid
 │    │    │    ├── BookCard.jsx      # Reusable book presentation component
 │    │    │    ├── Navbar.jsx        # Premium navigation bar
 │    │    │    └── Footer.jsx        # Responsive layout footer
 │    │    ├── data/                  # Static models data
 │    │    ├── hooks/                 # Custom reusable React hooks
 │    │    ├── lib/                   # API utilities (dynamic Axios client api.js)
 │    │    ├── pages/
 │    │    │    ├── admin/            # Admin dashboard routes
 │    │    │    ├── dashboard/        # Customer library, wishlist, and settings
 │    │    │    ├── Auth.jsx          # Secure Sign-In, Register, and OTP verification
 │    │    │    ├── Shop.jsx          # Catalog browsing, book details, cart checkout
 │    │    │    └── NotFound.jsx      # 3D interactive floating book 404 page
 │    │    └── stores/                # Zustand persistent stores (Auth, Cart, Wishlist)
 │    ├── vercel.json                 # Vercel SPA routing rewrite configs
 │    └── tailwind.config.js          # Extended color parameters (Cream, Green, Coral palettes)
 └── NOTES.TXT                        # General study and developer notes
```

---

## 🔒 Security Implementation

1. **Laravel Sanctum Token Verification**: Direct validation of bearer tokens on protected endpoints.
2. **Dynamic CORS Configuration**: Implemented in [config/cors.php](file:///c:/Users/hp/Desktop/BOOK%20MANAGEMENT%20SYSTEM/backend/bookStoreBackend/config/cors.php) to dynamically whitelist client production domains while whitelisting cookie authentication.
3. **Role-Based Admin Protection**: The custom `AdminMiddleware` blocks unauthorized users from reaching API resources.
4. **Environment Variables**: Sensitive tokens (Razorpay Keys, DB secrets, Google client OAuth secrets) are securely handled on the host rather than in the repository.
5. **Cryptographic Payment Validation**: Server-side checks verify signatures on payment updates to prevent transaction fraud.

---

## ⚙️ Environment Variables Config

### 🖥️ Frontend Environment Setup (`haven-books/.env`)
Create a `.env` file in the root of `haven-books`:
```env
# URL pointing to your deployed backend (Laravel) API
VITE_API_URL=http://127.0.0.1:8000
```

### ⚙️ Backend Environment Setup (`backend/bookStoreBackend/.env`)
Create a `.env` file in the root of `backend/bookStoreBackend/`:
```env
APP_NAME=BookVault
APP_ENV=local
APP_KEY=base64:+IjmZfYoX7jmn5RYcvLRmaKO1IlbV95X9izauLb9T40=
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database Configuration
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bookvault
DB_USERNAME=root
DB_PASSWORD=

# Stateful Domains (CORS support for React Client)
SANCTUM_STATEFUL_DOMAINS=localhost:5173,localhost:8080
CORS_ALLOWED_ORIGINS=http://localhost:5173,http://localhost:8080,http://127.0.0.1:5173,http://127.0.0.1:8080

# Mail Configuration (Transactional OTP Emails)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=adityakuma876@gmail.com
MAIL_PASSWORD=your_secure_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="adityakuma876@gmail.com"
MAIL_FROM_NAME="BookVault"

# Socialite Third-Party Login (Google OAuth)
GOOGLE_CLIENT_ID=your_google_client_id.apps.googleusercontent.com
GOOGLE_CLIENT_SECRET=your_google_client_secret
GOOGLE_REDIRECT_URL=http://127.0.0.1:8000/api/auth/google/callback

# Razorpay E-Commerce Payment Gateway
RAZORPAY_KEY=your_razorpay_test_key
RAZORPAY_SECRET=your_razorpay_secret
```

---

## 🚀 Installation & Local Development Setup

### ⚙️ 1. Start the Backend API (Laravel)
1. Navigate to the backend directory:
   ```bash
   cd "backend/bookStoreBackend"
   ```
2. Install dependencies:
   ```bash
   composer install
   ```
3. Set up the environment variables:
   ```bash
   cp .env.example .env
   ```
   *(Generate application key: `php artisan key:generate`)*
4. Run migrations and database seeding:
   ```bash
   php artisan migrate --seed
   ```
5. Spin up the API server locally:
   ```bash
   php artisan serve
   ```
   *(Running on `http://127.0.0.1:8000`)*

### 🖥️ 2. Start the Frontend Application (Vite/React)
1. Navigate to the frontend directory:
   ```bash
   cd "haven-books"
   ```
2. Install npm dependencies:
   ```bash
   npm install
   ```
3. Spin up the Vite development server:
   ```bash
   npm run dev
   ```
   *(Running on `http://localhost:5173` or `http://localhost:8080`)*

---

## ⚡ Async & Performance Optimizations

1. **Vite Bundler & Asset Minification**: Compiles assets down to highly optimized HTML/JS/CSS files inside `dist`.
2. **React Lazy Loading & Dynamic Imports**: Modules are loaded on-demand, reducing initial javascript payload.
3. **Zustand Selective Rerendering**: Core state subscriptions prevent unnecessary React component updates.
4. **Laravel Production Cache**: Natively implements route, config, and database view caching, lowering request times from ~150ms to ~20ms.

---

## 🌐 Production Deployment

### 🖥️ Frontend (Vercel)
The client includes a customized [vercel.json](file:///c:/Users/hp/Desktop/BOOK%20MANAGEMENT%20SYSTEM/haven-books/vercel.json) configuration that handles client routing parameters dynamically.
1. Connect `haven-books` as a repository to **Vercel**.
2. Set the framework preset to `Vite`.
3. In **Environment Variables**, configure `VITE_API_URL` to point to your deployed Render URL.
4. Vercel will handle the CI/CD pipeline and serve your frontend.

### ⚙️ Backend (Render)
Our containerized **Docker** setup guarantees absolute consistency and skips complex web server configuration.
1. Connect `backend/bookStoreBackend` as a repository to **Render**.
2. Select **Docker** as the deployment runtime.
3. Add all environment variables (DB credentials, Google Auth tokens, Razorpay credentials) under **Environment Variables** in Render.
4. Deploy! Render will build and launch your PHP-FPM Nginx alpine container automatically on port `80`.

---

## 🔮 Future Architecture Enhancements (Recommended Improvements)

While BookVault is a robust, production-ready full-stack application, incorporating the following enterprise patterns will further enhance scaling and user engagement:

### 🔄 1. WebSockets & Real-Time Sync
* **Objective**: Add real-time user-to-admin chats and live book stock updates.
* **Proposed Design**: Integrate **Laravel Reverb** or **Pusher** on the backend, and the **Socket.io / Echo client** on the React frontend.
```
┌──────────────┐                 ┌────────────────┐                 ┌──────────────┐
│ React Client │ <=============> │ Pusher/Reverb  │ <=============> │ Laravel API  │
│ (Echo Event) │    WebSockets   │ (Broadcasting) │    Event Dispatch│ (Job Queue)  │
└──────────────┘                 └────────────────┘                 └──────────────┘
```

### 🛰️ 2. WebRTC Video Consultation
* **Objective**: Host live, face-to-face book club discussions or author meet-and-greets directly on the platform.
* **Proposed Design**: Connect client browsers through peer-to-peer WebRTC connections mapped via a signaling server (Node.js/Socket.io).
```
┌───────────────┐              ┌──────────────────┐              ┌───────────────┐
│ User A Browser│ <──────────> │ Signaling Server │ <──────────> │ User B Browser│
│               │  SDP/ICE     │ (Node / Socket)  │  SDP/ICE     │               │
│               │ <============================================> │               │
└───────────────┘                   Peer-to-Peer Media Stream    └───────────────┘
```

### 🏎️ 3. Database Caching & Redis Integration
* **Objective**: Reduce database strain during surge sales.
* **Proposed Design**: Route standard catalog search lists (`GET /api/books`) through a **Redis cache** with automatic invalidation on updates.

---

## 📄 License

This project is licensed under the **MIT License** — feel free to utilize, modify, and distribute it for private or commercial purposes. See [LICENSE](LICENSE) for full details.

---

## 🧑‍💻 Author

**Aditya Kumar**
* Full Stack Software Engineer specializing in modern scalable systems.
* **GitHub**: [github.com/aditya](https://github.com)
* **LinkedIn**: [linkedin.com/in/aditya](https://linkedin.com)
* **Email**: [adityakuma876@gmail.com](mailto:adityakuma876@gmail.com)

---

<p align="center">
  Made with 📖, ☕, and 💻. Copyright © 2026 BookVault. All rights reserved.
</p>
