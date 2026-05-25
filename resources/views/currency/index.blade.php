<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professional Currency Dashboard</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            background: #0b1120;
        }

        .main-card {
            background: #111827;
            border: 1px solid rgba(255, 255, 255, 0.06);
        }

        .input-box {
            background: #1e293b;
            border: 1px solid #334155;
            transition: 0.3s;
        }

        .input-box:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15);
            outline: none;
        }

        .table-row:hover {
            background: rgba(255, 255, 255, 0.03);
        }

        .gradient-btn {
            background: linear-gradient(to right, #2563eb, #4f46e5);
        }

        .gradient-btn:hover {
            background: linear-gradient(to right, #1d4ed8, #4338ca);
        }
    </style>

</head>

<body class="text-white min-h-screen">

    <div class="max-w-7xl mx-auto px-5 py-10">

        {{-- Header --}}
        <div class="flex flex-col lg:flex-row justify-between items-center mb-10 gap-6">

            <div>

                <h1 class="text-5xl font-black tracking-tight">
                    Currency
                    <span class="text-blue-500">
                        Exchange
                    </span>
                </h1>

                <p class="text-gray-400 mt-3 text-lg">
                    Professional Laravel 12 Currency Converter Dashboard
                </p>

            </div>

            {{-- Analytics --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 w-full lg:w-auto">

                <div class="main-card rounded-2xl px-6 py-5 text-center min-w-[150px]">

                    <p class="text-gray-400 text-sm">
                        Total Records
                    </p>

                    <h2 class="text-3xl font-bold mt-2 text-blue-400">
                        {{ $histories->count() }}
                    </h2>

                </div>

                <div class="main-card rounded-2xl px-6 py-5 text-center min-w-[150px]">

                    <p class="text-gray-400 text-sm">
                        Active Currency
                    </p>

                    <h2 class="text-3xl font-bold mt-2 text-indigo-400">
                        5
                    </h2>

                </div>

            </div>

        </div>

        {{-- Main Layout --}}
        <div class="grid lg:grid-cols-3 gap-8">

            {{-- Left Converter --}}
            <div class="lg:col-span-1">

                <div class="main-card rounded-3xl p-8 sticky top-10 shadow-2xl">

                    <h2 class="text-3xl font-bold mb-8">
                        Currency Converter
                    </h2>

                    {{-- Result --}}
                    @if(session('converted'))

                        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl p-6 mb-8 shadow-lg">

                            <p class="uppercase tracking-widest text-sm text-blue-100">
                                Conversion Result
                            </p>

                            <h2 class="text-4xl font-black mt-4 break-words">

                                {{ session('amount') }}

                                {{ session('from') }}

                                →

                                {{ session('converted') }}

                                {{ session('to') }}

                            </h2>

                        </div>

                    @endif

                    {{-- Form --}}
                    <form action="/convert" method="POST" class="space-y-6">

                        @csrf

                        {{-- Amount --}}
                        <div>

                            <label class="block mb-3 text-gray-300 font-medium">
                                Amount
                            </label>

                            <input type="number" name="amount" required placeholder="Enter Amount"
                                class="input-box w-full rounded-2xl px-5 py-4 text-white">

                        </div>

                        {{-- From --}}
                        <div>

                            <label class="block mb-3 text-gray-300 font-medium">
                                From Currency
                            </label>

                            <select name="from" class="input-box w-full rounded-2xl px-5 py-4 text-white">
                                <option value="USD">🇺🇸 USD</option>
                                <option value="INR">🇮🇳 INR</option>
                                <option value="EUR">🇪🇺 EUR</option>
                                <option value="GBP">🇬🇧 GBP</option>
                                <option value="JPY">🇯🇵 JPY</option>
                            </select>

                        </div>

                        {{-- To --}}
                        <div>

                            <label class="block mb-3 text-gray-300 font-medium">
                                To Currency
                            </label>

                            <select name="to" class="input-box w-full rounded-2xl px-5 py-4 text-white">
                                <option value="INR">🇮🇳 INR</option>
                                <option value="USD">🇺🇸 USD</option>
                                <option value="EUR">🇪🇺 EUR</option>
                                <option value="GBP">🇬🇧 GBP</option>
                                <option value="JPY">🇯🇵 JPY</option>
                            </select>

                        </div>

                        {{-- Button --}}
                        <button type="submit"
                            class="gradient-btn w-full py-4 rounded-2xl text-white font-bold text-lg transition-all duration-300 hover:scale-[1.02]">
                            Convert Currency
                        </button>

                    </form>

                </div>

            </div>

            {{-- Right History --}}
            <div class="lg:col-span-2">

                <div class="main-card rounded-3xl p-8 shadow-2xl">

                    {{-- Top --}}
                    <div class="flex flex-col md:flex-row justify-between items-center gap-5 mb-8">

                        <div>

                            <h2 class="text-3xl font-bold">
                                Conversion History
                            </h2>

                            <p class="text-gray-400 mt-2">
                                Track all currency conversion activity
                            </p>

                        </div>

                        {{-- Search --}}
                        <form method="GET" action="/" class="w-full md:w-[320px]">

                            <input type="text" name="search" placeholder="Search Currency..."
                                class="input-box w-full rounded-2xl px-5 py-4 text-white">

                        </form>

                    </div>

                    {{-- Table --}}
                    <div class="overflow-x-auto rounded-2xl border border-slate-700">

                        <table class="w-full">

                            <thead class="bg-slate-800">

                                <tr>

                                    <th class="text-left p-5 text-gray-300">
                                        Amount
                                    </th>

                                    <th class="text-left p-5 text-gray-300">
                                        From
                                    </th>

                                    <th class="text-left p-5 text-gray-300">
                                        To
                                    </th>

                                    <th class="text-left p-5 text-gray-300">
                                        Converted
                                    </th>

                                    <th class="text-left p-5 text-gray-300">
                                        Date
                                    </th>

                                    <th class="text-left p-5 text-gray-300">
                                        Action
                                    </th>

                                </tr>

                            </thead>

                            <tbody>

                                @forelse($histories as $history)

                                    <tr class="table-row border-b border-slate-700">

                                        <td class="p-5 font-semibold">
                                            {{ $history->amount }}
                                        </td>

                                        <td class="p-5">

                                            <span class="bg-blue-500/20 text-blue-400 px-4 py-2 rounded-xl text-sm">
                                                {{ $history->from_currency }}
                                            </span>

                                        </td>

                                        <td class="p-5">

                                            <span class="bg-indigo-500/20 text-indigo-400 px-4 py-2 rounded-xl text-sm">
                                                {{ $history->to_currency }}
                                            </span>

                                        </td>

                                        <td class="p-5 text-green-400 font-bold text-lg">
                                            {{ $history->converted_amount }}
                                        </td>

                                        <td class="p-5 text-gray-400">
                                            {{ $history->created_at->format('d M Y') }}
                                        </td>

                                        <td class="p-5">

                                            <form action="/history/{{ $history->id }}" method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this conversion history?')">

                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    class="bg-red-500 hover:bg-red-600 px-4 py-2 rounded-xl text-white transition-all">
                                                    Delete
                                                </button>

                                            </form>
                                        </td>

                                    </tr>

                                @empty

                                    <tr>

                                        <td colspan="6" class="text-center py-16">

                                            <div class="text-7xl mb-4">
                                                💱
                                            </div>

                                            <h2 class="text-2xl font-bold text-gray-300">
                                                No Conversion History
                                            </h2>

                                            <p class="text-gray-500 mt-3">
                                                Start converting currencies now
                                            </p>

                                        </td>

                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                    {{-- Pagination --}}
                    <div class="mt-8">
                        {{ $histories->links() }}
                    </div>

                </div>

            </div>

        </div>

    </div>

</body>

</html>