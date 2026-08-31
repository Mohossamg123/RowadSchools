<?php

namespace App\Services;

use App\Models\SocialMediaAccount;
use App\Models\SocialMediaPost;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class SocialMediaService
{
    public function syncAccount(
        SocialMediaAccount $account
    ): int {
        if (!$account->access_token) {
            throw new RuntimeException(
                "No access token configured for {$account->platform}."
            );
        }

        return match (strtolower($account->platform)) {
            'instagram' => $this->syncInstagram($account),
            'x' => $this->syncX($account),

            default => throw new RuntimeException(
                "Unsupported social media platform."
            ),
        };
    }

    /*
    |--------------------------------------------------------------------------
    | Instagram
    |--------------------------------------------------------------------------
    */

    protected function syncInstagram(
        SocialMediaAccount $account
    ): int {
        $version = config(
            'services.social.instagram.version',
            env('INSTAGRAM_GRAPH_VERSION', 'v23.0')
        );

        $baseUrl = config(
            'services.social.instagram.base_url',
            env(
                'INSTAGRAM_GRAPH_BASE_URL',
                'https://graph.instagram.com'
            )
        );

        $url = "{$baseUrl}/{$version}/me/media";

        $response = Http::connectTimeout(5)
            ->timeout(15)
            ->withToken($account->access_token)
            ->get($url, [
                'fields' => implode(',', [
                    'id',
                    'caption',
                    'media_type',
                    'media_url',
                    'thumbnail_url',
                    'permalink',
                    'timestamp',
                ]),

                'limit' => 20,
            ]);

        if ($response->failed()) {
            throw new RuntimeException(
                'Instagram API error: ' .
                $response->body()
            );
        }

        $json = $response->json();

        $count = 0;

        foreach ($json['data'] ?? [] as $post) {

            $externalId = $post['id'] ?? null;

            if (!$externalId) {
                continue;
            }

            $mediaUrl =
                $post['media_url']
                ?? $post['thumbnail_url']
                ?? null;

            SocialMediaPost::updateOrCreate(
                [
                    'social_media_account_id' => $account->id,
                    'external_id' => $externalId,
                ],
                [
                    'content' => $post['caption'] ?? null,

                    'post_url' =>
                        $post['permalink']
                        ?? $account->url,

                    'media_url' => $mediaUrl,

                    'published_at' =>
                        $post['timestamp'] ?? null,

                    'status' => true,
                ]
            );

            $count++;
        }

        $account->update([
            'last_synced_at' => now(),
        ]);

        return $count;
    }

    /*
    |--------------------------------------------------------------------------
    | X
    |--------------------------------------------------------------------------
    */

    protected function syncX(
        SocialMediaAccount $account
    ): int {
        /*
        |--------------------------------------------------------------------------
        | First get X user ID from username
        |--------------------------------------------------------------------------
        */

        $userResponse = Http::connectTimeout(5)
            ->timeout(15)
            ->withToken($account->access_token)
            ->get(
                'https://api.x.com/2/users/by/username/' .
                ltrim($account->username, '@'),
                [
                    'user.fields' => 'id,username,name',
                ]
            );

        if ($userResponse->failed()) {
            throw new RuntimeException(
                'X user lookup failed: ' .
                $userResponse->body()
            );
        }

        $user = $userResponse->json('data');

        if (!$user || empty($user['id'])) {
            throw new RuntimeException(
                'X user was not found.'
            );
        }

        $userId = $user['id'];

        /*
        |--------------------------------------------------------------------------
        | Get posts
        |--------------------------------------------------------------------------
        */

        $response = Http::connectTimeout(5)
            ->timeout(15)
            ->withToken($account->access_token)
            ->get(
                "https://api.x.com/2/users/{$userId}/tweets",
                [
                    'max_results' => 20,

                    'tweet.fields' => implode(',', [
                        'id',
                        'text',
                        'created_at',
                        'attachments',
                    ]),

                    'expansions' => 'attachments.media_keys',

                    'media.fields' => implode(',', [
                        'media_key',
                        'type',
                        'url',
                        'preview_image_url',
                    ]),
                ]
            );

        if ($response->failed()) {
            throw new RuntimeException(
                'X API error: ' .
                $response->body()
            );
        }

        $json = $response->json();

        $mediaMap = [];

        foreach (
            $json['includes']['media'] ?? []
            as $media
        ) {
            if (!empty($media['media_key'])) {
                $mediaMap[$media['media_key']] = $media;
            }
        }

        $count = 0;

        foreach ($json['data'] ?? [] as $post) {

            $externalId = $post['id'] ?? null;

            if (!$externalId) {
                continue;
            }

            $mediaUrl = null;

            $mediaKeys =
                $post['attachments']['media_keys']
                ?? [];

            if (!empty($mediaKeys)) {

                $media = $mediaMap[$mediaKeys[0]]
                    ?? null;

                if ($media) {
                    $mediaUrl =
                        $media['url']
                        ?? $media['preview_image_url']
                        ?? null;
                }
            }

            SocialMediaPost::updateOrCreate(
                [
                    'social_media_account_id' => $account->id,
                    'external_id' => $externalId,
                ],
                [
                    'content' => $post['text'] ?? null,

                    'post_url' =>
                        'https://x.com/' .
                        ltrim($account->username, '@') .
                        '/status/' .
                        $externalId,

                    'media_url' => $mediaUrl,

                    'published_at' =>
                        $post['created_at'] ?? null,

                    'status' => true,
                ]
            );

            $count++;
        }

        $account->update([
            'last_synced_at' => now(),
        ]);

        return $count;
    }
}