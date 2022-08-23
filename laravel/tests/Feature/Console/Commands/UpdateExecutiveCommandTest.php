<?php

namespace Tests\Feature\Console\Commands;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @see \App\Console\Commands\UpdateExecutiveCommand
 */
class UpdateExecutiveCommandTest extends TestCase
{
    /**
     * @test
     */
    public function it_runs_successfully()
    {
        $this->markTestIncomplete( __FUNCTION__ . ' has issues, see command, needs review, query fails');

        $this->artisan('executive:update')
            ->assertExitCode(0)
            ->run();
    }
}
