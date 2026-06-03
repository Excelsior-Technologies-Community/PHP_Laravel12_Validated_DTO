<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PostService;
use App\DTOs\PostDTO;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class PostController extends Controller
{
    protected PostService $service;

    public function __construct(PostService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request): View
    {
        $posts = \App\Models\Post::query();

        if ($request->filled('search')) {
            $posts->where('title', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('body', 'LIKE', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $posts->where('status', $request->status);
        }

        $posts = $posts->latest()->paginate(3);

        return view('posts.index', compact('posts'));
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $dto = PostDTO::fromArray($request->all());
            $post = $this->service->create($dto);

            return response()->json([
                'status' => true,
                'message' => 'Post Created Successfully',
                'data' => $post
            ], 201);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}