use Tests\TestCase;
use App\Models\User;
use App\Models\Position;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PositionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_position(): void
    {
        // Creating a single user instance
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $data = [
            'title' => 'Software Engineer',
            'job_type' => 'full_time',
            'requirement' => [
                "education" => "Bachelor's Degree",
                "experience" => "9 years",
                "skills" => "dicta, sent, consequent"
            ],
            'status' => 'open',
            'description' => 'Sit omnis nemo et enim quia sed. Adipisci et dolorem quas sunt.',
            'post_date' => '2018-10-12',
        ];

        $response = $this->postJson('/api/positions', $data);

        $response->assertJson([
            'success' => true,
            'data' => 'data stored successfully',
        ]);

        $this->assertDatabaseHas('positions', [
            'title' => 'Software Engineer',
            'job_type' => 'full_time',
            'requirement' => json_encode([
                "education" => "Bachelor's Degree",
                "experience" => "9 years",
                "skills" => "dicta, sent, consequent"
            ]),
            'status' => 'open',
            'description' => 'Sit omnis nemo et enim quia sed. Adipisci et dolorem quas sunt.',
            'post_date' => '2018-10-12',
        ]);
    }

    /** @test */
    public function it_can_fetch_all_positions(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        Position::factory()->count(3)->create();

        $response = $this->getJson('/api/positions');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     '*' => [
                         'id',
                         'title',
                         'job_type',
                         'requirement',
                         'description',
                         'post_date',
                     ]
                 ]);
    }

    /** @test */
    public function it_can_fetch_a_specific_position(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $position = Position::factory()->create([
            'title' => 'Software Engineer',
            'job_type' => 'full_time',
        ]);

        // Ensure you access the single model's id
        $response = $this->getJson('/api/positions/' . $position->id);

        $response->assertStatus(200)
                 ->assertJson([
                     'id' => $position->id,
                     'title' => 'Software Engineer',
                     'job_type' => 'full_time',
                 ]);
    }

    /** @test */
    public function it_can_update_a_position(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $position = Position::factory()->create();

        $updatedData = [
            'title' => 'Senior Software Engineer',
            'job_type' => 'full_time',
            'requirement' => json_encode(["Master's degree", "5+ years experience"]),
            'description' => 'Responsible for leading the development team.',
            'post_date' => now()->toDateString(),
        ];

        $response = $this->putJson('/api/positions/' . $position->id, $updatedData);

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Job updated successfully']);

        $this->assertDatabaseHas('positions', [
            'id' => $position->id,
            'title' => 'Senior Software Engineer',
            'job_type' => 'full_time',
            'requirement' => json_encode(["Master's degree", "5+ years experience"]),
            'description' => 'Responsible for leading the development team.',
            'post_date' => now()->toDateString(),
        ]);
    }

    /** @test */
    public function it_can_delete_a_position(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $position = Position::factory()->create();

        $response = $this->deleteJson('/api/positions/' . $position->id);

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Job deleted successfully']);

        $this->assertDatabaseMissing('positions', [
            'id' => $position->id,
        ]);
    }

    /** @test */
    public function it_can_change_position_status(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $position = Position::factory()->create(['status' => 'open']);

        // Ensure you're calling refresh on the single model instance
        $response = $this->postJson('/api/positions/change-status/' . $position->id);

        $response->assertStatus(200);

        $position->refresh();
        $this->assertEquals('close', $position->status);

        $response = $this->postJson('/api/positions/change-status/' . $position->id);
        $position->refresh();
        $this->assertEquals('open', $position->status);
    }
}
