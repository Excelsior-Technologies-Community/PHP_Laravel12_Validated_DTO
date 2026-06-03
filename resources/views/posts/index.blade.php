<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts Manager</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 dark:bg-gray-900 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-3xl font-bold text-gray-800 dark:text-white mb-8">🚀 Posts Manager</h2>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow h-fit">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Create Post</h3>
                <form id="postForm" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm text-gray-600 dark:text-gray-400">Title</label>
                        <input type="text" name="title" class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white p-2">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600 dark:text-gray-400">Body</label>
                        <textarea name="body" rows="3" class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white p-2"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600 dark:text-gray-400">Status</label>
                        <select name="status" class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white p-2">
                            <option value="published">Published</option>
                            <option value="draft">Draft</option>
                        </select>
                    </div>
                    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg">Submit</button>
                </form>
            </div>

            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow flex flex-wrap gap-4 justify-between items-center">
                    <form method="GET" action="/posts" class="flex flex-1 gap-2">
                        <input type="text" name="search" value="{{ request('search') }}" class="flex-1 rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white p-2">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg">Search</button>
                    </form>
                    <div class="flex gap-2">
                        <a href="/posts" class="px-3 py-2 rounded-lg text-sm bg-gray-200 dark:bg-gray-700 dark:text-white">All</a>
                        <a href="{{ request()->fullUrlWithQuery(['status' => 'published']) }}" class="px-3 py-2 rounded-lg text-sm bg-green-600 text-white">Published</a>
                        <a href="{{ request()->fullUrlWithQuery(['status' => 'draft']) }}" class="px-3 py-2 rounded-lg text-sm bg-yellow-600 text-white">Draft</a>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-6">
                    @forelse($posts as $post)
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ $post->title }}</h3>
                        <p class="text-gray-600 dark:text-gray-300 mt-2">{{ $post->body }}</p>
                        <span class="mt-4 inline-block text-xs px-2 py-1 rounded {{ $post->status === 'published' ? 'bg-green-100' : 'bg-yellow-100' }}">
                            {{ ucfirst($post->status) }}
                        </span>
                    </div>
                    @empty
                    <div class="col-span-2 text-center text-gray-500 py-10">No posts found.</div>
                    @endforelse
                </div>
                <div>{{ $posts->appends(request()->query())->links() }}</div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('postForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const data = Object.fromEntries(new FormData(this).entries());
            fetch('/posts', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify(data)
            })
            .then(res => res.json())
            .then(() => window.location.reload());
        });
    </script>
</body>
</html>