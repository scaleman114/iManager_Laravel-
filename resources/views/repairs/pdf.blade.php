@extends('repairs.pdflayout')

@section('content')
<div>
    <table class="table table-bordered">

        <thead class="thead-lightw">
            <tr>

                <th>Customer</th>
                <th colspan="2">Details</th>


            </tr>
        </thead>
        <tr>

            <td>


                {!! nl2br(e($address)) !!}
            </td>

            <td style="text-align:right;font-weight:bold;">

                Repair No:<br>
                Date:<br>
                Min. Charge:<br>
                Quoted:<br>
                Hours:
            </td>

            <td>

                {{ $repair->id }}<br>
                {{ date('d/m/y',strtotime($repair->date)) }}<br>
                {{ $repair->min_charge }}<br>
                {{ $repair->quoted }}<br>
                {{ $repair->hours }}
            </td>


        </tr>
        <tr>
            <td colspan="3">
                <h6>Description:</h6>
                <p>{{$repair->notes}}</p>
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




    @foreach($repairitems as $items)
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
                <em>Customer:</em>_______________________________________

            </td>



            <td style="vertical-align:bottom">

                <em>Engineer:</em>_______________________________________

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