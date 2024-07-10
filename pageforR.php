<!DOCTYPE html>
<html>
<head>
  <title>اختيار الاتجاه</title>
  <style>
    body {
      background-color: #f0f0f0;
      font-family: Arial, sans-serif;
    }
    .button-container {
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      height: 80vh;
      background-color: #ccc;
      border-radius: 20px;
      padding: 20px;
    }
    .button-row {
      display: flex;
      justify-content: center;
      align-items: center;
      margin: 10px 0;
    }
    .button {
      width: 200px;
      height: 100px;
      margin: 0 20px;
      font-size: 18px;
      background-color: #736F6E;
      color: black;
      border: none;
      border-radius: 50px;
      cursor: pointer;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .stop {
      background-color: #e53935;
      color: white;
    }
  </style>
</head>
<body>
  <div class="button-container">
    <div class="button-row">
      <button class="button front">forward</button>
    </div>
    <div class="button-row">
      <button class="button left">left</button>
      <button class="button stop">stop</button>
      <button class="button right">right</button>
    </div>
    <div class="button-row">
      <button class="button back">backward</button>
    </div>
  </div>

  <?php
    // تحقق من إرسال النموذج
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // الحصول على القيم المرسلة من النموذج
      $direction = $_POST["direction"];

      // التحقق من قاعدة البيانات وحفظ البيانات
      $servername = "localhost";
      $username = "root";
      $password = "";
      $db = "web";

      $conn = new mysqli($servername, $username, $password, $db);

      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }

      $sql = "INSERT INTO control_table (button_value) VALUES ('$direction')";

      if ($conn->query($sql) === TRUE) {
        echo "Data saved successfully";
      } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
      }

      $conn->close();
    }
  ?>

  <script>
    // الحصول على الأزرار
    const buttons = document.querySelectorAll(".button");

    // إضافة حدث النقر على كل زر
    buttons.forEach(button => {
      button.addEventListener("click", () => {
        // الحصول على اتجاه الزر المنقور
        const direction = button.textContent.toLowerCase();
        let buttonValue;

        // تحديد قيمة الزر المرسلة إلى الخادم
        switch (direction) {
          case "right":
            buttonValue = "R";
            break;
          case "left":
            buttonValue = "L";
            break;
          case "forward":
            buttonValue = "F";
            break;
          case "backward":
            buttonValue = "B";
            break;
          case "stop":
            buttonValue = "S";
            break;
        }

        // إرسال البيانات إلى الخادم باستخدام AJAX
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "<?php echo $_SERVER["PHP_SELF"];?>", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            alert(this.responseText);
          }
        };
        xhr.send("direction=" + buttonValue);
      });
    });
  </script>
</body>
</html>