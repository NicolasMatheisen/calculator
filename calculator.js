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
    } else {
        if (displayValue === '0' || displayValue === '') {
            displayValue = number;
        } 
        else if (number === ',') { 
            if (!displayValue.includes(',')) {
                displayValue += number;
            }
        } 
        else {
            displayValue += number;
        }
    }
    updateDisplay();
}


function handleActionInput(action) {
    if (action === 'clear') {
        displayValue = '0';
        firstOperand = null;
        secondOperand = null;
        operator = '';
        awaitSecondOperator = false;
    } 
    else if (action === 'equals') {
        if (firstOperand !== null && operator) {
            secondOperand = parseFloat(displayValue);
            displayValue = calculate(firstOperand, secondOperand, operator);
            operator = '';
            firstOperand = null;
            awaitSecondOperator = false;
        }
    }
     else if (action === 'negate') {
        displayValue = (parseFloat(displayValue) * -1).toString();
    } 
    else if (action === 'percent') {
        displayValue = (parseFloat(displayValue) / 100).toString();
    } 
    else {
        if (firstOperand === null) {
            firstOperand = parseFloat(displayValue);
        } 
        else if (operator) {
            secondOperand = parseFloat(displayValue);
            displayValue = calculate(firstOperand, secondOperand, operator);
            firstOperand = parseFloat(displayValue);
        }
        operator = action;
        awaitSecondOperator = true;
    }
    updateDisplay();
}

function calculate(firstOperand, secondOperand, operator) {
    switch (operator) {
        case 'add':
            return firstOperand + secondOperand;
        case 'subtract':
            return firstOperand - secondOperand;
        case 'multiply':
            return firstOperand * secondOperand;
        case 'divide':
            if (secondOperand === 0) {
                alert("Division durch Null ist nicht erlaubt.");
                return firstOperand;
            }
            return firstOperand / secondOperand;
        default:
            return secondOperand;
    }
}


function updateDisplay() {
    const display = document.getElementById('display');
    display.textContent = displayValue;
}