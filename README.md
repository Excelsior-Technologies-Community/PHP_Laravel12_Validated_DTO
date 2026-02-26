# PHP_Laravel12_Validated_DTO

## Project Description

PHP_Laravel12_Validated_DTO is a Laravel 12 REST API project that demonstrates how to implement Data Transfer Object (DTO) pattern using the wendelladriel/laravel-validated-dto package.

The project follows a clean architecture approach by separating responsibilities into Controller, DTO, Service, and Model layers. Incoming request data is first validated using a DTO class, then passed to the Service layer for business logic, and finally stored in the database using Eloquent Model.

This project is designed as a reference architecture for building scalable and maintainable APIs in Laravel 12.


## Project Purpose

- Demonstrate DTO-based validation in Laravel 12

- Implement Service Layer architecture

- Maintain clean separation of concerns

- Improve code readability and maintainability

- Provide a structured API development example



## Key Features

- Laravel 12 based REST API

- ValidatedDTO package integration

- Service Layer implementation

- Structured folder organization

- JSON API response format

- MySQL database integration


## Architecture Flow

Client Request → Route → Controller → DTO → Service → Model → Database → JSON Response


## Prerequisites

- PHP >= 8.2
- Composer
- MySQL
- Laravel 12
- Postman (for API testing)


---



## Installation Steps


---


## STEP 1: Create Laravel 12 Project

### Open terminal / CMD and run:

```
composer create-project laravel/laravel PHP_Laravel12_Validated_DTO "12.*"

```

### Go inside project:

```
cd PHP_Laravel12_Validated_DTO

```

#### Explanation:

Creates a fresh Laravel 12 application with all default folders, configuration, and dependencies. 

This is the base structure for building your API project.




## STEP 2: Database Setup 

### Open .env and set:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel12_validated_dto
DB_USERNAME=root
DB_PASSWORD=

```

### Create database in MySQL / phpMyAdmin:

```
Database name: laravel12_validated_dto

```

#### Explanation:

Configures Laravel to connect with MySQL database using .env file credentials. 

This allows Laravel to store and retrieve data from the database.




## STEP 3: Install Validated DTO Package

### Run:

```
composer require wendelladriel/laravel-validated-dto

```

#### Explanation:

Installs the DTO validation package which helps validate and transfer data safely between Controller and Service layers. 

It improves clean architecture and data validation.





## STEP 4: Project Structure 

### Create folders:

```
mkdir app\DTOs

mkdir app\Services

```

#### Explanation:

Creates custom folders (DTOs, Services) to organize business logic and data transfer objects. 

This follows a clean architecture pattern.






## STEP 5: Create Model + Migration

### Run:

```
php artisan make:model Post -m

```

### Edit Migration: database/migrations/create_posts_table.php

```
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {

            $table->id();

            $table->string('title');

            $table->string('content');

            $table->integer('price');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};

```

### Run migration:

```
php artisan migrate

```

#### Explanation:

Creates the Post model and migration file to define database table structure. 

Migration is used to create the posts table with required fields.






## STEP 6: Create DTO 

### Open: app/DTOs/PostDTO.php

```
<?php

namespace App\DTOs;

use WendellAdriel\ValidatedDTO\ValidatedDTO;

class PostDTO extends ValidatedDTO
{
    public string $title;
    public string $content;
    public int $price;

    protected function rules(): array
    {
        return [
            'title' => ['required', 'string'],
            'content' => ['required', 'string'],
            'price' => ['required', 'integer'],
        ];
    }

    protected function defaults(): array
    {
        return [];
    }

    protected function casts(): array
    {
        return [];
    }
}

```

#### Explanation:

Defines PostDTO class to validate incoming request data before processing. 

It ensures only valid and correct data is used in the application.






## STEP 7: Create Service Layer (Reference Architecture)

### Create: app/Services/PostService.php

```
<?php

namespace App\Services;

use App\Models\Post;
use App\DTOs\PostDTO;

class PostService
{
    public function create(PostDTO $dto): Post
    {
        return Post::create([
            'title' => $dto->title,
            'content' => $dto->content,
            'price' => $dto->price,
        ]);
    }
}

```

#### Explanation:

Creates PostService class to handle business logic and database operations. 

This keeps Controller clean and separates logic properly.




## STEP 8: Edit Model

### Edit: app/Models/Post.php

```
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title',
        'content',
        'price'
    ];
}

```

#### Explanation:

Defines fillable fields in Post model to allow mass assignment. 

This enables Laravel to safely insert data into the database.






## STEP 9: Create Controller

### Run: 

```
php artisan make:controller PostController

```

### Open: app/Http/Controllers/PostController.php

```
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PostService;
use App\DTOs\PostDTO;

class PostController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => true,
            'message' => 'Post API Working'
        ]);
    }

    public function store(Request $request, PostService $service)
    {
        try {

            $dto = PostDTO::fromArray($request->all());

            $post = $service->create($dto);

            return response()->json([
                'status' => true,
                'message' => 'Post Created Successfully',
                'data' => $post
            ], 201);

        } catch (\Throwable $e) {

            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'line' => $e->getLine()
            ], 500);

        }
    }
}

```

#### Explanation:

Handles incoming API requests and converts request data into DTO object. 

It then sends DTO to Service layer and returns JSON response.






## STEP 10: Add Route

### routes/api.php

```
<?php

use App\Http\Controllers\PostController;

Route::get('/posts', [PostController::class, 'index']);
Route::post('/posts', [PostController::class, 'store']);

```

#### Explanation:

Defines API endpoints for accessing PostController methods. 

Routes connect HTTP requests to controller functions.






## STEP 11: Test Server

### Run the server:

```
php artisan serve

```

### Visit:

```
http://127.0.0.1:8000

```

#### Explanation:

Starts Laravel development server to run the project locally. 

This allows you to access API via browser or Postman.






## STEP 12: Test Using Postman 

### Method:

```
POST 

```

### URL:

```
http://127.0.0.1:8000/api/posts

```

### Headers:

```
Content-Type: application/json

```

### Body (JSON):

```
{
  "title": "Laptop",
  "content": "Gaming laptop",
  "price": 50000
}

```

### Example Response:

```
{
    "status": true,
    "message": "Post Created Successfully",
    "data": {
        "title": "Laptop",
        "content": "Gaming laptop",
        "price": 50000,
        "updated_at": "2026-02-26T08:34:08.000000Z",
        "created_at": "2026-02-26T08:34:08.000000Z",
        "id": 1
    }
}

```


#### Explanation:

Sends POST request with JSON data to test API functionality. 

This verifies DTO validation, service logic, and database insertion.


## Expected Output:


<img width="1409" height="904" alt="Screenshot 2026-02-26 140446" src="https://github.com/user-attachments/assets/3d597f40-5cc3-4f25-8c7c-fb3a2addaa3f" />



---

# Project Folder Structure:

```
PHP_Laravel12_Validated_DTO/
│
├── app/
│   ├── DTOs/
│   │   └── PostDTO.php
│   │
│   ├── Services/
│   │   └── PostService.php
│   │
│   ├── Http/
│   │   └── Controllers/
│   │       └── PostController.php
│   │
│   └── Models/
│       └── Post.php
│
├── database/
│   └── migrations/
│       └── create_posts_table.php
│
├── routes/
│   └── api.php
│
├── .env
├── artisan
└── composer.json
```
