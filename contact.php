<?php 
include 'global_php.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Contact Us - ShopPro</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- Tailwind CDN -->
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <style>
    /* ড্র্যাগ করার জন্য বাটনের জন্য একটু হেল্পফুল CSS */
    #movableBtn {
      position: fixed;
      z-index: 40;
      user-select: none;
    }
  </style>
</head>
<body class="bg-gray-100 text-gray-800">

  <!-- TOP BAR / HEADER -->
  <?php include 'header.php'; ?>

  <!-- MAIN WRAPPER -->
  <main class="pt-24 pb-16">
    <section class="max-w-7xl mx-auto px-4">
      
      <!-- PAGE TITLE -->
      <div class="text-center mb-10">
        <h1 class="text-3xl md:text-4xl font-bold text-gray-900">Contact Us</h1>
        <p class="mt-3 text-gray-600 max-w-xl mx-auto">
          <?php echo $company['about_us']; ?>
        </p>
      </div>

      <!-- MAIN GRID -->
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- LEFT SIDE: COMPANY INFO -->
        <div class="bg-white rounded-2xl shadow-md p-6 lg:col-span-1 flex flex-col justify-between">
          
          <div>
            <h2 class="text-xl font-semibold mb-3 text-gray-900">Get in Touch</h2>
            <p class="text-sm text-gray-600 mb-6">
              আপনি চাইলে আমাদের কল, ইমেইল বা মেসেজ করতে পারেন। দ্রুততম সময়ে রিপ্লাই করার চেষ্টা করবো।
            </p>

            <div class="space-y-4 text-sm">
              <!-- Phone -->
              <div class="flex items-start gap-3">
                <div class="h-9 w-9 flex items-center justify-center rounded-full bg-indigo-50 text-indigo-600">
                  📞
                </div>
                <div>
                  <p class="font-semibold">Phone</p>
                  <p class="text-gray-600"><?php echo $company['mobile_number']; ?></p>
                </div>
              </div>

              <!-- Email -->
              <div class="flex items-start gap-3">
                <div class="h-9 w-9 flex items-center justify-center rounded-full bg-indigo-50 text-indigo-600">
                  📧
                </div>
                <div>
                  <p class="font-semibold">Email</p>
                  <p class="text-gray-600"><?php echo $company['email']; ?></p>
                </div>
              </div>

              <!-- Address -->
              <div class="flex items-start gap-3">
                <div class="h-9 w-9 flex items-center justify-center rounded-full bg-indigo-50 text-indigo-600">
                  📍
                </div>
                <div>
                  <p class="font-semibold">Office Address</p>
                  <p class="text-gray-600">
                    <?php echo $company['office_address']; ?>
                  </p>
                </div>
              </div>
            </div>
          </div>

          <!-- SOCIAL LINKS -->
          <div class="mt-8 border-t pt-4">
            <p class="text-sm font-semibold mb-2">Follow Us</p>
            <div class="flex items-center gap-3 text-sm">
              <a href="#" class="px-3 py-1 rounded-full border border-gray-300 hover:border-indigo-500 hover:text-indigo-600 transition">Facebook</a>
              <a href="#" class="px-3 py-1 rounded-full border border-gray-300 hover:border-indigo-500 hover:text-indigo-600 transition">Instagram</a>
              <a href="#" class="px-3 py-1 rounded-full border border-gray-300 hover:border-indigo-500 hover:text-indigo-600 transition">YouTube</a>
            </div>
          </div>
        </div>

        <!-- RIGHT SIDE: CONTACT FORM -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-md p-6 md:p-8">
          <h2 class="text-xl font-semibold mb-4 text-gray-900">Send us a message</h2>
          <p class="text-sm text-gray-600 mb-6">
            নিচের ফর্মটি পূরণ করে আমাদের মেসেজ পাঠাতে পারেন। সাধারণত ২৪ ঘণ্টার মধ্যে ইমেইলে রিপ্লাই করি।
          </p>

          <form action="#" method="post" class="space-y-4">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <!-- Name -->
              <div>
                <label class="block text-sm font-medium mb-1">Your Name</label>
                <input 
                  type="text" 
                  name="name" 
                  class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" 
                  placeholder="Enter your name" 
                  required
                />
              </div>

              <!-- Email -->
              <div>
                <label class="block text-sm font-medium mb-1">Email Address</label>
                <input 
                  type="email" 
                  name="email" 
                  class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" 
                  placeholder="you@example.com" 
                  required
                />
              </div>
            </div>

            <!-- Phone -->
            <div>
              <label class="block text-sm font-medium mb-1">Phone Number (optional)</label>
              <input 
                type="tel" 
                name="phone" 
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" 
                placeholder="+8801788832489"
              />
            </div>

            <!-- Subject -->
            <div>
              <label class="block text-sm font-medium mb-1">Subject</label>
              <select
                name="subject"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white"
                required
              >
                <option value="">Select a subject</option>
                <option value="order">Order Related Issue</option>
                <option value="product">Product Inquiry</option>
                <option value="payment">Payment & Billing</option>
                <option value="return">Return & Refund</option>
                <option value="other">Other</option>
              </select>
            </div>

            <!-- Message -->
            <div>
              <label class="block text-sm font-medium mb-1">Your Message</label>
              <textarea 
                name="message" 
                rows="5"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" 
                placeholder="Write your message here..." 
                required
              ></textarea>
            </div>

            <!-- Checkbox -->
            <div class="flex items-start gap-2 text-xs text-gray-600">
              <input id="copyMail" type="checkbox" class="mt-1 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
              <label for="copyMail">
                আমার ইমেইল এ একটি কপি পাঠিয়ে দিন।
              </label>
            </div>

            <!-- Submit Button -->
            <div>
              <button 
                type="submit"
                class="w-full md:w-auto px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg shadow-sm transition"
              >
                Send Message
              </button>
            </div>
          </form>
        </div>

      </div>

      <!-- FAQ SECTION -->
      <section class="mt-12">
        <h2 class="text-2xl font-bold mb-4 text-gray-900 text-center">Frequently Asked Questions</h2>
        <p class="text-sm text-gray-600 text-center max-w-2xl mx-auto mb-6">
          Contact করার আগে দ্রুত উত্তর দরকার? নিচের কমন প্রশ্নগুলো দেখে নিতে পারেন।
        </p>

        <div class="max-w-3xl mx-auto space-y-3">

          <details class="bg-white rounded-xl shadow-sm p-4">
            <summary class="cursor-pointer font-semibold text-sm text-gray-800">
              🕒 অর্ডার ডেলিভারি হতে কত দিন লাগে?
            </summary>
            <p class="mt-2 text-sm text-gray-600">
              সাধারণত ঢাকা সিটির মধ্যে ১-৩ কর্মদিবস এবং ঢাকার বাইরে ৩-৫ কর্মদিবসের মধ্যে ডেলিভারি হয়ে যায়।
            </p>
          </details>

          <details class="bg-white rounded-xl shadow-sm p-4">
            <summary class="cursor-pointer font-semibold text-sm text-gray-800">
              💳 কোন কোন পেমেন্ট মেথড আছে?
            </summary>
            <p class="mt-2 text-sm text-gray-600">
              আমরা Cash on Delivery, বকশ, নগদ, রকেট এবং ডেবিট/ক্রেডিট কার্ড সাপোর্ট করি।
            </p>
          </details>

          <details class="bg-white rounded-xl shadow-sm p-4">
            <summary class="cursor-pointer font-semibold text-sm text-gray-800">
              🔄 প্রোডাক্ট রিটার্ন বা এক্সচেঞ্জ করতে পারবো?
            </summary>
            <p class="mt-2 text-sm text-gray-600">
              হ্যাঁ, নির্দিষ্ট শর্ত সাপেক্ষে ৭ দিনের মধ্যে রিটার্ন বা এক্সচেঞ্জ করা যায়। বিস্তারিত জানতে রিটার্ন পলিসি দেখুন বা আমাদের সাথে যোগাযোগ করুন।
            </p>
          </details>

        </div>
      </section>

    </section>
  </main>

  <!-- FOOTER -->
  <footer class="bg-gray-900 text-gray-300 text-sm py-6 mt-8">
    <div class="max-w-7xl mx-auto px-4 flex flex-col md:flex-row items-center justify-between gap-3">
      <p>© 2025 <?php echo $company['company_name']; ?> — All Rights Reserved.Developed By ENG. ABDUL BASIR</p>
      <p>Need quick help? <a href="mailto:support@shoppro.com" class="text-indigo-400 hover:underline">support@shoppro.com</a></p>
    </div>
  </footer>

  <!-- 🟢 MOVABLE WHATSAPP BUTTON -->
  <button
    id="movableBtn"
    class="bg-green-500 hover:bg-green-600 text-white rounded-full shadow-lg px-4 py-2 flex items-center gap-2 text-sm font-semibold cursor-grab"
    type="button"
  >
    <span>💬</span>
    <span class="hidden sm:inline">WhatsApp</span>
  </button>

  <script>
   const btn = document.getElementById("movableBtn");
