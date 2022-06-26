@extends('layouts.admin')

@section('title','Error - Pages')
@section('content')
<div class="container-xxl container-p-y">
      <div class="misc-wrapper">
        <h2 class="mb-2 mx-2">Page Not Found :(</h2>
        <p class="mb-4 mx-2">Oops! 😖 The requested URL was not found on this server.</p>
        <a href="index.html" class="btn btn-primary">Back to home</a>
        <div class="mt-3">
          <img src="../assets/img/illustrations/page-misc-error-light.png" alt="page-misc-error-light" class="img-fluid" data-app-dark-img="illustrations/page-misc-error-dark.png" data-app-light-img="illustrations/page-misc-error-light.png" width="500">
        </div>
      </div>
    </div>
@endsection