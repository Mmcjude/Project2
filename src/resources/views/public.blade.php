<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Martin's Book Store - {{ $title }}</title>
    <meta name="description" content="Welcome to Martin's Book Store">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Bootstrap CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
        rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
        crossorigin="anonymous">
    
    <!-- Bootstrap Icons CSS -->
    <link 
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" 
        rel="stylesheet">

    <!-- Custom CSS for Styling -->
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
            opacity: 0;
            animation: fadeIn 1.5s forwards;
        }
        
        /* Fade-in animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .navbar {
            background-color: #343a40;
        }
        .navbar-brand, .nav-link {
            color: #fff !important;
        }
        .navbar-brand:hover, .nav-link:hover {
            color: #f1c40f !important;
        }
        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-radius: 10px;
        }
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .card-body {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .section-title {
            font-size: 2rem;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 30px;
        }
        .footer {
            background-color: #343a40;
            color: #fff;
            padding: 20px 0;
        }
        .btn-primary {
            background-color: #f1c40f;
            border-color: #f1c40f;
        }
        .btn-primary:hover {
            background-color: #e67e22;
            border-color: #e67e22;
        }
        .admin-section {
            background-color: #f5f5f5;
            padding: 30px;
            border-radius: 10px;
            margin-top: 30px;
        }
        .card-title {
            font-size: 1.25rem;
            color: #2c3e50;
        }
        .lead {
            color: #7f8c8d;
        }
        .icon-btn {
            font-size: 1.5rem;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">Martin's Book Store</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/books">Books</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/authors">Authors</a>
                    </li>
                    @if(Auth::check())
                        <li class="nav-item">
                            <a class="nav-link" href="/logout">Log out</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="/login">Authenticate</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container mt-5">
        
        <!-- Home Section for Public Viewers -->
        <section id="home" class="text-center">
            <h1 class="display-4 text-primary mb-4">Welcome to Martin's Book Store!</h1>
            <p class="lead text-muted mb-4">Explore our curated collection of best-selling and trending books. Dive into your next adventure today!</p>
            <a href="/books" class="btn btn-primary btn-lg">Browse Books <i class="bi bi-search"></i></a>
        </section>

        <!-- Public Books Section -->
        <section id="books" class="mt-5">
            <h2 class="section-title text-center">Featured Book: To Kill a Mockingbird</h2>
            <div class="row">
                <!-- Featured Book Card -->
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">To Kill a Mockingbird</h5>
                            <p class="card-text">A classic novel of racial injustice and childhood innocence in the Deep South.</p>
                            <a href="#" class="btn btn-primary">Read More <i class="bi bi-bookmark"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Admin Section (Visible only to Admin Users) -->
        @auth
            @if(Auth::user()->role == 'admin')
                <section id="admin" class="admin-section mt-5">
                    <h2 class="section-title text-center">Admin Dashboard</h2>
                    <div class="text-center">
                        <a href="/manage-books" class="btn btn-primary btn-lg">Manage Books <i class="bi bi-book"></i></a>
                        <a href="/manage-authors" class="btn btn-primary btn-lg ml-3">Manage Authors <i class="bi bi-person"></i></a>
                    </div>
                </section>
            @endif
        @endauth

    </main>

    <!-- Footer -->
    <footer class="footer text-center">
        <div class="container">
            <p>&copy; 2024 Martin's Book Store. All Rights Reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-ENNnntmfhZbFG++XNpaIPFPYeosv89dIoepcqjYPja5u9vxOTNn3TGjGOePwyiqC" 
        crossorigin="anonymous"></script>
</body>
</html>
