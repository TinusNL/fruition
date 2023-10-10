<nav class="header">
    <div class="top">
        <div class="search">
            <input id="search" type="text" placeholder="Search">
            <img src="./assets/icons/magnifying-glass.svg" alt="Magnifying Glass">
        </div>
        <div class="categories" id="categories-holder">
            <?php foreach (Type::getAll() as $type) : ?>
                <button data-type="<?= $type->name ?>" data-label="<?= $type->label ?>">
                    <img src="./assets/icons/food/<?= $type->name ?>.svg" alt="Category">
                    <span><?= $type->label ?></span>
                </button>
            <?php endforeach; ?>
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
            <a href="./alter-account"><img src="./assets/icons/settings.svg" alt="Settings"></a>
            <a href="./submissions"><img src="./assets/icons/submission.svg" alt="Submission"></a>
        </div>
        <div class="logo">
            <img src="./assets/logo.svg" alt="Fruition Logo">
        </div>
    </div>
</nav>

<script src="./<?= Router::getOffset() ?>scripts/filter.js"></script>