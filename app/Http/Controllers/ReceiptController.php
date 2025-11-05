<?php

namespace App\Http\Controllers;

use App\Models\Tithe;
use App\Models\Offering;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;

class ReceiptController extends Controller
{
    public function tithe(int $id)
    {
        $tithe = Tithe::with('member')->findOrFail($id);
        $html = view('receipts.tithe', compact('tithe'))->render();
        if (class_exists(Pdf::class)) return Pdf::loadHTML($html)->download('tithe-receipt-'.$tithe->id.'.pdf');
        return new Response($html);
    }
    public function offering(int $id)
    {
        $offering = Offering::with('member')->findOrFail($id);
        $html = view('receipts.offering', compact('offering'))->render();
        if (class_exists(Pdf::class)) return Pdf::loadHTML($html)->download('offering-receipt-'.$offering->id.'.pdf');
        return new Response($html);
    }
}
