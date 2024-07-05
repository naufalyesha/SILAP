document.querySelectorAll('.faq-question').forEach(item => {
    item.addEventListener('click', event => {
        const currentlyActive = document.querySelector('.faq-question.active');
        if (currentlyActive && currentlyActive !== item) {
            currentlyActive.classList.toggle('active');
            currentlyActive.nextElementSibling.style.display = 'none';
        }

        item.classList.toggle('active');
        const answer = item.nextElementSibling;
        if (item.classList.contains('active')) {
            answer.style.display = 'block';
        } else {
            answer.style.display = 'none';
        }
    });
});