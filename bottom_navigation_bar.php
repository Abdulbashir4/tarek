

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body>
    <!-- Bottom Navigation - paste near end of <body> -->
<nav class="fixed inset-x-0 bottom-0 z-50 bg-white border-t shadow-md sm:hidden" aria-label="Primary">
  <ul class="flex justify-between items-center max-w-xl mx-auto">
    <!-- Home -->
    <li class="flex-1 text-center">
      <a href="index.php" class="block py-2.5 px-1 text-gray-600 hover:text-indigo-600 active:text-indigo-700" id="nav-home" aria-label="Home">
        <!-- Icon -->
        <svg class="mx-auto w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l9-7 9 7v7a2 2 0 0 1-2 2h-4a2 2 0 0 1-2-2v-4H9v4a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-7z"></path>
        </svg>
        <span class="text-xs block mt-0.5">Home</span>
      </a>
    </li>

    <!-- Categories -->
    <li class="flex-1 text-center">
      <a href="#category" class="block py-2.5 px-1 text-gray-600 hover:text-indigo-600" id="nav-cats" aria-label="Categories">
        <svg class="mx-auto w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
        <span class="text-xs block mt-0.5">Categories</span>
      </a>
    </li>

    <!-- Search (center, slightly larger) -->
    <li class="flex-1 text-center">
      <a href="search.php" class="block -mt-2" id="nav-search" aria-label="Search">
        <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-indigo-600 text-white shadow-lg transform -translate-y-1">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 18a7 7 0 1 1 0-14 7 7 0 0 1 0 14z"></path>
          </svg>
        </div>
        <span id="mobileSearchBtn" class="text-xs block mt-1 text-gray-600">Search</span>
      </a>
    </li>

    <!-- Cart (badge) -->
    <li class="flex-1 text-center relative">
      <a href="cart.php" class="relative">
        🛒
        <span id="footerCartCount" 
              class="cart-badge absolute -top-2 -right-2 bg-red-600 text-white text-xs font-bold w-5 h-5 flex items-center justify-center rounded-full">
          <?php echo isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'qty')) : 0; ?>
        </span>
      </a>
    </li>

    <!-- Profile -->
    <li class="flex-1 text-center">
      <a href="profile.php" class="block py-2.5 px-1 text-gray-600 hover:text-indigo-600" id="nav-profile" aria-label="Profile">
        <svg class="mx-auto w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0 1 12 15c2.5 0 4.84.63 6.879 1.804M15 11a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"></path>
        </svg>
        <span class="text-xs block mt-0.5">Account</span>
      </a>
    </li>
  </ul>
</nav>

<!-- Optional script to set active state + update cart badge dynamically -->
<script>
  // Set active nav item based on current URL (simple)
  (function(){
    const path = location.pathname.split('/').pop().toLowerCase();
    if(path.includes('index') || path === '') document.getElementById('nav-home')?.classList.add('text-indigo-600');
    if(path.includes('categories')) document.getElementById('nav-cats')?.classList.add('text-indigo-600');
    if(path.includes('search')) document.getElementById('nav-search')?.classList.add(''); // center has its own style
    if(path.includes('cart')) document.getElementById('nav-cart')?.classList.add('text-indigo-600');
    if(path.includes('profile')) document.getElementById('nav-profile')?.classList.add('text-indigo-600');
  })();

  // Update cart badge from a global element (e.g., header cartCount) OR fetch from server
  function updateBottomCartBadge(count) {
    const badge = document.getElementById('bottomCartBadge');
    if(!badge) return;
    badge.innerText = count ?? 0;
    badge.style.display = (count && count > 0) ? 'inline-flex' : 'none';
  }

  // If you already have an element with id="cartCount" (header), copy its value
  document.addEventListener('DOMContentLoaded', () => {
    const headerCount = document.getElementById('cartCount');
    if(headerCount) {
      const n = Number(headerCount.innerText || headerCount.textContent) || 0;
      updateBottomCartBadge(n);
    } else {
      // Optional: fetch from server (example)
      // fetch('cart_count.php').then(r=>r.json()).then(j=> updateBottomCartBadge(j.count));
      updateBottomCartBadge(0);
    }
  });
</script>

</body>
</html>