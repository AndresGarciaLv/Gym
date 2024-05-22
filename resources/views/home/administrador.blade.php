@extends('layouts.panel')

@section('titulo')
   Dashboard
@endsection

@section('contenido')
<h1>Home ADMINISTRADOR</h1>

<script>
   @if (session('success'))
       toastr.success("{{ session('success') }}");
   @endif
</script>
@endsection