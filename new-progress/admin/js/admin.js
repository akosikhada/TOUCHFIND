/**
 * TOUCHFIND Admin JavaScript
 */

// Initialize charts when DOM is loaded
document.addEventListener("DOMContentLoaded", function () {
  // Initialize product image preview
  const productImageInput = document.getElementById("productImage");
  if (productImageInput) {
    initializeProductImagePreview(productImageInput);
  }

  // Initialize product action buttons
  initializeProductActions();

  // Initialize chat message action buttons
  initializeChatMessageActions();

  // Initialize admin header search and filter
  initializeAdminHeader();

  // Initialize edit product image preview
  const editProductImageInput = document.getElementById("editProductImage");
  if (editProductImageInput) {
    initializeProductImagePreview(editProductImageInput);
  }

  // Initialize save product changes button
  const saveProductChangesBtn = document.getElementById("saveProductChanges");
  if (saveProductChangesBtn) {
    saveProductChangesBtn.addEventListener("click", saveProductChanges);
  }

  // Initialize save message changes button
  const saveMessageChangesBtn = document.getElementById("saveMessageChanges");
  if (saveMessageChangesBtn) {
    saveMessageChangesBtn.addEventListener("click", saveMessageChanges);
  }

  // Initialize delete confirmation buttons
  initializeDeleteConfirmations();

  // Initialize the notification container
  initializeNotifications();
});

/**
 * Initialize product image preview functionality
 * @param {HTMLElement} inputElement - The file input element
 */
function initializeProductImagePreview(inputElement) {
  inputElement.addEventListener("change", function (e) {
    const file = e.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function (e) {
        const placeholder = document.querySelector(
          ".product-image-placeholder"
        );
        placeholder.innerHTML = `<img src="${e.target.result}" alt="Product Preview" class="img-fluid product-preview">`;
        placeholder.classList.add("has-image");
      };
      reader.readAsDataURL(file);
    }
  });
}

/**
 * Initialize product action buttons (edit and delete)
 */
function initializeProductActions() {
  // Edit product button functionality
  const editButtons = document.querySelectorAll("button[data-product-id]");
  if (editButtons.length > 0) {
    editButtons.forEach((button) => {
      // Only add click handler to edit buttons (not delete buttons)
      if (button.classList.contains("edit-btn")) {
        button.addEventListener("click", function (e) {
          e.preventDefault();
          const productId = this.getAttribute("data-product-id");
          const productRow = this.closest("tr");

          // Get product details from the row
          openEditProductModal(productRow, productId);
        });
      }
    });
  }

  // Delete product button functionality
  const deleteButtons = document.querySelectorAll(
    "button.delete-btn[data-product-id]"
  );
  if (deleteButtons.length > 0) {
    deleteButtons.forEach((button) => {
      button.addEventListener("click", function (e) {
        e.preventDefault();
        const productId = this.getAttribute("data-product-id");
        const productRow = this.closest("tr");
        const productName =
          productRow.querySelector(".product-name").textContent;

        // Open delete confirmation modal
        openDeleteModal(productName, productId);
      });
    });
  }

  // Note: The delete confirmation button handler is now managed by initializeTypeDeleteConfirmation()
}

/**
 * Opens the edit product modal and populates it with the product data
 * @param {HTMLElement} productRow - The table row element containing the product data
 * @param {string} productId - The product ID
 */
