<?php
$title = 'Home';
ob_start();
session_start();

?>


<div class="row">
    <div id="carouselExampleDark" class="carousel carousel-dark slide">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active"
                aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1"
                aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2"
                aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active" data-bs-interval="1000">
                <img src="/job_task/assets/img/img1.jpg" class="d-block w-100" alt="Image description">

            </div>
            <div class="carousel-item" data-bs-interval="2000">
                <img src="/job_task/assets/img/img2.jpg" class="d-block w-100" alt="Image description">
            </div>
            <div class="carousel-item">
                <img src="/job_task/assets/img/img2.jpg" class="d-block w-100" alt="Image description">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>

<div class="container my-2">
    <div class="row row-cols-1 row-cols-md-4 g-4">
        <div class="col-md-3">
            <div class="card mx-1">
                <img src="/job_task/assets/img/041.webp" class="card-img-top" alt="Hollywood Sign on The Hill" />
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">
                        This is a longer card with supporting text below as a natural lead-in to
                        additional content.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card mx-1">
                <img src="/job_task/assets/img/043.webp" class="card-img-top" alt="Palm Springs Road" />
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">
                        This is a longer card with supporting text below as a natural lead-in to
                        additional content.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card mx-1">
                <img src="/job_task/assets/img/044.webp" class="card-img-top" alt="Los Angeles Skyscrapers" />
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">This is a longer card with supporting text below as a natural lead-in to
                        additional content.</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card mx-1">
                <img src="/job_task/assets/img/044.webp" class="card-img-top" alt="Los Angeles Skyscrapers" />
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">This is a longer card with supporting text below as a natural lead-in to
                        additional content.</p>
                </div>
            </div>
        </div>

    </div>
</div>
<?php
$content = ob_get_clean();
include 'master.php';
?>