# KoraStream Documentation
**by Hakim BOUZOURDAZ**

Welcome to the comprehensive documentation for **KoraStream**, a Mobile-First Live Football and Sports Streaming Web Application. This document provides developers and administrators with everything they need to know to install, manage, and extend the platform.

---

## Table of Contents
1. [System Requirements](#system-requirements)
2. [Installation Guide](#installation-guide)
3. [Architecture and Codebase](#architecture-and-codebase)
4. [Database Schema](#database-schema)
5. [Routing System](#routing-system)
6. [Design System & Frontend](#design-system--frontend)
7. [PWA Integration](#pwa-integration)

---

## System Requirements

To run KoraStream, your server must meet the following requirements:
- **Web Server**: Apache or Nginx (Apache is recommended as the project ships with pre-configured `.htaccess` files).
- **PHP**: PHP 7.4 or higher (PHP 8.0+ recommended) with the following extensions enabled:
  - `pdo_mysql`
  - `json`
  - `mbstring`
  - `fileinfo`
- **Database**: MySQL 5.7+ or MariaDB 10.3+.

---

## Installation Guide

KoraStream includes a 4-step automated installer to make deployment straightforward.

1. **Upload Files**: Transfer the entire `kora-stream` directory to your web server's document root (e.g., `public_html` or `www`).
2. **Set Permissions**: Ensure the `public/uploads` directory and its subdirectories (`leagues`, `teams`, `channels`) have write permissions (`CHMOD 755` or `777`).
3. **Run Installer**: Navigate to your website's URL (e.g., `http://yourdomain.com`). The application will detect that it is not installed and automatically redirect you to the installer (`/public/install.php`).
4. **Follow the Steps**:
   - **Step 1 (Requirements)**: Verifies PHP version, extensions, and writable directories.
   - **Step 2 (Database)**: Enter your MySQL database credentials. The installer will test the connection and populate the database using `install.sql`.
   - **Step 3 (Admin)**: Create the primary super-admin account.
   - **Step 4 (Finish)**: The installer finalizes the `.env` configuration file and routes you to the dashboard login.

---

## Architecture and Codebase

KoraStream is built using a custom, lightweight MVC-like pattern without external PHP frameworks (like Laravel or Symfony), making it extremely fast and easy to host on shared servers.

### Directory Structure Overview
- **`config/`**: Contains the database connection class which parses the `.env` file.
- **`app/Controllers/`**: Houses all the business logic. Every administrative feature has a dedicated controller (e.g., `MatchController`, `TeamController`). The frontend is managed by `FrontendController`.
- **`app/Models/`**: Contains classes representing database tables. These models handle data retrieval and manipulation.
- **`views/`**: Contains all HTML/PHP view templates.
  - **`frontend/`**: The public-facing Mobile-First UI screens.
  - **`dashboard/`**, **`matches/`**, **`teams/`**, etc.: Admin dashboard screens.
- **`public/`**: The document root. All requests are routed through `public/index.php`. It contains assets (CSS, JS) and user uploads.
- **`routes/`**: Contains `web.php` and `api.php` which map incoming `?page=` requests to the appropriate controllers.

---

## Database Schema

The database relies on an InnoDB engine with `utf8mb4` encoding to support all characters, including emojis.

### Core Tables
1. **`admins`**: Stores administrative credentials (email, bcrypt password, role).
2. **`matches`**: The primary table for sports events. Links to home and away teams, leagues, and broadcast channels.
3. **`match_servers`**: Stores various streaming links (m3u8, iframe, youtube) linked to a specific match. Allows users to switch servers during a live match.
4. **`leagues`** & **`teams`**: Categorization and meta-data for matches, including logos.
5. **`channels`**: 24/7 Live sports TV channels with direct stream URLs.
6. **`ad_settings`** & **`app_settings`**: Global configuration and advertisement script injection points.

---

## Routing System

The application uses a query-string based routing mechanism managed by `public/index.php`.

**URL Pattern**: `index.php?page={page}&action={action}&id={id}`

### Frontend Routes
Handled by `FrontendController`:
- `?page=home` (Default): The main app screen showing the sliding dates and match list.
- `?page=watch&id={match_id}`: The live player screen with the bottom-sheet server switcher.
- `?page=leagues`: A grid directory of all leagues.
- `?page=channels`: A directory of live 24/7 sports channels.

### Admin Routes
Handled by specific controllers based on the entity:
- `?page=admin_matches` -> `MatchController`
- `?page=admin_teams` -> `TeamController`
- Actions include `index`, `create`, `edit`, `store`, `update`, `delete`.

---

## Design System & Frontend

The frontend is specifically designed to replicate a **Native Android Application** using Material Design 3 principles. It uses Tailwind CSS for rapid styling.

### Key UI Components
- **Mobile Safe Areas**: CSS integrates `env(safe-area-inset-top)` to ensure the UI does not overlap with smartphone notches or status bars.
- **Bottom Navigation Bar**: Fixed at the bottom of the screen (`views/frontend/footer.php`), it includes active state pills and Material icons.
- **Bottom Sheet Drawer**: Replaces traditional dropdowns. Used heavily in the `watch.php` screen to allow users to slide up a list of available streaming servers natively using custom JavaScript (`bottom-sheet.js`).
- **Color Palette**: 
  - Status Bar: `#090D16` (Onyx Black)
  - Background: `#0F1322` (Slate Gray)
  - Live Accent: `#10B981` (Emerald)

---

## PWA Integration

KoraStream acts as a Progressive Web App (PWA). Users on Android devices will be prompted to "Add to Home Screen".
- **`manifest.json`**: Located in the root directory, it dictates the app's name, standalone display mode, and app icons.
- **`sw.js`**: A service worker that caches core assets to ensure the app wrapper loads instantly, even on poor network connections.
