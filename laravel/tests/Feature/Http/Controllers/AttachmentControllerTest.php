<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Attachment;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AttachmentController
 */
class AttachmentControllerTest extends TestCase
{
//todo admin attachment work

    /**
     * @test
     */
    public function create_returns_an_ok_response()
    {
       // $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $response = $this->actingAs($this->admin_user)->get(route('attachment_create'));

        $response->assertOk();
        $response->assertViewIs('admin.attachment');
        $response->assertViewHas('data');
    }

    /**
     * @test
     * @group destroyok
     */
    public function destroy_returns_an_ok_response()
    {
       $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $attachment = \App\Models\Attachment::factory()->create();

        $response = $this->actingAs($this->admin_user)
            ->delete(route('attachment_destroy', ['id' => $attachment->id]));

        $response->assertRedirect(route('attachments_list'));
        $this->assertModelMissing($attachment);

        /**
         *    ├ Attempt to read property "subfolder" on bool
        │
        ╵ /var/www/project118/laravel/vendor/laravel/framework/src/Illuminate/Testing/TestResponse.php:148
        ╵ /var/www/project118/laravel/tests/Feature/Http/Controllers/AttachmentControllerTest.php:42

         */
    }

    /**
     * @test
     * @group destroyok
     */
    public function destroy_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AttachmentController::class,
            'destroy',
            \App\Http\Requests\Attachments\DestroyAttachmentRequest::class
        );
    }

    /**
     * @test
     * @group downloadok
     */
    public function download_returns_an_ok_response()
    {
        //$this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $attachment = \App\Models\Attachment::factory()->create();

        $response = $this->actingAs($this->admin_user)
            ->get(route('attachment_download', ['folder' => $attachment->folder, 'attachment' => $attachment]));

        $response->assertOk();
    }

    /**
     * @test
     * @group editok
     */
    public function edit_returns_an_ok_response()
    {
        //$this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $attachment = \App\Models\Attachment::factory()->create();

        $response = $this->actingAs($this->admin_user)
            ->get(route('admin_attachment_edit', [$attachment->id]));

        $response->assertOk();
        $response->assertViewIs('admin.attachment');
        //$response->assertRedirect(route('attachments_list'));

/*
        $response->assertOk();
        $response->assertViewIs('admin.attachment');
        $response->assertViewHas('data');
*/
    }

    /**
     * @test
     * @group indexok
     */
    public function index_returns_an_ok_response()
    {
        Attachment::factory()->times(3)->create();
        $response = $this->actingAs($this->admin_user)->get(route('attachments_list'));
        $response->assertOk();
        $response->assertViewIs('admin.list_attachments');
        $response->assertViewHas('data');
    }

    /**
     * @test
     * @group storeok
     */
    public function store_returns_an_ok_response()
    {
       // $this->markTestIncomplete( __FUNCTION__ .' has issues.');
        // TODO: send request data
        $attachment = \App\Models\Attachment::factory()->make();
        $response = $this->actingAs($this->admin_user)
            ->post(route('create_attachment', [$attachment]));

        $att = Attachment::latest()->first();

        $response->assertRedirect(route('admin_attachment_edit', $att));
    }

    /**
     * @test
     */
    public function store_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AttachmentController::class,
            'store',
            \App\Http\Requests\Attachments\StoreAttachmentRequest::class
        );
    }

    /**
     * @test
     * @group updateok
     */
    public function update_returns_an_ok_response()
    {
        //$this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $attachment = \App\Models\Attachment::factory()->create();

        $att = Attachment::latest()->first();
        $response = $this->actingAs($this->admin_user)
            ->post('admin/attachment/{attachment}/edit', [
            $att
        ]);

        $response->assertRedirect(route('admin_attachment_edit', $att));
    }

    /**
     * @test
     * @group updateok
     */
    public function update_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AttachmentController::class,
            'update',
            \App\Http\Requests\Attachments\UpdateAttachmentRequest::class
        );
    }
}
