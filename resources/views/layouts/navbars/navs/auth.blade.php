

@push('scripts')
@if(auth()->check() && auth()->user()->role === 'siswa')
<script>
document.addEventListener('DOMContentLoaded', function () {
  function updateUnreadNotifications() {
    fetch(@json(route('siswa.notifikasi.unreadCount')))
      .then(function (response) { return response.json(); })
      .then(function (data) {
        var badge = document.querySelector('.notification-badge');
        if (!badge) return;
        if (data.count > 0) {
          badge.textContent = data.count;
          badge.style.display = 'inline-block';
        } else {
          badge.style.display = 'none';
        }
      })
      .catch(function () {
        // silently ignore errors
      });
  }

  updateUnreadNotifications();
  setInterval(updateUnreadNotifications, 30000);
});
</script>
@endif
@endpush

