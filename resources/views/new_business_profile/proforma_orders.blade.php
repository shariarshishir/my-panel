@extends('layouts.app_containerless')

@php
$searchInput = isset($_REQUEST['poSearchInput']) ? $_REQUEST['poSearchInput'] : '';
@endphp

@section('content')

<div class="account_profile_wrapper">
    <div class="account_profile_menu">
        <div class="container">
            <div class="profile_account_desktop_menu">
                @include('new_business_profile.profile_menu')
            </div>

            <div class="profile_account_mobile_menu" style="display: none;">
                <div class="row">
                    <div class="col s12">
                        <div class="profile_account_rightbar">
                            <a onclick="openProfileAccountNav()" href="javascript:void(0);" class="btn-product-sidenav">&nbsp;</a>
                        </div>
                    </div>
                    <div class="col s12">
                        <ul class="collapsible">
                            <li>
                                <div class="collapsible-header"><i class="material-icons">menu</i></div>
                                <div class="collapsible-body">
                                    @include('new_business_profile.profile_menu')
                                </div>
                            </li>
                            </ul>
                    </div>
                </div>

                <!-- <div id="profileAccountRight">
                    <a href="javascript:void(0)" class="closebtn" onclick="closeProfileAccountNav()"><i class="material-icons">clear</i></a>
                    test
                </div> -->
            </div>
        </div>
    </div>

    <div class="profile_account_innerinfo_wrap">
        <div class="container">
            <div class="account_profile_box">
                <div class="row">
                    <div class="col s12 m3 l2">
                        <div class="account_item_menu">
                            <ul>
                                <li class="profile_pos_pending {{ Route::is('new.profile.profoma_orders.pending', $alias) ? 'active' : ''}}">
                                    <a href="{{route('new.profile.profoma_orders.pending', $alias)}}">
                                        <div class="icon_img">&nbsp;</div>
                                        <h4>Pending</h4>
                                    </a>
                                </li>
                                <li class="profile_pos_ongoing {{ Route::is('new.profile.profoma_orders.ongoing', $alias) ? 'active' : ''}}">
                                    <a href="{{route('new.profile.profoma_orders.ongoing', $alias)}}">
                                        <div class="icon_img">&nbsp;</div>
                                        <h4>On Going</h4>
                                    </a>
                                </li>
                                <li class="profile_pos_shipped {{ Route::is('new.profile.profoma_orders.shipped', $alias) ? 'active' : ''}}">
                                    <a href="{{route('new.profile.profoma_orders.shipped', $alias)}}">
                                        <div class="icon_img">&nbsp;</div>
                                        <h4>Shipped</h4>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col s12 m9 l10">
                        <div class="profile_account_pos_info">
                            <div class="row">
                                <div class="col s12">
                                    <div class="product_design_wrapper">
                                        <div class="profile_account_searchBar">
                                            <div class="row">
                                                <div class="col s12">
                                                    <div class="profile_account_search">
                                                        <form action="{{ route('new.profile.profoma_orders.search', $alias) }}" method="GET">
                                                            @csrf
                                                            <i class="material-icons">search</i>
                                                            <input class="profile_filter_search typeahead" name="poSearchInput" type="text" placeholder="Search Merchant Bay Studio/Raw Material Libraries" value="{{$searchInput}}" />
                                                            <a href="javascript:void(0);" class="reset_po_filter" style="@php echo isset($_REQUEST['poSearchInput']) ? 'display: block;' : 'display: none;' @endphp"><i class="material-icons">restart_alt</i></a>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="profile_account_poinfo_innerbox">
                                            <div class="row poinfo_account_title_bar">
                                                <div class="col s8">
                                                    @if($status == 0)
                                                        <h4>Pending PIs</h4>
                                                    @elseif($status == 1)
                                                        <h4>Ongoing PIs</h4>
                                                    @elseif($status == 4)
                                                        <h4>All PIs</h4>
                                                    @else
                                                        <h4>Shipped PIs</h4>
                                                    @endif
                                                </div>
                                                <div class="col s4 right-align">
                                                    <span class="rfqView">{{count($proformas)}} results</span>
                                                </div>
                                            </div>
                                            <div class="po_block_wrapper">
                                                @foreach($proformas as $proforma)
                                                <div class="po_block {{($proforma->status == -1) ? 'rejected':'' }}" data-potitle="{{$proforma->proforma_id}}">
                                                    <div class="profile_account_poinfo_box">
                                                        <a href="#po_block_{{$proforma->id}}" class="po_overlay modal-trigger"></a>
                                                        <div class="row top_download_bar">
                                                            @if(($proforma->status == -1))
                                                            <a href="#po_reject_block_{{$proforma->id}}" class="reject_message_box modal-trigger" data-toggle="tooltip" title="Click here to see the cause of rejection"><i class="material-icons">message</i></a>
                                                            <span class="po_status_rejected">Rejected</span>
                                                            @endif
                                                            <div class="col s12 m10">
                                                                <h5>{{$proforma->proforma_id}}</h5>
                                                                <span class="poinfo">{{ date('d-m-Y', strtotime($proforma->created_at))}}</span>
                                                            </div>
                                                            <div class="col s12 m2">
                                                                <div class="download_icon">
                                                                    <a href="javascript:void(0);" data-toggle="tooltip" title="Click here to download"><img src="{{ Storage::disk('s3')->url('public/account-images/icon-download.png') }}" /></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            @php
                                                                $i = 0;
                                                                $proformaCount = count($proforma->performa_items);
                                                                foreach($proforma->performa_items as $item)
                                                                {
                                                            @endphp
                                                            <div class="col s6 m6 xl5">
                                                                <p>Quantity <br/> <b>{{$item->unit}}</b></p>
                                                                <p>Unit Price <br/> <b>{{$item->unit_price}} {{$item->price_unit}}</b></p>
                                                            </div>
                                                            <div class="col s12 m6 l2 proinfo_account_blank">&nbsp;</div>
                                                            <div class="col s6 m6 xl5">
                                                                <p>Shipping Date <br/> <b>{{$proforma->proforma_date}}</b></p>
                                                                <p>Total Price <br/> <b>{{$item->tax_total_price}}</b></p>
                                                            </div>
                                                            @if($proformaCount > 1)
                                                            <span class="moreItem">+ has more line item</span>
                                                            @endif
                                                            @php
                                                                if($i == 0) {
                                                                    break;
                                                                }
                                                                $i++;
                                                                }
                                                            @endphp

                                                        </div>

                                                        <div id="po_block_{{$proforma->id}}" class="po_block_modal modal modal-fixed-footer">
                                                            <div class="modal-content">
                                                                @include('new_business_profile.proforma_orders_modal')
                                                            </div>
                                                            <div class="modal-footer">
                                                                <a href="javascript:void(0);" class="modal-action modal-close waves-effect waves-green btn-flat">Close</a>
                                                            </div>
                                                        </div>

                                                        <div id="po_reject_block_{{$proforma->id}}" class="po_reject_block_modal modal modal-fixed-footer">
                                                            <div class="modal-content">
                                                                <legend>Cause of rejection</legend>
                                                                {{$proforma->reject_message}}
                                                            </div>
                                                            <div class="modal-footer">
                                                                <a href="javascript:void(0);" class="modal-action modal-close waves-effect waves-green btn-flat">Close</a>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div id="po_reject_modal" class="modal modal-fixed-footer">
                                                        <div class="modal-content">
                                                            <legend>Write your comment why this proforma "{{$proforma->proforma_id}}" is rejected</legend>
                                                            <form action="{{route('new.profile.profoma_orders.reject',['alias'=>$alias,'proformaId'=>$proforma->id])}}" method="POST">
                                                                @csrf
                                                                <div class="row">
                                                                    <div class="input-field col s12">
                                                                        <label for="reject_message_box">Message</label>
                                                                        <textarea id="reject_message_box" name="reject_message" class="materialize-textarea"></textarea>
                                                                    </div>
                                                                </div>
                                                                <button class="reject_message_submit waves-effect waves-light btn_green" type="submit">Submit</button>
                                                            </form>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <a href="javascript:void(0);" class="modal-action modal-close waves-effect waves-green btn-flat ">Close</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection

