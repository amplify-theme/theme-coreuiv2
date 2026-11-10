<header class="{{ backpack_theme_config('classes.header') }}">
  {{-- Logo --}}
  <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto ml-3" type="button" data-toggle="sidebar-show" aria-label="{{ trans('backpack::base.toggle_navigation')}}">
    <span class="navbar-toggler-icon"></span>
  </button>
  <a class="navbar-brand" href="{{ url(backpack_theme_config('home_link')) }}" title="{{ backpack_theme_config('project_name') }}">
    @php
    $imageSrc = config('amplify.basic.navbar_brand', 'assets/img/amplify.png');
    $imageSrc = str_starts_with($imageSrc, 'http') ? $imageSrc : asset($imageSrc);
    @endphp
    <img src="{{ $imageSrc }}" class="img-fluid img-responsive" alt="{{ config('app.name') }}"/>
  </a>
  <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button" data-toggle="sidebar-lg-show" aria-label="{{ trans('backpack::base.toggle_navigation')}}">
    <span class="navbar-toggler-icon"></span>
  </button>

  @include(backpack_view('inc.menu'))
</header>
