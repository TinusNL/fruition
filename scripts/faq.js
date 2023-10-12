document.querySelectorAll('.question-card > h4').forEach((header) => {
    header.addEventListener('click', () => {
        document.querySelectorAll('.question-card').forEach((card) => {
            if (card !== header.parentElement) {
                card.classList.remove('active')
            }
        })

        header.parentElement.classList.toggle('active')
    })
})