<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;

class PostController extends Controller
{
    private $post;
    const LOCAL_STORAGE_FOLDER = 'images/';

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function index()
    {
        $all_posts = $this->post->latest()->get();
        return view('posts.index')
            ->with('all_posts', $all_posts);
    }

    public function create()
    {
        $categories = Category::all(); // ← カテゴリ一覧を取得
        return view('posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        #1. validate the request
        // mime -> multipurpose internet mail extensions. max:1048 = 1048 KB
        $request->validate([
            'title' => 'required|max:50',
            'body' => 'required|max:1000',
            'image' => 'required|mimes:jpeg,jpg,png,gif|max:1048',
            'categories' => 'required|array|min:1',
            'category.*' => 'exists:categories,id',
        ]);


        #2. save the date to 'posts' table
        $this->post->user_id = Auth::user()->id;
        $this->post->title = $request->title;
        $this->post->body = $request->body;
        $this->post->image = $this->saveImage($request->image);
        $this->post->save();

        #3. 中間テーブルへカテゴリを紐づけ
        $this->post->categories()->attach($request->categories);

        #4. redirect to homepage
        return redirect()->route('index');
    }

    private function saveImage($image)
    {
        // change the name of the image to CURRENT TIME to avoid overwriting
        // $image_name = ex) 1747713010.jpeg
        $image_name = time() . "." . $image->extension();

        // save the image to storage/app/public/images
        $image->storeAs(self::LOCAL_STORAGE_FOLDER, $image_name);

        return $image_name;
    }

    public function show($id)
    {
        $post = $this->post->findOrFail($id);

        return view('posts.show')
            ->with('post', $post);
    }

    public function edit($id)
    {
    $post = $this->post->findOrFail($id);

    if ($post->user->id != Auth::user()->id) {
        return redirect()->back();
    }

    $categories = Category::all(); // ← カテゴリ一覧を取得

    return view('posts.edit')
        ->with('post', $post)
        ->with('categories', $categories); // ← 渡す
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|max:50',
            'body' => 'required|max:1000',
            'image' => 'mimes:jpeg,jpg,png,gif|max:1048',
            'categories' => 'required|array',
        ]);

        $post = $this->post->findOrFail($id);
        $post->title = $request->title;
        $post->body = $request->body;

        # if there is a new image
        if($request->image){
            # delete the old image
            $this->deleteImage($post->image);

            # save the new image
            $post->image = $this->saveImage($request->image);
        }

        $post->save();

        if ($request->has('categories')) {
        $post->categories()->sync($request->categories);
        }

        return redirect()->route('post.show', $id);
    }

    public function deleteImage($image)
    {
        $image_path = self::LOCAL_STORAGE_FOLDER . $image;
        // sample: $image_path = 'images/1747714007.jpg

        if(Storage::disk('public')->exists($image_path)){
            Storage::disk('public')->delete($image_path);
        }
    }

    public function delete($id)
    {
        $post = $this->post->findOrFail($id);
        $this->deleteImage($post->image);
        $post->delete();

        return back();
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        $posts = Post::where('title', 'like', '%' . $keyword . '%')
                ->orWhere('body', 'like', '%' . $keyword . '%')
                ->orderBy('created_at', 'desc')
                ->get(); 

        return view('posts.search')
                     ->with('posts', $posts)
                     ->with('keyword', $keyword); 
    }
}
