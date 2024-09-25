<?php

namespace App\Jobs;

use App\Mail\PostCreated;
use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendPostCreatedEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $postId;
    public $adminEmail;

    public function __construct($postId, $adminEmail)
    {
        $this->postId = $postId;
        $this->adminEmail = $adminEmail;
    }

    public function handle()
    {
        $post = Post::find($this->postId);
        if ($post) {
            Mail::to($this->adminEmail)->send(new PostCreated($post->id));
        }
    }
}

?>