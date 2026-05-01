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

    public function list(PostService $service)
    {
        return response()->json([
            'status' => true,
            'data' => $service->all()
        ]);
    }

    public function search(Request $request, PostService $service)
    {
        return response()->json([
            'status' => true,
            'data' => $service->search($request->query('q'))
        ]);
    }

    public function paginated(PostService $service)
    {
        return response()->json([
            'status' => true,
            'data' => $service->paginated(3)
        ]);
    }
}
