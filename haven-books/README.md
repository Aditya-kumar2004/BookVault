<div align="center">

<img src="public/banner.png" alt="BookVault Banner" width="100%" />

<br/>
<br/>

<img src="public/bookvault-logo.png" alt="BookVault Logo" height="60" />

<br/>
<br/>

**The Next Chapter in Your Reading Journey**

*A full-featured, premium online bookstore built with React, Vite & Tailwind CSS*

<br/>

[![React](https://img.shields.io/badge/React-18.3-61DAFB?style=for-the-badge&logo=react&logoColor=white)](https://react.dev/)
[![Vite](https://img.shields.io/badge/Vite-5.4-646CFF?style=for-the-badge&logo=vite&logoColor=white)](https://vitejs.dev/)
[![JavaScript](https://img.shields.io/badge/JavaScript-ES2020-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)](https://developer.mozilla.org/en-US/docs/Web/JavaScript)
[![Tailwind CSS](https://img.shields.io/badge/TailwindCSS-3.4-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white)](https://tailwindcss.com/)
[![Zustand](https://img.shields.io/badge/Zustand-5.0-FF6B35?style=for-the-badge&logo=npm&logoColor=white)](https://zustand-demo.pmnd.rs/)
[![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)](LICENSE)

</div>

---

## 🔭 Overview

**BookVault** is a state-of-the-art online bookstore platform built for the modern reader. Featuring a curated catalogue of 2M+ titles, real-time cart and wishlist management, a fully functional admin dashboard, and a sleek dark/light mode UI — BookVault delivers a premium shopping experience from the very first page load.

The project is fully converted from TypeScript to **plain JavaScript (JSX/JS)**, eliminating build complexity while retaining all runtime functionality.

---

## ✨ Key Features

| Feature | Description |
|---|---|
| 🏠 **Landing Page** | Cinematic hero section, curated bestsellers, genre browsing, author spotlights & promo banners |
| 🛒 **Cart System** | Persistent cart with quantity controls, live item count, and animated badge |
| ❤️ **Wishlist** | Toggle per-book wishlist with instant toast feedback, persisted across sessions |
| 🔐 **Authentication** | Login & Register flows with protected routes and role-based access (Reader / Admin) |
| 📊 **Admin Dashboard** | Revenue charts, order management, inventory alerts, user management, coupons & activity log |
| 👤 **User Dashboard** | Personal library, wishlist view, order history, reviews & account settings |
| 🎨 **Dark Mode** | System-aware theming via `next-themes` |
| 📱 **Responsive** | Mobile-first layout — works flawlessly from 320px to 4K |
| ⚡ **Performance** | Lazy image loading, code-split routes, Framer Motion micro-animations |

---

## 🧱 Technology Stack

| Layer | Technology |
|---|---|
| **Framework** | [React 18](https://react.dev/) + [Vite 5](https://vitejs.dev/) |
| **Language** | JavaScript (ES2020 · JSX) |
| **Styling** | [Tailwind CSS 3](https://tailwindcss.com/) + [shadcn/ui](https://ui.shadcn.com/) |
| **Routing** | [React Router v6](https://reactrouter.com/) |
| **State** | [Zustand 5](https://zustand-demo.pmnd.rs/) with `persist` middleware |
| **Data Fetching** | [TanStack Query v5](https://tanstack.com/query/latest) |
| **Animations** | [Framer Motion 12](https://www.framer.com/motion/) |
| **Charts** | [Recharts 2](https://recharts.org/) |
| **Forms** | [React Hook Form](https://react-hook-form.com/) + [Zod](https://zod.dev/) |
| **Notifications** | [Sonner](https://sonner.emilkowal.ski/) + shadcn Toast |
| **Testing** | [Vitest](https://vitest.dev/) + [Testing Library](https://testing-library.com/) |
| **Fonts** | Playfair Display · DM Sans (Google Fonts) |

---

## 📁 Project Structure

```
haven-books/
├── public/
│   ├── bookvault-logo.png    # High-res professional logo
│   ├── banner.png            # README banner
│   └── robots.txt
├── src/
│   ├── components/
│   │   ├── ui/               # shadcn/ui base components (16 active)
│   │   │   ├── button.jsx
│   │   │   ├── card.jsx
│   │   │   ├── dialog.jsx
│   │   │   └── ...
│   │   ├── landing/
│   │   │   ├── Hero.jsx      # Landing hero section
│   │   │   └── Sections.jsx  # BookOfMonth, Genres, Deals, Authors, Trust
│   │   ├── BookCard.jsx      # Reusable book card with hover Add-to-Cart
│   │   ├── Navbar.jsx        # Sticky nav with search, cart & wishlist badges
│   │   └── Footer.jsx        # Multi-column footer
│   ├── data/
│   │   └── books.js          # Book catalogue, genres & author data
│   ├── hooks/
│   │   ├── use-mobile.jsx    # Responsive breakpoint hook
│   │   └── use-toast.js      # Toast state management
│   ├── lib/
│   │   └── utils.js          # cn() class merge utility
│   ├── pages/
│   │   ├── Index.jsx         # Home page
│   │   ├── Shop.jsx          # Browse, Book Detail, Cart, Authors list
│   │   ├── Auth.jsx          # Login & Register pages
│   │   ├── NotFound.jsx      # 404 page
│   │   ├── dashboard/        # User dashboard (Library, Wishlist, Orders…)
│   │   └── admin/            # Admin panel (Overview, Books, Orders, Users…)
│   ├── stores/
│   │   └── index.js          # Zustand stores: cart · wishlist · auth
│   ├── App.jsx               # Root router & providers
│   └── main.jsx              # Entry point
├── vite.config.js
├── tailwind.config.js
├── eslint.config.js
└── package.json
```

---

## 🚀 Installation & Setup

### 1. Clone the repository

```bash
git clone https://github.com/Aditya-kumar2004/haven-books.git
cd haven-books
```

### 2. Install dependencies

```bash
npm install
```

### 3. Start the development server

```bash
npm run dev
```

> App will be running at **http://localhost:8080**

### 4. Build for production

```bash
npm run build
npm run preview
```

---

## 🔑 Demo Credentials

| Role | Email | Password |
|---|---|---|
| **Reader** | `reader@bookvault.io` | `password` |
| **Admin** | `admin@bookvault.io` | `password` |

---

## 📸 Screenshots

### 🏠 Home Page
> Hero section with animated book display, curated bestsellers, genre grid, author spotlights & promotional banner

### 🛒 Browse & Cart
> Filterable book grid with live search · Book detail pages · Cart with quantity management

### 📊 Admin Dashboard
> Revenue & order charts · Book/Author/Genre management · Inventory alerts · User administration · Coupon system

### 👤 User Dashboard
> Personal reading library · Wishlist · Order history · Account settings

---

## 🛠️ Available Scripts

```bash
npm run dev          # Start dev server at http://localhost:8080
npm run build        # Build production bundle
npm run preview      # Preview production build
npm run lint         # Run ESLint
npm run test         # Run Vitest tests once
npm run test:watch   # Run Vitest in watch mode
```

---

## 🧩 Architecture Decisions

- **JavaScript over TypeScript** — Project converted from TSX/TS to JSX/JS for broader accessibility and zero compiler overhead
- **Zustand with persist** — Lightweight global state with localStorage sync for cart, wishlist, and auth — no backend required
- **shadcn/ui** — Only the 16 components actually used in the project are included, keeping bundle size minimal
- **Vite SWC** — Uses `@vitejs/plugin-react-swc` for Rust-based JSX transform — faster than Babel
- **Open Library Covers** — Book cover images are fetched live from [OpenLibrary.org](https://openlibrary.org/dev/docs/api) by ISBN

---

## 🤝 Contributing

Contributions, issues and feature requests are welcome!

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

---

## 📄 License

Distributed under the **MIT License**. See [`LICENSE`](LICENSE) for more information.

---

<div align="center">

Made with ❤️ and ☕ by **Aditya Kumar**

⭐ Star this repo if you find it helpful!

</div>
