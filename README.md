# M-Banking

## Overview
M-Banking is a comprehensive banking application built using Laravel and React. The application provides a robust backend with Laravel, paired with a dynamic and responsive frontend using React. This project aims to deliver a seamless banking experience, including features like user authentication, currency exchange, and account management.

## Features
- User Authentication
- Currency Exchange
- Account Management
- User Dashboard

## Installation

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js and npm
- MySQL

### Backend Setup
1. Clone the repository:
    ```bash
    git clone https://github.com/storegrill/M-Banking.git
    cd M-Banking
    ```

2. Install PHP dependencies:
    ```bash
    composer install
    ```

3. Copy the example environment file and configure the environment variables:
    ```bash
    cp .env.example .env
    ```
    Update the `.env` file with your database configuration and other necessary settings.

4. Generate the application key:
    ```bash
    php artisan key:generate
    ```

5. Run the migrations:
    ```bash
    php artisan migrate
    ```

### Frontend Setup
1. Install Node.js dependencies:
    ```bash
    npm install
    ```

2. Build the frontend assets:
    ```bash
    npm run build
    ```

### Running the Application
1. Start the Laravel development server:
    ```bash
    php artisan serve
    ```

2. Run Vite to serve the React frontend:
    ```bash
    npm run dev
    ```

## Contributing
Contributions are welcome! Please submit pull requests or open issues for any changes or suggestions.

## License
This project is licensed under the MIT License.
