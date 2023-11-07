@extends('layouts.master')
@section('title')
    الفواتير _ برنامج الفواتير
@endsection
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ قائمه
                    الفواتير</span>
            </div>
        </div>

        {{-- ************************************ --}}



    @section('page-header')
        <!-- breadcrumb -->
        <div class="breadcrumb-header justify-content-between">
            <div class="my-auto">
                <div class="d-flex">
                    <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">
                        @if (isset($status_view))
                            {{ '/' . $status_view }}
                        @else
                            /قائمة الفواتير
                        @endif

                    </span>
                </div>
            </div>
            @can('تصدير EXCEL')
                <a class="modal-effect btn btn-sm btn-primary" href="{{ url('export_invoices') }}" style="color:white"><i
                        class="fas fa-file-download"></i>&nbsp;تصدير اكسيل</a>
            @endcan
        </div>
        <!-- breadcrumb -->
    @endsection
    @section('content')
        @if (session()->has('edit'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{ session()->get('edit') }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif


        @if (session()->has('delete_invoice'))
            <script>
                window.onload = function() {
                    notif({
                        msg: "تم حذف الفاتورة بنجاح",
                        type: "success"
                    })
                }
            </script>
        @endif
        @if (session()->has('Status_Update'))
            <script>
                window.onload = function() {
                    notif({
                        msg: "تم تغير حاله الفاتوره بنجاح",
                        type: "success"
                    })
                }
            </script>
        @endif

        <!-- row opened -->
        <div class="row row-sm">


            <!--div-->
            <div class="col-xl-12">
                <div class="card mg-b-20">
                    <div class="card-header pb-0">

                    </div>
                    @can('اضافة فاتورة')
                        <a class="btn btn-outline-primary" href="invoices/create"><b>اضافه فاتوره</a>
                    @endcan


                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example1" class="table key-buttons text-md-nowrap" data-page-length="50">
                                <thead>
                                    <tr>
                                        <th class="border-bottom-0">#</th>
                                        <th class="border-bottom-0">رقم الفاتوره</th>
                                        <th class="border-bottom-0">تاريخ الفاتوره</th>
                                        <th class="border-bottom-0">تاريخ الأستحقاق</th>
                                        <th class="border-bottom-0">المنتج</th>
                                        <th class="border-bottom-0">القسم</th>

                                        <th class="border-bottom-0">الخصم</th>
                                        <th class="border-bottom-0">نسبه الضريبه</th>
                                        <th class="border-bottom-0">قيمه الضريبه</th>
                                        <th class="border-bottom-0">الأجمالي </th>
                                        <th class="border-bottom-0">الحاله</th>
                                        <th class="border-bottom-0">ملاحظلات</th>
                                        <th class="border-bottom-0">العمليات</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $x = 0; ?>


                                    @foreach ($invoices as $inv)
                                        <?php $x++; ?>

                                        <tr>
                                            <td>{{ $x }}</td>
                                            <td>{{ $inv->invoice_number }}</td>
                                            <td>{{ $inv->invoice_Date }}</td>
                                            <td>{{ $inv->Due_date }}</td>
                                            <td>{{ $inv->product }}</td>
                                            <td>
                                                <a href="{{ route('detalis.edit', $inv->id) }}">
                                                    {{ $inv->section->section_name }}
                                                </a>
                                            </td>
                                            <td>{{ $inv->Amount_collection }}</td>
                                            <td>{{ $inv->Discount }}</td>
                                            <td>{{ $inv->Value_VAT }}</td>
                                            <td>{{ $inv->Total }}</td>
                                            <td>
                                                @if ($inv->Value_Status == 2)
                                                    <p class="text-danger">{{ $inv->Status }} </p>
                                                @elseif ($inv->Value_Status == 1)
                                                    <p class="text-success">{{ $inv->Status }} </p>
                                                @else
                                                    <p class="text-warning">{{ $inv->Status }} </p>
                                                @endif
                                            </td>
                                            <td>{{ $inv->note }}</td>

                                            <td>
                                                <div class="dropdown">
                                                    <button aria-expanded="false" aria-haspopup="true"
                                                        class="btn ripple btn-primary" data-toggle="dropdown"
                                                        id="dropdownMenuButton" type="button">العمليات<i
                                                            class="fas fa-caret-down ml-1"></i></button>
                                                    <div class="dropdown-menu tx-13">
                                                        @can('تعديل الفاتورة')
                                                            <a class="dropdown-item"
                                                                href="{{ route('invoices.edit', $inv->id) }}">تعديل
                                                            </a>
                                                        @endcan

                                                        @can('حذف الفاتورة')
                                                            <a class="dropdown-item" href="#delete_invoice"
                                                                data-invoice_id="{{ $inv->id }}" data-toggle="modal"
                                                                data-target="#delete_invoice"><i
                                                                    class="text-danger fas fa-trash-alt"></i>&nbsp;&nbsp;حذف
                                                                الفاتورة</a>
                                                        @endcan
                                                        @can('تغير حالة الدفع')
                                                            <a class="dropdown-item"
                                                                href="{{ URL::route('Status_show', ['id' => $inv->id]) }}"><i
                                                                    class=" text-success fas
                                                        fa-money-bill"></i>&nbsp;&nbsp;تغير
                                                                حالة
                                                                الدفع</a>
                                                        @endcan
                                                        @can('ارشفة الفاتورة')
                                                            <a class="dropdown-item" href="#"
                                                                data-invoice_id="{{ $inv->id }}" data-toggle="modal"
                                                                data-target="#Transfer_invoice"><i
                                                                    class="text-warning fas fa-exchange-alt"></i>&nbsp;&nbsp;نقل
                                                                الي
                                                                الارشيف</a>
                                                        @endcan



                                                        @can('طباعةالفاتورة')
                                                            <a class="dropdown-item"
                                                                href="Print_invoice/{{ $inv->id }}"><i
                                                                    class="text-success fas fa-print"></i>&nbsp;&nbsp;طباعة
                                                                الفاتورة
                                                            </a>
                                                        @endcan


                                                    </div>
                                                </div>
                                            </td>

                                        </tr>
                                    @endforeach



                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!--/div-->

            <!--div-->

        </div>
        <!-- /row -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->

    <div class="modal fade" id="delete_invoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">حزف نهائي للفاتوره</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <form action="{{ route('invoices.destroy', 'test') }}" method="post">
                        {{ method_field('delete') }}
                        {{ csrf_field() }}
                </div>
                <div class="modal-body">
                    هل انت متاكد من عملية الحذف ؟
                    <input type="hidden" name="invoice_id" id="invoice_id" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                    <button type="submit" class="btn btn-danger">تاكيد</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Archive --}}
    <div class="modal fade" id="Transfer_invoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">ارشفة الفاتورة</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <form action="{{ route('invoices.destroy', 'test') }}" method="post">
                        {{ method_field('delete') }}
                        {{ csrf_field() }}
                </div>
                <div class="modal-body">
                    هل انت متاكد من عملية الارشفة ؟
                    <input type="hidden" name="invoice_id" id="invoice_id" value="">
                    <input type="hidden" name="id_page" id="id_page" value="2">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                    <button type="submit" class="btn btn-success">تاكيد</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection

















{{-- ************************************ --}}








</div>
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
<div class="row">

</div>
<!-- row closed -->
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->
@endsection
@section('js')
<!-- Internal Data tables -->
<script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
<!--Internal  Datatable js -->
<script src="{{ URL::asset('assets/js/table-data.js') }}"></script>

<script>
    $('#delete_invoice').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var invoice_id = button.data('invoice_id')
        var modal = $(this)
        modal.find('.modal-body #invoice_id').val(invoice_id);
    })
</script>
<script>
    $('#Transfer_invoice').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var invoice_id = button.data('invoice_id')
        var modal = $(this)
        modal.find('.modal-body #invoice_id').val(invoice_id);
    })
</script>
@endsection
