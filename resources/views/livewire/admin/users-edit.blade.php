<div class="container h-100 mt-5">
    <div class="row h-100 justify-content-center align-items-center">
      <div class="col-10 col-md-8 col-lg-6">
        <h3>Actualizar Registro</h3>
        <form  method="post">
          @csrf
          @method('PUT')
          <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" class="form-control" id="name" name="name"
              value="{{ $user->name }}" required>
          </div>
          
          <button type="submit" class="btn mt-3 btn-primary">Update Post</button>
        </form>
      </div>
    </div>
  </div>
