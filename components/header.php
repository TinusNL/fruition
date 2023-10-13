<nav class="header">
    <div class="top">
        <div class="search">
            <input id="search" type="text" placeholder="Search">
            <img class="filter" id="filter-action" src="./assets/icons/filter.svg" alt="Filter">
            <img class="magnify" src="./assets/icons/magnifying-glass.svg" alt="Magnifying Glass">
            <div id="filter-content">
                <form id="filter-form" action="" method="get">
                    <div class="dropdown">
                        <label for="season">Season</label>
                        <select name="season" id="season">
                            <option <?= ($_GET['season'] ?? null) == 0 ? 'selected' : '' ?> value="0">All</option>
                            <?php foreach (Season::getAll() as $season) : ?>
                                <option <?= ($_GET['season'] ?? null) == $season->id  ? 'selected' : '' ?> value="<?= $season->id ?>"><?= $season->name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <?php
                    // If logged in
                    if (!empty($_SESSION['user_id'])) :
                    ?>
                    <div class="checkbox">
                        <label for="favorites">Favorites</label>
                        <input type="checkbox" name="favorites" id="favorites" <?= ($_GET['favorites'] ?? false) == 'on' ? 'checked' : '' ?>>
                    </div>
                    <?php endif; ?>
                </form>
            </div>
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
            <?php
            if (isset($_SESSION['user_id'])) {
                echo '<a class="logout" href="/' . URL_PREFIX . '/logout"><img src="./assets/icons/backdoor.svg" alt="Logout"></a>';
            } else {
                echo '<a class="profile" href="#"><img src="./assets/icons/user.svg" alt="Profile"></a>';
            }
            ?>
            <div class="popup">
                <div class="signup">
                    <a href="/<?= URL_PREFIX ?>/signup">Sign up</a>
                </div>
                <div class="login">
                    <a href="/<?= URL_PREFIX ?>/login">Log in</a>
                </div>
                <div class="triangle"></div>
            </div>
            <?php
            if (isset($_SESSION['user_id'])) {
                echo '<a href="./alter-account"><img src="./assets/icons/settings.svg" alt="Settings"></a>';
                echo '<a href="./submissions"><img src="./assets/icons/submission.svg" alt="Submission"></a>';
            }
            ?>

        </div>
        <div class="logo">
            <img src="./assets/logo.svg" alt="Fruition Logo">
        </div>
    </div>
</nav>

<script src="./<?= Router::getOffset() ?>scripts/filter.js"></script>