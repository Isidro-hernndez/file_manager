<?php

namespace App\Http\Controllers;

use App\Folder;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class FolderController extends Controller
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
		$user = Auth::user();
		$status = 'error';
		$message = 'Problema al crear carpeta';
		if ($user)
		{

			$folder = new Folder;
			$folder->name = $request->name;
			//$folder->user_id = 1;
			$folder->user_id = $user->id;
			$folder->save();
			$status = 'success';
			$message = 'Creación exitosa';
		}

		$data = [
			'folder' => is_null($folder) ? null : $folder,
			'status' => $status,
			'message' => $message,
		];
		return response()->json($data);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Folder  $folder
	 * @return \Illuminate\Http\Response
	 */
	public function show(Folder $folder)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Folder  $folder
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Folder $folder)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Folder  $folder
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request)
	{
		//
		$folder = Folder::find($request->id);

		$folder->name = $request->name;
		$folder->save();
		//	$folder->update($request->only('name'));

		$data = [
			'folder' => $folder,
			'status' => 'success',
			'message' => 'Edición exitosa'
		];
		return response()->json($data);

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Folder  $folder
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Request $request)
	{
		$folder = Folder::find($request->id);
		$folder->delete();

		$data = [
			'status' => 'success',
			'message' => 'Eliminación exitosa'
		];
		return response()->json($data);

	}
	public function getFiles(Request $request)
	{
		$folder = Folder::find($request->folder_id);
		$user = Auth::user();
		$status = 'error';
		$message = 'Problema al buscar carpeta';
		if(($user && $folder) && ($user->id == $folder->user_id))
		{
			$status = 'success';
			$message = 'Carpeta encontrada';
			$files = $folder->files;
		}

		$data = [
			'files' => is_null($files) ? null : $files,
			'status' => $status,
			'message' => $message,
		];

		return response()->json($data);
	}
}
