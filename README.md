## Installation

1. **Install PHP dependencies via Composer:**

    ```bash
    composer install
    ```

2. **Copy `.env.example` to create a new `.env` file:**

    ```bash
    cp .env.example .env
    ```

3. **Open `.env` and configure your database settings:**

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=your_database_username
    DB_PASSWORD=your_database_password
    ```

4. **Generate an application key:**

    ```bash
    php artisan key:generate
    ```

5. **Run migrations to create the database tables:**

    ```bash
    php artisan migrate
    ```
6. **For generate files**

    ```bash
   php artisan storage:link  
    ```
7. **Start the development server:**

    ```bash
    php artisan serve
    ```
Your application should now be accessible at `http://localhost:8000`.
