@extends('layouts.appHTML')

@section('sidebar')   
  <header>
    <div class="home-content">
      <i class='bx bx-menu close'></i>
      <div class="info-header close">
        <img class="foto-perfil" src="/storage/fotos_perfil/usuario.png" alt="foto de perfil">
        <p class="my-0">Admin</p>
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
        <a href="{{route('admin.inicio')}}">
          <i class='bx bx-grid-alt' ></i>
          <span class="link_name">Inicio</span>
        </a>
        <ul class="sub-menu blank">
          <li><a class="link_name" href="{{route('admin.inicio')}}">Inicio</a></li>
        </ul>
      </li>
      <li>
        <div class="iocn-link">
          <a href="{{route('admin.alumnos')}}">
            <i class="fas fa-graduation-cap"></i>
            <span class="link_name">Alumnos</span>
          </a>
          <i class='bx bxs-chevron-down arrow' ></i>
        </div>
        <ul class="sub-menu">
          <li><a class="link_name" href="{{route('admin.alumnos')}}">Alumnos</a></li>
          <li><a href="{{route('admin.alumnos')}}">Todos los alumnos</a></li>     
          <li><a href="{{route('admin.aulas')}}">Alumnos por aula</a></li>   
        </ul>
      </li>
      <li>
        <a href="{{route('admin.profesores')}}">
          <i class="fas fa-chalkboard-teacher"></i>
          <span class="link_name">Profesores</span>
        </a>
        <ul class="sub-menu blank">
          <li><a class="link_name" href="#">Profesores</a></li>
        </ul>
      </li>
      <li>
        <a href="{{route('admin.cursos')}}">
          <i class="fas fa-book"></i>
          <span class="link_name">Cursos</span>
        </a>
        <ul class="sub-menu blank">
          <li><a class="link_name" href="#">Cursos</a></li>
        </ul>
      </li>
      <li>
        <div class="iocn-link">
          <a href="/asistencia_alumnos">
            <i class="fas fa-check-double"></i>
            <span class="link_name">Asistencia</span>
          </a>
          <i class='bx bxs-chevron-down arrow' ></i>
        </div>
        <ul class="sub-menu">
          <li><a class="link_name" href="/asistencia_alumnos">Asistencia</a></li>
          <li><a href="/asistencia_alumnos">Alumnos</a></li>
          <li><a href="/asistencia_profesores">Profesores</a></li>
          <li><a href="/asistencia_trabajadores">Trabajadores</a></li>
          <li><a href="/nueva_asistencia">Registrar asistencia</a></li>          
        </ul>
      </li>
      <li>
        <a href="{{route('admin.trabajadores')}}">
          <i class="fas fa-briefcase"></i>
          <span class="link_name">Personal Complementario</span>
        </a>
        <ul class="sub-menu blank">
          <li><a class="link_name" href="#">Personal Complementario</a></li>
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
