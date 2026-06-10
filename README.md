# KoraStream — Live Match & Sports Streaming Platform

**KoraStream** is a Mobile-First Live Football/Sports Match Streaming Web App designed to look, feel, and behave like a native Android Mobile Application (Material Design 3, Mobile-First, PWA-Ready). It includes a complete Admin Dashboard for backend management.

## Features

- **Mobile-First App-like UI**: Designed with Android Material Design guidelines. Includes a bottom navigation bar, top app bar, sliding date tabs, and bottom sheets for stream server selection.
- **PWA Ready**: Supports "Add to Home Screen" on Android devices, enabling a native app feel and offline shell asset loading.
- **Admin Dashboard**: Comprehensive backend management system for matches, stream servers, leagues, teams, channels, and ad settings.
- **Live Streams**: Supports various streaming formats like iframe, m3u8, youtube, and dash with server selection using an Android-like Bottom Sheet.
- **Responsive Layout**: Dark glassmorphism design with mobile safe-areas built directly into the CSS.

## Technology Stack

- **Backend**: PHP (vanilla, custom MVC pattern), MySQL
- **Frontend**: HTML, JavaScript (vanilla), Tailwind CSS
- **Design**: Google Fonts (Outfit & Inter), Font Awesome 6.5.1
- **Video Player**: Hls.js library for native stream parsing

## Installation

1. Upload the files to your server.
2. The platform includes a 4-step auto-installer to configure the environment, database, and admin credentials.
3. Access the webroot through your browser to begin the installation process.

## Architecture

The project follows a custom MVC-like architecture:
- **Controllers**: Manage business logic (e.g., MatchController, LeagueController, AuthController, InstallController).
- **Models**: Database interactions (Match, League, Team, Channel, AdSetting).
- **Views**: UI components segregated by layouts, frontend screens, and dashboard views.
- **Routes**: Direct incoming requests (`web.php`, `api.php`, `install.php`).

## Design System

The frontend utilizes a Mobile-First Material You (Dark Mode / Sports Neon) theme:
- StatusBar & AppBar Background: Deep Onyx Black (`#090D16`)
- App Canvas: Dark Slate Gray (`#0F1322`)
- Material Accent Colors: Bright Emerald, Electric Purple/Indigo
- App-like Micro-Animations: Ripple effects, glowing status indicators, and bottom sheet transitions.

## License

This project is proprietary and confidential. All rights reserved.