function openEditProductModal(productRow, productId) {
  // Get product details from the row
  const productName = productRow.querySelector(".product-name").textContent;
  const productSku = productRow
    .querySelector(".product-sku")
    .textContent.replace("SKU: ", "");
  const productStock = productRow.querySelector(".stock-badge").textContent;
  const productLocation = productRow.querySelector(
    "td[data-label='LOCATION'] .shelf-location"
  ).textContent;
  const productPrice = productRow
    .querySelector("td[data-label='PRICE'] .price-value")
    .textContent.replace("₱", "")
    .replace(",", "")
    .trim();
  const productImageSrc = productRow.querySelector(".product-image img").src;
  const productCategory =
    productRow.querySelector(".product-category").textContent;
  const productDescription = productRow.querySelector(
    ".full-product-description"
  ).value;

  console.log("Description:", productDescription);

  // Set values in the modal
  document.getElementById("editProductId").value = productId;
  document.getElementById("editProductName").value = productName;
  document.getElementById("editSku").value = productSku;
  document.getElementById("editDesc").value = productDescription;
  console.log(
    "Desc field value after setting:",
    document.getElementById("editDesc").value
  );

  // Handle category dropdown - find option with matching text and select it
  const categoryText = productRow
    .querySelector(".product-category")
    .textContent.trim();
  const categorySelect = document.getElementById("editCategory");
  for (let i = 0; i < categorySelect.options.length; i++) {
    // Compare the text content of each option with the category text from the row
    if (categorySelect.options[i].textContent.trim() === categoryText) {
      categorySelect.selectedIndex = i;
      break;
    }
  }

  document.getElementById("editStock").value = productStock;

  // Handle shelf location dropdown - find and select the option with matching value
  const shelfLocationSelect = document.getElementById("editShelfLocation");
  for (let i = 0; i < shelfLocationSelect.options.length; i++) {
    if (shelfLocationSelect.options[i].value === productLocation.trim()) {
      shelfLocationSelect.selectedIndex = i;
      break;
    }
  }

  document.getElementById("editPrice").value = productPrice;

  // Set product image in the placeholder
  const imagePlaceholder = document.querySelector(".edit-image-placeholder");
  imagePlaceholder.innerHTML = `<img src="${productImageSrc}" alt="${productName}" class="img-fluid product-preview" style="max-height: 180px; max-width: 100%;">`;
  imagePlaceholder.classList.add("has-image");

  // Show the modal
  const editModal = new bootstrap.Modal(
    document.getElementById("editProductModal")
  );
  editModal.show();
}

/**
 * Opens the delete confirmation modal
 * @param {string} productName - Name of the product to delete
 * @param {string} productId - ID of the product to delete
 */
function openDeleteModal(productName, productId) {
  // Set product details in the modal
  document.getElementById("deleteProductName").textContent = productName;
  document.getElementById("deleteProductId").value = productId;

  // Show the modal
  const deleteModal = new bootstrap.Modal(
    document.getElementById("deleteProductModal")
  );
  deleteModal.show();
}

/**
 * Saves the changes made to a product in the edit modal
 */
