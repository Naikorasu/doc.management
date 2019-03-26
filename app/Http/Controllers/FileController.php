<?php

namespace App\Http\Controllers;

use App\File;
use Illuminate\Http\Request;
use App\Classes\FunctionHelper;

class FileController extends Controller
{
    //

    public function upload(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|file|max:20000', // max 20MB
        ]);

        $user = $request->user();
        $user_email = $user->email;

        if ($request->file('file')->isValid()) {
            //
            if ($request->hasFile('file')) {

                $file = $request->file('file');
                $path = $file->store('public/files');

                $original_name = $file->getClientOriginalName();

                $extension = $file->getClientOriginalExtension();
                $real_path = $file->getRealPath();
                $size = $file->getSize();
                $mime = $file->getMimeType();

                $fh = New FunctionHelper();
                $mask = $fh::generate_unique_key($user_email . ";" . $mime . ";" . $real_path . ";" . $extension . ";");

                $destinationPath = public_path() . "/uploads/";
                $file->move($destinationPath, $mask . "." . $extension );


                $data_file = array(
                    'title' => $original_name,
                    'mask' => $mask,
                    'path' => $destinationPath ."/". $mask . "." . $extension,
                    'email' => $user_email,
                );
                $data_file = New File($data_file);
                $data_file->save();

            }
        }

        return response()->json([
            'message' => "File $file Uploaded.",
            'time' => round(microtime(true) * 1000),
            'result' => array(
                'upload' => $file,
                'path' => $path,
                'real_path' => $real_path,
                'name' => $original_name,
                'mime' => $mime,
                'extension' => $extension,
                'size' => $size,
                'public_path' => public_path(),

            ),
        ], 200);
    }
}
