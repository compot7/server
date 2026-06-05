const input = document.getElementById('expressionInput');
const buttons = document.querySelectorAll('.calc-btn');

buttons.forEach((button) => {
    button.addEventListener('click', () => {
        const value = button.dataset.value;

        if (value === '=') {
            return;
        }

        if (value === 'C') {
            input.value = '';
            return;
        }

        if (value === '.' && /(^|[^\d])\d*\.\d*$/.test(input.value)) {
            return;
        }

        input.value += value;
    });
});
