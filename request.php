<?php
require 'includes/header.php';
?>

<body>
    <main>
        <link rel="stylesheet" href="/css/request.css">
        <div class="background"></div>

        <form method="POST" action="/api/search/request.php">
            <div class="request-form">
                <label for="address">Address</label>
                <input name="address" class="address" type="text" placeholder="Address">
                    
                <label for="description">Description</label>
                <textarea name="description" class="description"> </textarea>
                <button type="submit">Submit</button>
            </div>
            
        </form>
    </main>
</body>
