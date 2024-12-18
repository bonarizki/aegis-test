# Aegis-Test

This project provides API endpoints for managing users.

Available endpoints:
- **GET /users**: Retrieve the list of users.
- **POST /users**: Create a new user.

The project also includes features for sending emails using queues, events, and listeners in Laravel. After a user is created, two event listeners will be triggered:
- Sending an email to the admin.
- Sending an email to the newly created user.

Description: This project is designed to simplify user data management and automate email delivery using Laravel. The system ensures seamless integration between the backend API and event-driven email services.

## Technology Used
- PHP (Latest Laravel version)

### Laravel 11 System Requirements
To run Laravel 11, ensure your system meets the following requirements:
- **PHP**: Version 8.2 or higher
- **Database**: MySQL 8.0+, PostgreSQL 15+, SQLite 3.39+, or SQL Server 2017+
- **Composer**: Version 2.5 or higher
- Required **PHP Extensions**:
  - OpenSSL
  - PDO
  - Mbstring
  - Tokenizer
  - XML
  - Ctype
  - JSON
  - BCMath
  - Fileinfo

## Installation Steps
1. Clone this repository:
   ```bash
   git clone https://github.com/bonarizki/aegis-test.git
   cd aegis-test
   ```
2. Install dependencies using Composer:
   ```bash
   composer install
   ```
3. Copy the `.env.example` file to `.env`:
   ```bash
   cp .env.example .env
   ```
4. Configure the `.env` file as needed, including database and email settings.
5. Generate the application key:
   ```bash
   php artisan key:generate
   ```
6. Run database migrations:
   ```bash
   php artisan migrate
   ```
7. Start the queue worker to process email queues:
   ```bash
   php artisan queue:work --queue=admin,user
   ```
8. Start the local server:
   ```bash
   php artisan serve
   ```

## Usage Examples
### 1. Retrieve User List
**Request:**
```bash
GET /users?search=&sortBy=
```
**Response:**
```json
{
    "page": 1,
    "users": [
        {
            "id": 25,
            "name": "Terence McDermott",
            "email": "camila57@example.net",
            "active": 1,
            "created_at": "2024-12-04T16:08:55.000000Z",
            "deleted_at": null,
            "orders_count": 19
        }
    [,
}
```

### 2. Create a New User
**Request:**
```bash
POST /users
Content-Type: application/json

{
  "name": "Jane Doe",
  "email": "jane.doe@example.com",
  "password": "securepassword"
}
```
**Response:**
```json
{
  "id": 2,
  "name": "Jane Doe",
  "email": "jane.doe@example.com",
  "created_at": "2024-01-01T01:00:00.000000Z"
}
```

## License
This project is licensed under the [MIT](LICENSE) license.

## Contribution
Contributions are welcome! Please create a pull request or open an issue for further discussion.
