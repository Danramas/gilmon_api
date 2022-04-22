<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class DocumentTest extends TestCase
{

    private static $uuid;

    public function test_api_document_created()
    {
        $response = $this->postJson('/api/v1/document');

        $decodedResponse = $response->decodeResponseJson();
        self::$uuid = $decodedResponse['data']['document']['id'];

        $response
            ->assertStatus(201);

    }

    public function test_api_document_missing_returns_404()
    {
        $response = $this->getJson('/api/v1/document/123');

        $response
            ->assertStatus(404);

    }

    public function test_api_document_patch_unpublished()
    {
        $response = $this->patchJson('/api/v1/document/'.self::$uuid, [
            'from' => 'test',
            'subject' => 'Hello',
            'message' => 'Hi! This is test :)'
        ]);

        $response
            ->assertStatus(200);

    }

    public function test_api_document_publish()
    {
        $response = $this->postJson('/api/v1/document/'.self::$uuid.'/publish');

        $response
            ->assertStatus(200)
            ->assertJsonPath('data.document.status', 'published');

    }

    public function test_api_document_patch_published()
    {
        $response = $this->patchJson('/api/v1/document/'.self::$uuid, [
            'from' => 'test',
            'subject' => 'Hello',
            'message' => 'Hi! This is test :)'
        ]);

        $response
            ->assertStatus(400);

    }

    public function test_api_document_get()
    {
        $response = $this->getJson('/api/v1/document/'.self::$uuid);

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
            $json->has('data.document.status')
                ->has('data.document.id')
                ->hasAny('data.document.payload',
                    'subject',
                    'from',
                    'message'
                )
            );
    }
}
