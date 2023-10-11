$(".card-thing").hover(
    () => {
        $(".card-footer-thing").removeClass("d-none");
    },
    () => {
        $(".card-footer-thing").addClass("d-none");
    }
);
const showRealTime = () => {
    var time = new Date();
    var timeid = time.toLocaleTimeString();
    $('.time-realtime').html(timeid);
}

showRealTime();
$(document).ready(function () {
    const showtime = () => {
        var timeinterval = setInterval(() => {
            $("#successupdate").addClass("success-none");
            clearInterval(timeinterval);
        }, 3000);

        var timeinterval2 = setInterval(() => {
            $("#successupdate").addClass("d-none");
            clearInterval(timeinterval2);
        }, 5000);
    };

    var timeinterval3 = setInterval(() => {
        showRealTime();
    }, 1000);

    if ($("#successupdate").hasClass("success-update")) return showtime();

    $("#laporan-lelang-bulanan").DataTable({
        pageLength: 10,
        paging: true,
        dom: "Bfrtip",
        buttons: [
            //'copyHtml5',
            //'excelHtml5',
            //'csvHtml5',
            {
                extend: "pdfHtml5",
                text: "Download PDF",
                className: "btn-success",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5],
                },
            },
            {
                extend: "print",
                text: "Print Preview",
                className: "btn-secondary",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5],
                },
            },
        ],
    });

    $("#laporan-lelang-mingguan").DataTable({
        pageLength: 10,
        paging: true,
        dom: "Bfrtip",
        buttons: [
            //'copyHtml5',
            //'excelHtml5',
            //'csvHtml5',
            {
                extend: "pdfHtml5",
                text: "Download PDF",
                className: "btn-success",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5],
                },
            },
            {
                extend: "print",
                text: "Print Preview",
                className: "btn-secondary",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5],
                },
            },
        ],
    });

    $("#laporan-lelang-harian").DataTable({
        pageLength: 10,
        paging: true,
        dom: "Bfrtip",
        buttons: [
            //'copyHtml5',
            //'excelHtml5',
            //'csvHtml5',
            {
                extend: "pdfHtml5",
                text: "Download PDF",
                className: "btn-success",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5],
                },
            },
            {
                extend: "print",
                text: "Print Preview",
                className: "btn-secondary",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5],
                },
            },
        ],
    });

    $("#table-verifikasi").DataTable({
        pageLength: 10,
        paging: true,
        dom: "Bfrtip",
        buttons: [
            //'copyHtml5',
            //'excelHtml5',
            //'csvHtml5',
            {
                extend: "pdfHtml5",
                text: "Download PDF",
                className: "btn-success",
                exportOptions: {
                    columns: [0, 1, 2, 3],
                },
            },
            {
                extend: "print",
                text: "Print Preview",
                className: "btn-secondary",
                exportOptions: {
                    columns: [0, 1, 2, 3],
                },
            },
        ],
    });

    $("#laporan-barang-saya").DataTable({
        serverSide: false,
        pageLength: 5,
        paging: true,
        dom: "Bfrtip",
        buttons: [
            //'copyHtml5',
            //'excelHtml5',
            //'csvHtml5',
            {
                extend: "pdfHtml5",
                text: "Download PDF",
                className: "btn-success",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4],
                },
            },
            {
                extend: "print",
                text: "Print Preview",
                className: "btn-secondary",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4],
                },
            },
        ],
    });

    $("#laporan-lelang-admin-harian").DataTable({
        pageLength: 10,
        paging: true,
        dom: "Bfrtip",
        buttons: [
            //'copyHtml5',
            //'excelHtml5',
            //'csvHtml5',
            {
                extend: "pdfHtml5",
                text: "Download PDF",
                className: "btn-success",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5],
                },
            },
            {
                extend: "print",
                text: "Print Preview",
                className: "btn-secondary",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5],
                },
            },
        ],
    });

    $("#laporan-lelang-admin-mingguan").DataTable({
        pageLength: 10,
        paging: true,
        dom: "Bfrtip",
        buttons: [
            //'copyHtml5',
            //'excelHtml5',
            //'csvHtml5',
            {
                extend: "pdfHtml5",
                text: "Download PDF",
                className: "btn-success",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5],
                },
            },
            {
                extend: "print",
                text: "Print Preview",
                className: "btn-secondary",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5],
                },
            },
        ],
    });

    $("#laporan-lelang-admin-bulanan").DataTable({
        pageLength: 10,
        paging: true,
        dom: "Bfrtip",
        buttons: [
            //'copyHtml5',
            //'excelHtml5',
            //'csvHtml5',
            {
                extend: "pdfHtml5",
                text: "Download PDF",
                className: "btn-success",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5],
                },
            },
            {
                extend: "print",
                text: "Print Preview",
                className: "btn-secondary",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4],
                },
            },
        ],
    });

    $("#table-penawaran-saya").DataTable({
        pageLength: 10,
        paging: true,
        dom: "Bfrtip",
        buttons: [
            {
                extend: "pdfHtml5",
                text: "Download PDF",
                className: "btn-success",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4],
                },
            },
            {
                extend: "print",
                text: "Print Preview",
                className: "btn-secondary",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4],
                },
            },
        ],
        responsive: true,
    });

    $("#laporan-lelang-penjual").DataTable({
        pageLength: 5,
        paging: true,
        dom: "Bfrtip",
        buttons: [
            {
                extend: "pdfHtml5",
                text: "Download PDF",
                className: "btn-success",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5],
                },
            },
            {
                extend: "print",
                text: "Print Preview",
                className: "btn-secondary",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5 ],
                },
            },
        ],
    });

    $("#table-request-barang").DataTable({
        serverSide: false,
        pageLength: 50,
        paging: true,
        dom: "Bfrtip",
        buttons: [
            
        ],
    });

    const popoverTriggerList = document.querySelectorAll(
        '[data-bs-toggle="popover"]'
    );
    const popoverList = [...popoverTriggerList].map(
        (popoverTriggerEl) => new bootstrap.Popover(popoverTriggerEl)
    );
});
