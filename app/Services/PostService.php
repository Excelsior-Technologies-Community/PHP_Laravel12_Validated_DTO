<?php

namespace App\Services;

use App\Models\Post;
use App\DTOs\PostDTO;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class PostService
{
    public function create(PostDTO $dto): Post
    {
        return Post::create([
            'title'  => $dto->title,
            'body'   => $dto->body,
            'status' => $dto->status,
        ]);
    }

    public function all(): Collection
    {
        return Post::all();
    }

    public function search(string $query): Collection
    {
        return Post::where('title', 'like', "%$query%")
            ->orWhere('body', 'like', "%$query%")
            ->get();
    }

    public function paginated(int $limit = 5): LengthAwarePaginator
    {
        return Post::latest()->paginate($limit);
    }
}