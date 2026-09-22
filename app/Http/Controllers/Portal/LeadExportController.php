<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\ContactLead;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LeadExportController extends Controller
{
    public function csv(): StreamedResponse
    {
        return response()->streamDownload(function () {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['nama', 'email', 'telepon', 'program', 'subjek', 'pesan', 'bahasa', 'dihubungi', 'masuk']);

            ContactLead::query()
                ->orderByDesc('id')
                ->chunk(500, function ($leads) use ($out) {
                    foreach ($leads as $lead) {
                        fputcsv($out, [
                            $lead->name,
                            $lead->email,
                            $lead->phone,
                            $lead->program,
                            $lead->subject,
                            $lead->message,
                            $lead->locale,
                            optional($lead->contacted_at)->format('Y-m-d H:i'),
                            $lead->created_at->format('Y-m-d H:i'),
                        ]);
                    }
                });

            fclose($out);
        }, 'leads-iflanguage-' . now()->format('Ymd') . '.csv', [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }
}
