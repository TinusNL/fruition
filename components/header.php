<nav class="header">
    <div class="top">
        <div class="search">
            <input id="search" type="text" placeholder="Search">
            <img src="./assets/icons/magnifying-glass.svg" alt="Magnifying Glass">
        </div>
        <div class="categories" id="categories-holder">
            <button data-type="apple" data-label="Apples">
                <img src="./assets/icons/food/apple.svg" alt="Category">
                <span>Apples</span>
            </button>
            <button data-type="berry" data-label="Berries">
                <img src="./assets/icons/food/berry.svg" alt="Category">
                <span>Berries</span>
            </button>
        </div>
    </div>
    <div class="bottom">
        <div class="actions">
            <a class="profile" href="#"><img src="./assets/icons/user.svg" alt="Profile"></a>
            <div class="popup">
                <div class="signup">
                    <a href="#">Sign up</a>
                </div>
                <div class="login">
                    <a href="#">Log in</a>
                </div>
                <div class="triangle"></div>
            </div>
            <a href="#"><img src="./assets/icons/settings.svg" alt="Settings"></a>
            <a href="#"><img src="./assets/icons/submission.svg" alt="Submission"></a>
        </div>
        <div class="logo">
            <img src="./assets/logo.svg" alt="Fruition Logo">
        </div>
    </div>
</nav>

<script src="./<?= Router::getOffset() ?>scripts/filter.js"></script>