<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            height: 100vh;
            background-color: #343a40;
            color: white;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #495057;
            color: #ffc107;
        }
        .nav-link.active {
            background-color: #495057;
        }
        .content {
            padding: 2rem;
        }

        /* Untuk perangkat kecil, sidebar bisa disembunyikan */
        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                top: 0;
                left: -250px;
                width: 250px;
                height: 100%;
                transition: all 0.3s;
            }
            .sidebar.show {
                left: 0;
            }
            .navbar-toggler {
                display: block;
            }
        }
    </style>
</head>
<body>
<div class="d-flex flex-column flex-md-row">
    <!-- Sidebar -->
    <div class="sidebar p-3" id="sidebar">
        <h4 class="mb-4"><i class="bi bi-speedometer2"></i> Admin Panel</h4>
        <ul class="nav flex-column">
            <li class="nav-item mb-2">
                <a class="nav-link {{ request()->routeIs('admin.index') ? 'active' : '' }}" href="{{ route('admin.index') }}">
                    <i class="bi bi-card-checklist"></i> Soal Kuis
                </a>
            </li>
            <li class="nav-item mb-2">
                <a class="nav-link {{ request()->routeIs('admin.visitors') ? 'active' : '' }}" href="{{ route('admin.visitors') }}">
                    <i class="bi bi-people-fill"></i> Pengunjung Hari Ini
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="flex-grow-1">
        <nav class="navbar navbar-light bg-white shadow-sm">
            <div class="container-fluid">
                <span class="navbar-brand mb-0 h1">Dashboard Admin</span>

                <!-- Hamburger Toggle Button for Small Screens -->
                <button class="navbar-toggler d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Logout Icon -->
                <form method="POST" action="{{ route('logout') }}" class="d-inline-block">
                    @csrf
                    <button type="submit" class="btn btn-link text-danger">
                        <i class="bi bi-box-arrow-right" style="font-size: 1.5rem;"></i>
                    </button>
                </form>
            </div>
        </nav>
        <div class="content">
            @yield('content')
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // For small screen, toggle sidebar visibility
    const toggleButton = document.querySelector('.navbar-toggler');
    const sidebar = document.getElementById('sidebar');
    
    toggleButton.addEventListener('click', function() {
        sidebar.classList.toggle('show');
    });
</script>
</body>
</html>
