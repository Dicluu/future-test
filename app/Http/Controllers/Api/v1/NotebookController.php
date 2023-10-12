<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Notebook\PaginationRequest;
use App\Http\Requests\Notebook\StoreRequest;
use App\Http\Requests\Notebook\UpdateRequest;
use App\Http\Resources\NotebookResource;
use App\Models\Notebook;
use App\Service\Notebook\Service;
use Illuminate\Http\Response;

class NotebookController extends Controller
{
    // Объявление сервиса
    private $service;

    // Инъекция зависимости
    public function __construct(Service $service) {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(PaginationRequest $request)
    {
        $data = $request->validated();

        // Решил использовать сервис, так как код стал слишком объемным для контроллера.
        return $this->service->index($data);
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
