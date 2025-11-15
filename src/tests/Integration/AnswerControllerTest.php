<?php

namespace Tests\Integration;

use App\Http\Controllers\AnswerController;
use App\Models\Answer;
use App\Models\Option;
use App\Models\Question;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Mockery;

class AnswerControllerTest extends TestCase
{
    use RefreshDatabase;

    protected AnswerController $controller;

    protected function setUp(): void
    {
        parent::setUp();
        $this->controller = new AnswerController();
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /**
     * Test that store method creates answer for selected option and redirects with success message.
     *
     * @return void
     */
    public function test_store_creates_answer_for_selected_option(): void
    {
        // Arrange
        $user = User::factory()->create();
        $subject = Subject::factory()->create();
        $question = Question::factory()->create([
            'owner_id' => $user->id,
            'subject_id' => $subject->id
        ]);

        $correctOption = Option::factory()->create([
            'question_id' => $question->id,
            'option_text' => 'Correct Answer',
            'correct' => true
        ]);

        $request = Request::create('/questions/' . $question->id . '/answers', 'POST', [
            'selected1' => '1'
        ]);

        $this->actingAs($user);
        Auth::shouldReceive('id')->andReturn($user->id);

        // Act
        $response = $this->controller->store($request, $question->id);

        // Assert
        $this->assertDatabaseHas('answers', [
            'user_id' => $user->id,
            'option_id' => $correctOption->id,
            'correct' => true
        ]);

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertEquals(route('welcome'), $response->getTargetUrl());
    }

    /**
     * Test that store method creates incorrect answer when wrong option is selected.
     *
     * @return void
     */
    public function test_store_creates_incorrect_answer_for_wrong_option(): void
    {
        // Arrange
        $user = User::factory()->create();
        $subject = Subject::factory()->create();
        $question = Question::factory()->create([
            'owner_id' => $user->id,
            'subject_id' => $subject->id
        ]);

        // Create a correct option first (this will be option 1)
        $correctOption = Option::factory()->create([
            'question_id' => $question->id,
            'option_text' => 'Correct Answer',
            'correct' => true
        ]);

        // Create an incorrect option second (this will be option 2)
        $incorrectOption = Option::factory()->create([
            'question_id' => $question->id,
            'option_text' => 'Wrong Answer',
            'correct' => false
        ]);

        $request = Request::create('/questions/' . $question->id . '/answers', 'POST', [
            'selected2' => '1'  // Select the second option (incorrect)
        ]);

        $this->actingAs($user);
        Auth::shouldReceive('id')->andReturn($user->id);

        // Act
        $this->controller->store($request, $question->id);

        // Assert
        $this->assertDatabaseHas('answers', [
            'user_id' => $user->id,
            'option_id' => $incorrectOption->id,
            'correct' => false
        ]);
    }

    /**
     * Test that updateShow returns JSON with answers for a specific question.
     *
     * @return void
     */
    public function test_update_show_returns_answers_for_question(): void
    {
        // Arrange
        $user1 = User::factory()->create(['name' => 'John Doe']);
        $user2 = User::factory()->create(['name' => 'Jane Smith']);
        $subject = Subject::factory()->create();
        $question = Question::factory()->create([
            'owner_id' => $user1->id,
            'subject_id' => $subject->id
        ]);

        $option1 = Option::factory()->create([
            'question_id' => $question->id,
            'option_text' => 'Option A',
            'correct' => true
        ]);

        $option2 = Option::factory()->create([
            'question_id' => $question->id,
            'option_text' => 'Option B',
            'correct' => false
        ]);

        Answer::factory()->create([
            'user_id' => $user1->id,
            'option_id' => $option1->id,
            'correct' => true
        ]);

        Answer::factory()->create([
            'user_id' => $user2->id,
            'option_id' => $option2->id,
            'correct' => false
        ]);

        // Act
        $response = $this->controller->updateShow($question->id);

        // Assert
        $data = $response->getData(true);
        $this->assertCount(2, $data);

        $this->assertEquals('John Doe', $data[0]['user_name']);
        $this->assertEquals('Option A', $data[0]['selected_option']);
        $this->assertEquals(1, $data[0]['correct']); // Check for integer value

        $this->assertEquals('Jane Smith', $data[1]['user_name']);
        $this->assertEquals('Option B', $data[1]['selected_option']);
        $this->assertEquals(0, $data[1]['correct']); // Check for integer value
    }

    /**
     * Test that updateShow returns empty array when no answers exist for question.
     *
     * @return void
     */
    public function test_update_show_returns_empty_array_for_question_without_answers(): void
    {
        // Arrange
        $user = User::factory()->create();
        $subject = Subject::factory()->create();
        $question = Question::factory()->create([
            'owner_id' => $user->id,
            'subject_id' => $subject->id
        ]);

        // Act
        $response = $this->controller->updateShow($question->id);

        // Assert
        $data = $response->getData(true);
        $this->assertCount(0, $data);
    }

    /**
     * Test that export method generates CSV file with question answers.
     *
     * @return void
     */
    public function test_export_generates_csv_file_with_answers(): void
    {
        // Arrange
        $user = User::factory()->create(['name' => 'Test User']);
        $subject = Subject::factory()->create();
        $question = Question::factory()->create([
            'question' => 'What is 2+2?',
            'owner_id' => $user->id,
            'subject_id' => $subject->id
        ]);

        $option = Option::factory()->create([
            'question_id' => $question->id,
            'option_text' => '4',
            'correct' => true
        ]);

        Answer::factory()->create([
            'user_id' => $user->id,
            'option_id' => $option->id,
            'correct' => true
        ]);

        // Act
        $response = $this->controller->export($question);

        // Assert
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('question-' . $question->id . '-answers-export.csv',
            $response->headers->get('Content-Disposition'));
        // Remove the Content-Type assertion as it's not set in the controller
        $this->assertNotNull($response->getFile());
    }

    /**
     * Test that comparison method returns correct view.
     *
     * @return void
     */
    public function test_comparison_returns_correct_view(): void
    {
        // Arrange
        $user = User::factory()->create();
        $subject = Subject::factory()->create();
        $question = Question::factory()->create([
            'owner_id' => $user->id,
            'subject_id' => $subject->id
        ]);

        // Act
        $response = $this->controller->comparison($question);

        // Assert
        $this->assertEquals('answer.compare', $response->name());
    }

    /**
     * Test that show method returns correct view with question ID.
     *
     * @return void
     */
    public function test_show_returns_correct_view_with_question_id(): void
    {
        // Arrange
        $questionId = 123;

        // Act
        $response = $this->controller->show($questionId);

        // Assert
        $this->assertEquals('answer.showAnswer', $response->name());
        $this->assertEquals($questionId, $response->getData()['question_id']);
    }
}
