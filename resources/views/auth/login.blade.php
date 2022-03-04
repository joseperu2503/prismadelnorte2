@extends('layouts.app')

@section('title','Login')

@section('content')

<div class = "grid-container">
    <span class = "prisma"></span>
    <div id="login" class="login-container">       
        <form  method="post" action="" autocomplete="on"> 
            @csrf
            <h2 class = "login-titulo">Iniciar Sesión</h2>                                   
            <input class = "login-input" id="dni" name="dni" required="required" type="text" placeholder="DNI" value="{{old('dni')}}"/>
            <input class = "login-input" id="password" name="password" required="required" type="password" placeholder="Contraseña" value="{{old('password ')}}"/> 
            @error('message')
            <p class="alert alert-danger">{{$message}}</p>
            @enderror  
            <button name="login" >Entrar</button>
        
            <!-- <p class="login button"> 
                <input type="submit" name="login" value="Ingresar" /> 
            </p> -->
        
        
            <!-- <p class="change_link">
            Aun no eres miembro ?
            <a href="#toregister" class="to_register">Regístrate</a>
            </p> -->
        </form>
    </div>
</div> 



{{-- <div class="block mx-auto my-12 p-8 bg-white w-1/3 border border-gray-200
rounded-lg shadow-lg">
    <h1 class="text-3xl text-center font-bold">Login</h1>

    <form action="" class="mt-4" method="POST">
        @csrf
        <input type="email" class="border border-gray-200 rounded-md bg-gray-200 w-full text-lg placeholder-gray-900 p-2 my-2 focus:bg-white" placeholder="Email" id="email" name="email">
        <input type="password" class="border border-gray-200 rounded-md bg-gray-200 w-full text-lg placeholder-gray-900 p-2 my-2 focus:bg-white" placeholder="Password" id="password" name="password">
        @error('message')
            <p class="border border-red-500 rounded-md bg-red-100 w-full text-red-600 p-2 my-2">{{$message}}</p>
        @enderror   
        <button type="submit" class="rounded-md bg-indigo-500 w-full text-lg text-white font-semibold p-2 my-3 hover:bg-indigo-600">Send</button>
    </form>

</div> --}}
    
@endsection