@push('js')
<script>
$(document).ready(function(){

    $(".reset_po_filter").click(function(){
        location.href = "{{route('new.profile.profoma_orders.pending', $alias)}}";
    });

    $(".po_reject_trigger").click(function(){
        $(".po_block_modal").modal("close");
        $(this).closest(".po_block").children("#po_reject_modal").modal("open");
    })

})

function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;

    window.print();
    document.body.innerHTML = originalContents;
}
</script>

<script>
    let proformaList = @json($proformas);
    console.log(proformaList);

    function intToEnglish(number)
    {
        var NS = [
            { value: 10000000, str: "Crore" },
            { value: 100000, str: "Lakh" },
            { value: 1000, str: "Thousand" },
            { value: 100, str: "Hundred" },
            { value: 90, str: "Ninety" },
            { value: 80, str: "Eighty" },
            { value: 70, str: "Seventy" },
            { value: 60, str: "Sixty" },
            { value: 50, str: "Fifty" },
            { value: 40, str: "Forty" },
            { value: 30, str: "Thirty" },
            { value: 20, str: "Twenty" },
            { value: 19, str: "Nineteen" },
            { value: 18, str: "Eighteen" },
            { value: 17, str: "Seventeen" },
            { value: 16, str: "Sixteen" },
            { value: 15, str: "Fifteen" },
            { value: 14, str: "Fourteen" },
            { value: 13, str: "Thirteen" },
            { value: 12, str: "Twelve" },
            { value: 11, str: "Eleven" },
            { value: 10, str: "Ten" },
            { value: 9, str: "Nine" },
            { value: 8, str: "Eight" },
            { value: 7, str: "Seven" },
            { value: 6, str: "Six" },
            { value: 5, str: "Five" },
            { value: 4, str: "Four" },
            { value: 3, str: "Three" },
            { value: 2, str: "Two" },
            { value: 1, str: "One" }
        ];
        var result = '';
        for (var n of NS) {
            if (number >= n.value) {
            if (number <= 99) {
                result += n.str;
                number -= n.value;
                if (number > 0) result += ' ';
            } else {
                var t = Math.floor(number / n.value);
                // console.log(t);
                var d = number % n.value;
                if (d > 0) {
                    return intToEnglish(t) + ' ' + n.str + ' ' + intToEnglish(d);
                } else {
                    return intToEnglish(t) + ' ' + n.str;
                }

            }
            }
        }
        return result;
    }

    function getNumber(abc)
    {
        numbers = []
        console.log(abc)
        numbers = String(abc).split(".")
        const res = intToEnglish(numbers[0])+ " Taka" + " And " + intToEnglish(numbers[1]) + " Poisa"
        return res
    }
    //console.log();
    proformaList.map(i=>{
        //console.log(i.id);
        document.getElementById("totalResultFront_"+i.id).innerHTML = getNumber(document.getElementById("proformaGrandTotal_"+i.id).innerHTML);
        document.getElementById("totalResultPdfFront_"+i.id).innerHTML = getNumber(document.getElementById("proformaGrandTotal_"+i.id).innerHTML);
    });
</script>
@endpush
