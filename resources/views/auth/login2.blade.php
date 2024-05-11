<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    @vite('resources/css/app.css')
</head>
<body>
    
<div className="grid grid-cols-1 lg:grid-cols-2 min-h-screen">
    <div className="flex flex-col items-center justify-center bg-gray-100 rounded-tl-lg rounded-bl-lg p-4">
      <div className="my-8">
        <img src="{{ asset('fotos/Logo-Ericks-500px.png') }}" alt="Ericks GYM" width="100" height="100" />
      </div>
      <div className="flex flex-col items-center gap-8">
        <h1 className="text-4xl font-bold text-gray-900">Bienvenido</h1>
        
      </div>
      <div className="my-14">
        <p className="text-center relative text-gray-500 bg-gray-100 before:max-w-[50px] md:before:max-w-[120px] before:w-full before:-left-[60px] md:before:-left-[140px] before:h-[1px] before:bg-current before:absolute before:top-[50%] after:max-w-[50px] md:after:max-w-[120px] after:w-full after:h-[1px] after:bg-current after:absolute after:top-[50%] after:-right-[60px] md:after:-right-[140px]">
          Ingresa con tu email
        </p>
      </div>
      <div className="w-full mb-8">
        <form>
          <div className="flex justify-center mb-4">
            <input
              type="email"
              className="w-full max-w-md py-2 px-4 rounded-lg outline-none"
              placeholder="Correo electrónico"
            />
          </div>
          <div className="flex justify-center mb-6">
            <input
              type="password"
              className="w-full max-w-md py-2 px-4 rounded-lg outline-none"
              placeholder="Password"
            />
          </div>
          <div className="w-full max-w-md mx-auto flex items-center justify-between text-gray-500 mb-8">
            <div className="flex items-center gap-2">
              <input type="checkbox" id="remember" />
              <label htmlFor="remember">Recordarme</label>
            </div>
            <div>
              <a
                href="#"
                className="hover:underline hover:text-gray-900 transition-all"
              >
                ¿Olvidaste tu password?
              </a>
            </div>
          </div>
          <div className="w-full max-w-md mx-auto">
            <button
              type="submit"
              className="w-full bg-gray-200 py-2 px-4 rounded-lg text-gray-900 hover:bg-gray-300 transition-colors"
            >
              Iniciar sesión
            </button>
          </div>
        </form>
      </div>
      <div>
        <span className="text-gray-500">
          ¿No tienes cuenta?{" "}
          <a
            href="#"
            className="text-gray-900 hover:underline transition-all"
          >
            Registrate
          </a>
        </span>
      </div>
    </div>
    <div className="hidden lg:flex items-center justify-center border-t border-r border-b rounded-tr-lg rounded-br-lg">
      <img
        src="https://img.freepik.com/vector-gratis/ilustracion-concepto-inicio-sesion_114360-739.jpg?w=826&t=st=1661290496~exp=1661291096~hmac=f284a9abf6658fc4278a4d2fc1b2b25c0083f1051b424e23d2885365b89e169c"
        className="w-full object-cover"
      />
    </div>
  </div>
</body>
</html>