function saveProductChanges() {
  const saveButton = document.getElementById("saveProductChanges");
  setButtonLoading(saveButton, true);

  const form = document.getElementById("editProductForm");
  const formData = new FormData(form);

  // Debugging output
  for (let [key, value] of formData.entries()) {
    console.log(key + ": " + value);
  }

  fetch("update_product.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.text())
    .then((result) => {
      if (result.trim() === "success") {
        showNotification(
          `<strong>Success!</strong> Product updated.`,
          "success",
          3000
        );
        const editModal = bootstrap.Modal.getInstance(
          document.getElementById("editProductModal")
        );
        editModal.hide();
        // Force full page reload to get fresh data from server
        window.location.reload(true);
      } else {
        showNotification(
          `<strong>Error:</strong> Failed to update product.`,
          "danger",
          3000
        );
        console.error("Update error:", result); // Log the error
      }
      setButtonLoading(saveButton, false);
    })
    .catch((error) => {
      console.error("Error updating product:", error);
      showNotification(`<strong>Error:</strong> ${error}`, "danger", 3000);
      setButtonLoading(saveButton, false);
    });
}

/**
 * Helper function to show notifications
 * @param {string} message - Message to display
 * @param {string} type - Bootstrap alert type (success, danger, warning, info)
 * @param {number} duration - Duration in milliseconds before auto-dismissing
 */
function showNotification(message, type = "success", duration = 3000) {
  const messageContainer = document.createElement("div");
  messageContainer.className = `alert alert-${type} alert-dismissible fade show`;
  messageContainer.innerHTML = `
		${message}
		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
	`;

  const notificationsContainer = document.getElementById(
    "notifications-container"
  );
  if (notificationsContainer) {
    notificationsContainer.appendChild(messageContainer);

    // Auto-dismiss the message after specified duration
    if (duration > 0) {
      setTimeout(() => {
        messageContainer.style.transition = "opacity 0.5s ease";
        messageContainer.style.opacity = "0";
        setTimeout(() => messageContainer.remove(), 500);
      }, duration);
    }
  }

  return messageContainer;
}

/**
 * Show loading state for a button
 * @param {HTMLElement} button - Button element
 * @param {boolean} loading - Whether to show loading state
 * @param {string} originalContent - Original button content
 */
function setButtonLoading(button, loading, originalContent = null) {
  if (loading) {
    // Store original content if not provided
    const content = originalContent || button.innerHTML;
    button.setAttribute("data-original-content", content);
    button.innerHTML =
      '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...';
    button.disabled = true;
  } else {
    // Restore original content
    const content =
      originalContent || button.getAttribute("data-original-content");
    button.innerHTML = content;
    button.disabled = false;
  }
}

/**
 * Initialize chat message action buttons (edit and delete)
 */
function initializeChatMessageActions() {
  // Edit message button functionality
  const editButtons = document.querySelectorAll("button[data-message-id]");
  if (editButtons.length > 0) {
    editButtons.forEach((button) => {
      // Only add click handler to edit buttons
      if (button.classList.contains("edit-btn")) {
        button.addEventListener("click", function (e) {
          e.preventDefault();
          const messageId = this.getAttribute("data-message-id");
          const messageRow = this.closest("tr");

          // Get message details from the row
          openEditMessageModal(messageRow, messageId);
        });
      }
    });
  }

  // Delete message button functionality
  const deleteButtons = document.querySelectorAll(
    "button.delete-btn[data-message-id]"
  );
  if (deleteButtons.length > 0) {
    deleteButtons.forEach((button) => {
      button.addEventListener("click", function (e) {
        e.preventDefault();
        const messageId = this.getAttribute("data-message-id");
        const messageRow = this.closest("tr");
        const sender = messageRow.querySelector(".message-sender").textContent;

        // Open delete confirmation modal
        openDeleteMessageModal(sender, messageId);
      });
    });
  }

  // Note: The delete confirmation button handler is now managed by initializeTypeDeleteConfirmation()
}

/**
 * Opens the edit message modal and populates it with the message data
 * @param {HTMLElement} messageRow - The table row element containing the message data
 * @param {string} messageId - The message ID
 */
function openEditMessageModal(messageRow, messageId) {
  // Get message details from the row
  const timestamp = messageRow.querySelector("td:first-child").textContent;
  const sender = messageRow.querySelector(".message-sender").textContent;
  const messageText = messageRow.querySelector(".message-text").textContent;

  // Set values in the modal
  document.getElementById("editMessageId").value = messageId;
  document.getElementById("editTimestamp").value = timestamp;
  document.getElementById("editMessageText").value = messageText;

  // Set the sender dropdown
  const senderSelect = document.getElementById("editSender");
  for (let i = 0; i < senderSelect.options.length; i++) {
    if (senderSelect.options[i].value === sender) {
      senderSelect.selectedIndex = i;
      break;
    }
  }

  // Show the modal
  const editModal = new bootstrap.Modal(
    document.getElementById("editMessageModal")
  );
  editModal.show();
}

/**
 * Opens the delete message confirmation modal
 * @param {string} sender - The sender of the message
 * @param {string} messageId - ID of the message
 */
function openDeleteMessageModal(sender, messageId) {
  // Set message details in the modal
  document.getElementById("deleteMessageSender").textContent = sender;
  document.getElementById("deleteMessageId").value = messageId;

  // Show the modal
  const deleteModal = new bootstrap.Modal(
    document.getElementById("deleteMessageModal")
  );
  deleteModal.show();
}

/**
 * Saves the changes made to a message in the edit modal
 */
function saveMessageChanges() {
  // Get form values
  const messageId = document.getElementById("editMessageId").value;
  const sender = document.getElementById("editSender").value;
  const messageText = document.getElementById("editMessageText").value;

  // Validate form
  if (!messageText) {
    document.getElementById("editMessageText").classList.add("is-invalid");
    showNotification(
      "<strong>Error!</strong> Message text is required.",
      "danger",
      3000
    );
    return;
  } else {
    document.getElementById("editMessageText").classList.remove("is-invalid");
  }

  // Show loading state
  const saveButton = document.getElementById("saveMessageChanges");
  setButtonLoading(saveButton, true);

  // Here you would typically make an AJAX call to update the message
  // For demonstration, we'll just simulate a delay and update the row
  setTimeout(() => {
    // Find the message row
    const editButton = document.querySelector(
      `button.edit-btn[data-message-id="${messageId}"]`
    );
    const messageRow = editButton ? editButton.closest("tr") : null;

    if (!messageRow) {
      showNotification(
        "<strong>Error!</strong> Could not find message row to update.",
        "danger",
        3000
      );
      setButtonLoading(saveButton, false);
      return;
    }

    // Update the row with new values
    messageRow.querySelector(".message-sender").textContent = sender;
    messageRow.querySelector(".message-text").textContent = messageText;

    // Hide modal with a slight delay for better UX
    setTimeout(() => {
      const editModal = bootstrap.Modal.getInstance(
        document.getElementById("editMessageModal")
      );
      editModal.hide();

      // Reset loading state
      setButtonLoading(saveButton, false);

      // Show success message
      showNotification(
        `<strong>Success!</strong> Message has been updated.`,
        "success",
        3000
      );

      // Highlight the updated row
      messageRow.style.transition = "background-color 0.5s ease";
      messageRow.style.backgroundColor = "rgba(40, 167, 69, 0.1)";
      setTimeout(() => {
        messageRow.style.backgroundColor = "";
      }, 2000);
    }, 300);
  }, 800);
}

/**
 * Initialize delete confirmation buttons for all types (product, delivery, message)
 */
function initializeDeleteConfirmations() {
  initializeTypeDeleteConfirmation("Product", "product");
  initializeTypeDeleteConfirmation("Message", "message");
}

/**
 * Initialize delete confirmation for a specific type
 * @param {string} type - The type of item (product, message)
 * @param {string} displayName - The display name for notifications
 */
function initializeTypeDeleteConfirmation(type, displayName) {
  const confirmDeleteBtn = document.getElementById(`confirmDelete${type}`);
  if (confirmDeleteBtn) {
    confirmDeleteBtn.addEventListener("click", function () {
      const itemId = document.getElementById(`delete${type}Id`).value;
      let itemName = "";

      // Get appropriate name/identifier based on type
      if (type === "Product") {
        itemName = document.getElementById("deleteProductName").textContent;
      }

      // Show loading state
      setButtonLoading(this, true);

      // Send AJAX request to delete the product
      fetch("delete_product.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: `productId=${itemId}`,
      })
        .then((response) => response.text())
        .then((result) => {
          if (result.trim() === "success") {
            // Remove the row from the table
            const allDeleteButtons =
              document.querySelectorAll("button.delete-btn");
            let targetButton = null;

            for (const btn of allDeleteButtons) {
              if (btn.getAttribute(`data-${displayName}-id`) === itemId) {
                targetButton = btn;
                break;
              }
            }

            let itemRow = null;
            if (targetButton) {
              itemRow = targetButton.closest("tr");
            }

            if (itemRow) {
              itemRow.remove();
            }

            // Close the delete modal
            const deleteModal = bootstrap.Modal.getInstance(
              document.getElementById(`delete${type}Modal`)
            );
            deleteModal.hide();

            // Show success message
            showNotification(
              `<strong>Success!</strong> ${displayName} "${itemName}" has been deleted.`,
              "success",
              3000
            );
          } else {
            showNotification(
              `<strong>Error:</strong> Failed to delete ${displayName}.`,
              "danger",
              3000
            );
          }
          setButtonLoading(confirmDeleteBtn, false);
        })
        .catch((error) => {
          console.error("Error deleting item:", error);
          showNotification(`<strong>Error:</strong> ${error}`, "danger", 3000);
          setButtonLoading(confirmDeleteBtn, false);
        });
    });
  }
}

