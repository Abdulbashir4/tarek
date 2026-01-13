<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="flex items-center justify-center h-screen bg-gray-100">

<div class="bg-white p-6 rounded shadow w-96">
    <h2 class="text-xl text-center mb-4">Register</h2>

    <input id="username" type="text"
        class="w-full border p-2 mb-3"
        placeholder="Username">

    <input id="phone" type="text"
       class="w-full border p-2 mb-3"
       placeholder="Phone Number">


    <input id="password" type="password"
        class="w-full border p-2 mb-3"
        placeholder="Password">

    <input id="confirm_password" type="password"
        class="w-full border p-2 mb-3"
        placeholder="Confirm Password">

    <button onclick="register()"
        class="w-full bg-green-500 text-white p-2 rounded">
        Register
    </button>

    <p id="msg" class="text-center mt-3"></p>

    <p class="text-center text-sm mt-4">
        Already have account?
        <a href="login.php" class="text-blue-500 underline">Login</a>
    </p>
</div>

<script>
function register() {
    msg.innerText = "";

    fetch("ajax_register.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body:
 `username=${encodeURIComponent(username.value)}` +
 `&phone=${encodeURIComponent(phone.value)}` +
 `&password=${encodeURIComponent(password.value)}` +
 `&confirm_password=${encodeURIComponent(confirm_password.value)}`

    })
    .then(res => res.text())
.then(text => {
    console.log("SERVER RESPONSE:", text); // 🔥 এটা দেখো
    let data = JSON.parse(text);

    if (data.success) {
        msg.className = "text-green-600 text-center mt-3";
        msg.innerText = "Registration successful!";
    } else {
        msg.className = "text-red-600 text-center mt-3";
        msg.innerText = data.message;
    }
})
    .catch(err => {
        msg.className = "text-red-600 text-center mt-3";
        msg.innerText = "Server error";
        console.error(err);
    });
}
</script>

</body>
</html>