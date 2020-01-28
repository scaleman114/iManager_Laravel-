@extends('contracts.pdflayout')

@section('content')
<div>
    <table class="table table-bordered">

        <thead class="thead-lightw">
            <tr>

                <th>{{ \App\Enums\ContractType::getDescription($contract->contract_type) }} Contract Customer</th>
                <th colspan="2">Details</th>


            </tr>
        </thead>
        <tr>

            <td>


                {!! nl2br(e($address)) !!}
            </td>

            <td style="text-align:right;font-weight:bold;">

                Contract No:<br>
                Start Date:<br>
                Premium:<br>
                Terms:<br>
                Period:
                
            </td>

            <td>

                {{ $contract->contract_id }}<br>
                {{ date('d/m/y',strtotime($contract->contract_startdate)) }}<br>
                {{ $contract->contract_premium }}<br>
                {{ $contract->contract_terms }}<br>
                {{ $contract->contract_period }} months
               
            </td>


        </tr>
        <tr>
            <td colspan="3">
                <h6>Notes:</h6>
                <p>{{$contract->contract_notes}}</p>
            </td>
        </tr>




    </table>
</div>

<table class="table table-bordered">



    <thead class="thead-lightw">
        <tr>

            <th>Machine</th>
            <th>Serial No.</th>
            <th>Capacity</th>

        </tr>
    </thead>




    @foreach($contractitems as $items)
    <tr>

        <td>{{ $items->mc_type }}</td>
        <td>{{ $items->serial_no }}</td>
        <td>{{ $items->capacity }}</td>
    </tr>
    @endforeach

</table>

<div class="signaturestrip">
    <table>

        <tr>

            <td style="vertical-align:bottom">
                I/We accept Weigh-Till T & Cs (available on request)<br><br>
                <em>Customer:</em>________________________

            </td>




            <td style="vertical-align:bottom">

                <em>Date:</em>_____________________

            </td>








        </tr>

        <tr>
            <td colspan="2" style="vertical-align:bottom">

                <p style="font-size:50%;"><br><br>
                    In the case of an electrical product repair we cannot guarantee that other faults
                    will not develop within the 3 month warranty period. Electrical appliances are instruments
                    containing many components and within the repair the parts specified have been replaced.
                    The breakdown of other parts may cause a fault similar to the fault prior to the repair.</p>

            </td>

        </tr>

    </table>
</div>

@endsection