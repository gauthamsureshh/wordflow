<?php
namespace App\Mail;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PostCreated extends Mailable implements ShouldQueue // Implement ShouldQueue here
{
    use Queueable, SerializesModels;
    public $postId;

    /**
     * Create a new message instance.
     */
    public function __construct($postId) // Change here
    {
        $this->postId = $postId;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Blog Created',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        // Fetch the post inside this method
        $post = Post::find($this->postId);

        return new Content(
            view: 'mail.mailNotify', 
            with: [
                'post' => $post,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}

?>