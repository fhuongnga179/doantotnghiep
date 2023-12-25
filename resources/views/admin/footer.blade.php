<!-- jQuery -->
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<!-- Bootstrap 4 -->
<script src="/template/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- DataTables and related plugins -->
<script src="/template/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/template/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="/template/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="/template/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="/template/admin/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="/template/admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="/template/admin/plugins/jszip/jszip.min.js"></script>
<script src="/template/admin/plugins/pdfmake/pdfmake.min.js"></script>
<script src="/template/admin/plugins/pdfmake/vfs_fonts.js"></script>
<script src="/template/admin/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="/template/admin/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="/template/admin/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>


{{-- Charts --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- AdminLTE App -->
<script src="/template/admin/dist/js/adminlte.min.js?v=3.2.0"></script>

<!-- Include other DataTables extensions here -->

<!-- Your custom scripts -->
<script src="/template/admin/js/main.js"></script>
<script>
    (function(w, d) {
        ! function(dg, dh, di, dj) {
            dg[di] = dg[di] || {};
            dg[di].executed = [];
            dg.zaraz = {
                deferred: [],
                listeners: []
            };
            dg.zaraz.q = [];
            dg.zaraz._f = function(dk) {
                return async function() {
                    var dl = Array.prototype.slice.call(arguments);
                    dg.zaraz.q.push({
                        m: dk,
                        a: dl
                    })
                }
            };
            for (const dm of ["track", "set", "debug"]) dg.zaraz[dm] = dg.zaraz._f(dm);
            dg.zaraz.init = () => {
                var dn = dh.getElementsByTagName(dj)[0],
                    dp = dh.createElement(dj),
                    dq = dh.getElementsByTagName("title")[0];
                dq && (dg[di].t = dh.getElementsByTagName("title")[0].text);
                dg[di].x = Math.random();
                dg[di].w = dg.screen.width;
                dg[di].h = dg.screen.height;
                dg[di].j = dg.innerHeight;
                dg[di].e = dg.innerWidth;
                dg[di].l = dg.location.href;
                dg[di].r = dh.referrer;
                dg[di].k = dg.screen.colorDepth;
                dg[di].n = dh.characterSet;
                dg[di].o = (new Date).getTimezoneOffset();
                if (dg.dataLayer)
                    for (const du of Object.entries(Object.entries(dataLayer).reduce(((dv, dw) => ({
                            ...dv[1],
                            ...dw[1]
                        })), {}))) zaraz.set(du[0], du[1], {
                        scope: "page"
                    });
                dg[di].q = [];
                for (; dg.zaraz.q.length;) {
                    const dx = dg.zaraz.q.shift();
                    dg[di].q.push(dx)
                }
                dp.defer = !0;
                for (const dy of [localStorage, sessionStorage]) Object.keys(dy || {}).filter((dA => dA
                    .startsWith("_zaraz_"))).forEach((dz => {
                    try {
                        dg[di]["z_" + dz.slice(7)] = JSON.parse(dy.getItem(dz))
                    } catch {
                        dg[di]["z_" + dz.slice(7)] = dy.getItem(dz)
                    }
                }));
                dp.referrerPolicy = "origin";
                dp.src = "/cdn-cgi/zaraz/s.js?z=" + btoa(encodeURIComponent(JSON.stringify(dg[di])));
                dn.parentNode.insertBefore(dp, dn)
            };
            ["complete", "interactive"].includes(dh.readyState) ? zaraz.init() : dg.addEventListener(
                "DOMContentLoaded", zaraz.init)
        }(w, d, "zarazData", "script");
    })(window, document);
</script>


<script>
    $(document).ready(function() {
        console.log("Initializing DataTables...");
        // Destroy existing DataTable instance

        var table = $("#example1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["excel", "pdf", "print"]
        });

        table.buttons().container().appendTo('.dataTables_wrapper .col-md-6:eq(0)');

        console.log("DataTables initialized successfully.");

    });
</script>


<!-- Additional scripts from the yield section -->
@yield('footer')
