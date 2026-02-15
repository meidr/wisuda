<!-- ======= Footer ======= -->
<footer id="footer">
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="footer-info">
                        <h3>Wisuda UII Dalwa</h3>
                        <p>
                            Universitas Islam Internasional <br />
                            Darullughah Wadda'wah<br /><br />
                        </p>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6 footer-links">
                    <h4>Menu Website</h4>
                    <ul>
                        <li>
                            <i class="bx bx-chevron-right"></i> <a href="#">Home</a>
                        </li>
                        <li>
                            <i class="bx bx-chevron-right"></i> <a href="#alur">Alur Pendaftaran</a>
                        </li>
                        <li>
                            <i class="bx bx-chevron-right"></i> <a href="#faq">FAQs</a>
                        </li>
                        <li>
                            <i class="bx bx-chevron-right"></i>
                            <a href="#">Daftar</a>
                        </li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6 footer-links">
                    <h4>Alur Pendaftaran</h4>
                    <ul>
                        <li>
                            <i class="bx bx-chevron-right"></i> <a href="#footer">Daftar</a>
                        </li>
                        <li>
                            <i class="bx bx-chevron-right"></i>
                            <a href="#footer">Isi Formulir</a>
                        </li>
                        <li>
                            <i class="bx bx-chevron-right"></i>
                            <a href="#footer">Cek dan Edit Formulir</a>
                        </li>
                        <li>
                            <i class="bx bx-chevron-right"></i> <a href="#footer">Selesai</a>
                        </li>
                    </ul>
                </div>

                <div class="col-lg-4 col-md-6 footer-newsletter">
                    <h4>Salam hangat</h4>
                    <p>
                        Semoga sistem informasi pendaftaran wisuda ini bermanfaat dan memudahkan kita untuk
                        mendaftar dan mendata pendaftaran wisuda UII Darullugah Wadda'wah.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="copyright">
            &copy; Copyright <strong><span>Tim IT</span></strong>. All Rights Reserved
        </div>
    </div>
</footer>
<!-- End Footer -->

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
        class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
<script src="{{ asset('assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
<script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>

<!-- Template Main JS File -->
<script src="{{ asset('assets/js/main.js') }}"></script>


@if (session('success'))
    <script>
        swal("Sukses", "{{ Session::get('success') }}", "success");
    </script>
@endif

@if (session('error'))
    <script>
        swal("Error", "{{ Session::get('error') }}", "error");
    </script>
@endif
