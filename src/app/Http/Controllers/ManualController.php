<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ManualController extends Controller
{
    public function downloadGuestPDF()
    {
        $pdf = PDF::loadView('pdf.guestPDF');
        return $pdf->download('guest.pdf');
    }

    public function downloadUserPDF()
    {
        $pdf = PDF::loadView('pdf.userPDF');
        return $pdf->download('user.pdf');
    }

    public function downloadAdminPDF()
    {
        $pdf = PDF::loadView('pdf.adminPDF');
        return $pdf->download('admin.pdf');
    }
}
