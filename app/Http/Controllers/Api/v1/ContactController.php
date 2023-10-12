<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Contact\PaginationRequest;
use App\Http\Requests\Contact\StoreRequest;
use App\Http\Requests\Contact\UpdateRequest;
use App\Http\Resources\ContactResource;
use App\Models\Contact;
use App\Service\Contact\Service;
use Illuminate\Http\Response;

class ContactController extends Controller
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
        // Возвращаем в ответе созданный контакт.
        return new ContactResource(Contact::create($request->validated()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        return new ContactResource($contact);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, int $id)
    {
        $contact = Contact::findOrFail($id);
        $contact->update($request->validated());
        return new ContactResource($contact);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
