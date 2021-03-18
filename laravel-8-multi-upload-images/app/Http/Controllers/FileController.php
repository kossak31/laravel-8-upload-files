<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;

class FileController extends Controller
{
    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'filenames' => 'required',
            'filenames.*' => 'mimes:doc,pdf,docx,zip,jpeg,jpg,png'
        ]);


        if ($request->hasfile('filenames')) {

            foreach ($request->file('filenames') as $file) {

                //generate new name 123_now.jpg
                $name = rand() . "_" . time() . '.' . $file->extension();

                //move to storage/files/123_now.jpg
                $file->move(public_path() . '/files/', $name);

                //create array ['file1','file2']
                $data[] = $name;
            }
        }

        //create object and save array in json
        $file = new File();
        $file->filenames = json_encode($data);
        $file->save();


        return back()->with('success', 'Data Your files has been successfully added');
    }
}
