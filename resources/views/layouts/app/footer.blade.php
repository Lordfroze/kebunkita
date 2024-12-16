</div><!-- /.content-wrapper -->
<!-- Footer -->
<!-- Main Footer -->
<footer class="main-footer">
  <!-- To the right -->
  <div class="float-right d-none d-sm-inline">
    solusi agribisnis milenial
  </div>
  <!-- Default to the left -->
  <strong>Copyright &copy; 2024 <a href="{{url('dashboard')}}">Yogatama_KebunKita</a>.</strong> All rights reserved.
</footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- fontawesome -->
<script src="https://kit.fontawesome.com/ab6a36f250.js" crossorigin="anonymous"></script>
<!-- chartjs -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- jQuery -->
<script src="{{ asset('lte/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('lte/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('lte/dist/js/adminlte.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.min.js" integrity="sha512-L0Shl7nXXzIlBSUUPpxrokqq4ojqgZFQczTYlGjzONGTDAcLremjwaWv5A+EDLnxhQzY5xUZPWLOLqYRkY0Cbw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- Dark Mode -->
<script>
  // Function to toggle dark mode
  function toggleDarkMode() {
    document.getElementById('body').classList.toggle('dark-mode');
    const isDarkMode = document.getElementById('body').classList.contains('dark-mode');
    localStorage.setItem('darkMode', isDarkMode);
  }

  // Check and apply user's preference on page load
  document.addEventListener('DOMContentLoaded', function() {
    const isDarkMode = localStorage.getItem('darkMode') === 'true';
    if (isDarkMode) {
      document.getElementById('body').classList.add('dark-mode');
    }
  });

  // Add click event listener to the toggle button
  document.getElementById('darkModeToggle').addEventListener('click', toggleDarkMode);
</script>

</body>

</html>
<!-- Footer End -->