<?php

namespace Tests\Feature\Console\Commands;

use Tests\TestCase;

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
        $this->artisan('executive:update')
            ->assertExitCode(0)
            ->run();
    }
}
