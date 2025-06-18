# SmartLight IoT System

![SmartLight Logo](https://img.icons8.com/fluency/96/000000/light.png)

## Overview

SmartLight is an intelligent IoT-based lighting control system built with Laravel, Tailwind CSS, and ESP32 microcontrollers. It provides automated light control based on ambient light levels with manual overrides, scheduling capabilities, real-time monitoring and analytics.

## Features

- **Real-time Dashboard**: Monitor light status, ambient light intensity, and operation mode.
- **Automatic Light Control**: Lights automatically turn on/off based on ambient light levels.
- **Manual Override**: Take control of your lighting system when needed.
- **Smart Scheduling**: Create custom schedules for automatic operation.
- **Data Analytics**: View usage statistics, trends, and generate reports.
- **Data Export**: Export light usage data to CSV for further analysis.
- **Responsive Design**: Works on desktop, tablet, and mobile devices.
- **Dark Mode Support**: For comfortable viewing in any environment.

## System Architecture

### Software Components
- **Frontend**: Laravel Blade + Tailwind CSS + Alpine.js
- **Backend**: Laravel 11, PHP 8.2+
- **Database**: SQLite (can be easily switched to MySQL/PostgreSQL)
- **Real-time Updates**: JavaScript polling for real-time dashboard updates
- **Charts/Visualizations**: Chart.js

### Hardware Components
- **Microcontroller**: ESP32 Development Board
- **Sensors**: LDR (Light Dependent Resistor)
- **Actuators**: Relay Module for Light Control
- **Power Supply**: 5V power adapter

## Installation

### Prerequisites
- PHP 8.2+
- Composer
- Node.js & NPM
- XAMPP/WAMP/LAMP stack (or any PHP development environment)
- Arduino IDE (for ESP32 programming)

### Web Application Setup
1. Clone the repository:
```bash
git clone https://github.com/yourusername/smartlight.git
cd smartlight
```

2. Install PHP dependencies:
```bash
composer install
```

3. Install and build frontend assets:
```bash
npm install && npm run build
```

4. Set up environment:
```bash
cp .env.example .env
php artisan key:generate
```

5. Configure database in .env file:
```
DB_CONNECTION=sqlite
# For SQLite, keep the following line commented
# DB_DATABASE=absolute/path/to/database.sqlite
```

6. Run migrations and seed data:
```bash
php artisan migrate --seed
```

7. Start the development server:
```bash
php artisan serve
```

### ESP32 Setup
1. Connect your ESP32 according to the wiring diagram in the `/arduino` directory.
2. Open Arduino IDE and install the required libraries:
   - ESP32 Board Support
   - ArduinoJson
   - HTTPClient

3. Open the `smartlight_esp32.ino` sketch from the `/arduino` directory.
4. Update the WiFi credentials and server URL.
5. Upload the sketch to your ESP32 board.

## Usage

### Web Interface
1. Navigate to `http://localhost:8000` in your browser.
2. Register a new account or log in with the default admin:
   - Email: admin@example.com
   - Password: password

3. Use the dashboard to:
   - Monitor real-time light status
   - Toggle manual/auto mode
   - View light intensity chart
   - Check today's usage statistics

4. Access the schedules page to create automated lighting schedules.

5. Visit the settings page to configure:
   - Light threshold for automatic operation
   - Other system parameters

6. Generate reports and analytics from the reports page:
   - Daily, weekly, or monthly usage
   - Export data to CSV

### Hardware

The LDR sensor constantly monitors ambient light levels. When the light level drops below the threshold set in the web application, the ESP32 activates the relay to turn on the light. This process is automatic but can be overridden via the web interface.

## API Documentation

The SmartLight system provides a REST API for communication with IoT devices:

- `GET /api/light-status` - Get the current light status
- `POST /api/light-status` - Update light status from ESP32
- `GET /api/settings` - Get system settings (threshold, etc.)
- `GET /api/schedules` - Get active schedules

See the complete API documentation in [API-DOCUMENTATION.md](API-DOCUMENTATION.md).

## Troubleshooting

### Web Application
- **Charts not displaying**: Clear browser cache or check for console errors.
- **Database issues**: Run `php artisan migrate:fresh --seed` to reset the database.
- **Server errors**: Check Laravel logs in `storage/logs/laravel.log`.

### ESP32
- **Connection failures**: Verify WiFi credentials and server URL.
- **Irregular readings**: Check LDR connections and wiring.
- **System not responding**: Reset ESP32 and check power supply.

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Acknowledgements

- [Laravel](https://laravel.com)
- [Tailwind CSS](https://tailwindcss.com)
- [Chart.js](https://www.chartjs.org)
- [ESP32](https://www.espressif.com/en/products/socs/esp32)
