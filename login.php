<!DOCTYPE html>
<html>
<head>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="flex items-center justify-center h-screen bg-gray-100">

<div class="bg-white p-6 rounded shadow w-80">
    <h2 class="text-xl mb-4 text-center">Login</h2>

    <input id="username" class="w-full border p-2 mb-3" placeholder="Username">
    <input id="password" type="password" class="w-full border p-2 mb-3" placeholder="Password">

    <button onclick="login()" class="w-full bg-blue-500 text-white p-2 rounded">
        Login
    </button>

    <p id="msg" class="text-red-500 text-center mt-3"></p>
    <p class="flex gap-4">Create Account<a class="underline" href="register.php">Registration</a></p>
</div>

<script>
function login() {
    fetch("ajax_login.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `username=${encodeURIComponent(username.value)}&password=${encodeURIComponent(password.value)}`
    })
    .then(res => res.text())
    .then(text => {
        console.log("SERVER RESPONSE:", text); // 🔥 খুব দরকার

        let data = JSON.parse(text);

        if (data.success) {
            window.location.href = "user_dashbord.php";
        } else {
            msg.innerText = data.message;
        }
    })
    .catch(err => {
        msg.innerText = "Server Error";
        console.error(err);
    });
}
</script>


</body>
</html>