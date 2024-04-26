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

        // Table creation
        $print .= "<table style='width:100%;'>";
        $print .= "<tr>";
        $print .= "<td>Batch :</td>";

        $print .= "<td><h3>" . $payment->enrollment->batch->name . "</h3></td>";
        $print .= "</tr>";

        $print .= "<tr>";
        $print .= "<td>Amount :</td>";
        $print .= "<td><h3>" . $payment->amount . "</h3></td>";
        $print .= "</tr>";

        $print .= "</table>";

        // Printed date
        $print .= "<hr/>";
        $print .= "<span>Printed Date: <b>" . date('Y-m-d') . "</b></span>";
        $print .= "</div>";

        // Load HTML content into PDF and stream it to the user
        $pdf->loadHTML($print);
        return $pdf->stream();
    }
}
