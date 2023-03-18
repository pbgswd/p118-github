<?php

namespace Tests\Feature\Http\Controllers;

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
     */
    public function destroy_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $attachment = \App\Models\Attachment::factory()->create();

        $response = $this->actingAs($this->admin_user)->delete(route('attachment_destroy'));

        $response->assertRedirect(route('attachments_list'));
        $this->assertModelMissing($attachmentDestroy);
    }

    /**
     * @test
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
     */
    public function download_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $attachment = \App\Models\Attachment::factory()->create();

        $response = $this->actingAs($this->admin_user)->get(route('attachment_download', ['folder' => $attachment->folder, $attachment]));

        $response->assertOk();
    }

    /**
     * @test
     */
    public function edit_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $attachment = \App\Models\Attachment::factory()->create();

        $response = $this->actingAs($this->admin_user)->get(route('admin_attachment_edit', [$attachment->id]));

        $response->assertRedirect(route('attachments_list'));

/*
        $response->assertOk();
        $response->assertViewIs('admin.attachment');
        $response->assertViewHas('data');
*/
    }

    /**
     * @test
     */
    public function index_returns_an_ok_response()
    {
        $attachment = \App\Models\Attachment::factory()->create();
        $attachments = \App\Models\Attachment::factory()->times(3)->create();
        $response = $this->actingAs($this->admin_user)->get(route('attachments_list'));
        $response->assertOk();
        $response->assertViewIs('admin.list_attachments');
        $response->assertViewHas('data');
    }

    /**
     * @test
     */
    public function store_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');
        // TODO: send request data
        $response = $this->actingAs($this->admin_user)->post('admin/attachment/create', [

        ]);

        $response->assertRedirect(route('admin_attachment_edit', $attachment->id));
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
     */
    public function update_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $attachment = \App\Models\Attachment::factory()->create();

        $response = $this->actingAs($this->admin_user)->post('admin/attachment/{attachment}/edit', [
            // TODO: send request data
        ]);

        $response->assertRedirect(route('admin_attachment_edit', $attachment->id));
    }

    /**
     * @test
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
