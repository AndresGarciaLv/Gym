<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Credencial</title>
    <style>
      @font-face {
            font-family: 'Rammetto One';
            src: url('{{ public_path('fonts/RammettoOne-Regular.ttf') }}') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        body {
           
        }
        .card {
            width: 53.98mm;
            height: 85.60mm;
            border-radius: 5mm;
            background-color: #f0f0f0;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            text-align: center;
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            position: relative;
        }
        .card-header {
            background-color: #7F0001;
            color: white;
            padding: 2mm 0;
        }
        .card-header img {
            width: 20mm;
            height: auto;
        }
        .card-header h2{
  font-family: "Rammetto One", sans-serif;
}
        
        .card-body {
            padding: 2mm;
        }
        .card-body h4 {
            margin: 2mm 0;
            font-size: 10pt;
            color: #333;
        }
        .card-footer img {
            width: 40mm;
            height: auto;
        }
        .card-footer h5{
            color:#7F0001;
        }
        .card-footer p {
            margin: 2mm 0;
            font-size: 12pt;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="card-header">
            @if($user->hasRole(['Super Administrador', 'Administrador']))
                <img class="image" src="{{ $logoBase64 }}" alt="Logo">
            @else
                <h2>{{ $user->gyms->first()->name }}</h2>
            @endif
        </div>
        <div class="card-body">
            <h4>{{ $user->name }}</h4>
            <h4>{{ $user->email }}</h4>
            
        </div>
        <div class="card-footer">
            <div class="card-footer">
              <h5>¡Escanea tu código!</h5>
            <img class="code" src="{{ $barcodeBase64 }}" alt="Barcode">
            <p>{{ $user->code }}</p>
            @if($user->hasRole('Cliente'))
            <h4>Cliente</h4>
        @endif
        </div>
    </div>
</body>
</html>
