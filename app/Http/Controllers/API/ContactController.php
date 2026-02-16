<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\ContactRequest;
use App\Http\Resources\API\ContactResource;
use App\Models\Contact;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class ContactController extends Controller
{
    use ApiResponse;

    /**
     * Store a newly created contact message.
     *
     * @param ContactRequest $request
     * @return JsonResponse
     */
    public function store(ContactRequest $request): JsonResponse
    {
        $contact = Contact::create($request->validated());

        return $this->success(new ContactResource($contact), __('messages.Contact message sent successfully'), 201);
    }
}
