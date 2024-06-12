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

        // Obtener la foto del gimnasio o el nombre del gimnasio
        $gym = $user->gyms->first();
        if ($user->gyms->count() > 1) {
            $logoBase64 = $this->convertImageToBase64(public_path('fotos/EricksCredential-bn.png'));
        } else if ($gym && $gym->photo) {
            $logoBase64 = $this->convertImageToBase64(storage_path('app/public/' . $gym->photo));
        } else if ($gym) {
            $gymName = $gym->name;
        } else {
            $logoBase64 = $this->convertImageToBase64(public_path('fotos/EricksCredential-bn.png'));
        }

        return view('admin.users.generate-credential', compact('user', 'barcodeBase64', 'logoBase64', 'gymName'));
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

        // Obtener la foto del gimnasio o el nombre del gimnasio
        $gym = $user->gyms->first();
        if ($user->gyms->count() > 1) {
            $logoBase64 = $this->convertImageToBase64(public_path('fotos/EricksCredential-bn.png'));
        } else if ($gym && $gym->photo) {
            $logoBase64 = $this->convertImageToBase64(storage_path('app/public/' . $gym->photo));
        } else if ($gym) {
            $gymName = $gym->name;
        } else {
            $logoBase64 = $this->convertImageToBase64(public_path('fotos/EricksCredential-bn.png'));
        }

        $data = [
            'user' => $user,
            'barcodeBase64' => $barcodeBase64,
            'logoBase64' => $logoBase64 ?? null,
            'gymName' => $gymName ?? null,
        ];

        // Genera el PDF con la vista y ajusta el tamaño de la página
        $pdf = Pdf::loadView('admin.users.generate-credential', $data)
                  ->setPaper([0, 0, 226.38, 357.17], 'portrait');

        // Descarga el PDF
        return $pdf->download('credencial.pdf');
    }

    private function convertImageToBase64($path) {
        $imageData = file_get_contents($path);
        return 'data:image/png;base64,' . base64_encode($imageData);
    }
}
