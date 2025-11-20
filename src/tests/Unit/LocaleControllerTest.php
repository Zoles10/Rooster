<?php

namespace Tests\Unit;

use App\Http\Controllers\LocaleController;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Tests\TestCase;
use Mockery;

class LocaleControllerTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /**
     * Tests that setLocale method sets locale and session for valid language and redirects back
     *
     * @return void
     */
    public function testSetLocaleSetsLocaleAndSessionAndRedirects()
    {
        // Arrange
        $lang = 'en';
        $redirectResponse = Mockery::mock(RedirectResponse::class);
        $sessionStore = Mockery::mock(\Illuminate\Session\Store::class);

        // Mock session store for redirect back
        $sessionStore->shouldReceive('get')
            ->with('_previous.url')
            ->andReturn('/previous');

        // Bind the mocked session store to the container
        $this->app->instance('session.store', $sessionStore);

        // Mock Session facade
        Session::shouldReceive('put')
            ->once()
            ->with('locale', $lang);

        // Mock App facade
        App::shouldReceive('setLocale')
            ->once()
            ->with($lang);

        // Mock Redirect facade
        Redirect::shouldReceive('back')
            ->once()
            ->andReturn($redirectResponse);

        $controller = new LocaleController();

        // Act
        $result = $controller->setLocale($lang);

        // Assert
        $this->assertEquals($redirectResponse, $result);
    }

    /**
     * Tests that setLocale method does not set locale and session for invalid language and still redirects back
     *
     * @return void
     */
    public function testSetLocaleDoesNotSetForInvalidLanguage()
    {
        // Arrange
        $lang = 'invalid';
        $redirectResponse = Mockery::mock(RedirectResponse::class);
        $sessionStore = Mockery::mock(\Illuminate\Session\Store::class);

        // Mock session store for redirect back
        $sessionStore->shouldReceive('get')
            ->with('_previous.url')
            ->andReturn('/previous');

        // Bind the mocked session store to the container
        $this->app->instance('session.store', $sessionStore);

        // Mock Redirect facade (no App or Session put calls expected)
        Redirect::shouldReceive('back')
            ->once()
            ->andReturn($redirectResponse);

        $controller = new LocaleController();

        // Act
        $result = $controller->setLocale($lang);

        // Assert
        $this->assertEquals($redirectResponse, $result);
    }
}
