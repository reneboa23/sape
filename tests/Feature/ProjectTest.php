<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use App\Project;


class ProjectTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_create_a_project()
    {

        $this->actingAs($user = factory(User::class)->create(), 'api');
        $response = $this->post('/api/projects', [
            'name' => 'My first project',
            'description' => 'Description of my first project'
        ])->assertStatus(201);

        $this->assertCount(1, Project::all());
        $project = Project::find(1);
        $this->assertEquals('My first project', $project->name);
        $this->assertEquals('Description of my first project', $project->description);
        $response->assertJson([
            'data' => [
                'type' => 'projects',
                'id' => $project->id,
                'attributes' => [
                    'name' => $project->name,
                    'description' => $project->description,
                ],

            ],
            'links' => [
                'self' => url('/projects/' . $project->id)
            ]
        ]);
    }

    /** @test */
    public function a_project_can_be_requested()
    {
        $this->withoutExceptionHandling();
        $project = factory(Project::class)->create();
        $this->actingAs($user = factory(User::class)->create(), 'api');
        $response = $this->get('/api/projects/' . $project->id)
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'type' => 'projects',
                    'id' => $project->id,
                    'attributes' => [
                        'name' => $project->name,
                        'description' => $project->description,
                    ],

                ],
                'links' => [
                    'self' => url('/projects/' . $project->id)
                ]
            ]);
    }

    /** @test */
    public function projects_can_be_requested()
    {

        factory(Project::class)->create();
        $this->actingAs($user = factory(User::class)->create(), 'api');
        $response = $this->get('/api/projects')->assertStatus(200);
        $projects = Project::all();
        $response->assertJson([
            'data' => [
                [
                    'data' => [
                        "type" => 'projects',
                        'id' => $projects->first()->id,
                        'attributes' => [
                            'name' => $projects->first()->name,
                            'description' => $projects->first()->description
                        ]
                    ],
                    'links' => [
                        'self' => url('/projects/' . $projects->first()->id)
                    ]
                ]
            ],
            'project_count' => $projects->count(),
            'links' => [
                'self' => url('/projects/')
            ]
        ]);
    }

    /** @test */
    public function name_is_required_to_create_a_project()
    {

        $this->actingAs($user = factory(User::class)->create(), 'api');
        $response = $this->post('/api/projects', [
            'name' => '',
            'description' => 'Description of my first project'
        ])->assertStatus(422);

        $responseString = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('name', $responseString['errors']['meta']);
    }

    /** @test */
    public function description_is_required_to_create_a_project()
    {

        $this->actingAs($user = factory(User::class)->create(), 'api');
        $response = $this->post('/api/projects', [
            'name' => 'Project Title',
            'description' => ''
        ])->assertStatus(422);

        $responseString = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('description', $responseString['errors']['meta']);
    }
}