let isDragging = false;
let dragged = false;
let offsetX = 0;
let offsetY = 0;

// প্রথমে default position সেট করি
function setInitialPosition() {
  const margin = 24;
  btn.style.left = window.innerWidth - btn.offsetWidth - margin + "px";
  btn.style.top = window.innerHeight - btn.offsetHeight - margin + "px";
}

window.addEventListener("load", setInitialPosition);
window.addEventListener("resize", setInitialPosition);

// Mouse down = drag শুরু হতে পারে
btn.addEventListener("mousedown", (e) => {
  isDragging = true;
  dragged = false;
  offsetX = e.clientX - btn.offsetLeft;
  offsetY = e.clientY - btn.offsetTop;
});

// Mouse move = drag করা হচ্ছে
document.addEventListener("mousemove", (e) => {
  if (isDragging) {
    dragged = true;
    btn.style.left = e.clientX - offsetX + "px";
    btn.style.top = e.clientY - offsetY + "px";
  }
});

// Mouse up = drag শেষ
document.addEventListener("mouseup", () => {
  isDragging = false;
});

// Prevent click when dragged
btn.addEventListener("click", (e) => {
  if (dragged) {
    e.preventDefault();
    return; // drag করলে WhatsApp ক্লিক হবে না
  }

  // WhatsApp direct open
  const phone = "966569989506"; 
  const text = encodeURIComponent("Hello ShopPro, I need help.");
  window.open(`https://wa.me/${phone}?text=${text}`, "_blank");
});

/* Mobile Touch Support */
btn.addEventListener("touchstart", (e) => {
  const t = e.touches[0];
  isDragging = true;
  dragged = false;
  offsetX = t.clientX - btn.offsetLeft;
  offsetY = t.clientY - btn.offsetTop;
});

document.addEventListener("touchmove", (e) => {
  if (isDragging) {
    dragged = true;
    const t = e.touches[0];
    btn.style.left = t.clientX - offsetX + "px";
    btn.style.top = t.clientY - offsetY + "px";
  }
});

document.addEventListener("touchend", () => {
  isDragging = false;
});

  </script>

</body>
</html>
