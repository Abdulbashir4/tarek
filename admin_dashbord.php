<!doctype html>
<html lang="bn">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Admin Dashboard — ShopPro</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <style>
    :root{ --sidebar-w:18rem; }
    /* subtle scrollbar for panel */
    .scrollbar-thin::-webkit-scrollbar { height:8px; width:8px; }
    .scrollbar-thin::-webkit-scrollbar-thumb { background:rgba(0,0,0,0.12); border-radius:8px; }
    /* small helper for KPI delta color */
    .delta-up { color: #16a34a; }
    .delta-down { color: #dc2626; }
  </style>
</head>
<body class="bg-gray-100 text-gray-800 font-sans">

<!-- Page wrapper -->
<div class="min-h-screen flex">

  <!-- SIDEBAR (desktop) -->
  

  <!-- MOBILE SIDEBAR (slide-in) -->
  <div id="mobileSidebar" class="fixed inset-0 z-40 md:hidden hidden">
    <div id="ms-backdrop" class="absolute inset-0 bg-black/40" ></div>
    <div class="absolute right-0 top-0 bottom-0 w-72 bg-gray-800 text-white p-4 overflow-auto">
      <div class="flex items-center justify-between mb-3">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 bg-indigo-500 rounded flex items-center justify-center font-bold">SP</div>
          <div><div class="text-sm font-semibold">Admin</div><div class="text-xs text-gray-300">admin@shoppro.com</div></div>
        </div>
        <button id="mobileClose" class="p-1 hover:bg-gray-700 rounded">✖️</button>
      </div>

      <nav class="space-y-1">
        <a class="block px-3 py-2 rounded hover:bg-gray-700" href="#">Dashboard</a>
        <a class="block px-3 py-2 rounded hover:bg-gray-700" href="#">All Products</a>
        <a class="block px-3 py-2 rounded hover:bg-gray-700" href="#">Orders</a>
        <a class="block px-3 py-2 rounded hover:bg-gray-700" href="#">Analytics</a>
        <a class="block px-3 py-2 rounded hover:bg-gray-700" href="#">Settings</a>
      </nav>
    </div>
  </div>

  <!-- Main content -->
  <div class="flex-1 min-h-screen">

    <!-- TOPBAR -->
    <header class="sticky top-0 z-20 bg-white border-b">
      <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between gap-4">
        <div class="flex items-center gap-3">
          <button id="openMobile" class="md:hidden p-2 rounded hover:bg-gray-100">☰</button>
          <h1 class="text-xl font-semibold hidden sm:block">Dashboard</h1>
          <div class="relative hidden sm:block">
            <input id="globalSearch" class="border rounded px-3 py-2 w-80" placeholder="Search orders, products..." />
            <button onclick="document.getElementById('globalSearch').value='';" class="absolute right-1 top-1.5 text-sm text-gray-500">✖</button>
          </div>
        </div>

        <div class="flex items-center gap-3">
          <button class="p-2 rounded hover:bg-gray-50">🔔 <span class="ml-1 text-xs bg-red-500 text-white px-1 rounded-full">3</span></button>
          <div class="flex items-center gap-2">
            <img src="https://i.pravatar.cc/40?img=12" class="w-9 h-9 rounded-full border" />
            <div class="text-sm">
              <div class="font-medium">Admin</div>
              <div class="text-xs text-gray-500">Super Admin</div>
            </div>
          </div>
        </div>
      </div>
    </header>

    <!-- PAGE BODY -->
    <main class="max-w-7xl mx-auto px-4 py-6 grid grid-cols-1 lg:grid-cols-12 gap-6">

      <!-- Left: KPIs + Chart -->
      <section class="lg:col-span-8 space-y-6">

        <!-- KPI Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
          <div class="bg-white p-4 rounded shadow flex items-center justify-between">
            <div>
              <div class="text-xs text-gray-500">Total Sales</div>
              <div class="text-2xl font-bold">$24,820</div>
              <div class="text-xs text-gray-500 mt-1"><span class="delta-up">+8.4%</span> vs last week</div>
            </div>
            <div class="bg-indigo-50 p-3 rounded">
              <svg class="w-8 h-8 text-indigo-600" viewBox="0 0 24 24" fill="none"><path d="M3 3v18h18" stroke="currentColor" stroke-width="2"/></svg>
            </div>
          </div>

          <div class="bg-white p-4 rounded shadow flex items-center justify-between">
            <div>
              <div class="text-xs text-gray-500">Orders</div>
              <div class="text-2xl font-bold">1,320</div>
              <div class="text-xs text-gray-500 mt-1"><span class="delta-down">-2.1%</span> vs last week</div>
            </div>
            <div class="bg-amber-50 p-3 rounded">
              <svg class="w-8 h-8 text-amber-600" viewBox="0 0 24 24" fill="none"><path d="M3 7h18" stroke="currentColor" stroke-width="2"/></svg>
            </div>
          </div>

          <div class="bg-white p-4 rounded shadow flex items-center justify-between">
            <div>
              <div class="text-xs text-gray-500">Customers</div>
              <div class="text-2xl font-bold">8,214</div>
              <div class="text-xs text-gray-500 mt-1"><span class="delta-up">+3.2%</span></div>
            </div>
            <div class="bg-green-50 p-3 rounded">
              <svg class="w-8 h-8 text-green-600" viewBox="0 0 24 24" fill="none"><path d="M12 2v20" stroke="currentColor" stroke-width="2"/></svg>
            </div>
          </div>

          <div class="bg-white p-4 rounded shadow flex items-center justify-between">
            <div>
              <div class="text-xs text-gray-500">Revenue</div>
              <div class="text-2xl font-bold">$56,430</div>
              <div class="text-xs text-gray-500 mt-1"><span class="delta-up">+12.6%</span></div>
            </div>
            <div class="bg-pink-50 p-3 rounded">
              <svg class="w-8 h-8 text-pink-600" viewBox="0 0 24 24" fill="none"><path d="M3 12h18" stroke="currentColor" stroke-width="2"/></svg>
            </div>
          </div>
        </div>

        <!-- Revenue Chart + small stats -->
        <div class="bg-white rounded shadow p-4">
          <div class="flex items-center justify-between mb-3">
            <h3 class="text-lg font-semibold">Revenue (Last 30 days)</h3>
            <div class="text-sm text-gray-500">Updated 2h ago</div>
          </div>

          <!-- simple sparkline area (placeholder) -->
          <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="md:col-span-3">
              <div class="w-full h-44 bg-gradient-to-b from-indigo-50 to-white rounded p-3">
                <!-- tiny svg area chart -->
                <svg viewBox="0 0 400 120" class="w-full h-full">
                  <defs>
                    <linearGradient id="g" x1="0" x2="0" y1="0" y2="1">
                      <stop offset="0%" stop-color="#6366F1" stop-opacity="0.18"></stop>
                      <stop offset="100%" stop-color="#A78BFA" stop-opacity="0"></stop>
                    </linearGradient>
                  </defs>
                  <path d="M0 80 L50 60 L100 40 L150 50 L200 30 L250 20 L300 35 L350 25 L400 20 L400 120 L0 120 Z" fill="url(#g)"></path>
                  <path d="M0 80 L50 60 L100 40 L150 50 L200 30 L250 20 L300 35 L350 25 L400 20" fill="none" stroke="#6366F1" stroke-width="3" stroke-linejoin="round" stroke-linecap="round"></path>
                </svg>
              </div>
            </div>

            <div class="md:col-span-1 flex flex-col gap-2">
              <div class="bg-gray-50 p-3 rounded">
                <div class="text-xs text-gray-500">Avg Order Value</div>
                <div class="font-semibold">$42.70</div>
              </div>
              <div class="bg-gray-50 p-3 rounded">
                <div class="text-xs text-gray-500">Conversion Rate</div>
                <div class="font-semibold">3.2%</div>
              </div>
              <div class="bg-gray-50 p-3 rounded">
                <div class="text-xs text-gray-500">Refund Rate</div>
                <div class="font-semibold text-red-600">0.6%</div>
              </div>
            </div>
          </div>
        </div>

        <!-- Recent Orders table -->
        <div class="bg-white rounded shadow p-4">
          <div class="flex items-center justify-between mb-3">
            <h3 class="text-lg font-semibold">Recent Orders</h3>
            <div class="flex items-center gap-2">
              <input id="ordersFilter" class="border rounded px-3 py-1 text-sm" placeholder="Filter by customer or id...">
              <button id="refreshOrders" class="px-3 py-1 bg-indigo-600 text-white rounded text-sm">Refresh</button>
            </div>
          </div>

          <div class="overflow-x-auto">
            <table class="w-full text-sm">
              <thead class="text-left text-gray-500 bg-gray-50">
                <tr>
                  <th class="p-3">Order</th>
                  <th class="p-3">Customer</th>
                  <th class="p-3">Total</th>
                  <th class="p-3">Status</th>
                  <th class="p-3">Date</th>
                  <th class="p-3">Action</th>
                </tr>
              </thead>
              <tbody id="ordersTable">
                <!-- rows populated by JS -->
              </tbody>
            </table>
          </div>
        </div>

      </section>

      <!-- Right: Products / Activity -->
      <aside class="lg:col-span-4 space-y-6">

        <!-- Quick Actions -->
        <div class="bg-white rounded shadow p-4">
          <h3 class="font-semibold mb-3">Quick Actions</h3>
          <div class="grid grid-cols-2 gap-2">
            <button class="p-3 bg-indigo-600 text-white rounded">Add Product</button>
            <button class="p-3 bg-amber-500 text-white rounded">Add Discount</button>
            <button class="p-3 bg-green-600 text-white rounded">Export CSV</button>
            <button class="p-3 bg-gray-200 rounded">Settings</button>
          </div>
        </div>

        <!-- Products list -->
        <div class="bg-white rounded shadow p-4">
          <h3 class="font-semibold mb-3">Top Products</h3>
          <div class="space-y-3" id="productList">
            <!-- product cards by JS -->
          </div>
        </div>

        <!-- Activity / Messages -->
        <div class="bg-white rounded shadow p-4">
          <h3 class="font-semibold mb-3">Activity</h3>
          <ul class="text-sm text-gray-600 space-y-2">
            <li>🟢 New user signed up — <span class="text-gray-500">10m ago</span></li>
            <li>📦 Order #2712 shipped — <span class="text-gray-500">30m ago</span></li>
            <li>⚠️ Payment failed — <span class="text-gray-500">2h ago</span></li>
          </ul>
        </div>

      </aside>

    </main>

    <!-- FOOTER -->
    <footer class="bg-white border-t mt-6">
      <div class="max-w-7xl mx-auto px-4 py-4 text-sm text-gray-500 text-center">
        © 2025 ShopPro • Admin Dashboard
      </div>
    </footer>

  </div>
</div>

<!-- SCRIPTS: demo data & interactivity -->
<script>
  // sidebar submenu toggle
  document.querySelectorAll('[data-sub]').forEach(btn=>{
    btn.addEventListener('click', ()=> {
      const id = btn.dataset.sub;
      document.getElementById(id).classList.toggle('hidden');
    });
  });

  // mobile sidebar open/close
  const mobileSidebar = document.getElementById('mobileSidebar');
  document.getElementById('openMobile').addEventListener('click', ()=>{ mobileSidebar.classList.remove('hidden'); document.body.style.overflow='hidden'; });
  document.getElementById('mobileClose').addEventListener('click', ()=>{ mobileSidebar.classList.add('hidden'); document.body.style.overflow=''; });
  document.getElementById('ms-backdrop').addEventListener('click', ()=>{ mobileSidebar.classList.add('hidden'); document.body.style.overflow=''; });

  // sample orders data
  const orders = [
    {id:2715, customer:'Rahim Uddin', total:79.90, status:'Processing', date:'2025-12-08'},
    {id:2714, customer:'Fatema Akter', total:34.50, status:'Shipped', date:'2025-12-07'},
    {id:2713, customer:'Jahid Hasan', total:120.00, status:'Completed', date:'2025-12-06'},
    {id:2712, customer:'Anika Sultana', total:12.99, status:'Cancelled', date:'2025-12-05'},
  ];

  function renderOrders(list){
    const tbody = document.getElementById('ordersTable');
    tbody.innerHTML = '';
    list.forEach(o=>{
      const tr = document.createElement('tr');
      tr.className = 'border-b hover:bg-gray-50';
      tr.innerHTML = `
        <td class="p-3">#${o.id}</td>
        <td class="p-3">${o.customer}</td>
        <td class="p-3 font-semibold">$${o.total.toFixed(2)}</td>
        <td class="p-3"><span class="px-2 py-1 rounded text-xs ${o.status==='Completed'?'bg-green-100 text-green-700': o.status==='Shipped'?'bg-blue-100 text-blue-700': o.status==='Processing'?'bg-yellow-100 text-yellow-700':'bg-red-100 text-red-700'}">${o.status}</span></td>
        <td class="p-3">${o.date}</td>
        <td class="p-3"><button data-id="${o.id}" class="viewBtn px-3 py-1 bg-indigo-50 text-indigo-700 rounded text-sm">View</button></td>
      `;
      tbody.appendChild(tr);
    });
  }

  renderOrders(orders);

  // filter orders
  document.getElementById('ordersFilter').addEventListener('input', (e)=>{
    const q = e.target.value.toLowerCase();
    renderOrders(orders.filter(o=> (''+o.id).includes(q) || o.customer.toLowerCase().includes(q)));
  });

  // refresh (demo)
  document.getElementById('refreshOrders').addEventListener('click', ()=>{
    // in real app you'd fetch fresh data via AJAX
    alert('Orders refreshed (demo).');
  });

  // demo products
  const products = [
    {id:101, name:'Wireless Headphone', price:59.99, stock:120, thumb:'https://via.placeholder.com/80'},
    {id:102, name:'Smart Watch', price:89.99, stock:32, thumb:'https://via.placeholder.com/80'},
    {id:103, name:'Bluetooth Speaker', price:29.50, stock:74, thumb:'https://via.placeholder.com/80'}
  ];

  function renderProducts(){
    const wrap = document.getElementById('productList');
    wrap.innerHTML = '';
    products.forEach(p=>{
      const el = document.createElement('div');
      el.className = 'flex items-center gap-3';
      el.innerHTML = `
        <img src="${p.thumb}" class="w-12 h-12 object-cover rounded">
        <div class="flex-1">
          <div class="font-medium">${p.name}</div>
          <div class="text-xs text-gray-500">$${p.price.toFixed(2)} • ${p.stock} in stock</div>
        </div>
        <div class="flex gap-2">
          <button class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded text-sm">Edit</button>
          <button class="px-2 py-1 bg-red-100 text-red-800 rounded text-sm">Delete</button>
        </div>
      `;
      wrap.appendChild(el);
    });
  }
  renderProducts();

  // small UX: global search focus clears
  document.getElementById('globalSearch').addEventListener('keydown', (e)=>{
    if (e.key === 'Enter') {
      const q = e.target.value.trim().toLowerCase();
      // just demo: filter products by name
      const filtered = products.filter(p=> p.name.toLowerCase().includes(q));
      if (filtered.length) {
        // show first product in right pane (simple behaviour)
        alert('Found '+filtered.length+' product(s). (demo)');
      } else {
        alert('No results found (demo).');
      }
    }
  });
</script>

</body>
</html>
