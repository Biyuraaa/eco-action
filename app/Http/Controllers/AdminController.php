<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;


class AdminController extends Controller
{
    public function index()
    {
        return view('dashboard.home');
    }

    public function users()
    {
        $users = User::all();
        return view('dashboard.users', compact('users'));
    }

    public function volunteers()
    {
        return view('dashboard.volunteers');
    }

    public function donations()
    {
        return view('dashboard.donations');
    }

    public function articles()
    {
        $articles = Article::all();
        return view('dashboard.articles.index', compact('articles'));
    }

    public function create()
    {
        return view('dashboard.articles.create');
    }

    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:articles',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if ($validator->fails()) {
            return redirect()->route('articles.create')
                ->withErrors($validator)
                ->withInput();
        }

        // Simpan gambar
        $path = $request->file('image')->store('assets/images/articles');

        // Simpan artikel ke dalam basis data
        $article = new Article();
        $article->title = $request->title;
        $article->description = $request->description;
        $article->image = $path;
        $article->save();

        return redirect()->route('dashboard.articles')->with('success', 'Artikel berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $article = Article::findOrFail($id);
        return view('dashboard.articles.edit', compact('article'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:articles,title,' . $id,
            'description' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if ($validator->fails()) {
            return redirect()->route('articles.edit', $id)
                ->withErrors($validator)
                ->withInput();
        }

        // Temukan artikel yang akan diperbarui
        $article = Article::findOrFail($id);
        $article->title = $request->title;
        $article->description = $request->description;

        // Periksa apakah ada file gambar yang diunggah
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            Storage::delete($article->image);

            // Simpan gambar baru ke dalam storage
            $path = $request->file('image')->store('assets/images/articles');
            $article->image = $path;
        }

        // Simpan perubahan artikel
        $article->save();

        // Redirect dengan pesan sukses
        return redirect()->route('dashboard.articles')->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $article = Article::findOrFail($id);

        // Hapus gambar terkait
        Storage::delete($article->image);

        $article->delete();

        return redirect()->route('dashboard.articles')->with('success', 'Artikel berhasil dihapus.');
    }
}
