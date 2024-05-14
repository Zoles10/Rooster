<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ManualController extends Controller
{
    public function downloadPDF()
    {
        $view = view('pdf.guestPDF')->render() . view('pdf.userPDF')->render() . view('pdf.adminPDF')->render();
        $pdf = PDF::loadHTML($view);
        return $pdf->download('manual.pdf');
    }
}
