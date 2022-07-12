<?php

namespace App\Http\Livewire\Dashboard\Restaurant\Comments;

use App\Models\Comment;
use Livewire\Component;
use WireUi\Traits\Actions;
use Illuminate\Http\Request;
use App\Http\Resources\CommentAdminResource;
use App\Http\Controllers\API\CommentController;

class CommentShow extends Component
{
    use Actions;

    public $comments;

    public function setAnswer($form)
    {
        $request = new Request([
            'comment_id' => $form['comment_id'],
            'answer' => $form['answer'],
        ]);
        $response = app(CommentController::class)->setAnswer($request);
        if ($response->status() == 200) {
            $this->notification()->send([
                'title' => 'Answer saved!',
                'icon' => 'success'
            ]);
            $this->fetchData();
        }
        else {
            $this->notification()->send([
                'title' => 'ERROR in saved!',
                'icon' => 'error'
            ]);
        }
    }

    public function banComment($id)
    {
        $request = new Request([
            'comment_id' => $id,
        ]);

        $response = app(CommentController::class)->deleteRequest($request);
        if ($response->status() == 200) {
            $this->notification()->send([
                'title' => 'Request saved!',
                'icon' => 'success'
            ]);
            $this->fetchData();
        }
        else {
            $this->notification()->send([
                'title' => 'ERROR in saved!',
                'icon' => 'error'
            ]);
        }
    }

    public function deleteComment($id)
    {
        $request = new Request([
            'comment_id' => $id,
        ]);

        $response = app(CommentController::class)->destroy($request);
        if ($response->status() == 200) {
            $this->notification()->send([
                'title' => 'Comment Deleted!',
                'icon' => 'success'
            ]);
            $this->fetchData();
        }
        else {
            $this->notification()->send([
                'title' => 'ERROR in delete!',
                'icon' => 'error'
            ]);
        }
    }

    public function fetchData()
    {
        if (auth()->user()->role == 'restaurant') {
            $request = new Request(['restaurant_id' => auth()->user()->restaurant->id]);
            $response = app(CommentController::class)->show($request);
            if ($response->status() == 200) {
                $comments = json_decode($response->getContent())->comments;
                $this->comments = $comments;
            }
            else {
                $this->notification()->error(
                    $title = 'Error !!!',
                    $description = 'Comments can\'t be loaded!'
                );
            }
        } elseif (auth()->user()->role == 'admin') {
            $response = app(CommentController::class)->findCommentsForAdmin();
            $this->comments = \json_decode($response->getContent());
        }
    }
    public function render()
    {
        $this->fetchData();
        return view('livewire.dashboard.restaurant.comments.comment-show');
    }
}
