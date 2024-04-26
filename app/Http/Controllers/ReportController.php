<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function report1($pid)
    {
        // Find the payment by its ID
        $payment = Payment::find($pid);

        // Initialize PDF object
        $pdf = App::make('dompdf.wrapper');

        // Build the HTML content for the receipt
        $print = "<div style='margin:20px; padding: 20px;'>";
        $print .= "<h1 align='center'>Payment Receipt</h1>";
        $print .= "<hr/>";
        $print .= "<p>Receipt No : <b>" . $pid . "</b> </p>";
        $print .= "<p>Date : <b>" . $payment->paid_date . "</b> </p>";
        $print .= "<p>Enrollment No : <b>" . $payment->enrollment->enroll_no . "</b> </p>";
        $print .= "<p>Student Name : <b>" . $payment->enrollment->student->name . "</b> </p>";
        $print .= "<hr/>";
        $print .= "<table style='width:100%;'>";
        $print .= "<tr><td>Batch</td><td>Amount</td></tr>";
        $print .= "<tr><td>" . $payment->enrollment->batch->name . "</td><td>" . $payment->amount . "</td></tr>";
        $print .= "</table>";
        $print .= "<hr/>";
        // $print .= "<span>Printed By: <b>" . Auth::user()->name . "</b></span>";
        $print .= "<span>Printed Date: <b>" . date('Y-m-d') . "</b></span>";
        $print .= "</div>";

        // Load HTML content into PDF and stream it to the user
        $pdf->loadHTML($print);
        return $pdf->stream();
    }
}
