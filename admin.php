<!DOCTYPE html>
<html lang="bn">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Admin — Simple Sidebar</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <style>
    :root { --header-h:56px; }
    .content-iframe { width:100%; height:calc(100vh - var(--header-h)); border:0; }
    /* mobile panel hidden to right, animate to 0 */
    .panel { transform: translateX(100%); transition: transform .25s ease; }
    .panel.open { transform: translateX(0); }
    /* mini mode */
    .mini .label { display:none; }
    .mini .submenu { display:none!important; }
  </style>
</head>
<body class="bg-gray-100 font-sans">

<header id="hdr" class="fixed top-0 left-0 right-0 bg-white border-b z-30">
  <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">

    <div class="flex items-center gap-3">
      <span class="hidden sm:inline text-sm text-gray-600">admin@shoppro.com</span>
      <button id="openMobile" class="md:hidden p-2 rounded hover:bg-gray-100">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
      </button>
    </div>
  </div>
</header>

<div style="padding-top:56px;">
  <div class="min-h-[calc(100vh-56px)] flex">

    <!-- desktop sidebar -->
    <aside id="sidebar" class="hidden md:flex flex-col bg-gray-800 text-white w-64">
      <div class="p-4 border-b">
        <div class="flex items-center gap-3"><div class="w-9 h-9 bg-indigo-600 rounded flex items-center justify-center">A</div>
          <div><div class="text-sm font-semibold">Admin</div><div class="text-xs text-gray-300">admin@shoppro.com</div></div>
        </div>
        <input id="search" class="mt-3 w-full bg-gray-700 rounded px-3 py-2 text-sm" placeholder="Search menu...">
      </div>

      <nav id="nav" class="p-2 flex-1 overflow-auto space-y-1">
        <a class="nav-item flex items-center gap-3 px-3 py-2 rounded hover:bg-gray-700" href="admin_dashbord.php" target="content_frame"><svg class="w-5 h-5 text-indigo-300" viewBox="0 0 24 24" fill="currentColor"><path d="M3 13h8V3H3v10zM3 21h8v-6H3v6zM13 21h8V11h-8v10zM13 3v6h8V3h-8z"/></svg><span class="label">Dashboard</a>

        <div>
          <button data-sub="prod" class="w-full flex items-center justify-between px-3 py-2 rounded hover:bg-gray-700">
            <span class="flex items-center gap-3"><svg class="w-5 h-5 text-indigo-300" viewBox="0 0 24 24" fill="currentColor"><path d="M3 7h18v2H3V7zm0 4h18v2H3v-2zm0 4h18v2H3v-2z"/></svg><span class="label font-medium">Products</span></span>
            <svg class="w-4 h-4 text-gray-300" viewBox="0 0 24 24" fill="none"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </button>
          <div id="prod" class="pl-12 space-y-1 submenu hidden">
            <a class="block px-3 py-2 rounded hover:bg-gray-700" href="add_product.php" target="content_frame">Add Product</a>
            <a class="block px-3 py-2 rounded hover:bg-gray-700" href="product_list_view.php" target="content_frame">Product List</a>
            <a class="block px-3 py-2 rounded hover:bg-gray-700" href="add_catagory_sub&brand.php" target="content_frame">Add Brand</a>
          </div>
        </div>

        <a class="nav-item flex items-center gap-3 px-3 py-2 rounded hover:bg-gray-700" href="admin_orders.php" target="content_frame"><svg class="w-5 h-5 text-indigo-300" viewBox="0 0 24 24" fill="currentColor"><path d="M3 3h18v2H3V3zm0 6h18v12H3V9z"/></svg><span class="label">Orders</span></a>

        <a class="nav-item flex items-center gap-3 px-3 py-2 rounded hover:bg-gray-700" href="order_tracking.php" target="content_frame"><svg class="w-5 h-5 text-indigo-300" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l1.5 4.5L18 8l-4 2.5L12 15l-2-4.5L6 8l4.5-1.5L12 2z"/></svg><span class="label">Order Tracking</span></a>
      </nav>


    </aside>

    <!-- mobile sidebar slide-from-right -->
    <div id="mobileWrap" class="fixed inset-0 z-40 md:hidden hidden">
      <div id="backdrop" class="absolute inset-0 bg-black/40"></div>
      <div id="panel" class="panel absolute right-0 top-0 bottom-0 w-72 bg-gray-800 text-white p-4">
        <div class="flex items-center justify-between mb-3">
          <div class="flex items-center gap-3"><div class="w-10 h-10 bg-indigo-600 rounded flex items-center justify-center">A</div><div><div class="font-semibold">Admin</div><div class="text-xs text-gray-300">admin@shoppro.com</div></div></div>
          <button id="closeMobile" class="p-1 rounded hover:bg-gray-700">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none"><path d="M6 18L18 6M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
          </button>
        </div>
        <input id="msearch" class="w-full bg-gray-700 rounded px-3 py-2 mb-3" placeholder="Search...">
        <nav class="space-y-1">
          <a class="block px-3 py-2 rounded hover:bg-gray-700" href="admin_dashbord.php" target="content_frame">📊 Dashboard</a>
          <a class="block px-3 py-2 rounded hover:bg-gray-700" href="add_product.php" target="content_frame">➕ Add Product</a>
          <a class="block px-3 py-2 rounded hover:bg-gray-700" href="product_list_view.php" target="content_frame">📦 Product List</a>
          <a class="block px-3 py-2 rounded hover:bg-gray-700" href="admin_orders.php" target="content_frame">🧾 Order List</a>
          <a class="block px-3 py-2 rounded hover:bg-gray-700" href="order_tracking.php" target="content_frame">🚚 Orders tracking</a>
        </nav>
      </div>
    </div>

    <!-- main -->
    <main class="flex-1">
      <iframe name="content_frame" src="test1.php" class="content-iframe"></iframe>
    </main>
  </div>
