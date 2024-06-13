jQuery('.woocommerce-billing-fields__field-wrapper #billing_phone').on('keyup', function () {
    let value = jQuery(this).val();
    jQuery(".digcon #username").val(value);
});

jQuery('.digcon #username').on('keyup', function () {
    let value = jQuery(this).val();
    jQuery('.woocommerce-billing-fields__field-wrapper #billing_phone').val(value);
});


document.addEventListener('DOMContentLoaded', function () {


    const accountName = document.getElementById('account_first_name');
    const accountLastName = document.getElementById('account_last_name');
    const billingFirstName = document.getElementById('billing_first_name');
    const billingLastName = document.getElementById('billing_last_name');
    if (accountName) {
        addErrorSection(accountName);
    }
    if (accountLastName) {
        addErrorSection(accountLastName);
    }
    if (billingFirstName) {
        addErrorSection(billingFirstName);
    }
    if (billingLastName) {
        addErrorSection(billingLastName);
    }

});

let accountName = document.getElementById('account_first_name');
if (accountName) {
    accountName.addEventListener('input', function () {
        const input = this;
        const message = accountName.nextElementSibling;
        preventPersianCharacter(input, message);
    });
}

let accountLastName = document.getElementById('account_last_name');
if (accountLastName) {
    accountLastName.addEventListener('input', function () {
        const input = this;
        const message = accountLastName.nextElementSibling;
        preventPersianCharacter(input, message);
    });
}

let billingFirstName = document.getElementById('billing_last_name');
if (billingFirstName) {
    billingFirstName.addEventListener('input', function () {
        const input = this;
        const message = billingFirstName.nextElementSibling;
        const persianRegex = /^[\u0600-\u06FF\s]*$/;

        if (persianRegex.test(input.value)) {
            message.textContent = '';
        } else {
            input.value = input.value.replace(/[^\u0600-\u06FF\s]/g, '');
            message.textContent = 'فقط حروف فارسی مجاز می باشد.';
        }
    });
}
let billingLastName = document.getElementById('billing_first_name');
if (billingLastName) {
    billingLastName.addEventListener('input', function () {
        const input = this;
        const message = billingLastName.nextElementSibling;
        const persianRegex = /^[\u0600-\u06FF\s]*$/;

        if (persianRegex.test(input.value)) {
            message.textContent = '';
        } else {
            input.value = input.value.replace(/[^\u0600-\u06FF\s]/g, '');
            message.textContent = 'فقط حروف فارسی مجاز می باشد.';
        }
    });
}


function preventPersianCharacter(input, message) {
    const persianRegex = /^[\u0600-\u06FF\s]*$/;

    if (persianRegex.test(input.value)) {
        message.textContent = '';
    } else {
        input.value = input.value.replace(/[^\u0600-\u06FF\s]/g, '');
        message.textContent = "فقط حروف فارسی مجاز می باشد.";
        setTimeout(function () {
            message.textContent = '';
        }, 5000)

    }
}

function addErrorSection(selectedElement) {
    const newElement = document.createElement('div');

    newElement.classList.add('motorola-error');

    // Function to insert after a selected element
    function insertAfter(newNode, referenceNode) {
        referenceNode.parentNode.insertBefore(newNode, referenceNode.nextSibling);
    }

    // Insert the new element after the selected element
    insertAfter(newElement, selectedElement);
}