<?php

namespace Tests\Unit\Project;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use App\Models\User;
use App\Models\Project\Project;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    public function testMakeProject(): void
    {
        $project = Project::factory()->make();

        $this->assertInstanceOf(Project::class, $project);
    }

    public function testCreateProjectb(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->for($user)->create();

        $this->assertModelExists($project);
        $this->assertDatabaseHas('projects', [
            'user_id' => $user->id,
            'approved' => $project->approved,
            'hide' => $project->hide,
        ]);
    }
}
