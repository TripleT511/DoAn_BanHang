<!DOCTYPE html>
<html lang="en" class="light-style" dir="ltr" data-theme="theme-default" data-assets-path="{{ asset('ad/assets') }}"
  data-template="vertical-menu-template-free">

<head>
  <meta charset="utf-8" />
  <meta name="viewport"
    content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title>Error - Pages</title>

  <meta name="description" content="" />

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="{{ asset('ad/assets/img/favicon/favicon.ico') }}" />

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
    rel="stylesheet" />

  <!-- Icons. Uncomment required icon fonts -->
  <link rel="stylesheet" href="{{ asset('ad/assets/vendor/fonts/boxicons.css') }}" />

  <!-- Core CSS -->
  <link rel="stylesheet" href="{{ asset('ad/assets/vendor/css/core.css') }}" class="template-customizer-core-css" />

  <!-- Page -->
  <link rel="stylesheet" href="{{ asset('ad/assets/vendor/css/pages/page-misc.css') }}" />
  <!-- Helpers -->
</head>

<body>
  <!-- Content -->

  <!-- Error -->
  <div class="container-xxl container-p-y">
    <div class="misc-wrapper">
      <h2 class="mb-2 mx-2">Không tìm thấy trang</h2>
      <a href="{{ route('home') }}" class="btn btn-primary">Về trang chủ</a>
      <div class="mt-3">
        <img src="{{ asset('ad/assets/img/illustrations/page-misc-error-light.png') }}" alt="page-misc-error-light" width="500"
          class="img-fluid" data-app-dark-img="illustrations/page-misc-error-dark.png"
          data-app-light-img="illustrations/page-misc-error-light.png" />
      </div>
    </div>
  </div>
</body>

</html>