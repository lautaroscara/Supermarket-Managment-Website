# Supermarket Management Website

A web application for managing the product catalog of a supermarket, built with plain **PHP** and **MySQL**. It lets you browse, search, add, edit and delete products through a simple web interface.

Originally a high-school project, it was later refactored: every query now uses prepared statements, all output is escaped, and the code is organized into shared includes instead of duplicated pages.

> The user interface is in Spanish.

## Features

- **Product listing** with thumbnail, description and price, ordered alphabetically.
- **Product detail** page with the full-size photo, stock and price.
- **Search** by code, description (contains), brand (starts with) or price range.
- **Add products**: enter a code, and if it is free, fill in the rest of the data.
- **Edit products**: search by code and update the data in a pre-filled form.
- **Delete products** with an explicit confirmation step.

## Tech stack

- PHP (mysqli, prepared statements)
- MySQL / MariaDB
- HTML and CSS
- A small amount of JavaScript (switches the search form according to the selected criterion)
- Developed and tested locally with XAMPP

## Project structure

```
Supermarket-Managment-Website/
├── index.php                  # Product listing (home page)
├── pages/
│   ├── alta.php               # Add a product
│   ├── ampliado.php           # Product detail
│   ├── baja.php               # Delete a product (with confirmation)
│   ├── buscar.php             # Multi-criteria search
│   └── modificacion.php       # Edit a product
├── includes/
│   ├── header.php             # Shared header and navigation
│   └── footer.php             # Shared footer
├── config/
│   ├── conexion.php           # Database connection (not tracked by Git)
│   └── conexion_example.php   # Connection template
├── database/
│   └── productos.sql          # Table structure and sample data
├── assets/
│   ├── css/styles.css
│   ├── js/js.js
│   └── fotos/                 # Logo, error image, muestras/ (thumbnails), grandes/ (full size)
└── .gitignore
```

Each operation (add, edit, delete) lives in a single file: the page handles the search step, the confirmation or form step, and the final action.

## Requirements

- PHP 7.4 or later with the `mysqli` extension (with `mysqlnd`)
- MySQL or MariaDB
- A local web server such as [XAMPP](https://www.apachefriends.org/)

## Installation

1. **Start the servers.** Open the XAMPP Control Panel and start **Apache** and **MySQL**.

2. **Get the project.** Clone or download this repository into the `htdocs` folder:
   ```bash
   cd C:\xampp\htdocs
   git clone https://github.com/lautaroscara/Supermarket-Managment-Website.git
   ```

3. **Create the database.** Open `http://localhost/phpmyadmin`, create a database named `super`, then go to **Import** and select `database/productos.sql`. The dump creates the `productos` table and loads sample products, but it does not create the database itself.

4. **Configure the connection.** Copy the template and edit it with your credentials:
   ```bash
   copy config\conexion_example.php config\conexion.php
   ```
   Then edit `config/conexion.php`:
   ```php
   $conexion = new mysqli("localhost", "your_user", "your_password", "super");
   ```
   With the XAMPP defaults the user is `root` and the password is empty. `config/conexion.php` is listed in `.gitignore`, so your credentials are never committed.

5. **Open the site:** `http://localhost/Supermarket-Managment-Website/`

## Pages

| Route | Description |
|-------|-------------|
| `/index.php` | Lists all products. Each one links to its detail page. |
| `/pages/buscar.php` | Searches by code, description, brand or price range. |
| `/pages/ampliado.php?codigo=<code>` | Shows the full details of one product. |
| `/pages/alta.php` | Adds a new product. |
| `/pages/modificacion.php` | Edits an existing product. |
| `/pages/baja.php` | Deletes a product after confirmation. |

## Database

Table `productos`:

| Column | Type | Description |
|--------|------|-------------|
| `codigo` | `BIGINT(13)`, primary key | Product barcode |
| `descrip` | `VARCHAR(50)` | Description |
| `stock` | `INT` | Units in stock |
| `precio` | `FLOAT` | Unit price |
| `sector` | `VARCHAR(3)` | Sector code (for example `ALM`, `BEB`, `LAC`, `LIM`, `MAS`, `PER`) |
| `marca` | `VARCHAR(20)` | Brand |
| `foto` | `VARCHAR(20)` | Image file name, stored in `assets/fotos/muestras/` and `assets/fotos/grandes/` |

The product code is a 13-digit number, so it is handled as a string in PHP and bound as a string in queries to avoid integer overflow issues.

Photos are not uploaded through the application: to add a product with an image, place a thumbnail in `assets/fotos/muestras/` and the full-size file in `assets/fotos/grandes/` using the same file name.

## Security

- **Prepared statements** for every query that uses user input, which prevents SQL injection.
- **Output escaping** with `htmlspecialchars` (through the `escapar()` helper) for all dynamic values, which prevents XSS.
- **Deletion only via POST**, after a confirmation step. Nothing is deleted by opening a link.
- **Server-side validation** of required fields and numeric values.
- **Credentials kept out of the repository** (`config/conexion.php` is ignored by Git, with a `conexion_example.php` template).

## Refactoring notes

The original version had:

- One file per step of each operation (`alta.php` + `alta2.php`, `baja.php` + `baja2.php`, `modificacion.php` + `modificacion2.php`).
- Queries built by concatenating user input, which was vulnerable to SQL injection.
- Deletion triggered by a GET link, and product data passed through the URL and printed without escaping.
- The same header, footer and database credentials copied into every page.

Now each operation is a single page, queries are prepared, output is escaped, deletion requires a POST confirmation, and the header, footer and connection are shared.

## Known limitations

- **No authentication.** Anyone who can reach the site can add, edit or delete products. It is meant for local use or as a demo.
- **No CSRF protection** on the forms.
- The default XAMPP credentials (`root` without a password) are only suitable for local development.
- No pagination: the home page loads every product.
- `precio` is a `FLOAT`; a `DECIMAL(10,2)` column would be more accurate for money.

## Possible improvements

- Login with sessions and `password_hash`, with a separate role for administrators.
- CSRF tokens on all forms.
- Image upload instead of placing files manually.
- Pagination and sorting in the listing.
- Migrate `precio` to `DECIMAL` and move to utf8mb4 tables.

## Author

[@lautaroscara](https://github.com/lautaroscara)