<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Feature;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AdminFeatureController
 */
class AdminFeatureControllerTest extends TestCase
{
    //

    /**
     * @test
     * @group createok
     */
    public function create_returns_an_ok_response()
    {
        $response = $this->actingAs($this->admin_user)
            ->get(route('admin_feature_create'));

        $response->assertOk();
        $response->assertViewIs('admin.feature');
        $response->assertViewHas('data');
    }

    /**
     * @test
     * @group destroyok
     */
    public function destroy_returns_an_ok_response()
    {
        $feature = \App\Models\Feature::factory()->create();

        $response = $this->actingAs($this->admin_user)
            ->delete(route('admin_feature_destroy', ['id' => $feature->id]));

        $response->assertRedirect(route('admin_features_list'));
        $this->assertModelMissing($feature);
    }

    /**
     * @test
     * @group destroyok
     */
    public function destroy_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AdminFeatureController::class,
            'destroy',
            \App\Http\Requests\Feature\DestroyFeatureRequest::class
        );
    }

    /**
     * @test
     * @group editok
     */
    public function edit_returns_an_ok_response()
    {
        $feature = \App\Models\Feature::factory()->create();

        $response = $this->actingAs($this->admin_user)
            ->get(route('admin_feature_edit', ['any_feature' => $feature]));

        $response->assertOk();
        $response->assertViewIs('admin.feature');
        $response->assertViewHas('data');
    }

    /**
     * @test
     * @group indexok
     */
    public function index_returns_an_ok_response()
    {
        $features = \App\Models\Feature::factory()->times(3)->create();

        $response = $this->actingAs($this->admin_user)
            ->get(route('admin_features_list'));

        $response->assertOk();
        $response->assertViewIs('admin.features-list');
        $response->assertViewHas('data');
    }

    /**
     * @test
     * @group storeok
     */
    public function store_returns_an_ok_response()
    {
        $feature = Feature::factory()->make();

        $response = $this->actingAs($this->admin_user)
            ->post('admin/feature/create', [
            'feature' => $feature->toArray()
        ]);

        $response->assertRedirect(route('admin_feature_edit', [$feature->slug]));
    }

    /**
     * @test
     * @group storeok
     */
    public function store_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AdminFeatureController::class,
            'store',
            \App\Http\Requests\Feature\StoreFeatureRequest::class
        );
    }

    /**
     * @test
     * @group updateok
     */
    public function update_returns_an_ok_response()
    {
        $feature = \App\Models\Feature::factory()->create();

        $data = Feature::first();

        $data['description'] = "feature description edit " . $data->description;

        $response = $this->actingAs($this->admin_user)
            ->post('admin/feature/' . $data->slug . '/edit', [
                'feature' => $data->toArray()
        ]);

        $response->assertRedirect(route('admin_feature_edit', ['any_feature' => $data->slug]));

    }

    /**
     * @test
     * @group updateok
     */
    public function update_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AdminFeatureController::class,
            'update',
            \App\Http\Requests\Feature\UpdateFeatureRequest::class
        );
    }
}