/**
 * Initialize the notifications container
 */
function initializeNotifications() {
  // Check if notifications container exists, create it if not
  let notificationsContainer = document.getElementById(
    "notifications-container"
  );

  if (!notificationsContainer) {
    notificationsContainer = document.createElement("div");
    notificationsContainer.id = "notifications-container";
    notificationsContainer.className = "mb-3";

    // Insert it after the page title section
    const mainContent = document.querySelector(".admin-main .container-fluid");
    if (mainContent) {
      const pageHeader = mainContent.querySelector(
        ".d-flex.justify-content-between"
      );
      if (pageHeader) {
        mainContent.insertBefore(
          notificationsContainer,
          pageHeader.nextSibling
        );
      } else {
        mainContent.prepend(notificationsContainer);
      }
    }
  }

  // Clear any existing notifications
  notificationsContainer.innerHTML = "";
}

/**
 * Initialize admin header search and filter functionality
 */
function initializeAdminHeader() {
  // Get all search inputs with the data-search-target attribute
  const searchInputs = document.querySelectorAll(
    ".search-box input[data-search-target]"
  );

  // Add input event listener to each search input
  searchInputs.forEach((input) => {
    input.addEventListener("input", function () {
      const searchValue = this.value.toLowerCase().trim();
      const targetType = this.getAttribute("data-search-target");

      // Get the table rows to filter based on the target type
      let tableRows;

      if (targetType === "products") {
        tableRows = document.querySelectorAll(".product-table tbody tr");
      } else if (targetType === "chat-messages") {
        tableRows = document.querySelectorAll(".chat-table tbody tr");
      } else {
        tableRows = document.querySelectorAll(".admin-table tbody tr");
      }

      // Filter the table rows
      filterTableRows(tableRows, searchValue, targetType);
    });
  });

  // Get all filter buttons with the data-filter-target attribute
  const filterButtons = document.querySelectorAll(
    ".btn-filter[data-filter-target]"
  );

  // Add click event listener to each filter button
  filterButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const targetType = this.getAttribute("data-filter-target");

      // Show filter modal based on target type
      showFilterModal(targetType);
    });
  });
}

