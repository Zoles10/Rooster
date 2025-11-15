<?php

namespace Tests\Integration;

use App\Http\Controllers\QuestionController;
use App\Models\Question;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Mockery;

class QuestionControllerTest extends TestCase
{
    use RefreshDatabase;

    protected QuestionController $controller;

    protected function setUp(): void
    {
        parent::setUp();
        $this->controller = new QuestionController();
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /**
     * Test that getAllByUserId returns only questions belonging to the specified user.
     *
     * @return void
     */
    public function test_get_all_by_user_id_returns_questions_for_user(): void
    {
        // Arrange
        $targetUser = User::factory()->create();
        $otherUser = User::factory()->create();
        $subject = Subject::factory()->create();

        Question::factory()->count(3)->create([
            'owner_id' => $targetUser->id,
            'subject_id' => $subject->id
        ]);

        Question::factory()->count(2)->create([
            'owner_id' => $otherUser->id,
            'subject_id' => $subject->id
        ]);

        // Act
        $result = $this->controller->getAllByUserId($targetUser->id);

        // Assert
        $this->assertCount(3, $result);
        $this->assertTrue($result->every(fn($q) => $q->owner_id === $targetUser->id));
    }

    /**
     * Test that getAllByUserId returns empty collection when user has no questions.
     *
     * @return void
     */
    public function test_get_all_by_user_id_returns_empty_collection_for_nonexistent_user(): void
    {
        // Act
        $result = $this->controller->getAllByUserId('999');

        // Assert
        $this->assertCount(0, $result);
    }

    /**
     * Test that multiply method creates an exact duplicate of a question including its options.
     *
     * @return void
     */
    public function test_multiply_creates_duplicate_question_with_options(): void
    {
        // Arrange
        $user = User::factory()->create();
        $subject = Subject::factory()->create();

        $originalQuestion = Question::factory()->create([
            'owner_id' => $user->id,
            'subject_id' => $subject->id
        ]);

        $originalQuestion->options()->create([
            'option_text' => 'Option 1',
            'correct' => true
        ]);

        $originalQuestion->options()->create([
            'option_text' => 'Option 2',
            'correct' => false
        ]);

        $this->actingAs($user);

        // Act
        $this->controller->multiply($originalQuestion);

        // Assert
        $this->assertEquals(2, Question::count());
        $newQuestion = Question::where('id', '!=', $originalQuestion->id)->first();

        $this->assertEquals($originalQuestion->question, $newQuestion->question);
        $this->assertEquals($originalQuestion->owner_id, $newQuestion->owner_id);
        $this->assertEquals(2, $newQuestion->options()->count());
    }

    /**
     * Test that destroy method successfully deletes a question from the database.
     *
     * @return void
     */
    public function test_destroy_deletes_question(): void
    {
        // Arrange
        $user = User::factory()->create();
        $subject = Subject::factory()->create();

        $question = Question::factory()->create([
            'owner_id' => $user->id,
            'subject_id' => $subject->id
        ]);

        $this->actingAs($user);

        // Act
        $this->controller->destroy($question);

        // Assert
        $this->assertDatabaseMissing('questions', ['id' => $question->id]);
    }

    /**
     * Test that destroyAdmin method allows deletion of any question by ID.
     *
     * @return void
     */
    public function test_destroy_admin_deletes_question_by_id(): void
    {
        // Arrange
        $admin = User::factory()->create();
        $subject = Subject::factory()->create();

        $question = Question::factory()->create([
            'owner_id' => $admin->id,
            'subject_id' => $subject->id
        ]);

        $this->actingAs($admin);

        // Act
        $this->controller->destroyAdmin($question->id);

        // Assert
        $this->assertDatabaseMissing('questions', ['id' => $question->id]);
    }

    /**
     * Test that store method creates a new question with the authenticated user as owner.
     *
     * @return void
     */
    public function test_store_creates_question_with_authenticated_user_as_owner(): void
    {
        // Arrange
        $user = User::factory()->create();
        $subject = Subject::factory()->create();

        $request = Request::create('/questions', 'POST', [
            'question' => 'Test question?',
            'subject' => $subject->id,
            'option1' => 'Answer 1',
            'option2' => 'Answer 2',
            'isCorrect1' => '1'
        ]);

        $this->actingAs($user);
        Auth::shouldReceive('id')->andReturn($user->id);

        // Act
        $this->controller->store($request);

        // Assert
        $this->assertDatabaseHas('questions', [
            'question' => 'Test question?',
            'owner_id' => $user->id,
            'subject_id' => $subject->id
        ]);
    }

    /**
     * Test that store method creates a new subject when "other_subject" is provided.
     *
     * @return void
     */
    public function test_store_creates_new_subject_when_other_subject_provided(): void
    {
        // Arrange
        $user = User::factory()->create();

        $request = Request::create('/questions', 'POST', [
            'question' => 'Test question?',
            'subject' => '0',
            'other_subject' => 'New Subject',
            'option1' => 'Answer 1',
            'isCorrect1' => '1'
        ]);

        $this->actingAs($user);
        Auth::shouldReceive('id')->andReturn($user->id);

        // Act
        $this->controller->store($request);

        // Assert
        $this->assertDatabaseHas('subjects', ['subject' => 'New Subject']);
        $this->assertDatabaseHas('questions', ['question' => 'Test question?']);
    }

    /**
     * Test that update method modifies question data correctly.
     *
     * @return void
     */
    public function test_update_modifies_question_data(): void
    {
        // Arrange
        $user = User::factory()->create();
        $subject = Subject::factory()->create();

        $question = Question::factory()->create([
            'owner_id' => $user->id,
            'subject_id' => $subject->id
        ]);

        $request = Request::create('/questions/' . $question->id, 'PUT', [
            'question' => 'Updated question?',
            'option1' => 'New Answer 1',
            'isCorrect1' => '1'
        ]);

        $this->actingAs($user);

        // Act
        $this->controller->update($request, $question);

        // Assert
        $question->refresh();
        $this->assertEquals('Updated question?', $question->question);
    }

    /**
     * Test that update method toggles question active status and sets last_closed date.
     *
     * @return void
     */
    public function test_update_toggles_active_status(): void
    {
        // Arrange
        $user = User::factory()->create();
        $subject = Subject::factory()->create();

        $question = Question::factory()->create([
            'owner_id' => $user->id,
            'subject_id' => $subject->id,
            'active' => 1
        ]);

        $request = Request::create('/questions/' . $question->id, 'PUT', [
            'active' => 0
        ]);

        $this->actingAs($user);

        // Act
        $this->controller->update($request, $question);

        // Assert
        $question->refresh();
        $this->assertEquals(0, $question->active);
        $this->assertNotNull($question->last_closed);
    }
}
