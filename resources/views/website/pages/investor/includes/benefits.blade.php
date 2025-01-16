<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Investors Benefits</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<section class="benefits-section">
    <div class="container">
        <h2 class="section-title">Investors Benefits</h2>
        <div class="benefits-grid">
            <!-- Benefit 1 -->
            <div class="benefit-item">
                <div class="benefit-content">
                    <div class="benefit-number yellow-color">1</div>
                    <h3 class="benefit-title">Benefit</h3>
                    <p class="benefit-description">
                        Lorem ipsum dolor sit amet consectetur. Eu a aenean vulputate tristique tortor interdum.
                        Id quis morbi sagittis mi amet id non. Augue proin nibh risus sapien.
                    </p>
                </div>
            </div>
            <!-- Benefit 2 -->
            <div class="benefit-item">
                <div class="benefit-content">
                    <div class="benefit-number">2</div>
                    <h3 class="benefit-title">Benefit</h3>
                    <p class="benefit-description">
                        Lorem ipsum dolor sit amet consectetur. Eu a aenean vulputate tristique tortor interdum.
                        Id quis morbi sagittis mi amet id non. Augue proin nibh risus sapien.
                    </p>
                </div>
            </div>
            <!-- Benefit 3 -->
            <div class="benefit-item">
                <div class="benefit-content">
                    <div class="benefit-number">3</div>
                    <h3 class="benefit-title">Benefit</h3>
                    <p class="benefit-description">
                        Lorem ipsum dolor sit amet consectetur. Eu a aenean vulputate tristique tortor interdum.
                        Id quis morbi sagittis mi amet id non. Augue proin nibh risus sapien.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
</body>
</html>

<style>
    /* General Reset */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
    }

    .container h2 {
        color: white;
    }

    .benefits-section {
        position: relative;
        background: url("../img/building/investor-benefits.jpg") no-repeat center center/cover;
        background-size: cover;
        background-position: center;
        padding: 50px 20px;
        color: #fff;
        text-align: center;
        overflow: hidden; /* Ensures the pseudo-element stays within the section */
    }

    .benefits-section::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.8); /* Black overlay with 50% opacity */
        z-index: 1; /* Places the overlay above the background image */
    }

    .benefits-section * {
        position: relative;
        z-index: 2; /* Ensures text and content are above the overlay */
    }

    .section-title {
        font-size: 2.5rem;
        font-weight: bold;
        margin-bottom: 40px;
    }

    .benefits-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: center;
    }

    .benefit-item {
        flex: 1 1 calc(33.333% - 40px);
        max-width: 300px;
        /*background: rgba(0, 0, 0, 0.6); !* Semi-transparent background *!*/
        padding: 20px;
        border-radius: 8px;
        text-align: center;
    }

    .benefit-item h3 {
        color: white;
    }

    .benefit-content {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .benefit-number {
        font-size: 8rem;
        font-weight: bold;
        color: #ffd700; /* Gold color */
    }

    .benefit-title {
        font-size: 1.5rem;
        margin: 10px 0;
    }

    .benefit-description {
        font-size: 1rem;
        line-height: 1.5;
        color: #e0e0e0;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .benefit-item {
            flex: 1 1 100%;
        }
    }
</style>
