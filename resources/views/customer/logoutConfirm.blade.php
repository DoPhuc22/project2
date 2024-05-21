<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Logged Out Page</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- Font Awesome CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
  <!-- Your Custom CSS -->
  <link rel="stylesheet" href="path/to/your/custom.css">
</head>
@vite(["resources/sass/app.scss", "resources/js/app.js"])
<body class="bg-light">
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6" style="flex: 0 0 60%; max-width: 60%">
        <div class="card">
          <div class="card-body text-center">
            <img src="{{asset('admin-assets/img/paradise-theatre-logo.png')}}" alt="logo" class="img-fluid mb-4">
            <h1 class="font-weight-bold text-danger mb-4">You Have Been Logged Out</h1>
            <p class="mb-4">Thank you for using our website. Please <a href="{{route('customer.login')}}">click here</a> to login back to our site.</p>
            <!-- You can add your form or any other content here -->
          </div>
        </div>
        <div class="text-center mt-4">
          <a href="{{route('home')}}" class="text-dark">Home</a>
          <span class="mx-2 text-muted">|</span>
          {{-- <a href="#" class="text-dark">About</a>
          <span class="mx-2 text-muted">|</span> --}}
          <a href="{{route('help')}}" class="text-dark">FAQ</a>
          {{-- <span class="mx-2 text-muted">|</span>
          <a href="#" class="text-dark">Contact</a> --}}
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS and Popper.js -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <!-- Your Custom JS -->
  <script src="path/to/your/custom.js"></script>
</body>
</html>
