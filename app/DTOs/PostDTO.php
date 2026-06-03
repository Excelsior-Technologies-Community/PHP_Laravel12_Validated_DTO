<?php

namespace App\DTOs;

use WendellAdriel\ValidatedDTO\ValidatedDTO;

class PostDTO extends ValidatedDTO
{
    public string $title;
    public string $body;
    public string $status;

    protected function rules(): array
    {
        return [
            'title'  => ['required', 'string', 'max:255'],
            'body'   => ['required', 'string'],
            'status' => ['required', 'string', 'in:draft,published'],
        ];
    }

    protected function defaults(): array
    {
        return [
            'status' => 'published',
        ];
    }

    protected function casts(): array
    {
        return [];
    }
}