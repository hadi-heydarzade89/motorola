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
    const footer = document.createElement('footer');
    footer.id = 'mobile-footer';

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

    // Load Google Material Icons (if needed)
    const link = document.createElement('link');
    link.href = 'https://fonts.googleapis.com/icon?family=Material+Icons';
    link.rel = 'stylesheet';
    document.head.appendChild(link);

    // Footer Start
    // footer.innerHTML = `
    //     <div class="footer-container">
    //         <a href="/" class="footer-link">
    //             <span class="material-icons">home</span>
    //             <span>Home</span>
    //         </a>
    //         <a href="/categories" class="footer-link">
    //             <span class="material-icons">category</span>
    //             <span>Categories</span>
    //         </a>
    //         <a href="/cart" class="footer-link">
    //             <span class="material-icons">shopping_cart</span>
    //             <span>Cart</span>
    //         </a>
    //         <a href="/account" class="footer-link">
    //             <span class="material-icons">account_circle</span>
    //             <span>Account</span>
    //         </a>
    //     </div>
    // `;

    // // Append the footer to the body
    // document.body.appendChild(footer);

    // // Get all footer links
    // const footerLinks = document.querySelectorAll('.footer-link');

    // // Add click event listener to each footer link
    // footerLinks.forEach(link => {
    //     link.addEventListener('click', function (e) {
    //         e.preventDefault(); // Prevent default action for now

    //         // Remove the 'active' class from all links
    //         footerLinks.forEach(l => l.classList.remove('active'));

    //         // Add the 'active' class to the clicked link
    //         link.classList.add('active');
    //     });
    // });


    // Wait until the document is fully loaded

    // Select the footer navigation menu
    const menuItemss = document.querySelectorAll('.lower-short-menu li');
    const activeItemId = localStorage.getItem('activeMenuItemId');

    if (activeItemId) {
        const activeItem = document.querySelector(`#${activeItemId}`);
        if (activeItem) {
            activeItem.classList.add('active');  // Add 'active' class to the stored active item
        }
    }
  
    if (menuItemss.length > 0) {
      // Add Material Icons using class names from Google Fonts
      menuItemss[0].querySelector('a').insertAdjacentHTML('afterbegin', `<span class="material-icons menu-icon">home</span>`);
        menuItemss[1].querySelector('a').insertAdjacentHTML('afterbegin', `<span class="material-icons menu-icon">category</span>`);
        menuItemss[2].querySelector('a').insertAdjacentHTML('afterbegin', `<span class="material-icons menu-icon">person</span>`);
        menuItemss[3].querySelector('a').insertAdjacentHTML('afterbegin', `<span class="material-icons menu-icon">shopping_cart</span>`);
    }
    
    
    function handleMenuClick(event) {
       
        menuItemss.forEach(item => {
          item.classList.remove('active');
        });
        
        this.classList.add('active');

        localStorage.setItem('activeMenuItemId', this.id);
      }
    
      menuItemss.forEach(item => {
        item.addEventListener('click', handleMenuClick);
      });
  
    // footer End 


// Icons to be added for each category item
const icons = {
    "بدون دسته‌بندی": "category",
    "پرفروش های موتورولا": "star",
    "تلفن های همراه موتورولا": "stay_primary_portrait",
    "شگفت انگیز": "whatshot",
    "قطعات سری موتورولا ایکس": "build",
    "قطعات سری موتورولا جی": "build",
    "قطعات سری موتورولا دروید": "build",
    "قطعات سری موتورولا زد": "build",
    "قطعات سری موتورولا سی": "build",
    "قطعات سری موتورولا وان": "build",
    "قطعات موتو ۳۶۰": "watch",
    "قطعات موتو ام": "build",
    "قطعات موتو ای ۷": "build",
    "قطعات موتو ای ۷ آی پاور": "build",
    "قطعات موتو جی 9 پاور": "battery_alert",
    "قطعات موتو جی 9 پلاس": "battery_full",
    "خشاب سیم کارت": "sim_card",
    "سنسور اثر انگشت موتورولا": "fingerprint",
    "قطعات سری اج موتورولا": "build",
    "قطعات اج ۳۰ پرو": "build",
    "قطعات موتورولا":"build"
};

// Select all the menu items
const menuItems = document.querySelectorAll('#menu-secondary li a');

// Loop through each menu item and inject the icon beside the text
menuItems.forEach(menuItem => {
    const text = menuItem.innerText.trim();
    if (icons[text]) {
        const iconElement = document.createElement('span');
        iconElement.classList.add('material-icons');
        iconElement.textContent = icons[text]; // Set the appropriate icon from the object
        menuItem.prepend(iconElement); // Insert the icon before the text
    } else {
        console.log("Icon not found for:", text);
    }
});


// End Icons




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
createModal(); // Initialize the modal


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


const populateModal = (categoryName, subMenu) => {
    const modalTitle = document.getElementById('modalTitle');
    const subProductList = document.getElementById('subProductList');

    // Set modal title to the category clicked
    modalTitle.textContent = categoryName;
    subProductList.innerHTML = ''; // Clear previous items

    // Extract sub-menu items
    if (subMenu) {
        const subItems = subMenu.querySelectorAll('li');
        if (subItems.length > 0) {
            // If there are sub-menu items, list them in the modal
            subItems.forEach(item => {
                const li = document.createElement('li');
                const aTag = item.querySelector('a');
                li.textContent = aTag ? aTag.innerText : item.innerText;
                li.classList.add('sub-product-item');

                // Add click event for each subcategory
                li.addEventListener('click', (event) => {
                    event.stopPropagation();

                    // If this item has another sub-menu, populate it
                    const nestedSubMenu = item.querySelector('.sub-menu');
                    if (nestedSubMenu) {
                        populateModal(li.textContent, nestedSubMenu);
                    } else if (aTag) {
                        // If it's a final item (with no more sub-menus), navigate to the URL
                        window.location.href = aTag.href;
                    }
                });

                subProductList.appendChild(li);
            });
        }
    }
};



document.querySelectorAll('#menu-secondary li').forEach(item => {
    item.addEventListener('click', (event) => {
        event.preventDefault(); // Prevent navigation
        event.stopPropagation();

        const category = item.querySelector('a').innerText;
        const subMenu = item.querySelector('.sub-menu');

        // Populate modal with the sub-menu items
        populateModal(category, subMenu);

        // Show the modal
        setTimeout(() => {
            document.getElementById('productModal').classList.toggle('show');
        }, 300);
    });
});

// Close the modal on clicking the close button
document.getElementById('closeModal').addEventListener('click', () => {
    document.getElementById('productModal').classList.remove('show');
});
});


// Create Icons ==> Start

// Load Google Material Icons




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


