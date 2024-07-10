document.addEventListener('DOMContentLoaded', () => {
    const days = document.querySelectorAll('.day');
    const buttons = document.querySelectorAll('.schedule-btn:not(.booked)');
    const calendarContainer = document.querySelector('.calendar-container');
    const btnSchedule = document.querySelector('.btn-schedule');
    const scheduleContainer = document.querySelector('.schedule');

    btnSchedule.addEventListener('click', () => {
        calendarContainer.classList.toggle('show');
    });

    days.forEach(day => {
        day.addEventListener('click', () => {
            // Remove the selected class from all days
            days.forEach(d => d.classList.remove('selected'));
            // Add the selected class to the clicked day
            day.classList.add('selected');

            // Get the selected date
            const selectedDate = day.getAttribute('data-date');
            // Show/hide the schedule buttons based on the selected date
            document.querySelectorAll('.schedule .schedule-btn').forEach(btn => {
                if (btn.getAttribute('data-date') === selectedDate) {
                    btn.style.display = 'block';
                } else {
                    btn.style.display = 'none';
                }
            });

            // Show the schedule container
            scheduleContainer.classList.add('show');
        });
    });

    buttons.forEach(button => {
        button.addEventListener('click', () => {
            // Toggle the selected class on the clicked button
            button.classList.toggle('selected');
        });
    });
});