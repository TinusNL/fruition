<nav class="header">
    <div class="top">
        <div class="search">
            <input id="search" type="text" placeholder="Search">
            <img src="./assets/icons/magnifying-glass.svg" alt="Magnifying Glass">
        </div>
        <div class="categories" id="categories-holder">
            <button data-id="1" data-label="Apples" class="selected">
                <img src="./assets/icons/food/apple.svg" alt="Category">
                <span>Apples</span>
            </button>
            <button data-id="2" data-label="Berries">
                <img src="./assets/icons/food/berry.svg" alt="Category">
                <span>Berries</span>
            </button>
        </div>
    </div>
    <div class="bottom">
        <div class="actions">
            <a href="#"><img src="./assets/icons/user.svg" alt="Profile"></a>
            <a href="#"><img src="./assets/icons/settings.svg" alt="Settings"></a>
            <a href="#"><img src="./assets/icons/submission.svg" alt="Submission"></a>
        </div>
        <div class="logo">
            <img src="./assets/logo.svg" alt="Fruition Logo">
        </div>
    </div>
</nav>

<script src="./<?= Router::getOffset() ?>scripts/search.js"></script>