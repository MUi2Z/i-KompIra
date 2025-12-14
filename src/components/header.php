<?php $oof = 1;// include '../backend/connection.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="src/css/input.css">
    <link href="../src/css/output.css" rel="stylesheet">
    <link href="/output.css" rel="stylesheet">
    <title>i-KompIra</title>
    <style>
        *
        {
            scroll-behavior: smooth;
        }
        
        body
        {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background-color: #F8F4E9;
        }
    </style>

    <?php
        // style templates
        $border = "border-2 border-orange-300 rounded-lg";
        $modal_outer = "fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50";
        $modal_inner = "relative top-20 mx-auto p-5 border w-11/12 md:w-3/5 lg:w-2/5 shadow-lg rounded-md bg-white";
    ?>
</head>
<body>

