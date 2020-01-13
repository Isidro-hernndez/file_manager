<?php

namespace App\Http\Controllers;

use App\Folder;
use Illuminate\Http\Request;

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
		$folder = new Folder;
		$folder->name = $request->name;
        //$folder->user_id = 1;
        $folder->user_id = $request->user_id;
		$folder->save();

		$data = [
			'folder' => $folder,
			'status' => 'success',
			'message' => 'Creación exitosa'
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
}
