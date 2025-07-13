const MOBILE_BREAKPOINT = 768;
const d = document;
d.addEventListener('DOMContentLoaded', () => {
  d.addEventListener("click", (e) => {
    if (
      e.target.classList.contains('dashboard-overlay') ||
      e.target.classList.contains('menu-toggle')
    ) {
      toggleSidebar();
    }
  })
});

function toggleSidebar () {
  const sidebar = d.getElementById('sidebar');
  const overlay = d.getElementById('dashboardOverlay');
  const isMobile = window.innerWidth <= MOBILE_BREAKPOINT;

  if (isMobile) {
    sidebar.classList.toggle('active');
    overlay.classList.toggle('active');
    // prevent scrolling on body when sidebar is open on mobile
    d.body.style.overflow = sidebar.classList.contains('active') ? 'hidden' : '';
  }
}