</div>

<script>
  // set header height var
  (function(){ const h = document.getElementById('hdr')?.offsetHeight||56; document.documentElement.style.setProperty('--header-h', h+'px'); window.addEventListener('resize', ()=>{ const h2=document.getElementById('hdr')?.offsetHeight||56; document.documentElement.style.setProperty('--header-h', h2+'px'); }); })();

  // submenu toggle
  document.querySelectorAll('[data-sub]').forEach(b=> b.onclick=()=> { const id=b.dataset.sub; document.getElementById(id).classList.toggle('hidden'); });

  // search desktop
  document.getElementById('search')?.addEventListener('input', e=>{
    const q=e.target.value.toLowerCase();
    document.querySelectorAll('#nav a, #nav button').forEach(el=>{
      const txt = (el.innerText||'').toLowerCase();
      el.style.display = (!q || txt.includes(q)) ? '' : 'none';
    });
  });

  // mobile open/close (slide from right)
  const mobileWrap = document.getElementById('mobileWrap'), panel=document.getElementById('panel'), backdrop=document.getElementById('backdrop');
  document.getElementById('openMobile')?.addEventListener('click', ()=>{
    mobileWrap.classList.remove('hidden'); requestAnimationFrame(()=>{ panel.classList.add('open'); backdrop.classList.add('visible'); document.body.style.overflow='hidden'; });
  });
  document.getElementById('closeMobile')?.addEventListener('click', ()=>{ panel.classList.remove('open'); backdrop.classList.remove('visible'); setTimeout(()=>{ mobileWrap.classList.add('hidden'); document.body.style.overflow=''; },260); });
  backdrop?.addEventListener('click', ()=> document.getElementById('closeMobile').click());

  // mobile search
  document.getElementById('msearch')?.addEventListener('input', e=>{
    const q=e.target.value.toLowerCase();
    document.querySelectorAll('#panel nav a').forEach(a=> a.style.display = (!q || a.innerText.toLowerCase().includes(q)) ? '' : 'none');
  });

  // mini / collapse
  const sidebar=document.getElementById('sidebar');
  document.getElementById('miniBtn')?.addEventListener('click', ()=> document.body.classList.toggle('mini'));
  document.getElementById('collapse')?.addEventListener('click', ()=> document.body.classList.add('mini'));

  // active link highlight
  document.querySelectorAll('a[target="content_frame"]').forEach(a=>{
    a.addEventListener('click', ()=> { document.querySelectorAll('.nav-item').forEach(n=>n.classList.remove('bg-gray-700')); if(a.classList.contains('nav-item')) a.classList.add('bg-gray-700'); if(window.innerWidth<768) document.getElementById('closeMobile').click(); });
  });
</script>

</body>
</html>
