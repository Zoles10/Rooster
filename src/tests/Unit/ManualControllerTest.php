<?php

namespace Tests\Unit;

use App\Http\Controllers\ManualController;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Illuminate\Support\Facades\View as ViewFacade;
use Tests\TestCase;
use Mockery;

class ManualControllerTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /**
     * Tests that downloadPDF method generates PDF from multiple views and returns download response
     *
     * @return void
     */
    public function testDownloadPDFGeneratesAndDownloadsPDF()
    {
        // Arrange
        $guestView = Mockery::mock(View::class);
        $userView = Mockery::mock(View::class);
        $adminView = Mockery::mock(View::class);

        // Create a mock that is an instance of the real PDF class so return type checks pass
        $pdfInstance = Mockery::mock(\Barryvdh\DomPDF\PDF::class);
        $downloadResponse = Mockery::mock(Response::class);

        // Simplified HTML fragments
        $guestHTML = '<div id="guest"><h1>GUEST</h1></div>';
        $userHTML = '<div id="user"><h1>USER</h1></div>';
        $adminHTML = '<div id="admin"><h1>ADMIN</h1></div>';

        // Expect render() on each returned view
        $guestView->shouldReceive('render')->once()->andReturn($guestHTML);
        $userView->shouldReceive('render')->once()->andReturn($userHTML);
        $adminView->shouldReceive('render')->once()->andReturn($adminHTML);

        // Mock the View facade to return our mocked view instances.
        // Accept the two optional array args passed by the helper: make($view, $data = [], $mergeData = [])
        ViewFacade::shouldReceive('make')
            ->with('pdf.guestPDF', Mockery::any(), Mockery::any())
            ->once()
            ->andReturn($guestView);
        ViewFacade::shouldReceive('make')
            ->with('pdf.userPDF', Mockery::any(), Mockery::any())
            ->once()
            ->andReturn($userView);
        ViewFacade::shouldReceive('make')
            ->with('pdf.adminPDF', Mockery::any(), Mockery::any())
            ->once()
            ->andReturn($adminView);

        // Accept any string for HTML input; ensure facade returns pdfInstance (typed as PDF)
        Pdf::shouldReceive('loadHTML')
            ->once()
            ->with(Mockery::type('string'))
            ->andReturn($pdfInstance);

        $pdfInstance->shouldReceive('download')
            ->once()
            ->with('manual.pdf')
            ->andReturn($downloadResponse);

        $controller = new ManualController();

        // Act
        $result = $controller->downloadPDF();

        // Assert
        $this->assertEquals($downloadResponse, $result);
    }
}
