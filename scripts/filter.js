const categoriesElement = document.getElementById('categories-holder')

// Searching
function refreshSearch(value) {
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
    refreshSearch(this.value)
})


// Filtering

const selectedFilters = []

function refreshFilter() {
    const children = categoriesElement.children

    for (let i = 0; i < children.length; i++) {
        const child = children[i]

        if (selectedFilters.length == 0) {
            if (!child.classList.contains('selected')) {
                showMarkerType(child.dataset.type)
            }
            child.classList.remove('selected')
            continue
        }

        if (selectedFilters.includes(child.dataset.type)) {
            if (child.classList.contains('selected')) {
                continue
            }
            child.classList.add('selected')
            showMarkerType(child.dataset.type)
        } else {
            child.classList.remove('selected')
            hideMarkerType(child.dataset.type)
        }
    }
}

function toggleFilter(type) {
    if (selectedFilters.includes(type)) {
        selectedFilters.splice(selectedFilters.indexOf(type), 1)
    } else {
        selectedFilters.push(type)
    }

    refreshFilter()
}

const children = categoriesElement.children
for (let i = 0; i < children.length; i++) {
    const child = children[i]

    child.addEventListener('click', function () {
        toggleFilter(this.dataset.type)
    })
}