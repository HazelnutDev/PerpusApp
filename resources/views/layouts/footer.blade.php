<!-- Footer -->
<footer class="content-footer footer bg-footer-theme">
  <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
    <div class="mb-2 mb-md-0">
      ©
      <script>
        document.write(new Date().getFullYear());
      </script>
      , Copyright By
      <a href="https://github.com/Hazelnut-dev?tab=repositories" target="_blank" class="footer-link fw-bolder">Akhbar Hidayat</a>
    </div>
    <div>
      <a href="https://github.com/Hazelnut-dev?tab=repositories" class="footer-link me-4" target="_blank">Github</a>
      <a href="https://www.instagram.com/akbardirgantara21?utm_source=qr&igsh=M3lvenV3cnZ3Zmpl " target="_blank" class="footer-link me-4">Instagram</a>

      <a
        href="https://github.com/Hazelnut-dev/PerpusApp/issues"
        target="_blank"
        class="footer-link me-4"
        >Support</a
      >
    </div>
  </div>
</footer>
<!-- / Footer -->

<div class="content-backdrop fade"></div>
</div>
<!-- Content wrapper -->
</div>
<!-- / Layout page -->
</div>

<!-- Overlay -->
<div class="layout-overlay layout-menu-toggle"></div>
</div>
<!-- / Layout wrapper -->


<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->
<script src="{{asset('sneat')}}/assets/vendor/libs/jquery/jquery.js"></script>
<script src="{{asset('sneat')}}/assets/vendor/libs/popper/popper.js"></script>
<script src="{{asset('sneat')}}/assets/vendor/js/bootstrap.js"></script>
<script src="{{asset('sneat')}}/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

<script src="{{asset('sneat')}}/assets/vendor/js/menu.js"></script>
<!-- endbuild -->

<!-- Vendors JS -->
<script src="{{asset('sneat')}}/assets/vendor/libs/apex-charts/apexcharts.js"></script>

<!-- Main JS -->
<script src="{{asset('sneat')}}/assets/js/main.js"></script>

<!-- Page JS -->
<script src="{{asset('sneat')}}/assets/js/dashboards-analytics.js"></script>

<script>
  function clock() {
      var time = new Date(),
          hours = time.getHours(),
          minutes = time.getMinutes(),
          seconds = time.getSeconds();
  
      var ampm = hours >= 12 ? 'PM' : 'AM'; // Menentukan apakah pagi atau sore
  
      hours = hours % 12;
      hours = hours ? hours : 12; // Format jam 12 jam
  
      document.querySelectorAll('.clock')[0].innerHTML = harold(hours) + ":" + harold(minutes) + ":" + harold(seconds) + " " + ampm;
  
      function harold(standIn) {
          if (standIn < 10) {
              standIn = '0' + standIn
          }
          return standIn;
      }
  }
  setInterval(clock, 1000);
  </script>
</body>
</html>
