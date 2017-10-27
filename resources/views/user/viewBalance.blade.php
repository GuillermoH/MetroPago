@extends('layouts.userApp')

@section('head')
    <link rel="stylesheet" href="{{ asset('css/daterangepicker.css') }}">
@endsection

@section('content')
    <section id="funds" class="top-break">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <h3 class="text-primary">Balance</h3><br>
                </div>
                <div class="col-lg-3">
                    <br>
                    <input class="form-control" id="myInput" type="text" placeholder="Buscar..">
                </div>
                <div class="col-lg-4 col-lg-offset-2">
                    <br>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        <input type="text" class="form-control" name="daterange" id="dateInput"/>
                    </div>

                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12" id="balanceTable">
                    <table class="table table-striped table-hover" >
                        <thead>
                        <tr>
                            <th>Negocio</th>
                            <th>tipo / Referencia</th>
                            <th>Monto</th>
                            <th>Fecha</th>
                        </tr>
                        </thead>
                        <tbody data-link="row" class="rowlink" id="myTable">
                        @foreach($balance as $b)
                            <tr>
                                <td>
                                    @if(isset($b->business))
                                        {{ $b->business }}
                                    @endif
                                </td>
                                <td>
                                    @if(isset($b->type))
                                        {{ $b->type." = ".$b->reference }}
                                    @endif
                                </td>
                                <td class="@if($b->amount < 0)
                                    danger
                                @endif">
                                    {{ number_format($b->amount, 2)  }}</td>
                                <td>{{ \Carbon\Carbon::parse($b->created_at)->format('d/m/y h:i:s A') }} </td>
                            </tr>

                        @endforeach

                        </tbody>
                    </table>
                </div>





            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        $(document).ready(function(){

            console.log('11/11/2017' < '10/10/2014');
            $('[data-toggle="tooltip"]').tooltip();

            $("#myInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#myTable tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });


        });


    </script>
    <script src="{{ asset('js/moment.min.js') }}"></script>
    <script src="{{ asset('js/daterangepicker.js') }}"></script>
    <script>
        $(function() {

            var date = new Date(), y = date.getFullYear(), m = date.getMonth();
            var thisMonthfirstDay = new Date(y, m, 1);
            var thisMonthLastDay = new Date(y, m + 1, 0);
            var pastMonthfirstDay = new Date(y, m -1 , 1);
            var pastMonthLastDay = new Date(y, m , 0);

            thisMonthfirstDay = moment(thisMonthfirstDay).format('DD/MM/YY');
            thisMonthLastDay = moment(thisMonthLastDay).format('DD/MM/YY');
            pastMonthfirstDay = moment(pastMonthfirstDay).format('DD/MM/YY');
            pastMonthLastDay = moment(pastMonthLastDay).format('DD/MM/YY');
            today = moment().format('DD/MM/YY');
            sevenDaysAgo = moment().subtract(7,'d').format('DD/MM/YY');

            var datePicker = $('input[name="daterange"]');

            datePicker.daterangepicker({
                "showDropdowns": false,
                "ranges": {
                    "Hoy": [
                        moment().format('DD/MM/YY'),
                        moment().format('DD/MM/YY')
                    ],
                    "Ayer": [
                        moment().subtract(1,'d').format('DD/MM/YY'),
                        moment().subtract(1,'d').format('DD/MM/YY')

                    ],
                    "Ultimos 7 días": [
                        moment().subtract(7,'d').format('DD/MM/YY'),
                        moment().format('DD/MM/YY')
                    ],
                    "Ultimos 30 días": [
                        moment().subtract(30,'d').format('DD/MM/YY'),
                        moment().format('DD/MM/YY')
                    ],
                    "Este Mes": [
                        thisMonthfirstDay,
                        thisMonthLastDay
                    ],
                    "Mes Pasado": [
                        pastMonthfirstDay,
                        pastMonthLastDay
                    ]
                },
                "locale": {
                    "format": "DD/MM/YYYY",
                    "separator": " - ",
                    "applyLabel": "Apply",
                    "cancelLabel": "Cancel",
                    "fromLabel": "From",
                    "toLabel": "To",
                    "customRangeLabel": "Custom",
                    "weekLabel": "W",
                    "daysOfWeek": [
                        "Do",
                        "Lu",
                        "Ma",
                        "Mi",
                        "Ju",
                        "Vi",
                        "Sa"
                    ],
                    "monthNames": [
                        "Enero",
                        "Febrero",
                        "Marzo",
                        "Abril",
                        "Mayo",
                        "Junio",
                        "Julio",
                        "Agosto",
                        "Septiembre",
                        "Octubre",
                        "Noviembre",
                        "Diciembre"
                    ],
                    "firstDay": 1
                },
                "startDate": sevenDaysAgo,
                "endDate": today,
                "maxDate": today,
                "opens": "left"
            }, function(start, end, label) {
                var input, filter, table, tr, td, i;
                input = document.getElementById("dateInput");
                filter = input.value;
                table = document.getElementById("purchasesTable");
                tr = table.getElementsByTagName("tr");
                for (i = 0; i < tr.length; i++) {
                    td = tr[i].getElementsByTagName("td")[3];
                    if (td) {
                        if (moment(td.innerHTML.substring(0,8), 'DD/MM/YY').valueOf() >= moment(start.format('DD/MM/YY'), 'DD/MM/YY').valueOf()
                                && moment(td.innerHTML.substring(0,8), 'DD/MM/YY').valueOf() <= moment(end.format('DD/MM/YY'), 'DD/MM/YY').valueOf()) {

                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                }

            });
        });
    </script>
@endsection