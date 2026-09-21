<?php

namespace App\Http\Controllers;

use App\Models\ContactLead;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Simpan lead dari form kontak ke database.
     * Perlindungan bot: honeypot field "website" + time-trap sesi (< 3 detik = bot).
     * Jika gagal (mis. DB bermasalah), arahkan user ke WhatsApp agar lead tidak hilang.
     */
    public function store(Request $request, string $locale)
    {
        // Honeypot: field tersembunyi; manusia tidak mengisinya. Bot diarahkan pulang diam-diam.
        if (filled($request->input('website'))) {
            return redirect()->route('contact', ['locale' => $locale]);
        }

        // Time-trap: submit kurang dari 3 detik setelah form dibuka = bot.
        $openedAt = (int) $request->session()->get('contact_form_opened_at', 0);
        if ($openedAt > 0 && now()->getTimestamp() - $openedAt < 3) {
            return redirect()->route('contact', ['locale' => $locale])
                ->withErrors(['message' => __('messages.form_try_again')]);
        }

        $validated = $request->validate([
            'name'    => ['required', 'string', 'max:120'],
            'email'   => ['required', 'email', 'max:190'],
            'phone'   => ['nullable', 'string', 'max:30'],
            'program' => ['nullable', 'string', 'max:80'],
            'subject' => ['nullable', 'string', 'max:190'],
            'message' => ['required', 'string', 'max:3000'],
        ]);

        try {
            ContactLead::create($validated + ['locale' => $locale]);

            return back()->with('success', true);
        } catch (\Throwable $e) {
            report($e);

            $waNumber = config('services.whatsapp.number', '628118887568');
            $text = 'Halo IF Language School, saya ' . ($validated['name'] ?? '') . ' — ' . ($validated['message'] ?? '');

            return redirect()
                ->to('https://wa.me/' . $waNumber . '?text=' . rawurlencode($text))
                ->with('error', true);
        }
    }
}
