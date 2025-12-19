<!-- Bootstrap bundle JS -->
<script src="{{ asset('admin/assets/js/bootstrap.bundle.min.js') }}"></script>

<!--plugins-->
<script src="{{ asset('admin/assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('admin/assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
<script src="{{ asset('admin/assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
<script src="{{ asset('admin/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
<script src="{{ asset('admin/assets/js/pace.min.js') }}"></script>

{{-- chart --}}
<script src="{{ asset('admin/assets/plugins/chartjs/js/Chart.min.js') }}"></script>
<script src="{{ asset('admin/assets/plugins/chartjs/js/Chart.extension.js') }}"></script>
<script src="{{ asset('admin/assets/plugins/apexcharts-bundle/js/apexcharts.min.js') }}"></script>

{{-- datatable --}}
<script src="{{ asset('admin/assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin/assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/table-datatable.js') }}"></script>

<!--app-->
<script src="{{ asset('admin/assets/js/app.js') }}"></script>
<script src="{{ asset('admin/assets/js/index2.js') }}"></script>
<script>
    new PerfectScrollbar(".best-product")
</script>
@yield('scripts')

@stack('scripts')
