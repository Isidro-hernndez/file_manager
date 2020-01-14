<?php

namespace App\Http\Controllers;

use App\File;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
		$status = 'error';
		$message = 'Problema al subir archivo';
		$user = Auth::user();
		if ( $request->hasFile('file')  && $user) {

			$file = new File;
			$file->name = $request->file->getClientOriginalName();
			$file->type = $request->file->getMimeType();
			$file->url = $request->file('file')->store('public');
			
			$file->folder_id = $request->folder_id;
			
			$file->save();	

			$status = 'success';
			$message = 'Archivo almacenado con exito';
		}
/*		$file = new File;
		$file->name = $request->name;
		$file->folder_id = $request->folder_id;
		$file->type = $request->type;
		$file->save(); */

		$data = [
			'file' => is_null($file) ? null : $file,
			'status' => $status,
			'message' => $message,
		];

		return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\File  $file
     * @return \Illuminate\Http\Response
     */
    public function show(File $file)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\File  $file
     * @return \Illuminate\Http\Response
     */
    public function edit(File $file)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\File  $file
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, File $file)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\File  $file
     * @return \Illuminate\Http\Response
     */
    public function destroy(File $file)
    {
        //
    }

	
}
