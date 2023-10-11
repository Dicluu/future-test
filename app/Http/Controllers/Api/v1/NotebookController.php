<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Notebook\StoreRequest;
use App\Http\Requests\Notebook\UpdateRequest;
use App\Http\Resources\NotebookResource;
use App\Models\Notebook;
use Illuminate\Http\Response;

class NotebookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return NotebookResource::collection(Notebook::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        // Возвращаем в ответе созданную книжку.
        return new NotebookResource(Notebook::create($request->validated()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Notebook $notebook)
    {
        return new NotebookResource($notebook);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Notebook $notebook)
    {
        $notebook->update($request->validated());
        return new NotebookResource($notebook);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notebook $notebook)
    {
        $notebook->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
