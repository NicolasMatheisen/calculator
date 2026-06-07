let displayValue = '0';
let operator = '';
let firstOperand = null;
let secondOperand = null;
let awaitSecondOperator = false;

document.querySelectorAll('.button').forEach(
    button => {
        button.addEventListener(
            'click', () => {
                const action = button.dataset.action;
                const number = button.dataset.number;

                if (number) {
                    handleNumberInput(number);
                }
                else if (action) {
                    handleActionInput(action);
                }
            }
        );
    }
);

function handleNumberInput(number) {
    if (awaitSecondOperator) {
        displayValue = number;
        awaitSecondOperator = false;
    }
    else {
        displayValue = displayValue === '0' ? number : displayValue + number;
    }
    updateDisplay();
}

function updateDisplay() {
    const display = document.getElementById('display');
    display.textContent = displayValue;
}