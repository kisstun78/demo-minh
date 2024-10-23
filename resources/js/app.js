import 'mdb-ui-kit/js/mdb.umd.min.js';
import * as mdb from 'mdb-ui-kit'; // lib
window.mdb = mdb;

document.addEventListener('DOMContentLoaded', function() {
    // Lấy tất cả các nhóm input-number
    const inputGroups = document.querySelectorAll('.input-number');

    inputGroups.forEach(group => {
        const numberInput = group.querySelector('.number-input');
        const decrementButton = group.querySelector('.btn-decrement');
        const incrementButton = group.querySelector('.btn-increment');

        decrementButton.addEventListener('click', function() {
            let currentValue = parseInt(numberInput.value) || 0;
            if (currentValue > 0) {
                numberInput.value = currentValue - 1;
            }
        });

        incrementButton.addEventListener('click', function() {
            let currentValue = parseInt(numberInput.value) || 0;
            numberInput.value = currentValue + 1;
        });
    });
});

