@extends('layouts.master')
@section('css')
    <!---Internal  Prism css-->
    <link href="{{ URL::asset('assets/plugins/prism/prism.css') }}" rel="stylesheet">
    <!---Internal Input tags css-->
    <link href="{{ URL::asset('assets/plugins/inputtags/inputtags.css') }}" rel="stylesheet">
    <!--- Custom-scroll -->
    <link href="{{ URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.css') }}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        @if (session()->has('Add'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{ session()->get('Add') }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if (session()->has('delete'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>{{ session()->get('delete') }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">قائمة الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    تفاصيل فاتورة</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <div class="panel panel-primary tabs-style-2">
        <div class=" tab-menu-heading">
            <div class="tabs-menu1">
                <!-- Tabs -->
                <ul class="nav panel-tabs main-nav-line">
                    <li><a href="#tab4" class="nav-link active" data-toggle="tab">معلومات الفاتورة</a></li>
                    <li><a href="#tab5" class="nav-link" data-toggle="tab">حالات الدفع</a></li>
                    <li><a href="#tab6" class="nav-link" data-toggle="tab">المرفقات</a></li>
                </ul>
            </div>
        </div>
        <div class="panel-body tabs-menu-body main-content-body-right border">
            <div class="tab-content">
                <div class="tab-pane active" id="tab4">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="row">رقم الفاتورة</th>
                                <td>{{ $invoice->invoice_number }}</td>
                                <th scope="row">تاريخ الاصدار</th>
                                <td>{{ $invoice->invoice_date }}</td>
                                <th scope="row">تاريخ الاستحقاق</th>
                                <td>{{ $invoice->due_date }}</td>
                                <th scope="row">القسم</th>
                                <td>{{ $invoice->Section->section_name }}</td>
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <th scope="row">المنتج</th>
                                <td>{{ $invoice->product }}</td>
                                <th scope="row">مبلغ التحصيل</th>
                                <td>{{ $invoice->amount_collection }}</td>
                                <th scope="row">مبلغ العمولة</th>
                                <td>{{ $invoice->amount_commission }}</td>
                                <th scope="row">الخصم</th>
                                <td>{{ $invoice->discount }}</td>

                            </tr>

                            <tr>
                                <th scope="row">نسبة الضريبة</th>
                                <td>{{ $invoice->rate_vat }}</td>
                                <th scope="row">قيمة الضريبة</th>
                                <td>{{ $invoice->value_vat }}</td>
                                <th scope="row">الإجمالي مع الضريبة</th>
                                <td>{{ $invoice->total }}</td>
                                <th scope="row">الحالة الحالية</th>
                                @if ($invoice->value_status == 1)
                                    <td>
                                        <span class="badge badge-pill badge-success">{{ $invoice->status }}</span>
                                    </td>
                                @elseif($invoice->value_status == 2)
                                    <td>
                                        <span class="badge badge-pill badge-danger">{{ $invoice->status }}</span>
                                    </td>
                                @else
                                    <td>
                                        <span class="badge badge-pill badge-warning">{{ $invoice->status }}</span>
                                    </td>
                                @endif
                            </tr>
                            <tr>
                                <th scope="row">ملاحظات</th>
                                <td>{{ $invoice->note }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane" id="tab5">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="row">#</th>
                                <th scope="row">رقم الفاتورة</th>
                                <th scope="row">نوع المنتج</th>
                                <th scope="row">القسم</th>
                                <th scope="row">حالة الدفع</th>
                                <th scope="row">تاريخ الدفع</th>
                                <th scope="row">ملاحظات</th>
                                <th scope="row">تاريخ الاضافة</th>
                                <th scope="row">المستخدم</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 0;
                            @endphp
                            @foreach ($details as $item)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $item->invoice_number }}</td>
                                    <td>{{ $item->product }}</td>
                                    <td>{{ $invoice->Section->section_name }}</td>
                                    @if ($item->value_status == 1)
                                        <td>
                                            <span class="badge badge-pill badge-success">{{ $item->status }}</span>
                                        </td>
                                    @elseif($item->value_status == 2)
                                        <td>
                                            <span class="badge badge-pill badge-danger">{{ $item->status }}</span>
                                        </td>
                                    @else
                                        <td>
                                            <span class="badge badge-pill badge-warning">{{ $item->status }}</span>
                                        </td>
                                    @endif
                                    <td></td>
                                    <td>{{ $item->note }}</td>
                                    <td>{{ $item->created_at }}</td>
                                    <td>{{ $item->users->name }}</td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                <div class="tab-pane" id="tab6">
                    <!--المرفقات-->
                    <div class="card card-statistics">

                        <div class="card-body">
                            <p class="text-danger">* صيغة المرفق pdf, jpeg ,.jpg , png </p>
                            <h5 class="card-title">اضافة مرفقات</h5>
                            <form method="post" action="{{ url('/invoice_attachments') }}" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="customFile" name="file_name"
                                        required>
                                    <input type="hidden" id="customFile" name="invoice_number"
                                        value="{{ $invoice->invoice_number }}">
                                    <input type="hidden" id="invoice_id" name="invoice_id" value="{{ $invoice->id }}">
                                    <label class="custom-file-label" for="customFile">حدد
                                        المرفق</label>
                                </div><br><br>
                                <button type="submit" class="btn btn-primary btn-sm " name="uploadedFile">تاكيد</button>
                            </form>
                        </div>

                        <br>
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th scope="row">#</th>
                                    <th scope="row">اسم الملف</th>
                                    <th scope="row">قام بالاضافة</th>
                                    <th scope="row">تاريخ الاضافة</th>
                                    <th scope="row" colspan="3">اختر</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 0;
                                @endphp
                                @foreach ($attachments as $attachment)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $attachment->file_name }}</td>
                                        <td>{{ $attachment->users->name }}</td>
                                        <td>{{ $attachment->created_at }}</td>
                                        <td style="text-align: center"><a class="btn btn-info btn-sm"
                                                href="{{ url('view_file') }}/{{ $invoice->invoice_number }}/{{ $attachment->file_name }}">عرض</a>
                                        </td>
                                        <td style="text-align: center"><a class="btn btn-success btn-sm"
                                                href="{{ url('download_file') }}/{{ $invoice->invoice_number }}/{{ $attachment->file_name }}">تحميل</a>
                                        </td>
                                        <td style="text-align: center">


                                            <button class="btn btn-danger btn-sm" data-toggle="modal"
                                                data-file_name="{{ $attachment->file_name }}"
                                                data-invoice_number="{{ $invoice->invoice_number }}"
                                                data-id_file="{{ $attachment->id }}"
                                                data-target="#delete_file">حذف</button>

                                        </td>
                                    </tr>
                                @endforeach


                                <!-- delete -->
                                <div class="modal fade" id="delete_file" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">حذف المرفق</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{ route('delete_file') }}" method="post">

                                                {{ csrf_field() }}
                                                <div class="modal-body">
                                                    <p class="text-center">
                                                    <h6 style="color:red"> هل انت متاكد من عملية حذف المرفق ؟</h6>
                                                    </p>

                                                    <input type="hidden" name="id_file" id="id_file" value="">
                                                    <input type="hidden" name="file_name" id="file_name"
                                                        value="">
                                                    <input type="hidden" name="invoice_number" id="invoice_number"
                                                        value="">

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default"
                                                        data-dismiss="modal">الغاء</button>
                                                    <button type="submit" class="btn btn-danger">تاكيد</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                    </div>
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!-- Internal Select2 js-->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!-- Internal Jquery.mCustomScrollbar js-->
    <script src="{{ URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <!-- Internal Input tags js-->
    <script src="{{ URL::asset('assets/plugins/inputtags/inputtags.js') }}"></script>
    <!--- Tabs JS-->
    <script src="{{ URL::asset('assets/plugins/tabs/jquery.multipurpose_tabcontent.js') }}"></script>
    <script src="{{ URL::asset('assets/js/tabs.js') }}"></script>
    <!--Internal  Clipboard js-->
    <script src="{{ URL::asset('assets/plugins/clipboard/clipboard.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/clipboard/clipboard.js') }}"></script>
    <!-- Internal Prism js-->
    <script src="{{ URL::asset('assets/plugins/prism/prism.js') }}"></script>
    <script>
        $('#delete_file').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id_file = button.data('id_file')
            var file_name = button.data('file_name')
            var invoice_number = button.data('invoice_number')
            var modal = $(this)

            modal.find('.modal-body #id_file').val(id_file);
            modal.find('.modal-body #file_name').val(file_name);
            modal.find('.modal-body #invoice_number').val(invoice_number);
        })
    </script>

    <script>
        // Add the following code if you want the name of the file appear on select
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
    </script>
@endsection
