# Creating Pages

## Creating a page
1. Create a folder in `pages/` with the name of the page.
2. Create a `index.php` in the newly created folder.
###### Example: `pages/home/index.php`

## Adding SCSS to a page
1. Create a `.scss` file with the name of the page in `src/scss/`.
2. Add a `@import` statement to `src/scss/main.scss` to import the new file.

## Example Page Content
```php
<div class="page-name">
    <p>Page content goes here.</p>
</div>
```