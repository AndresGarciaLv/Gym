<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Error 403</title>
    @vite('resources/css/app.css')
</head>
<body>
<div class="h-screen w-screen bg-gray-50 flex items-center">
    <div class="container flex flex-col md:flex-row items-center justify-between px-5 text-gray-700">
        <div class="w-full lg:w-1/2 mx-8">
            <p class="text-7xl text-red-700 font-dark font-extrabold mb-8">403</p>
            <p class="text-2xl md:text-3xl font-light leading-normal mb-8">
                Lo sentimos, no pudimos encontrar la página que estás buscando.
            </p>
            <a href="{{ url('/') }}" class="px-5 inline py-3 text-sm font-medium leading-5 shadow-2xl text-white transition-all duration-400 border border-transparent rounded-lg focus:outline-none bg-red-500 active:bg-red-600 hover:bg-red-700">Back to homepage</a>
        </div>
        <div class="w-full lg:flex lg:justify-end lg:w-1/2 mx-5 my-12">
            <img  src="{{ asset('fotos/404-img.svg') }}" alt="Page not found">
        </div>
    </div>
</div>
</body>
</html>
