<?php

namespace Tests\Unit;

use App\Http\Controllers\ProfileController;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Tests\TestCase;
use Mockery;

class ProfileControllerTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /**
     * Tests that the edit method returns a view with the authenticated user data
     *
     * @return void
     */
    public function testEditReturnsViewWithUser()
    {
        // Arrange
        $user = Mockery::mock(User::class);
        $request = Mockery::mock(Request::class);

        $request->shouldReceive('user')->once()->andReturn($user);

        // Create a controller instance and test the method logic
        $controller = new ProfileController();

        // Mock the view facade
        $this->mock('overload:view', function ($mock) use ($user) {
            $view = Mockery::mock(View::class);
            $mock->shouldReceive('__invoke')
                ->with('profile.edit', ['user' => $user])
                ->andReturn($view);
            return $view;
        });

        // Act
        $result = $controller->edit($request);

        // Assert
        $this->assertInstanceOf(View::class, $result);
    }

    /**
     * Tests profile update when email is not changed
     *
     * @return void
     */
    public function testUpdateWithoutEmailChange()
    {
        // Arrange
        $user = Mockery::mock(User::class);
        $request = Mockery::mock(ProfileUpdateRequest::class);

        $validatedData = ['name' => 'John Doe'];

        $request->shouldReceive('user')->times(3)->andReturn($user);
        $request->shouldReceive('validated')->once()->andReturn($validatedData);

        $user->shouldReceive('fill')->once()->with($validatedData);
        $user->shouldReceive('isDirty')->once()->with('email')->andReturn(false);
        $user->shouldReceive('save')->once();

        // Mock Redirect facade
        Redirect::shouldReceive('route')
            ->once()
            ->with('profile.edit')
            ->andReturnSelf();
        Redirect::shouldReceive('with')
            ->once()
            ->with('status', 'profile-updated')
            ->andReturn(Mockery::mock(RedirectResponse::class));

        $controller = new ProfileController();

        // Act
        $result = $controller->update($request);

        // Assert
        $this->assertInstanceOf(RedirectResponse::class, $result);
    }

    /**
     * Tests profile update when email is changed and verification is reset
     *
     * @return void
     */
    public function testUpdateWithEmailChange()
    {
        // Arrange
        $user = Mockery::mock(User::class);
        $request = Mockery::mock(ProfileUpdateRequest::class);

        $validatedData = ['email' => 'new@example.com'];

        $request->shouldReceive('user')->times(4)->andReturn($user);
        $request->shouldReceive('validated')->once()->andReturn($validatedData);

        $user->shouldReceive('fill')->once()->with($validatedData);
        $user->shouldReceive('isDirty')->once()->with('email')->andReturn(true);
        $user->shouldReceive('setAttribute')->once()->with('email_verified_at', null);
        $user->shouldReceive('save')->once();

        // Mock Redirect facade
        Redirect::shouldReceive('route')
            ->once()
            ->with('profile.edit')
            ->andReturnSelf();
        Redirect::shouldReceive('with')
            ->once()
            ->with('status', 'profile-updated')
            ->andReturn(Mockery::mock(RedirectResponse::class));

        $controller = new ProfileController();

        // Act
        $result = $controller->update($request);

        // Assert
        $this->assertInstanceOf(RedirectResponse::class, $result);
    }

    /**
     * Tests user account deletion with proper logout and session cleanup
     *
     * @return void
     */
    public function testDestroyDeletesUserAndRedirects()
    {
        // Arrange
        $user = Mockery::mock(User::class);
        $request = Mockery::mock(Request::class);
        $session = Mockery::mock();

        $request->shouldReceive('validateWithBag')
            ->once()
            ->with('userDeletion', ['password' => ['required', 'current_password']]);
        $request->shouldReceive('user')->once()->andReturn($user);
        $request->shouldReceive('session')->times(2)->andReturn($session);

        $session->shouldReceive('invalidate')->once();
        $session->shouldReceive('regenerateToken')->once();

        Auth::shouldReceive('logout')->once();
        $user->shouldReceive('delete')->once();

        Redirect::shouldReceive('to')
            ->once()
            ->with('/')
            ->andReturn(Mockery::mock(RedirectResponse::class));

        $controller = new ProfileController();

        // Act
        $result = $controller->destroy($request);

        // Assert
        $this->assertInstanceOf(RedirectResponse::class, $result);
    }
}
