<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Barryvdh\DomPDF\Facade\Pdf;

class CredentialController extends Controller
{
    public function printCredential($userId)
    {
        $user = User::findOrFail($userId);
        $generator = new BarcodeGeneratorPNG();
        
        // Genera el código de barras en formato PNG
        $barcode = $generator->getBarcode($user->code, $generator::TYPE_CODE_128);
        
        // Convierte el código de barras a una base64
        $barcodeBase64 = 'data:image/png;base64,' . base64_encode($barcode);

        // Convierte la imagen del logo a base64
        $logoBase64 = $this->convertImageToBase64(public_path('fotos/Logo-Ericks-500px.png'));

        return view('admin.users.generate-credential', compact('user', 'barcodeBase64', 'logoBase64'));
    }

    public function generatePDF($userId)
    {
        ini_set('memory_limit', '256M');
        set_time_limit(120);

        $user = User::findOrFail($userId);
        $generator = new BarcodeGeneratorPNG();
        
        // Genera el código de barras en formato PNG
        $barcode = $generator->getBarcode($user->code, $generator::TYPE_CODE_128);
        
        // Convierte el código de barras a una base64
        $barcodeBase64 = 'data:image/png;base64,' . base64_encode($barcode);

        // Convierte la imagen del logo a base64
        $logoBase64 = $this->convertImageToBase64(public_path('fotos/Gym-logo.png'));

        $data = [
            'user' => $user,
            'barcodeBase64' => $barcodeBase64,
            'logoBase64' => $logoBase64,
        ];

        // Genera el PDF con la vista
        $pdf = Pdf::loadView('admin.users.generate-credential', $data);

        // Descarga el PDF
        return $pdf->download('credencial.pdf');
    }

    private function convertImageToBase64($path) {
        $imageData = file_get_contents($path);
        return 'data:image/png;base64,' . base64_encode($imageData);
    }
}