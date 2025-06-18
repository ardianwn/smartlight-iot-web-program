# Smart Light IoT Web Program

This repository contains the code for a Smart Light IoT system that includes both a web application and hardware components.

## Project Structure

This project is organized into two main directories:

### 1. smartlight/

The `smartlight` directory contains a Laravel-based web application that provides a user interface for controlling and monitoring smart lights. It includes:

- User authentication and management
- Light status monitoring and control
- Scheduling capabilities for automated light control
- Settings management
- API endpoints for communication with IoT devices

### 2. smartlight-hardware/

The `smartlight-hardware` directory contains the code for the hardware components of the smart light system. It's built using PlatformIO and includes:

- Main control logic for the IoT devices
- Communication protocols with the web application
- Sensor integration
- Light control functionality

## Getting Started

### Web Application Setup

1. Navigate to the `smartlight` directory
2. Install PHP dependencies: `composer install`
3. Install Node.js dependencies: `npm install`
4. Copy `.env.example` to `.env` and configure your environment variables
5. Run database migrations: `php artisan migrate`
6. Seed the database with initial data: `php artisan db:seed`
7. Start the development server: `php artisan serve`

### Hardware Setup

1. Navigate to the `smartlight-hardware` directory
2. Open the project in PlatformIO
3. Configure your device settings
4. Build and upload the code to your IoT devices

## Features

- Real-time light status monitoring
- Remote light control from web interface
- Automated scheduling for lights
- User-specific settings and preferences
- Secure API communication between web app and hardware devices

## Technology Stack

- **Web Application**: Laravel, PHP, JavaScript, Tailwind CSS
- **Hardware**: PlatformIO, C++
- **Database**: SQLite (default, configurable)

## License

[MIT License](LICENSE)

## Contributors

- [Your Name](https://github.com/ardianwn)
