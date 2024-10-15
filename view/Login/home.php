<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cafeteria Landing Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .navbar {
            background: linear-gradient(45deg, #29023b, #81389e);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .nav-link {
            color: #fff !important;
        }

        /* Hero Section */
        .hero {
            height: 100vh;
            position: relative;
        }

        .hero h1,
        .hero p {
            animation-duration: 1s;
        }

        .hero a {
            margin-top: 20px;
        }

        .hero h1 {
            font-size: 3.5rem;
        }

        .hero p {
            font-size: 1.5rem;
        }

        .about img {
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .about h2 {
            color: #ff7e5f;
        }

        .about p {
            color: #555;
        }

        /* Footer */
        footer {
            position: relative;
            bottom: 0;
            width: 100%;
            background-color: #81389e;
            color: #fff;
            text-align: center;
            padding: 10px 0;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
     
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <img src="log.jpg" class="me-3" width="70px" height="50px" alt="not">
            <a class="navbar-brand fw-bold text-white fs-4" href="#">Cafeteria</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"></a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <div class="container ">
        <img src="5765684.jpg" style="height: 743px; width: 100%;" alt="Cafeteria Image">
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-light text-center py-3 ">
        <div class="container mb-3 ">
            <p>&copy; 2024 Cafeteria. All Rights Reserved.</p>
        </div>
        <div class="bg d-flex container  " style="margin-left: 400px;">
            <p class="fw-bold fs-5">Team Members </p>
            <i class="fa-solid fa-arrow-right fa-xl me-4 ms-2 " style="margin-top:15px ;color: white !important;"></i>
            <div class="d-flex gap-5">
            <p class="ms-5 fw-bold">Mohamed Elnashar</p>
            <p class="ms-5 fw-bold">Mohamed Ibrahiim </p>
            <p class="ms-5 fw-bold">Mahmoud Eltantawy</p>
            <p class="ms-5 fw-bold">Mohamed Ashraf</p>
            </div>
        </div>

    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>