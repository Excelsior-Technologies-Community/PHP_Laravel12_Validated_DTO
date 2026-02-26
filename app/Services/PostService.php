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