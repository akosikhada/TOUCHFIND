<?php
require_once 'components/db_connection.php';
session_start();

function truncateDescription($description, $wordLimit) {
    $words = explode(' ', $description);
    if (count($words) > $wordLimit) {
        return implode(' ', array_slice($words, 0, $wordLimit)) . '...';
    }
    return $description;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TOUCHFIND | Order List</title>
    <!-- Bootstrap CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Admin CSS -->
    <link href="css/admin.css" rel="stylesheet">
    <style>
        /* Base table styles */
        .admin-table {
            border-collapse: separate;
            border-spacing: 0;
            width: 100%;
            margin-bottom: 0;
            border: 1px solid #f0f0f0;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.03);
        }
        
        .admin-table th {
            background-color: #f8f9fa;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            color: #495057;
            padding: 16px;
            border-bottom: 2px solid #e9ecef;
            white-space: nowrap;
            vertical-align: middle;
        }
        
        .admin-table td {
            padding: 16px;
            vertical-align: middle;
            border-top: 1px solid #f2f2f2;
            color: #333;
            transition: background-color 0.2s;
        }
        
        /* Zebra striping */
        .admin-table tbody tr:nth-child(even) {
            background-color: #fcfcfc;
        }
        
        .admin-table tbody tr:hover {
            background-color: #f8f9fa;
        }
        
        /* Product image styles */
        .product-image {
            width: 60px;
            height: 60px;
            border-radius: 6px;
            overflow: hidden;
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            border: 1px solid #f0f0f0;
            margin: 0 auto;
        }
        
        .product-image img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }
        
        /* Product info styles */
        .product-name {
            font-weight: 600;
            color: #212529;
            margin-bottom: 4px;
            font-size: 0.95rem;
        }
        
        .product-sku {
            font-size: 0.8rem;
            color: #6c757d;
            font-weight: 500;
        }
        
        .product-description {
            max-width: 220px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            color: #6c757d;
            font-size: 0.9rem;
            line-height: 1.5;
        }
        
        .product-category {
            display: inline-block;
            padding: 4px 10px;
            background-color: #f8f9fa;
            border-radius: 4px;
            font-size: 0.85rem;
            color: #495057;
            border: 1px solid #e9ecef;
            font-weight: 500;
        }
        
        /* Stock badge styling */
        .stock-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 6px 10px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.85rem;
            min-width: 70px;
        }
        
        .stock-badge.high {
            background-color: #e3f7ec;
            color: #0f8a41;
        }
        
        .stock-badge.medium {
            background-color: #fff8e1;
            color: #b7791f;
        }
        
        .stock-badge.low {
            background-color: #ffefef;
            color: #c53030;
        }
        
        .stock-badge.critical {
            background-color: #fee;
            color: #e53e3e;
        }
        
        /* Price styling */
        .price-value {
            font-weight: 600;
            font-size: 0.95rem;
            color: #2d3748;
        }
        
        /* Shelf location styling */
        .shelf-location {
            display: inline-block;
            padding: 4px 10px;
            background-color: #f0f9ff;
            border-radius: 4px;
            font-size: 0.85rem;
            font-weight: 600;
            color: #3182ce;
            border: 1px solid #e2f2ff;
        }
        
        /* Action buttons styling */
        .action-buttons {
            white-space: nowrap;
        }
        
        .action-buttons-container {
            display: flex;
            gap: 8px;
            justify-content: center;
        }
        
        /* Individual button styling */
        .action-buttons .btn-primary {
            margin-right: 5px;
        }
        
        /* Make buttons a bit wider for better text display */
        .action-buttons .btn {
            min-width: 90px;
            padding-left: 15px;
            padding-right: 15px;
            font-size: 0.85rem;
            text-align: center;
            display: inline-block;
            white-space: nowrap;
            overflow: visible;
        }
        
        /* Fix for truncated "Unpaid" text */
        .btn-danger {
            min-width: 95px !important;
        }
        
        .btn-action {
            width: 36px;
            height: 36px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            transition: all 0.2s ease;
            margin: 0 3px;
            border: none;
        }
        
        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        .btn-action.edit-btn {
            background-color: #4299e1;
            color: white;
        }
        
        .btn-action.edit-btn:hover {
            background-color: #3182ce;
        }
        
        .btn-action.delete-btn {
            background-color: #f56565;
            color: white;
        }
        
        .btn-action.delete-btn:hover {
            background-color: #e53e3e;
        }
        
        /* Card container */
        .admin-table-card {
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            border: none;
            margin-bottom: 24px;
        }
        
        /* Pagination styling to match screenshots */
        .pagination-container {
            padding: 0.5rem;
            align-items: center;
            justify-content: space-between;
        }
        
        .items-per-page {
            display: flex;
            align-items: center;
        }
        
        .items-per-page span {
            color: #4a5568;
            font-size: 0.9rem;
            white-space: nowrap;
        }
        
        .items-per-page select {
            width: 80px;
            border-radius: 6px;
            border: 1px solid #e2e8f0;
            font-size: 0.9rem;
            padding: 0.25rem 0.5rem;
            margin-left: 8px;
        }
        
        .pagination {
            display: flex;
            padding-left: 0;
            list-style: none;
            margin-bottom: 0;
        }
        
        .page-item:first-child .page-link {
            border-top-left-radius: 0.25rem;
            border-bottom-left-radius: 0.25rem;
        }
        
        .page-item:last-child .page-link {
            border-top-right-radius: 0.25rem;
            border-bottom-right-radius: 0.25rem;
        }
        
        .page-item.active .page-link {
            background-color: #dc3545;
            border-color: #dc3545;
            color: white;
        }
        
        .page-link {
            position: relative;
            display: block;
            padding: 0.5rem 0.75rem;
            margin-left: -1px;
            line-height: 1.25;
            color: #333;
            background-color: #fff;
            border: 1px solid #dee2e6;
        }
        
        .page-link:hover {
            z-index: 2;
            color: #666;
            text-decoration: none;
            background-color: #e9ecef;
            border-color: #dee2e6;
        }
        
        @media (max-width: 767.98px) {
            .pagination-container {
                flex-direction: column;
                gap: 15px;
            }
            
            .items-per-page {
                width: 100%;
                justify-content: center;
            }
            
            .pagination-wrapper {
                width: 100%;
                display: flex;
                justify-content: center;
            }
        }
        
        /* Add Product Button */
        .btn-add-product {
            background-color: #38a169;
            color: white;
            font-weight: 500;
            padding: 10px 20px;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            transition: all 0.2s;
            border: none;
        }
        
        .btn-add-product:hover {
            background-color: #2f855a;
            transform: translateY(-1px);
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            color: white;
        }
        
        .btn-add-product i {
            margin-right: 8px;
        }
        
        /* Items per page selector */
        .items-per-page {
            display: flex;
            align-items: center;
        }
        
        .items-per-page span {
            color: #4a5568;
            font-weight: 500;
            white-space: nowrap;
            margin-right: 10px;
        }
        
        .items-per-page select {
            border-radius: 6px;
            padding: 6px 12px;
            border-color: #e2e8f0;
            font-weight: 500;
            min-width: 80px;
            color: #4a5568;
        }

        /* Responsive Styles */
        @media (max-width: 991.98px) {
            .admin-main {
                padding-left: 0;
            }
            
            .admin-table th,
            .admin-table td {
                padding: 12px;
            }
            
            .product-description {
                max-width: 180px;
            }
        }
        
        @media (max-width: 767.98px) {
            /* Search and filter layout for mobile */
            .d-flex.justify-content-between.align-items-center.mb-4 {
                flex-direction: column;
                align-items: flex-start !important;
                gap: 15px;
            }
            
            .d-flex.justify-content-between.align-items-center.mb-4 > div {
                width: 100%;
            }
            
            .d-flex.justify-content-between.align-items-center.mb-4 > div.d-flex.align-items-center {
                display: flex !important;
                flex-direction: row !important;
                gap: 10px;
            }
            
            .search-box {
                width: 100%;
                max-width: 100%;
                flex-grow: 1;
                margin-right: 10px;
            }
            
            .admin-page-title {
                font-size: 1.5rem;
                margin-bottom: 0;
            }
            
            .btn-filter {
                padding: 8px 16px;
                display: flex;
                align-items: center;
                justify-content: center;
                width: auto;
                white-space: nowrap;
                min-width: 90px;
            }
            
            /* Mobile card styling */
            .admin-table tbody tr {
                display: block;
                border: 1px solid #e2e8f0;
                border-radius: 12px;
                margin-bottom: 16px;
                padding: 0;
                box-shadow: 0 3px 6px rgba(0,0,0,0.05);
                background-color: white;
                overflow: hidden;
            }
            
            /* Product header section */
            .admin-table td:first-child {
                padding: 16px 16px 12px;
                margin: 0;
                border: none;
                background-color: #f8fafc;
                border-bottom: 1px solid #edf2f7;
            }
            
            /* Product image */
            .product-image {
                width: 70px;
                height: 70px;
                border-radius: 8px;
                background-color: white;
                border: 1px solid #edf2f7;
            }
            
            /* Product info styling */
            .product-info-mobile {
                text-align: left;
            }
            
            .product-info-mobile .product-name {
                font-size: 1.1rem;
                font-weight: 600;
                color: #2d3748;
            }
            
            .product-info-mobile .product-sku {
                font-size: 0.8rem;
                color: #718096;
            }
            
            /* Detail fields */
            .admin-table td[data-label="DESCRIPTION"],
            .admin-table td[data-label="CATEGORY"],
            .admin-table td[data-label="STOCK"],
            .admin-table td[data-label="LOCATION"],
            .admin-table td[data-label="PRICE"] {
                padding: 12px 16px;
                border-bottom: 1px solid #edf2f7;
                margin: 0;
            }
            
            /* Action buttons footer */
            .admin-table td.action-buttons {
                padding: 12px 16px;
                background-color: #f8fafc;
                border-top: none;
                margin: 0;
            }
            
            /* Card styling */
            .admin-table-card {
                border: none;
                background: transparent;
                box-shadow: none;
            }
            
            .admin-table-card .card-body {
                padding: 0;
            }
            
            /* Hide table headers */
            .admin-table thead {
                display: none;
            }
            
            /* Mobile data field styling */
            .admin-table td {
                width: 100%;
                display: flex;
                align-items: center;
                justify-content: space-between;
            }
            
            .admin-table td:before {
                content: attr(data-label);
                font-weight: 600;
                color: #64748b;
                text-transform: uppercase;
                font-size: 0.7rem;
                letter-spacing: 0.05em;
                margin-right: 10px;
                min-width: 90px;
                flex-shrink: 0;
            }
            
            .admin-table td:first-child:before {
                display: none;
            }
            
            /* Hide product name cell */
            .admin-table td[data-label="PRODUCT"] {
                display: none;
            }
            
            /* Description field */
            .product-description {
                text-align: right;
                max-width: none;
            }
            
            /* Category and badges */
            .product-category, .stock-badge, .shelf-location {
                margin-left: auto;
                min-width: 80px;
                text-align: center;
            }
            
            /* Pagination controls */
            .pagination-controls {
                flex-direction: column;
                gap: 16px;
            }
            
            .pagination-controls .items-per-page {
                margin-bottom: 8px;
                justify-content: center;
                width: 100%;
            }
            
            .pagination-controls .pagination {
                margin-left: auto;
                margin-right: auto;
            }
        }
        
        /* Extra small devices - phone improvements */
        @media (max-width: 575.98px) {
            .container-fluid.px-4.py-4 {
                padding-left: 10px !important;
                padding-right: 10px !important;
            }
            
            /* Adjust card padding */
            .admin-table td:first-child {
                padding: 16px 10px 10px;
            }
            
            /* Slightly larger image for better visibility */
            .product-image {
                width: 90px;
                height: 90px;
            }
            
            /* Adjust text size */
            .product-info-mobile .product-name {
                font-size: 1.05rem;
            }
            
            /* Add more space between image and details section */
            .admin-table td[data-label="DESCRIPTION"] {
                padding-top: 12px;
                margin-top: 5px;
            }
            
            /* Tighter card padding for small screens */
            .admin-table tbody tr {
                margin-bottom: 12px;
            }
            
            .admin-table td:first-child {
                padding: 12px 12px 10px;
            }
            
            .admin-table td[data-label="DESCRIPTION"],
            .admin-table td[data-label="CATEGORY"],
            .admin-table td[data-label="STOCK"],
            .admin-table td[data-label="LOCATION"],
            .admin-table td[data-label="PRICE"] {
                padding: 10px 12px;
            }
            
            .admin-table td.action-buttons {
                padding: 10px 12px;
            }
            
            /* Label and content adjustments */
            .admin-table td:before {
                width: 75px;
                min-width: 75px;
                font-size: 0.65rem;
            }
            
            /* Font size adjustments */
            .product-info-mobile .product-name {
                font-size: 1rem;
            }
            
            .product-info-mobile .product-sku {
                font-size: 0.75rem;
            }
            
            .product-description {
                font-size: 0.8rem;
                line-height: 1.4;
            }
            
            .stock-badge, .product-category, .shelf-location {
                font-size: 0.75rem;
                padding: 3px 7px;
            }
            
            .price-value {
                font-size: 0.85rem;
                font-weight: 700;
            }
            
            /* Smaller action buttons */
            .btn-action {
                width: 32px;
                height: 32px;
            }
            
            /* Stack search and filter */
            .d-flex.justify-content-between.align-items-center.mb-4 > div.d-flex.align-items-center {
                flex-direction: column !important;
                width: 100%;
                gap: 10px;
            }
            
            .search-box {
                width: 100%;
                margin-right: 0;
            }
            
            .btn-filter {
                width: 100%;
                margin-left: 0;
                justify-content: center;
            }
        }
        
        /* Description textarea styling */
        textarea#editDesc {
            width: 100% !important;
            min-height: 180px !important;
            resize: vertical;
            line-height: 1.5;
            font-size: 0.95rem;
            padding: 12px;
            border-color: #e2e8f0;
            transition: border-color 0.2s ease;
            box-sizing: border-box;
            display: block;
        }
        
        .description-container {
            width: 100%;
            margin-top: 20px;
            padding: 0;
        }
        
        .description-container label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
        }
        
        /* Edit modal styling */
        #editProductModal .modal-content {
            border: none;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        
        #editProductModal .modal-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #edf2f7;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            padding: 16px 24px;
        }
        
        #editProductModal .modal-footer {
            background-color: #f8f9fa;
            border-top: 1px solid #edf2f7;
            padding: 16px 24px;
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
        }
        
        #editProductModal .input-group-text {
            border-color: #e2e8f0;
            background-color: #f8f9fa;
            color: #4a5568;
        }
        
        #editProductModal .form-control,
        #editProductModal .form-select {
            border-color: #e2e8f0;
            box-shadow: none;
            transition: all 0.2s ease;
        }
        
        #editProductModal .form-control:focus,
        #editProductModal .form-select:focus {
            border-color: #4299e1;
            box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.15);
        }
        
        #editProductModal .form-label {
            color: #4a5568;
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
        }
        
        .description-container .card {
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            overflow: hidden;
        }
        
        .description-container .card-body {
            padding: 16px;
        }
        
        /* Product image upload styling */
        .product-image-placeholder {
            min-height: 150px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
            border-radius: 4px;
            padding: 20px;
        }
        
        .product-image-upload {
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .product-image-upload:hover {
            background-color: #f0f9ff;
        }
        
        .product-image-placeholder:hover {
            background-color: rgba(0,0,0,0.03);
            transform: scale(1.02);
        }
        
        .product-image-placeholder:after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0);
            transition: background-color 0.2s ease;
            border-radius: 4px;
            z-index: 1;
        }
        
        .product-image-placeholder.has-image:hover:after {
            background-color: rgba(0,0,0,0.1);
        }
        
        .product-image-placeholder img {
            max-width: 100%;
            max-height: 150px;
            object-fit: contain;
            border-radius: 4px;
            position: relative;
            z-index: 2;
        }
        
        .product-image-placeholder.has-image {
            background-color: transparent;
            border: none;
        }

        /* Search Box Styling */
        .search-box {
            position: relative;
            width: 250px;
            transition: all 0.3s ease;
        }

        .search-box input {
            padding-right: 40px;
            height: 42px;
            border-radius: 6px;
            border: 1px solid #e2e8f0;
            padding-left: 12px;
            font-size: 0.95rem;
            transition: all 0.2s ease;
        }

        .search-box input:focus {
            border-color: #4299e1;
            box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.15);
        }

        .search-icon {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #718096;
            pointer-events: none;
        }

        /* Filter Button Styling */
        .btn-filter {
            background-color: #f8f9fa;
            color: #4a5568;
            border: 1px solid #e2e8f0;
            padding: 10px 16px;
            height: 42px;
            margin-left: 10px;
            border-radius: 6px;
            font-weight: 500;
            display: flex;
            align-items: center;
            transition: all 0.2s ease;
        }
        
        .btn-filter:hover {
            background-color: #2D3748;
            border-color: #2D3748;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        .btn-filter i {
            margin-right: 8px;
            font-size: 1rem;
        }

        .admin-header-container {
            width: 100%;
            margin-bottom: 20px;
        }

        @media (max-width: 767.98px) {
            .admin-header-container {
                margin-bottom: 15px;
            }
        }

        /* Mobile product card styling */
        .mobile-product-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 10px 0;
            width: 100%;
        }

        @media (max-width: 767.98px) {
            /* Product card styling */
            .admin-table td:first-child {
                padding: 15px 15px 10px;
                background-color: white;
                border-bottom: none;
            }
            
            /* Image styling */
            .product-image {
                width: 80px;
                height: 80px;
                border-radius: 8px;
                margin: 0 auto;
                background-color: #f9fafc;
                border: 1px solid #edf2f7;
                box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            }
            
            /* Info styling */
            .product-info-mobile {
                width: 100%;
                text-align: center;
                padding-top: 8px;
            }
            
            .product-info-mobile .product-name {
                font-size: 1.1rem;
                font-weight: 600;
                color: #2d3748;
                margin-bottom: 4px;
            }
            
            .product-info-mobile .product-sku {
                font-size: 0.8rem;
                color: #718096;
            }
            
            /* Add a separator line */
            .admin-table td[data-label="DESCRIPTION"] {
                border-top: 1px solid #edf2f7;
            }
        }

        /* Admin header container styling */
        .admin-header-container {
            padding: 10px 0;
            background-color: #f8f9fa;
            margin-bottom: 20px;
            border-radius: 6px;
        }
        
        .admin-page-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #3a3a3a;
            margin-bottom: 0;
        }
        
        /* Desktop search and filter styling */
        .search-box {
            position: relative;
            width: 240px;
        }
        
        .search-input {
            height: 38px;
            border-radius: 6px;
            border: 1px solid #dee2e6;
            padding: 8px 35px 8px 12px;
            font-size: 0.9rem;
            width: 100%;
        }
        
        .search-input::placeholder {
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        .search-icon {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            font-size: 0.9rem;
            cursor: pointer;
        }
        
        .btn-outline-secondary.filter-button {
            height: 38px;
            padding: 6px 16px;
            background-color: white;
            border: 1px solid #dee2e6;
            color: #212529;
            font-weight: 400;
            font-size: 0.9rem;
            border-radius: 6px;
        }
        
        .btn-outline-secondary.filter-button:hover {
            background-color: #2D3748;
            border-color: #2D3748;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        .btn-outline-secondary.filter-button i {
            color: #6c757d;
            font-size: 0.8rem;
        }
        
        /* Mobile Search Layout - Match screenshot precisely */
        .search-container {
            display: none;
            background-color: #f8f9fa;
            padding: 15px;
        }
        
        @media (max-width: 767.98px) {
            .container-fluid {
                padding: 0;
                background-color: #f8f9fa;
            }
            
            .admin-header-container .d-flex.justify-content-between {
                display: none !important;
            }
            
            .search-container {
                display: block;
            }
            
            .search-box-wrapper {
                position: relative;
                border-radius: 6px;
                overflow: hidden;
            }
            
            .search-input {
                height: 44px;
                border-radius: 6px;
                border: 1px solid #dee2e6;
                padding: 8px 40px 8px 15px;
                font-size: 0.95rem;
                width: 100%;
                box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            }
            
            .search-icon {
                position: absolute;
                right: 15px;
                top: 50%;
                transform: translateY(-50%);
                color: #6c757d;
                font-size: 0.95rem;
            }
            
            .filter-button-wrapper {
                width: 100%;
            }
            
            .filter-button {
                height: 44px;
                width: 100%;
                display: flex;
                align-items: center;
                justify-content: center;
                background-color: white;
                border: 1px solid #dee2e6;
                color: #333;
                font-weight: 500;
                font-size: 0.95rem;
                border-radius: 6px;
                box-shadow: 0 1px 3px rgba(0,0,0,0.05);
                padding: 0 15px;
            }
            
            .filter-button i {
                margin-right: 8px;
                font-size: 0.9rem;
                color: #6c757d;
            }
        }

        /* Mobile-specific styles */
        @media (max-width: 767.98px) {
            /* Center the order ID */
            td[data-label="ORDER ID"] {
                text-align: center !important;
                display: block !important;
                width: 100% !important;
                font-weight: 700;
                font-size: 1.2rem;
                color: #333;
                padding: 20px 15px 15px;
                background-color: #f8f9fa;
                border-bottom: 1px solid #e9ecef;
            }
            
            /* Add a header-like appearance to Order ID on mobile */
            td[data-label="ORDER ID"]:before {
                content: "ORDER ID";
                display: block;
                font-size: 0.75rem;
                font-weight: 600;
                color: #6c757d;
                letter-spacing: 0.05em;
                margin-bottom: 8px;
                text-transform: uppercase;
            }
        }
    </style>
</head>
<body>
    <?php include 'components/edit_product.php'; ?>
    <?php include 'components/delete_product.php'; ?>
    <?php include 'components/admin_header.php'; ?>
    
    <div class="d-flex admin-dashboard">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <?php include 'components/admin_sidebar.php'; ?>
        </aside>

        <!-- Main Content Area -->
        <main class="admin-main">
            <div class="container-fluid px-4 py-4">
                <div class="admin-header-container">
                    <div class="d-flex justify-content-between align-items-center">
                        <h1 class="admin-page-title mb-0">LIST OF ORDERS</h1>
                        <div class="d-flex align-items-center">
                            <div class="search-box me-2">
                                <input type="text" class="form-control search-input" placeholder="Search orders...">
                                <i class="bi bi-search search-icon"></i>
                            </div>
                            <button class="btn btn-outline-secondary filter-button d-flex align-items-center">
                                <i class="bi bi-funnel me-1"></i> Filter
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Mobile search layout -->
                <div class="search-container d-md-none">
                    <h1 class="admin-page-title mb-3">LIST OF ORDERS</h1>
                    <div class="search-box-wrapper mb-3">
                        <input type="text" class="search-input" placeholder="Search orders...">
                        <i class="bi bi-search search-icon"></i>
                    </div>
                    <div class="filter-button-wrapper">
                        <button class="filter-button">
                            <i class="bi bi-funnel"></i> Filter Orders
                        </button>
                    </div>
                </div>
                
                <!-- Notifications container -->
                <div id="notifications-container" class="mb-3"></div>

                <!-- Product List Table -->
                <div class="admin-table-card card">
                    <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table admin-table product-table">
                            <thead>
                                <tr>
                                    <th width="15%">ORDER ID</th>
                                    <th width="15%">ORDER NUMBER</th>
                                    <th>TOTAL AMOUNT</th>
                                    <th>QUANTITY</th>
                                    <th width="18%">TIMESTAMP</th>
                                    <th>STATUS</th>
                                    <th width="15%" class="text-center">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Mock data for demonstration
                                $mockData = [
                                    'order_id' => '1001',
                                    'order_number' => 'ORD-2023-5678',
                                    'total_amount' => 1250.75,
                                    'quantity' => 3,
                                    'created_at' => date('Y-m-d H:i:s'),
                                    'status' => 'paid'
                                ];
                                
                                $sql = "SELECT * FROM orders";
                                $result = $conn->query($sql);

                                // Show mock data if no real data exists
                                if ($result && $result->num_rows > 0):
                                    while ($order = $result->fetch_assoc()):
                                        $status = $order['status'] ?? 'unpaid';
                                        $statusClass = ($status == 'paid') ? 'high' : 'critical';
                                ?>
                                <tr>
                                    <td data-label="ORDER ID"><?= $order['order_id'] ?></td>
                                    <td data-label="ORDER NUMBER"><?= htmlspecialchars($order['order_number']) ?></td>
                                    <td data-label="TOTAL AMOUNT"><span class="price-value">₱<?= number_format($order['total_amount'], 2) ?></span></td>
                                    <td data-label="QUANTITY"><?= $order['quantity'] ?></td>
                                    <td data-label="TIMESTAMP"><?= isset($order['created_at']) ? date('M d, Y h:i A', strtotime($order['created_at'])) : 'N/A' ?></td>
                                    <td data-label="STATUS"><span class="stock-badge <?= $statusClass ?>"><?= ucfirst($status) ?></span></td>
                                    <td class="action-buttons text-center" data-label="ACTIONS">
                                        <div class="action-buttons-container">
                                            <button type="button" class="btn btn-action edit-btn" 
                                                    onclick="updateOrderStatus(<?= $order['order_id'] ?>, 'paid')">
                                                Paid
                                            </button>
                                            <button type="button" class="btn btn-action delete-btn" 
                                                    onclick="updateOrderStatus(<?= $order['order_id'] ?>, 'unpaid')">
                                                Unpaid
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                                    endwhile;
                                else:
                                    // Display mock data
                                    $order = $mockData;
                                    $status = $order['status'] ?? 'unpaid';
                                    $statusClass = ($status == 'paid') ? 'high' : 'critical';
                                ?>
                                <tr>
                                    <td data-label="ORDER ID"><?= $order['order_id'] ?></td>
                                    <td data-label="ORDER NUMBER"><?= htmlspecialchars($order['order_number']) ?></td>
                                    <td data-label="TOTAL AMOUNT"><span class="price-value">₱<?= number_format($order['total_amount'], 2) ?></span></td>
                                    <td data-label="QUANTITY"><?= $order['quantity'] ?></td>
                                    <td data-label="TIMESTAMP"><?= isset($order['created_at']) ? date('M d, Y h:i A', strtotime($order['created_at'])) : 'N/A' ?></td>
                                    <td data-label="STATUS"><span class="stock-badge <?= $statusClass ?>"><?= ucfirst($status) ?></span></td>
                                    <td class="action-buttons text-center" data-label="ACTIONS">
                                        <div class="action-buttons-container">
                                            <button type="button" class="btn btn-action edit-btn" 
                                                    onclick="updateOrderStatus(<?= $order['order_id'] ?>, 'paid')">
                                                Paid
                                            </button>
                                            <button type="button" class="btn btn-action delete-btn" 
                                                    onclick="updateOrderStatus(<?= $order['order_id'] ?>, 'unpaid')">
                                                Unpaid
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <?php 
                                endif; 
                                ?>
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>

                <!-- Pagination UI -->
                <div class="card admin-table-card">
                    <div class="card-body py-3">
                        <div class="d-flex pagination-container">
                            <div class="items-per-page me-auto">
                                <div class="d-flex align-items-center">
                                    <span class="me-2">Items per page</span>
                                    <select class="form-select form-select-sm">
                                        <option value="10" selected>10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="pagination-wrapper">
                                <nav aria-label="Page navigation">
                                    <ul class="pagination pagination-sm mb-0">
                                        <li class="page-item">
                                            <a class="page-link" href="#" aria-label="Previous">
                                                <i class="bi bi-chevron-left"></i>
                                            </a>
                                        </li>
                                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                                        <li class="page-item">
                                            <a class="page-link" href="#" aria-label="Next">
                                                <i class="bi bi-chevron-right"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Bootstrap JS -->
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Admin JS -->
    <script src="js/admin.js"></script>
    
    <!-- Edit Product Modal -->
    <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="editProductModalLabel">Edit Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="editProductForm" enctype="multipart/form-data">
                        <input type="hidden" id="editProductId" name="productId">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editProductName" class="form-label fw-medium">Product Name</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="bi bi-tag"></i></span>
                                    <input type="text" class="form-control" id="editProductName" name="productName" required>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="editCategory" class="form-label fw-medium">Category</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="bi bi-folder"></i></span>
                                        <select class="form-select" id="editCategory" name="categ" required>
                                            <option value="">Select category...</option>
                                            <?php 
                                            $catQuery = $conn->query("SELECT category_id, category_name FROM categories ORDER BY category_name");
                                            while($cat = $catQuery->fetch_assoc()): 
                                            ?>
                                                <option value="<?= $cat['category_id'] ?>"><?= htmlspecialchars($cat['category_name']) ?></option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="editStock" class="form-label fw-medium">Stock</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="bi bi-boxes"></i></span>
                                    <input type="number" class="form-control" id="editStock" name="stock" required>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="editShelfLocation" class="form-label fw-medium">Shelf Location</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="bi bi-geo-alt"></i></span>
                                        <select class="form-select" id="editShelfLocation" name="shelfLocation" required>
                                            <option value="">Select shelf location...</option>
                                            <option value="A1">Aisle A, Shelf 1</option>
                                            <option value="A2">Aisle A, Shelf 2</option>
                                            <option value="A3">Aisle A, Shelf 3</option>
                                            <option value="B1">Aisle B, Shelf 1</option>
                                            <option value="B2">Aisle B, Shelf 2</option>
                                            <option value="B3">Aisle B, Shelf 3</option>
                                            <option value="C1">Aisle C, Shelf 1</option>
                                            <option value="C2">Aisle C, Shelf 2</option>
                                            <option value="C3">Aisle C, Shelf 3</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="mt-2">
                                    <label for="editPrice" class="form-label fw-medium">Price</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">₱</span>
                                    <input type="number" step="0.01" class="form-control" id="editPrice" name="price" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editProductImage" class="form-label fw-medium">Product Image</label>
                                    <div class="card">
                                        <div class="card-body p-0 overflow-hidden">
                                            <div class="product-image-upload bg-light p-4 text-center position-relative" onclick="document.getElementById('editProductImage').click()">
                                        <input type="file" class="d-none" id="editProductImage" name="productImage">
                                                <div class="product-image-placeholder edit-image-placeholder">
                                                    <i class="bi bi-image fs-2 text-muted mb-2 d-block"></i>
                                                    <p class="mb-0">Click image to change</p>
                                                </div>
                                                <small class="text-muted d-block mt-3">Click image to change</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <label for="editSku" class="form-label fw-medium">SKU</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">#</span>
                                    <input required type="text" class="form-control" id="editSku" name="sku">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="description-container mt-4">
                            <div class="card">
                                <div class="card-header bg-light py-3">
                                    <label for="editDesc" class="form-label fw-bold mb-0">Product Description</label>
                                </div>
                                <div class="card-body">
                                    <textarea class="form-control border-0" id="editDesc" name="desc"></textarea>
                                    <small class="text-muted mt-2 d-block">Enter a detailed description of the product including features, specifications, and usage instructions.</small>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-end border-top">
                    <button type="button" class="btn btn-primary px-4 py-2" id="saveProductChanges">
                        <i class="bi bi-check-circle me-2"></i>Save Changes
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Delete Confirmation Modal -->
    <?php echo renderDeleteModal('product'); ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Notifications system
            window.showNotification = function(message, type = 'success') {
                const notificationsContainer = document.getElementById('notifications-container');
                
                const notification = document.createElement('div');
                notification.className = `alert alert-${type} alert-dismissible fade show`;
                notification.role = 'alert';
                
                // Add icon based on type
                let icon = 'check-circle';
                if (type === 'danger') icon = 'exclamation-triangle';
                if (type === 'warning') icon = 'exclamation-circle';
                if (type === 'info') icon = 'info-circle';
                
                notification.innerHTML = `
                    <div class="d-flex align-items-center">
                        <i class="bi bi-${icon} me-2"></i>
                        <div>${message}</div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                `;
                
                notificationsContainer.appendChild(notification);
                
                // Auto-dismiss after 5 seconds
                setTimeout(() => {
                    notification.classList.remove('show');
                    setTimeout(() => {
                        notification.remove();
                    }, 300);
                }, 5000);
            };
            
            // Handle search functionality for both desktop and mobile
            const searchInputs = document.querySelectorAll('.search-input');
            
            // Add event listeners to all search inputs
            searchInputs.forEach(input => {
                // Search on input change
                input.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase().trim();
                    searchOrders(searchTerm);
                });
                
                // Search when Enter key is pressed
                input.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        const searchTerm = this.value.toLowerCase().trim();
                        searchOrders(searchTerm);
                        e.preventDefault();
                    }
                });
            });
            
            // Make search icons clickable
            document.querySelectorAll('.search-icon').forEach(icon => {
                icon.style.cursor = 'pointer';
                icon.addEventListener('click', function() {
                    const input = this.parentElement.querySelector('.search-input');
                    const searchTerm = input.value.toLowerCase().trim();
                    searchOrders(searchTerm);
                });
            });
            
            function searchOrders(searchTerm) {
                const tableRows = document.querySelectorAll('.product-table tbody tr');
                let matches = 0;
                
                tableRows.forEach(row => {
                    let found = false;
                    const cells = row.querySelectorAll('td');
                    
                    cells.forEach(cell => {
                        if (cell.textContent.toLowerCase().includes(searchTerm)) {
                            found = true;
                        }
                    });
                    
                    if (found) {
                        row.style.display = '';
                        matches++;
                    } else {
                        row.style.display = 'none';
                    }
                });
                
                // Show feedback about search results
                if (searchTerm.length > 0) {
                    if (matches === 0) {
                        showNotification(`No orders match "${searchTerm}"`, 'warning');
                    }
                }
            }
            
            // Handle filter buttons
            const filterButtons = document.querySelectorAll('.filter-button, .btn-filter');
            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Implement filter functionality here
                    showNotification('Filter functionality will be implemented soon', 'info');
                });
            });
            
            // Enhanced desktop interactions
            if (window.innerWidth >= 992) {
                // Add row hover effects
                const tableRows = document.querySelectorAll('.admin-table tbody tr');
                tableRows.forEach(row => {
                    row.addEventListener('mouseenter', function() {
                        this.style.transform = 'translateY(-1px)';
                        this.style.boxShadow = '0 4px 8px rgba(0,0,0,0.05)';
                        this.style.transition = 'all 0.2s ease';
                    });
                    
                    row.addEventListener('mouseleave', function() {
                        this.style.transform = 'translateY(0)';
                        this.style.boxShadow = 'none';
                    });
                });
            }
        });
        
        // Simplified order status update function
        function updateOrderStatus(orderId, newStatus) {
            // Show a notification instead of making an actual request
            showNotification(`Order status would be updated to ${newStatus}`, 'info');
        }
    </script>
</body>
</html>