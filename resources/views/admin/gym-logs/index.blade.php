<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Check-IN / OUT</title>
    @vite('resources/css/app.css')
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        /* Estilos personalizados para el modal según el estado */
        .modal-content {
            border: 5px solid;
        }
        .modal-vigente {
            border-color: #28a745;
        }
        .modal-por-vencer {
            border-color: #ffc107;
        }
        .modal-vence-hoy {
            border-color: #007bff;
        }
        .modal-vencido {
            border-color: #dc3545;
        }

        /* Estilos para el input */
        #code-input {
            border: 2px solid #ccc;
            border-radius: 5px;
            font-size: 1.25rem;
            padding: 0.5rem 1rem;
            width: 100%;
            max-width: 400px;
            transition: border-color 0.3s, box-shadow 0.3s;
        }
        #code-input:focus {
            border-color: #7F0001;
            box-shadow: 0 0 5px rgba(127, 0, 1, 0.5);
            outline: none;
        }

        /* Hacer que el modal ocupe todo el ancho de la pantalla */
        .modal-dialog {
            max-width: 100%;
            margin: 0;
        }
        .modal-content {
            height: 100vh;
        }
        .modal-body {
            overflow-y: auto;
        }
    </style>
</head>

<body>
  <div class="bg-gradient-to-r from-gray-200 via-red-100 to-gray-300 min-h-screen w-full pt-3">

        <h1 class="shadow-xl p-8 text-3xl font-bold text-center uppercase">CHECK IN / OUT {{ $gym->name }}</h1>

      <div class="max-w-10xl mx-auto sm:px-6 lg:px-8">
          <div class="overflow-hidden shadow-sm sm:rounded-lg">
              <div class="flex flex-col items-center justify-center p-6 bg-white border-b border-gray-200">
                  <h2 class="text-[#7F0001]">¡Escanea tu código de Barras!</h2>
                  <img class="w-[250px] h-[250px]" src="{{ asset('fotos/codigo-de-barras.png') }}" alt="Imagen Barcode" />
                  <form id="checkin-form" method="POST" action="{{ route('admin.gym-log.logAction', $gym->id) }}">
                      @csrf
                      <input class="text-center text-4xl" type="text" id="code-input" name="code" placeholder="Ingresa el código" maxlength="6" required />
                      <input type="hidden" name="id_gym" value="{{ $gym->id }}"> <!-- ID del gimnasio dinámico -->
                      <button type="submit" class="ml-2 p-2 bg-blue-500 text-white rounded" style="display: none;">Buscar</button>
                      @if ($errors->has('code'))
                      <div id="code-error-message" class="text-red-500 mt-2">{{ $errors->first('code') }}</div>
                  @endif
                  </form>

                  @if (session('message'))
                      <script>
                          $(document).ready(function() {
                              // Aplicar blur al contenido principal
                              $('body > .bg-gradient-to-r');

                              // Mostrar el modal
                              $('#messageModal').modal('show');
                              setTimeout(function() {
                                  $('#messageModal').modal('hide');
                                  // Quitar el blur después de cerrar el modal
                                  $('body > .bg-gradient-to-r');
                              }, 10000);
                          });
                      </script>
                  @endif

              </div>
          </div>
      </div>
      <div class="mt-5 text-sm text-center text-gray-500 font-semibold py-1">
        Copyright © <span id="get-current-year">2024</span><a href="https://www.facebook.com/profile.php?id=61558455937047" class="hover:underline text-gray-500 hover:text-gray-800" target="_blank"> Erick's GYM </a>
        <span>by</span>
        <a href="https://www.firenow.com" class="text-gray-500 hover:text-gray-800 hover:underline">Firenow Solutions</a>.
      </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="messageModal" tabindex="-1" role="dialog" aria-labelledby="messageModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content
              @if (session('status') == 'Vigente') modal-vigente
              @elseif (session('status') == 'Por Vencer') modal-por-vencer
              @elseif (session('status') == 'Vence Hoy') modal-vence-hoy
              @else modal-vencido
              @endif">
              <div class="modal-header"
                  style="background-color:
                      @if (session('status') == 'Vigente') #28a745
                      @elseif (session('status') == 'Por Vencer') #ffc107
                      @elseif (session('status') == 'Vence Hoy') #007bff
                      @else #dc3545
                      @endif;">
              <h5 class="modal-title" id="messageModalLabel">
                @if (session('status') == 'Vencido')
                    Acceso Denegado
                @else
                    {{ session('action') == 'entry' ? 'Registro de Entrada' : 'Registro de Salida' }}
                @endif
            </h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body text-center">

                        @if (session('status') == 'Vigente')
                            <h2 class="text-gray-700">Bienvenido, disfruta tu visita.</h2>
                            <h3 class="text-[#28a745]">
                                {{ session('message') }}
                            </h3>

                        @elseif (session('status') == 'Por Vencer')
                        <h3 class="text-gray-700">Bienvenido, disfruta tu visita.</h2>
                        <h4 class="text-[#ffc107] ">
                            {{ session('message') }}
                        </h4>
                        <h5 class="text-gray-700">Te quedan pocos días, ¡No te quedes sin acceso!</h5>
                        <h4 class="text-[#7F0001]">¡Renueva tú Membresía en Recepción!</h4>

                        @elseif (session('status') == 'Vence Hoy')
                        <h3 class="text-gray-700">Bienvenido, disfruta tu visita.</h2>
                        <h4 class="text-[#007bff] ">
                            {{ session('message') }}
                        </h4>
                        <h5 class="text-gray-700">Por favor, pasa a recepción para renovar tú membresía.</h5>

                        @elseif (session('status') == 'Vencido')
                            <h4 class="text-[#7F0001] ">
                                {{ session('message') }}
                            </h4>

                        @else
                            <h3 class="text-gray-700 ">{{ session('message') }}</h3>
                        @endif

                  @if(session('membership') && session('user'))
                      <div class="mt-4 flex flex-col justify-center items-center">
                          <p class="text-xl"><strong>{{ session('membership')->membership->name }}</strong> </p>
                          <p><strong>Fecha de Vencimiento:</strong> {{ \Carbon\Carbon::parse(session('membership')->end_date)->format('d-m-Y') }}</p>

                          <p><strong>Gimnasio:</strong> {{ session('membership')->gym->name }}</p>
                          <p><strong>Usuario:</strong> {{ session('user')->name }}</p>
                          <p><strong>Hora:</strong> {{ session('currentTime') }}</p>
                          <img class="w-32 h-32 rounded-full" src="{{ session('user')->photo ? asset('storage/' . session('user')->photo) : asset('fotos/Avatar.webp') }}" alt="Foto de perfil" />
                      </div>
                  @endif
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
              </div>
          </div>
      </div>

  </div>



  <script>
      document.addEventListener('DOMContentLoaded', function () {
          const codeInput = document.getElementById('code-input');
          // Focus the input when the page loads
          codeInput.focus();

          // Re-focus the input whenever it loses focus
          codeInput.addEventListener('blur', function () {
              setTimeout(function () {
                  codeInput.focus();
              }, 0);
          });


        codeInput.addEventListener('input', function (e) {
              let value = codeInput.value;
              // Eliminar caracteres no alfanuméricos y convertirlos a mayúsculas

              value = value.replace(/[^a-zA-Z0-9]/g, '').toUpperCase();
              // Limite de 6 caracteres
              if (value.length > 6) {
                  value = value.slice(0, 6);
              }
              codeInput.value = value;

              if (codeInput.value.length === 6) { // Suponiendo un código de 6 caracteres
                  document.getElementById('checkin-form').submit();
              }
          });

            // Ocultar el mensaje de error después de 10 segundos
        const errorMessage = document.getElementById('code-error-message');
        if (errorMessage) {
            setTimeout(function () {
                errorMessage.style.display = 'none';
            }, 10000); // 10 segundos
        }
      });
  </script>
</body>
</html>
