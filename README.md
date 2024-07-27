# Anime Verse

Anime Verse is a Laravel-based web application for exploring and managing anime series. This project allows users to search for anime, view details, and manage their watchlist.

## Features

- **Search for Anime:** Find anime series by title, genre, or other filters.
- **View Anime Details:** Get detailed information about each anime series.
- **Manage Watchlist:** Add and remove anime series from your personal watchlist.
- **User Authentication:** Register and log in to manage your watchlist and settings.

## Installation

### Prerequisites

- PHP >= 8.0
- Composer
- Laravel

### Getting Started

1. **Clone the Repository:**

    ```bash
    git clone https://github.com/trixiediane/anime-verse.git
    cd anime-verse
    ```

2. **Install Dependencies:**

    ```bash
    composer install
    ```

3. **Create a `.env` File:**

    ```bash
    cp .env.example .env
    ```

    Update the `.env` file with your database and other environment settings.

4. **Generate Application Key:**

    ```bash
    php artisan key:generate
    ```

5. **Run Migrations:**

    ```bash
    php artisan migrate
    ```

6. **Seed the Database (optional):**

    ```bash
    php artisan db:seed
    ```

7. **Start the Development Server:**

    ```bash
    php artisan serve
    ```

    The application will be available at `http://localhost:8000`.

## Usage

- **Browse Anime:** Navigate to the anime search page to start exploring.
- **Manage Watchlist:** Log in to add or remove anime from your watchlist.
- **View Details:** Click on any anime title to view detailed information.

## Contributing

Contributions are welcome! Please follow these steps to contribute:

1. Fork the repository.
2. Create a new branch (`git checkout -b feature/YourFeature`).
3. Commit your changes (`git commit -am 'Add new feature'`).
4. Push to the branch (`git push origin feature/YourFeature`).
5. Create a new Pull Request.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Acknowledgments

- Laravel - The PHP framework used for this application.
- [Anime API](https://example.com) - Provides anime data (replace with actual source).

