<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Photo;
use Illuminate\Support\Facades\Session;

class AdminMediasController extends Controller {

    //
    public function index() {
        $photos = Photo::all();
        return view('admin.medias.index', compact('photos'));
    }

    public function create() {
        return view('admin.medias.create');
    }

    public function store(Request $request) {
        $file = $request->file('file');
        $name = time() . $file->getClientOriginalName();
        $file->move('images', $name);
        Photo::create(['file' => $name]);
        //return view('admin.medias.index');
    }

    public function destroy($id) {
        $photo = Photo::findOrFail($id);
        unlink(public_path() . $photo->file);
        $photo->delete();
        Session::flash('deleted_media', 'The media has been deleted');
        return redirect('admin/medias');
    }

    public function deleteMedia(Request $request) {
        $photos = Photo::findOrFail($request->checkBoxArray);
        foreach ($photos as $photo) {
            unlink(public_path() . $photo->file);
            $photo->delete();
        }
        Session::flash('deleted_media', 'The media has been deleted');
        return redirect()->back();
        //dd($request);
    }

}
