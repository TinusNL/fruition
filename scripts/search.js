const categoriesElement = document.getElementById('categories-holder')

function refreshCategories(value) {
    const children = categoriesElement.children

    for (let i = 0; i < children.length; i++) {
        const child = children[i]
        const childLabel = child.dataset.label.toLowerCase()

        if (childLabel.includes(value.toLowerCase())) {
            child.style.display = 'block'
        } else {
            child.style.display = 'none'
        }
    }
}

document.getElementById('search').addEventListener('keyup', function () {
    refreshCategories(this.value)
})