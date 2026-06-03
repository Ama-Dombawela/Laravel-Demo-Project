# Modern Laravel CRM Web Application

CRM WEB is a modern, full-stack Customer Relationship Management (CRM) platform designed to help businesses efficiently manage customers, track proposals, generate invoices, monitor payments, and view transaction histories through a centralized dashboard.

Built with Laravel, Vue.js, and MySQL, the system provides a seamless and responsive user experience, featuring interactive dashboards, real-time business insights, secure authentication, and a premium, modern interface. The platform streamlines customer relationship management while giving businesses complete visibility into their financial activities and transactions.


## 🌟 Core Features

- **Authentication & Profiles:** Secure login, registration, and user profile management powered by Laravel Breeze.
- **Customer Management:** Comprehensive CRUD operations to manage client accounts and contact information.
- **Proposals System:** Create, edit, and track business proposals and bids through their lifecycle.
- **Invoicing & Billing:** Generate detailed invoices, email them directly to clients, and manage billing statuses.
- **Secure Payment Processing:** Seamlessly integrated with Stripe to accept and process invoice payments.
- **Transaction History:** Automatically log and track all successful Stripe payments to maintain an accurate ledger.
- **Dynamic Dashboard:** A centralized overview featuring key business metrics, recent activities, and quick-action shortcuts.

## 🛠 Tech Stack

- **Backend:** Laravel 12.x, PHP 8.2+
- **Frontend:** Vue.js 3 (Composition API), Inertia.js
- **Styling:** Tailwind CSS (v3), custom premium glassmorphism UI tokens
- **Database:** MySQL
- **Payments:** Stripe PHP SDK
- **Emails:** Mailtrap SDK (Symfony Mailer Integration)
- **Build Tool:** Vite

## 📋 Prerequisites

Before you begin, ensure you have the following installed on your local machine:
- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL Database

## 🚀 Installation & Setup

1. **Clone the repository**
   ```bash
   git clone https://github.com/Ama-Dombawela/Laravel-Demo-Project.git
   cd crm-project
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install NPM dependencies**
   ```bash
   npm install
   ```

4. **Environment Configuration**
   Copy the example environment file and create your own:
   ```bash
   cp .env.example .env
   ```
   Open the `.env` file and configure your application, database, and third-party credentials:
   ```env
   APP_NAME=CRM_WEB
   APP_URL=http://127.0.0.1:8000
   
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=demo_crm_db
   DB_USERNAME=root
   DB_PASSWORD=

   MAIL_MAILER=mailtrap
   MAILTRAP_TOKEN=
   MAILTRAP_HOST=sandbox.api.mailtrap.io
   MAILTRAP_INBOX_ID=

   STRIPE_KEY=
   STRIPE_SECRET=
   ```

5. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

6. **Run Migrations**
   Create the database tables:
   ```bash
   php artisan migrate
   ```

## ⚙️ Integrations Setup

### Stripe Payments
To process payments, you must provide your Stripe API keys in the `.env` file:
```env
STRIPE_KEY=pk_test_...
STRIPE_SECRET=sk_test_...
```

### Email Configuration (Local vs Production)
This application uses a flexible dual-driver setup to ensure emails are handled securely in different environments without changing any code.

**1. Local Development (Mailtrap Sandbox)**
Locally, the application uses the official Mailtrap SDK to "trap" testing emails. Update your `.env` with your Sandbox credentials:
```env
MAIL_MAILER=mailtrap
MAILTRAP_TOKEN=your_mailtrap_api_token
MAILTRAP_HOST=sandbox.api.mailtrap.io
MAILTRAP_INBOX_ID=your_inbox_id
```

**2. Live Production (e.g., Railway)**
When deploying to a live server where you want to send real emails to actual users without buying a custom domain name, simply switch the `MAIL_MAILER` to `smtp` in your production dashboard (like Railway Variables) and use a free Gmail account:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=465
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your_google_app_password
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="CRM Dashboard"
```
*(Note: You must generate a 16-character "App Password" in your Google Account Security settings for this to work).*

## 💻 Running the Application

This project uses Laravel's built-in concurrent runner to boot the local server, Vite compiler, and queue listener simultaneously. 

Run the following command:
```bash
npm run dev
```

The application will now be accessible at `http://127.0.0.1:8000`.

## 📄 License
This project is open-source and available under the MIT License.
