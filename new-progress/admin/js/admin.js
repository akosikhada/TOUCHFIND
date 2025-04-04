/**
 * TOUCHFIND Admin JavaScript
 */

// Initialize charts when DOM is loaded
document.addEventListener("DOMContentLoaded", function () {
	// Initialize sales performance chart if it exists on the page
	const salesChartElement = document.getElementById("salesChart");
	if (salesChartElement) {
		initializeSalesChart(salesChartElement);
	}

	// Initialize product image preview
	const productImageInput = document.getElementById("productImage");
	if (productImageInput) {
		initializeProductImagePreview(productImageInput);
	}

	// Add active class to the current month button by default
	const periodButtons = document.querySelectorAll(
		".btn-group .btn-outline-secondary"
	);
	if (periodButtons.length > 0) {
		// Remove active class from all buttons
		periodButtons.forEach((btn) => btn.classList.remove("active"));
		// Find and set the Month button as active
		periodButtons.forEach((btn) => {
			if (btn.textContent.trim() === "Month") {
				btn.classList.add("active");
			}
		});
	}

	// Initialize product action buttons
	initializeProductActions();

	// Initialize delivery action buttons
	initializeDeliveryActions();

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

	// Initialize save delivery changes button
	const saveDeliveryChangesBtn = document.getElementById("saveDeliveryChanges");
	if (saveDeliveryChangesBtn) {
		saveDeliveryChangesBtn.addEventListener("click", saveDeliveryChanges);
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
 * Initialize the sales performance chart
 * @param {HTMLElement} chartElement - The canvas element for the chart
 */
function initializeSalesChart(chartElement) {
	const ctx = chartElement.getContext("2d");

	const chart = new Chart(ctx, {
		type: "line",
		data: {
			labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul"],
			datasets: [
				{
					label: "Sales",
					data: [4000, 3000, 5000, 2800, 1800, 2500, 3500],
					borderColor: "#c32424",
					backgroundColor: "rgba(195, 36, 36, 0.1)",
					borderWidth: 2,
					tension: 0.4,
					fill: true,
					pointBackgroundColor: "#c32424",
					pointRadius: 4,
					pointHoverRadius: 6,
				},
			],
		},
		options: {
			responsive: true,
			maintainAspectRatio: false,
			plugins: {
				legend: {
					display: false,
				},
				tooltip: {
					mode: "index",
					intersect: false,
					backgroundColor: "rgba(0, 0, 0, 0.7)",
					titleColor: "#fff",
					bodyColor: "#fff",
					borderColor: "rgba(255, 255, 255, 0.2)",
					borderWidth: 1,
				},
			},
			scales: {
				x: {
					grid: {
						display: true,
						color: "rgba(0, 0, 0, 0.05)",
					},
				},
				y: {
					beginAtZero: true,
					grid: {
						color: "rgba(0, 0, 0, 0.05)",
					},
					ticks: {
						callback: function (value) {
							if (value >= 1000) {
								return value / 1000 + "k";
							}
							return value;
						},
					},
				},
			},
		},
	});

	// Add period selection functionality
	const periodButtons = document.querySelectorAll(
		".btn-group .btn-outline-secondary"
	);
	if (periodButtons.length > 0) {
		periodButtons.forEach((button) => {
			button.addEventListener("click", function () {
				// Remove active class from all buttons
				periodButtons.forEach((btn) => btn.classList.remove("active"));
				// Add active class to clicked button
				this.classList.add("active");

				// Here you would typically update the chart data based on the period
				// For demonstration, we're just showing different data for each period
				let newData;
				if (this.textContent.trim() === "Today") {
					newData = [500, 600, 700, 800, 750, 900, 1000];
				} else if (this.textContent.trim() === "Week") {
					newData = [2000, 1800, 2200, 2400, 2100, 1900, 2300];
				} else if (this.textContent.trim() === "Month") {
					newData = [4000, 3000, 5000, 2800, 1800, 2500, 3500];
				} else if (this.textContent.trim() === "Year") {
					newData = [30000, 35000, 40000, 45000, 42000, 47000, 52000];
				}

				chart.data.datasets[0].data = newData;
				chart.update();
			});
		});
	}
}

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
	const productLocation =
		productRow.querySelector("td:nth-child(4)").textContent;
	const productPrice = productRow
		.querySelector("td:nth-child(5)")
		.textContent.replace("$", "");
	const productImageSrc = productRow.querySelector(".product-image img").src;

	// Set values in the modal
	document.getElementById("editProductId").value = productId;
	document.getElementById("editProductName").value = productName;
	document.getElementById("editSku").value = productSku;
	document.getElementById("editStock").value = productStock;
	document.getElementById("editShelfLocation").value = productLocation;
	document.getElementById("editPrice").value = productPrice;

	// Set product image in the placeholder
	const imagePlaceholder = document.querySelector(".edit-image-placeholder");
	imagePlaceholder.innerHTML = `<img src="${productImageSrc}" alt="${productName}" class="img-fluid product-preview">`;
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
	// Get form values
	const productId = document.getElementById("editProductId").value;
	const productName = document.getElementById("editProductName").value;
	const productStock = document.getElementById("editStock").value;
	const shelfLocation = document.getElementById("editShelfLocation").value;
	const price = document.getElementById("editPrice").value;

	// Validate form
	if (!productName) {
		document.getElementById("editProductName").classList.add("is-invalid");
		showNotification(
			"<strong>Error!</strong> Product name is required.",
			"danger",
			3000
		);
		return;
	} else {
		document.getElementById("editProductName").classList.remove("is-invalid");
	}

	if (!productStock) {
		document.getElementById("editStock").classList.add("is-invalid");
		showNotification(
			"<strong>Error!</strong> Stock quantity is required.",
			"danger",
			3000
		);
		return;
	} else {
		document.getElementById("editStock").classList.remove("is-invalid");
	}

	if (!shelfLocation) {
		document.getElementById("editShelfLocation").classList.add("is-invalid");
		showNotification(
			"<strong>Error!</strong> Shelf location is required.",
			"danger",
			3000
		);
		return;
	} else {
		document.getElementById("editShelfLocation").classList.remove("is-invalid");
	}

	if (!price) {
		document.getElementById("editPrice").classList.add("is-invalid");
		showNotification(
			"<strong>Error!</strong> Price is required.",
			"danger",
			3000
		);
		return;
	} else {
		document.getElementById("editPrice").classList.remove("is-invalid");
	}

	// Show loading state
	const saveButton = document.getElementById("saveProductChanges");
	setButtonLoading(saveButton, true);

	// Here you would typically make an AJAX call to update the product
	// For demonstration, we'll just simulate a delay and update the row
	setTimeout(() => {
		// Find the product row
		const editButton = document.querySelector(
			`button.edit-btn[data-product-id="${productId}"]`
		);
		const productRow = editButton ? editButton.closest("tr") : null;

		if (!productRow) {
			showNotification(
				"<strong>Error!</strong> Could not find product row to update.",
				"danger",
				3000
			);
			setButtonLoading(saveButton, false);
			return;
		}

		// Update the row with new values
		productRow.querySelector(".product-name").textContent = productName;

		// Update stock with appropriate class
		const stockBadge = productRow.querySelector(".stock-badge");
		stockBadge.textContent = productStock;

		// Remove existing classes and add new one based on stock level
		stockBadge.classList.remove("high", "medium", "low", "critical");
		if (productStock > 30) {
			stockBadge.classList.add("high");
		} else if (productStock > 20) {
			stockBadge.classList.add("medium");
		} else if (productStock > 10) {
			stockBadge.classList.add("low");
		} else {
			stockBadge.classList.add("critical");
		}

		// Update other fields
		productRow.querySelector("td:nth-child(4)").textContent = shelfLocation;
		productRow.querySelector("td:nth-child(5)").textContent =
			"$" + parseFloat(price).toFixed(2);

		// If a new image was selected, update the image
		const fileInput = document.getElementById("editProductImage");
		if (fileInput.files && fileInput.files[0]) {
			const reader = new FileReader();
			reader.onload = function (e) {
				productRow.querySelector(".product-image img").src = e.target.result;
			};
			reader.readAsDataURL(fileInput.files[0]);
		}

		// Hide modal with a slight delay for better UX
		setTimeout(() => {
			const editModal = bootstrap.Modal.getInstance(
				document.getElementById("editProductModal")
			);
			editModal.hide();

			// Reset loading state
			setButtonLoading(saveButton, false);

			// Show success message
			showNotification(
				`<strong>Success!</strong> Product "${productName}" has been updated.`,
				"success",
				3000
			);

			// Highlight the updated row
			productRow.style.transition = "background-color 0.5s ease";
			productRow.style.backgroundColor = "rgba(40, 167, 69, 0.1)";
			setTimeout(() => {
				productRow.style.backgroundColor = "";
			}, 2000);
		}, 300);
	}, 800);
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
 * Initialize delivery action buttons (edit and delete)
 */
function initializeDeliveryActions() {
	// Edit delivery button functionality
	const editButtons = document.querySelectorAll("button[data-delivery-id]");
	if (editButtons.length > 0) {
		editButtons.forEach((button) => {
			// Only add click handler to edit buttons
			if (button.classList.contains("edit-btn")) {
				button.addEventListener("click", function (e) {
					e.preventDefault();
					const deliveryId = this.getAttribute("data-delivery-id");
					const deliveryRow = this.closest("tr");

					// Get delivery details from the row
					openEditDeliveryModal(deliveryRow, deliveryId);
				});
			}
		});
	}

	// Delete delivery button functionality
	const deleteButtons = document.querySelectorAll(
		"button.delete-btn[data-delivery-id]"
	);
	if (deleteButtons.length > 0) {
		deleteButtons.forEach((button) => {
			button.addEventListener("click", function (e) {
				e.preventDefault();
				const deliveryId = this.getAttribute("data-delivery-id");
				const deliveryRow = this.closest("tr");
				const orderId = deliveryRow.querySelector("td:first-child").textContent;
				const customerName =
					deliveryRow.querySelector("td:nth-child(2)").textContent;

				// Open delete confirmation modal
				openDeleteDeliveryModal(orderId, customerName, deliveryId);
			});
		});
	}

	// Note: The delete confirmation button handler is now managed by initializeTypeDeleteConfirmation()
}

/**
 * Opens the edit delivery modal and populates it with the delivery data
 * @param {HTMLElement} deliveryRow - The table row element containing the delivery data
 * @param {string} deliveryId - The delivery ID
 */
function openEditDeliveryModal(deliveryRow, deliveryId) {
	// Get delivery details from the row
	const orderId = deliveryRow.querySelector("td:first-child").textContent;
	const customerName = deliveryRow.querySelector("td:nth-child(2)").textContent;
	const deliveryAddress =
		deliveryRow.querySelector("td:nth-child(3)").textContent;
	const deliveryStatus = deliveryRow.querySelector(
		"td:nth-child(4) .status-badge"
	).textContent;
	const estimatedDelivery =
		deliveryRow.querySelector("td:nth-child(5)").textContent;

	// Set values in the modal
	document.getElementById("editDeliveryId").value = deliveryId;
	document.getElementById("editOrderId").value = orderId;
	document.getElementById("editCustomerName").value = customerName;
	document.getElementById("editDeliveryAddress").value = deliveryAddress;

	// Set the status dropdown
	const statusSelect = document.getElementById("editDeliveryStatus");
	for (let i = 0; i < statusSelect.options.length; i++) {
		if (statusSelect.options[i].value === deliveryStatus) {
			statusSelect.selectedIndex = i;
			break;
		}
	}

	// Convert date format to yyyy-mm-dd for the date input
	const dateParts = estimatedDelivery.split(", ")[0].split(" ");
	const month = new Date(Date.parse(dateParts[0] + " 1, 2000")).getMonth() + 1;
	const dateStr = `2024-${month
		.toString()
		.padStart(2, "0")}-${dateParts[1].padStart(2, "0")}`;
	document.getElementById("editEstimatedDelivery").value = dateStr;

	// Show the modal
	const editModal = new bootstrap.Modal(
		document.getElementById("editDeliveryModal")
	);
	editModal.show();
}

/**
 * Opens the delete delivery confirmation modal
 * @param {string} orderId - Order ID to delete
 * @param {string} customerName - Customer name
 * @param {string} deliveryId - ID of the delivery
 */
function openDeleteDeliveryModal(orderId, customerName, deliveryId) {
	// Set delivery details in the modal
	document.getElementById("deleteDeliveryOrder").textContent = orderId;
	document.getElementById("deleteDeliveryCustomer").textContent = customerName;
	document.getElementById("deleteDeliveryId").value = deliveryId;

	// Show the modal
	const deleteModal = new bootstrap.Modal(
		document.getElementById("deleteDeliveryModal")
	);
	deleteModal.show();
}

/**
 * Saves the changes made to a delivery in the edit modal
 */
function saveDeliveryChanges() {
	// Get form values
	const deliveryId = document.getElementById("editDeliveryId").value;
	const orderId = document.getElementById("editOrderId").value;
	const customerName = document.getElementById("editCustomerName").value;
	const deliveryAddress = document.getElementById("editDeliveryAddress").value;
	const deliveryStatus = document.getElementById("editDeliveryStatus").value;
	const estimatedDelivery = document.getElementById(
		"editEstimatedDelivery"
	).value;

	// Validate form
	if (!customerName) {
		document.getElementById("editCustomerName").classList.add("is-invalid");
		showNotification(
			"<strong>Error!</strong> Customer name is required.",
			"danger",
			3000
		);
		return;
	} else {
		document.getElementById("editCustomerName").classList.remove("is-invalid");
	}

	if (!deliveryAddress) {
		document.getElementById("editDeliveryAddress").classList.add("is-invalid");
		showNotification(
			"<strong>Error!</strong> Delivery address is required.",
			"danger",
			3000
		);
		return;
	} else {
		document
			.getElementById("editDeliveryAddress")
			.classList.remove("is-invalid");
	}

	if (!estimatedDelivery) {
		document
			.getElementById("editEstimatedDelivery")
			.classList.add("is-invalid");
		showNotification(
			"<strong>Error!</strong> Estimated delivery date is required.",
			"danger",
			3000
		);
		return;
	} else {
		document
			.getElementById("editEstimatedDelivery")
			.classList.remove("is-invalid");
	}

	// Show loading state
	const saveButton = document.getElementById("saveDeliveryChanges");
	setButtonLoading(saveButton, true);

	// Here you would typically make an AJAX call to update the delivery
	// For demonstration, we'll just simulate a delay and update the row
	setTimeout(() => {
		// Find the delivery row
		const editButton = document.querySelector(
			`button.edit-btn[data-delivery-id="${deliveryId}"]`
		);
		const deliveryRow = editButton ? editButton.closest("tr") : null;

		if (!deliveryRow) {
			showNotification(
				"<strong>Error!</strong> Could not find delivery row to update.",
				"danger",
				3000
			);
			setButtonLoading(saveButton, false);
			return;
		}

		// Update the row with new values
		deliveryRow.querySelector("td:nth-child(2)").textContent = customerName;
		deliveryRow.querySelector("td:nth-child(3)").textContent = deliveryAddress;

		// Format date for display (Jan 25, 2024 format)
		const date = new Date(estimatedDelivery);
		const monthNames = [
			"Jan",
			"Feb",
			"Mar",
			"Apr",
			"May",
			"Jun",
			"Jul",
			"Aug",
			"Sep",
			"Oct",
			"Nov",
			"Dec",
		];
		const formattedDate = `${
			monthNames[date.getMonth()]
		} ${date.getDate()}, ${date.getFullYear()}`;
		deliveryRow.querySelector("td:nth-child(5)").textContent = formattedDate;

		// Update status badge
		const statusBadge = deliveryRow.querySelector(
			"td:nth-child(4) .status-badge"
		);
		statusBadge.textContent = deliveryStatus;

		// Update status badge class
		statusBadge.className = "status-badge";
		if (deliveryStatus === "In Transit") {
			statusBadge.classList.add("in-transit");
		} else if (deliveryStatus === "Delivered") {
			statusBadge.classList.add("delivered");
		} else if (deliveryStatus === "Pending") {
			statusBadge.classList.add("pending");
		}

		// Hide modal with a slight delay for better UX
		setTimeout(() => {
			const editModal = bootstrap.Modal.getInstance(
				document.getElementById("editDeliveryModal")
			);
			editModal.hide();

			// Reset loading state
			setButtonLoading(saveButton, false);

			// Show success message
			showNotification(
				`<strong>Success!</strong> Delivery Order ${orderId} has been updated.`,
				"success",
				3000
			);

			// Highlight the updated row
			deliveryRow.style.transition = "background-color 0.5s ease";
			deliveryRow.style.backgroundColor = "rgba(40, 167, 69, 0.1)";
			setTimeout(() => {
				deliveryRow.style.backgroundColor = "";
			}, 2000);
		}, 300);
	}, 800);
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
	// Product delete confirmation
	initializeTypeDeleteConfirmation("product", "Product");

	// Delivery delete confirmation
	initializeTypeDeleteConfirmation("delivery", "Delivery Order");

	// Message delete confirmation
	initializeTypeDeleteConfirmation("message", "Message");
}

/**
 * Initialize delete confirmation for a specific type
 * @param {string} type - The type of item (product, delivery, message)
 * @param {string} displayName - The display name for notifications
 */
function initializeTypeDeleteConfirmation(type, displayName) {
	const confirmDeleteBtn = document.getElementById(
		`confirmDelete${type.charAt(0).toUpperCase() + type.slice(1)}`
	);
	if (confirmDeleteBtn) {
		confirmDeleteBtn.addEventListener("click", function () {
			const itemId = document.getElementById(
				`delete${type.charAt(0).toUpperCase() + type.slice(1)}Id`
			).value;
			let itemName = "";

			// Get appropriate name/identifier based on type
			if (type === "product") {
				itemName = document.getElementById("deleteProductName").textContent;
			} else if (type === "delivery") {
				itemName = document.getElementById("deleteDeliveryOrder").textContent;
			} else if (type === "message") {
				itemName = document.getElementById("deleteMessageSender").textContent;
			}

			// Show loading state
			setButtonLoading(this, true);

			// DIRECT APPROACH: Find all rows with delete buttons and match the ID
			const allDeleteButtons = document.querySelectorAll("button.delete-btn");
			let targetButton = null;

			// Find the button with matching ID attribute
			for (const btn of allDeleteButtons) {
				if (btn.getAttribute(`data-${type}-id`) === itemId) {
					targetButton = btn;
					break;
				}
			}

			// If button found, get its row
			let itemRow = null;
			if (targetButton) {
				itemRow = targetButton.closest("tr");
			}

			if (!itemRow) {
				console.error(`Could not find row with ${type}-id=${itemId}`);
				showNotification(
					`<strong>Error!</strong> Could not find item to delete.`,
					"danger",
					3000
				);
				setButtonLoading(confirmDeleteBtn, false);
				return;
			}

			// Hide the modal immediately
			const deleteModal = bootstrap.Modal.getInstance(
				document.getElementById(
					`delete${type.charAt(0).toUpperCase() + type.slice(1)}Modal`
				)
			);
			deleteModal.hide();

			// Immediately remove the row
			itemRow.remove();

			// Reset loading state
			setButtonLoading(confirmDeleteBtn, false);

			// Show success message
			let successMessage = "";
			if (type === "product") {
				successMessage = `<strong>Success!</strong> Product "${itemName}" has been deleted.`;
			} else if (type === "delivery") {
				successMessage = `<strong>Success!</strong> Delivery Order ${itemName} has been deleted.`;
			} else if (type === "message") {
				successMessage = `<strong>Success!</strong> Message from ${itemName} has been deleted.`;
			}

			showNotification(successMessage, "success", 3000);
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

			if (targetType === "list-of-product") {
				tableRows = document.querySelectorAll(".product-table tbody tr");
			} else if (targetType === "delivery-updates") {
				tableRows = document.querySelectorAll(
					".admin-table:not(.product-table):not(.chat-table) tbody tr"
				);
			} else if (targetType === "chat-responses") {
				tableRows = document.querySelectorAll(".chat-table tbody tr");
			} else if (targetType === "sales-overview") {
				tableRows = document.querySelectorAll(".sales-table tbody tr");
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
			// This would need to be implemented for each specific page
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
	if (!searchValue) {
		// If search value is empty, show all rows
		rows.forEach((row) => (row.style.display = ""));
		return;
	}

	// Filter rows based on target type
	rows.forEach((row) => {
		let text = "";

		if (targetType === "list-of-product") {
			// For product list, search in product name and SKU
			const productName = row.querySelector(".product-name")?.textContent || "";
			const productSku = row.querySelector(".product-sku")?.textContent || "";
			text = productName + " " + productSku;
		} else if (targetType === "delivery-updates") {
			// For delivery updates, search in order ID, customer name, and address
			const orderId = row.cells[0]?.textContent || "";
			const customer = row.cells[1]?.textContent || "";
			const address = row.cells[2]?.textContent || "";
			text = orderId + " " + customer + " " + address;
		} else if (targetType === "chat-responses") {
			// For chat responses, search in timestamp, sender, and message
			const timestamp = row.cells[0]?.textContent || "";
			const sender = row.querySelector(".message-sender")?.textContent || "";
			const message = row.querySelector(".message-text")?.textContent || "";
			text = timestamp + " " + sender + " " + message;
		} else if (targetType === "sales-overview") {
			// For sales overview, search in order ID, customer, and product
			const cells = row.cells;
			for (let i = 0; i < cells.length; i++) {
				text += cells[i].textContent + " ";
			}
		} else {
			// For any other table, search in all cells
			const cells = row.cells;
			for (let i = 0; i < cells.length; i++) {
				text += cells[i].textContent + " ";
			}
		}

		// Show or hide row based on search
		if (text.toLowerCase().includes(searchValue)) {
			row.style.display = "";
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
