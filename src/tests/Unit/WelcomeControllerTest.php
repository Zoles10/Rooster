<?php

namespace Tests\Unit;

use App\Http\Controllers\WelcomeController;
use Illuminate\View\View;
use Illuminate\Support\Facades\View as ViewFacade;
use Tests\TestCase;
use Mockery;

class WelcomeControllerTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /**
     * Tests that welcome method returns the welcome view
     *
     * @return void
     */
    public function testWelcomeReturnsWelcomeView()
    {
        // Arrange
        $view = Mockery::mock(View::class);

        // Mock the View facade to return our mocked view instance
        ViewFacade::shouldReceive('make')
            ->with('welcome', [], [])
            ->once()
            ->andReturn($view);

        $controller = new WelcomeController();

        // Act
        $result = $controller->welcome();

        // Assert
        $this->assertEquals($view, $result);
    }
}
