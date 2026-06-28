<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ContactMessageController extends Controller
{
    /** POST /api/contact-messages — public contact-form submission. */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'sender_name' => ['required', 'string', 'max:200'],
            'sender_email' => ['required', 'email', 'max:255'],
            'subject' => ['nullable', 'string', 'max:300'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        ContactMessage::create($data);

        return response()->json(
            ['message' => 'Thank you — your message has been sent.'],
            Response::HTTP_CREATED
        );
    }

    /** GET /api/admin/contact-messages — inbox (admin). */
    public function index(Request $request)
    {
        $query = ContactMessage::query()->orderByDesc('created_at');

        if ($request->boolean('unread')) {
            $query->where('is_read', false);
        }

        return $query->paginate($request->integer('per_page', 20));
    }

    public function show(ContactMessage $message): ContactMessage
    {
        return $message;
    }

    /** PATCH /api/admin/contact-messages/{message}/read. */
    public function markRead(ContactMessage $message): ContactMessage
    {
        $message->update(['is_read' => true]);

        return $message;
    }

    public function destroy(ContactMessage $message): Response
    {
        $message->delete();

        return response()->noContent();
    }
}
