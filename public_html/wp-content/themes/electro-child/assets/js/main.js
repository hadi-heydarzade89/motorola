const link = document.createElement('link');
link.href = 'https://fonts.googleapis.com/icon?family=Material+Icons';
link.rel = 'stylesheet';
document.head.appendChild(link)
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

// Category start

const createModal = () => {
    const modal = document.createElement('div');
    modal.id = 'productModal';
    modal.classList.add('modal');

    const modalContent = document.createElement('div');
    modalContent.classList.add('modal-content');

    const closeButton = document.createElement('span');
    closeButton.classList.add('close-button');
    closeButton.id = 'closeModal';
    closeButton.innerHTML = '&times;';
    closeButton.addEventListener('click', () => {
        modal.classList.remove('show');
    });

    const modalTitle = document.createElement('h2');
    modalTitle.id = 'modalTitle';

    const subProductList = document.createElement('ul');
    subProductList.id = 'subProductList';
    subProductList.classList.add('sub-product-list');

    modalContent.appendChild(closeButton);
    modalContent.appendChild(modalTitle);
    modalContent.appendChild(subProductList);
    modal.appendChild(modalContent);
    document.body.appendChild(modal);
};


// Start category
// Call the function to create the modal
createModal();

const subProducts = {
    "بدون دسته‌بندی": ["Product 1", "Product 2"],
    "پرفروش های موتورولا": ["Moto G", "Moto X", "Moto Z"],
    "تلفن های همراه موتورولا": ["Motorola Edge", "Motorola Razr"],
    "قطعات موتورولا": {
        "قطعات سری موتورولا ایکس": ["Battery", "Screen", "Camera"],
        "قطعات سری موتورولا جی": ["Motherboard", "Speakers"],
        "قطعات سری موتورولا دروید": ["Charging Port", "Headphone Jack"]
    }
};



const populateModal = (categoryName) => {
    const modalTitle = document.getElementById('modalTitle');
    const subProductList = document.getElementById('subProductList');

    // Set the modal title with the clicked category
    modalTitle.textContent = categoryName;

    // Clear the previous list in the modal
    subProductList.innerHTML = '';

    const categoryData = subProducts[categoryName];
    if (typeof categoryData === 'object') {
        // Handle nested sub-categories
        for (let subCategory in categoryData) {
            const li = document.createElement('li');
            li.textContent = subCategory;
            li.classList.add('sub-product-item');
            
            // Add click event to show sub-products
            li.addEventListener('click', () => {
                const subProductsList = categoryData[subCategory];
                // Clear the current list and populate sub-products
                subProductList.innerHTML = '';
                subProductsList.forEach(product => {
                    const subLi = document.createElement('li');
                    subLi.textContent = product;
                    subLi.classList.add('sub-product-item');
                    subProductList.appendChild(subLi);
                });
            });
            
            subProductList.appendChild(li);
        }
    } else if (Array.isArray(categoryData)) {
        // Direct sub-products (no nested sub-categories)
        categoryData.forEach(product => {
            const li = document.createElement('li');
            li.textContent = product;
            li.classList.add('sub-product-item');
            subProductList.appendChild(li);
        });
    } else {
        // If no sub-products available, show a message
        const li = document.createElement('li');
        li.textContent = 'No sub-products available';
        li.classList.add('sub-product-item');
        subProductList.appendChild(li);
    }
};





document.querySelectorAll('.category-item').forEach(item => {
    item.addEventListener('click', (event) => {
        event.stopPropagation();

        const category = event.target.closest('.category-item').innerText;

        // Populate the modal with the appropriate sub-products
        populateModal(category);

        // Show the modal with a 500ms delay
        setTimeout(() => {
            document.getElementById('productModal').classList.toggle('show');
        }, 500);
    });
});

// Close the modal on clicking the close button
document.getElementById('closeModal').addEventListener('click', () => {
    document.getElementById('productModal').classList.remove('show');
});



document.querySelectorAll('a').forEach(link => {
    console.log(link.getAttribute('href')); // Logs the href attribute value of each <a> tag.
    // Example: Display href as a tooltip.
    link.setAttribute('#', link.getAttribute('href'));
});


// Category End


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

document.querySelector('.menu-toggle').addEventListener('click', function() {
    document.querySelector('.site-content::before').style.zIndex = 1;
});


