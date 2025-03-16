# Blog Platform API

A RESTful API for a blog platform built using **Laravel**. This API allows users to perform CRUD operations on blog posts with role-based access control. It supports **user authentication** with **JWT**, and implements roles for **admin** and **author** users.

## Features

- **User Authentication**: Users can register and log in using JWT authentication.
- **Role-based Access Control**: 
  - **Admin** users can perform all CRUD operations on posts.
  - **Author** users can only create, update, or delete their own posts.
- **CRUD Operations** on Blog Posts.
- **Commenting System**: Authenticated users can comment on posts.
- **Filtering and Search**:
  - Filter posts by category, author, and date range.
  - Search posts by title, author, or category.
- **Pagination**: Paginated results for the list of posts.

## API Endpoints

### Authentication

- **POST** `/api/register` - Register a new user (requires `name`, `email`, `password`, and `role`).
- **POST** `/api/login` - Log in and obtain a JWT token (requires `email` and `password`).

### Posts

- **POST** `/api/posts` - Create a new post (authors only).
  - **Fields**: `title`, `content`, `category` (from predefined list: `Technology`, `Lifestyle`, `Education`).
- **GET** `/api/posts` - List all posts (admins can see all, authors see their own). Supports pagination and filtering by `category`, `author`, and `date range`.
- **GET** `/api/posts/{id}` - View a single post (returns post details, including author).
- **PUT** `/api/posts/{id}` - Update a post (authors can update their own posts, admins can update any).
- **DELETE** `/api/posts/{id}` - Delete a post (authors can delete their own posts, admins can delete any).

### Comments

- **POST** `/api/posts/{id}/comments` - Add a comment to a post (authenticated users only).

### Filtering and Search

- **GET** `/api/posts?category={category}&author={authorId}&start_date={startDate}&end_date={endDate}` - Filter posts by category, author, and date range.
- **GET** `/api/posts?title={searchTerm}` - Search posts by title.

## Installation

Follow these steps to set up the API locally.

### Prerequisites

Before running the project, make sure you have the following installed:

- **PHP** >= 7.4
- **Composer** (for managing dependencies)
- **MySQL** or another relational database

### Step 1: Clone the Repository

Clone the repository to your local machine:

```bash
git clone https://github.com/sarahmohamedsalah/blog-laravel-api-task.git

go to directory

```bash
cd blog-laravel-api-task

Set Up Environment Variables: Copy the .env.example file to .env so that you can configure your environment settings.

```bash
cp .env.example .env

Generate Application Key: Laravel requires an application key for encryption and other internal functionality. Run the following command to generate the key:

```bash
php artisan key:generate

Run Migrations: Run the database migrations to create all the necessary tables in your database.

```bash
php artisan migrate
