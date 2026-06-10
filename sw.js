/**
 * KoraStream Service Worker
 */

const CACHE_NAME = 'korastream-v1';
const ASSETS = [
  'public/index.php',
  'public/assets/css/tailwind-custom.css',
  'public/assets/js/main.js',
  'public/assets/js/bottom-sheet.js',
  'manifest.json'
];

// Install Event
self.addEventListener('install', e => {
  e.waitUntil(
    caches.open(CACHE_NAME).then(cache => {
      return cache.addAll(ASSETS);
    }).then(() => self.skipWaiting())
  );
});

// Activate Event
self.addEventListener('activate', e => {
  e.waitUntil(
    caches.keys().then(keys => {
      return Promise.all(
        keys.map(key => {
          if (key !== CACHE_NAME) {
            return caches.delete(key);
          }
        })
      );
    }).then(() => self.clients.claim())
  );
});

// Fetch Event
self.addEventListener('fetch', e => {
  // Let the browser handle standard POST requests and admin pages dynamically
  if (e.request.method !== 'GET' || e.request.url.includes('page=admin')) {
    return;
  }
  
  e.respondWith(
    caches.match(e.request).then(cachedResponse => {
      return cachedResponse || fetch(e.request).catch(() => {
        // Fallback for offline if necessary
      });
    })
  );
});
