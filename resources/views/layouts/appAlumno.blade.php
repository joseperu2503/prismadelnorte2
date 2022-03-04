@extends('layouts.appHTML')

@section('sidebar')   
  <header>
    <div class="home-content">
      <i class='bx bx-menu close'></i>
      <div class="info-header close">
        <img class="foto-perfil" src="{{ $alumno->foto_perfil }}" alt="foto de perfil">
        <p>{{ $alumno->primer_nombre }}</p>
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
        <a href="/alumno">
          <i class='bx bx-grid-alt' ></i>
          <span class="link_name">Inicio</span>
        </a>
        <ul class="sub-menu blank">
          <li><a class="link_name" href="#">Inicio</a></li>
        </ul>
      </li>
    
      <li>
        <a href="/alumno/perfil">
          <i class="fas fa-id-card"></i>
          <span class="link_name">Perfil</span>
        </a>
        <ul class="sub-menu blank">
          <li><a class="link_name" href="#">Perfil</a></li>
        </ul>
      </li>
      <li>
        <a href="/alumno/cursos">
          <i class="fas fa-book"></i>
          <span class="link_name">Mis Cursos</span>
        </a>
        <ul class="sub-menu blank">
          <li><a class="link_name" href="#">Mis Cursos</a></li>
        </ul>
      </li>
      <li>
        <div class="iocn-link">
          <a href="#">
            <i class="fas fa-check-double"></i>
            <span class="link_name">Reporte academico</span>
          </a>
          <i class='bx bxs-chevron-down arrow' ></i>
        </div>
        <ul class="sub-menu">
          <li><a class="link_name" href="#">Reporte academico</a></li>
          <li><a href="/alumno/mi_asistencia">Asistencia</a></li>
          <li><a href="#">Disciplina</a></li>          
        </ul>
      </li>
      <li>
        <div class="profile-details">
          
          <div class="profile-content">
            <!--<img src="image/profile.jpg" alt="profileImg">-->
          </div>
          <div class="name-job">
            <div class="profile_name">Cerrar Sesion</div>
          </div>
          <a href="{{route('login.destroy')}}">
            <i class='bx bx-log-out' ></i>
          </a>
          
        </div>
      </li>
    </ul>
  </div>
@endsection