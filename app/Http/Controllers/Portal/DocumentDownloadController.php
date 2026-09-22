<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DocumentDownloadController extends Controller
{
    /**
     * Unduh dokumen dari disk privat. Route sudah dilindungi
     * middleware auth + role:admin,translator.
     */
    public function download(Document $document): StreamedResponse
    {
        $disk = \Illuminate\Support\Facades\Storage::disk('local');

        abort_unless($disk->exists($document->file_path), 404, 'File tidak ditemukan di storage.');

        return $disk->download(
            $document->file_path,
            $document->title . '.' . (pathinfo($document->file_path, PATHINFO_EXTENSION) ?: 'bin')
        );
    }
}
