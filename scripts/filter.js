const categoriesElement = document.getElementById('categories-holder')
const filterElement = document.getElementById('filter-content')

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


    if (document.documentElement.clientWidth < 376 && value.length > 0) {
        categoriesElement.style.display = 'flex'
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

// Hide categories when on mobile
document.getElementById('search').addEventListener('focusin', function () {
    if (document.documentElement.clientWidth < 376 && this.value.length == 0) {
        categoriesElement.style.display = 'flex'
    }
})

document.getElementById('search').addEventListener('focusout', function () {
    if (document.documentElement.clientWidth < 376 && this.value.length == 0) {
        categoriesElement.style.display = 'none'
    }
})

window.addEventListener('resize', function (event) {
    if (document.documentElement.clientWidth < 376 && document.getElementById('search').value.length == 0) {
        categoriesElement.style.display = 'none'
    } else {
        categoriesElement.style.display = 'flex'
    }
})

// Show/Hide filter dropdown
document.getElementById('filter-action').addEventListener('click', function () {
    filterElement.classList.toggle('active')
})

// Submit filter form on change
document.getElementById('filter-form').addEventListener('change', function () {
    this.submit()
})