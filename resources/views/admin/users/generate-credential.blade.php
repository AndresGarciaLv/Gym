<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Credencial</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f0f0;
        }
        .card {
            position: relative;
            width: 300px;
            border-radius: 15px;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            text-align: center;
        }
        .card-header {
            background-color: #7F0001;
            color: white;
            padding: 10px 0;
        }
        .card-header img {
            width: 80px;
            height: auto;
        }
        .card-body {
            padding: 20px;
        }
        .card-body h4 {
            margin: 10px 0;
            font-size: 1.5em;
            color: #333;
        }
        .card-body img {
            width: 200px;
            height: 50px;
        }
        .card-body p {
            margin: 5px 0;
            font-size: 1.2em;
            color: #777;
        }
        .card-footer {
            background-color: #f0f0f0;
            padding: 10px;
            color: #777;
        }
       
    </style>
</head>
<body>
    <div class="card">
        <div class="card-header">
            <img class="image" src="{{ $logoBase64 }}" alt="Logo">
        </div>
        <div class="card-body">
            <h4>{{ $user->name }}</h4>
            <img class="code" src="{{ $barcodeBase64 }}" alt="Barcode">
            <p>{{ $user->code }}</p>
        </div>
      
    </div>
</body>
</html>
