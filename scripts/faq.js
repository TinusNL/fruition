document.querySelectorAll('.question-card > h4').forEach((header) => {
    header.addEventListener('click', () => {
        header.parentElement.classList.toggle('active')
    })
})