/**
 * Filters table rows based on search value
 * @param {NodeList} rows - The table rows to filter
 * @param {string} searchValue - The search value
 * @param {string} targetType - The type of table being filtered
 */
function filterTableRows(rows, searchValue, targetType) {
  let matchCount = 0;

  if (searchValue === "") {
    // If search is empty, show all rows
    rows.forEach((row) => {
      row.style.display = "";
      matchCount++;
    });
    return matchCount;
  }

  // Convert search to lowercase for case-insensitive search
  const searchLower = searchValue.toLowerCase();

  rows.forEach((row) => {
    let match = false;

    if (targetType === "products") {
      const productName =
        row.querySelector(".product-name")?.textContent.toLowerCase() || "";
      const productSKU =
        row.querySelector(".product-sku")?.textContent.toLowerCase() || "";
      const stockLevel =
        row.querySelector(".stock-badge")?.textContent.toLowerCase() || "";

      match =
        productName.includes(searchLower) ||
        productSKU.includes(searchLower) ||
        stockLevel.includes(searchLower);
    } else if (targetType === "chat-messages") {
      const sender =
        row.querySelector("td:first-child")?.textContent.toLowerCase() || "";
      const message =
        row.querySelector(".message-text")?.textContent.toLowerCase() || "";

      match = sender.includes(searchLower) || message.includes(searchLower);
    }

    if (match) {
      row.style.display = "";
      matchCount++;
    } else {
      row.style.display = "none";
    }
  });
}

/**
 * Shows a filter modal for specific page type
 * @param {string} targetType - The type of page to show filter for
 */
function showFilterModal(targetType) {
  // This function would be expanded with specific filter options for each page type
  console.log(`Filter modal for ${targetType} would be shown here`);

  // For now, just show a notification
  showNotification(
    `<strong>Notice:</strong> Filter functionality for ${targetType} is coming soon.`,
    "info",
    3000
  );
}
