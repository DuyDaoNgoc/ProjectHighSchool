<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AJAX Loading</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
    /* Loading overlay */
    #loading {
        display: none;
        position: fixed;
        z-index: 1000;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
    }

    /* Spinner style */
    #loading .spinner {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 50px;
        height: 50px;
        border: 5px solid #f3f3f3;
        border-top: 5px solid #3498db;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: translate(-50%, -50%) rotate(0deg);
        }

        100% {
            transform: translate(-50%, -50%) rotate(360deg);
        }
    }

    /* Result area style */
    #result {
        margin-top: 20px;
    }
    </style>
</head>

<body>
    <button id="loadData">Load Data</button>
    <!-- Loading overlay with spinner -->
    <div id="loading">
        <div class="spinner"></div>
    </div>
    <div id="result"></div>

    <script>
    $(document).ready(function() {
        $("#loadData").click(function() {
            // Hiển thị loading spinner
            $("#loading").show();
            $.ajax({
                url: "process.php", // Đường dẫn đến file xử lý AJAX
                type: "GET",
                success: function(data) {
                    $("#result").html(data);
                },
                error: function(xhr, status, error) {
                    $("#result").html("Error: " + error);
                },
                complete: function() {
                    // Ẩn loading sau khi request hoàn thành
                    $("#loading").hide();
                }
            });
        });
    });
    </script>
</body>

</html>