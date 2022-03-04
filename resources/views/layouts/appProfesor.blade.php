@extends('layouts.appHTML')

@section('sidebar')   
  <header>
    <div class="home-content">
      <i class='bx bx-menu close'></i>
      <div class="info-header close">
        <img class="foto-perfil" src="/storage/fotos_perfil/{{ $profesor->foto_perfil }}" alt="foto de perfil">
        <p>{{ $profesor->primer_nombre }}</p>
      </div>
    </div>
  </header>
  <div class="sidebar close">
    <div class="logo-details">
      <img class="logo" src="https://i.postimg.cc/y8ZNkg1R/icono-prisma.png" alt="">
      <span class="logo_name">Prisma del Norte</span>
    </div>
    <ul class="nav-links">
      <li>
        <a @if (auth()->user()->role == 'profesor')
          href="/profesor"
        @else
          href="/profesor/{{ $profesor->id }}"    
        @endif 
        >
          <i class='bx bx-grid-alt' ></i>
          <span class="link_name">Inicio</span>
        </a>
        <ul class="sub-menu blank">
          <li><a class="link_name" href="#">Inicio</a></li>
        </ul>
      </li>
    
      <li>
        <a @if (auth()->user()->role == 'profesor')
          href="{{route('profesor.mis_cursos')}}"
        @else
          href="/profesor/{{ $profesor->id }}/cursos"    
        @endif 
        >
          <i class="fas fa-book"></i>
          <span class="link_name">Mis Cursos</span>
        </a>
        <ul class="sub-menu blank">
          <li><a class="link_name" href="#">Mis Cursos</a></li>
        </ul>
      </li>
        
      <li>
        <div class="profile-details">
          <div class="profile-content">
            <!--<img src="image/profile.jpg" alt="profileImg">-->
          </div>
          <div class="name-job">
            <div class="profile_name">Cerrar Sesión</div>
          </div>
          <a href="{{route('login.destroy')}}">
            <i class='bx bx-log-out' ></i>
          </a>
          
        </div>
      </li>
    </ul>
  </div>
@endsection