<?php

namespace Tests\Unit\Project;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Project\{Project, ProjectTranslation};


class ProjectTranslationTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Project $project;
    private ProjectTranslation $projectTranslation;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->project = Project::factory()->for($this->user)->create();

        $this->projectTranslation = ProjectTranslation::factory()->for($this->project)->for($this->user)->create();
    }

    public function testCreateProjectTranslation(): void
    {
        $this->assertInstanceOf(ProjectTranslation::class, $this->projectTranslation);

        $this->assertModelExists($this->projectTranslation);

        $this->assertDatabaseHas('project_translations', [
            'project_id' => $this->project->id,
            'user_id' => $this->user->id,
            'locale' => $this->projectTranslation->locale,
            'slug' => $this->projectTranslation->slug,
            'title' => $this->projectTranslation->title,
            'intro' => $this->projectTranslation->intro,
            'content' => $this->projectTranslation->content,
            'result' => $this->projectTranslation->result,
            'site_description' => $this->projectTranslation->site_description,
            'site_keyword' => $this->projectTranslation->site_keyword,
        ]);
    }

    public function testProjectTranslationBelongsToUser(): void
    {
        $this->assertInstanceOf(User::class, $this->projectTranslation->user);
    }

    public function testProjectTranslationBelongsToProject(): void
    {
        $this->assertInstanceOf(Project::class, $this->projectTranslation->project);
    }
}
