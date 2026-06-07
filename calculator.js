const display = document.getElementById('display');
const operator = '';
const firstOperand = null;
const secondOperand = null;

document.querySelectorAll('.button').forEach(
    button => {
        button.addEventListener(
            'click', () => {
                const action = button.dataset.action;
                const number = button.dataset.number;

                if (number) {
                    handleNumberInput(number);
                }
                else (action) {
                    handleActionInput(action);
                }
            }
        );
    }
);