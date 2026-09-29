# 🛒 Multi-Vendor E-Commerce Platform

A modern, scalable, and high-performance **Multi-Vendor E-Commerce Platform** designed to connect multiple independent sellers with customers worldwide. Built with a robust backend architecture, real-time analytics, split payment processing, and advanced search functionality.

---

## 📋 Table of Contents

- [Architecture Overview](#-architecture-overview)  
- [Key Features](#-key-features)  
  - [Customer Portal](#1-customer-portal)  
  - [Vendor Dashboard](#2-vendor-dashboard)  
  - [Super Admin Panel](#3-super-admin-panel)  
- [Tech Stack](#-tech-stack)  
- [System Architecture](#-system-architecture)  
- [Getting Started](#-getting-started)  
  - [Prerequisites](#prerequisites)  
  - [Installation & Setup](#installation--setup)  
- [API Reference](#-api-reference)  
- [Environment Variables](#-environment-variables)  
- [Contributing](#-contributing)  
- [License](#-license)

---

## 🏗 Architecture Overview

The platform uses a decoupled architecture separating the high-traffic storefront, vendor management portal, and backend API service layer:

- **Frontend (Storefront & Vendor Portal):** Next.js (React), Tailwind CSS, Redux Toolkit.  
- **Backend API:** Laravel 10 / Node.js (RESTful & GraphQL endpoints, Sanctum/JWT Auth).  
- **Database & Caching:** PostgreSQL / MySQL, Redis for caching & queue processing.  
- **Search & Indexing:** Elasticsearch / Meilisearch for high-speed catalog querying.  
- **Payments:** Stripe Connect for automated vendor payouts and split payments.

---

## ✨ Key Features

### 1\. Customer Portal

- 🔍 **Advanced Search & Filtering:** Instant searching by category, price, brand, rating, and vendor.  
- 🛒 **Unified Shopping Cart:** Add products from multiple vendors in a single checkout session.  
- 💳 **Secure Payment Gateway:** Credit Card, PayPal, and Apple Pay support with automated multi-vendor order splits.  
- 📦 **Real-time Order Tracking:** Live order state updates via WebSockets.  
- ⭐️ **Product Reviews & Ratings:** Verified buyer review system with media uploads.

### 2\. Vendor Dashboard

- 📊 **Analytics & Reports:** Revenue tracking, sales graphs, and top-selling products.  
- 📦 **Inventory & Product Management:** SKU tracking, multi-variant products (size, color, weight), and bulk uploads.  
- 💰 **Payout Management:** Automated payout scheduling via Stripe Connect.  
- 🚚 **Order Processing:** Custom shipping rules, order fulfillment, and tracking number assignment.

### 3\. Super Admin Panel

- 🛡 **Vendor Verification & Onboarding:** Manual or automated vendor approval workflow.  
- 💵 **Commission & Fee Management:** Flexible global or per-vendor commission structures.  
- 📈 **Platform-Wide Metrics:** Comprehensive revenue reports, active seller analytics, and dispute resolution system.  
- ⚙️ **System Configuration:** Global settings, tax rate management, and multi-currency settings.

---

## 🛠 Tech Stack

| Domain | Technology |
| :---- | :---- |
| **Frontend Framework** | Next.js 14 (App Router), React 18 |
| **Styling & UI** | Tailwind CSS, Shadcn UI |
| **State Management** | Redux Toolkit, Zustand |
| **Backend Framework** | Laravel 10 (PHP 8.2) / Node.js Express |
| **Database** | MySQL 8.0 / PostgreSQL |
| **Cache & Queue** | Redis |
| **Search Engine** | Meilisearch / Elasticsearch |
| **Payments** | Stripe Connect (Custom / Express Accounts) |
| **Containerization** | Docker, Docker Compose |

---

## 📐 System Architecture

                       \+------------------------+

                       |    Client Browsers     |

                       \+-----------+------------+

                                   |

                                   v

                       \+------------------------+

                       |    Nginx Reverse Proxy  |

                       \+-----------+------------+

                                   |

             \+---------------------+---------------------+

             |                                           |

             v                                           v

\+------------------------+                  \+------------------------+

|  Storefront (Next.js)  |                  | Vendor Admin (Next.js) |

\+------------+-----------+                  \+------------+-----------+

             |                                           |

             \+---------------------+---------------------+

                                   |

                                   v

                       \+------------------------+

                       |    REST / REST API      |

                       |  (Laravel / Node.js)   |

                       \+-----------+------------+

                                   |

         \+-------------------------+-------------------------+

         |                         |                         |

         v                         v                         v

\+------------------+     \+------------------+      \+------------------+

| MySQL / Postgres |     |   Redis Cache    |      | Meilisearch/ES   |

\+------------------+     \+------------------+      \+------------------+

---

## ⚡️ Getting Started

### Prerequisites

Make sure you have the following installed on your machine:

- **Docker** & **Docker Compose**  
- **Node.js** (v18+) & **npm** / **yarn**  
- **PHP** (v8.2+) & **Composer**

### Installation & Setup

1. **Clone the Repository**  
     
   git clone \<your-repository-url\>  
     
   cd multi-vendor-ecommerce  
     
2. **Environment Configuration**  
     
   cp .env.example .env  
     
3. **Start Containers via Docker Compose**  
     
   docker-compose up \-d \--build  
     
4. **Run Database Migrations & Seeders**  
     
   docker-compose exec backend php artisan migrate \--seed  
     
5. **Access Application**  
     
   - Storefront: `http://localhost:3000`  
   - Vendor Portal: `http://localhost:3001`  
   - Admin Panel: `http://localhost:3000/admin`  
   - API Base URL: `http://localhost:8000/api/v1`

---

## 🔌 API Reference

### Auth Endpoints

| Method | Endpoint | Description | Access |
| :---- | :---- | :---- | :---- |
| `POST` | `/api/v1/auth/register` | Register new customer or vendor | Public |
| `POST` | `/api/v1/auth/login` | Authenticate user & issue token | Public |
| `POST` | `/api/v1/auth/logout` | Revoke access token | Authenticated |

### Vendor Endpoints

| Method | Endpoint | Description | Access |
| :---- | :---- | :---- | :---- |
| `GET` | `/api/v1/vendor/products` | Get list of vendor products | Vendor |
| `POST` | `/api/v1/vendor/products` | Create a new product | Vendor |
| `GET` | `/api/v1/vendor/orders` | Fetch orders for vendor's items | Vendor |

---

## 🔐 Environment Variables

Key variables required in `.env`:

APP\_NAME="MultiVendorPlatform"

APP\_ENV=local

APP\_URL=http://localhost:8000

DB\_CONNECTION=mysql

DB\_HOST=127.0.0.1

DB\_PORT=3306

DB\_DATABASE=multivendor\_db

DB\_USERNAME=root

DB\_PASSWORD=secret

REDIS\_HOST=127.0.0.1

REDIS\_PORT=6379

STRIPE\_KEY=pk\_test\_sample\_key

STRIPE\_SECRET=sk\_test\_sample\_secret

STRIPE\_WEBHOOK\_SECRET=whsec\_sample\_secret

---

## 🤝 Contributing

Contributions are welcome\! Please follow these steps:

1. Fork the repository.  
2. Create a new feature branch (`git checkout -b feature/AmazingFeature`).  
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`).  
4. Push to the branch (`git push origin feature/AmazingFeature`).  
5. Open a Pull Request.

---

## 📄 License

This project is licensed under the MIT License \- see the LICENSE file for details.
