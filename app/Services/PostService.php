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

    // FEATURE: Get all posts
    public function all()
    {
        return Post::all();
    }

    // FEATURE: Search posts
    public function search(string $query)
    {
        return Post::where('title', 'like', "%$query%")
            ->orWhere('content', 'like', "%$query%")
            ->get();
    }

    // FEATURE: Pagination
    public function paginated(int $limit = 3)
    {
        return Post::paginate($limit);
    }
}