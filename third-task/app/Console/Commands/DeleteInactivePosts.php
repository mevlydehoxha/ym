<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Post;
use Carbon\Carbon;

class DeleteInactivePosts extends Command
{
    protected $signature = 'posts:delete-inactive';

    protected $description = 'Soft delete posts that have not received a comment for 1 year.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $oneYearAgo = Carbon::now()->subYear();

        $postsToDelete = Post::whereDoesntHave('comments')
                            ->where('created_at', '<=', $oneYearAgo)
                            ->get();

        $postsToDelete->each(function ($post) {
            $post->delete();
        });

        $this->info('Inactive posts soft deleted successfully.');
    }
}
