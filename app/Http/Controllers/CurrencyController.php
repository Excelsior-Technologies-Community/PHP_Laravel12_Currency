<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Currency;
use App\Models\ConversionHistory;

class CurrencyController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $histories = ConversionHistory::when($search, function ($query) use ($search) {

            $query->where('amount', 'like', "%{$search}%")
                ->orWhere('from_currency', 'like', "%{$search}%")
                ->orWhere('to_currency', 'like', "%{$search}%")
                ->orWhere('converted_amount', 'like', "%{$search}%")
                ->orWhereDate('created_at', 'like', "%{$search}%");

        })
            ->latest()
            ->paginate(4);

        return view('currency.index', compact('histories'));
    }

    public function convert(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'from' => 'required',
            'to' => 'required',
        ]);

        $amount = $request->amount;
        $from = $request->from;
        $to = $request->to;

        try {

            $converted = Currency::convert($amount, $from, $to);

            // Fix null issue
            if (!$converted) {

                $rates = [
                    'USD_INR' => 83,
                    'INR_USD' => 0.012,
                    'EUR_INR' => 90,
                    'INR_EUR' => 0.011,
                    'USD_EUR' => 0.92,
                    'EUR_USD' => 1.08,
                ];

                $key = $from . '_' . $to;

                if (isset($rates[$key])) {
                    $converted = $amount * $rates[$key];
                } else {
                    $converted = $amount;
                }
            }

            ConversionHistory::create([
                'amount' => $amount,
                'from_currency' => $from,
                'to_currency' => $to,
                'converted_amount' => round($converted, 2),
            ]);

            return redirect('/')->with([
                'converted' => round($converted, 2),
                'amount' => $amount,
                'from' => $from,
                'to' => $to,
            ]);

        } catch (\Exception $e) {

            return back()->with('error', 'Currency conversion failed.');

        }
    }

    public function destroy($id)
    {
        ConversionHistory::findOrFail($id)->delete();

        return redirect('/')->with('success', 'History Deleted Successfully');
    }
}