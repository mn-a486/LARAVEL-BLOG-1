<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Auth; 

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all(); // 全てのカテゴリーを取得

        return view('categories.index') // 'categories.index' ビューに渡す
                     ->with('categories', $categories);
    }

    // 特定のカテゴリーに属する投稿を表示するメソッド
    // ルートモデルバインディングを使って、IDからCategoryモデルのインスタンスを自動的に取得
    public function show(Category $category) // ここで $category を受け取る
    {
        // dd($category); // ★一時的に追加して、Categoryオブジェクトの内容を確認★

        $posts = $category->posts()->orderBy('created_at', 'desc')->paginate(10);

        return view('categories.show') // 'categories.show' ビューに渡す
                     ->with('category', $category) // 選択されたカテゴリー情報
                     ->with('posts', $posts);      // そのカテゴリーに属する投稿
    }

    public function create()
    {
        return view('categories.admin.create'); // 後で作成するビュー
    }

    /**
     * 新しいカテゴリをデータベースに保存
     */
    public function store(Request $request)
    {
        // バリデーションルールを定義
        $request->validate([
            'name' => 'required|string|max:20|unique:categories,name', // カテゴリ名は必須、文字列、255文字以内、ユニーク
        ]);

        // カテゴリを作成してデータベースに保存
        Category::create([
            'name' => $request->name,
        ]);

        return redirect()->route('category.index')->with('success', 'The category was created successfully.');
    }

    /**
     * 既存のカテゴリを編集するフォームを表示
     */
    public function edit(Category $category)
    {
        return view('categories.admin.edit')->with('category', $category); // 後で作成するビュー
    }

    /**
     * 既存のカテゴリをデータベースで更新
     */
    public function update(Request $request, Category $category)
    {
        // バリデーションルールを定義
        $request->validate([
            'name' => 'required|string|max:20|unique:categories,name,' . $category->id, // 更新時は自分自身の名前は重複とみなさない
        ]);

        // カテゴリを更新
        $category->update([
            'name' => $request->name,
        ]);

        return redirect()->route('category.index')->with('success', 'The category was updated successfully.');
    }

    /**
     * カテゴリをデータベースから削除
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('category.index')->with('success', 'The category was deleted successfully.');
    }
}
