# M-Banking

M-Banking is a digital banking system that provides users with functionalities like account creation, money transfers, exchange rate conversions, and more. This application is built using Laravel for the backend and utilizes APIs for real-time data handling.

## Features

- User Registration and Authentication
- Account Management
  - Create and manage accounts
  - View account balances
  - Transfer money between accounts
- Budget Management
- Transaction History
- Currency Exchange Rates
  - Fetch real-time exchange rates
  - Convert currency amounts

## Requirements

- PHP 7.4 or higher
- Composer
- Laravel 8.x
- MySQL or any other supported database
- Node.js and npm (for frontend development)

## Installation

1. **Clone the repository:**

    ```bash
    git clone https://github.com/yourusername/M-Banking.git
    cd M-Banking
    ```

2. **Install dependencies:**

    ```bash
    composer install
    npm install
    ```

3. **Environment setup:**

    Copy the example environment file and modify it according to your configuration:

    ```bash
    cp .env.example .env
    ```

    Generate the application key:

    ```bash
    php artisan key:generate
    ```

4. **Database setup:**

    Create a database and update the `.env` file with your database credentials. Then run the migrations:

    ```bash
    php artisan migrate
    ```

5. **Serve the application:**

    ```bash
    php artisan serve
    ```

    By default, the application will be served at `http://localhost:8000`.

## API Endpoints

### Authentication

- **Register:**
  - `POST /register`
  - Request: `{ "name": "John Doe", "email": "john@example.com", "password": "password", "password_confirmation": "password" }`
  - Response: `201 Created`

- **Login:**
  - `POST /login`
  - Request: `{ "email": "john@example.com", "password": "password" }`
  - Response: `{ "token": "auth_token", "user": { "id": 1, "name": "John Doe", "email": "john@example.com" } }`

### Account Management

- **Create Account:**
  - `POST /accounts`
  - Request: `{ "account_number": "123456789" }`
  - Response: `201 Created`

- **Get Accounts:**
  - `GET /accounts`
  - Response: `[ { "id": 1, "account_number": "123456789", "balance": "0.00" } ]`

- **Transfer Money:**
  - `POST /transfer`
  - Request: `{ "from_account": "123456789", "to_account": "987654321", "amount": 100.00 }`
  - Response: `{ "message": "Transfer successful" }`

### Currency Exchange

- **Get Exchange Rate:**
  - `GET /exchange-rate/{baseCurrency}/{targetCurrency}`
  - Response: `{ "rate": 1.23 }`

- **Convert Currency:**
  - `POST /convert-currency`
  - Request: `{ "baseCurrency": "USD", "targetCurrency": "EUR", "amount": 100 }`
  - Response: `{ "convertedAmount": 123.00 }`

## Contributing

Contributions are welcome! Please submit a pull request or open an issue to discuss your ideas.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
