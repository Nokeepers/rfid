<?php

namespace App\Http\Controllers;

use App\Models\RfidCard;
use App\Models\RfidScan;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    /**
     * Show the report page with filters and summary.
     */
    public function index(Request $request)
    {
        [$query, $summary] = $this->buildQuery($request);

        $scans = $query->latest()->paginate(50)->withQueryString();
        $cards = RfidCard::orderBy('owner_name')->get();

        return view('reports.index', compact('scans', 'cards', 'summary'));
    }

    /**
     * Export the filtered results as a CSV file (streamed, no memory issues).
     */
    public function export(Request $request): StreamedResponse
    {
        [$query] = $this->buildQuery($request);

        $scans    = $query->latest()->get();
        $filename = 'rfid-report-' . now()->format('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        return response()->streamDownload(function () use ($scans) {
            $out = fopen('php://output', 'w');

            // UTF-8 BOM so Excel renders characters correctly
            fwrite($out, "\xEF\xBB\xBF");

            fputcsv($out, [
                'Scan ID', 'UID', 'Owner', 'Device', 'Status', 'IP Address', 'Scanned At',
            ]);

            foreach ($scans as $scan) {
                fputcsv($out, [
                    $scan->id,
                    $scan->uid,
                    $scan->rfidCard?->owner_name ?? 'Unknown',
                    $scan->device_id,
                    $scan->status,
                    $scan->ip_address,
                    $scan->created_at->toDateTimeString(),
                ]);
            }

            fclose($out);
        }, $filename, $headers);
    }

    /**
     * Build the filtered Eloquent query and summary stats.
     *
     * @return array{0: \Illuminate\Database\Eloquent\Builder, 1: array}
     */
    private function buildQuery(Request $request): array
    {
        $query = RfidScan::with('rfidCard');

        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }
        if ($request->filled('rfid_card_id')) {
            $query->where('rfid_card_id', $request->rfid_card_id);
        }
        if ($request->filled('status')
            && in_array($request->status, ['authorized', 'unknown', 'inactive'], true)) {
            $query->where('status', $request->status);
        }

        // Summary is computed on cloned builders so the main query is untouched
        $summary = [
            'total'      => (clone $query)->count(),
            'authorized' => (clone $query)->where('status', 'authorized')->count(),
            'unknown'    => (clone $query)->where('status', 'unknown')->count(),
            'inactive'   => (clone $query)->where('status', 'inactive')->count(),
        ];

        return [$query, $summary];
    }
}
