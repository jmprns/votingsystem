<!DOCTYPE html>
<html>
<head>
	<title>Printable Voter</title>

	<link rel="shortcut icon" href="{{ asset('media/favicon.ico') }}">

	<!-- DataTables -->
    <link href="{{ asset('vendor') }}/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('vendor') }}/datatables/buttons.bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('vendor') }}/datatables/fixedHeader.bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('vendor') }}/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('vendor') }}/datatables/scroller.bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('vendor') }}/datatables/dataTables.colVis.css" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('vendor') }}/datatables/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('vendor') }}/datatables/fixedColumns.dataTables.min.css" rel="stylesheet" type="text/css"/>

	<link href="{{ asset('css/admin/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/admin/core.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/admin/components.css') }}" rel="stylesheet" type="text/css" />

</head>
<body>

<div class="row">
                            <div class="col-sm-12">
                                <div class="card-box table-responsive">
                                    <h4 class="m-t-0 header-title"><b>Printable Voters</b></h4>
                                    <p class="text-muted font-13 m-b-30">
                                        Search in the name of the election in the bar to filter the results or click the table headings to filter the ordering of the table.
                                    </p>

                                    <table id="datatable-buttons" class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th>User ID</th>
                                            <th>Password</th>
                                            <th>Name</th>
                                            <th>D-Y</th>
                                            <th>Election</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                       		@foreach($voters as $voter)
                                       			<tr>
                                       				<td><b>User ID: </b>{{ $voter->id }}</td>
                                       				<td><b>Password: </b>{{ $voter->alias }}</td>
                                                    <td>{{ $voter->lname }}, {{ $voter->fname }}</td>
                                       				<td>{{ $voter->year->department->dept_name }} - {{ $voter->year->year_name }}</td>
                                       				<td>{{ $voter->elc->elc_name }}</td>
                                       			</tr>
                                       		@endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>





<!-- jQuery  -->
<script src="{{ asset('js/admin/jquery.min.js') }}"></script>
<script src="{{ asset('js/admin/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/admin/detect.js') }}"></script>
<script src="{{ asset('js/admin/fastclick.js') }}"></script>
<script src="{{ asset('js/admin/jquery.blockUI.js') }}"></script>
<script src="{{ asset('js/admin/waves.js') }}"></script>
<script src="{{ asset('js/admin/jquery.slimscroll.js') }}"></script>
<script src="{{ asset('js/admin/jquery.scrollTo.min.js') }}"></script>

<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap.js') }}"></script>


<script src="{{ asset('vendor') }}/datatables/jquery.dataTables.min.js"></script>
<script src="{{ asset('vendor') }}/datatables/dataTables.bootstrap.js"></script>

<script src="{{ asset('vendor') }}/datatables/dataTables.buttons.min.js"></script>
<script src="{{ asset('vendor') }}/datatables/buttons.bootstrap.min.js"></script>
<script src="{{ asset('vendor') }}/datatables/jszip.min.js"></script>
<script src="{{ asset('vendor') }}/datatables/pdfmake.min.js"></script>
<script src="{{ asset('vendor') }}/datatables/vfs_fonts.js"></script>
<script src="{{ asset('vendor') }}/datatables/buttons.html5.min.js"></script>
<script src="{{ asset('vendor') }}/datatables/buttons.print.min.js"></script>
<script src="{{ asset('vendor') }}/datatables/dataTables.fixedHeader.min.js"></script>
<script src="{{ asset('vendor') }}/datatables/dataTables.keyTable.min.js"></script>
<script src="{{ asset('vendor') }}/datatables/dataTables.responsive.min.js"></script>
<script src="{{ asset('vendor') }}/datatables/responsive.bootstrap.min.js"></script>
<script src="{{ asset('vendor') }}/datatables/dataTables.scroller.min.js"></script>
<script src="{{ asset('vendor') }}/datatables/dataTables.colVis.js"></script>
<script src="{{ asset('vendor') }}/datatables/dataTables.fixedColumns.min.js"></script>

<script src="{{ asset('js/admin/datatable.button.js') }}"></script>

<!-- App js -->
<script src="{{ asset('js/admin/jquery.core.js') }}"></script>
<script src="{{ asset('js/admin/jquery.app.js') }}"></script>

<script type="text/javascript">
            $(document).ready(function () {
                $('#datatable').dataTable();
                $('#datatable-keytable').DataTable({keys: true});
                $('#datatable-responsive').DataTable();
                $('#datatable-colvid').DataTable({
                    "dom": 'C<"clear">lfrtip',
                    "colVis": {
                        "buttonText": "Change columns"
                    }
                });
                $('#datatable-scroller').DataTable({
                    ajax: "../plugins/datatables/json/scroller-demo.json",
                    deferRender: true,
                    scrollY: 380,
                    scrollCollapse: true,
                    scroller: true
                });
                var table = $('#datatable-fixed-header').DataTable({fixedHeader: true});
                var table = $('#datatable-fixed-col').DataTable({
                    scrollY: "300px",
                    scrollX: true,
                    scrollCollapse: true,
                    paging: false,
                    fixedColumns: {
                        leftColumns: 1,
                        rightColumns: 1
                    }
                });
            });
            TableManageButtons.init();

        </script>
</body>
</html>