<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    private $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function store(Request $request, $post_id)
    {
        $request->validate([
            'comment' => 'required|max:150'
        ]);

        $this->comment->user_id = Auth::user()->id; // who created the comment
        $this->comment->post_id = $post_id; // which post was commented
        $this->comment->body = $request->comment; // content of the comment
        $this->comment->save();

        return back();
    }

    public function edit($id)
    {
        $comment = $this->comment->findOrFail($id);

        if($comment->user->id != Auth::id())
        {
            return redirect()->back();
        }

        return view('comment.edit')->with('comment', $comment);
    }

    public function update(Request $request, $id)
    {
        $comment = $this->comment->findOrFail($id); 

        $validator = Validator::make($request->all(), [
            'edit_comment' => 'required|string|max:150',
        ]);

        if ($validator->fails()) {
            session()->flash('open_edit_modal', $id);
            return redirect()->route('post.show', $comment->post_id)
                            ->withErrors($validator)
                            ->withInput();
        }

        if ($comment->user_id != Auth::id()) {
            return redirect()->back()->with('error', 'You do not have permission to edit this comment.');
        }

        $comment->body = $request->input('edit_comment');
        $comment->save();

        return redirect()->route('post.show', $comment->post_id)
            ->with('success', 'Your comment was updated successfully.');
    }

    public function destroy($id)
    {
        $this->comment->destroy($id);

        return back();
    }
}
