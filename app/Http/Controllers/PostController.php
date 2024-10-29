<?php
namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function create(){
        return view('posts.create');
    }

    public function store(Request $request){
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);
        
        $content = $request->content;
        $dom = new \DOMDocument();        
        @$dom->loadHTML(mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $images = $dom->getElementsByTagName('img');

        foreach ($images as $img) {
            $src = $img->getAttribute('src');

            if (preg_match('/^data:image\/(\w+);base64,/', $src, $type)) {
                $data = substr($src, strpos($src, ',') + 1);
                $data = base64_decode($data);
                $imageName = time() . '.png';
                $path = public_path('uploads/') . $imageName;
                file_put_contents($path, $data);

                $img->setAttribute('src', asset('uploads/' . $imageName));
            }
        }

        $content = $dom->saveHTML();

        Post::create([
            'title' => $request->title,
            'content' => $content,
        ]);

        return redirect()->route('posts.create')->with('success', 'Post Created Successfully!');
    }
}
