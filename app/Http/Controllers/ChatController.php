<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Shop;
use App\Services\ChatService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;

class ChatController extends Controller
{
    public function store(Request $request, ChatService $chatService)
    {
        $validated = $request->validate([
            'message' => [
                'required',
                'string',
                'max:1000',
                function (string $attribute, mixed $value, \Closure $fail) {
                    if (is_string($value) && trim($value) === '') {
                        $fail('Le message ne peut pas être vide.');
                    }
                },
            ],
            'shop_subdomain' => ['nullable', 'string', 'max:100'],
        ]);

        $userId = auth()->id();
        $sessionId = $request->session()->getId();

        $rateKey = $userId
            ? "chat:user:{$userId}"
            : "chat:session:{$sessionId}:ip:" . $request->ip();

        if (RateLimiter::tooManyAttempts($rateKey, 20)) {
            $retryAfter = RateLimiter::availableIn($rateKey);

            return response()->json([
                'message' => 'Trop de messages. Réessayez dans quelques secondes.',
                'retry_after' => $retryAfter,
            ], 429);
        }

        RateLimiter::hit($rateKey, 60);

        $shop = $this->resolveShop($request);

        $conversation = $userId
            ? Conversation::firstOrCreate(['user_id' => $userId], ['session_id' => $sessionId])
            : Conversation::firstOrCreate(['session_id' => $sessionId], ['user_id' => null]);

        if ($shop && empty($conversation->metadata['shop_id'])) {
            $conversation->update([
                'metadata' => array_merge($conversation->metadata ?? [], ['shop_id' => $shop->id]),
            ]);
        }

        try {
            $reply = $chatService->sendMessage($conversation, $validated['message'], $shop);
        } catch (\Throwable $e) {
            Log::error('ChatController store failed', [
                'conversation_id' => $conversation->id ?? null,
                'user_id' => $userId,
                'session_id' => $sessionId,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'message' => "Une erreur est survenue. Veuillez réessayer.",
            ], 500);
        }

        return response()->json([
            'conversation_id' => $conversation->id,
            'reply' => $reply,
        ]);
    }

    private function resolveShop(Request $request): ?Shop
    {
        if (app()->bound('shop')) {
            return app('shop');
        }

        $subdomain = $request->input('shop_subdomain');
        if ($subdomain) {
            return Shop::where('subdomain', $subdomain)
                ->where('status', 'active')
                ->first();
        }

        return null;
    }
}
